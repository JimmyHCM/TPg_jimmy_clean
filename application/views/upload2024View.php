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
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=3" rel="stylesheet" type="text/css" />

  <!-- App css -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>

  <?php include_once APPPATH."config/userConstants.php"; ?>

  <script type="text/javascript">
    window.history.forward();
    function noBack()
    {
      window.history.forward();
    }

    // tick declaration before uploading doc — shows the submit button.
    // Checkbox ids/names and button ids are unchanged from the original flow.
    function tpDeclare(sfx)
    {
      var checkBox = document.getElementById("declaration" + sfx);
      var button = document.getElementById("submit" + sfx);
      var hint = document.getElementById("hint" + sfx);
      button.style.display = (checkBox.checked == true) ? "block" : "none";
      if (hint) hint.style.display = (checkBox.checked == true) ? "none" : "block";
    }

    $(document).ready(function()
    {
      $(":file").change(function()
      {
        $(this).toggleClass("fileAdded", !!this.value);

        // live counter of selected-but-not-yet-uploaded files per form
        var form = $(this).closest("form");
        var n = form.find(":file").filter(function() { return !!this.value; }).length;
        form.find(".tp-file-counter").text(n > 0 ? " (" + n + " file" + (n > 1 ? "s" : "") + " selected)" : "");
        var badge = form.find(".tp-ready-badge");
        if (n > 0) { badge.show().find("b").text(n); } else { badge.hide(); }
      });
    });
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

          <!-- testing purpose -->
          <?php if (strpos ($menu, 'T') !== false) { ?>
            <li class="side-nav-item">
              <a href="<?php echo base_url(); ?>display/uploadTest" class="side-nav-link">
                <i class="mdi mdi-email-outline"></i>
                <span> Testing (Marian) </span>
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

<?php
/* -------------------------------------------------------------------------
   View-level helpers (presentation only — the upload state logic below is
   behaviour-compatible with the original in_array($verified / $uploaded /
   $fileErr) checks; no field names, form actions or accepted formats change).
   ------------------------------------------------------------------------- */
if (!function_exists('tpItemState'))
{
  function tpItemState ($key, $verified, $uploaded, $fileErr, $fileErrCount)
  {
    $state = array ('show' => TRUE, 'status' => 'pending', 'msg' => '');
    if (in_array ($key, $verified))
    {
      $state['show'] = FALSE;
      $state['status'] = 'verified';
    }
    else if (in_array ($key, $uploaded))
    {
      $state['status'] = 'uploaded';
    }
    else
    {
      for ($jj = 0; $jj < $fileErrCount; $jj++)
        if ($fileErr[$jj][0] == $key)
        {
          $state['status'] = 'error';
          $state['msg'] .= $fileErr[$jj][1].' '.$fileErr[$jj][2].' ';
        }
    }
    return $state;
  }

  function tpStatusChip ($state)
  {
    switch ($state['status'])
    {
      case 'verified':
        echo '<div class="tp-status tp-status-verified"><i class="mdi mdi-checkbox-marked-circle"></i> Verified &amp; accepted</div>';
        echo '<p class="tp-status-note">Already verified by the department &mdash; no further upload needed.</p>';
        break;
      case 'uploaded':
        echo '<div class="tp-status tp-status-uploaded"><i class="mdi mdi-cloud-check"></i> Uploaded</div>';
        echo '<p class="tp-status-note">Uploading again will replace the previous file.</p>';
        break;
      case 'error':
        echo '<div class="tp-status tp-status-error"><i class="mdi mdi-alert-circle"></i> Upload error</div>';
        echo '<p class="tp-status-note tp-status-note-error">'.$state['msg'].'</p>';
        break;
      default:
        echo '<div class="tp-status tp-status-pending"><i class="mdi mdi-upload"></i> Not uploaded yet</div>';
    }
  }

  function tpFileInput ($item)
  {
    echo '<input name="'.$item[0].'" type="file" id="'.$item[0].'" accept="'.$item[3].'" />';
  }

  function tpDeclaration ($sfx, $buttonLabel)
  {
    ?>
    <div class="tp-declare mt-4">
      <h6 class="tp-declare-title"><i class="mdi mdi-square-edit-outline"></i> Declaration</h6>
      <div class="tp-declare-text">
        I make the declaration as follows:
        <ul>
          <li>I declare that the information to be given in support of this application is accurate and complete, and I understand that any misrepresentation will disqualify my application to the University and the University has the right to make a report to the relevant law enforcement agencies which may result in criminal prosecution. I understand and agree that I am personally responsible for the authenticity of the application materials submitted to the University, whether by myself or an agent/intermediary appointed by me. </li>
          <li>I understand that The University of Hong Kong is a 'public body' and is therefore subject to the Prevention of Bribery Ordinance. </li>
          <li>I authorize The University of Hong Kong to obtain, and the relevant examination authorities, assessment bodies or academic institutions in Hong Kong and elsewhere to release any and all information about my public examination results, records of studies or professional qualifications. I also authorize the University to use my data in this form for the purpose of obtaining such information. </li>
          <li>I accept that all the data in this form and those the University is authorized to obtain will be used for purposes related to the processing and administration of my application in the university context.</li>
        </ul>
        I note the general points pursuant to the Personal Data (Privacy) Ordinance as set out in the Personal Information Collection Statement and the General Data Protection Regulation.
      </div>
      <div class="custom-control custom-checkbox mt-3">
        <input type="checkbox" class="custom-control-input" name="declaration<?php echo $sfx; ?>" id="declaration<?php echo $sfx; ?>" onclick="tpDeclare('<?php echo $sfx; ?>')" value="tick"/>
        <label class="custom-control-label" for="declaration<?php echo $sfx; ?>"><strong>I have read and agree to the declaration above.</strong></label>
      </div>
      <p class="tp-declare-hint" id="hint<?php echo $sfx; ?>"><i class="mdi mdi-arrow-up"></i> Tick the declaration to enable the upload button.</p>
      <button class="btn btn-primary btn-lg tpg-btn-block mt-2" type="submit" name="submit" id="submit<?php echo $sfx; ?>" style="display:none" value="<?php echo $buttonLabel; ?>"><i class="mdi mdi-cloud-upload"></i> <?php echo $buttonLabel; ?><span class="tp-file-counter"></span></button>
    </div>
    <?php
  }
}

/* ---- progress overview, computed from data the page already receives ---- */
$tpErr      = isset ($fileErrCount) ? $fileErr : array ();
$tpErrCount = isset ($fileErrCount) ? $fileErrCount : 0;
$tpDoneSet  = array_merge ($verified, $uploaded);

$tpSections = array ();
$tpAcadT = 0; $tpAcadD = 0;
for ($qq = 0; $qq < $Pno; $qq++)
{
  $isChina = (isset ($degInfo['isChina'][$qq]) && $degInfo['isChina'][$qq] == 'Y');
  $endLoop = $isChina ? ($qq+1)*12 : $qq*12+7;
  $t = 0; $d = 0;
  for ($i = $qq*12; $i < $endLoop; $i++)
  {
    if (UPLOAD_ITEMS[$i][1] == "") continue;
    $t++;
    if (in_array (UPLOAD_ITEMS[$i][0], $tpDoneSet)) $d++;
  }
  $tpSections[] = array ('label' => 'Institution #'.($qq+1), 't' => $t, 'd' => $d);
  $tpAcadT += $t; $tpAcadD += $d;
}

$tpEngT = 0; $tpEngD = 0;
for ($i = 36; $i <= 37; $i++)
{
  if (UPLOAD_ITEMS[$i][1] == "") continue;
  $tpEngT++;
  if (in_array (UPLOAD_ITEMS[$i][0], $tpDoneSet)) $tpEngD++;
}

$tpOthT = 0; $tpOthD = 0;
for ($i = 38; $i <= 40; $i++)
{
  if (UPLOAD_ITEMS[$i][1] == "") continue;
  $tpOthT++;
  if (in_array (UPLOAD_ITEMS[$i][0], $tpDoneSet)) $tpOthD++;
}

$tpTotal = $tpAcadT + $tpEngT + $tpOthT;
$tpDone  = $tpAcadD + $tpEngD + $tpOthD;
$tpPct   = ($tpTotal > 0) ? (int) round ($tpDone * 100 / $tpTotal) : 0;
$tpDash  = round (213.6 * $tpPct / 100, 1);   // donut circumference 2*pi*34
?>

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
            <h4 class="page-title">Supporting documents</h4>
            <p class="lead mb-0">Upload at your own pace &mdash; one by one, by section, or across multiple sign-ins. A new upload for the same item simply replaces the old file.</p>
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

      <!-- overview: key rules + progress -->
      <div class="row m-2 d-none d-md-flex">
        <div class="col-xl-8 d-flex">
          <div class="card tp-rules-card flex-fill">
            <div class="card-body">
              <h5 class="tp-card-heading"><i class="mdi mdi-shield-outline"></i> Key rules at a glance</h5>
              <div class="tp-rules">
                <div class="tp-rule"><i class="mdi mdi-file-pdf-box"></i><span><strong>PDF preferred</strong><br>max 3MB, not password-protected</span></div>
                <div class="tp-rule"><i class="mdi mdi-package-variant-closed"></i><span><strong>8MB per upload</strong><br>split large batches into rounds</span></div>
                <div class="tp-rule"><i class="mdi mdi-timer-sand"></i><span><strong>30-min session</strong><br>per upload section, then re-login</span></div>
                <div class="tp-rule"><i class="mdi mdi-autorenew"></i><span><strong>Re-upload = replace</strong><br>the newest file always wins</span></div>
                <div class="tp-rule"><i class="mdi mdi-translate"></i><span><strong>English required</strong><br>certified translation if original isn't</span></div>
                <div class="tp-rule"><i class="mdi mdi-gesture-tap"></i><span><strong>Submit per section</strong><br>each tab has its own upload button</span></div>
              </div>
              <div class="mt-3">
                <a class="tp-collapse-link" data-toggle="collapse" href="#tpFullRules" role="button" aria-expanded="false">
                  <i class="mdi mdi-chevron-down"></i> Full upload instructions
                </a>
                <span class="tp-collapse-sep">&middot;</span>
                <a class="tp-collapse-link" data-toggle="collapse" href="#tpLocalDef" role="button" aria-expanded="false">
                  <i class="mdi mdi-chevron-down"></i> Local / non-local definition
                </a>
              </div>
              <div class="collapse" id="tpFullRules">
                <div class="tp-collapse-body">
                  <ul>
                    <li>You have 30 minutes for each upload section. Please login again if the page expires.</li>
                    <li>Each <strong>Choose File</strong> option allows the selection of only one file for upload.</li>
                    <li>You can always replace an uploaded file by uploading another file for the same item. The previously uploaded document will be automatically replaced by the new one.</li>
                    <li>Each page has its own <strong>Upload documents</strong> submission button. Clicking another tab without clicking <strong>Upload documents</strong> will reset any file sections that have not yet been uploaded.</li>
                    <li>Each upload action is limited to a total of 8MB. For larger files, it is suggested to break them into multiple uploads.</li>
                    <li>Upload the documents at your own pace. You can upload files one by one, by section, or login later to complete further uploads.</li>
                    <li>Documents not in English should be accompanied by an officially certified translation in English. If the original document included a side-by-side English translation, a separate translation copy is not necessary.</li>
                    <li>PDF Guidelines:
                      <ul>
                        <li>Use PDF format for most of the documents</li>
                        <li>Secured / protected PDFs are not allowed</li>
                        <li>Maximum file size: 3MB</li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="collapse" id="tpLocalDef">
                <div class="tp-collapse-body">
                  <p>According to the HKSAR Government's for education-related areas in the post-secondary education context, <strong>non-local</strong> students are those holding:</p>
                  <ul>
                    <li>A student visa/entry permit to study in Hong Kong</li>
                    <li>A dependent visa / entry permit and were aged 18 years old or above when they were first issued with such documents by the Immigration Department of the HKSAR;</li>
                    <li>A visa / entry permit under the Immigration Arrangements for Non-local Graduates (IANG), issued by the Director of Immigration of the Hong Kong Immigration Department</li>
                    <li>VISA / entry permit for Top Talent Pass Scheme (&#39640;&#31471;&#20154;&#25165;&#36890;&#34892;&#35657;&#35336;&#21123;)</li>
                  </ul>
                  <p class="mb-0">Applicants are considered a <strong>local</strong> student if they are none of the above.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4 d-flex">
          <div class="card tp-progress-card flex-fill">
            <div class="card-body">
              <h5 class="tp-card-heading"><i class="mdi mdi-chart-donut"></i> Your progress</h5>
              <div class="tp-progress-wrap">
                <svg viewBox="0 0 84 84" class="tp-donut" role="img" aria-label="<?php echo $tpPct; ?> percent of documents submitted">
                  <defs>
                    <linearGradient id="tpDonutGrad" x1="0" y1="0" x2="1" y2="1">
                      <stop offset="0" stop-color="#12995F"/>
                      <stop offset="1" stop-color="#14C9A0"/>
                    </linearGradient>
                  </defs>
                  <circle cx="42" cy="42" r="34" class="tp-donut-track"/>
                  <circle cx="42" cy="42" r="34" class="tp-donut-fill" stroke="url(#tpDonutGrad)"
                          stroke-dasharray="<?php echo $tpDash; ?> 213.6" transform="rotate(-90 42 42)"/>
                  <text x="42" y="40" text-anchor="middle" class="tp-donut-num"><?php echo $tpPct; ?>%</text>
                  <text x="42" y="52" text-anchor="middle" class="tp-donut-sub">submitted</text>
                </svg>
                <div class="tp-progress-stats">
                  <div class="tp-stat"><span class="tp-stat-num"><?php echo $tpDone; ?><span class="tp-stat-of">/<?php echo $tpTotal; ?></span></span><span class="tp-stat-label">documents submitted</span></div>
                  <ul class="tp-progress-list">
                    <?php foreach ($tpSections as $sec) { ?>
                      <li><span><?php echo $sec['label']; ?></span><b class="<?php echo ($sec['d'] >= $sec['t']) ? 'tp-complete' : ''; ?>"><?php echo $sec['d']; ?>/<?php echo $sec['t']; ?></b></li>
                    <?php } ?>
                    <li><span>English requirements</span><b class="<?php echo ($tpEngD >= $tpEngT) ? 'tp-complete' : ''; ?>"><?php echo $tpEngD; ?>/<?php echo $tpEngT; ?></b></li>
                    <li><span>Other documents</span><b class="<?php echo ($tpOthD >= $tpOthT) ? 'tp-complete' : ''; ?>"><?php echo $tpOthD; ?>/<?php echo $tpOthT; ?></b></li>
                  </ul>
                </div>
              </div>
              <p class="tp-progress-note mb-0"><i class="mdi mdi-information-outline"></i> Only items that apply to you need to be uploaded &mdash; "if applicable" documents can stay empty.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- end overview -->

      <div class="row m-2 d-md-none d-lg-none d-xl-none"> <!-- visible sm and down -->
        <h4 class="text-primary">Screen too small for file upload, please use a device with larger screen size.</h4>
      </div>
      <div class="row m-2 d-none d-md-block"> <!-- visible md and up -->
        <div class="col-md-12 col-md-offset-12 col-md-pull-12">
          <div class="card">
            <div class="card-body" id="tabs">

              <div class="alert alert-warning tp-pending-notice" id="tpPendingNotice" style="display:none">
                <i class="mdi mdi-alert-outline"></i>
                <span>You selected <b>0</b> file(s) in another section that have <strong>not been uploaded yet</strong>. Go back to that section and click its <strong>Upload documents</strong> button, or the selection will be lost.</span>
              </div>

              <ul class="nav nav-pills bg-light tp-steps" role="tablist">
                <li class="nav-item">
                  <a href="#info-2" data-toggle="tab" role="tab" aria-expanded="true" class="nav-link active">
                    <span class="tp-step-num">1</span>
                    <span class="d-none d-lg-inline">Academic studies</span>
                    <span class="tp-step-count"><?php echo $tpAcadD; ?>/<?php echo $tpAcadT; ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#info-3" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="tp-step-num">2</span>
                    <span class="d-none d-lg-inline">English language requirements</span>
                    <span class="tp-step-count"><?php echo $tpEngD; ?>/<?php echo $tpEngT; ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#info-4" data-toggle="tab" role="tab" aria-expanded="false" class="nav-link">
                    <span class="tp-step-num">3</span>
                    <span class="d-none d-lg-inline">Other documents</span>
                    <span class="tp-step-count"><?php echo $tpOthD; ?>/<?php echo $tpOthT; ?></span>
                  </a>
                </li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane show active" id="info-2">

                  <ul class="nav nav-pills bg-light tp-subtabs" role="tablist">
                    <?php for ($qset = 1; $qset <= MAX_fileDNO; $qset++) { ?>
                      <li class="nav-item">
                        <a href="#info-2<?php echo $qset; ?>" data-toggle="tab" role="tab" aria-expanded="<?php if ($qset == 1) echo 'true'; else echo 'false' ?>" class="nav-link <?php if ($qset == 1) echo 'active'; ?> <?php if ($qset > $Pno) echo 'disabled'; ?>">
                          <span class="<?php if ($qset > $Pno) echo 'text-muted'; ?>">Institution #<?php echo $qset; ?></span>
                          <?php if ($qset <= $Pno && isset ($tpSections[$qset-1])) { ?>
                            <span class="tp-step-count"><?php echo $tpSections[$qset-1]['d']; ?>/<?php echo $tpSections[$qset-1]['t']; ?></span>
                          <?php } ?>
                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                  <div class="tab-content">

                    <?php for ($qq = 0; $qq < $Pno; $qq++) { ?>
                      <?php $qset = $qq+1; ?>
                      <div class="tab-pane <?php if ($qset == 1)  echo 'show active'; ?>" id="info-2<?php echo $qset; ?>">
                        <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">

                          <div class="tp-refkey-box mt-3">
                            <div class="row align-items-center">
                              <div class="col-lg-8">
                                <label for="title<?php echo $qset; ?>" class="mb-lg-0">
                                  <i class="mdi mdi-tag-outline"></i>
                                  Reference tag for <u><?php echo isset ($degInfo['uni'][$qq]) ? $degInfo['uni'][$qq] : ''; ?></u> &mdash; <u><?php echo isset ($degInfo['degree'][$qq]) ? $degInfo['degree'][$qq] : ''; ?></u>
                                  <small class="d-block text-muted">max 15 letters, short form is ok, e.g. BEng_NJU</small>
                                </label>
                              </div>
                              <div class="col-lg-4">
                                <input class="form-control" type="text" name="title<?php echo $qset; ?>" id="title<?php echo $qset; ?>" required="yes" onkeypress="return isNumericKey(event)" value="<?php echo $titleArray[$qset]; ?>" maxlength="15">
                              </div>
                            </div>
                          </div>

                          <ul class="list-group tp-doc-list mt-3">
                            <?php $isChina = (isset ($degInfo['isChina'][$qq]) && $degInfo['isChina'][$qq] == 'Y'); ?>
                            <?php if ($isChina) $endLoop = ($qq+1)*12; else $endLoop = $qq*12+7; ?>
                            <?php $tpRowNum = 0; ?>
                            <?php for ($i=$qq*12; $i<$endLoop; $i++) { ?>
                              <?php if (UPLOAD_ITEMS[$i][1] == "") continue; ?>
                              <?php $tpRowNum++; $st = tpItemState (UPLOAD_ITEMS[$i][0], $verified, $uploaded, $tpErr, $tpErrCount); ?>
                              <li class="list-group-item tp-doc-row tp-doc-<?php echo $st['status']; ?>">
                                <div class="row">
                                  <div class="col-lg-7">
                                    <div class="tp-doc-title">
                                      <span class="tp-doc-num"><?php echo $tpRowNum; ?></span>
                                      <h5><?php echo UPLOAD_ITEMS[$i][1]; ?>
                                        <?php if (UPLOAD_ITEMS[$i][2] != "") { ?>
                                          <span data-toggle="popover" html="true" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                                      </h5>
                                    </div>
                                    <?php if (UPLOAD_ITEMS[$i][4] != "") { ?>
                                      <a class="tp-sample-link" data-toggle="collapse" href="#cardCollapse<?php echo UPLOAD_ITEMS[$i][0]; ?>" role="button" aria-expanded="false">
                                        <i class="mdi mdi-eye-outline"></i> View sample
                                      </a>
                                      <div id="cardCollapse<?php echo UPLOAD_ITEMS[$i][0] ?>" class="collapse pt-2">
                                        <img class="img-fluid mb-1 tp-sample-img" src="<?php echo base_url().UPLOAD_ITEMS[$i][4]; ?>" alt="">
                                      </div>
                                    <?php } ?>
                                  </div>

                                  <div class="col-lg-5 tp-doc-action">
                                    <?php tpStatusChip ($st); ?>
                                    <?php if ($st['show']) tpFileInput (UPLOAD_ITEMS[$i]); ?>
                                  </div>
                                </div>
                              </li>
                            <?php } ?>
                          </ul>

                          <div class="tp-ready-badge alert alert-success mt-3" style="display:none">
                            <i class="mdi mdi-paperclip"></i> <b>0</b> file(s) selected &mdash; tick the declaration and click <strong>Upload documents</strong> below to submit them.
                          </div>

                          <?php tpDeclaration ('A'.$qset, 'Upload documents'); ?>
                        </form>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <div class="tab-pane" id="info-3">
                  <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">
                    <div class="tp-section-intro mt-3">
                      <p class="mb-0">Applicants seeking admission based on qualification from a university or comparable institution outside of Hong Kong, where the language of instruction and/or examination is not English, is required to submit TOEFL / IELTS official score report. Click <a href="https://aal.hku.hk/tpg/english-language-requirements" target="_blank"><strong>here</strong></a> for detailed requirements from HKU.</p>
                    </div>
                    <?php $eng=36; ?>
                    <ul class="list-group tp-doc-list mt-3">
                      <?php $st = tpItemState (UPLOAD_ITEMS[$eng][0], $verified, $uploaded, $tpErr, $tpErrCount); ?>
                      <li class="list-group-item tp-doc-row tp-doc-<?php echo $st['status']; ?>">
                        <div class="row">
                          <div class="col-lg-7">
                            <div class="tp-doc-title">
                              <span class="tp-doc-num">1</span>
                              <h5><?php echo UPLOAD_ITEMS[$eng][1]; ?>
                                <?php if (UPLOAD_ITEMS[$eng][2] != "") { ?>
                                <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$eng][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                              </h5>
                            </div>
                            <?php if (UPLOAD_ITEMS[$eng][4] != "") { ?>
                              <a class="tp-sample-link" data-toggle="collapse" href="#cardCollapse<?php echo UPLOAD_ITEMS[$eng][0]; ?>" role="button" aria-expanded="false">
                                <i class="mdi mdi-eye-outline"></i> View sample
                              </a>
                              <div id="cardCollapse<?php echo UPLOAD_ITEMS[$eng][0] ?>" class="collapse pt-2">
                                <img class="img-fluid mb-1 tp-sample-img" src="<?php echo base_url().UPLOAD_ITEMS[$eng][4]; ?>" alt="">
                              </div>
                            <?php } ?>
                          </div>

                          <div class="col-lg-5 tp-doc-action">
                            <?php tpStatusChip ($st); ?>
                            <?php if ($st['show']) tpFileInput (UPLOAD_ITEMS[$eng]); ?>
                          </div>
                        </div>
                      </li>

                      <?php $st = tpItemState (UPLOAD_ITEMS[$eng+1][0], $verified, $uploaded, $tpErr, $tpErrCount); ?>
                      <li class="list-group-item tp-doc-row tp-doc-<?php echo $st['status']; ?>">
                        <div class="row">
                          <div class="col-lg-7">
                            <div class="tp-doc-title">
                              <span class="tp-doc-num">2</span>
                              <h5><?php echo UPLOAD_ITEMS[$eng+1][1]; ?>
                                <?php if (UPLOAD_ITEMS[$eng+1][2] != "") { ?>
                                  <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$eng+1][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                              </h5>
                            </div>
                          </div>

                          <div class="col-lg-5 tp-doc-action">
                            <p class="tp-radio-label">Select the test you are submitting:</p>
                            <div class="custom-control custom-radio">
                              <input type="radio" name="customRadio" class="custom-control-input" id="toefl" value="TOEFL">
                              <label class="custom-control-label" for="toefl">TOEFL (Test of English as a Foreign Language)</label>
                            </div>
                            <div class="custom-control custom-radio mb-2">
                              <input type="radio" name="customRadio" class="custom-control-input" id="ielts" value="IELTS" checked>
                              <label class="custom-control-label" for="ielts">IELTS (International English Language Testing System)</label>
                            </div>
                            <?php tpStatusChip ($st); ?>
                            <?php if ($st['show']) tpFileInput (UPLOAD_ITEMS[$eng+1]); ?>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <div class="tp-ready-badge alert alert-success mt-3" style="display:none">
                      <i class="mdi mdi-paperclip"></i> <b>0</b> file(s) selected &mdash; tick the declaration and click <strong>Upload documents</strong> below to submit them.
                    </div>

                    <?php tpDeclaration ('B', 'Upload documents'); ?>
                  </form>
                </div>

                <div class="tab-pane" id="info-4">
                  <div class="tp-section-intro mt-3">
                    <p class="mb-0">Use this section to upload other documents requested by departmental administration. If in doubt, please check with department before upload.</p>
                  </div>

                  <ul class="list-group tp-doc-list mt-3">
                  <?php for ($other = 0; $other < 3; $other++) {
                    $i = 38 + $other;
                    $st = tpItemState (UPLOAD_ITEMS[$i][0], $verified, $uploaded, $tpErr, $tpErrCount); ?>

                    <!-- upload modal-->
                    <div id="otherUploadForm<?php echo $other+1; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="p-2">
                              <div class="text-center w-80 m-auto">
                                <h4 class="mt-0 font-weight-bold">Upload <?php echo UPLOAD_ITEMS[$i][1]; ?></h4>
                              </div>

                              <form method="post" action="<?php echo base_url().'upload/uploadAll'; ?>" enctype="multipart/form-data">
                                <div class="form-group text-left mt-3">
                                  <label for="other<?php echo UPLOAD_ITEMS[$i][0]; ?>">What are you uploading?</label>
                                  <input class="form-control" type="text" name="other<?php echo UPLOAD_ITEMS[$i][0]; ?>" id="other<?php echo UPLOAD_ITEMS[$i][0]; ?>" required="yes" placeholder="description" maxlength="12">

                                  <div class="mt-3"> <!-- file upload -->
                                    <?php tpStatusChip ($st); ?>
                                    <?php if ($st['show']) tpFileInput (UPLOAD_ITEMS[$i]); ?>
                                  </div> <!-- end file upload -->
                                </div>

                                <?php tpDeclaration ('C'.($other+1), 'Upload document'); ?>
                              </form>
                            </div>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <li class="list-group-item tp-doc-row tp-doc-<?php echo $st['status']; ?>">
                      <div class="row">
                        <div class="col-lg-7">
                          <div class="tp-doc-title">
                            <span class="tp-doc-num"><?php echo $other+1; ?></span>
                            <h5><?php echo UPLOAD_ITEMS[$i][1]; ?>
                            <?php if (UPLOAD_ITEMS[$i][2] != "") { ?>
                              <span data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php echo UPLOAD_ITEMS[$i][2]; ?>"> <i class="mdi mdi-information-outline"></i></span><?php } ?>
                            </h5>
                          </div>
                        </div>

                        <div class="col-lg-5 tp-doc-action">
                          <?php tpStatusChip ($st); ?>
                          <?php if ($st['show']) { ?>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#otherUploadForm<?php echo $other+1; ?>"><i class="mdi mdi-upload"></i> upload file</button>
                          <?php } ?>
                        </div>
                      </div>
                    </li>

                  <?php } ?>
                  </ul>

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
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=3"></script>
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

  // warn when switching tabs while files are selected but not yet uploaded —
  // purely a front-end reminder, nothing about the upload flow changes.
  $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function ()
  {
    var pending = $('input[type=file]').filter(function ()
    {
      return !!this.value && $(this).closest('.tab-pane.active').length === 0;
    }).length;

    var notice = $('#tpPendingNotice');
    if (pending > 0)
    {
      notice.find('b').first().text(pending);
      notice.slideDown(180);
    }
    else
      notice.slideUp(120);
  });
  </script>
  </body>
</html>
