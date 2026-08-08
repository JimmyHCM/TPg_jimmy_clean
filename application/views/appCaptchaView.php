<?php
$pageTitle = 'Security Check';
$bodyClass = 'tpg-auth-body';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
?>
<script type="text/javascript">
  window.history.forward();
  function noBack() {
    window.history.forward();
  }
</script>

  <div class="account-pages pt-5 pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card tpg-auth-card">

            <?php include(APPPATH.'views/partials/auth_brand.php'); ?>

            <div class="card-body p-4 p-md-5">

              <div class="text-center mb-4">
                <h4 class="tpg-auth-title mt-0">Security Check</h4>
                <p class="tpg-auth-sub mb-0">One more step to confirm it's really you</p>
              </div>

              <?php if (isset($_SESSION['info'])) { ?>
                <div class="alert alert-info"><?php echo $_SESSION['info']; ?></div>
              <?php } ?>

              <form method="post" action="<?php echo base_url().'captcha/captchaSubmit'; ?>">

                <div class="tp-captcha-img" id="captImg"><?php if (isset($captchaImg)) echo $captchaImg; ?></div>
                <span class="tp-captcha-refresh">
                  Can't read the image [CAPITALS and digits]?
                  Click <a href="<?php echo base_url().'captcha'; ?>">here</a> to refresh.
                </span>

                <div class="form-group">
                  <label for="captcha">Image code</label>
                  <input class="form-control" type="text" required="yes" id="captcha" name="captcha" value=""
                         minlength="8" maxlength="8" autofocus="autofocus"
                         placeholder="Enter the image code (expires in 3 minutes)">
                </div>

                <div class="form-group">
                  <label for="otpCode">Email OTP code</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span id="otpCodePrefix" class="input-group-text tp-otp-prefix"><?php echo $_SESSION['otpCodePrefix']; ?></span>
                    </div>
                    <input class="form-control" type="tel" required="yes" id="otpCode" name="otpCode"
                           minlength="6" maxlength="6" value=""
                           placeholder="6 digits OTP code (expires in 3 mins)">
                  </div>
                </div>

                <div class="form-group mb-3">
                  <button class="btn btn-primary btn-lg tpg-btn-block" name="submit" value="submit" type="submit">Submit</button>
                </div>

              </form>

              <p class="tpg-note mb-0">
                The OTP code has been sent to the email address you signed in with.
                The prefix shown next to the input box is not part of the 6-digit code.
              </p>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
