<?php

class CodeModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();
  }

  function createCaptcha ()
  {
    ini_set('display_errors', 0);     // do not display errors
    // Captcha configuration
    $config = array(
      'img_path'      => 'captchaImages/',
      'img_url'       => base_url().'captchaImages/',
      'font_path'     => 'system/fonts/texb.ttf',
      'img_width'     => 260,
      'img_height'    => 80,
      'word_length'   => 8,
      'font_size'     => 25,
      'pool'    => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',
      'colors'        => array(
                        //'background' => array(219, 255, 193),
        'background' => array(189, 182, 152),
                        'border' => array(123, 119, 104),
                        'text' => array(123, 119, 104),
                        'grid' => array(123, 119, 104),
                        )
    );
    $captcha = create_captcha($config);

    return $captcha;
  }
}

?>