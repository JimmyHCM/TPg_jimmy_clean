<?php
$pageTitle = 'Submit Reply Slip';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
include_once APPPATH."config/userConstants.php";
?>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
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
            <!-- reply slip already submitted — confirmation state -->
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-10 col-12">
                <div class="card">
                  <div class="card-body p-4 p-md-5">
                    <div class="tp-done">
                      <div class="tp-done-icon"><i class="mdi mdi-check-decagram"></i></div>
                      <h4 class="tp-done-title">Reply slip submitted</h4>
                      <p class="tp-done-text mb-0">
                        Your reply slip has been received. A copy has been emailed to you,
                        and you will be informed of the next step in due course.
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
                  <h4 class="page-title">Confirmation of offer</h4>
                  <p class="lead mb-0">Congratulations on receiving an offer. Details of the offer can be found in the offer letter sent to you via email. Please fill out the form below to accept / reject the offer.</p>
                </div>
              </div>
            </div>
            <!-- end page title -->

            <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
              <h4 class="text-primary">Screen too small for the form, please use a device with larger screen size.</h4>
            </div>

            <div class="row d-none d-md-block"><!-- visible md and up -->
              <div class="col-12">
                <div class="card tp-letter-card">
                  <?php include(APPPATH.'views/partials/auth_brand.php'); ?>
                  <div class="card-body p-4 p-md-5">

                    <!-- notice of admission -->
                    <?php if ($RS['currLen'] == '1') $displayYear = 'year'; else $displayYear = 'years'; ?>
                    <table style="width:90%">
                      <tr><td colspan="6" align="center">THE UNIVERSITY OF HONG KONG</td></tr>
                      <tr><td colspan="6"><br/></td></tr>
                      <tr><td colspan="6"><strong>Notice of Admission <?php echo $RS['acadYear']; ?>:</strong> <?php echo $RS['currTitle'] ?> (<?php echo $RS['studyMode']; ?>)</td></tr>
                      <tr><td colspan="6"><em>(To be completed by the Faculty Office.)</em></td></tr>
                      <tr><td colspan="6">The candidate named below:</td></tr>
                      <tr><td><br/></td><td>Candidate:</td><td><br/></td><td colspan="3"><?php echo $RS['appName']; ?></td></tr>
                      <tr><td><br/></td><td>Application Number:</td><td><br/></td><td colspan="3"><?php echo $RS['appNo']; ?></td></tr>
                      <tr><td colspan="6"><br/></td></tr>
                      <tr><td colspan="6">is offered admission to the following programme commencing in <?php echo $RS['commencingDate']; ?>:</td></tr>
                      <tr><td colspan="6"><br/></td></tr>
                      <tr><td><br/></td><td>Programme:</td><td><br/></td><td colspan="3"><?php echo $RS['titleDisplay']; ?></td></tr>
                      <tr><td><br/></td><td>Mode of Study:</td><td><br/></td><td colspan="3"><?php echo $RS['studyMode']; ?></td></tr>
                      <tr><td><br/></td><td>Programme Duration:</td><td><br/></td><td colspan="3"><?php echo $RS['currLen'].' '.$displayYear; ?></td></tr>
                      <tr><td colspan="6"><br/></td></tr>
                      <tr><td><br/><br/>Date:</td>
                        <td align="center"><br/><br/><?php echo $RS['issueDate']; ?></td>
                        <td><br/></td>
                        <td><br/><br/>Signature:</td><td><br/></td>
                        <td align="left"><img src="<?php echo base_url(); ?>assets/images/signature.png" height="80px"></td></tr>
                      <tr><td colspan="4"><br/></td><td colspan="2" align="left"><?php echo FAC_SEC; ?><br/>Secretary, Faculty of Engineering<br/>for Registrar</td></tr>
                      <tr><td colspan="6"><br/></td></tr>
                    </table>

                    <!-- form -->
                    <form role="form" id="RSform" action="<?php echo base_url(); ?>status/reply" method="POST" enctype="multipart/form-data">
                    <?php $wordO = ''; if ($RS['recommendation'] == 'C') $wordO = 'CONDITIONAL'; else if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF') $wordO = 'FIRM'; ?>
                     <div class="text-center">
                      <hr>
                      <br/><strong><?php echo $wordO; ?> OFFER OF ADMISSION</strong><br/><br/>
                    </div>
                    <p><em>To be completed and submitted by the candidate by </em><u><?php echo $RS['deadline']; ?>.</u><br/><br/>
                      <em>Please tick the appropriate box below.</em>
                    </p>

                    <div class="custom-control custom-radio mb-2">
                      <input type="radio" id="acceptO" name="myReply" class="custom-control-input" value="acceptO" required />
                      <label class="custom-control-label" for="acceptO">ACCEPTANCE</label>
                      <table style="width:92%">
                        <tr><td align="justify" colspan="2">
                          <?php if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF') { ?>
                            I, the candidate named above, accept this <strong>firm offer of admission</strong>, and in so doing and without prejudice to other rights and remedies of the University,
                          <?php } else if ($RS['recommendation'] == 'C') { ?>
                            I, the candidate named above, accept this <strong>conditional offer of admission</strong> under the conditions laid down in the offer of admission of <?php echo $RS['issueDate']; ?>, and in so doing and without prejudice to other rights and remedies of the University,
                          <?php } ?>
                        </td></tr>
                      </table>
                      <div class="panel-group mb-2">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h5 class="panel-title">
                              <a data-toggle="collapse" href="#collapse1">Details (show / hide)</a>
                            </h5>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                              <table style="width:92%">
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand and agree that the University may, at its absolute discretion exercisable at any time, request me to produce the originals of transcripts, certificates, references, reports, assignments, publications and any other relevant documents in support of and/or in connection with my application and/or admission, regardless of whether such documents have been previously submitted to it.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand and agree that if there are any discrepancy, misrepresentation, forgery, falsification, plagiarism or other irregularities in respect of my application and/or the above documents which the University deems to be material, the University has the right at any time to withdraw the offer of admission, treat any acceptance of the offer as null and void, terminate my enrolment and student status in the University, and make a report to the relevant law enforcement agencies which may result in criminal prosecution.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I agree to obey all rules and regulations of the University as long as they apply to me as a member of the University.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that I am liable to pay the first instalment of composition fee<?php if ($RS['studyMode']=='Full-time') echo ', caution money of HK$350 and the Student Activity Fee of HK$100 (applicable to full-time students only)'; else echo ' and caution money of HK$350'; ?> upon acceptance of the offer and that <span style="color:red;"><strong>fees once paid are non-refundable and non-transferrable.</strong></span>  The composition fee<sup>#</sup> of this <?php echo $RS['currLen'].'  '.$displayYear. ' '. lcfirst ($RS['studyMode']); ?> programme for <?php echo $RS['acadYear']; ?> is <?php echo $RS['compFeeCurr']; ?><?php if ($RS['provisional'] == 'Y') { ?>
                                  <sup>*</sup> (provisional)
                                <?php } ?>
                                for <?php echo $RS['totalCredit']; ?> credit-units.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">Pursuant to the Personal Data (Privacy) Ordinance, I agree that the personal data provided by me can be used by the University for all academic and administrative purposes.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that The University of Hong Kong is a &lsquo;public body&rsquo; and is therefore subject to the meaning of the Prevention of Bribery Ordinance.</td></tr>
                                <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that concurrent registration by a student of this University for another post-secondary qualification either at this University or another institution without the approval of the Senate <em>given in advance</em> is prohibited by University regulations and that breach of this regulation may result in discontinuation of my studies at the University.</td></tr>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="uploadPslip" class="form-group alert alert-info" role="alert"> <!-- file upload -->
                      <label>Payment slip (.jpg, .jpeg, .png accepted) at least 1MB, max 2MB</label>
                      <input name="paymentSlip" id="paymentSlip" type="file" accept=".jpg,.jpeg,.png" />
                    </div> <!-- end file upload -->

                    <div class="custom-control custom-radio mt-4 mb-2">
                      <input type="radio" id="rejectO" name="myReply" class="custom-control-input" value="rejectO" />
                      <label class="custom-control-label" for="rejectO">REJECTION</label>
                      <table>
                        <tr><td colspan="2">I, the candidate named above, decline this <strong><?php if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF') echo 'firm'; else if ($RS['recommendation'] == 'C') echo 'conditional'; ?> offer of admission</strong>.</td></tr>
                        <tr><td style="width:3%" valign="top"><br/></td><td><br/></td></tr>
                      </table>
                    </div>
                    <table style="width:92%">
                      <tr><td style="width:3%" valign="top"><small>#</small></td><td align="justify"><small><?php echo $RS['RSfooter']; ?></small></td></tr>
                        <?php if ($RS['provisional'] == 'Y') { ?>
                          <tr><td valign="top"><small>*</small></td><td align="justify"><small>Pending the University&rsquo;s announcement on the composition fee for <?php echo $RS['acadYear']; ?>.</small></td></tr>
                        <?php } ?>
                      <tr><td spancol="2"><br/></td></tr>
                    </table>
                    <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control" id="replyDate" name="replyDate" disabled value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                      <label for="signature">Signature (English only)</label>
                      <input class="form-control" type="signature" name="signature" required="yes" id="signature" maxlength="30" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                      <label for="myEmail">Email address</label>
                      <input class="form-control" type="email" name="myEmail" required="yes" id="myEmail" placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-0 text-center">
                      <input type="submit" name="submit" class="btn btn-primary btn-lg tpg-btn-block" value="Submit reply slip"></input>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div> <!-- content -->

<?php if (!$hasError && !$replied) { ?>
  <script>
    $(document).ready(function()
    {
      $("#uploadPslip").hide();
      var recommendation = "<?php echo $RS['recommendation']; ?>";
      $("#acceptO").change(function()
      {
        if ($("#acceptO").is(':checked'))
        {
          var recommendation = "<?php echo $RS['recommendation']; ?>";
          if (recommendation == 'C' || recommendation == 'F')
          {
            $("#paymentSlip").prop('required', true);
            $("#uploadPslip").show();
          }
        }
      });
      $("#rejectO").change(function()
      {
        if ($("#rejectO").is(':checked'))
        {
          $("#paymentSlip").prop('required', false);
          $("#uploadPslip").hide();
        }
      });

    });
  </script>
<?php } ?>

<?php include(APPPATH.'views/partials/hub_foot.php'); ?>
