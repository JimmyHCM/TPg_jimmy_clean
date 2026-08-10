<?php
/**
 * Shared <head> partial.
 * Set these before including (all optional):
 *   $pageTitle  — browser title (string)
 *   $bodyClass  — class applied to <body> (e.g. 'tpg-auth-body')
 *   $bodyId     — id applied to <body>
 *   $bodyAttrs  — extra raw attributes for <body> (e.g. 'onload="noBack();"')
 */
$pageTitle = isset($pageTitle) ? $pageTitle : 'TPg Admission';
$bodyClass = isset($bodyClass) ? $bodyClass : '';
$bodyId    = isset($bodyId) ? $bodyId : '';
$bodyAttrs = isset($bodyAttrs) ? $bodyAttrs : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $pageTitle; ?> — HKU Faculty of Engineering</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0E6B4E">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- TPg fresh theme layer (must load after app.min.css) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-theme.css" rel="stylesheet" type="text/css" />
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=7" rel="stylesheet" type="text/css" />
</head>

<body<?php echo $bodyId ? ' id="'.$bodyId.'"' : ''; ?><?php echo $bodyClass ? ' class="'.$bodyClass.'"' : ''; ?><?php echo $bodyAttrs ? ' '.$bodyAttrs : ''; ?>>
