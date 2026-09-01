<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/Sftp.php";
include_once APPPATH."config/userConstants.php";

class Upload extends CI_Controller
{

  function __construct () 
  {
    parent::__construct ();
    $this->load->model('UploadModel');
    $this->load->model('CSVModel');
    $this->load->model('SlipModel');
    $this->load->model('SupportDocModel');
    $this->load->model('AppAuthModel');
    $this->load->model('EmailModel');

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

  public function summary() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $recipientEmail = $_POST['email'];
    $appNo = $_SESSION['appNo'];

    // special arrangement for 2023 admission year
    $admYear = $this->AppAuthModel->getAdmYear ($appNo);
    $acadYear = '';
    if ($admYear == 2023 || $admYear == '2023')
      $acadYear = '2023-24';
    else
      $acadYear = $this->SlipModel->getUserDefinedText ('ACADyear');


    if ($this->AppAuthModel->isAppNoEmailCorrect($appNo, $recipientEmail))
    {
      //$shortMsg = "";
      //$this->EmailModel->generateShortMsg($shortMsg);
      //$this->AppAuthModel->emailNoFile($heading, $shortMsg, $recipientEmail);

      $currCode = $this->AppAuthModel->getCurrCode ($appNo);
      $emailFooter = 'e'; // general footer
      if (in_array($currCode, CURRCODE_SCDS_LIST))   // SCDS email footer
        $emailFooter = 'c';

      $alreadyUploaded = array ();
      $pNo = 0;
      $titleArray = array ('', '', '', '');
      $currStud = 'N';
      $this->SupportDocModel->getLatestUploadStatus ($alreadyUploaded, $currStud, $pNo, $titleArray);
      $heading = 'HKU Engineering Admissions '.$acadYear.' - File upload summary';

      $longMsg = "";
      $this->EmailModel->generateLongMsg($appNo, $longMsg, $alreadyUploaded, $pNo, $titleArray);
      $this->AppAuthModel->emailNoFile($heading, $longMsg, $recipientEmail, $emailFooter);

      $this->session->set_flashdata("info", "your file upload summary has been sent to your mail box, please check.");
    }
    else
    {
      $this->session->set_flashdata("error", "information not match, please login again.");
    }
    redirect("upload/done","refresh");
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

  // convert all letters into uppercase, change space to '_' and removes the rest
  private function filterTitle (&$titleArray)
  {
    ini_set('display_errors', 0);     // do not display errors
    for ($j=0; $j<4; $j++)
    {
      $title = $titleArray[$j];
      $len = strlen ($title);
      if ($len > 0)
      {
        $title = strtoupper ($title);
        $temp = str_split ($title);
        $titleString = '';
        for ($i=0; $i<$len; $i++)
        {
          $character = $temp[$i];
          if ($character >= 'A' && $character <= 'Z')
            $titleString = $titleString . $character;
          else if ($character == ' ' || $character == '_')
            $titleString = $titleString . '_';
        }
        $titleArray[$j] = $titleString;
      }
    }
  }

  private function itemTitle ($keyfile)
  {
    ini_set('display_errors', 0);     // do not display errors
    foreach (UPLOAD_ITEMS as $row) 
    {
      if ($row[0] == $keyfile)
      {
        //return $row[6] . ' ('.$row[5].')';
        return $row[6];
      }
    }
  }

  // 2026: each institution section of the upload page carries its own academic
  // qualification (GPA / mark + classification of award). The field names are
  // suffixed with the institution slot, so the slot needs no reference key
  // lookup -- it is whatever section the applicant submitted.
  private function saveAcadQual ()
  {
    ini_set('display_errors', 0);     // do not display errors
    $saved = 0;

    for ($p=1; $p<=MAX_fileDNO; $p++)
    {
      $obtained   = trim ((string) $this->input->post('avgMarkObtained'.$p));
      $max        = trim ((string) $this->input->post('avgMarkMax'.$p));
      $awardClass = trim ((string) $this->input->post('awardClass'.$p));

      if ($obtained == '' || $max == '' || $awardClass == '')
        continue;   // section not submitted, or fields left empty

      // avgMarkByStudN is varchar(20), awardClassN is varchar(40)
      $avgMarkByStudent = substr ($obtained, 0, 5) . '/' . substr ($max, 0, 4);
      $this->SupportDocModel->saveAcadQual ($p, $avgMarkByStudent, substr ($awardClass, 0, 40));
      log_message('debug', 'upload/saveAcadQual: slot '.$p.' '.$avgMarkByStudent);
      $saved++;
    }
    return $saved;
  }

  public function uploadAll()
  {
    ini_set('display_errors', 0);     // do not display errors
    // for storing all errors
    $errorMsg = "";
    $counter = 0;
    $successMsg = "";
    $fileStatus = array ();
    $uploadOK = FALSE;          // check if first level upload is ok
    $qualSaved = 0;             // academic qualification sections submitted

    //print_r($_POST);

    if ($this->AppAuthModel->sessionExpired(1800))
    {
      $errorMsg = "This page expired, please login again.";
      redirect("auth");
    }
    else
    {
      $titleArray = array ('', '', '', '');
      if (isset($_POST['title0']))
        $titleArray[0] = $_POST['title0'];
      if (isset($_POST['title1']))
        $titleArray[1] = $_POST['title1'];
      if (isset($_POST['title2']))
        $titleArray[2] = $_POST['title2'];
      if (isset($_POST['title3']))
        $titleArray[3] = $_POST['title3'];
      $this->filterTitle($titleArray);

      $this->load->helper('file');

      if ($this->input->post('submit') == "Upload documents" || 
          $this->input->post('submit') == "Upload document")
      {
        $_SESSION['fileErrCount'] = 0;

        // saved first, so a rejected file never costs the applicant the marks
        // they just typed in that section
        $qualSaved = $this->saveAcadQual ();

        //Upload to the local server
        if (!is_dir(UPLOAD_DIR . $_SESSION['appNo'])) 
        {
          mkdir('./'.UPLOAD_DIR . $_SESSION['appNo'], 0777, true);    // create dir
        }
        $config['upload_path'] = UPLOAD_DIR . $_SESSION['appNo'] . "/";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        $markedFieldNames = array ();
        $averageMark = array ();        // calculated by system according to student input
        $averageMark['fileD14'] = 0;
        $averageMark['fileD24'] = 0;
        $averageMark['fileD34'] = 0;
        $avgMarkByStudent = array ();   // entered as text by student
        $avgMarkByStudent['fileD14'] = '';
        $avgMarkByStudent['fileD24'] = '';
        $avgMarkByStudent['fileD34'] = '';

        //$tempBuf = UPLOAD_DIR . $_SESSION['appNo'] . "/file.txt";
        //file_put_contents($tempBuf, print_r($_FILES, true));
        //print_r ($_FILES);
        //echo nl2br("\n");

        foreach ($_FILES as $keyfile => $rowValue)
        {
          if ($_FILES[$keyfile]['name'] != NULL && $_FILES[$keyfile]['name'] != '' && $_FILES[$keyfile]['size'] >0)
          {
            $uploadOK = TRUE;     // at least 1 file uploaded
            //echo nl2br("working on ".$keyfile."\n");
            //echo nl2br("... which is ".$_FILES[$keyfile]['name']."\n\n");

            log_message('debug', 'upload/uploadAll: working on '.$keyfile. ' '.$_FILES[$keyfile]['name']);

            // re-initialize upload library
            $config['file_name'] = $_SESSION['appNo'].$keyfile;
            $config['overwrite'] = TRUE;  // old file will be overwritten
            $this->upload->initialize($config);

            if($this->upload->do_upload($keyfile)) 
            {
              //Get uploaded file information
              $uploadData = $this->upload->data();
              //echo nl2br("uploaddata:\n");
              //print_r ($uploadData);
              //echo nl2br("\n\n");
              $hasError = false;

              $fileType = $this->UploadModel->checkFileType ($uploadData, $keyfile);

              //echo nl2br('filetype: '.$fileType."\n\n");

              log_message('debug', 'upload/uploadAll: filetype '.$fileType);
              if ($fileType == 1 || $fileType == 2)   // img OR pdf
              {
                if ($fileType == 1) // img
                {
                  $this->UploadModel->generatePDF($uploadData);
                  log_message('debug', 'upload/uploadAll: generated pdf');
                }
                $markedFieldNames[$keyfile] = "pdf";
                $counter++;
                $successMsg = $successMsg . "[".$_FILES[$keyfile]['name']."] ";
                
                //echo nl2br('successmsg: '.$successMsg."\n\n");

                log_message('debug', 'upload/uploadAll: markedFieldNames '.$keyfile.' .. '. 'pdf');
              }
              else if ($fileType == 3)  // txt
              {
                $markSheet = array ();
                $errMsg = '';
                $result = $this->CSVModel->validateChecksum ($uploadData, $markSheet, $errMsg);

                $avg = 0;
                $this->CSVModel->genMSexcel ($uploadData, $markSheet, $avg, $result);
                $markedFieldNames[$keyfile] = "xlsx";

                if ($result != -1 || ($_SESSION['staff'] != '' && $_SESSION['staff'] == $_SESSION['uid'])) 
                {
                  log_message('debug', 'upload/uploadAll: checksum ok');
                }
                else
                {
                  log_message('debug', 'upload/uploadAll: txt marksheet checksum not matched');
                }

                $averageMark[$keyfile] = $avg;
                $avgMarkByStudent[$keyfile] = $marksheet['avgMarkByStudent'];
                $counter++;
                $successMsg = $successMsg . "[".$_FILES[$keyfile]['name']."] ";
                log_message('debug', 'upload/uploadAll: markedFieldNames '.$keyfile.' .. '. 'xlsx');
              }
              else if  ($fileType == 5)  // protected pdf
              {
                $hasError = true;
                $err = 'protected pdf not supported. ';
                $errorMsg = $errorMsg . $err;
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              }
              else
              {
                $hasError = true;
                $err = 'cannot upload due to improper size / format, please check requirement. ';
                $errorMsg = $errorMsg . $err;
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              }

              //echo nl2br('haserror: '.$hasError."\n\n");

              if ($hasError)
              {
                $errorMsg = $errorMsg . 'File upload error in <strong>'. $this->itemTitle($keyfile) . '</strong>';
                $this->UploadModel->cleanUp($uploadData['file_name']);
                $_SESSION['fileErrCount']++;
              }
            }
            else
            {
              $err = 'cannot upload due to improper size / format, please check requirement. ';
              $errorMsg = $errorMsg . $err . 'File upload error in <strong>'. $this->itemTitle($keyfile) . '</strong>';
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              $_SESSION['fileErrCount']++;
              $error = ['error' => $this->upload->display_errors()];
              //print_r($error);
            }
          }
        }

        //echo nl2br('uploadOK: '.$uploadOK."\n\n");

        if ($uploadOK)
        {
          $this->SupportDocModel->markFileToUpload($markedFieldNames, $titleArray, $averageMark, $avgMarkByStudent);
          $this->SupportDocModel->performUpload($markedFieldNames);
          //print_r($_SESSION);
        }
      }
    }

    if (!$uploadOK && $errorMsg == "")
    {
      // no file failed -- the applicant simply submitted the section without
      // choosing a file, which is fine when the academic qualification is what
      // they came to save
      if ($qualSaved == 0)
      {
        $errorMsg = "Problem with file upload, therefore no file was uploaded. Either no file was selected or total upload size had exceeded system limit. You may try to upload one file to view detail error message.<br/>";
        log_message('debug', 'upload/uploadAll: problem with file upload, no file was uploaded.');
      }
    }

    if ($errorMsg != "")
    {
      //echo nl2br ("err: ".$errorMsg."\n\n");
      $this->session->set_flashdata("error", $errorMsg);
      $errorMsg = "";
    }

    $infoMsg = "";
    if ($counter > 0)
      $infoMsg = $counter . " file(s) uploaded ... ".$successMsg;
    if ($qualSaved > 0)
      $infoMsg = $infoMsg . ($infoMsg == "" ? "" : "<br/>") . "Academic qualification saved.";
    if ($infoMsg != "")
    {
      //echo nl2br ("ok: ".$infoMsg."\n\n");
      $this->session->set_flashdata("info", $infoMsg);
      $successMsg = "";
    }

    $_SESSION['lastAction'] = time();
    redirect ("display/upload");     // with flashdata
  }

  // for testing
  public function uploadAllTest() 
  {
    // for storing all errors
    $errorMsg = "";
    $counter = 0;
    $successMsg = "";
    $fileStatus = array ();
    $uploadOK = FALSE;          // check if first level upload is ok

    print_r($_POST);
    echo nl2br("\n");

    if ($this->AppAuthModel->sessionExpired(1800))
    {
      $errorMsg = "This page expired, please login again.";
      redirect("auth");
    }
    else
    {
      $titleArray = array ('', '', '', '');
      if (isset($_POST['title0']))
        $titleArray[0] = $_POST['title0'];
      if (isset($_POST['title1']))
        $titleArray[1] = $_POST['title1'];
      if (isset($_POST['title2']))
        $titleArray[2] = $_POST['title2'];
      if (isset($_POST['title3']))
        $titleArray[3] = $_POST['title3'];
      $this->filterTitle($titleArray);

      $this->load->helper('file');

      if ($this->input->post('submit') == "Upload documents" || 
          $this->input->post('submit') == "Upload document")
      {
        $_SESSION['fileErrCount'] = 0;

        //Upload to the local server
        if (!is_dir(UPLOAD_DIR . $_SESSION['appNo'])) 
        {
          mkdir('./'.UPLOAD_DIR . $_SESSION['appNo'], 0777, true);    // create dir
        }
        $config['upload_path'] = UPLOAD_DIR . $_SESSION['appNo'] . "/";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        $markedFieldNames = array ();
        $averageMark = array ();        // calculated by system according to student input
        $averageMark['fileD14'] = 0;
        $averageMark['fileD24'] = 0;
        $averageMark['fileD34'] = 0;
        $avgMarkByStudent = array ();   // entered as text by student
        $avgMarkByStudent['fileD14'] = '';
        $avgMarkByStudent['fileD24'] = '';
        $avgMarkByStudent['fileD34'] = '';

        //$tempBuf = UPLOAD_DIR . $_SESSION['appNo'] . "/file.txt";
        //file_put_contents($tempBuf, print_r($_FILES, true));
        print_r ($_FILES);
        echo nl2br("\n");

        foreach ($_FILES as $keyfile => $rowValue)
        {
          if ($_FILES[$keyfile]['name'] != NULL && $_FILES[$keyfile]['name'] != '' && $_FILES[$keyfile]['size'] >0)
          {
            $uploadOK = TRUE;     // at least 1 file uploaded
            echo nl2br("working on ".$keyfile."\n");
            echo nl2br("... which is ".$_FILES[$keyfile]['name']."\n\n");

            log_message('debug', 'upload/uploadAll: working on '.$keyfile. ' '.$_FILES[$keyfile]['name']);

            // re-initialize upload library
            $config['file_name'] = $_SESSION['appNo'].$keyfile;
            $config['overwrite'] = TRUE;  // old file will be overwritten
            $this->upload->initialize($config);

            if($this->upload->do_upload($keyfile)) 
            {
              //Get uploaded file information
              $uploadData = $this->upload->data();
              echo nl2br("uploaddata:\n");
              print_r ($uploadData);
              echo nl2br("\n\n");
              $hasError = false;

              $fileType = $this->UploadModel->checkFileTypeTest ($uploadData, $keyfile);

              echo nl2br('filetype: '.$fileType."\n\n");

              log_message('debug', 'upload/uploadAll: filetype '.$fileType);
              if ($fileType == 1 || $fileType == 2)   // img OR pdf
              {
                if ($fileType == 1) // img
                {
                  $this->UploadModel->generatePDF($uploadData);
                  log_message('debug', 'upload/uploadAll: generated pdf');
                }
                $markedFieldNames[$keyfile] = "pdf";
                $counter++;
                $successMsg = $successMsg . "[".$_FILES[$keyfile]['name']."] ";
                
                echo nl2br('successmsg: '.$successMsg."\n\n");

                log_message('debug', 'upload/uploadAll: markedFieldNames '.$keyfile.' .. '. 'pdf');
              }
              else if ($fileType == 3)  // txt
              {
                $markSheet = array ();
                $errMsg = '';
                $result = $this->CSVModel->validateChecksum ($uploadData, $markSheet, $errMsg);

                $avg = 0;
                $this->CSVModel->genMSexcel ($uploadData, $markSheet, $avg, $result);
                $markedFieldNames[$keyfile] = "xlsx";

                if ($result != -1 || ($_SESSION['staff'] != '' && $_SESSION['staff'] == $_SESSION['uid'])) 
                {
                  log_message('debug', 'upload/uploadAll: checksum ok');
                }
                else
                {
                  log_message('debug', 'upload/uploadAll: txt marksheet checksum not matched');
                }

                $averageMark[$keyfile] = $avg;
                $avgMarkByStudent[$keyfile] = $marksheet['avgMarkByStudent'];
                $counter++;
                $successMsg = $successMsg . "[".$_FILES[$keyfile]['name']."] ";
                log_message('debug', 'upload/uploadAll: markedFieldNames '.$keyfile.' .. '. 'xlsx');
              }
              else if  ($fileType == 5)  // protected pdf
              {
                $hasError = true;
                $err = 'this is a protected pdf, remove the password and upload again. ';
                $errorMsg = $errorMsg . $err;
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              }
              else
              {
                $hasError = true;
                $err = 'cannot upload due to improper size / format, please check requirement. ';
                $errorMsg = $errorMsg . $err;
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              }

              echo nl2br('haserror: '.$hasError."\n\n");

              if ($hasError)
              {
                $errorMsg = $errorMsg . 'File upload error in <strong>'. $this->itemTitle($keyfile) . '</strong>';
                $this->UploadModel->cleanUp($uploadData['file_name']);
                $_SESSION['fileErrCount']++;
              }
            }
            else
            {
              $err = 'cannot upload due to improper size / format, please check requirement. ';
              $errorMsg = $errorMsg . $err . 'File upload error in <strong>'. $this->itemTitle($keyfile) . '</strong>';
                $_SESSION['fileErr'][] = array ($keyfile, $_FILES[$keyfile]['name'], $err);
              $_SESSION['fileErrCount']++;
              $error = ['error' => $this->upload->display_errors()];
              print_r($error);
            }
          }
        }

        echo nl2br('uploadOK: '.$uploadOK."\n\n");

        if ($uploadOK)
        {
          $this->SupportDocModel->markFileToUpload($markedFieldNames, $titleArray, $averageMark, $avgMarkByStudent);
          $this->SupportDocModel->performUpload($markedFieldNames);
          print_r($_SESSION);
        }
      }
    }

    if (!$uploadOK)
    {
      $errorMsg = "Problem with file upload, therefore no file was uploaded. Either no file was selected or total upload size had exceeded system limit. You may try to upload one file to view detail error message.<br/>";
      log_message('debug', 'upload/uploadAll: problem with file upload, no file was uploaded.');
    }

    if ($errorMsg != "")
    {
      echo nl2br ("err: ".$errorMsg."\n\n");
      $this->session->set_flashdata("error", $errorMsg);
      $errorMsg = "";
    }
    if ($counter > 0)
    {
      echo nl2br ("ok: ".$successMsg."\n\n");
      $this->session->set_flashdata("info", $counter . " file(s) uploaded ... ".$successMsg);
      $successMsg = "";
    }

    $_SESSION['lastAction'] = time();    
    //redirect ("display/upload");     // with flashdata
  }

  // not in use
  public function uploadMarkSheetOLD() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->load->helper('file');

    if ($this->input->post('submit') == "Upload mark sheet")
    {
      //Upload to the local server
      $config['upload_path'] = UPLOAD_DIR . $_SESSION['appNo'] . "/";
      $config['allowed_types'] = '*';
      $this->load->library('upload', $config);

      $this->UploadModel->sftpOpen();

      $keyfile = 'fileM';

        if ($_FILES[$keyfile]['name'] != NULL)
        {
          if($this->upload->do_upload($keyfile)) 
          {
              //Get uploaded file information
            $uploadData = $this->upload->data();

            $result = $this->CSVModel->validateChecksum ($uploadData);
            if ($result != -1) 
            {
              $this->CSVModel->toExcel ($uploadData, $result);
              $this->UploadModel->uploadExcel ($uploadData);
              $this->session->set_flashdata("info", " file uploaded");
            }
            else 
            {
              $this->session->set_flashdata("error", $uploadData['file_name']." file corrupted, please regenerate the mark sheet in <strong>Fill mark sheet</strong>.<br/>");
            }
          }
          else
          {
            $this->session->set_flashdata("error", $_FILES[$keyfile]['name']." cannot upload due to  improper size / format, please check requirement.<br/>");
            //$error = ['error' => $this->upload->display_errors()];
            //print_r($error);
          }
        }
      $this->UploadModel->sftpClose(); 
    }
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
    $data['currentYear'] = getDate()['year'];
    $this->load->view('uploadView', $data);
  }

}

?>
