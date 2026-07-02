<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - front page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=2" rel="stylesheet" type="text/css" />


</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <a name="top"></a>

  <!-- Begin page -->
  <div class="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

      <div class="slimscroll-menu">

        <!-- LOGO -->
	     	<a href="https://engg.hku.hk/" class="logo text-center">
          <span class="logo-lg">
            <img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="40">
          </span>
		    </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

          <li class="side-nav-title side-nav-item">Navigation</li>

          <?php if (strpos ($menu, 'D') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/upload" class="side-nav-link">
                <i class="mdi mdi-note-multiple"></i>
                <span> Documents</span>
                <span class="menu-arrow"></span>
              </a>
              <ul class="side-nav-second-level" aria-expanded="false">
                <li>
                  <a href="<?php echo base_url(); ?>display/upload"><i class="mdi mdi-playlist-check"></i>upload documents</a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>display/summary">my upload summary</a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'R') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/reply" class="side-nav-link">
                <i class="mdi mdi-message-text-outline"></i>
                <span> Submit reply slip </span>
              </a>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'P') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/payment" class="side-nav-link">
                <i class="mdi mdi-square-inc-cash"></i>
                <span> Upload payment slip </span>
              </a>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'S') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/checkStatus" class="side-nav-link">
                <i class="mdi mdi-signal"></i>
                <span> Check status </span>
              </a>
            </li>
          <?php } ?>
          
          <!-- chat message -->
          <!-- 
          <?php if (strpos ($menu, 'C') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/checkMessage" class="side-nav-link">
                <i class="mdi mdi-email-outline"></i>
                <span> Check message </span>
              </a>
            </li>
          <?php } ?>
        -->

          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>auth/logout" class="side-nav-link">
              <i class="mdi mdi-logout"></i>
              <span> Logout </span>
            </a>
          </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

      <!-- Start Content-->
      <div class="content">
        
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title text-primary">TPG admission</h4>
                <p class="lead">Thank you for your interest to study in the Faculty of Engineering, HKU.</p>
                <p class="lead">The processing time of your application depends on the complexity of your application and on the need for further information. This web will guide you to prepare all supporting documents in the proper format. It is ok to break down the upload into a few rounds.</p>

                <p class="text-muted mb-4">Please note, for security reason, the system will not store your email address once you have signed in. Therefore you might be requested to enter your email address again for security check when needed.</p>

                <div class="alert alert-info" role="alert">
                  <i class="dripicons-warning"></i> <strong>About file upload</strong>:
                  <ul>
                    <li>You have 30 minutes for each upload section. Please login again if the page expired.</li>
                    <li>Each <strong>Choose File</strong> only allows the selection of one file for upload.</li>
                    <li>You can always replace an uploaded file by uploading another file to the same item a second time. The previous uploaded document will be automatically replaced by the new one.</li>
                    <li>Do the upload at your own pace. It is ok to upload file by file, or section by section, or login at another day to do further uploads.</li>
                    <li>Documents which are not in English should be accompanied by a formally certified translation in English. If the original document has English translation side-by-side, there is no need to prepare a separate translation copy.</li>
                    <li>jpg / jpeg / png 
                      <ul>
                        <li>supported for most of the documents</li>
                        <li>dimension must be at least: 1240 x 1754 pixels</li>
                        <li>max size: 2MB</li>
                      </ul>
                    </li>
                    <li>pdf
                      <ul>
                        <li>only for document consists of more than 1 page</li>
                        <li>max size: 3MB</li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>     
          <!-- end page title --> 

        </div> <!-- container -->
      </div> <!-- content -->

      <!-- Footer Start -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <?php echo $currentYear; ?> © faculty of engineering, HKU
            </div>
            <div class="col-md-6">
              <div class="text-md-right footer-links d-none d-md-block">
                <a href="#top"><i class="mdi mdi-chevron-double-up h3"></i></a>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- end Footer -->

    </div>
  </div>
  <!-- END wrapper -->

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=2"></script>

</body>
</html>
