<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TPg CAPTCHA helper.
 *
 * Overrides CodeIgniter's create_captcha() (system/helpers/captcha_helper.php
 * is left untouched — CI loads MY_* first and the core copy is guarded by
 * function_exists()).
 *
 * Two things the stock renderer got wrong for us:
 *
 *   1. It leaned on low text/background contrast for its difficulty. That is
 *      backwards — any OCR pipeline normalises contrast in one pass, while a
 *      washed-out image is a real barrier for human readers. Here the palette
 *      is gentle *and* on-theme, and the difficulty comes from geometry:
 *      per-character rotation, size and baseline jitter, touching glyphs, a
 *      sinusoidal warp of the whole canvas, and confusion curves drawn in the
 *      same ink as the text so they cannot be colour-filtered away.
 *
 *   2. It wrote every image into a public folder under a predictable
 *      microtime() name and left it there for two hours. 'inline' => TRUE
 *      renders to a data: URI instead, so the image never touches disk.
 *
 * Extra config keys over the CI original:
 *   inline       bool   TRUE = data: URI, nothing written to disk
 *   supersample  int    render at Nx then downscale (antialiasing)
 *   warp         int    wave amplitude in final-image pixels, 0 = off
 *   char_angle   int    max per-character rotation, degrees
 *   noise        float  speckle / hairline density multiplier
 *   img_alt      string alt text for the <img>
 */

if ( ! function_exists('_tpg_captcha_color'))
{
	/**
	 * Allocate an RGB triplet, optionally jittered by +/- $spread per channel.
	 */
	function _tpg_captcha_color($im, array $rgb, $spread = 0)
	{
		$out = array();
		for ($i = 0; $i < 3; $i++)
		{
			$v = (int) $rgb[$i] + ($spread > 0 ? mt_rand(-$spread, $spread) : 0);
			$out[$i] = max(0, min(255, $v));
		}

		return imagecolorallocate($im, $out[0], $out[1], $out[2]);
	}
}

if ( ! function_exists('_tpg_captcha_mix'))
{
	/**
	 * Linear blend of two RGB triplets; $t = 0 gives $a, $t = 1 gives $b.
	 */
	function _tpg_captcha_mix(array $a, array $b, $t)
	{
		return array(
			(int) round($a[0] + ($b[0] - $a[0]) * $t),
			(int) round($a[1] + ($b[1] - $a[1]) * $t),
			(int) round($a[2] + ($b[2] - $a[2]) * $t)
		);
	}
}

if ( ! function_exists('_tpg_captcha_warp'))
{
	/**
	 * Sinusoidal warp. Every column slides vertically and every row slides
	 * horizontally, so the baseline is never straight and a segmentation pass
	 * has no stable geometry to lock onto. Destroys $src and returns a new
	 * image resource.
	 */
	function _tpg_captcha_warp($src, $w, $h, array $bg_rgb, $amp)
	{
		$amp = max(1, (int) $amp);

		$mid = imagecreatetruecolor($w, $h);
		imagefilledrectangle($mid, 0, 0, $w, $h, _tpg_captcha_color($mid, $bg_rgb));

		$lambda = mt_rand((int) ($w / 2.2), (int) ($w / 1.1));
		$phase  = mt_rand(0, 628) / 100;
		for ($x = 0; $x < $w; $x++)
		{
			$dy = (int) round($amp * sin((2 * M_PI * $x / $lambda) + $phase));
			imagecopy($mid, $src, $x, max(0, $dy), $x, max(0, -$dy), 1, $h - abs($dy));
		}
		imagedestroy($src);

		$out = imagecreatetruecolor($w, $h);
		imagefilledrectangle($out, 0, 0, $w, $h, _tpg_captcha_color($out, $bg_rgb));

		$amp_x  = max(1, (int) round($amp * 0.6));
		$lambda = mt_rand((int) ($h * 1.2), (int) ($h * 2.8));
		$phase  = mt_rand(0, 628) / 100;
		for ($y = 0; $y < $h; $y++)
		{
			$dx = (int) round($amp_x * sin((2 * M_PI * $y / $lambda) + $phase));
			imagecopy($out, $mid, max(0, $dx), $y, max(0, -$dx), $y, $w - abs($dx), 1);
		}
		imagedestroy($mid);

		return $out;
	}
}

if ( ! function_exists('create_captcha'))
{
	/**
	 * Create CAPTCHA
	 *
	 * Same signature and return shape as the CI original:
	 * array('word' => ..., 'time' => ..., 'image' => ..., 'filename' => ...)
	 * or FALSE on failure.
	 *
	 * @param	array	$data		Data for the CAPTCHA
	 * @param	string	$img_path	Path to create the image in (deprecated)
	 * @param	string	$img_url	URL to the CAPTCHA image folder (deprecated)
	 * @param	string	$font_path	Server path to font (deprecated)
	 * @return	array|bool
	 */
	function create_captcha($data = '', $img_path = '', $img_url = '', $font_path = '')
	{
		$defaults = array(
			'word'		=> '',
			'img_path'	=> '',
			'img_url'	=> '',
			'img_width'	=> 360,
			'img_height'	=> 96,
			'font_path'	=> '',
			'expiration'	=> 7200,
			'word_length'	=> 8,
			'font_size'	=> 40,
			'img_id'	=> '',
			'img_alt'	=> 'CAPTCHA image code',
			'inline'	=> FALSE,
			'supersample'	=> 2,
			'warp'		=> 5,
			'char_angle'	=> 22,
			'noise'		=> 1,
			'pool'		=> '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',
			'colors'	=> array(
				'background'	=> array(244, 246, 245),
				'border'	=> array(233, 236, 234),
				'text'		=> array(122, 146, 132),
				'grid'		=> array(216, 198, 152)
			)
		);

		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($data) && empty($$key))
			{
				$$key = $val;
			}
			else
			{
				$$key = isset($data[$key]) ? $data[$key] : $val;
			}
		}

		// This renderer needs FreeType: the rotation and per-glyph metrics are
		// the whole point, so fail closed rather than fall back to the flat,
		// trivially-segmented imagestring() output the core helper used.
		if ( ! extension_loaded('gd') OR ! function_exists('imagettftext')
			OR ! function_exists('imagecreatetruecolor')
			OR $font_path === '' OR ! is_file($font_path))
		{
			log_message('error', 'create_captcha: GD/FreeType or the font file is unavailable');
			return FALSE;
		}

		if ($inline === FALSE && ($img_path === '' OR $img_url === ''
			OR ! is_dir($img_path) OR ! is_really_writable($img_path)))
		{
			return FALSE;
		}

		$now = microtime(TRUE);

		// -----------------------------------
		// Remove old images
		// -----------------------------------
		// Keyed off mtime rather than the filename, so the folder still drains
		// correctly once nothing new is being written into it.

		if ($img_path !== '' && is_dir($img_path) && ($dir = @opendir($img_path)) !== FALSE)
		{
			while (($filename = @readdir($dir)) !== FALSE)
			{
				if (in_array(strtolower(substr($filename, -4)), array('.jpg', '.png'), TRUE)
					&& (@filemtime($img_path.$filename) + $expiration) < $now)
				{
					@unlink($img_path.$filename);
				}
			}

			@closedir($dir);
		}

		// -----------------------------------
		// Do we have a "word" yet?
		// -----------------------------------

		if (empty($word))
		{
			$word = '';
			$rand_max = strlen($pool) - 1;

			for ($i = 0; $i < $word_length; $i++)
			{
				if (function_exists('random_int'))
				{
					try
					{
						$word .= $pool[random_int(0, $rand_max)];
						continue;
					}
					catch (Exception $e)
					{
						// no CSPRNG available - fall through
					}
				}

				$word .= $pool[mt_rand(0, $rand_max)];
			}
		}

		$word	= (string) $word;
		$length	= strlen($word);

		// -----------------------------------
		//  Assign colors
		// -----------------------------------

		is_array($colors) OR $colors = $defaults['colors'];

		foreach ($defaults['colors'] as $key => $val)
		{
			if ( ! isset($colors[$key]) OR ! is_array($colors[$key]))
			{
				$colors[$key] = $val;
			}
		}

		// -----------------------------------
		//  Canvas (rendered oversized, downsampled at the end)
		// -----------------------------------

		$ss = max(1, (int) $supersample);
		$w  = (int) $img_width  * $ss;
		$h  = (int) $img_height * $ss;

		$im = imagecreatetruecolor($w, $h);
		function_exists('imageantialias') && @imageantialias($im, TRUE);
		imagefilledrectangle($im, 0, 0, $w, $h, _tpg_captcha_color($im, $colors['background']));

		// -----------------------------------
		//  Background texture
		// -----------------------------------
		// Soft blotches plus gold hairlines, in place of the core helper's
		// single hard spiral. All of it sits close to the background tone, so
		// it reads as paper grain to a person but still breaks up the flat
		// field a thresholding pass wants to find.

		for ($i = 0, $n = (int) round(6 * $noise); $i < $n; $i++)
		{
			$c = _tpg_captcha_color($im, _tpg_captcha_mix($colors['background'], $colors['grid'], mt_rand(10, 28) / 100), 3);
			imagefilledellipse($im, mt_rand(0, $w), mt_rand(0, $h), mt_rand((int) ($w / 6), (int) ($w / 2)), mt_rand((int) ($h / 3), $h), $c);
		}

		imagesetthickness($im, max(1, (int) round($ss * 0.8)));
		for ($i = 0, $n = (int) round(5 * $noise); $i < $n; $i++)
		{
			$c = _tpg_captcha_color($im, $colors['grid'], 10);
			imagearc($im, mt_rand(0, $w), mt_rand(0, $h), mt_rand((int) ($w / 3), $w), mt_rand((int) ($h / 2), $h * 2), mt_rand(0, 360), mt_rand(120, 360), $c);
		}
		imagesetthickness($im, 1);

		for ($i = 0, $n = (int) round((($w * $h) / 380) * $noise); $i < $n; $i++)
		{
			$c = _tpg_captcha_color($im, _tpg_captcha_mix($colors['background'], $colors['text'], mt_rand(15, 55) / 100), 6);
			imagefilledellipse($im, mt_rand(0, $w), mt_rand(0, $h), $ss, $ss, $c);
		}

		// -----------------------------------
		//  Measure the glyph run
		// -----------------------------------
		// Every character gets its own size, angle and advance. Advances are
		// allowed to fall slightly under the glyph width so neighbours touch -
		// that is what defeats per-character segmentation.

		$max_size = (int) round($h * 0.62);
		$sizes = $angles = $advances = array();
		$total = 0;

		for ($i = 0; $i < $length; $i++)
		{
			$sizes[$i]  = min($max_size, (int) round($font_size * $ss * mt_rand(86, 106) / 100));
			$angles[$i] = mt_rand(-abs((int) $char_angle), abs((int) $char_angle));

			$bbox = imagettfbbox($sizes[$i], $angles[$i], $font_path, $word[$i]);
			$cw   = max($bbox[0], $bbox[2], $bbox[4], $bbox[6]) - min($bbox[0], $bbox[2], $bbox[4], $bbox[6]);

			$advances[$i] = max($cw, (int) round($sizes[$i] * 0.5)) + (mt_rand(-3, 4) * $ss);
			$total += $advances[$i];
		}

		// Fit the run to the canvas. The core helper used a fixed advance and a
		// random start offset, which could push the last character off the
		// right-hand edge; this centres a run that always fits.
		if ($total > 0)
		{
			$scale = min(1.6, max(0.55, ($w * 0.86) / $total));

			if (abs($scale - 1) > 0.03)
			{
				$total = 0;

				for ($i = 0; $i < $length; $i++)
				{
					$sizes[$i] = min($max_size, max(8, (int) round($sizes[$i] * $scale)));

					$bbox = imagettfbbox($sizes[$i], $angles[$i], $font_path, $word[$i]);
					$cw   = max($bbox[0], $bbox[2], $bbox[4], $bbox[6]) - min($bbox[0], $bbox[2], $bbox[4], $bbox[6]);

					$advances[$i] = max($cw, (int) round($sizes[$i] * 0.5)) + (mt_rand(-3, 4) * $ss);
					$total += $advances[$i];
				}
			}
		}

		// -----------------------------------
		//  Write the text
		// -----------------------------------

		$x       = (int) max($ss * 4, ($w - $total) / 2);
		$mid_y   = (int) ($h * 0.5);
		$jitter  = (int) ($h * 0.07);

		for ($i = 0; $i < $length; $i++)
		{
			$y = $mid_y + (int) round($sizes[$i] * 0.36) + mt_rand(-$jitter, $jitter);
			$c = _tpg_captcha_color($im, $colors['text'], 14);

			imagettftext($im, $sizes[$i], $angles[$i], $x, $y, $c, $font_path, $word[$i]);
			$x += $advances[$i];
		}

		// -----------------------------------
		//  Confusion curves
		// -----------------------------------
		// Drawn in the text ink, after the glyphs, so they cannot be separated
		// out by colour - the classic cheap win against automated readers.

		imagesetthickness($im, max(1, (int) round($ss * 1.2)));
		for ($n = 0; $n < 2; $n++)
		{
			$c      = _tpg_captcha_color($im, $colors['text'], 10);
			$amp    = mt_rand((int) ($h * 0.10), (int) ($h * 0.22));
			$lambda = mt_rand((int) ($w / 1.6), $w * 2);
			$phase  = mt_rand(0, 628) / 100;
			$base   = mt_rand((int) ($h * 0.32), (int) ($h * 0.58));   // keep it inside the glyph band
			$prev_y = NULL;

			for ($px = 0; $px <= $w; $px += $ss)
			{
				$py = (int) round($base + $amp * sin((2 * M_PI * $px / $lambda) + $phase));

				if ($prev_y !== NULL)
				{
					imageline($im, $px - $ss, $prev_y, $px, $py, $c);
				}

				$prev_y = $py;
			}
		}
		imagesetthickness($im, 1);

		// -----------------------------------
		//  Warp, downsample, border
		// -----------------------------------

		if ($warp > 0)
		{
			$im = _tpg_captcha_warp($im, $w, $h, $colors['background'], (int) round($warp * $ss));
		}

		$out = imagecreatetruecolor((int) $img_width, (int) $img_height);
		imagefilledrectangle($out, 0, 0, (int) $img_width, (int) $img_height, _tpg_captcha_color($out, $colors['background']));
		imagecopyresampled($out, $im, 0, 0, 0, 0, (int) $img_width, (int) $img_height, $w, $h);
		imagedestroy($im);

		imagerectangle($out, 0, 0, (int) $img_width - 1, (int) $img_height - 1, _tpg_captcha_color($out, $colors['border']));

		// -----------------------------------
		//  Generate the image
		// -----------------------------------

		$attr = (($img_id === '') ? '' : ' id="'.$img_id.'"')
			.' width="'.(int) $img_width.'" height="'.(int) $img_height.'"'
			.' alt="'.htmlspecialchars($img_alt, ENT_QUOTES, 'UTF-8').'"';

		if ( ! function_exists('imagepng'))
		{
			imagedestroy($out);
			return FALSE;
		}

		// Inline: the image is never written to a public path, so there is no
		// predictable URL to fetch and nothing left behind to harvest.
		if ( ! empty($inline))
		{
			ob_start();
			imagepng($out, NULL, 9);
			$binary = ob_get_clean();
			imagedestroy($out);

			if ($binary === FALSE OR $binary === '')
			{
				return FALSE;
			}

			return array(
				'word'		=> $word,
				'time'		=> $now,
				'image'		=> '<img'.$attr.' draggable="false" src="data:image/png;base64,'.base64_encode($binary).'" />',
				'filename'	=> ''
			);
		}

		$img_filename = $now.'.png';
		imagepng($out, rtrim($img_path, '/').'/'.$img_filename, 9);
		imagedestroy($out);

		return array(
			'word'		=> $word,
			'time'		=> $now,
			'image'		=> '<img'.$attr.' src="'.rtrim($img_url, '/').'/'.$img_filename.'" />',
			'filename'	=> $img_filename
		);
	}
}
