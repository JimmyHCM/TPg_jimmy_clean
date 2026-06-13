<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
  #frontdisplay {
    background: url("<?php echo base_url(); ?>assets/images/tpgbg.png") no-repeat fixed;
    background-position: center;
    background-size: cover;
  }
  </style>

  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script>
    $(document).ready(function()
    {
      $(":submit").hide();

      $('input[type=checkbox]').change(function() 
      {
        var checkboxes = $('input:checkbox:checked').length;

        if (checkboxes > 0 && checkboxes <= 5)
        {
          $(":submit").show();
        }
        else
        {
          $(":submit").hide(); 
        }
      });

    });
  </script>

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
              <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
            </div>

            <div class="card-body p-4">

              <div class="text-center w-85 m-auto">

                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">How did you hear about the programme(s)?</h4>
                <p class="text-muted mb-4">Please select up to <strong>five</strong> channels in which you have heard about our programme(s).</p>
              </div>

              <?php echo form_open ('display/survey'); ?>
                <div class="form-group mt-2 mb-0 text-left">
                  <?php for ($i=0; $i<$mediaCount; $i++) { ?>
                    <div class="custom-control custom-checkbox mb-2">
                      <input type="checkbox" class="custom-control-input" name="mediaChannel[]" id="<?php echo 'check'.$i; ?>" value="<?php echo $mediaList[$i]; ?>" />
                      <label class="custom-control-label" for="<?php echo 'check'.$i; ?>"><?php echo $mediaList[$i]; ?></label>
                    </div>
                  <?php } ?>

                  <div class="text-right">
                    <button class="btn btn-primary" type="submit">Next</button>
                  </div>
                </div>

              <?php echo form_close(); ?>
            </div> <!-- end card-body -->
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
