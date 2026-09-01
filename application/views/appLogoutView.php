<?php
$pageTitle = 'Session Ended';
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

              <div class="tp-done">
                <div class="tp-done-icon"><i class="mdi mdi-logout-variant"></i></div>
                <h4 class="tp-done-title">This session has ended</h4>
              </div>

              <?php if (isset($_SESSION['error'])) {?>
                <div class="alert alert-danger mt-3"> <?php echo $_SESSION['error']; ?></div>
              <?php }?>

              <?php if (isset($_SESSION['info'])) {?>
                <div class="alert alert-info mt-3"> <?php echo $_SESSION['info']; ?></div>
              <?php }?>

              <div class="text-center mt-4">
                <a href="<?php echo base_url(); ?>auth" class="btn btn-primary btn-lg tpg-btn-block">Back to sign in</a>
              </div>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
