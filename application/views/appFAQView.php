<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - FAQ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <!-- Dell 1996 redesign layer (must load LAST) -->
  <link href="<?php echo base_url(); ?>assets/css/dell-1996.css" rel="stylesheet" type="text/css" />

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

          <!-- FAQ -->
          <!--
          <li class="side-nav-item">
            <a href="<?php echo base_url(); ?>display/faq" class="side-nav-link">
              <i class="mdi mdi-information-outline"></i>
              <span> FAQ </span>
            </a>
          </li>
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
      
      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title text-primary">Frequently Asked Questions</h4>
              </div>
            </div>
          </div>     
          <!-- end page title --> 

          <div class="row mb-4">
            <div class="col-12">
              <div class="card mt-0 mb-0 shadow-sm">
                <div class="card-header shadow-sm">
                  General enquiries
                </div>
                <div class="card-body mb-0 border bg-light">
                  <div class="row">
                    <div class="col">
                      <div class="table-responsive-sm">
                        <table class="table table-hover table-sm table-centered mb-0">
                          <thead>
                            <tr>
                              <th>Department</th>
                              <th>Programme</th>
                              <th>email</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="2">Faculty of Engineering</td>
                              <td>ENGG_TPg_admission@hku.hk</td>
                            </tr>
                            <tr>
                              <td>Department of Civil Engineering</td>
                              <td>MSc(Eng) in Environmental Engineering<br/>
                                MSc(Eng) in Geotechnical Engineering<br/>
                                MSc(Eng) in Infrastructure Project Management<br/>
                                MSc(Eng) in Structural Engineering<br/>
                              MSc(Eng) in Transportation Engineering</td>
                              <td>ymwonga@hku.hk</td>
                            </tr>
                            <tr>
                              <td>Department of Electrical and Electronic Engineering</td>
                              <td>MSc(Eng) in Electrical and Electronic Engineering<br/>
                              MSc(Eng) in Energy Engineering</td>
                              <td>tpg-admission@eee.hku.hk</td>
                            </tr>
                            <tr>
                              <td>Department of Industrial and Manufacturing Systems Engineering</td>
                              <td>MSc(Eng) in Industrial Engineering and Logistics Management</td>
                              <td>brendale@hku.hk</td>
                            </tr>
                            <tr>
                              <td>Department of Mechanical Engineering</td>
                              <td>MSc(Eng) in Building Services Engineering<br/>
                              MSc(Eng) in Mechanical Engineering</td>
                              <td>kkilo@hku.hk<br/>apang@hku.hk</td>
                            </tr>
                            <tr>
                              <td rowspan="2">Department of Computer Science</td>
                              <td>MSc in Computer Science</td>
                              <td>msccs@cs.hku.hk</td>
                            </tr>
                            <tr>
                              <td>MSc in Electronic Commerce and Internet Computing</td>
                              <td>admission@ecom-icom.hku.hk</td>
                            </tr>
                          </tbody>
                        </table>
                      </div> <!-- end table-responsive-->
                    </div>
                  </div>
                </div>  <!-- end card-body -->
              </div>
            </div>
          </div>

          <!--
          <div class="row mb-4">
            <div class="col-12">
              <div class="card mt-0 mb-0 shadow-sm">
                <div class="card-header shadow-sm">
                  <a href="https://engg.hku.hk/Portals/0/TPG/faq.pdf" target="_blank">More ...</a>
                </div>
              </div>  
            </div>
          </div> 
        -->
          <!-- end faq -->

        </div>
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
</body>
</html>
