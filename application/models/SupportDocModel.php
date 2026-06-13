<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// this file is NOT the same as backend

class SupportDocModel extends CI_Model {

  function __construct () {
    parent::__construct ();
    $this->dblog = $this->load->database('tpglog',TRUE);
    $this->load->model('AppAuthModel');
    $this->load->model('UploadModel');
  }

  // convert array $in into a string $out
  function arrayToString ($in, &$out)
  {
    ini_set('display_errors', 0);     // do not display errors
    $len = count($in);
    $out = "";
    for ($i=0; $i<$len; $i++)
    {
      $out = $out.$in[$i];
    }
  }

  // convert string $in into array $out
  function stringToArray ($in, &$out)
  {
    ini_set('display_errors', 0);     // do not display errors
    $len = strlen($in);
    for ($i=0; $i<$len; $i++)
    {
      $out[$i] = substr($in, $i, 1);
    }
  }

  // get file status from table
  function getFileStatus ($table, &$fileStatus)
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $_SESSION['appNo'];

    $this->db->select("appNo, fileStatus");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) 
    {
      $row = $query->first_row();
      $this->stringToArray ($row->fileStatus, $fileStatus);
    }
    else
    {
      $temp = "";
      $len = count (FILE_FIELD_MAP);
      for ($i=0; $i<$len; $i++)
        $temp = $temp."N";        // 'N' for init status
      $this->stringToArray ($temp, $fileStatus);
    }
  }

  // check if arrayIn contains only 'N'
  private function isInitStatus ($arrayIn)
  {
    ini_set('display_errors', 0);     // do not display errors
    $len = count ($arrayIn);
    for ($i=0; $i<$len; $i++)
    {
      if ($arrayIn[$i] != 'N')
        return false;
    }
    return true;
  }

  // extract file status from database row
  function extractFileStatus ($row, &$fileStatus)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (!empty($row))
    {
      $this->stringToArray ($row->fileStatus, $fileStatus);
    }
    else
    {
      $temp = "";
      $len = count (FILE_FIELD_MAP);
      for ($i=0; $i<$len; $i++)
        $temp = $temp."N";        // 'N' for init status
      $this->stringToArray ($temp, $fileStatus);
    }
  }

  function getMaxQualificationFilled ($alreadyUploaded)
  { 
    ini_set('display_errors', 0);     // do not display errors
    $maxField = "";

    foreach (FILE_FIELD_MAP as $key => $value)
    {
      if (in_array($value, $alreadyUploaded))
      {
        if (substr($value, 4,1) == "P")
          $maxField = $value;
      }
    }
    if ($maxField == "")
      return 0;
    else
    {
      $n = ord(substr($maxField, 5, 1)) - ord('0');
      return $n;
    }
  }

  // mark all verified doc
  function getLatestVerifiedStatus (&$verified)
  {
    ini_set('display_errors', 0);     // do not display errors
    $supportDocReviewRow = array();
    $fileReviewStatus = array ();
    $appNo = $_SESSION['appNo'];

    if ($this->getRecord ('supportDocReview', $appNo, $supportDocReviewRow)) 
    {
      $this->extractFileStatus ($supportDocReviewRow, $fileReviewStatus);
      $len = count($fileReviewStatus);
      for ($i=0; $i<$len; $i++)
      {
        if ($fileReviewStatus[$i] == 'C')       // already verified
        {
          array_push($verified, FILE_FIELD_MAP[$i]);
        }
      }
    }
  }

  // mark latest upload status
  function getLatestUploadStatus (&$alreadyUploaded, &$currStud, &$pNo, &$titleArray)
  {
    ini_set('display_errors', 0);     // do not display errors
    $supportDocRow = array();
    $fileStatus = array ();
    $appNo = $_SESSION['appNo'];

    if ($this->getRecord ('supportDoc', $appNo, $supportDocRow)) 
    {
      $pNo = $supportDocRow->pNo;
      $titleArray[0] = $supportDocRow->titleC1;
      $titleArray[1] = $supportDocRow->titleP1;
      $titleArray[2] = $supportDocRow->titleP2;
      $titleArray[3] = $supportDocRow->titleP3;
      $currStud = $supportDocRow->currStud;
      log_message('info', 'SupportDocModel/getLatestUploadStatus: currStud is '. $currStud);
      log_message('info', 'SupportDocModel/getLatestUploadStatus: pNo is '. $pNo);

      $this->extractFileStatus ($supportDocRow, $fileStatus);
      $len = count($fileStatus);
      for ($i=0; $i<$len; $i++)
      {
        $p = intdiv($i,13) + 1;   
        if ($fileStatus[$i] == 'U' || $fileStatus[$i] == 'R')       // already uploaded
        {
          if ($i>=0 && $i<MAX_fileDNO*13)
          {
            if ($p > $pNo)
              $pNo = $p;
          }
          array_push($alreadyUploaded, FILE_FIELD_MAP[$i]);
        }
      }

      $_SESSION['fileT2title'] = "";
      $_SESSION['fileV1title'] = "";
      $_SESSION['fileV2title'] = "";
      $_SESSION['fileV3title'] = "";

      if ($supportDocRow->englishTest != NULL)
      {
        $_SESSION['fileT2title'] = $supportDocRow->englishTest;
        if ($_SESSION['fileT2title'] == "cambr")
          $_SESSION['fileT2title'] = "Cambridge Test";
      }
      if ($supportDocRow->other1 != NULL)
        $_SESSION['fileV1title'] = $supportDocRow->other1;
      if ($supportDocRow->other2 != NULL)
        $_SESSION['fileV2title'] = $supportDocRow->other2;
      if ($supportDocRow->other3 != NULL)
        $_SESSION['fileV3title'] = $supportDocRow->other3;
      
      return true;
    }
    return false;
  }

  // get the whole row (matching appNo) from the requested database
  private function getRecord ($table, $appNo, &$row)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->db->select('*');
    $this->db->where('appNo', $appNo);
    $query = $this->db->get($table);
    $row = $query->row();

    if (isset ($row))
      return true;
    else
      return false;
  }
  

  function markFileToUpload ($fieldNames, $titleArray, $averageMark, $avgMarkByStudent)
  {
    ini_set('display_errors', 0);     // do not display errors
    $supportDocRow = array();
    $supportDocReviewRow = array();
    $update = FALSE;
    $timeStamp = 0;

    $appNo = $_SESSION['appNo'];

    if ($this->getRecord ('supportDoc', $appNo, $supportDocRow)) 
    {
      $this->db->insert('supportDocHistory', $supportDocRow);
      $timeStamp = $supportDocRow->lastModified;
      $update = TRUE;
    }

    $reviewValid = FALSE;
    if ($this->getRecord ('supportDocReview', $appNo, $supportDocRowReview)) 
    {
      if ($supportDocRowReview->lastModified > $timeStamp)  
        $reviewValid = TRUE;
    }

    $this->extractFileStatus ($supportDocRow, $fileStatusCurrArray);
    $this->extractFileStatus ($supportDocRowReview, $fileStatusReviewArray);

    $tobeUpdated = array ();
    $tobeUpdated['appNo'] = $appNo;
    $tobeUpdatedAvgMark = array ();
    $tobeUpdatedAvgMark['appNo'] = $appNo;
    $tobeUpdatedAvgMark['createDate'] = mdate('%Y-%m-%d %H:%i:%s', now());
    $pNo = 0;

    $len = count (FILE_FIELD_MAP);
    foreach ($fieldNames as $key => $value)     // $key -- fileD11 etc, $value -- filename
    {
      $done = FALSE;
      for ($i=0; $i<$len && !$done; $i++)
      {
        if (FILE_FIELD_MAP[$i] == $key)
        {
          if ($i>=0 && $i<MAX_fileDNO*13)       // fileDN submitted, find highest N
          {
            $p = intdiv($i,13) + 1;   
            if ($p > $pNo)
              $pNo = $p;
            $tobeUpdated['pNo'] = $pNo;

            $titlekey = 'titleP'.$p;
            $tobeUpdated[$titlekey] = $titleArray[$p];
          }

          if ($key == 'fileD14')
          {
            $tobeUpdatedAvgMark['avgMarkP1'] = $averageMark['fileD14'];
            $tobeUpdatedAvgMark['avgMarkByStud1'] = $avgMarkByStudent['fileD14'];
          }
          else if ($key == 'fileD24')
          {
            $tobeUpdatedAvgMark['avgMarkP2'] = $averageMark['fileD24'];
            $tobeUpdatedAvgMark['avgMarkByStud2'] = $avgMarkByStudent['fileD24'];
          }
          else if ($key == 'fileD34')
          {
            $tobeUpdatedAvgMark['avgMarkP3'] = $averageMark['fileD34'];
            $tobeUpdatedAvgMark['avgMarkByStud3'] = $avgMarkByStudent['fileD34'];
          }

          // mark upload as Upload or Re-upload
          if ($reviewValid && $fileStatusReviewArray[$i] == 'F')
          {
            $fileStatusCurrArray[$i] = 'R';
          }
          else
          {
            $fileStatusCurrArray[$i] = 'U';
          }

          if ($key == "fileT2")   // English test
          {
            $tobeUpdated['englishTest'] = $this->input->post('customRadio');
            $_SESSION[$key."title"] = $this->input->post('customRadio');
            if ($_SESSION[$key."title"] == "cambr")
              $_SESSION[$key."title"] = "Cambridge Test";

          }
          else if ($key == "fileV1")  // other doc #1
          {
            $tmp = $this->input->post('otherfileV1');
            if ($tmp == "")
              $tmp = "no title";
            $tobeUpdated['other1'] = $tmp;
            $_SESSION[$key."title"] = $tmp;
          }
          else if ($key == "fileV2")  // other doc #2
          {  
            $tmp = $this->input->post('otherfileV2');
            if ($tmp == "")
              $tmp = "no title";
            $tobeUpdated['other2'] = $tmp;
            $_SESSION[$key."title"] = $tmp;
          }
          else if ($key == "fileV3")  // other doc #3
          {  
            $tmp = $this->input->post('otherfileV3');
            if ($tmp == "")
              $tmp = "no title";
            $tobeUpdated['other3'] = $tmp;
            $_SESSION[$key."title"] = $tmp;
          }
          $done = TRUE;
        }
      }
    }

    if (!$this->isInitStatus ($fileStatusCurrArray))
    {
      $fileStatusString = "";
      $this->arrayToString ($fileStatusCurrArray, $fileStatusString);
      $tobeUpdated['fileStatus'] = $fileStatusString;

      if ($update)
      {
        $this->db->set($tobeUpdated);
        $this->db->where('appNo', $appNo);
        $this->db->update('supportDoc');
      }
      else
      {
        $tobeUpdated['createDate'] = mdate('%Y-%m-%d %H:%i:%s', now());
        $this->db->set($tobeUpdated);
        $this->db->insert('supportDoc');
      }

      //write SQLlog if TRUE
      $log = array(
        'sqlDetails'  => TRUE,
        'oldData'     => '',
        'newData'     => '',
        'sqlAction'   => 'update file status',
      );
      $this->AppAuthModel->writeSQLlog($log);
    }

    if (!empty ($tobeUpdatedAvgMark))
    {
      $this->db->set($tobeUpdatedAvgMark);
      $this->db->insert('avgMark');
    }
  }

  function performUpload ($fieldNames)
  {
    //echo nl2br("fieldNames:\n");
    //print_r($fieldNames);
    //echo nl2br("\n\n");

    ini_set('display_errors', 0);     // do not display errors

    $this->UploadModel->sftpOpen();
    foreach ($fieldNames as $key => $value)
    {
      $rawname = $_SESSION['appNo'].$key;
      $actualFileName = $_FILES[$key]['name'];
      $pos = strripos ($actualFileName, '.');
      $fileExt = substr ($actualFileName, $pos+1);

      if ($value != strtolower($fileExt))
        $fileExt = $value;

      //echo nl2br("actual filename: ".$actualFileName."\n\n");
      //echo nl2br("rawname: ".$rawname."\n\n");
      //echo nl2br("value: ".$fileExt."\n\n");

      $this->UploadModel->uploadFile ($rawname, $fileExt);
      log_message('info', 'SupportDocModel/performUpload: upload supporting doc '. $rawname);

      $_SESSION['uploaded'][] = $key;
      $this->UploadModel->cleanUp($rawname.".".$fileExt);

      if ($value == "xlsx")
      {
        $this->UploadModel->uploadFile ($rawname, "pdf");
        $this->UploadModel->cleanUp($rawname.".pdf");
      }
    }
    $this->UploadModel->sftpClose(); 
  }

  // extract uni, degree, loc info for an applicant
  public function getDegreeInfo (&$info)
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $_SESSION['appNo'];
    $this->db->select("appNo, uni1, uni2, uni3, degree1, degree2, degree3, isChina1, isChina2, isChina3");
    $this->db->where('appNo', $appNo);
    $query = $this->db->get('application');

    if ($query->num_rows() > 0) 
    {
      $row = $query->row();

      $degree1 = $row->degree1;
      $degree2 = $row->degree2;
      $degree3 = $row->degree3;
      $uni1 = $row->uni1;
      $uni2 = $row->uni2;
      $uni3 = $row->uni3;
      $isChina1 = $row->isChina1;
      $isChina2 = $row->isChina2;
      $isChina3 = $row->isChina3;

      $info['degree'] = array ($degree1, $degree2, $degree3);
      $info['uni'] = array ($uni1, $uni2, $uni3);
      $info['isChina'] = array ($isChina1, $isChina2, $isChina3);
    }
  }

}

?>
