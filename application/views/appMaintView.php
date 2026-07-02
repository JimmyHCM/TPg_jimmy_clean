<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - maintenance</title>
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
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css" rel="stylesheet" type="text/css" />


  <style type="text/css">
    body {
    background: url("<?php echo base_url(); ?>assets/images/tpgbg.png") no-repeat fixed;
    background-position: center;
    background-size: cover;
    }
  </style>
</head>

<body>

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
                <h4 class="text-uppercase text-danger mt-3">under maintenance</h4>

                <!--
                <br/><br/>
                <p class="text-info mb-4">Special maintenance<br/>12:00 30 Nov (UTC+8) to 22:00 1 Dec (UTC+8)</p>
              -->
              <!--
                <br/><br/>
                <p class="text-info mb-4">Temporary maintenance<br/>system will be available very soon 11:00 16 Mar (UTC+8)</p>
              -->

                <p class="text-muted mt-3">daily system down time for maintenance or update</p>
                <p class="text-muted mt-3">
                2:00-2:59 UTC+8<br/>14:00-14:59 UTC+8</p>
                
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
    <?php echo $currentYear; ?> © faculty of engineering, HKU
  </footer>


  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js"></script>
</body>
</html>
