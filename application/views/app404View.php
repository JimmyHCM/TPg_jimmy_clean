<?php 
  defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 
<?php
  $ci = new CI_Controller();
  $ci =& get_instance();
  $ci->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - 404</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
    #frontdisplay {
    background: url("<?php echo base_url(); ?>assets/images/tpgbg.png") no-repeat fixed;
    background-position: center;
    background-size: cover;
    }
  </style>
</head>

<body id="frontdisplay">

  <div class="account-pages mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card shadow-sm">

            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-primary">
              <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
            </div>

            <div class="card-body p-4">

              <div class="text-center w-75 m-auto">
                <h1 class="text-error mt-4">404</h1>
                <h4 class="text-uppercase text-danger mt-3">Page Not Found</h4>
                <p class="text-muted mt-3">Looks like you may have taken a wrong turn. Don't worry... it happens to the best of us.</p>
              </div>

            </div> <!-- end card-body -->
          </div>
          <!-- end card -->

        </div> <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end page -->

  <footer class="footer footer-alt">
    <script>
      var CurrentYear = new Date().getFullYear()
      document.write(CurrentYear)
    </script>
     © faculty of engineering, HKU
  </footer>


  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
