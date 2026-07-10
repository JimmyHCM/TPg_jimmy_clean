<!-- no upload of payment, with confirm modal before actual submit  -->
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
      
      <div class="content">

        <div class="container-fluid">

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


          <!-- reply slip modal-->
          <div id="RSmodal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="card shadow-sm">

                    <div class="card-body p-4">
                      <div class="text-center w-80 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Admission offer - my reply</h4>
                        <p class="text-muted mb-4">Please check the following information, and then confirm to submit.</p>
                      </div>

                      <form role="form" id="RSform" action="<?php echo base_url(); ?>status/reply" method="POST">
                        <div class="form-group text-left">
                          <label for="RSsignature">Candidate name</label>
                          <input class="form-control" type="text" name="RSsignature" id="RSsignature" readonly="readonly">
                        </div>
                        <div class="form-group text-left">
                          <label for="RSemail">Email address</label>
                          <input class="form-control" type="text" name="RSemail" id="RSemail" readonly="readonly">
                        </div>
                        <div class="custom-control custom-radio mb-2">
                          <input type="radio" id="RSacceptO" name="RSmyReply" class="custom-control-input" value="acceptO" disabled="yes">
                          <label class="custom-control-label" for="RSacceptO">Accept offer</label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                          <input type="radio" id="RSrejectO" name="RSmyReply" class="custom-control-input" value="rejectO" disabled="yes">
                          <label class="custom-control-label" for="RSrejectO">Reject offer</label>
                        </div>
                        <div class="form-group text-left">
                          <input type="hidden" class="form-control" name="RSmyReply" id="RSmyReply">
                        </div>
                        <div class="form-group">
                          <label>Date</label>
                          <input type="text" class="form-control" id="RSreplyDate" name="RSreplyDate" readonly="readonly">
                        </div>
                        <div class="form-group text-center">
                          <button type="submit" class="btn btn-rounded btn-outline-primary">Confirm and submit</button>
                          <button class="btn btn-rounded btn-outline-primary" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

          <div class="row justify-content-center">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="card shadow-sm" style="background-color: white;">
                <!-- Logo -->
                <div class="card-header pt-4 pb-4 text-center bg-primary">
                  <span><img src="<?php echo base_url(); ?>assets/images/engghkuLogoWhite.png" alt="" height="60"></span>
                </div>
                <div class="card-body p-4">

                  <!-- notice of admission -->
                  <table>
                    <tr><td colspan="4" align="center">THE UNIVERSITY OF HONG KONG</td></tr>
                    <tr><td colspan="4"><br/></td></tr>
                    <tr><td colspan="4"><strong>Notice of Admission <?php echo $RS['acadYear']; ?>:</strong> <?php echo $RS['currTitle'] ?> (<?php echo $RS['studyMode']; ?>)</td></tr>
                    <tr><td colspan="4"><br/></td></tr>
                    <tr><td colspan="4">The candidate named below:</td></tr>
                    <tr><td><br/></td><td>Candidate:</td><td colspan="2"><?php echo $RS['appName']; ?></td></tr>
                    <tr><td><br/></td><td>Application Number:</td><td colspan="2"><?php echo $RS['appNo']; ?></td></tr>
                    <tr><td colspan="4"><br/></td></tr>
                    <tr><td colspan="4">is offered admission to the following curriculum commencing in <?php echo $RS['commencingDate']; ?>:</td></tr>
                    <tr><td colspan="4"><br/></td></tr>
                    <tr><td><br/></td><td>Curriculum:</td><td colspan="2"><?php echo $RS['titleDisplay']; ?></td></tr>
                    <tr><td><br/></td><td>Mode of Study:</td><td colspan="2"><?php echo $RS['studyMode']; ?></td></tr>
                    <tr><td><br/></td><td>Length of Curriculum:</td><td colspan="2"><?php echo $RS['currLen'].' academic year'; if ($RS['currLen']!=1 && $RS['currLen']!='1') echo 's'; ?></td></tr>
                    <tr><td colspan="4"><br/></td></tr>
                    <tr><td><br/><br/><br/>Date:</td><td><br/><br/><br/><?php echo $RS['issueDate']; ?></td><td><br/><br/><br/>Signature:</td><td align="center"><img src="<?php echo base_url(); ?>assets/images/signature.png" height="80px"></td></tr>
                    <tr><td colspan=3><br/></td><td align="center">Secretary<br/>Faculty of Engineering<br/>for Registrar</td></tr>
                    <tr><td colspan="4"><hr></td></tr>
                  </table>

                  <!-- form -->
                  <p><strong>To be completed and submitted by the candidate by <?php echo $RS['deadline']; ?>.</strong><br/><br/>
                    Please mark the appropriate selection below.
                  </p>

                  <div class="custom-control custom-radio mb-2">
                    <input type="radio" id="acceptO" name="myReply" class="custom-control-input" value="acceptO" required />
                    <label class="custom-control-label" for="acceptO">Accept offer</label>
                    <table>
                      <tr><td colspan="2">
                        <?php if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF') { ?>
                      I, the candidate named above, accept this <strong>offer of admission</strong>, and in so doing and without prejudice to other rights and remedies of the University,
                      <?php } else if ($RS['recommendation'] == 'C') { ?>
                        I, the candidate named above, accept this <strong>conditional offer of admission</strong> under the conditions laid down in the offer of admission of <?php echo $RS['issueDate']; ?>, and in so doing and without prejudice to other rights and remedies of the University,
                      <?php } ?>
                      </td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand and agree that the University may, at its absolute discretion exercisable at any time, request me to produce the originals of transcripts, certificates, references, reports, assignments, publications and any other relevant documents in support of and/or in connection with my application and/or admission, regardless of whether such documents have been previously submitted to it.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand and agree that if there are any discrepancy, misrepresentation, forgery, falsification, plagiarism or other irregularities in respect of my application and/or the above documents which the University deems to be material, the University has the right at any time to withdraw the offer of admission, treat any acceptance of the offer as null and void, and terminate my enrolment and student status in the University.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I agree to obey all rules and regulations of the University as long as they apply to me as a member of the University.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that I am liable to pay the composition fee and the caution money of HK$350 upon acceptance of the offer and that fees once paid are not refundable.  The composition fee<sup>#</sup> of this <?php echo $RS['currLen']; ?> academic years <?php echo lcfirst ($RS['studyMode']); ?> curriculum for <?php echo $RS['acadYear']; ?> is <?php echo $RS['compFeeCurr']; ?><?php if ($RS['provisional'] == 'Y') { ?>
                        <sup>*</sup> (provisional)
                      <?php } ?>
                      for <?php echo $RS['totalCredit']; ?> credit-units.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">Pursuant to the Personal Data (Privacy) Ordinance, I agree that the personal data provided by me can be used by the University for all academic and administrative purposes.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that The University of Hong Kong is a ‘public body’ and is therefore subject to the meaning of the Prevention of Bribery Ordinance.</td></tr>
                      <tr><td style="width:3%" valign="top">&bull;</td><td align="justify">I understand that concurrent registration by a student of this University for another post-secondary qualification either at this University or another institution without the approval of the Senate <em>given in advance</em> is prohibited by University regulations and that breach of this regulation may result in discontinuation of my studies at the University.</td></tr>
                    </table>
                  </div>
                    
                  <div class="custom-control custom-radio mb-2">
                    <input type="radio" id="rejectO" name="myReply" class="custom-control-input" value="rejectO" />
                    <label class="custom-control-label" for="rejectO">Reject offer</label>
                    <table>
                      <tr><td colspan="2">I, the candidate named above, do not wish to accept this offer of admission.</td></tr>
                      <tr><td style="width:3%" valign="top"><br/></td><td><br/></td></tr>
                    </table>
                  </div>
                  <table>
                    <tr><td style="width:3%" valign="top"><small>#</small></td><td style="width:92%" align="justify"><small><?php echo $RS['RSfooter']; ?></small></td></tr>
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
                    <label for="signature">Signature</label>
                    <input class="form-control" type="signature" name="signature" required="yes" id="signature" placeholder="Enter your name">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input class="form-control" type="email" name="email" required="yes" id="email" placeholder="Enter your email">
                  </div>
                  <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-block" name="submit" id="submit"><i class="mdi mdi-login"></i> Submit </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-1">
            </div>
          </div>
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
      $('#submit').on('click', function () 
      {
        if (!$("#signature").val () || !$("#email").val () || 
            ($("#acceptO").prop ('checked') == false && $("#rejectO").prop ('checked') == false))
          alert ("information missing, please check");
        else
        {
          $("#RSsignature").val ($("#signature").val ());
          $("#RSemail").val ($("#email").val ());
          
          if ($("#acceptO").prop ('checked') == true)
          {
            $("#RSacceptO").prop ('checked', true);
            $('#RSmyReply').val("acceptO");
          }
          else if ($("#rejectO").prop ('checked') == true)
          {
            $("#RSrejectO").prop ('checked', true);
            $('#RSmyReply').val("rejectO");
          }

          $("#RSreplyDate").val ($("#replyDate").val ());
          $("#RSmodal").modal();
        }
      });

    });
  </script>

</body>
</html>
