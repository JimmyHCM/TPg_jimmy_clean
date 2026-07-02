<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - submission of supporting documents</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css" rel="stylesheet" type="text/css" />

  <!-- App css -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  
  <?php include_once APPPATH."config/userConstants.php"; ?>

  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
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
            <p class="lead">The processing time of your application depends on the complexity of your application and on the need for further information. This page will guide you to prepare and upload all supporting documents in the proper format. It is ok to break down the upload into a few rounds.</p>

            <div class="alert alert-info" role="alert">
              <i class="dripicons-warning"></i> <strong>About file upload</strong>:
              <ul>
                <li>You have 30 minutes for each upload section. Please login again if the page expired.</li>
                <li>Each <strong>Choose File</strong> only allows the selection of one file for upload.</li>
                <li>You can always replace an uploaded file by uploading another file to the same item a second time. The previous uploaded document will be automatically replaced by the new one.</li>
                <li>Each page has its own <strong>Upload documents</strong> submission button, clicking another tab without clicking <strong>Upload documents</strong> will reset all not yet uploaded file selections.</li>
                <li>A total of 8MB is limited for each upload action. If you have large files, it is suggested to break into a few uploads.</li>
                <li>Do the upload at your own pace. It is ok to upload file by file, or section by section, or login at another time to do further uploads.</li>
                <li>Documents which are not in English should be accompanied by a formally certified translation in English. If the original document has English translation side-by-side, there is no need to prepare a separate translation copy.</li>
                <li>jpg / jpeg / png 
                  <ul>
                    <li>supported for most of the documents</li>
                    <li>dimension must be at least: 1200 x 1700 pixels</li>
                    <li>max size: 2MB</li>
                  </ul>
                </li>
                <li>pdf
                  <ul>
                    <li>for transcript and other documents</li>
                    <li>max size: 3MB</li>
                  </ul>
                </li>
              </ul>
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
                <?php if ($_SESSION['currentStatus'] == "1") { ?>
                <li class="nav-item">
                  <a href="#info-1" data-toggle="tab" role="tab" aria-expanded="true" class="nav-link active">
                    <span class="d-none d-lg-block">Academic qualification<br/>Current academic studies</span>
                  </a>
                </li>
                <?php } ?>

                  <li class="nav-item">
                    <a href="#info-2" data-toggle="tab" role="tab" aria-expanded="<?php if ($_SESSION['currentStatus'] == "2") echo 'true'; else echo 'false'; ?>" class="nav-link <?php if ($_SESSION['currentStatus'] == "2") echo 'active'; ?>">
                      <span class="d-none d-lg-block">Previous academic studies<br/>Qualification obtained</span>
                    </a>
                  </li>
                
                <li class="nav-item">
                  <a href="#info-3" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="d-none d-lg-block"><br/>English language requirements</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#info-4" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="d-none d-lg-block"><br/>Other documents</span>
                  </a>
                </li>
              </ul>

              <div class="tab-content">
                <?php if ($_SESSION['currentStatus'] == "1") { ?>
                <div class="tab-pane show active" id="info-1">
                  <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">

                    <br/>
                    <div class="form-group text-left">
                      <div class="row">
                        <div class="col-8">
                          <label for="title0"><h5>Institution and degree obtained (max 15 characters, as a reference tag, short form is ok. e.g. BEng_PolyU)</h5></label>
                        </div>
                        <div class="col-4">
                          <input class="form-control" type="text" name="title0" id="title0" required="yes" onkeypress="return isNumericKey(event)" value="<?php echo $titleArray[0]; ?>" maxlength="15">
                        </div>
                      </div>
                    </div>

                    <ul class="list-group">
                      <?php for ($i = 0; $i < 6; $i++) { ?>
                        <li class="list-group-item">
                          <?php if (UPLOAD_ITEMS[$i][1] != "") { ?>
                            <div class="row">
                              <div class="col-8">
                                <div class="row">
                                <div class="col-12">
                                  <h5><?php echo UPLOAD_ITEMS[$i][1]; ?>
                                    <?php if (UPLOAD_ITEMS[$i][2] != "") { ?>
                                    <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
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
                          <?php } ?>
                        </li>
                      <?php } ?>
                    </ul>

                    <div class="row mb-4">
                      <div class="col-12">
                        <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" value="Upload documents">Upload documents</button>
                      </div>
                    </div>
                  </form>
                </div>
                <?php } ?>

                <div class="tab-pane <?php if ($_SESSION['currentStatus'] == "2") echo 'show active'; ?>" id="info-2">

                  <div class="card">
                    <div class="card-body">
                      <ul class="nav nav-pills bg-light" role="tablist">
                        <?php for ($qset = 1; $qset <= MAX_filePNO; $qset++) { ?>
                          <li class="nav-item">
                            <a href="#info-2<?php echo $qset; ?>" data-toggle="tab" role="tab" aria-expanded="<?php if ($qset == 1) echo 'true'; else echo 'false' ?>" class="nav-link <?php if ($qset == 1) echo 'active'; ?> <?php if ($qset > $Pno) echo 'disabled'; ?>">
                              
                                <span class="d-none d-lg-block <?php if ($qset > $Pno) echo 'text-muted'; ?>">Qualification #<?php echo $qset; ?></span>
                                
                            </a>
                          </li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content">
                        <?php for ($qq = 0; $qq < $Pno; $qq++) { ?>
                          <?php $qset = $qq+1; ?>
                          <div class="tab-pane <?php if ($qset == 1)  echo 'show active'; ?>" id="info-2<?php echo $qset; ?>">
                            <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">
                              <div class="col-12 mt-1">
                                <p><strong>Note</strong> The proof of successful confirmation of the award shall be effective by <?php echo $effectiveByDate; ?>.</p>
                                <?php if ($qset == 1) { ?>
                                  <p>If you have obtained other academic qualifications on or before <?php echo $effectiveByDate; ?>, please upload ALL supporting documents (jpg / pdf). Each block (Qualification obtained #n) corresponds to the set of documents for one qualification obtained. A new block will be enabled after you have uploaded a set of documents.</p>
                                <?php } ?>

                                <br/>
                              </div>
                              <div class="form-group text-left">
                                <div class="row">
                                  <div class="col-8">
                                    <label for="title<?php echo $qset; ?>"><h5>Institution and degree obtained (max 15 characters, as a reference tag, short form is ok. e.g. BEng_NJU)</h5></label>
                                  </div>
                                  <div class="col-4">
                                    <input class="form-control" type="text" name="title<?php echo $qset; ?>" id="title<?php echo $qset; ?>" required="yes" onkeypress="return isNumericKey(event)" value="<?php echo $titleArray[$qset]; ?>" maxlength="15">
                                  </div>
                                </div>
                              </div>

                              <ul class="list-group">
                                <?php for ($i = $qq*10+6; $i < $qq*10+16; $i=$i+2) { ?>
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

                                    <div class="row">
                                      <div class="col-8">
                                        <div class="row">
                                          <div class="col-12">
                                            <h5><?php echo UPLOAD_ITEMS[$i+1][1]; ?>
                                              <?php if (UPLOAD_ITEMS[$i+1][2] != "") { ?>
                                                <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i+1][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                                            </h5>
                                          </div>
                                        </div>
                                  
                                        <div class="row mt-1">
                                          <?php if (UPLOAD_ITEMS[$i+1][4] != "") { ?>
                                            <div class="col-10"><!-- sample -->
                                              <div class="card shadow-sm"><!-- card -->
                                                <div class="card-body">
                                                  <div id="sample<?php echo UPLOAD_ITEMS[$i+1][0]; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <span><img src="<?php echo base_url().UPLOAD_ITEMS[$i+1][4]; ?>" alt=""></span>
                                                    </div>
                                                  </div>
                                                  <h5 class="card-title mb-0"><a href="#cardCollapse<?php echo UPLOAD_ITEMS[$i+1][0]; ?>" data-toggle="collapse">Sample</a></h5>
                                                  <div id="cardCollapse<?php echo UPLOAD_ITEMS[$i+1][0] ?>" class="collapse pt-3">
                                                    <img class="img-fluid mb-1" src="<?php echo base_url().UPLOAD_ITEMS[$i+1][4]; ?>" alt="">
                                                  </div>
                                                </div>
                                              </div><!-- end card -->
                                            </div><!-- end sample -->
                                          <?php } ?>
                                        </div>
                                      </div>
                                  
                                      <div class="col-4 mb-4"> <!-- file upload -->
                                        <?php if (UPLOAD_ITEMS[$i+1][1] != "") { ?>
                                          <?php $showF = TRUE; $color = FALSE; if (in_array(UPLOAD_ITEMS[$i+1][0], $verified))   { $showF = FALSE; $color = TRUE; ?>
                                            <div class="alert alert-warning" role="alert"><strong>document has already been verified and accepted by department</strong>.
                                          <?php } else if (in_array(UPLOAD_ITEMS[$i+1][0], $uploaded))   { $color = TRUE; ?>
                                            <div class="alert alert-info" role="alert"><strong>file previously uploaded</strong>. If you upload again, the old file will be overwritten by the new one.
                                          <?php } else if (isset($fileErrCount)) { ?>
                                          <?php for ($jj=0; $jj<$fileErrCount; $jj++) { ?>
                                          <?php if ($fileErr[$jj][0] == UPLOAD_ITEMS[$i+1][0]) { $color = TRUE; ?>
                                            <div class="alert alert-danger" role="alert"><strong>file upload error</strong>:
                                            <?php echo $fileErr[$jj][1].' '.$fileErr[$jj][2]; ?>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php } ?>
                                            <?php if ($showF)   { ?>
                                              <input name="<?php echo UPLOAD_ITEMS[$i+1][0]; ?>" type="file" id="<?php echo UPLOAD_ITEMS[$i+1][0]; ?>" accept="<?php echo UPLOAD_ITEMS[$i+1][3]; ?>" />
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
                                  <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" value="Upload documents">Upload documents</button>
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
                  <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">
                    <div class="row mt-1">
                      <div class="col-12">
                        <p>If your institution is outside Hong Kong, please submit one of the followings. Click <a href="https://aal.hku.hk/tpg/english-language-requirements" target="_blank"><strong>here</strong></a> for details of the requirements from HKU.</p>
                      </div>
                    </div>
                    <?php $eng=56; ?>
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
                              <h5>Select one and then upload the score report</h5>
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
                            <div class="row">
                              <div class="custom-control custom-radio">
                                <input type="radio" name="customRadio" class="custom-control-input" id="gce" value="GCE">
                                <label class="custom-control-label" for="gce">GCE (General Certificate of Education)</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="custom-control custom-radio">
                                <input type="radio" name="customRadio" class="custom-control-input" id="igcse" value="IGCSE">
                                <label class="custom-control-label" for="igcse">IGCSE (International General Certificate of Secondary Education)</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="custom-control custom-radio">
                                <input type="radio" name="customRadio" class="custom-control-input" id="cambridge" value="cambr">
                                <label class="custom-control-label" for="cambridge">Cambridge Test of Proficiency in English Language</label>
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
                        <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" value="Upload documents">Upload documents</button>
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
                  $i = 58 + $other; ?>
                  
                  <!-- upload modal-->
                  <div id="otherUploadForm<?php echo $other+1; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="card">

                            <div class="card-body p-4">
                              <div class="text-center w-80 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Upload <?php echo UPLOAD_ITEMS[$i][1]; ?></h4>
                              </div>

                              <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">
                                <div class="form-group text-left">
                                  <div class="row">
                                    <label for="other<?php echo UPLOAD_ITEMS[$i][1]; ?>">What are you uploading?</label>
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
                                <div class="form-group text-center">
                                  <button class="btn btn-block btn-sm btn-primary" type="submit" name="submit" value="Upload document">Upload document</button>
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
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js"></script>
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
