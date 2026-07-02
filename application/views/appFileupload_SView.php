<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>TPG - Current student file upload</title>
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


</head>

<body>
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

          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>display" class="side-nav-link">
              <i class="mdi mdi-home"></i>
              <span>Start here</span>
            </a>
          </li>
          <li class="side-nav-item">
            <a href="javascript: void(0);" class="side-nav-link">
              <i class="mdi mdi-file-document"></i>
              <span>Official documents</span>
              <span class="menu-arrow"></span>
            </a>
            <ul class="side-nav-second-level" aria-expanded="false">
              <li>
                <a href="<?php echo base_url(); ?>fileupload/currStudent">current status: student</a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>fileupload/currNotStudent">current status: NOT a student</a>
              </li>
            </ul>
          </li>
          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>fileupload/markSheet" class="side-nav-link">
              <i class="mdi mdi-table-edit"></i>
              <span> Mark sheet </span>
            </a>
          </li>

          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>auth/checkStatus" class="side-nav-link">
              <i class="mdi mdi-signal"></i>
              <span> Check status </span>
            </a>
          </li>

        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title text-primary">Supporting documents upload</h4>
                <p>This page is for applicant currently studying (Bachelor or higher degree) in an institution and not yet received the graduation certificate.</p>
                <p>Please follow instructions below to upload all necessary supporting documents. If your currently status is NOT a student, please click on the other link on the left panel under Official documents, this page is not for you.</p>

                  <div class="alert alert-info" role="alert">
                    <i class="dripicons-warning"></i> <strong>About file upload</strong>: Please observe these requirements:
                    <ul>
                      <li>jpg / jpeg / png
                        <ul>
                          <li>minimum size: 1MB</li>
                          <li>maximum size: 2MB</li>
                        </ul>
                      </li>
                      <li>pdf
                        <ul>
                          <li>use pdf only when original document consists of more than 1 page.</li>
                          <li>secured pdf is not allowed</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="row">
            <div class="col-12">

              <p class="lead">
                Academic qualification 
              </p>

              <div class="card d-block shadow-sm">
                <div class="card-header mt-2">
                  <p class="lead">Current academic studies</p>
                  <p>Please upload ALL supporting documents (jpg / pdf) related to your current degree to the corresponding upload boxes below. If you are not sure what to upload, please check the <strong>Start here</strong> page for detail.</p>
                  <div class="alert alert-info" role="alert">
                    <i class="dripicons-warning"></i> If you have completed one Bachelor degree and are currently enrolled in another degree, your attention is drawn to the University Regulation G6 which prohibits concurrent registration by a student for another post-secondary qualification either at this University or at another institution, unless approval of the Senate has been given in advance.  A breach of this regulation may result in discontinuation of studies at this University.
                  </div>
                </div>

                <div class="card-body slimscroll" style="max-height: 400px;">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-8">
                          <h5>Official Transcript with overall average result shown</h5>
                          <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                        </div>

                        <div class="col-4 mb-4"> <!-- file upload -->
                          <form action="/" method="post">
                            <input name="fileC1" type="file" accept=".pdf" />
                          </form>
                        </div> <!-- end file upload -->
                      </div>

                      <div class="row">
                        <div class="col-8">
                          <h5>English translation of the official transcript</h5>
                          <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                        </div>

                        <div class="col-4 mb-4"> <!-- file upload -->
                          <form action="/" method="post">
                            <input name="fileC1E" type="file" accept=".pdf" />
                          </form>
                        </div> <!-- end file upload -->
                      </div>
                    </li>

                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-8">
                          <h5>Grading system of your institution</h5>
                          <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                        </div>

                        <div class="col-4 mb-4"> <!-- file upload -->
                          <form action="/" method="post">
                            <input name="fileC2" type="file" accept=".jpg,.jpeg,.png" />
                          </form>
                        </div> <!-- end file upload -->
                      </div>

                      <div class="row">
                        <div class="col-8">
                          <h5>English translation of the grading system</h5>
                          <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                        </div>

                        <div class="col-4 mb-4"> <!-- file upload -->
                          <form action="/" method="post">
                            <input name="fileC2E" type="file" accept=".jpg,.jpeg,.png" />
                          </form>
                        </div> <!-- end file upload -->
                      </div>
                    </li>

                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-8">
                          <h5>Mark sheet for all courses you have taken in this degree in your institution</h5>
                          <p class="text-info">Download the excel template from <strong>Mark sheet</strong> on the left panel, follow the instructions to enter the mark / gpa for all courses you have taken in this degree, then upload over there.</p>
                        </div>
                      </div>
                    </li>

                  </ul>

                </div>  <!-- end card-body -->
              </div> <!-- end card block -->

            </div>
          </div>  <!-- end row -->

          <!-- Qualification obtained -->
          <div class="row">
            <div class="col-12">
              <div class="card d-block shadow-sm">
                <div class="card-header mt-2">
                  <p class="lead">Previous academic studies / Qualification obtained <button type="button" class="btn btn-sm btn-rounded btn-primary" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="the proof of successful confirmation of the award shall be effective by <?php echo $effectiveByDate; ?>." data-original-title="">i</button></p>
                  If you have obtained other academic qualifications on or before <?php echo $effectiveByDate; ?>, please upload ALL supporting documents (jpg / pdf). Click one block to upload the set of documents for one qualification obtained.
                </div>

                <div id="accordion">
                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#uni1">
                        Qualification obtained #1
                      </a>
                    </div>
                    <div id="uni1" class="collapse in" data-parent="#accordion">
                      <div class="card-body slimscroll" style="max-height: 400px;">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official Transcript with overall average result shown</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP11" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above transcript</h5>
                                <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP11E" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Grading system of your institution</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP12" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above grading system</h5>
                                <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP12E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>A statement issued by your institution showing your overall average mark / gpa in the degree you have obtained</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP15" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>

                          <div class="row">
                            <div class="col-8">
                              <h5>English translation of the above</h5>
                              <p class="text-info">Omit this part if the above is already in English OR the document contains English translation side-by-side.</p>
                            </div>

                            <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP15E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>
                        </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Graduation certificate</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP13" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP13E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>学士学位证书 (applicable to applicant from Mainland institutions only)</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP14" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP14E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>

                      </div>  <!-- end card-body -->
                    </div>
                  </div>

                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#uni2">
                        Qualification obtained #2
                      </a>
                    </div>
                    <div id="uni2" class="collapse" data-parent="#accordion">
                      <div class="card-body slimscroll" style="max-height: 400px;">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official Transcript with overall average result shown</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP21" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above transcript</h5>
                                <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP21E" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Grading system of your institution</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP22" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above grading system</h5>
                                <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP22E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>A statement issued by your institution showing your overall average mark / gpa in the degree you have obtained</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP25" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>

                          <div class="row">
                            <div class="col-8">
                              <h5>English translation of the above</h5>
                              <p class="text-info">Omit this part if the above is already in English OR the document contains English translation side-by-side.</p>
                            </div>

                            <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP25E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>
                        </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Graduation certificate</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP23" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP23E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>学士学位证书 (applicable to applicant from Mainland institutions only)</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP24" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP24E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>

                      </div>  <!-- end card-body -->
                    </div>
                  </div>

                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#uni3">
                        Qualification obtained #3
                      </a>
                    </div>
                    <div id="uni3" class="collapse" data-parent="#accordion">
                      <div class="card-body slimscroll" style="max-height: 400px;">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official Transcript with overall average result shown</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP31" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above transcript</h5>
                                <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP31E" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Grading system of your institution</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP32" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above grading system</h5>
                                <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP32E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>A statement issued by your institution showing your overall average mark / gpa in the degree you have obtained</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP35" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>

                          <div class="row">
                            <div class="col-8">
                              <h5>English translation of the above</h5>
                              <p class="text-info">Omit this part if the above is already in English OR the document contains English translation side-by-side.</p>
                            </div>

                            <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP35E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>
                        </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Graduation certificate</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP33" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP33E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>学士学位证书 (applicable to applicant from Mainland institutions only)</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP34" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP34E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>

                      </div>  <!-- end card-body -->
                    </div>
                  </div>

                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#uni4">
                        Qualification obtained #4
                      </a>
                    </div>
                    <div id="uni4" class="collapse" data-parent="#accordion">
                      <div class="card-body slimscroll" style="max-height: 400px;">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official Transcript with overall average result shown</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP41" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above transcript</h5>
                                <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP41E" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Grading system of your institution</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP42" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above grading system</h5>
                                <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP42E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>A statement issued by your institution showing your overall average mark / gpa in the degree you have obtained</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP45" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>

                          <div class="row">
                            <div class="col-8">
                              <h5>English translation of the above</h5>
                              <p class="text-info">Omit this part if the above is already in English OR the document contains English translation side-by-side.</p>
                            </div>

                            <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP45E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>
                        </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Graduation certificate</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP43" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP43E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>学士学位证书 (applicable to applicant from Mainland institutions only)</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP44" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP44E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>

                      </div>  <!-- end card-body -->
                    </div>
                  </div>

                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#uni5">
                        Qualification obtained #5
                      </a>
                    </div>
                    <div id="uni5" class="collapse" data-parent="#accordion">
                      <div class="card-body slimscroll" style="max-height: 400px;">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official Transcript with overall average result shown</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP51" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above transcript</h5>
                                <p class="text-info">Omit this part if the above transcript is already in English OR the transcript contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP51E" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>A statement issued by your institution showing your overall average mark / gpa in the degree you have obtained</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP55" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>

                          <div class="row">
                            <div class="col-8">
                              <h5>English translation of the above</h5>
                              <p class="text-info">Omit this part if the above is already in English OR the document contains English translation side-by-side.</p>
                            </div>

                            <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP55E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                          </div>
                        </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Grading system of your institution</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP52" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above grading system</h5>
                                <p class="text-info">Omit this part if the above grading system is already in English OR the document contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP52E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Graduation certificate</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP53" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP53E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>

                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>学士学位证书 (applicable to applicant from Mainland institutions only)</h5>
                                <p class="text-info">Documents which are not in English should be accompanied by a formally certified translation in English.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP54" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>

                            <div class="row">
                              <div class="col-8">
                                <h5>English translation of the above certificate</h5>
                                <p class="text-info">Omit this part if the above certificate is already in English OR the certificate contains English translation side-by-side.</p>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileP54E" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>

                      </div>  <!-- end card-body -->
                    </div>
                  </div>

                </div>
              </div> <!-- end card block -->
            </div>
          </div>


          <!-- English language -->
          <div class="row">
            <div class="col-12">
              <div class="card d-block shadow-sm">
                <div class="card-header mt-2">
                  <p class="lead">English language requirements</p>
                  If your institution is outside Hong Kong, please submit one of the followings. Click <a href="https://aal.hku.hk/tpg/english-language-requirements">here</a> for details of the requirements from HKU.
                </div>

                <div id="accordionE">
                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#englishProof">
                        Proof of the medium of instruction
                      </a>
                    </div>
                    <div id="englishProof" class="collapse" data-parent="#accordionE">
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>If the medium of instruction for the programme of the current academic studies and / or qualification obtained is in English, please submit the proof here.</h5>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileEngProof" type="file" accept=".jpg,.jpeg,.png" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#englishTest">
                        Official score report of English test
                      </a>
                    </div>
                    <div id="englishTest" class="collapse" data-parent="#accordionE">
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                <h5>Official score report of (please select one):</h5>

                                <form action="#">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" name="customRadio" class="custom-control-input" id="toefl" value="toefl">
                                    <label class="custom-control-label" for="toefl">TOEFL (Test of English as a Foreign Language)</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" name="customRadio" class="custom-control-input" id="ielts" value="ielts">
                                    <label class="custom-control-label" for="ielts">IELTS (International English Language Testing System)</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" name="customRadio" class="custom-control-input" id="gce" value="gce">
                                    <label class="custom-control-label" for="gce">GCE (General Certificate of Education)</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" name="customRadio" class="custom-control-input" id="igcse" value="igcse">
                                    <label class="custom-control-label" for="igcse">IGCSE (International General Certificate of Secondary Education)</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" name="customRadio" class="custom-control-input" id="cambridge" value="cambridge">
                                    <label class="custom-control-label" for="cambridge">Cambridge Test of Proficiency in English Language</label>
                                  </div>
                                </div>
                              </form>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileEngTest" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->

                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Other docs -->
          <div class="row">
            <div class="col-12">
              <div class="card d-block shadow-sm">
                <div class="card-header mt-2">
                  <p class="lead">Other documents</p>
                  If the programme you are applying requires other documents (e.g. CV), please upload here.
                </div>

                <div id="accordionO">
                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#other1">
                        Other #1
                      </a>
                    </div>
                    <div id="other1" class="collapse" data-parent="#accordionO">
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                
                                <div class="form-group">
                                  <label for="otherDoc1">What is this?</label>
                                  <input class="form-control" type="text" id="otherDoc1" placeholder="Enter the name of this document (e.g. CV)">
                                </div>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileOtherDoc1" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#other2">
                        Other #2
                      </a>
                    </div>
                    <div id="other2" class="collapse" data-parent="#accordionO">
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                
                                <div class="form-group">
                                  <label for="otherDoc2">What is this?</label>
                                  <input class="form-control" type="text" id="otherDoc2" placeholder="Enter the name of this document">
                                </div>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileOtherDoc2" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div> <!-- end of card mt-0 -->


                  <div class="card mt-0 mb-0">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#other3">
                        Other #3
                      </a>
                    </div>
                    <div id="other3" class="collapse" data-parent="#accordionO">
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-8">
                                
                                <div class="form-group">
                                  <label for="otherDoc3">What is this?</label>
                                  <input class="form-control" type="text" id="otherDoc3" placeholder="Enter the name of this document">
                                </div>
                              </div>

                              <div class="col-4 mb-4"> <!-- file upload -->
                                <form action="/" method="post">
                                  <input name="fileOtherDoc3" type="file" accept=".pdf" />
                                </form>
                              </div> <!-- end file upload -->
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div> <!-- end of card mt-0 -->

                </div>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12">
              <button type="button" class="btn btn-block btn-sm btn-primary">confirm and submit documents</button>
            </div>
          </div>

        </div> <!-- container -->

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

      </div>

      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->


    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=3"></script>

    <!-- Dropzone js -->
    <script src="<?php echo base_url(); ?>assets/js/vendor/dropzone.min.js"></script>

    <!-- File upload js -->
    <script src="<?php echo base_url(); ?>assets/js/ui/component.fileupload.js"></script>

    <script>
      $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
          $(this).popover('hide');
        }
      });
      });
    </script>

  </body>

  </html>