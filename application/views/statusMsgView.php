<?php
$pageTitle = 'Application Status';
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
          <div class="card tpg-auth-card tpg-auth-card-wide">

            <?php include(APPPATH.'views/partials/auth_brand.php'); ?>

            <div class="card-body p-4 p-md-5">

              <div class="text-center mb-4">
                <h4 class="tpg-auth-title mt-0">Application status update</h4>
                <p class="tpg-auth-sub mb-0">Application number <?php echo $appNo; ?></p>
              </div>

              <?php echo form_open ('display/statusShown'); ?>

                <div class="tp-status-letter">
                  <?php if ($statusMsg != '') { ?>
                    <?php echo $statusMsg; ?>
                  <?php } ?>
                </div>

                <button class="btn btn-primary btn-lg tpg-btn-block" type="submit">Next</button>

              <?php echo form_close(); ?>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
