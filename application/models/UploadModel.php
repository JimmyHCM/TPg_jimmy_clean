<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
require_once APPPATH."/libraries/Sftp.php";
include_once APPPATH."config/userConstants.php";
require_once APPPATH.'libraries/pdfparser-2.1.0/alt_autoload.php-dist';
//require_once APPPATH.'libraries/pdfparser-2.11.0/alt_autoload.php-dist';
use Smalot\PdfParser;
use Mpdf\Mpdf;

class UploadModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();

    $this->load->library('Pdf');
    $this->dblog = $this->load->database('tpglog',TRUE);
    $this->load->model('AppAuthModel');
  }

  // return value:
  // 0 - wrong type
  // 1 - img
  // 2 - pdf
  // 3 - txt
  // 5 - protected pdf
  function checkFileType ($uploadData, $fieldName)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (in_array($fieldName, IMG_FIELD))
    {
      if ($this->isNiceImage($uploadData))
        return 1;
    }
    else if (in_array($fieldName, PDF_FIELD))
    {
      $isProtected = $this->isProtectedPdf($uploadData);
      if ($isProtected)
        return 5;
      else if ($this->isNicePdf($uploadData))    // not protected
        return 2;
    }
    else if (in_array($fieldName, TXT_FIELD))
    {
      if ($this->isNiceTXT($uploadData))
        return 3;
    }
    return 0;
  }

  // testing
  // return value:
  // 0 - wrong type
  // 1 - img
  // 2 - pdf
  // 3 - txt
  // 5 - protected pdf
  function checkFileTypeTest ($uploadData, $fieldName)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (in_array($fieldName, IMG_FIELD))
    {
      if ($this->isNiceImage($uploadData))
        return 1;
    }
    else if (in_array($fieldName, PDF_FIELD))
    {
      echo nl2br("insider check file type\n\n");
      $isProtected = $this->isProtectedPdfTest($uploadData);
      if ($isProtected)
        return 5;
      else if ($this->isNicePdf($uploadData))    // not protected
        return 2;
    }
    else if (in_array($fieldName, TXT_FIELD))
    {
      if ($this->isNiceTXT($uploadData))
        return 3;
    }
    return 0;
  }

  function uploadExcel ($uploadData)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->UploadModel->uploadFile($uploadData, "xlsx", false);
    
    //echo nl2br("file uploaded\n");
    $this->UploadModel->cleanUp($uploadData);
  }

  // check if uploaded file is an image
  function isImage ($uploadData)
  {
    ini_set('display_errors', 0);     // do not display errors
    $supportedImageExtensions = Array('jpg','jpeg','png');
        
    $fileNameExt = $uploadData['file_ext'];
    $fileNameExt = strtolower(substr($fileNameExt, 1));   // remove .

    if (in_array($fileNameExt, $supportedImageExtensions)) 
    {
      if ($uploadData['is_image']) 
      {
        return TRUE;
      }
    }
    return FALSE;
  }

  function isNiceImage ($uploadData)
  {
    ini_set('display_errors', 0);     // do not display errors
    $supportedImageExtensions = Array('jpg','jpeg','png');
    $fileSize = $uploadData['file_size'];
        
    $fileNameExt = $uploadData['file_ext'];
    $fileNameExt = strtolower(substr($fileNameExt, 1));   // remove .

    if (in_array($fileNameExt, $supportedImageExtensions)) {
      if ($uploadData['is_image']) {
        $width = $uploadData['image_width'];
        $height = $uploadData['image_height'];
        if ($fileSize >= 1000 && $fileSize <= 2048) // max 2 MB
          return TRUE;
      }
    }
    return FALSE;
  }

  function isNicePdf ($uploadData)
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileSize = $uploadData['file_size'];
    $fileType = $uploadData['file_type'];
        
    $fileNameExt = $uploadData['file_ext'];
    $fileNameExt = strtolower(substr($fileNameExt, 1));   // remove .

    if ($fileNameExt == "pdf" && $fileType == "application/pdf") 
    {
      if ($fileSize <= 3072) // max 3 MB        
        return TRUE;
    }
    return FALSE;
  }

  // check if pdf is protected
  public function isProtectedPdf ($uploadData) 
  {     
    ini_set('display_errors', 0);     // do not display errors
    $source = $uploadData['full_path']; 

    $parser = new \Smalot\PdfParser\Parser();
    if ($parser->isProtectedPdf($source))
    {
      return true;  // protected
    }
    else
    {
      return false;
    }
  }

  // check if pdf is protected
  public function isProtectedPdfTest ($uploadData) 
  {     
    $source = $uploadData['full_path']; 

    echo nl2br("checking protected\n\n");
    $parser = new \Smalot\PdfParser\Parser();
    if ($parser->isProtectedPdfTest($source))
    {
      return true;  // protected
    }
    else
    {
      return false;
    }
  }

  function isNiceTXT ($uploadData)
  {     
    ini_set('display_errors', 0);     // do not display errors
    $fileNameExt = $uploadData['file_ext'];
    $fileNameExt = strtolower(substr($fileNameExt, 1));   // remove .
    $fileSize = $uploadData['file_size'];
    $fileType = $uploadData['file_type'];

    if ($fileNameExt == "txt" && $fileType == "text/plain")
    {
      if ($fileSize < 20)  // txt and filesize < 20KB
        return TRUE;
    }
    return FALSE;
  }

  function uploadReplySlip ($appNo, $rawName)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->sftpOpen();
    $this->uploadFile($rawName, "pdf", true);
    $this->sftpClose();
  }

  function uploadPaymentSlip ($appNo, $rawName)
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->sftpOpen();
    $this->uploadFile($rawName, "pdf", true);
    $this->sftpClose();
  }

  function uploadFile($rawName, $fileExt, $cleanUp=true)
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileNameHash = md5($rawName);
    $hashDir = substr($fileNameHash, 0, 2);

    $destFileExt = strtolower($fileExt);
      
    $source = UPLOAD_DIR . $_SESSION['appNo'] . "/".$rawName.".".$fileExt;
    
    //echo nl2br("calling sftpToBackend -- source: ".$source."\n\n");
    
    $this->UploadModel->sftpToBackend ($source, $fileNameHash, $destFileExt);

    if ($cleanUp)
    {
      if (file_exists($source)) 
      {
        unlink($source);
        //echo nl2br("unlinked ".$source."\n");
      }
                      
      // remove local hash directory
      if (is_dir(UPLOAD_DIR . $_SESSION['appNo'] . "/".$hashDir)) {
        rmdir('./'.UPLOAD_DIR . $_SESSION['appNo'] . "/".$hashDir);
      }
    }
  }

  function cleanUp($fileName)
  {
    ini_set('display_errors', 0);     // do not display errors
    $source = UPLOAD_DIR . $_SESSION['appNo'] . "/".$fileName;

    if (file_exists($source)) 
    {
      unlink($source);
      //echo nl2br("unlinked ".$source."\n");
    }
  }

  function generatePDF ($uploadData) 
  {            

    ini_set('display_errors', 0);     // do not display errors     
    $fileName = $uploadData['file_name'];
    $rawName = $uploadData['raw_name'];     
    $appNo =  $_SESSION['appNo'];
    $source = UPLOAD_DIR . $appNo . "/".$fileName;
    $dest = UPLOAD_DIR . $appNo . "/".$rawName.".pdf";

    //echo nl2br("converting image ".$source."\n");
    //echo nl2br("to dest file ".$dest."\n");

    $mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'orientation' => 'P']);
    $mpdf->WriteHTML("<img src=".$source.">");
    $mpdf->Output($dest, \Mpdf\Output\Destination::FILE);
    
    //echo nl2br("generated ".$dest."\n");
    if (file_exists($source)) 
    {
      unlink($source);
      //echo nl2br("unlinked ".$source."\n");
    }
  }

  // connect to sftp (do once)
  function sftpOpen () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->load->library('sftp');

    //SFTP configuration
    $ftp_config['hostname'] = SFTP_HOST;
    $ftp_config['username'] = SFTP_USER;
    $ftp_config['password'] = SFTP_PSWD;
    $ftp_config['port'] = 22;
    $ftp_config['debug'] = TRUE;

    // Connect to the remote server
    $this->sftp->connect($ftp_config);
  }

  // disconnect sftp (do once)
  function sftpClose () 
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->sftp->close();
  }

  // upload files via sftp (multiple times)
  function sftpToBackend ($source, $fileNameHash, $fileNameExt, $skip=false) 
  {
    ini_set('display_errors', 0);     // do not display errors
    //echo nl2br("hash: ".$fileNameHash."\n");

    $hashDir = substr($fileNameHash, 0, 2);
    if (!is_dir(UPLOAD_DIR . $_SESSION['appNo'] . "/".$hashDir)) {
      mkdir('./'.UPLOAD_DIR . $_SESSION['appNo'] . "/".$hashDir, 0777, true);    // create dir
    }

    $destination = SFTP_BASE_DIR.$hashDir.'/'.substr($fileNameHash, 2).".".$fileNameExt;

    //echo nl2br("start sftp upload: ".$source." to ".$destination."\n");
    
    //upload file
    $this->sftp->upload($source, $destination);

    if ($skip)
    {
      //write SQLlog if TRUE
      $log = array(
        'sqlDetails'  => FALSE,
        'oldData'     => '',
        'newData'     => '',
        'sqlAction'   => 'sftp '.$source." to ".$hashDir.'/'.substr($fileNameHash, 2),
      );
      $this->AppAuthModel->writeSQLlog($log);
    }
  }

}

?>
