<?php
$pageTitle = 'Upload Payment Slip';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
?>
<script type="text/javascript">
  window.history.forward();
  function noBack() {
    window.history.forward();
  }
</script>

<?php include(APPPATH.'views/partials/hub_top.php'); ?>

      <div class="content">

        <div class="container-fluid">

          <?php $hasError = false; ?>
          <div class="row m-2">
            <div class="col-12">
              <?php if (isset($_SESSION['info'])) {?>
                <?php $hasError = true; ?>
                <div class="alert alert-warning"> <?php echo $_SESSION['info']; ?></div>
              <?php }?>

              <?php if (isset($_SESSION['error'])) {?>
                <?php $hasError = true; ?>
                <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
              <?php }?>
            </div>
          </div>

          <?php if (!$hasError && $replied) { ?>
            <!-- payment proof already uploaded — confirmation state -->
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-10 col-12">
                <div class="card">
                  <div class="card-body p-4 p-md-5">
                    <div class="tp-done">
                      <div class="tp-done-icon"><i class="mdi mdi-check-decagram"></i></div>
                      <h4 class="tp-done-title">Payment proof received</h4>
                      <p class="tp-done-text mb-0">
                        Your proof of payment has been received and will be verified.
                        You will be informed of the next step in due course.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

          <?php if (!$hasError && !$replied) { ?>
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title">Upload payment slip</h4>
                <p class="lead mb-0">Please upload additional payment slip (if any) here.</p>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
            <h4 class="text-primary">Screen too small for file upload, please use a device with larger screen size.</h4>
          </div>

          <div class="row d-none d-md-block"><!-- visible md and up -->
            <div class="col-12">
              <div class="card tp-form-card">
                <?php include(APPPATH.'views/partials/auth_brand.php'); ?>
                <div class="card-body p-4">

                  <!-- form -->
                  <form id="RSform" action="<?php echo base_url(); ?>status/uploadPS" method="POST" enctype="multipart/form-data">
                  <p>Please enter the information below and upload any additional payment slip.</p>

                  <div id="uploadPslip" class="form-group alert alert-info" role="alert"> <!-- file upload -->
                    <label>Payment slip (.jpg, .jpeg, .png accepted) at least 1MB, max 2MB</label>
                    <input name="paymentSlip" id="paymentSlip" type="file" accept=".jpg,.jpeg,.png" required/>
                  </div> <!-- end file upload -->

                  <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control" id="replyDate" name="replyDate" disabled value="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input class="form-control" type="email" name="email" required="yes" id="email" placeholder="Enter your email">
                  </div>
                  <div class="form-group mb-0 text-center">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg tpg-btn-block" value="Upload payment slip"></input>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div> <!-- content -->

<?php include(APPPATH.'views/partials/hub_foot.php'); ?>
