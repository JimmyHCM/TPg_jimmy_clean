<?php

class CodeModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();
  }

  function createCaptcha ()
  {
    ini_set('display_errors', 0);     // do not display errors
    // Captcha configuration - palette follows the TPg premium theme
    // (sage ink on the --tp-ash surface, soft gold grain).
    //
    // The contrast here is deliberately gentle, around 3:1 against the
    // background. Difficulty is NOT meant to come from washing the text out -
    // OCR normalises contrast in one pass, so that only ever penalises human
    // readers. It comes from the geometry instead: per-character rotation,
    // size and baseline jitter, touching glyphs, a sinusoidal warp and
    // confusion curves drawn in the same ink as the text.
    // See application/helpers/MY_captcha_helper.php.
    $config = array(
      // legacy folder - kept only so any images left over from the old
      // on-disk renderer get swept up; nothing new is written there
      'img_path'      => 'captchaImages/',
      'img_url'       => base_url().'captchaImages/',
      'inline'        => TRUE,          // render as a data: URI, never to disk
      'font_path'     => 'system/fonts/texb.ttf',
      'img_width'     => 360,
      'img_height'    => 96,
      'word_length'   => 8,
      'font_size'     => 40,
      'char_angle'    => 22,            // max per-character rotation
      'warp'          => 5,             // wave amplitude, final-image pixels
      'noise'         => 1,
      'img_alt'       => 'Security image showing 8 capital letters and digits',
      // no 0/O/1/I/L - characters a person could reasonably misread
      'pool'          => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',
      'colors'        => array(
        'background' => array(244, 246, 245),   // --tp-ash
        'border'     => array(233, 236, 234),   // --tp-cloud
        'text'       => array(122, 146, 132),   // muted sage, ~3.0:1 on the ash
        'grid'       => array(216, 198, 152),   // --tp-gold softened, decorative only
      )
    );
    $captcha = create_captcha($config);

    return $captcha;
  }
}

?>
