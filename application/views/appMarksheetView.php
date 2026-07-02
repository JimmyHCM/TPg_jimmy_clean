<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - upload mark sheet</title>
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
  <link href="<?php echo base_url(); ?>assets/css/tpg-premium.css?v=2" rel="stylesheet" type="text/css" />


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
                <h4 class="page-title text-primary">Upload mark sheet</h4>
                <p>If your official transcript does not indicate an average mark / gpa, please follow the instructions below to prepare and upload the mark sheet.</p>
                <ol>
                  <li>Download the excel template <a href="https://engg.hku.hk/faculty_msc/calsheet.xls">here</a>.</li>
                  <li>Complete the template using information from your transcript.</li>
                  <li>A <strong>.csv</strong> file in the name of your application number will be generated.</li>
                  <li>Upload this <strong>.csv</strong> file below.</li>
                </ol>
                
              </div>
            </div>
          </div>     
          <!-- end page title --> 


          <form method="post" action="<?php echo base_url().'upload/uploadMarkSheet'; ?>" enctype="multipart/form-data">

            <?php if (isset($_SESSION['success'])) {?>
              <div class="alert alert-success"> <?php echo $_SESSION['success']; ?></div>
              <?php 
            }?>

            <?php if (isset($_SESSION['error'])) {?>
              <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
              <?php 
            }?>

            <div class="row mb-4">
              <div class="col-12">

                <div class="card d-block shadow-sm">
                  <div class="card-body">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-8">
                            <h5>Upload <i>application_no</i>.csv here</h5>
                            application_no is your application number
                          </div>

                          <div class="col-4"> <!-- file upload -->
                            <input name="fileM" type="file" accept=".csv" />
                          </div> <!-- end file upload -->
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-12">
                <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Upload mark sheet"></input>
              </div>
            </div>

          </form>
        </div> <!-- container -->

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

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


  </div>
  <!-- END wrapper -->


  <!-- App js -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tpg-premium.js?v=2"></script>
</body>
</html>
