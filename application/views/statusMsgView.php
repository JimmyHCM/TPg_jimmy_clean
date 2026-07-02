<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - display status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=3" rel="stylesheet" type="text/css" />


  <style type="text/css">
  #frontdisplay {
    background: url("<?php echo base_url(); ?>assets/images/tpgbg.png") no-repeat fixed;
    background-position: center;
    background-size: cover;
  }
  </style>

  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>

  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
    }
  </script>
</head>

<body id="frontdisplay" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <div class="account-pages mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card">

            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-primary">
              <h3 class="text-white">Application status update for <?php echo $appNo;?></h3>
            </div>

            <div class="card-body">
              <?php echo form_open ('display/statusShown'); ?>
                <p class="text-muted mb-4">
                  <?php if ($statusMsg != '') { ?>
                    <?php echo $statusMsg; ?>
                  <?php } ?>                    
                </p>
                <div class="text-right">
                  <button class="btn btn-primary" type="submit">Next</button>
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
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=3"></script>

  </body>
</html>
