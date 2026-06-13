<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system</title>
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
          <div class="card">

            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-primary">
              <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
            </div>

            <div class="card-body p-4">

              <div class="text-center w-80 m-auto">

                <?php if (isset($_SESSION['error'])) {?>
                  <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
                  <?php 
                }?>

                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign In</h4>
                <p class="text-muted mb-4">Enter your application number and email address.<br/>(<?php echo $currentTime; ?>)</p>
                <p>For security reason, once you have signed in, the system will not keep your email address. You might need to enter again at a later stage.</p>
              </div>

              <?php echo form_open ('auth/login'); ?>

                <div class="form-group">
                  <label for="appNo">Application number</label>
                  <input class="form-control" type="tel" required="yes" name="appNo" id="appNo" autofocus="autofocus" minlength="10" maxlength="10" placeholder="Enter your application number">
                </div>

                <div class="form-group">
                  <label for="email">Email address</label>
                  <input class="form-control" type="text" name="email" id="email" required="yes" placeholder="Enter your email">
                </div>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-primary" type="submit"> Log In </button>
                </div>

              <?php echo form_close(); ?>

              <div class="text-center w-80 m-auto">
			          <br/><br/>
				        <p class="text-muted mb-4">Daily maintenance<br/>2:00-4:59 UTC+8, 14:00-14:59 UTC+8</p>
                
                <!--
                <br/><br/>
                <p class="text-info mb-4">Special maintenance<br/>12:00 30 Nov (UTC+8) to 22:00 1 Dec (UTC+8)</p>
              -->
              
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
</body>
</html>
