<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH."config/userConstants.php";

class Testing extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->model('CSVModel');
		$this->load->model('SupportDocModel');
    $this->load->model('UploadModel');
    $this->load->model('SlipModel');
		$this->load->model('AppAuthModel');

    date_default_timezone_set("Asia/Hong_Kong");
    $this->dblog = $this->load->database('tpglog',TRUE);
	}

  public function index()
  {
  }

  public function trytry ()
  {
    $temp = $this->SlipModel->getUserDefinedText ('ACADyear');
    echo nl2br($temp);
  }

  // identify missing cases in reply slip
  public function trytryR ()
  {
    $appNoArray = array (1104085785);
    //$tobeUpdated = array ();
    $tobeUpdatedRS = array ();
    $appNo = 1104085785;
    $RS = array ();

    $this->AppAuthModel->getAppReplySlipDetails ($appNo, $RS, false);

    print_r($RS);

/*
    $this->db->select('appNo, replyStatus, replyDate');
    $this->db->where('replyStatus', 'X');
    $this->db->where_in('appNo', $appNoArray);
    $query = $this->db->get('offerReply');

    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $row)
      {
        $appNo = $row->appNo;
        $replyStatus = 'Y';
        $replyDate = date ('Y-m-d', strtotime ('2023-11-14'));
        
        $tobeUpdated[] = array (
          'appNo' => $appNo,
          'replyStatus' => $replyStatus,
          'replyDate' => $replyDate,
          'signature' => $RS['signature'],
        );
        */
/*
        $tobeUpdatedRS[] = array (
          'appNo' => $appNo,
          'recommendation' => 'F',
          'replyStatus' => 'Y',
          'uploadTime' => $replyDate,
        );*/
        
        //echo ($appNo.', ');
      //}
      //$appNoArray1 = array_column($query->result_array(), 'appNo');
      //$count = count ($appNoArray1);

      //echo nl2br ("application ". $count.": \n");
      //print_r($tobeUpdated);
      //print_r($tobeUpdatedRS);
      echo nl2br ("\n\n");

      //$this->db->trans_start();

      //$this->db->update_batch('offerReply', $tobeUpdated, 'appNo');
      //$this->db->insert_batch('rsUpload', $tobeUpdatedRS);

      //$this->db->trans_complete();
    //}
  }

  public function clearLog()
  {
    $timeCheck = date('Y-m-d H:i:s', strtotime('2019-10-17'));

    $this->dblog->where ('createdDateTime <', $timeCheck);
    $this->dblog->delete('sqllog');

  }

  // check if the list of application numbers are in the database tables
  public function listAppNo ()
  {
    $appNoArray = array (2200555052,2200555053,2200555054,2200555055);

    $this->db->select('appNo');
    $this->db->where_in('appNo', $appNoArray);
    $this->db->order_by('appNo', 'ASC');
    $query = $this->db->get('application');

    if ($query->num_rows() > 0)
    {
      $appNoArray1 = array_column($query->result_array(), 'appNo');
      $count = count ($appNoArray1);

      echo nl2br ("application ". $count.": \n");
      print_r($appNoArray1);
      echo nl2br ("\n\n");
    }

    $this->db->reset_query();
    $this->db->select('appNo');
    $this->db->where_in('appNo', $appNoArray);
    $this->db->order_by('appNo', 'ASC');
    $query = $this->db->get('applicationNew');

    if ($query->num_rows() > 0)
    {
      $appNoArray1 = array_column($query->result_array(), 'appNo');
      $count = count ($appNoArray1);

      echo nl2br ("applicationNew ". $count.": \n");
      print_r($appNoArray1);
      echo nl2br ("\n\n");
    }

    $this->db->reset_query();
    $this->db->select('appNo');
    $this->db->where_in('appNo', $appNoArray);
    $this->db->order_by('appNo', 'ASC');
    $query = $this->db->get('applicationProcessed');

    if ($query->num_rows() > 0)
    {
      $appNoArray1 = array_column($query->result_array(), 'appNo');
      $count = count ($appNoArray1);

      echo nl2br ("applicationProcessed ". $count.": \n");
      print_r($appNoArray1);
      echo nl2br ("\n\n");
    }

    $this->db->reset_query();
    $this->db->select('appNo');
    $this->db->where_in('appNo', $appNoArray);
    $this->db->order_by('appNo', 'ASC');
    $query = $this->db->get('applicationTemp');

    if ($query->num_rows() > 0)
    {
      $appNoArray1 = array_column($query->result_array(), 'appNo');
      $count = count ($appNoArray1);

      echo nl2br ("applicationTemp ". $count.": \n");
      print_r($appNoArray1);
      echo nl2br ("\n\n");
    }
  }

  public function genCheckSum ()
  {
    $source = "/var/www/html/app/temp.txt"; 
    $myfile = fopen($source, "r") or die ("unable to open");

    $appNo = "";
    $courseNo = "";
    $courseTotal = "";
    $sum1 = "";
    $sum2 = "";
    $calcSum1 = 0;
    $calcSum2 = 0;
    $gradeTotal = 0;
    $checksum = "";

    $calcString = "";
    $counter = 0;
    $dataEnd = false;

    while (!$dataEnd && !feof($myfile)) 
    {
      $temp = fgets($myfile);
      $tt = rtrim($temp);
      $tt = trim($tt, "\"");
      $buffer = explode(",", $tt);
      if ($appNo == "")
      {
        $appNo = $buffer[1];
        $markSheet['name'] = $buffer[0];
        $markSheet['deg'] = $buffer[2];
        $markSheet['uni'] = $buffer[3];
        $markSheet['u985'] = $buffer[4];
        $markSheet['u211'] = $buffer[5];
        $markSheet['key'] = $buffer[8];
        $markSheet['calcDate'] = $buffer[7];
        $markSheet['passing'] = $buffer[6];
      }
      else // get letter grade, sum1, sum2
      {
        $end = substr ($tt, -4);
        if ($end == ",,,,")  // last line with original checksum
        {
          $dataEnd = true;
          $calcString = $tt;
        }
        else // parse the course details
        {
          // buffer: year semester coursecode title creditunit mark gpa grade
          for ($i=0; $i<8; $i++)
          {
            $markSheet['row'][$counter][$i] = $buffer[$i];
          }
          
          $grade = $buffer[7];
          if ($grade != "")
            $gradeTotal += ord($grade);

          $c = $buffer[4];  // course credits
          $m = $buffer[5];  // score / mark
          $g = $buffer[6];  // gpa
          if ($m != "")
          {
            $s1 = doubleval($c) * doubleval($m);
            $calcSum1 += $s1;
          }
          if ($g != "")
          {
            $s2 = doubleval($c) * doubleval($g);
            $calcSum2 += $s2;
          }
          $counter++;
        }
      }
    }

    if ($dataEnd && !feof($myfile)) 
    {
      $tt = rtrim($calcString);
      $tt = trim($tt, "\"");
      $tt = rtrim($tt, ",");
      $checksum = $tt;
    }
    fclose ($myfile);

    $courseTotal = $counter;
    $markSheet['courseTotal'] = $courseTotal;

    // check sum
    $line = $appNo . "*" . $courseTotal . "*" . $calcSum1 . "*" . $calcSum2 . "*" . $gradeTotal;

    echo nl2br ("line: ".$line."\n");

    $newchecksum = strtoupper ($this->CSVModel->calcCheckSum ($line));

    echo nl2br ("checksum generated: ".$newchecksum."\n");
    echo nl2br ("checksum from file: ".$checksum."\n");

    $errMsg = '';
    if ($checksum != $newchecksum)    // checksum not match
    {
      $errMsg = "calculated checksum: ".$newchecksum." original checksum: ".$checksum." checksum not match. modified mark sheet will not be accepted. ";
    }
    echo nl2br ("err: ".$errMsg."\n");
    
    fclose ($infile);
  }

  public function checkEmail ()
  {
    $appNo = '1102690457';
    $email = 'wenqianchen1998@163.com';

    $this->db->select("appNo, email, appStatus");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0)
    {
      $row = $query->row();
      if (password_verify(strtolower($email), $row->email)) 
      {
        echo nl2br ("app: ".$appNo."\n");
        echo nl2br ("email: ".$row->email."\n");
        echo nl2br ("status: ".$row->appStatus."\n");
      }
      else
      {
        echo nl2br ("app: ".$appNo."\n");
        echo nl2br ("email: ".$row->email."\n");
        echo nl2br ("failed\n");
      }
    }
  }

  public function uploadFileApp ()
  {
    // name the file as appNokeyfile.txt
    // copy the txt to: UPLOAD_DIR . $appNo . "/" . file_name;
    // run this function

    //$appNo = '1101792832';
    $appNo = '2202400138';
    $_SESSION['appNo'] = $appNo;
   	$_SESSION['userID'] = $appNo;
   	$_SESSION['username'] = $appNo;
    $keyfile = 'fileD14';                 // change this
    $titleArray = array ('BENG_NJU', '', '', '');

    $markedFieldNames = array ();
    $averageMark = array ();
    $averageMark['fileD14'] = 0;
    $averageMark['fileD24'] = 0;
    $averageMark['fileD34'] = 0;
    $avgMarkByStudent = array ();   // entered as text by student
    $avgMarkByStudent['fileD14'] = '';
    $avgMarkByStudent['fileD24'] = '';
    $avgMarkByStudent['fileD34'] = '';
    $avg = 0;

    $uploadData = array (
    	'raw_name' => $appNo.$keyfile,
      'file_name' => $appNo.$keyfile.'.txt',
    );

    $fileNameHash = md5($uploadData['raw_name']);
    echo nl2br("hash: ".$fileNameHash."\n\n");
    $fileName = $uploadData['file_name'];
    $source = UPLOAD_DIR . $_SESSION['appNo'] . "/" . $fileName;
    echo nl2br("validating file: ".$source."\n\n");

    $markSheet = array ();
    $errMsg = '';
    $result = $this->CSVModel->validateChecksum ($uploadData, $markSheet, $errMsg);
    $avgMarkByStudent[$keyfile] = $markSheet['avgMarkByStudent'];

    $this->CSVModel->genMSexcel ($uploadData, $markSheet, $avg, $result);

    $markedFieldNames[$keyfile] = "xlsx";
    $averageMark[$keyfile] = $avg;

    $this->SupportDocModel->markFileToUpload($markedFieldNames, $titleArray, $averageMark, $avgMarkByStudent);
    $this->SupportDocModel->performUpload($markedFieldNames);
  }

  // generate reply slip (reply = yes)
  // execute
  //  /usr/bin/php /var/www/html/app/index.php Testing getRSinfo
  // use the result output to send all files to desktop PC
  // get existing file from backend (e.g. PdfTest>>checkIfRSexist)
  // combine the new reply slip into the existing payment 
  // then ftp to backend to replace existing files
  // might need to update RSstatus (e.g. PdfTest>>updateRSstatus)
  public function getRSinfo ()
  {
    $appNoArray = array (2205115612);

    foreach ($appNoArray as $appNo)
    {
      $RS = array ();
      $this->AppAuthModel->getAppReplySlipDetails ($appNo, $RS);
     //print_r($RS);
      $RS['reply'] = 'Y';
      $replyDate = '2024-07-31';
      $date = date_create ($replyDate);
      $RS['replyDate'] = date_format ($date, "F j, Y");
      $RS['signature'] = $RS['appName'];
      //print_r($RS);

      $this->SlipModel->genReplySlip ($RS, $rawName, $destFile, $keyfile, $fileExt, true);

      echo nl2br ($appNo." file: ".$destFile."\n\n");
      echo nl2br ("mv -f ".$destFile." .\n\n");
    }
  }

  public function missingKeySupportDoc ()
  {
    $appNoArray = array ();
    $timeCheck = date('Y-m-d H:i:s', strtotime('2023-09-15'));

    $this->db->select('appNo, fileStatus, titleP1, titleP2, titleP3');
    $this->db->where('createDate >', $timeCheck);
    $this->db->order_by('appNo', 'ASC');
    $query = $this->db->get('supportDoc');

    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $row)
      {
        $appNo = $row->appNo;
        $fileStatus = $row->fileStatus;
        $titleP1 = $row->titleP1;
        $titleP2 = $row->titleP2;
        $titleP3 = $row->titleP3;
        $problem = false;
        $check = substr ($fileStatus, 0, 12);
        if (str_contains($check, 'U') && $titleP1 == NULL)
          $problem = true;

        $check = substr ($fileStatus, 12, 12);
        if (str_contains($check, 'U') && $titleP2 == NULL)
          $problem = true;

        $check = substr ($fileStatus, 24, 12);
        if (str_contains($check, 'U') && $titleP3 == NULL)
          $problem = true;

        if ($problem)
        {
          $appNoArray[] = array (
            'appNo' => $appNo,
            'fileStatus' => $fileStatus,
            'titleP1' => $titleP1,
            'titleP2' => $titleP2,
            'titleP3' => $titleP3,
          );
        }
      }
    }
    print_r($appNoArray);
  }


  public function checkMessage()
  {
    $data = array();
    //$this->prepareMenu ($data['menu']);
    $data['menu'] = 'C';
    $data['currentYear'] = getDate()['year'];
    $allMessage = '';
    $newMessage = '';

    $appNo = $_SESSION['appNo'];
    $data['appNo'] = $appNo;
    $this->AppAuthModel->getChatHistory ($appNo, $allMessage, $newMessage);
    $data['allMessage'] = $allMessage;
    $data['newMessage'] = $newMessage;
    $data['appNo'] = $appNo;

    //echo nl2br($allMessage);
    //echo nl2br($newMessage);
    //print_r($_SESSION);

    $this->load->view('checkMessageView', $data);
  }

  // do this if missing support doc in backend
  public function uploadSuppDoc ()
  {
    $this->UploadModel->sftpOpen();

    $appNoArray = array ();

    $len = count (FILE_FIELD_MAP);

    foreach ($appNoArray as $appNo) 
    {
      for ($i=0; $i<$len; $i++) 
      {
        $value = FILE_FIELD_MAP[$i];
        //echo nl2br("checking file key: ". $value."\n");
        $rawName = $appNo.$value;
        $source = '';
        $destFileExt = 'pdf';

        if (in_array($value, TXT_FIELD))
        {
          $source = UPLOAD_DIR . $appNo . "/".$rawName.".xlsx";
          $destFileExt = 'xlsx';
        }
        else        
          $source = UPLOAD_DIR . $appNo . "/".$rawName.".pdf";

        //echo nl2br($source."\n");

        if (file_exists ($source))
        {
          echo nl2br("....... ". $source . "\n");
       
          $fileNameHash = md5($rawName);
          $hashDir = substr($fileNameHash, 0, 2);
      
          echo nl2br("... sftp ". $source . ' to ' . $fileNameHash . '.' . $destFileExt. "\n");
          $this->UploadModel->sftpToBackend ($source, $fileNameHash, $destFileExt, true);
          if ($destFileExt == 'xlsx')
          {
            echo nl2br("... sftp ". $source . ' to ' . $fileNameHash . '.' . $destFileExt. "\n");
            $this->UploadModel->sftpToBackend ($source, $fileNameHash, 'pdf', true);
          }
        }
      }
    }
    $this->UploadModel->sftpClose();
  }

  // do this if missing support doc in backend
  // confirm if missing doc can be found
  public function checkMissingSuppDoc ()
  {
    $appNoArray = array (1105152664);
    $fileKey = 'fileD11a,fileD11b,fileD12,fileD16a,fileT2,fileV3';
    $fieldNameArray = explode(',', $fileKey);

    $len = count ($fieldNameArray);

    //$this->UploadModel->sftpOpen();

    foreach ($appNoArray as $appNo) 
    {
      for ($i=0; $i<$len; $i++) 
      {
        $value = $fieldNameArray[$i];
        echo nl2br("checking file key: ". $value."\n");

        $rawName = $appNo.$value;
        $source = '';
        $destFileExt = 'pdf';

        if (in_array($value, TXT_FIELD))
        {
          $source = UPLOAD_DIR . $appNo . "/".$rawName.".xlsx";
          $destFileExt = 'xlsx';
        }
        else        
          $source = UPLOAD_DIR . $appNo . "/".$rawName.".pdf";

        //echo nl2br($source."\n");

        if (file_exists ($source))
        {
          echo nl2br("....... found ". $source . "\n");
       
          $fileNameHash = md5($rawName);
          $hashDir = substr($fileNameHash, 0, 2);
      
          //echo nl2br("... sftp ". $source . ' to ' . $fileNameHash . '.' . $destFileExt. "\n");
          //$this->UploadModel->sftpToBackend ($source, $fileNameHash, $destFileExt, true);
          if ($destFileExt == 'xlsx')
          {
            ;
            //echo nl2br("... sftp ". $source . ' to ' . $fileNameHash . '.' . $destFileExt. "\n");
            //$this->UploadModel->sftpToBackend ($source, $fileNameHash, 'pdf', true);
          }
        }
        else
          echo nl2br("....... not found...... ". $source . "\n");
      }
    }
    //$this->UploadModel->sftpClose();
  }

}
