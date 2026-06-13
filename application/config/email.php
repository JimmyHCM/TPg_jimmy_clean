<?php
$config['useragent'] = 'HKU Engineering TPG Admission';
$config['mailer'] = 'HKU Engineering TPG Admission';
$config['protocol'] = 'smtp';
//$config['protocol'] = 'sendmail';
//$config['mailpath'] = '/usr/sbin/sendmail';

/*
// with user auth.
$config['smtp_host'] = 'smtproam.hku.hk';
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'YOUR_SMTP_USER';
$config['smtp_pass'] = 'YOUR_SMTP_PASSWORD';
$config['smtp_port'] = 587;
*/

// without auth.
$config['smtp_host'] = 'mail.hku.hk';
$config['smtp_port'] = 25;

$config['smtp_timeout'] = 50;
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;

?>