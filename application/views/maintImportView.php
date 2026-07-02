<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - import record</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- Dell 1996 redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/dell-1996.css" rel="stylesheet" type="text/css" />

</head>

<body>
  <div class="account-pages mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card">

            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-primary">
              <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
            </div>

            <div class="card-body p-4">

              <div class="text-center w-75 m-auto">

                <?php if (isset($_SESSION['success'])) {?>
                  <div class="alert alert-danger"> <?php echo $_SESSION['success']; ?></div>
                  <?php 
                }?>

                <?php if (isset($_SESSION['error'])) {?>
                  <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
                  <?php 
                }?>

                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Import Records</h4>
              </div>

              <?php echo form_open ('maintenance/import'); ?>

                <div class="form-group">
                  <label for="filename">csv filename</label>
                  <input class="form-control" type="text" required="yes" name="filename" id="filename" autofocus="autofocus">
                </div>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-primary" type="submit"> Import </button>
                </div>

              <?php echo form_close(); ?>

              <?php echo form_open ('maintenance/logout'); ?>

                <div class="form-group mb-0 text-center">
                  <button class="btn btn-primary" type="submit"> Logout </button>
                </div>

              <?php echo form_close(); ?>
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
