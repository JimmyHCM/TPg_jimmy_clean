<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH."config/userConstants.php";

class Display extends CI_Controller
{

  function __construct () 
  {
    parent::__construct ();

    $this->load->model('AppAuthModel');
    $this->load->model('SupportDocModel');

    if($_SESSION['user_logged'] == FALSE)   
    {
      $this->session->set_flashdata("error", "redirecting to login page...");
      redirect("auth");
    }
  }

  private function deadlinePassed ($RS)
  {
    ini_set('display_errors', 0);     // do not display errors
    $today = date ("Y-m-d");
    $deadline = $RS['deadline'];

    if ($today > $deadline)
      return true;
    else
      return false;
  }

  private function preparePage (&$data)
  {
    ini_set('display_errors', 0);     // do not display errors
    $alreadyUploaded = array ();
    $pNo = 0;
    $titleArray = array ('', '', '', '');
    $currStud = 'N';
    $this->SupportDocModel->getLatestUploadStatus ($alreadyUploaded, $currStud, $pNo, $titleArray);
    log_message('info', 'display/preparePage: currStud is '. $currStud);
    log_message('info', 'display/preparePage: pNo is '. $pNo);

    $verified = array ();
    $this->SupportDocModel->getLatestVerifiedStatus ($verified);
    $data['verified'] = $verified;

    if ($pNo == MAX_fileDNO)
      $data['Pno'] = MAX_fileDNO;
    else
      $data['Pno'] = $pNo + 1;
//    $_SESSION['Pno'] = $data['Pno'];

    $data['uploaded'] = $alreadyUploaded;
    $_SESSION['uploaded'] = $alreadyUploaded;

    $data['titleArray'] = $titleArray;

    // 2026: academic qualification is filled next to the transcript on the
    // upload page, so every hub page prepares the values it already has.
    $acadQual = array ();
    $this->SupportDocModel->getLatestAcadQual ($acadQual);
    $data['acadQual'] = $acadQual;

    $_SESSION['lastAction'] = time();
  }

  private function prepareMenu (&$menu)
  {
    ini_set('display_errors', 0);     // do not display errors
    // menu: upload support Document, check Status, Reply slip, Payment
    $menu = '';
    $appNo = $_SESSION['appNo'];

    if ($_SESSION['getRS'])
    {
      // confirm RS
      $RS = array ();
      $hasRS = $this->AppAuthModel->getAppReplySlip ($appNo, $RS);
      if ($hasRS)
      {
        if ($RS['replyStatus'] == 'X')  // waiting for reply
          $menu = $menu . 'R';
        else if ($RS['replyStatus'] == 'P')  // pending payment
          $menu = $menu . 'P';
      }
      else
      {
        if ($appNo >= '1105000000')    // admission year 2025
        {
          $menu = $menu . 'D';
        }
      }
    }
    else
    {
      if ($appNo >= '1105000000')    // admission year 2025
      {
        $menu = $menu . 'D';
      }
    }
    $menu = $menu . 'S';

    // testing new function
    if ($appNo >= '2200000000')    // testing new function 
    {
      //$menu = $menu . 'C';  // C for chat
      $menu = $menu . 'T';    // testing function
    }

  }

  public function index() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->session->set_flashdata("error", "redirecting to login page...");
    redirect("auth");
  }

  // entry point after login
  public function start()
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $_SESSION['appNo'];
    $data = array();

    if ($_SESSION['getRS'])
    {
      // confirm RS
      $RS = array ();
      $hasRS = $this->AppAuthModel->getAppReplySlip ($appNo, $RS);
      
      if ($hasRS)
      {
        if ($RS['replyStatus'] == 'X' && ($RS['replyDate'] == null || $RS['replyDate'] == ''))        // waiting for reply
          redirect ("display/reply");
        else if ($RS['replyStatus'] == 'P')   // pending payment
          redirect ("display/payment");
        else                            // other cases
        {
          $statusMsg = '';
          $this->AppAuthModel->extractStatusMsg ($appNo, $statusMsg);
          $data['appNo'] = $_SESSION['appNo'];
          $data['statusMsg'] = $statusMsg;

          if ($statusMsg != '')
            $this->load->view('statusMsgView', $data);
          else      // no status msg
            redirect ("display/checkStatus");
        }
      }
      else  // unusual
      {
        $this->session->set_flashdata("error", "The system has encountered an error, please login again. If the error persists, please report to us.");
        redirect("display/done","refresh");
      }
    }
    else if (!$this->AppAuthModel->takenSurvey ($appNo))   // first time login
    {
      $data = array();
      $data['currentYear'] = getDate()['year'];

      $data['mediaList'] = array ();
      $this->AppAuthModel->getSurveyMediaList ($data['mediaList']);
      $data['mediaCount'] = count($data['mediaList']);

      $this->load->view('appSurveyView', $data);
    }
    else
    {
      $this->preparePage ($data);
      //print_r($data);
      //print_r($_SESSION);
      //echo nl2br ("\n\n");

      $this->prepareMenu ($data['menu']);
      $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
      $data['currentYear'] = getDate()['year'];
      $data['uploadItems'] = array();

      if ($_SESSION['appNo'] > '1105000000')    // admission 2025
      {
        $statusMsg = '';
        $this->AppAuthModel->extractStatusMsg ($appNo, $statusMsg);
        $data['appNo'] = $_SESSION['appNo'];
        $data['statusMsg'] = $statusMsg;

        if ($statusMsg != '')
          $this->load->view('statusMsgView', $data);
        else    // no status msg
        {
          $data['Pno'] = 3;
          $data['degInfo'] = array();
          $this->SupportDocModel->getDegreeInfo ($data['degInfo']);

          //print_r($data);
          $this->load->view('upload2024View', $data);
        }
      }
      else
      {
        $this->load->view('appCheckStatusView', $data);
      }
    }
  }

  public function upload()
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileErr = array ();
    $data = array ();

    if (isset ($_SESSION['fileErrCount']))
    {
      for ($i=0; $i<$_SESSION['fileErrCount']; $i++)
      {
        $fileErr[$i][0] = $_SESSION['fileErr'][$i][0];
        $fileErr[$i][1] = $_SESSION['fileErr'][$i][1];
        $fileErr[$i][2] = $_SESSION['fileErr'][$i][2];
      }
      $data['fileErr'] = $fileErr;
      $data['fileErrCount'] = $_SESSION['fileErrCount'];
      $_SESSION['fileErr'] = array ();
      $_SESSION['fileErrCount'] = 0;
    }
    $this->preparePage ($data);
    $this->prepareMenu ($data['menu']);
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');

    $data['currentYear'] = getDate()['year'];

    if ($_SESSION['appNo'] > '1105000000')
    {
      $data['Pno'] = 3;
      $data['degInfo'] = array();
      $this->SupportDocModel->getDegreeInfo ($data['degInfo']);
      $this->load->view('upload2024View', $data);
    }
    //else
    //  $this->load->view('uploadViewWorking', $data);  // 2023
  }

  // for testing
  public function uploadTest()
  {
    $fileErr = array ();
    $data = array ();

    if (isset ($_SESSION['fileErrCount']))
    {
      for ($i=0; $i<$_SESSION['fileErrCount']; $i++)
      {
        $fileErr[$i][0] = $_SESSION['fileErr'][$i][0];
        $fileErr[$i][1] = $_SESSION['fileErr'][$i][1];
        $fileErr[$i][2] = $_SESSION['fileErr'][$i][2];
      }
      $data['fileErr'] = $fileErr;
      $data['fileErrCount'] = $_SESSION['fileErrCount'];
      $_SESSION['fileErr'] = array ();
      $_SESSION['fileErrCount'] = 0;
    }
    $this->preparePage ($data);
    $this->prepareMenu ($data['menu']);
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');

    $data['currentYear'] = getDate()['year'];

    if ($_SESSION['appNo'] > '2200000000')
    {
      $data['Pno'] = 3;
      $data['degInfo'] = array();
      $this->SupportDocModel->getDegreeInfo ($data['degInfo']);
      $this->load->view('uploadTest2024View', $data);
    }
    //else
    //  $this->load->view('uploadViewWorking', $data);  // 2023
  }

  // 2026: the separate mark sheet page is gone -- the academic qualification is
  // now filled in the institution's own section of the upload page. Kept as a
  // redirect so old links and bookmarks still land somewhere useful.
  public function fillMarkSheet()
  {
    ini_set('display_errors', 0);     // do not display errors
    redirect ("display/upload");
  }

  public function summary ()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $this->prepareMenu ($data['menu']);
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appUploadSummaryView', $data);
  }

  public function faq()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $this->prepareMenu ($data['menu']);
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appFAQView', $data);
  }

  public function checkStatus()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $this->prepareMenu ($data['menu']);
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appCheckStatusView', $data);
  }

  public function checkMessage()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $this->prepareMenu ($data['menu']);
    $data['currentYear'] = getDate()['year'];
    $allMessage = '';
    $newMessage = '';

    $appNo = $_SESSION['appNo'];
    $data['appNo'] = $appNo;
    $this->AppAuthModel->getChatHistory ($appNo, $allMessage, $newMessage);
    $data['allMessage'] = $allMessage;
    $data['newMessage'] = $newMessage;

    //echo nl2br($allMessage);
    //echo nl2br($newMessage);

    $this->load->view('checkMessageView', $data);
  }

  public function reply()
  {
    ini_set('display_errors', 0);     // do not display errors
    $ok = false;
    $appNo = $_SESSION['appNo'];
    $msg = '';
    $data = array();

    if ($_SESSION['getRS'])
    {
      // confirm RS
      $RS = array ();
      $hasRS = $this->AppAuthModel->getAppReplySlip ($appNo, $RS);

      if ($hasRS)
      {
        if ($RS['replyStatus'] == 'X')  // waiting for reply
        {
          if ($this->deadlinePassed ($RS))
          {
            $msg = "Deadline for reply slip submission had passed, please contact department office.";
          }
          else
          {
            $this->AppAuthModel->getAppReplySlipDetails ($appNo, $RS, true);
            $data['RS'] = $RS;
            $data['replied'] = false;
            $ok = true;
            $this->prepareMenu ($data['menu']);
            $data['currentYear'] = getDate()['year'];
            $this->load->view('appReplyView', $data);
          }
        }
        else if ($RS['replyDate'] != '' && $RS['replyDate'] != null)
        {
          $data = array ();
          $data['replied'] = true;
          $ok = true;
          $this->prepareMenu ($data['menu']);
          $data['currentYear'] = getDate()['year'];
          $this->load->view('appReplyView', $data);
        }
      }
    }

    if (!$ok)
    {
      if ($msg == '')
        $msg = "Something is wrong.... the session needs to be closed.";

      $this->session->set_flashdata("error", $msg);
      redirect("display/done","refresh");
    }
  }

  public function payment ()
  {
    ini_set('display_errors', 0);     // do not display errors
    $ok = false;
    $appNo = $_SESSION['appNo'];
    $msg = '';
    $data = array();

    if ($_SESSION['getRS'])
    {
      // confirm RS
      $RS = array ();
      $hasRS = $this->AppAuthModel->getAppReplySlip ($appNo, $RS);
      if ($hasRS)
      {
        if ($RS['replyStatus'] == 'P')  // accepted and reply slip submitted, waiting for payment
        {
          if ($this->deadlinePassed ($RS))
          {
            $msg = "Deadline for reply slip submission had passed, please contact department office.";
          }
          else
          {
            $data['RS'] = $RS;
            $ok = true;
            $this->prepareMenu ($data['menu']);
            $data['currentYear'] = getDate()['year'];
            $this->load->view('appPaymentView', $data);
          }
        }
        else if ($RS['replyStatus'] == 'Q')   // just uploaded payment
        {
          $data = array ();
          $data['replied'] = true;
          $ok = true;
          $this->prepareMenu ($data['menu']);
          $data['currentYear'] = getDate()['year'];
          $this->load->view('appPaymentView', $data);
        }
      }
    }

    if (!$ok)
    {
      if ($msg == '')
        $msg = "Something is wrong.... the session needs to be closed.";

      $this->session->set_flashdata("error", $msg);
      redirect("display/done","refresh");
    }
  }

  public function done()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $temp = $this->session->flashdata();
    $_SESSION = array ();   // clear data
    $this->session->set_flashdata($temp);
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appLogoutView', $data);
  }

  // statusMsg had shown, now start uploading or check status for outdated applications
  public function statusShown ()
  {
    ini_set('display_errors', 0);     // do not display errors

    $appNo = $_SESSION['appNo'];

    $this->preparePage ($data);
    $this->prepareMenu ($data['menu']);
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
    $data['currentYear'] = getDate()['year'];
    $data['uploadItems'] = array();

    if ($_SESSION['appNo'] > '1106000000')
    {
      $data['Pno'] = 3;
      $data['degInfo'] = array();
      $this->SupportDocModel->getDegreeInfo ($data['degInfo']);

      //print_r($data);
      $this->load->view('upload2024View', $data);
    }
    else
    {
      $this->load->view('appCheckStatusView', $data);
    }
  }

  // count media channel
  public function survey()
  {
    ini_set('display_errors', 0);     // do not display errors

    $mediaChannel = $_POST['mediaChannel'];
    $len = count($mediaChannel);

    $appNo = $_SESSION['appNo'];
    $this->AppAuthModel->updateSurvey ($appNo, $mediaChannel, $len);

    $this->preparePage ($data);
    $this->prepareMenu ($data['menu']);
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
    $data['currentYear'] = getDate()['year'];
    $data['uploadItems'] = array();
    
    if ($_SESSION['appNo'] > '1104000000')
    {
      $statusMsg = '';
      $this->AppAuthModel->extractStatusMsg ($appNo, $statusMsg);
      $data['appNo'] = $_SESSION['appNo'];
      $data['statusMsg'] = $statusMsg;

      if ($statusMsg != '')
        $this->load->view('statusMsgView', $data);
      else
      {
        $data['Pno'] = 3;
        $data['degInfo'] = array();
        $this->SupportDocModel->getDegreeInfo ($data['degInfo']);

        //print_r($data);
        $this->load->view('upload2024View', $data);
      }
    }
    else
    {
      $this->load->view('appCheckStatusView', $data);
    }
  }

  public function writeMessage ()
  {    
    ini_set('display_errors', 0);     // do not display errors

    $toDept = $_POST['toDept'];
    $appNo = $_POST['appNo'];
    $tobeUpdated = array ();

    if ($this->input->post('submit') == "sendMsg") 
    {
      $today = date ("Y-m-d H:i");
      $newMessage = $today . ' [to dept]<br>' .$toDept;
      $tobeUpdated[] = array (
        'appNo' => $appNo,
        'newMessage' => $newMessage,
      );

      if (!empty ($tobeUpdated))
      {
        $this->db->update_batch ('chatHistoryApp', $tobeUpdated, 'appNo');
      }

      $this->session->set_flashdata("info", "message sent");
      //sleep (2);
      //echo '<script type="text/javascript">alert ("message sent.");</script>';
    }
    redirect ("display/start");
  }
}

?>
