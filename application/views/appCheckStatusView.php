<?php
$pageTitle = 'Check Status';
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

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title">My application status</h4>
                <p class="lead mb-0">The system will submit an update request on your behalf and this session will be ended. Within an hour, you will receive an email update of your application status.</p>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="row m-2">
            <div class="col-12">
              <?php if (isset($_SESSION['info'])) {?>
                <div class="alert alert-warning"> <?php echo $_SESSION['info']; ?></div>
              <?php }?>

              <?php if (isset($_SESSION['error'])) {?>
                <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
              <?php }?>
            </div>
          </div>

          <div class="row">
            <div class="col-12">

              <div class="card tp-form-card">
                <div class="card-body p-4">

                  <?php $show = TRUE;
                  if (isset($_SESSION['success'])) {?>
                    <div class="alert alert-success">
                      <?php echo $_SESSION['success']; ?>
                    </div>
                  <?php $show = FALSE;
                  } ?>

                  <!-- form -->
                  <?php
                  if ($show) {
                    echo form_open('status/checkStatus'); ?>

                    <p class="tpg-note mb-3">
                      For security reasons, the system did not store your login email address.
                      Please enter it again below to receive the update.
                    </p>

                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input class="form-control" type="email" name="email" required="yes" id="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-0">
                      <button class="btn btn-primary btn-lg tpg-btn-block" type="submit"><i class="mdi mdi-email-check-outline"></i> Email my status</button>
                    </div>

                  <?php echo form_close();
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- content -->

<?php include(APPPATH.'views/partials/hub_foot.php'); ?>
