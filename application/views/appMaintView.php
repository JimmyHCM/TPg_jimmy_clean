<?php
$pageTitle = 'Under Maintenance';
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
                <div class="tp-done-icon tp-done-warn"><i class="mdi mdi-wrench-outline"></i></div>
                <h4 class="tp-done-title">Under maintenance</h4>
                <p class="tp-done-text">The system is temporarily unavailable for maintenance or update. Please try again later.</p>
              </div>

              <!--
              <div class="alert alert-info text-center mt-3">Special maintenance<br/>12:00 30 Nov (UTC+8) to 22:00 1 Dec (UTC+8)</div>
              -->
              <!--
              <div class="alert alert-info text-center mt-3">Temporary maintenance<br/>system will be available very soon 11:00 16 Mar (UTC+8)</div>
              -->

              <p class="tpg-note text-center mt-4 mb-0">
                Daily system down time for maintenance or update:<br>
                02:00&ndash;02:59 (UTC+8) &amp; 14:00&ndash;14:59 (UTC+8)
              </p>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
