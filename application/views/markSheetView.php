<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - mark sheet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.">

  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <!-- TPg premium redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=5" rel="stylesheet" type="text/css" />


  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  
  <?php include_once APPPATH."config/userConstants.php"; ?>

  <script type="text/javascript">    
    window.history.forward();
    function noBack() { 
      window.history.forward(); 
    }

    var formSubmitting = false;
    var noKeyString = '';
    var formDirty = false;

    function setFormSubmitting() 
    { 
      formSubmitting = true; 
    }

    $(document).ready(function ()
    {
      noKeyString = "<?php echo $noKeyString; ?>";
      var noKey = "<?php echo $noKey; ?>";

      function checkField (fieldName)
      {
        if (fieldName != null)
        {
          if (fieldName.value != null && fieldName.value != '')
            formDirty = true;
        }
      }

      function testForm ()
      {
        var nameField = document.getElementById('name');
        var degField = document.getElementById('deg');
        var uniField = document.getElementById('uni');
        var avgMarkField = document.getElementById('avgMarkObtained');
        var avgMarkMaxField = document.getElementById('avgMarkMax');

        checkField (nameField);
        checkField (degField);
        checkField (uniField);
        checkField (avgMarkField);
        checkField (avgMarkMaxField);
      };

      window.addEventListener('beforeunload', (event) =>
      {
        testForm ();

        if (noKeyString == "F")
        {
          if (!formSubmitting && formDirty)
          {
            event.returnValue = 'Warning: all filled data will be lost after leaving this page!';
          }
        }
      });

    });

  </script>

  <style>
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
            <h4 class="page-title">TPG admission - Academic qualification of your institution</h4>
            <p class="lead mb-0">Select the reference tag of the institution, fill in the qualification details and submit. Repeat for each institution you have entered in <strong>upload documents</strong>.</p>
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
        <h4 class="text-primary">Screen too small for filling in mark sheet, please use a device with larger screen size.</h4>
      </div>
      <div class="row m-2 d-none d-md-block"> <!-- visible md and up -->
        <div class="col-md-12 col-md-offset-12 col-md-pull-12">
          <div class="card">
            <div class="card-body">

              <!-- mark sheet -->
              <?php if ($noKey) { ?>
                <h4 class="text-primary">Please upload supporting document(s) in <strong>upload documents</strong> page before filling mark sheet here.</h4>
              <?php } else { ?>
              <h5 class="tp-card-heading"><i class="mdi mdi-school-outline"></i> Academic qualification</h5>
              <form id="markSheetForm" name="markSheet" method="post" action="<?php echo base_url().'upload/uploadMarkSheet'; ?>" onsubmit="setFormSubmitting()">

                <div class="tp-refkey-box mt-2">
                  <div class="row align-items-center">
                    <div class="col-lg-8">
                      <label for="key" class="mb-lg-0">
                        <i class="mdi mdi-tag-outline"></i>
                        Reference key
                        <small class="d-block text-muted">select the short name you have entered in <strong>upload documents</strong></small>
                      </label>
                    </div>
                    <div class="col-lg-4">
                      <select class="form-control" name="key" id="key" required="yes">
                        <?php for ($i=0; $i<4; $i++) { ?>
                          <?php if ($titleArray[$i] != '') { ?>
                            <option value="<?php echo $titleArray[$i];?>"><?php echo $titleArray[$i]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-row mt-3">
                  <div class="form-group col-md-4">
                    <label class="tp-form-label" for="appNoShow">Application number</label>
                    <input class="form-control tp-form-static" id="appNoShow" disabled value="<?php echo $_SESSION['userID'];?>">
                  </div>
                  <div class="form-group col-md-8">
                    <label class="tp-form-label" for="name">Name</label>
                    <input class="form-control" type="text" required="yes" name="name" id="name" placeholder="name as shown on your transcript" onkeypress="return isName(event)">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="tp-form-label" for="deg">Degree / Qualification obtained / to be obtained</label>
                    <input class="form-control" type="text" required="yes" name="deg" id="deg" placeholder="e.g. BEng Computer Science" onkeypress="return isAlphaNumericSpaceKey(event)">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="tp-form-label" for="uni">Institution</label>
                    <input class="form-control" type="text" required="yes" name="uni" id="uni" placeholder="full name of the awarding institution" onkeypress="return isAlphaNumericSpaceKey(event)">
                  </div>
                </div>

                <div class="form-group">
                  <p class="tp-radio-label mb-1">For institution in Mainland China:</p>
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="u985" id="u985" value="985"/>
                    <label class="custom-control-label" for="u985">tick if this institution is 985 Project Universities</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="u211" id="u211" value="211"/>
                    <label class="custom-control-label" for="u211">tick if this institution is 211 Project Universities</label>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label class="tp-form-label" for="avgMarkObtained">GPA/Mark <small>(Sample: 85.6/100 or 3.85/4.0)</small></label>
                    <div class="tp-gpa-row">
                      <input class="form-control" type="text" required="yes" name="avgMarkObtained" id="avgMarkObtained" maxlength="5" placeholder="GPA / mark obtained" onkeypress="return isRealNum(event)">
                      <span class="tp-gpa-of">of</span>
                      <input class="form-control" type="text" required="yes" name="avgMarkMax" id="avgMarkMax" maxlength="4" placeholder="maximum GPA / full mark" onkeypress="return isRealNum(event)">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="tp-form-label" for="awardClass">Classification of award</label>
                    <select class="form-control" name="awardClass" id="awardClass" required="yes">
                      <option value="" disabled selected>Please select</option>
                      <option value="1st Class Honours">1st Class Honours</option>
                      <option value="2nd Class Honours (Division One)">2nd Class Honours (Division One)</option>
                      <option value="2nd Class Honours (Division Two)">2nd Class Honours (Division Two)</option>
                      <option value="Third Class Honours">Third Class Honours</option>
                      <option value="Pass">Pass</option>
                      <option value="Fail">Fail</option>
                    </select>
                  </div>
                </div>

                <div class="d-none">
                  <input type="text" name="appNo" id="appNo" value="<?php echo $_SESSION['userID'];?>">
                </div>

                <button class="btn btn-primary btn-lg tpg-btn-block mt-2" type="submit" name="submit" value="Submit mark sheet"><i class="mdi mdi-check-circle-outline"></i> Submit mark sheet</button>
              </form>
            <?php } ?>

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
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=4"></script>
  <script>
  
  $("[data-toggle=popover]").popover({trigger:"hover", html:"true"});

  function isAlphaNumericKey(evt) // allowed: A-Z, a-z, 0-9, _
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        (charCode >= 97 && charCode <= 122) || 
        (charCode >= 48 && charCode <= 57) || charCode == 95)
    return true;

    return false;
  } 

  function isAlphaNumericSpaceKey(evt) // allowed: A-Z, a-z, 0-9, _, space
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        (charCode >= 97 && charCode <= 122) || 
        (charCode >= 48 && charCode <= 57) || charCode == 95 || charCode == 32)
    return true;

    return false;
  } 

  function isName(evt) // allowed: A-Z, a-z, space
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        (charCode >= 97 && charCode <= 122) || charCode == 32)
    return true;

    return false;
  } 

  function isNum(evt) // allowed: 0-9
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if (charCode >= 48 && charCode <= 57)
    return true;

    return false;
  } 

  function isRealNum(evt) // allowed: 0-9, .
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 48 && charCode <= 57) || charCode == 46)
    return true;

    return false;
  } 

  function isGrade(evt) // allowed: A-Z, +, -
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        charCode == 43 || charCode == 45)
    return true;

    return false;
  } 

  function isAlphaNumCapKey(evt) // allowed: A-Z, 0-9
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 65 && charCode <= 90) || 
        (charCode >= 48 && charCode <= 57))
    return true;

    return false;
  } 

  function isNumericSpaceKey(evt) // allowed: 0-9, -, space
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 48 && charCode <= 57) || charCode == 45 || charCode == 32)
    return true;

    return false;
  } 

  function isNumericDotSlashKey(evt) // allowed: 0-9, ., slash
  {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    
    if ((charCode >= 48 && charCode <= 57) || charCode == 46 || charCode == 47)
    return true;

    return false;
  } 

  </script>
  </body>
</html>
