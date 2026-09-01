<?php
$pageTitle = 'My Upload Summary';
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
                <h4 class="page-title">My upload summary</h4>
                <p class="lead mb-0">The system is going to email the file upload summary to you, and this session will be ended.</p>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="row">
            <div class="col-12">

              <div class="card tp-form-card">
                <div class="card-body p-4">

                  <?php
                  $show = TRUE;
                  if (isset($_SESSION['success'])) {?>
                    <div class="alert alert-success">
                      <?php echo $_SESSION['success']; ?>
                    </div>
                  <?php
                  $show = FALSE;
                  } else if (isset($_SESSION['error'])) {?>
                    <div class="alert alert-danger">
                      <?php echo $_SESSION['error']; ?>
                    </div>
                  <?php
                  }?>

                  <!-- form -->
                  <?php
                  if ($show) {
                    echo form_open('upload/summary'); ?>

                    <p class="tpg-note mb-3">
                      For security reasons, the system did not store your login email address.
                      Please enter it again below to receive the file upload summary.
                    </p>

                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input class="form-control" type="email" name="email" required="yes" id="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-0">
                      <button class="btn btn-primary btn-lg tpg-btn-block" type="submit"><i class="mdi mdi-email-check-outline"></i> Email my summary</button>
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
