<?php
$pageTitle = 'Sign In';
$bodyClass = 'tpg-auth-body';
include(APPPATH.'views/partials/head.php');
?>

  <div class="account-pages pt-5 pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card tpg-auth-card">

            <?php include(APPPATH.'views/partials/auth_brand.php'); ?>

            <div class="card-body p-4 p-md-5">

              <div class="text-center mb-4">
                <h4 class="tpg-auth-title mt-0">TPg Admission Portal</h4>
                <p class="tpg-auth-sub mb-0">Sign in to continue your application</p>
              </div>

              <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
              <?php } ?>

              <?php echo form_open('auth/login'); ?>

                <div class="form-group">
                  <label for="appNo">Application number</label>
                  <input class="form-control" type="tel" required="yes" name="appNo" id="appNo"
                         autofocus="autofocus" minlength="10" maxlength="10"
                         placeholder="Enter your 10-digit application number">
                </div>

                <div class="form-group">
                  <label for="email">Email address</label>
                  <input class="form-control" type="text" name="email" id="email" required="yes"
                         placeholder="Enter your email">
                </div>

                <div class="form-group mb-3">
                  <button class="btn btn-primary btn-lg tpg-btn-block" type="submit">Log In</button>
                </div>

              <?php echo form_close(); ?>

              <p class="tpg-note mb-3">
                For security reasons, your email address is not kept once you have signed in.
                You may need to enter it again at a later stage.
              </p>

              <p class="tpg-auth-sub text-center mb-0">
                Server time: <?php echo $currentTime; ?><br>
                Daily maintenance: 02:00&ndash;04:59 &amp; 14:00&ndash;14:59 (UTC+8)
              </p>

              <!--
              <p class="alert alert-info text-center mt-3 mb-0">Special maintenance: 12:00 30 Nov (UTC+8) to 22:00 1 Dec (UTC+8)</p>
              -->

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
