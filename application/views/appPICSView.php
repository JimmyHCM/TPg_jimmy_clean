<?php
$pageTitle = 'Personal Information Collection Statement';
$bodyClass = 'tpg-auth-body';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
?>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
  window.history.forward();
  function noBack() {
    window.history.forward();
  }

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

  <div class="account-pages pt-5 pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card tpg-auth-card tpg-auth-card-wide">

            <?php include(APPPATH.'views/partials/auth_brand.php'); ?>

            <div class="card-body p-4 p-md-5">

              <div class="text-center mb-4">
                <h4 class="tpg-auth-title mt-0">Personal Information Collection Statement</h4>
                <p class="tpg-auth-sub mb-0">Please read the statement below before you continue</p>
              </div>

              <div class="tp-pdf-frame box embed-responsive embed-responsive-4by3 mb-4">
                <object class="embed-responsive-item" data="<?php echo base_url(); ?>assets/doc/pics.pdf" type="application/pdf" internalinstanceid="9" title="">
                  <p class="p-3">Your browser isn't supporting embedded pdf files. You can download the file
                    <a href="<?php echo base_url(); ?>assets/doc/pics.pdf">here</a>.</p>
                </object>
              </div>

              <?php echo form_open ('display/start'); ?>
                <div class="form-group mt-2 mb-0 text-center">
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="ok" />
                    <label class="custom-control-label" for="ok"><strong>I have read and understood the above.</strong></label>
                  </div>
                  <button class="btn btn-primary btn-lg tpg-btn-block" type="submit">Let's start</button>
                </div>
              <?php echo form_close(); ?>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
