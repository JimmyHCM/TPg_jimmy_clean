<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/Sftp.php";
include_once APPPATH."config/userConstants.php";

class Status extends CI_Controller
{

  function __construct () 
  {
    parent::__construct ();
    $this->load->model('AppAuthModel');
    $this->load->model('EmailModel');
    $this->load->model('SlipModel');
    $this->load->model('UploadModel');

    if($_SESSION['user_logged'] == FALSE)   
    {
      $this->session->set_flashdata("error", "redirecting to login page...");
      redirect("auth");
    }
  }

  public function index() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->session->set_flashdata("error", "redirecting to login page...");
    redirect("auth");
  }

  public function checkStatus () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $recipientEmail = $_POST['email'];
    $appNo = $_SESSION['appNo'];

    if ($this->AppAuthModel->isAppNoEmailCorrect($appNo, $recipientEmail))
    {
      /*
      $msg = "";
      $appStatus = $this->AppAuthModel->getAppStatus ($appNo);
      $replyStatus = $this->AppAuthModel->getReplyStatus ($appNo);
      $this->EmailModel->generateStatusMsg ($msg, $appNo, $appStatus, $replyStatus);
      $this->AppAuthModel->emailNoFile ("Application status", $msg, $recipientEmail);
      */
      $this->AppAuthModel->queueUpRequest ($appNo, 'S');

      $this->session->set_flashdata("info", "your application status will be emailed to you soon.");
      redirect("status/done","refresh");
    }
    
    $this->session->set_flashdata("error", "information not match, please login again.");
    redirect("status/done","refresh");
  }

  private function getUploadKeyfile ($appNo, $keyfile, &$fileExt)
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileOK = false;

    $this->load->helper('file');
    //print_r($_FILES);

    //Upload to the local server
    if (!is_dir(UPLOAD_DIR . $appNo)) 
    {
      mkdir('./'.UPLOAD_DIR . $appNo, 0755, true);    // create dir
    }
    $config['upload_path'] = UPLOAD_DIR . $appNo . "/";
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);

    if ($_FILES[$keyfile]['name'] != NULL)
    {
      // re-initialize upload library
      $config['file_name'] = $appNo.$keyfile;
      $config['overwrite'] = TRUE;  // old file will be overwritten
      $this->upload->initialize($config);

      if($this->upload->do_upload($keyfile)) 
      {
        //Get uploaded file information
        $uploadData = $this->upload->data();
        if ($this->UploadModel->isImage ($uploadData))
        {
          $fileExt = $uploadData['file_ext'];
          $fileOK = true;
        }
      }
    }
    return $fileOK;
  }

  // submit reply slip and payment slip
  public function reply () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $error = false;
    $msgErr = '';
    $msgInfo = '';

    if (empty($_POST))
    {
      // upload error
      $msgErr = "Something is wrong with your submission. Please check the file properties (only accept jpg, jpeg, png; min size 1MB; max size 2MB) and login to submit again. Thank you.";
      $error = true;
    }
    else
    {
      $recipientEmail = $_POST['myEmail'];
      $appNo = $_SESSION['appNo'];
      $fileOK = false;
      $fileExt = '';
      $keyfile = 'paymentSlip';
      $RS = array ();

      $currCode = $this->AppAuthModel->getCurrCode ($appNo);
      $emailFooter = 'e'; // general footer

      $acadYear = $this->SlipModel->getUserDefinedText ('ACADyear');
      /*
      // special arrangement for 2025 admission year
      $admYear = $this->AppAuthModel->getAdmYear ($appNo);
      if ($admYear == 2025 || $admYear == '2025')
        $acadYear = '2025-26';
      else
        $acadYear = $this->SlipModel->getUserDefinedText ('ACADyear');
      if ($acadYear == 'XXXX')
        $acadYear = '2025-26';
      */

      if ($this->input->post('submit') == "Submit reply slip")
      {
        if ($this->AppAuthModel->isAppNoEmailCorrect($appNo, $recipientEmail))
        {
          $this->AppAuthModel->getAppReplySlipDetails ($appNo, $RS);
          
          $RS['signature'] = $_POST['signature'];
          $RS['replyDate'] = date('F j, Y');
          $RS['reply'] = '';
          if ($_POST['myReply'] == 'acceptO')
            $RS['reply'] = 'Y';
          else if ($_POST['myReply'] == 'rejectO')
            $RS['reply'] = 'N';

          $RSreply = $RS['reply'];
          if ($RS['reply'] == 'Y')
          {
            if ($RS['recommendation'] == 'C' || $RS['recommendation'] == 'F')
            {
              $fileOK = $this->getUploadKeyfile ($appNo, $keyfile, $fileExt);
            }
            else if ($RS['recommendation'] == 'CF')
            {
              $fileOK = true;
            }
          }
        }
        else
        {
          $msgErr = "Email does not match, process terminated. Please login and submit again.";
          $error = true;  
        }
      }

      if (!$error)
      {
        if ($fileOK || $RS['reply'] == 'N')
        {
          $rawName = '';
          $destFile = '';

          $this->SlipModel->genReplySlip ($RS, $rawName, $destFile, $keyfile, $fileExt);

          $head = EMAIL_HEAD_NOREPLY;
          $msg = $head . "Dear ".$RS['appName'].",<br/><br/>Please find your submitted reply slip attached in this email.<br/><br/><br/>"; 

          $subject = 'HKU Engineering Admissions '.$acadYear.' - Acknowledgment of receipt of reply slip';
          $this->AppAuthModel->emailWithFile ($subject, $msg, $recipientEmail, $emailFooter, $destFile);
          $this->UploadModel->uploadReplySlip ($appNo, $rawName);
          $this->AppAuthModel->updateReply ($RS, false);

          // testing
          $subject = 'CHECKING: '.$RS['appNo'].' '.$subject;
          $msg = $msg . "<br/>post array<br/>" . print_r($_POST, true) . "<br/>RS array<br/>" .print_r($RS, true);
          $superEmail = 'mmchoy@hku.hk';
          $this->AppAuthModel->emailWithFile ($subject, $msg, $superEmail, $emailFooter, $destFile);
          // testing

          $msgInfo = "Thank you for your submission. A copy your submitted reply slip will be emailed to you. You will be informed of the next step in due course.";
        }
        else
        {
          $msgErr = "Something is wrong with your submission. Please check the file properties (only accept jpg, jpeg, png; min size 1MB; max size 2MB) and login to submit again. Thank you.";
          $error = true;
        }
      }
    }

    if ($error)
    {
      $this->session->set_flashdata("error", $msgErr);
      redirect("status/done","refresh");
    }
    else
    {
      $this->session->set_flashdata("info", $msgInfo);
      redirect("display/reply");
    }
  }

  // reply slip received, payment pending. now upload payment slip
  public function uploadPS () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileExt = '';
    $keyfile = 'paymentSlip';  
    $msgErr = '';
    $error = false;

    //print_r($_POST);
    $recipientEmail = $_POST['email'];
    $appNo = $_SESSION['appNo'];
    
    $currCode = $this->AppAuthModel->getCurrCode ($appNo);
    $emailFooter = 'e'; // general footer
    
    $acadYear = $this->SlipModel->getUserDefinedText ('ACADyear');
    /*
    // special arrangement for 2023 admission year
    $admYear = $this->AppAuthModel->getAdmYear ($appNo);
    $acadYear = '';
    if ($admYear == 2023 || $admYear == '2023')
      $acadYear = '2023-24';
    else
      $acadYear = $this->SlipModel->getUserDefinedText ('ACADyear');
    */

    if ($this->input->post('submit') == "Upload payment slip")
    {
      if ($this->AppAuthModel->isAppNoEmailCorrect($appNo, $recipientEmail))
      {
        $RS = array ();
        $this->AppAuthModel->getAppReplySlipDetails ($appNo, $RS);
        if ($RS['replyStatus'] == 'P')
        {
          $ok = $this->getUploadKeyfile ($appNo, $keyfile, $fileExt);
          if (!$ok)
          {
            $this->session->set_flashdata("error", "Something is wrong with your submission. Please check the file properties (only accept jpg, jpeg, png; min size 1MB; max size 2MB) and login to submit again. Thank you.");
            $error = true;
          }
          else      // upload payment slip successful
          {
            $RS['reply'] = 'Q';   // stop applicant from uploading again
            $rawName = '';
            $destFile = '';
            $this->SlipModel->genPaymentSlip ($RS, $rawName, $destFile, $keyfile, $fileExt);

            $head = EMAIL_HEAD_NOREPLY;
            $msg = $head . "Dear ".$RS['appName'].",<br/><br/>This is to acknowledge receipt of proof of payment of the deposit, which will be verified. You will be informed of the next step in due course.<br/>";

            $subject = "HKU Engineering Admissions ".$acadYear." - Acknowledgement of receipt of payment proof";
            $this->AppAuthModel->emailWithFile ($subject, $msg, $recipientEmail, $emailFooter, $destFile);
            $this->UploadModel->uploadPaymentSlip ($appNo, $rawName);
            $this->AppAuthModel->updateReply ($RS, true);
            sleep(2);

            $this->session->set_flashdata("info", "Thank you for your submission. You will be informed of the next step in due course.");

            //echo nl2br ("Thank you for your submission. You will be informed of the next step in due course.");
          }
        }
        else
        {
          $this->session->set_flashdata("error", "Something is wrong with your submission, process terminated. Please check your file and submit again.");
          $error = true;

          //echo nl2br ("Something is wrong with your submission, process terminated. Please check your file and submit again.");
        }
      }
      else
      {
        $this->session->set_flashdata("error", "Email does not match, process terminated. Please login and submit again.");
        $error = true;

        //echo nl2br ("Email does not match, process terminated. Please login and submit again.");
      }
    }
    else
    {
      $this->session->set_flashdata("error", "Problem with file size, process terminated.");
      $error = true;

      //echo nl2br ("Email does not match, process terminated. Please login and submit again.");
    }

    if ($error)
    {
      redirect("status/done","refresh");
    }
    else
    {
      redirect("display/payment");
    }
  }

  public function done()
  {
    ini_set('display_errors', 0);     // do not display errors
    $temp = $this->session->flashdata();
    $_SESSION = array ();   // clear data
    $this->session->set_flashdata($temp);
    $data = array();
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appLogoutView', $data);
  }
  
}

?>
