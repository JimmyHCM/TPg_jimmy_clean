<?php

class CodeModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();
  }

  function createCaptcha ()
  {
    ini_set('display_errors', 0);     // do not display errors
    // Captcha configuration — palette follows the TPg premium theme
    // (emerald ink on a near-white surface, faint gold grid), larger canvas
    // so the glyphs render crisply inside the auth card.
    $config = array(
      'img_path'      => 'captchaImages/',
      'img_url'       => base_url().'captchaImages/',
      'font_path'     => 'system/fonts/texb.ttf',
      'img_width'     => 360,
      'img_height'    => 96,
      'word_length'   => 8,
      'font_size'     => 38,
      'pool'    => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',
      'colors'        => array(
        'background' => array(244, 246, 245),   // --tp-ash
        'border' => array(233, 236, 234),       // --tp-cloud
        'text' => array(10, 46, 30),            // --tp-deep
        'grid' => array(201, 162, 75),          // --tp-gold
      )
    );
    $captcha = create_captcha($config);

    return $captcha;
  }
}

?>