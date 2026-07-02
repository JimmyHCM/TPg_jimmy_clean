<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - upload payment slip</title>
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
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=3" rel="stylesheet" type="text/css" />


  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
    }
  </script>
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

    <!-- Start Page Content here -->
    <div class="content-page">

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <button class="button-menu-mobile open-left disable-btn">
          <i class="mdi mdi-menu"></i>
        </button>
      </div>
      
      <div class="content">

        <div class="container-fluid">

          <?php $hasError = false; ?>
          <div class="row m-2">
            <div class="col-12">
              <?php if (isset($_SESSION['info'])) {?>
                <?php $hasError = true; ?>
                <div class="alert alert-warning"> <?php echo $_SESSION['info']; ?></div>
              <?php }?>

              <?php if (isset($_SESSION['error'])) {?>
                <?php $hasError = true; ?>
                <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
              <?php }?>
            </div>
          </div>

          <?php if (!$hasError && !$replied) { ?>
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title text-primary">Upload payment slip</h4>
                <p class="lead">Please upload additional payment slip (if any) here.</p>
              </div>
            </div>
          </div>     
          <!-- end page title --> 

          <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
            <h4 class="text-primary">Screen too small for file upload, please use a device with larger screen size.</h4>
          </div>

          <div class="row d-none d-md-block"><!-- visible md and up -->
            <div class="row justify-content-center">
              <div class="col-lg-1">
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="card shadow-sm" style="background-color: white;">
                  <!-- Logo -->
                  <div class="card-header pt-4 pb-4 text-center bg-primary">
                    <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
                  </div>
                  <div class="card-body p-4">

                    <!-- form -->
                    <form id="RSform" action="<?php echo base_url(); ?>status/uploadPS" method="POST" enctype="multipart/form-data">
                    <p>Please enter the information below and upload any additional payment slip.</p>

                    <div id="uploadPslip" class="form-group alert alert-info" role="alert"> <!-- file upload -->
                      <label>Payment slip (.jpg, .jpeg, .png accepted) at least 1MB, max 2MB</label>
                      <input name="paymentSlip" id="paymentSlip" type="file" accept=".jpg,.jpeg,.png" required/>
                    </div> <!-- end file upload -->

                    <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control" id="replyDate" name="replyDate" disabled value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input class="form-control" type="email" name="email" required="yes" id="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-0 text-center">
                      <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Upload payment slip"></input>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-1">
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
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

  </div><!-- END wrapper --> 

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=3"></script>

</body>
</html>
