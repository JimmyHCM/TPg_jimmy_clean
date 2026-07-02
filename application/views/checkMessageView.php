<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TPG - admission system - chat history </title>
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

  <script>
    $(document).ready(function()
    {
      var textMax = 500;
      $('#textareaCount').html(textMax + '/' + textMax);

      $('#msgTextArea').keyup(function() 
      {
        var textLen = $('#msgTextArea').val().length;
        var textRem = textMax - textLen;

        $('#textareaCount').html(textRem + '/' + textMax);
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
                <h4 class="page-title text-primary">Chat history between me (<?php echo $appNo;?>) and department</h4>
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

          <div class="row">
            <div class="col-12">

              <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                  <div class="card-body">

                    <?php if ($allMessage != '') { ?>
                      <strong>message history:</strong><br>
                      <div class="alert alert-success"> 
                        <h4 class="page-title text-secondary"><?php echo $allMessage; ?></h4>
                      </div>
                    <?php } else { ?>    
                      <strong>message history:</strong> -- nil --<br>
                    <?php } ?>                 

                    <?php if ($newMessage != '') { ?>
                      <strong>new message from me to department:</strong><br>
                     <div class="alert alert-info">
                      <h4 class="page-title text-secondary"><?php echo $newMessage; ?></h4>
                      </div>
                    <?php }?>


                    <?php if ($newMessage == '') { ?>
                      <!-- form -->
                        <?php echo form_open('display/writeMessage'); ?>
                          <br>
                          <hr>
                          <strong>If you want to write to department, please fill in the box below.</strong>
                          <br>
                          <div class="row d-none">
                            <input type="text" name="appNo" id="appNo" value="<?php echo $appNo;?>">
                          </div>
                          <div class="form-group text-left">
                            <label for="toDept">Your message to department (please keep this short):</label>
                            <br>
                            <textarea id="msgTextArea" rows="4" cols="50" name="toDept" required="yes" maxlength="400"></textarea>
                            <div id="textareaCount"></div>
                          </div>
                          <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submit" value="sendMsg">Submit</button>
                          </div>
                        <?php echo form_close(); ?>
                        <?php } else { ?>    
                          <br>
                          <hr>
                          <strong>New message written earlier has not yet reached department. If you want to write to department, please come back later.</strong>
                          <br>
                        <?php }  ?>    
                  </div>
                </div>
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
