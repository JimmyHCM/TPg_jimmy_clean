<?php
use phpDocumentor\Reflection\Types\Null_;

include_once APPPATH."config/userConstants.php";

class AppAuthModel extends CI_Model 
{

  function __construct () 
  {
    parent::__construct ();
    $this->load->model('SlipModel');

    date_default_timezone_set("Asia/Hong_Kong");
    $this->dblog = $this->load->database('tpglog',TRUE);
  }

  // check if this is daily maintanence time
  // Daily maintenance: 2:00-4:59 UTC+8, 14:00-14:59 UTC+8
  function isSystemDownTime ()
  {
    ini_set('display_errors', 0);     // do not display errors
    $downTime = false;
    if (date('H') == 2 || date('H') == 3 || date('H') == 4 || date('H') == 14) 
      $downTime = true;

    // special maintenance
    //if ((date('Ymd') == 20241130 && date('H') >= 12) || (date('Ymd') == 20241201 && date('H') < 22))
    //  $downTime = true;

    return $downTime;
  }

  // check if applicant exists. use appNo to search db
  function isApplicationExist($appNo)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      return true;
    }
    else 
    {
      return false;
    }
  }

  // get appStatus
  function getAppStatus ($appNo)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("appNo, appStatus");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      return $row->appStatus;
    }
    else 
    {
      return '';
    }
  }

  // get replyStatus
  function getReplyStatus ($appNo)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("appNo, replyStatus");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('offerReply');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      return $row->replyStatus;
    }
    else 
    {
      return false;
    }
  }

  // get admYear
  function getAdmYear ($appNo)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("admYear");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('offerReply');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      return $row->admYear;
    }
    return 999;
  }

  // get createDate
  function getAppCreatedDate ($appNo)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("appNo, createDate");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      return $row->createDate;
    }
    else 
    {
      log_message('debug', 'AppAuthModel/getAppCreatedDate: createDate not exist!!!!');
      return false;
    }
  }

  // get reply slip info
  function getAppReplySlip ($appNo, &$RS)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("appNo, currCode, replyStatus, deadline, replyDate");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('offerReply');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      $RS['appNo'] = $appNo;
      $RS['currCode'] = $row->currCode;
      $RS['replyStatus'] = $row->replyStatus;
      $RS['deadline'] = $row->deadline;
      $RS['replyDate'] = $row->replyDate;
      return true;
    }
    else 
    {
      return false;
    }
  }

  // update reply to table
  function updateReply ($RS, $forPaymentSlip)
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $RS['appNo'];

    $tobeUpdated = array ();
    $tobeUpdatedRS = array ();

    $tobeUpdatedRS = array (
      'appNo' => $appNo,
      'recommendation' => $RS['recommendation'],
      'replyStatus' => $RS['reply'],
      'uploadTime' => mdate('%Y-%m-%d %H:%i:%s', now()),
    );

    $dateNow = date ('Y-m-d');
    if ($forPaymentSlip)
    {
        $tobeUpdated = array (
        'appNo' => $appNo,
        'replyStatus' => $RS['reply'],
        );
    }
    else
    {
      $tobeUpdated = array (
        'appNo' => $appNo,
        'replyStatus' => $RS['reply'],
        'signature' => $RS['signature'],
        'replyDate' => $dateNow,
      );
    }

    // update table
    // do transaction as a group
    $this->db->trans_start();

    $this->db->insert('rsUpload', $tobeUpdatedRS);

    $this->db->where('appNo', $appNo);
    $this->db->update('offerReply', $tobeUpdated);

    $this->db->trans_complete();

    $log = array(
     'sqlDetails'  => TRUE,   //write SQLlog if TRUE
     'oldData'     => '',
     'newData'     => '',
     'sqlAction'   => 'update offerReply'.print_r($tobeUpdated, true),
    );
    $this->AppAuthModel->writeSQLlog ($log);
    log_message('info', 'AppAuthModel/updateReply: applicant reply slip submitted for '.$appNo.$RS['recommendation'].' '.$RS['reply']);
  }

  // get reply slip detail info
  function getAppReplySlipDetails ($appNo, &$RS, $needConfirm=false)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select("replyStatus, currCode, appName, studyMode, acadPlanCode, issueDate, deadline, replyDate, signature, recommendation, provisional, admYear, isLocal");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('offerReply');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      // check error
      if ($needConfirm && ($row->currCode != $RS['currCode'] || $RS['replyStatus'] != $row->replyStatus))
        return false;
      else
      {
        $currCode = $row->currCode;
        $admYear = $row->admYear;
        $appName = $row->appName;
        $issueDate = $row->issueDate;
        $acadPlanCode = $row->acadPlanCode;
        $deadline = $row->deadline;
        $replyDate = $row->replyDate;
        $signature = $row->signature;
        $provisional = $row->provisional;
        $studyMode = $row->studyMode;
        $isLocal = $row->isLocal;
        $replyStatus = $row->replyStatus;
        $recommendation = $row->recommendation;

        $RS['currCode'] = $currCode;
        $RS['admYear'] = $admYear;
        $RS['appNo'] = $appNo;
        $RS['replyStatus'] = $replyStatus;
        $RS['reply'] = '';
        $RS['recommendation'] = $recommendation;

        if ($studyMode == 'F')
        {
          $studyMode = 'Full-time';
          $currLen = '1';
        }
        else if ($studyMode == 'P')
        {
          $studyMode = 'Part-time';
          $currLen = '2';
        }
        if ($currCode == 396)
        {
          $currLen = '1.5';
        }
        
        $currTitle = '';
        $titleDisplay = '';
        $currFee = '';
        $currFeeL = '';
        $currFeeNL = '';
        $totalCredit = '';
        $RSfooterFT = '';
        $RSfooterPT = '';
        $this->db->select("currTitle, titleDisplay, fee, feeL, feeNL, totalCredit,  RSfooterLFT, RSfooterLPT, RSfooterNLFT, RSfooterNLPT");
        $this->db->where('currCode', $currCode);
        $currQuery = $this->db->get('currInfo');
        if ($currQuery->num_rows() > 0) 
        {
          $row = $currQuery->row();
          $currTitle = $row->currTitle;
          $titleDisplay = $row->titleDisplay;
          $currFee = $row->fee;
          $currFeeL = $row->feeL;
          $currFeeNL = $row->feeNL;
          $totalCredit = $row->totalCredit;
          $RSfooterLFT = $row->RSfooterLFT;
          $RSfooterLPT = $row->RSfooterLPT;
          $RSfooterNLFT = $row->RSfooterNLFT;
          $RSfooterNLPT = $row->RSfooterNLPT;
        }

        $acadPlanTitle = '';
        if ($acadPlanCode != '' && $acadPlanCode != null)
        {
          $this->db->select("acadPlanTitle");
          $this->db->where('acadPlanCode', $acadPlanCode);
          $acadPlanQuery = $this->db->get('streamInfo');
          if ($acadPlanQuery->num_rows() > 0) 
          {
            $row = $acadPlanQuery->row();
            $acadPlanTitle = $row->acadPlanTitle;
          }
        }

        $RS['studyMode'] = $studyMode;
        $RS['currLen'] = $currLen;
        $RS['currCode'] = $currCode;
        $RS['currTitle'] = $currTitle;
        $RS['totalCredit'] = $totalCredit;
        $RS['titleDisplay'] = $titleDisplay;
        $RS['acadPlanCode'] = $acadPlanCode;
        $RS['acadPlanTitle'] = $acadPlanTitle;
        $RS['appName'] = $appName;
        $date = date_create ($issueDate);
        $RS['issueDate'] = date_format ($date, "F j, Y");
        $date = date_create ($deadline);
        $RS['deadline'] = date_format ($date, "F j, Y");
        if ($replyDate != '' && $replyDate != null)
        {
          $date = date_create ($replyDate);
          $RS['replyDate'] = date_format ($date, "F j, Y");
          $RS['signature'] = $signature;
        }
        else
        {
          $RS['replyDate'] = '';
          $RS['signature'] = '';
        }
        
        $RS['provisional'] = $provisional;
        
        $line = '';

        $RS['acadYear'] = $this->SlipModel->getUserDefinedText ('ACADyear');
        $RS['commencingDate'] = $this->SlipModel->getUserDefinedText ('COMmencingDate');
          
        if ($isLocal == 'Y')
        {
          $RS['compFeeCurr'] = 'HK$'. number_format ($currFeeL);
        }
        else
        {
          $RS['compFeeCurr'] = 'HK$'. number_format ($currFeeNL);
        }

        if ($studyMode == 'Full-time')
        {
          if ($isLocal == 'Y')
          {
            $line = $RSfooterLFT;
          }
          else
          {
            $line = $RSfooterNLFT;
          }
        }
        else  // part time
        {
          if ($isLocal == 'Y')
          {
            $line = $RSfooterLPT;
          }
          else
          {
            $line = $RSfooterNLPT;
          }
        }
        
        if ($provisional == 'Y')
        {
          $line = str_replace ('*', '<sup>*</sup>', $line);
        }
        else
        {
          $line = str_replace ('*', '', $line);
        }
        $RS['RSfooter'] = $line;

        return true;
      }
    }
    return false;
  }

  // check if the pair (appNo, email) is correct
  function isAppNoEmailCorrect($appNo, $email) 
  {
    ini_set('display_errors', 0);     // do not display errors
    $status = $this->AppAuthModel->verifyUser($appNo, $email, false);
    if ($status == 'A')
    {
      return TRUE;
    }
    return FALSE;
  }

  // check if the pair (appNo, email) is correct and return status
  function verifyUser($appNo, $email, $staff=false) 
  {
    ini_set('display_errors', 0);     // do not display errors

    if ($appNo < 1105900000)
      return 'O';     // not current admission year
    else
    {
      $this->db->select("appNo, email, status, studStatus");
      $this->db->where('appNo', $appNo);
      $query = $this->db->get('application');

      if ($query->num_rows() > 0) 
      {
        foreach ($query->result() as $row) 
        {
          if ($staff || (!$staff && password_verify(strtolower($email), $row->email)) )
          {
            $_SESSION['currentStatus'] = $row->studStatus;
            return $row->status;
          }
        }
      }
      return 'X';
    }
  }

  function getCurrCode ($appNo)
  {
    $this->db->select("currCode");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();
      return $row->currCode;
    }
    return -1;
  }

  // check if user is staff
  function verifyStaff ($appNo, &$email) 
  {
    ini_set('display_errors', 0);     // do not display errors
    $uid = $email;

    // check for special testing or maintenance
    if ($appNo == 2200123123 && $email == 'mmchoy')
    {
      $_SESSION['uid'] = $uid;
      return 'M';
    }

    $email = $uid . '@hku.hk';
    $this->db->select("email, status");
    $this->db->where('portalID', $uid);
    $query = $this->db->get('enggStaff');

    if ($query->num_rows() > 0) 
    {
      foreach ($query->result() as $row) 
      {
        if (password_verify($email, $row->email)) 
        {
          $_SESSION['appNo'] = $appNo;
          $_SESSION['uid'] = $uid;
          return $row->status;
        }
      }
    }
    return 'X';
  }

  // too many login attempts, account set inactive for a few hours
  function setInactive()
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $_SESSION['appNo'];
    $this->db->set('status', 'I');
    $this->db->where('appNo', $appNo);
    $this->db->update('application');

    //write SQLlog if TRUE
    
    $log = array(
     'sqlDetails'  => TRUE,
     'oldData'     => '',
     'newData'     => '',
     'sqlAction'   => 'account set inactive due to too many login attempts',
    );
    $this->AppAuthModel->writeSQLlog ($log);
  }

  function emailNoFile ($subject, $msg, $recipientEmail, $footer='e')
  {
    ini_set('display_errors', 0);     // do not display errors
    $to = $recipientEmail;
    return ($this->sendEmail($to, $subject, $msg, $footer));
  }

  function emailWithFile ($subject, $msg, $recipientEmail, $footer, $fileAttach)
  {
    ini_set('display_errors', 0);     // do not display errors
    $to = $recipientEmail;
    return ($this->sendEmail($to, $subject, $msg, $footer, $fileAttach));
  }

  private function sendEmail($to, $subject, $message, $footer='e', $fileAttach='')
  {
    ini_set('display_errors', 0);     // do not display errors
    // Note: no $config param needed if it exists config/email.php
    $this->load->helper('path');
    $this->load->library('email');

    $this->email->from(FROM_TPG, TPG_EXTERNAL_NAME);
    $this->email->set_newline("\r\n");
    $this->email->to($to);
    $this->email->subject($subject);

    if ($footer == 'e')
      $message = $message . "<br/><br/>" . EMAIL_FOOTER;
    else if ($footer == 'c')  // for SCDS
      $message = $message . "<br/><br/>" . SCDS_EMAIL_FOOTER;

    $this->email->message($message);

    if ($fileAttach != '')
    {
      $path = set_realpath ($fileAttach);
      $this->email->attach ($path, 'attachment', 'yourReply.pdf');
      //echo $this->email->print_debugger();
    }
    
    if ($this->email->send()) 
    {
        //write Emaillog
        $log = array(
                'status'        => 'S',
                'emailAction'   => 'send '.$subject.' succussfully',
        );
            
        $this->AppAuthModel->writeEmaillog($log);
            
        return TRUE;
        
    } 
    else 
    {
        //write Emaillog
        $log = array(
            'status'        => 'E',
            'emailAction'   => 'send '.$subject.' error',
            'emailText'     => "$this->email->print_debugger()"
        );
        
        $this->AppAuthModel->writeEmaillog($log);
        return FALSE;
    }
  }

  function sendOtpCode($OtpCodePrefix, $OtpCode, $recipientEmail)
  {    
    ini_set('display_errors', 0);     // do not display errors
    $to = $recipientEmail;
    $subject = "TPg One Time Password";
    $message = "The OTP code is: ". $OtpCodePrefix."-".$OtpCode;

    return ($this->sendEmail($to, $subject, $message));
  }


  // get media list from mediaMap table
  public function getSurveyMediaList (&$mediaList)
  {
    ini_set('display_errors', 0);     // do not display errors

    $this->db->select("mediaName");
    $this->db->order_by('order', 'asc');
    $query = $this->db->get('mediaMap');

    if (!empty ($query->result()))
    {
      $mediaList = array_column($query->result_array(), 'mediaName');
    }
  }

  // get survey status
  function takenSurvey ($appNo) 
  {
    ini_set('display_errors', 0);     // do not display errors

    $this->db->select("mediaSurvey");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $user = $query->first_row();   
      if ($user->mediaSurvey == NULL || $user->mediaSurvey == 'N')   // not yet taken the survey
      {
        return false;
      }
      return true;
    }
  }

  // get latest statusMsg
  function extractStatusMsg ($appNo, &$message) 
  {
    ini_set('display_errors', 0);     // do not display errors

    $this->db->select("statusMsg");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $user = $query->first_row();   
      if ($user->statusMsg == NULL || $user->statusMsg == '')   // no useful message
      {
        $message = '';
      }
      else
        $message = $user->statusMsg;
    }
  }

  // update survey media to table
  // update mediaSurvey in application to Y
  function updateSurvey ($appNo, $mediaChannel, $len)
  {
    ini_set('display_errors', 0);     // do not display errors

    $media = array(NULL, NULL, NULL);
    for ($i=0; $i<$len; $i++)
    {
      $media[$i] = $mediaChannel[$i];
    }

    $tobeUpdated = array (
      'appNo' => $appNo,
      'media1' => $media[0],
      'media2' => $media[1],
      'media3' => $media[2],
    );

    // insert to mediaLog table
    $this->db->set($tobeUpdated);
    $this->db->insert('mediaLog');

    // update application table    
    $tobeUpdated = array (
      'appNo' => $appNo,
      'mediaSurvey' => 'Y',
    );  
    $this->db->set($tobeUpdated);
    $this->db->where('appNo', $appNo);
    $this->db->update('application', $tobeUpdated);
  }

  public function getMultiAppNo ($appNo, &$appNoArray)
  {
    ini_set('display_errors', 0);     // do not display errors

    $this->db->select("appNo, appNoList");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('multiApp');
    $appNoArray = array ();

    if ($query->num_rows() > 0) 
    {
      $row = $query->first_row();  
      $appNoList = $row->appNoList;
      $appNoArray = explode ('|', $appNoList);
    }
  }

  // get chat history message
  public function getChatHistory ($appNo, &$allMessage, &$newMessage)
  {
    ini_set('display_errors', 0);     // do not display errors

    $this->db->select("allMessage, newMessage");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('chatHistoryApp');

    if ($query->num_rows() > 0) 
    {
      $user = $query->first_row();  
      if ($user->allMessage == NULL || $user->allMessage == '')   // no useful message
      {
        $allMessage = '';
      }
      else
        $allMessage = $user->allMessage;

      if ($user->newMessage == NULL || $user->newMessage == '')   // no useful message
      {
        $newMessage = '';
      }
      else
        $newMessage = $user->newMessage;
    }
  }

  public function importRecord($filename)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (file_exists(APPPATH.$filename)) 
    {
      $myfile = fopen(APPPATH.$filename, "r");

      $appNo = "";
      $seqNo = "";
      $email = "";
      $counter = 0;

      while (!feof($myfile)) 
      {
        $line = fgets($myfile);
        if (strpos($line, ",") == FALSE)
        {
        // empty line
        }
        else 
        {
          $appNo = substr($line, 0, 10);
          $pos = strpos($line, ",", 11);
          if ($pos - 10 < 7)
            $seqNo = "";
          else
            $seqNo = substr($line, 11, 6);

          $email = substr ($line, $pos+1);
          $email = rtrim($email);       // remove extra \n
          if ($seqNo != "") {
            $result = $this->AppAuthModel->addAppRecord($appNo, $email);
            if ($result)
              $counter++;
          }
        }
      }
      fclose ($myfile);
      return $counter;
    }
    else
      return -1;
  }

  // request application status
  // add to table to queue up. table will be sent to backend regularly for processing
  // request = 'S'tatus OR 'F'ile summary
  public function queueUpRequest ($appNo, $request)
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array (
      'appNo' => $appNo,
      'requestTime' => mdate('%Y-%m-%d %H:%i:%s', now()),
      'request' => $request,
    );

    $query = $this->db->insert('appRequest', $data);
  }
  
  function addAppRecord($appNo, $email)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (!($this->AppAuthModel->isApplicationExist($appNo))) 
    {
      $data = array(
        'appNo'    => $appNo,
        'email'    => password_hash($email, PASSWORD_DEFAULT),
        'createdDate' => mdate('%Y-%m-%d %H:%i:%s', now()),
        'status'      => "A"
      );

      $query = $this->db->insert('application', $data);

      //write SQLlog if TRUE
      
      $log = array(
       'sqlDetails'  => TRUE,
       'oldData'     => '',
       'newData'     => '',
       'sqlAction'   => 'added',
      );
      $this->AppAuthModel->writeSQLlog ($log);

      return $query;
    }
    else
      return false;
  }

  // check if current time and last action is over $second number of seconds.
  // start a new session if current session expired.
  function sessionExpired ($second)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (isset($_SESSION['lastAction']) && (time() - $_SESSION['lastAction']) < $second)
    {
      return FALSE;
    }
    else
    {
      $_SESSION['lastAction'] = time();
      return TRUE;
    }
  }

  function writeSQLlog($log) 
  {
    ini_set('display_errors', 0);     // do not display errors
    if ($log['sqlDetails'] == FALSE ) {
      $sqlText = '';
    }
    else {
      $sqlText = $this->db->last_query();
    }
    $username = '';
    if (isset($_SESSION['username']))
      $username = $_SESSION['username'];
    else
      $username = 'testing';

    $sqlData = array(
      'userID'    => $_SESSION['userID'],
      'username'  => $username,
      'sqlText'   => $sqlText,
      'oldData'   => $log['oldData'],
      'newData'   => $log['newData'],
      'sqlAction' => $log['sqlAction'],
    );

    $this->dblog->insert('sqllog', $sqlData); 
  }

  function writeEmaillog($log)
  {
    ini_set('display_errors', 0);     // do not display errors
    $userID = 'tpg';
    $username = 'tpg';
    $temp = 'tpg@hku.hk';

    if (isset($_SESSION['userID']))
      $userID = $_SESSION['userID'];
    if (isset($_SESSION['username']))
      $username = $_SESSION['username'];
    if (isset($_SESSION['temp']))
      $temp = $_SESSION['temp'];

    $sqlData = array(
      'userID'            => $userID,
      'username'          => $username,
      'createdDateTime'   => mdate('%Y-%m-%d %H:%i:%s', now()),
      'email'             => $temp,
      'status'            => $log['status'],
      'emailAction'       => $log['emailAction'],
    );
        
    $this->dblog->insert('emaillog', $sqlData);
  }

}

?>