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
        $("#consentHint").hide();
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
                <div class="tp-pics-eyebrow">The University of Hong Kong</div>
                <h4 class="tp-pics-title">Personal Information Collection Statement</h4>
                <div class="tp-ornament"></div>
                <p class="tpg-auth-sub mb-0">For applicants and students &mdash; please read the statement below before you continue</p>
              </div>

              <div class="tp-pics-doc mb-2">
                <div class="tp-pics-doc-head">
                  <span><i class="mdi mdi-file-certificate-outline"></i> Official statement &mdash; 2 pages</span>
                  <a href="<?php echo base_url(); ?>assets/doc/pics.pdf" target="_blank" rel="noopener"><i class="mdi mdi-open-in-new"></i> Open in new tab</a>
                </div>
                <object data="<?php echo base_url(); ?>assets/doc/pics.pdf#toolbar=0&navpanes=0&view=FitH" type="application/pdf" internalinstanceid="9" title="Personal Information Collection Statement">
                  <p class="p-3">Your browser isn't supporting embedded pdf files. You can download the file
                    <a href="<?php echo base_url(); ?>assets/doc/pics.pdf">here</a>.</p>
                </object>
              </div>

              <?php echo form_open ('display/start'); ?>
                <div class="tp-consent">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ok" />
                    <label class="custom-control-label" for="ok"><strong>I have read and understood the above.</strong></label>
                  </div>
                  <p class="tp-consent-hint" id="consentHint"><i class="mdi mdi-arrow-up"></i> Tick the box to continue to your application.</p>
                </div>
                <div class="form-group mt-3 mb-0">
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
