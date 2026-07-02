<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- jQuery library -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
	
  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- Dell 1996 redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/dell-1996.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
    #frontdisplay {
    background: url("<?php echo base_url(); ?>assets/images/tpgbg.png") no-repeat fixed;
    background-position: center;
    background-size: cover;
    }
  </style>
  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
    }
  </script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="" id="frontdisplay">
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

                <h4 class="text-dark-50 text-center mt-0 mb-4 font-weight-bold">Security Check</h4>
              </div>

              <form method="post" action="<?php echo base_url().'captcha/captchaSubmit'; ?>">

                <div class="form-group">
                  <p id="captImg"><center><?php if (isset($captchaImg)) echo $captchaImg; ?></center></p>
        				  <p>Can't read the image [CAPITALS and digits]? click <a href="<?php echo base_url().'captcha'; ?>">here</a> to refresh.</p>

                <?php if (isset($_SESSION['info'])) {?>
                  <div class="alert alert-info"> <?php echo $_SESSION['info']; ?></div>
                  <?php 
                }?>

                  <div class="row">
                    <div class="col-12">
                      <input class="form-control" width="100%" type="text" required="yes" id="captcha" name="captcha" value ="" minlength="8" maxlength="8" autofocus="autofocus" placeholder="Enter the image code (expired in 3 minutes)">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="input-group-prepend">
                        <div id="otpCodePrefix" class="input-group-text"><?php echo $_SESSION['otpCodePrefix']; ?>
                        </div>
                        <input class="form-control" width="100%" type="tel" required="yes" id="otpCode" name="otpCode" minlength="6" maxlength="6" value ="" placeholder="6 digits OTP code (expired in 3 mins)">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-primary" name="submit" value="submit" type="submit"> Submit </button>
                </div>

              </form>
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
