<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - submit reply slip</title>
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
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=4" rel="stylesheet" type="text/css" />


  <?php include_once APPPATH."config/userConstants.php"; ?>
  
  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
    }
  </script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <a name="top"></a>

  <!-- Begin page -->
  <div class="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

      <div class="slimscroll-menu">

        <!-- LOGO -->
        <a href="https://engg.hku.hk/" class="logo text-center">
          <span class="logo-lg">
            <img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="40">
          </span>
        </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

          <li class="side-nav-title side-nav-item">Navigation</li>

          <?php if (strpos ($menu, 'D') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/upload" class="side-nav-link">
                <i class="mdi mdi-note-multiple"></i>
                <span> Documents</span>
                <span class="menu-arrow"></span>
              </a>
              <ul class="side-nav-second-level" aria-expanded="false">
                <li>
                  <a href="<?php echo base_url(); ?>display/upload"><i class="mdi mdi-playlist-check"></i>upload documents</a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>display/summary">my upload summary</a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'R') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/reply" class="side-nav-link">
                <i class="mdi mdi-message-text-outline"></i>
                <span> Submit reply slip </span>
              </a>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'P') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/payment" class="side-nav-link">
                <i class="mdi mdi-square-inc-cash"></i>
                <span> Upload payment slip </span>
              </a>
            </li>
          <?php } ?>

          <?php if (strpos ($menu, 'S') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/checkStatus" class="side-nav-link">
                <i class="mdi mdi-signal"></i>
                <span> Check status </span>
              </a>
            </li>
          <?php } ?>
          
          <!-- chat message -->
          <!-- 
          <?php if (strpos ($menu, 'C') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/checkMessage" class="side-nav-link">
                <i class="mdi mdi-email-outline"></i>
                <span> Check message </span>
              </a>
            </li>
          <?php } ?>
        -->

          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>auth/logout" class="side-nav-link">
              <i class="mdi mdi-logout"></i>
              <span> Logout </span>
            </a>
          </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- Start Page Content here -->
    <div class="content-page">

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <button class="button-menu-mobile open-left disable-btn">
          <i class="mdi mdi-menu"></i>
        </button>
      </div>

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

          <?php if (!$hasError && !$replied) { ?>
            <!-- start page title -->
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title text-primary">Confirmation of offer</h4>
                  <p class="lead">Congratulations on receiving an offer.</p>
                  <p class="lead">Details of the offer can be found in the offer letter sent to you via email. Please fill out the form below to accept / reject the offer.</p>
                </div>
              </div>
            </div>     
            <!-- end page title --> 

            <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
              <h4 class="text-primary">Screen too small for the form, please use a device with larger screen size.</h4>
            </div>

            <div class="row d-none d-md-block"><!-- visible md and up -->
              <div class="row justify-content-center">
                <div class="col-lg-1">
                </div>
                <div class="col-lg-6 col-md-12">
                  <div class="card shadow-sm" style="background-color: white;">
                    <!-- Logo -->
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                      <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
                    </div>
                    <div class="card-body p-4">

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
                                  <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that The University of Hong Kong is a ‘public body’ and is therefore subject to the meaning of the Prevention of Bribery Ordinance.</td></tr>
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
                            <tr><td valign="top"><small>*</small></td><td align="justify"><small>Pending the University’s announcement on the composition fee for <?php echo $RS['acadYear']; ?>.</small></td></tr>
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
                        <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Submit reply slip"></input>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-lg-1">
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <?php echo $currentYear; ?> © faculty of engineering, HKU
          </div>
          <div class="col-md-6">
            <div class="text-md-right footer-links d-none d-md-block">
              <a href="#top"><i class="mdi mdi-chevron-double-up h3"></i></a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- end Footer -->

  </div><!-- END wrapper --> 

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=4"></script>

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

</body>
</html>
