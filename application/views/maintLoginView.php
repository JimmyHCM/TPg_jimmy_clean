<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - maintenance page</title>
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

<body>
  <div class="account-pages mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card">

            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-primary">
              <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
            </div>

            <div class="card-body p-4">

              <div class="text-center w-75 m-auto">

                <?php if (isset($_SESSION['error'])) {?>
                  <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
                  <?php 
                }?>

                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign In</h4>
                <p class="text-muted mb-4">For maintenance only</p>
              </div>

              <?php echo form_open ('maintenance/login'); ?>

                <div class="form-group">
                  <label for="username">Username</label>
                  <input class="form-control" type="text" required="yes" name="username" id="username" autofocus="autofocus" placeholder="Enter your username">
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input class="form-control" type="password" name="password" id="password" required="yes" placeholder="Enter your password">
                </div>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-primary" type="submit"> Log In </button>
                </div>

              <?php echo form_close(); ?>
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
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=2"></script>
</body>
</html>
