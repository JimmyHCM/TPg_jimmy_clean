<?php
$pageTitle = 'Messages';
$bodyAttrs = 'onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload=""';
include(APPPATH.'views/partials/head.php');
?>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
  window.history.forward();
  function noBack() {
    window.history.forward();
  }

  $(document).ready(function()
  {
    var textMax = 400;
    $('#textareaCount').html(textMax + '/' + textMax);

    $('#msgTextArea').keyup(function()
    {
      var textLen = $('#msgTextArea').val().length;
      var textRem = textMax - textLen;

      $('#textareaCount').html(textRem + '/' + textMax);
    });
  });
</script>

<?php include(APPPATH.'views/partials/hub_top.php'); ?>

      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <h4 class="page-title">Messages with department</h4>
                <p class="lead mb-0">Chat history between me (<?php echo $appNo;?>) and the department.</p>
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
            <div class="col-lg-8 col-12">
              <div class="card">
                <div class="card-body p-4">

                  <h5 class="tp-card-heading mt-0"><i class="mdi mdi-history"></i> Message history</h5>
                  <?php if ($allMessage != '') { ?>
                    <div class="tp-chat-log"><?php echo $allMessage; ?></div>
                  <?php } else { ?>
                    <p class="tp-chat-empty">&mdash; no messages yet &mdash;</p>
                  <?php } ?>

                  <?php if ($newMessage != '') { ?>
                    <h5 class="tp-card-heading"><i class="mdi mdi-email-send-outline"></i> New message from me to department</h5>
                    <div class="tp-chat-log tp-chat-log-new"><?php echo $newMessage; ?></div>
                  <?php }?>

                  <?php if ($newMessage == '') { ?>
                    <!-- form -->
                    <?php echo form_open('display/writeMessage'); ?>
                      <hr>
                      <h5 class="tp-card-heading"><i class="mdi mdi-pencil-outline"></i> Write to department</h5>
                      <div class="row d-none">
                        <input type="text" name="appNo" id="appNo" value="<?php echo $appNo;?>">
                      </div>
                      <div class="form-group text-left">
                        <label for="msgTextArea">Your message to department (please keep this short):</label>
                        <textarea class="form-control" id="msgTextArea" rows="4" name="toDept" required="yes" maxlength="400"></textarea>
                        <div id="textareaCount" class="tp-chat-count"></div>
                      </div>
                      <div class="form-group mb-0">
                        <button class="btn btn-primary" type="submit" name="submit" value="sendMsg"><i class="mdi mdi-send"></i> Submit</button>
                      </div>
                    <?php echo form_close(); ?>
                  <?php } else { ?>
                    <hr>
                    <p class="tpg-note mb-0">
                      Your earlier message has not yet reached the department.
                      If you want to write to the department again, please come back later.
                    </p>
                  <?php }  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- content -->

<?php include(APPPATH.'views/partials/hub_foot.php'); ?>
