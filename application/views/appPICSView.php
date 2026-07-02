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
  <!-- Dell 1996 redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/dell-1996.css" rel="stylesheet" type="text/css" />

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
      $("#ok").change(function()
      {
        if ($("#ok").is(':checked'))
        {
          $(":checkbox").prop("disabled", true);
          $(":submit").show();
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
              <h3 class="text-white">Personal Information Collection Statement</h3>
            </div>

            <div class="card-body">
              <div class="box embed-responsive embed-responsive-4by3">
                <object class="embed-responsive-item" data="<?php echo base_url(); ?>assets/doc/pics.pdf" type="application/pdf" internalinstanceid="9" title="">
                  <p>Your browser isn't supporting embedded pdf files. You can download the file
                    <a href="<?php echo base_url(); ?>assets/doc/pics.pdf">here</a>.</p>
                  </object>
                </div>
                
                <?php echo form_open ('display/start'); ?>
                    <div class="form-group mt-2 mb-0 text-center">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ok" />
                        <label class="custom-control-label" for="ok">I have read and understood the above.</label>
                      </div>
                      <button class="btn btn-primary" type="submit">Let's start</button>
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
