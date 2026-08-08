<?php
$pageTitle = 'Quick Survey';
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

  <div class="account-pages pt-5 pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card tpg-auth-card tpg-auth-card-wide">

            <?php include(APPPATH.'views/partials/auth_brand.php'); ?>

            <div class="card-body p-4 p-md-5">

              <div class="text-center mb-4">
                <h4 class="tpg-auth-title mt-0">How did you hear about the programme(s)?</h4>
                <p class="tpg-auth-sub mb-0">Please select up to <strong>five</strong> channels in which you have heard about our programme(s).</p>
              </div>

              <?php echo form_open ('display/survey'); ?>
                <div class="form-group mt-2 mb-0 text-left">
                  <div class="tp-option-list">
                    <?php for ($i=0; $i<$mediaCount; $i++) { ?>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="mediaChannel[]" id="<?php echo 'check'.$i; ?>" value="<?php echo $mediaList[$i]; ?>" />
                        <label class="custom-control-label" for="<?php echo 'check'.$i; ?>"><?php echo $mediaList[$i]; ?></label>
                      </div>
                    <?php } ?>
                  </div>

                  <div class="mt-3">
                    <button class="btn btn-primary btn-lg tpg-btn-block" type="submit">Next</button>
                  </div>
                </div>
              <?php echo form_close(); ?>

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div> <!-- end col -->
      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end page -->

<?php include(APPPATH.'views/partials/footer.php'); ?>
