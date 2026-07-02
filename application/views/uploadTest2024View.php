<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - submission of supporting documents</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" />
  <!-- Dell 1996 redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/dell-1996.css" rel="stylesheet" type="text/css" />

  <!-- App css -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  
  <?php include_once APPPATH."config/userConstants.php"; ?>

  <script type="text/javascript">    
    window.history.forward();
    function noBack() 
    { 
      window.history.forward(); 
    }

    // 2025 - tick declaration before uploading doc 
    function declareA1() 
    {
      var checkBox = document.getElementById("declarationA1");
      var button = document.getElementById("submitA1");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }
    function declareA2() 
    {
      var checkBox = document.getElementById("declarationA2");
      var button = document.getElementById("submitA2");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }
    function declareA3() 
    {
      var checkBox = document.getElementById("declarationA3");
      var button = document.getElementById("submitA3");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }

    function declareB() 
    {
      var checkBox = document.getElementById("declarationB");
      var button = document.getElementById("submitB");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }
    
    function declareC1() 
    {
      var checkBox = document.getElementById("declarationC1");
      var button = document.getElementById("submitC1");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }
    function declareC2() 
    {
      var checkBox = document.getElementById("declarationC2");
      var button = document.getElementById("submitC2");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }
    function declareC3() 
    {
      var checkBox = document.getElementById("declarationC3");
      var button = document.getElementById("submitC3");
      button.style.display = (checkBox.checked == true) ? "block" : "none";
    }

    $(document).ready(function() 
    {
      $(":file").change(function()
      {
        $(this).addClass("fileAdded");
      });
    });
  </script>

  <style>
  .fileAdded 
  {
    background-color: #d9fcb6;
  }
  </style>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <a name="top"></a>

  <!-- Begin page -->
  <div class="wrapper">

<!--<div class="container-fluid">-->

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
                  <a href="<?php echo base_url(); ?>display/upload">upload documents</a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>display/summary">my upload summary</a>
                </li>
              </ul>
            </li>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/fillMarkSheet" class="side-nav-link">
                <i class="mdi mdi-grid-large"></i>
                <span>Fill mark sheet</span>
              </a>
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

    <div class="content-page">

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <button class="button-menu-mobile open-left disable-btn">
          <i class="mdi mdi-menu"></i>
        </button>
      </div>

      <!-- start page title -->
      <div class="row m-2">
        <div class="col-12">
          <div class="page-title-box">
            <h4 class="page-title text-primary">TPG admission - submission of supporting documents</h4>
            <p class="lead">The processing time of your application depends on its complexity and any additional informaiton required. This page will guide you in preparing and uploading all supporting documents in the correct format. You may upload the documents in multiple rounds if needed.</p>

            <div class="alert alert-info" role="alert">
              <i class="dripicons-warning"></i> <strong>File Upload Instructions</strong>:
              <ul>
                <li>You have 30 minutes for each upload section. Please login again if the page expires.</li>
                <li>Each <strong>Choose File</strong> option allows the selection of only one file for upload.</li>
                <li>• You can always replace an uploaded file by uploading another file for the same item. The previously uploaded document will be automatically replaced by the new one.</li>
                <li>Each page has its own <strong>Upload documents</strong> submission button. Clicking another tab without clicking <strong>Upload documents</strong> will reset any file sections that have not yet been uploaded.</li>
                <li>Each upload action is limited to a total of 8MB. For larger files, it is suggested to break them into multiple uploads.</li>
                <li>If you have other applications using the same login email address, this system will create copies for those applications after each upload, which may result in slightly longer uploading time.</li>
                <li>Upload the documents at your own pace. You can upload files one by one, by section, or login later to complete further uploads.</li>
                <li>Documents not in English should be accompanied by an offfically certified translation in English. If the original document included a side-by-side English translation, a separate translation copy is not necessary.</li>
                <li>PDF Guidelines:
                  <ul>
                    <li>Use PDF format for most of the documents</li>
                    <li>Secured / protected PDFs arenot allowed</li>
                    <li>Maximum file size: 3MB</li>
                  </ul>
                </li>
              </ul>
              <i class="dripicons-warning"></i> <strong>Definition of Local / Non-local students</strong>
              <p>According to the HKSAR Government's for education-related areas in the post-secondary education context, <strong>non-local</strong> students are those holding:</p>
              <ul>
                <li>A student visa/entry permit to study in Hong Kong</li>
                <li>A dependent visa / entry permit and were aged 18 years old or above when they were first issued with such documents by the Immigration Department of the HKSAR;</li>
                <li>A visa / entry permit under the Immigration Arrangements for Non-local Graduates (IANG), issued by the Director of Immigration of the Hong Kong Immigration Department</li>
                <li>VISA / entry permit for Top Talent Pass Scheme (高端人才通行證計劃)</li>
              </ul>
              <p>Applicants are considered a <strong>local</strong> student if they are none of the above.</p>
            </div>
          </div>
        </div>
      </div>     
      <!-- end page title --> 

      <div class="row m-2">
        <div class="col-12">
          <?php if (isset($_SESSION['info'])) {?>
            <div class="alert alert-warning"> <?php echo $_SESSION['info']; ?></div>
          <?php }?>

          <?php if (isset($_SESSION['error'])) {?>
            <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
          <?php }?>
        </div>
      </div>

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <h4 class="text-primary">Screen too small for file upload, please use a device with larger screen size.</h4>
      </div>
      <div class="row m-2 d-none d-md-block"> <!-- visible md and up -->
        <div class="col-md-12 col-md-offset-12 col-md-pull-12">
          <div class="card">
            <div class="card-body" id="tabs">
              <ul class="nav nav-pills bg-light" role="tablist">

                  <li class="nav-item">
                    <a href="#info-2" data-toggle="tab" role="tab" aria-expanded="true" class="nav-link active">
                      <span class="d-none d-lg-block">Academic studies</span>
                    </a>
                  </li>
                
                <li class="nav-item">
                  <a href="#info-3" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="d-none d-lg-block">English language requirements</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#info-4" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="d-none d-lg-block">Other documents</span>
                  </a>
                </li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane show active" id="info-2">

                  <div class="card">
                    <div class="card-body">
                      <ul class="nav nav-pills bg-light" role="tablist">
                        <?php for ($qset = 1; $qset <= MAX_fileDNO; $qset++) { ?>
                          <li class="nav-item">
                            <a href="#info-2<?php echo $qset; ?>" data-toggle="tab" role="tab" aria-expanded="<?php if ($qset == 1) echo 'true'; else echo 'false' ?>" class="nav-link <?php if ($qset == 1) echo 'active'; ?> <?php if ($qset > $Pno) echo 'disabled'; ?>">
                              
                                <span class="d-none d-lg-block <?php if ($qset > $Pno) echo 'text-muted'; ?>">Institution #<?php echo $qset; ?></span>
                                
                            </a>
                          </li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content">

                        <?php for ($qq = 0; $qq < $Pno; $qq++) { ?>
                          <?php $qset = $qq+1; ?>
                          <div class="tab-pane <?php if ($qset == 1)  echo 'show active'; ?>" id="info-2<?php echo $qset; ?>">
                            <form method="post" action="<?php echo base_url().'upload/uploadAllTest'; ?>" enctype="multipart/form-data">
                              <div class="col-12 mt-1">
                                <br/>
                              </div>
                              <div class="form-group text-left">
                                <div class="row">
                                  <div class="col-8">
                                    <label for="title<?php echo $qset; ?>"><h5 style="color:green;">Enter a reference tag (max 15 letters) for your institution <u><?php echo $degInfo['uni'][$qq]; ?></u> and degree <u><?php echo $degInfo['degree'][$qq]; ?></u> (short form is ok. e.g. BEng_NJU)</h5></label>
                                  </div>
                                  <div class="col-4">
                                    <input class="form-control" type="text" style="border: 2px solid green" name="title<?php echo $qset; ?>" id="title<?php echo $qset; ?>" required="yes" onkeypress="return isNumericKey(event)" value="<?php echo $titleArray[$qset]; ?>" maxlength="15">
                                  </div>
                                </div>
                              </div>

                              <ul class="list-group">

                                <?php if ($degInfo['isChina'][$qq] == 'Y') $endLoop = ($qq+1)*12; else $endLoop = $qq*12+7; ?>
                                <?php for ($i=$qq*12; $i<$endLoop; $i++) { ?>
                                  <li class="list-group-item">
                                    <div class="row">
                                      <div class="col-8">
                                        <div class="row">
                                          <div class="col-12">
                                            <h5><?php echo UPLOAD_ITEMS[$i][1]; ?>
                                              <?php if (UPLOAD_ITEMS[$i][2] != "") { ?>
                                                <span data-toggle="popover" html="true" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                                            </h5>
                                          </div>
                                        </div>
                                
                                        <div class="row mt-1">
                                          <?php if (UPLOAD_ITEMS[$i][4] != "") { ?>
                                            <div class="col-10"><!-- sample -->
                                              <div class="card shadow-sm"><!-- card -->
                                                <div class="card-body">
                                                  <div id="sample<?php echo UPLOAD_ITEMS[$i][0]; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <span><img src="<?php echo base_url().UPLOAD_ITEMS[$i][4]; ?>" alt=""></span>
                                                    </div>
                                                  </div>
                                                  <h5 class="card-title mb-0"><a href="#cardCollapse<?php echo UPLOAD_ITEMS[$i][0]; ?>" data-toggle="collapse">Sample</a></h5>
                                                  <div id="cardCollapse<?php echo UPLOAD_ITEMS[$i][0] ?>" class="collapse pt-3">
                                                    <img class="img-fluid mb-1" src="<?php echo base_url().UPLOAD_ITEMS[$i][4]; ?>" alt="">
                                                  </div>
                                                </div>
                                              </div><!-- end card -->
                                            </div><!-- end sample -->
                                          <?php } ?>
                                        </div>
                                      </div>
                                  
                                      <div class="col-4 mb-4"> <!-- file upload -->
                                        <?php if (UPLOAD_ITEMS[$i][1] != "") { ?>
                                          <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$i][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                                            <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                                          <?php } else if (in_array(UPLOAD_ITEMS[$i][0], $uploaded))   { $color = TRUE; ?>
                                            <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                                          <?php } else if (isset($fileErrCount)) { ?>
                                          <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                                          <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$i][0]) { $color = TRUE; ?>
                                            <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                                            <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php if ($showF)   { ?>
                                            <input name="<?php echo UPLOAD_ITEMS[$i][0]; ?>" type="file" id="<?php echo UPLOAD_ITEMS[$i][0]; ?>" accept="<?php echo UPLOAD_ITEMS[$i][3]; ?>" />
                                          <?php } ?>
                                          <?php if ($color)   { ?>
                                            </div>
                                          <?php } ?>
                                        <?php } ?>
                                      </div> <!-- end file upload -->
                                    </div>
                                  </li>
                                <?php } ?>
                              </ul>

                              <div class="row mb-4">
                                <div class="col-12">
                                  <br/>
                                </div>
                                <div class="col-12">
                                  <div class="form-group mt-2 mb-0 text-left">
                                    <div class="custom-control custom-checkbox mb-2">
                                      <input type="checkbox" class="custom-control-input" name="declarationA<?php echo $qset; ?>" id="declarationA<?php echo $qset; ?>" onclick="declareA<?php echo $qset; ?>()" value="tick"/>
                                      <label class="custom-control-label" for="declarationA<?php echo $qset; ?>"><strong>Declaration</strong><br/>I make the declaration as follows:<br/>
                                        <ul>
                                          <li>I declare that the information to be given in support of this application is accurate and complete, and I understand that any misrepresentation will disqualify my application to the University and the University has the right to make a report to the relevant law enforcement agencies which may result in criminal prosecution. I understand and agree that I am personally responsible for the authenticity of the application materials submitted to the University, whether by myself or an agent/intermediary appointed by me. </li>
                                          <li>I understand that The University of Hong Kong is a 'public body' and is therefore subject to the Prevention of Bribery Ordinance. </li>
                                          <li>I authorize The University of Hong Kong to obtain, and the relevant examination authorities, assessment bodies or academic institutions in Hong Kong and elsewhere to release any and all information about my public examination results, records of studies or professional qualifications. I also authorize the University to use my data in this form for the purpose of obtaining such information. </li>
                                          <li>I accept that all the data in this form and those the University is authorized to obtain will be used for purposes related to the processing and administration of my application in the university context.</li>
                                        </ul> 
                                        I note the general points pursuant to the Personal Data (Privacy) Ordinance as set out in the Personal Information Collection Statement and the General Data Protection Regulation.
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" id="submitA<?php echo $qset; ?>" style="display:none" value="Upload documents">Upload documents</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="info-3">
                  <form method="post" action="<?php echo base_url().'upload/uploadAllTest'; ?>" enctype="multipart/form-data">
                    <div class="row mt-1">
                      <div class="col-12">
                        <p>Applicants seeking admission based on qualification from a university or comparable institution outside of Hong Kong, where the language of instruction and/or examination is not English, is required to submit TOEFL / IELTS official score report. Click <a href="https://aal.hku.hk/tpg/english-language-requirements" target="_blank"><strong>here</strong></a> for detailed requirements from HKU.</p>
                      </div>
                    </div>
                    <?php $eng=36; ?>
                    <ul class="list-group">
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-8">
                            <div class="row">
                              <div class="col-12">
                                <h5><?php echo UPLOAD_ITEMS[$eng][1]; ?>
                                  <?php if (UPLOAD_ITEMS[$eng][2] != "") { ?>
                                  <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$eng][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                                </h5>
                              </div>
                            </div>

                            <div class="row mt-1">
                              <?php if (UPLOAD_ITEMS[$eng][4] != "") { ?>
                                <div class="col-10"><!-- sample -->
                                  <div class="card shadow-sm"><!-- card -->
                                    <div class="card-body">
                                      <div id="sample<?php echo UPLOAD_ITEMS[$eng][0]; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <span><img src="<?php echo base_url().UPLOAD_ITEMS[$eng][4]; ?>" alt=""></span>
                                        </div>
                                      </div>
                                      <h5 class="card-title mb-0"><a href="#cardCollapse<?php echo UPLOAD_ITEMS[$eng][0]; ?>" data-toggle="collapse">Sample</a></h5>
                                      <div id="cardCollapse<?php echo UPLOAD_ITEMS[$eng][0] ?>" class="collapse pt-3">
                                        <img class="img-fluid mb-1" src="<?php echo base_url().UPLOAD_ITEMS[$eng][4]; ?>" alt="">
                                      </div>
                                    </div>
                                  </div><!-- end card -->
                                </div><!-- end sample -->
                              <?php } ?>
                            </div>
                          </div>
                        
                          <div class="col-4 mb-4"> <!-- file upload -->
                            <div class="row">
                              <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$eng][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                                <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                              <?php } else if (in_array(UPLOAD_ITEMS[$eng][0], $uploaded))   { $color = TRUE; ?>
                                <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                              <?php } else if (isset($fileErrCount)) { ?>
                              <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                              <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$eng][0]) { $color = TRUE; ?>
                                <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                                <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                              <?php } ?>
                              <?php } ?>
                              <?php } ?>
                              <?php if ($showF)   { ?>
                                <input name="<?php echo UPLOAD_ITEMS[$eng][0]; ?>" type="file" id="<?php echo UPLOAD_ITEMS[$eng][0]; ?>" accept="<?php echo UPLOAD_ITEMS[$eng][3]; ?>" />
                              <?php } ?>
                              <?php if ($color)   { ?>
                                </div>
                              <?php } ?>
                            </div>
                          </div> <!-- end file upload -->
                        </div>
                      </li>

                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-8">
                            <h5><?php echo UPLOAD_ITEMS[$eng+1][1]; ?>
                              <?php if (UPLOAD_ITEMS[$eng+1][2] != "") { ?>
                                <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$eng+1][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                            </h5>
                          </div>

                          <div class="col-4">
                            <div class="row">
                              <h5>Please select one of the following options and upload the score report:</h5>
                              <div class="custom-control custom-radio">
                                <input type="radio" name="customRadio" class="custom-control-input" id="toefl" value="TOEFL">
                                <label class="custom-control-label" for="toefl">TOEFL (Test of English as a Foreign Language)</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="custom-control custom-radio">
                                <input type="radio" name="customRadio" class="custom-control-input" id="ielts" value="IELTS" checked>
                                <label class="custom-control-label" for="ielts">IELTS (International English Language Testing System)</label>
                              </div>
                            </div>
                            <div class="row mt-1"><!-- file upload -->
                              <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$eng+1][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                                <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                              <?php } else if (in_array(UPLOAD_ITEMS[$eng+1][0], $uploaded))   { $color = TRUE;  ?>
                                <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                              <?php } else if (isset($fileErrCount)) { ?>
                              <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                              <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$eng+1][0]) { $color = TRUE; ?>
                                <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                                <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                              <?php } ?>
                              <?php } ?>
                              <?php } ?>
                              <?php if ($showF)   { ?>
                                <input name="<?php echo UPLOAD_ITEMS[$eng+1][0]; ?>" type="file" id="<?php echo UPLOAD_ITEMS[$eng+1][0]; ?>" accept="<?php echo UPLOAD_ITEMS[$eng+1][3]; ?>" />
                              <?php } ?>
                              <?php if ($color)   { ?>
                                </div>
                              <?php } ?>
                            </div> <!-- end file upload -->
                          </div>
                        </div>
                      </li>
                    </ul>

                    <div class="row mb-4">
                      <div class="col-12">
                        <br/>
                      </div>
                      <div class="col-12">
                        <div class="form-group mt-2 mb-0 text-left">
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" name="declarationB" id="declarationB" onclick="declareB()" value="tick"/>
                            <label class="custom-control-label" for="declarationB"><strong>Declaration</strong><br/>I make the declaration as follows:<br/>
                              <ul>
                                <li>I declare that the information to be given in support of this application is accurate and complete, and I understand that any misrepresentation will disqualify my application to the University and the University has the right to make a report to the relevant law enforcement agencies which may result in criminal prosecution. I understand and agree that I am personally responsible for the authenticity of the application materials submitted to the University, whether by myself or an agent/intermediary appointed by me. </li>
                                <li>I understand that The University of Hong Kong is a 'public body' and is therefore subject to the Prevention of Bribery Ordinance. </li>
                                <li>I authorize The University of Hong Kong to obtain, and the relevant examination authorities, assessment bodies or academic institutions in Hong Kong and elsewhere to release any and all information about my public examination results, records of studies or professional qualifications. I also authorize the University to use my data in this form for the purpose of obtaining such information. </li>
                                <li>I accept that all the data in this form and those the University is authorized to obtain will be used for purposes related to the processing and administration of my application in the university context.</li>
                              </ul> 
                              I note the general points pursuant to the Personal Data (Privacy) Ordinance as set out in the Personal Information Collection Statement and the General Data Protection Regulation.
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" id="submitB" style="display:none" value="Upload documents">Upload documents</button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="tab-pane" id="info-4">
                  <div class="row mt-1">
                    <div class="col-12">
                      <p>Use this section to upload other documents requested by departmental administration. If in doubt, please check with department before upload.</p>
                    </div>
                  </div>
                  
                <?php for ($other = 0; $other < 3; $other++) { 
                  $i = 38 + $other; ?>
                  
                  <!-- upload modal-->
                  <div id="otherUploadForm<?php echo $other+1; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card">

                            <div class="card-body p-4">
                              <div class="text-center w-80 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Upload <?php echo UPLOAD_ITEMS[$i][1]; ?></h4>
                              </div>

                              <form method="post" action="<?php echo base_url().'upload/uploadAllTest'; ?>" enctype="multipart/form-data">
                                <div class="form-group text-left">
                                  <div class="row">
                                    <label for="other<?php echo UPLOAD_ITEMS[$i][0]; ?>">What are you uploading?</label>
                                    <input class="form-control" type="text" name="other<?php echo UPLOAD_ITEMS[$i][0]; ?>" id="other<?php echo UPLOAD_ITEMS[$i][0]; ?>" required="yes" placeholder="description" maxlength="12">
                                  </div>
                        
                                  <div class="row"> <!-- file upload -->
                                    <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$i][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                                      <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                                    <?php } else if (in_array(UPLOAD_ITEMS[$i][0], $uploaded))   { $color = TRUE; ?>
                                      <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                                    <?php } else if (isset($fileErrCount)) { ?>
                                    <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                                    <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$i][0]) { $color = TRUE; ?>
                                      <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                                      <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                      <?php if ($showF)   { ?>
                                        <input name="<?php echo UPLOAD_ITEMS[$i][0]; ?>" type="file" id="<?php echo UPLOAD_ITEMS[$i][0]; ?>" accept="<?php echo UPLOAD_ITEMS[$i][3]; ?>" />
                                    <?php } ?>
                                    <?php if ($color)   { ?>
                                      </div>
                                    <?php } ?>
                                  </div> <!-- end file upload -->
                                </div>
                                
                                <div class="col-12">
                                  <br/>
                                </div>
                                <div class="col-12">
                                  <div class="form-group mt-2 mb-0 text-left">
                                    <div class="custom-control custom-checkbox mb-2">
                                      <input type="checkbox" class="custom-control-input" name="declarationC<?php echo $other+1; ?>" id="declarationC<?php echo $other+1; ?>" onclick="declareC<?php echo $other+1; ?>()" value="tick"/>
                                      <label class="custom-control-label" for="declarationC<?php echo $other+1; ?>"><strong>Declaration</strong><br/>I make the declaration as follows:<br/>
                                        <ul>
                                          <li>I declare that the information to be given in support of this application is accurate and complete, and I understand that any misrepresentation will disqualify my application to the University and the University has the right to make a report to the relevant law enforcement agencies which may result in criminal prosecution. I understand and agree that I am personally responsible for the authenticity of the application materials submitted to the University, whether by myself or an agent/intermediary appointed by me. </li>
                                          <li>I understand that The University of Hong Kong is a 'public body' and is therefore subject to the Prevention of Bribery Ordinance. </li>
                                          <li>I authorize The University of Hong Kong to obtain, and the relevant examination authorities, assessment bodies or academic institutions in Hong Kong and elsewhere to release any and all information about my public examination results, records of studies or professional qualifications. I also authorize the University to use my data in this form for the purpose of obtaining such information. </li>
                                          <li>I accept that all the data in this form and those the University is authorized to obtain will be used for purposes related to the processing and administration of my application in the university context.</li>
                                        </ul> 
                                        I note the general points pursuant to the Personal Data (Privacy) Ordinance as set out in the Personal Information Collection Statement and the General Data Protection Regulation.
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group text-center">
                                  <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" id="submitC<?php echo $other+1; ?>" style="display:none" value="Upload document">Upload document</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                  <div class="row">
                    <div class="col-8">
                      <h5><?php echo UPLOAD_ITEMS[$i][1]; ?>
                      <?php if (UPLOAD_ITEMS[$i][2] != "") { ?>
                        <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                      </h5>
                    </div>
                    
                    <div class="col-4">
                      <div class="row"> <!-- file upload -->
                        <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$i][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                          <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                        <?php } else if (in_array(UPLOAD_ITEMS[$i][0], $uploaded))   { $color = TRUE; ?>
                          <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                        <?php } else if (isset($fileErrCount)) { ?>
                        <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                        <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$i][0]) { $color = TRUE; ?>
                          <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                          <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($showF)   { ?>
                          <button type="button" class="btn btn-light" data-toggle="modal" data-target="#otherUploadForm<?php echo $other+1; ?>">upload file</button>
                        <?php } ?>
                        <?php if ($color)   { ?>
                          </div>
                        <?php } ?>
                      </div> <!-- end file upload -->
                    </div>
                  </div>
                
              <?php } ?>
                  
                </div>
              </div> <!-- end tab-content -->

            </div> <!-- end card-body -->
          </div> <!-- end card -->
        </div>
      </div> <!-- end row -->

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
  </div>

  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script>
  
  $("[data-toggle=popover]").popover({trigger:"hover", html:"true"});

  function isNumericKey(evt)
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        (charCode >=97 && charCode <= 122) || 
        (charCode >=48 && charCode <= 57) || charCode == 95)
    return true;

    return false;
  } 


  // has error
  /*
  $(document).ready(function()
  {
    $(":submit").attr('disabled', 'disabled');
    var count = 0;

    $("#tabs").on("click", function()
    {
      count = 0;
      $(":submit").attr('disabled', 'disabled');

      $(":file").each(function()
      {
        $(this).val(null);
      });
    }
    );

    $(":file").each(function()
    {
      $(this).change(function()
      {
        if ($(this).val())
        {
          count++;
        }
        else
          count--;

        if (count > 0)
          $(":submit").removeAttr('disabled');
        else
          $(":submit").attr('disabled', 'disabled');
        
      });
    });
          
  });
  */
  </script>
  </body>
</html>
