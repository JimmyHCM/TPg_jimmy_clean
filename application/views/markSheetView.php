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
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=4" rel="stylesheet" type="text/css" />


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
      var counter = 1;    
      $("#counter").val(counter);
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
        var passingField = document.getElementById('passing');
        var avgMarkField = document.getElementById('avgMarkByStudent');

        checkField (nameField);
        checkField (degField);
        checkField (uniField);
        checkField (passingField);
        checkField (avgMarkField);

        if (!formDirty)
        {
          var i;
          var done = false;
          for (i=0; i<counter && !done; i++)
          {
            var yearID = 'year' + i;
            var year = document.getElementById(yearID);
            var markID = 'mark' + i;
            var mark = document.getElementById(markID);
            var gpaID = 'gpa' + i;
            var gpa = document.getElementById(gpaID);
            var gradeID = 'grade' + i;
            var grade = document.getElementById(gradeID);
            var courseCode = 'courseCode' + i;
            var code = document.getElementById(courseCode);
            var courseTitle = 'courseTitle' + i;
            var title = document.getElementById(courseTitle);
            var creditUnit = 'creditUnit' + i;
            var credit = document.getElementById(creditUnit);

            checkField (year);
            checkField (mark);
            checkField (gpa);
            checkField (grade);
            checkField (code);
            checkField (title);
            checkField (credit);
            if (formDirty)
              done = true;
          }
        }
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

      $("#addrow").on("click", function () 
      {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input class="form-control" type="text" pattern=".{4,}" required title="4 digits for year" name="year' + counter + '" id="year' + counter + '" required="yes" onkeypress="return isNumericSpaceKey(event)"></td>';
        cols += '<td><select name="semester' + counter + '" id="semester' + counter + '"><option value="Fall">Fall</option><option value="Spring">Spring</option><option value="Summer">Summer</option><option value="Winter">Winter</option><option value="First">First</option><option value="Second">Second</option><option value="Third">Third</option></select></td>';
        cols += '<td><input class="form-control" type="text" name="courseCode' + counter + '" id="courseCode' + counter + '" required="yes" onkeypress="return isAlphaNumCapKey(event)"></td>';
        cols += '<td><input class="form-control" type="text" name="courseTitle' + counter + '" id="courseTitle' + counter + '" required="yes" onkeypress="return isAlphaNumericSpaceKey(event)"></td>';
        cols += '<td><input class="form-control" type="text" name="creditUnit' + counter + '" id="creditUnit' + counter + ' onkeypress="return isRealNum(event)"></td>';
        cols += '<td><input class="form-control" type="text" name="mark' + counter + '" id="mark' + counter + '" onkeypress="return isRealNum(event)"></td>';
        cols += '<td><input class="form-control" type="text" name="gpa' + counter + '" id="gpa' + counter + '" onkeypress="return isRealNum(event)"></td>';
        cols += '<td><input class="form-control" type="text" name="grade' + counter + '" id="grade' + counter + '" onkeypress="return isGrade(event)"></td>';
        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);

        $("table.order-list").append(newRow);
        counter++;
        $("#counter").val(counter);
      });

      $("table.order-list").on("click", ".ibtnDel", function (event) 
      {
        $(this).closest("tr").remove();    
        $("#counter").val(counter);
      });

      $("#checkMS").on("click", function () 
      {
        var i;
        var done = false;
        for (i=0; i<counter && !done; i++)
        {
          var yearID = 'year' + i;
          var year = document.getElementById(yearID);
          if (year != null)
          {
            var markID = 'mark' + i;
            var mark = document.getElementById(markID);
            var gpaID = 'gpa' + i;
            var gpa = document.getElementById(gpaID);
            var gradeID = 'grade' + i;
            var grade = document.getElementById(gradeID);
            
            var ok = false;
            if (mark.value != '' || gpa.value != '' || grade.value != '')
              ok = true;
            if (!ok)
            {
              var codeID = 'courseCode' + i;
              var code = document.getElementById(codeID);
              alert ('Missing mark / gpa / grade for the course ' + code.value);
              done = true;
            }
          }
        }
        if (!done)
          alert ('All marks look good!');
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
            <h4 class="page-title text-primary">TPG admission - mark sheet for all courses you have taken in your institution</h4>
            <div class="alert alert-info" role="alert">
              If your transcript does not indicate an overall average mark / CGPA, please follow the instructions to enter the mark / GPA for all courses you have taken in your institution, then submit. Please upload supporting document(s) in <strong>upload documents</strong> page before filling mark sheet here. Please note, refreshing this page will reset the form. Remember to <strong>Submit mark sheet</strong> when done.<br/><br/>You have 120 minutes (until <?php echo $endTime; ?>) to fill in the mark sheet. When you submit the mark sheet, a file will be generated. If you are applying for more than one curriculum, you can upload the same generated file for another application instead of filling in the mark sheet again.
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
              <form id="markSheetForm" name="markSheet" method="post" action="<?php echo base_url().'upload/uploadMarkSheet'; ?>" onsubmit="setFormSubmitting()">
                    
                <div class="row">
                  <div class="col-12">
                    <div class="input-group mt-2 mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Reference key (select the short name you have entered in
                           <strong>upload documents</strong>)</span>
                      </div>
                      <select class="form-control" name="key" id="key" required="yes">
                        <?php for ($i=0; $i<4; $i++) { ?>
                          <?php if ($titleArray[$i] != '') { ?>
                            <option value="<?php echo $titleArray[$i];?>"><?php echo $titleArray[$i]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Application number</span>
                      </div>
                      <input class="form-control" disabled value="<?php echo $_SESSION['userID'];?>">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Name</span>
                      </div>
                      <input class="form-control" type="text" required="yes" name="name" id="name" onkeypress="return isName(event)">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Degree / Qualification obtained / to be obtained</span>
                      </div>
                      <input class="form-control" type="text" required="yes" name="deg" id="deg" onkeypress="return isAlphaNumericSpaceKey(event)">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Institution</span>
                      </div>
                      <input class="form-control" type="text" required="yes" name="uni" id="uni" onkeypress="return isAlphaNumericSpaceKey(event)">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="u985" id="u985" value="985"/>
                        <label class="custom-control-label" for="u985"><strong>For institution in Mainland China</strong>: tick if this institution is 985 Project Universities</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="u211" id="u211" value="211"/>
                        <label class="custom-control-label" for="u211"><strong>For institution in Mainland China</strong>: tick if this institution is 211 Project Universities</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Passing mark</span>
                      </div>
                      <input class="form-control" type="tel" required="yes" name="passing" id="passing">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-group mb-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Average mark or GPA (sample: 85.6/100 or 3.85/4.0)</span>
                      </div>
                      <input class="form-control" type="text" required="yes" name="avgMarkByStudent" id="avgMarkByStudent" onkeypress="return isNumericDotSlashKey(event)">
                    </div>
                  </div>
                </div>

                <div class="row d-none">
                  <input type="text" name="counter" id="counter">
                  <input type="text" name="appNo" id="appNo" value="<?php echo $_SESSION['userID'];?>">
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-info" role="alert">
                      Marks of ALL courses taken in the qualification specified above should be included below. For other qualification(s), please fill in the mark sheet in another tab.
                    </div>
                  </div>
                  <div class="col-12">
                    <table id="myMarkTable" class="table order-list">
                      <thead>
                        <tr>
                          <td>Year of attendance (4 digits for year)</td>
                          <td>Semester</td>
                          <td>Course code<br/>(A-Z,0-9 only)</td>
                          <td>Course title<br/>(no puncuation mark)</td>
                          <td>Credit units of course (if applicable)</td>
                          <td>Mark / score obtained (if applicable)</td>
                          <td>Grade points obtained (if applicable)</td>
                          <td>Letter grade (if applicable. UPPERCASE, +, - only)</td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input class="form-control" type="text" pattern=".{4,}" required title="4 digits for year" name="year0" id="year0" required="yes" onkeypress="return isNumericSpaceKey(event)">
                          </td>
                          <td>
                            <select name="semester0" id="semester0">
                              <option value="Fall">Fall</option>
                              <option value="Spring">Spring</option>
                              <option value="Summer">Summer</option>
                              <option value="Winter">Winter</option>
                              <option value="First">First</option>
                              <option value="Second">Second</option>
                              <option value="Third">Third</option>
                            </select>
                          </td>
                          <td>
                            <input class="form-control" type="text" name="courseCode0" id="courseCode0" required="yes" onkeypress="return isAlphaNumCapKey(event)">
                          </td>
                          <td>
                            <input class="form-control" type="text" name="courseTitle0" id="courseTitle0" required="yes" onkeypress="return isAlphaNumericSpaceKey(event)">
                          </td>
                          <td>
                            <input class="form-control" type="text" name="creditUnit0" id="creditUnit0" onkeypress="return isRealNum(event)">
                          </td>
                          <td>
                            <input class="form-control" type="text" name="mark0" id="mark0" onkeypress="return isRealNum(event)">
                          </td>
                          <td>
                            <input class="form-control" type="text" name="gpa0" id="gpa0" onkeypress="return isRealNum(event)">
                          </td>
                          <td>
                            <input class="form-control" type="text" name="grade0" id="grade0" onkeypress="return isGrade(event)">
                          </td>
                          <td><a class="deleteRow"></a>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="9" style="text-align: left;">
                            <input type="button" class="btn btn-sm btn-block " id="addrow" value="add row" />
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-12">
                    <input type="button" class="btn btn-sm btn-block btn-outline-primary" id="checkMS" value="Validate mark sheet" />
                    <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Submit mark sheet"></input>
                  </div>
                </div>
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
