<?php
  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $ci = new CI_Controller();
  $ci =& get_instance();
  $ci->load->helper('url');
?>
<?php
$pageTitle = 'Page Not Found';
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
                <div class="tp-error-code">404</div>
                <h4 class="tp-done-title mt-3">Page not found</h4>
                <p class="tp-done-text">Looks like you may have taken a wrong turn. Don't worry... it happens to the best of us.</p>
              </div>

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
