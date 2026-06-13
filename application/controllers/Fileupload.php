<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/Sftp.php";

class Fileupload extends CI_Controller 
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('SlipModel');
    $this->load->library('javascript');
        //$this->load->library('vendor/jquery/jquery.min.js');
  }

  private $upload_path = "./uploads";

  public function index() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array ();
    if (!$_SESSION['user_logged'])   
    {            
      $this->session->set_flashdata("error", "Please login first to view this page!!!");
      redirect("auth");
    }
    else 
    {
      $data['currentYear'] = getDate()['year'];
      $this->load->view("appFrontView", $data);
    }
  }

  public function currStudent() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
    $data['currentYear'] = getDate()['year'];
    $this->load->view("appFileupload_SView", $data);
  }

  public function currNotStudent() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $data['effectiveByDate'] = $this->SlipModel->getUserDefinedText ('EFFECTiveByDate');
    $data['currentYear'] = getDate()['year'];
    $this->load->view("appFileupload_CView", $data);
  }

  public function markSheet() 
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $data['currentYear'] = getDate()['year'];
    $this->load->view("appMarksheetView", $data);
  }
    
  public function validate()
  {
    ini_set('display_errors', 0);     // do not display errors
    if (isset($_POST["validate"])) 
    {
      // Get Image Dimension
      $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
      $width = $fileinfo[0];
      $height = $fileinfo[1];

      // Validate file input to check if is not empty
      if (! file_exists($_FILES["file-input"]["tmp_name"])) 
      {
        $response = array(
          "type" => "error",
          "message" => "Choose image file to upload."
        );
      }    // Validate image file size
      else if (($_FILES["file-input"]["size"] > 2100000)) 
      {
        $response = array(
          "type" => "error",
          "message" => "Image size too big (max 2MB)"
        );
      }    // Validate image file size
      else if (($_FILES["file-input"]["size"] < 1000000)) 
      {
        $response = array(
          "type" => "error",
          "message" => "Image size too small (min 1MB)"
        );
      }    
      // Validate image file dimension
      /*
      else if (!(($width < "1080" && $height < "1920") || ($height < "1080" && $width < "1920"))) 
      {
        $response = array(
          "type" => "error",
          "message" => "Image dimension should be within 1920x1080"
        );
      }
      */
      else
      {
        $response = array(
          "type" => "success",
          "message" => "file is ready to upload"
        );
      }
    }
  }

  public function upload()
  {
    ini_set('display_errors', 0);     // do not display errors
    if( ! empty($_FILES))
    {
      $config["upload_path"] = $this->upload_path;
              //$config["upload_path"] = "./uploads";
      $config["allow_type"] = "gif|jpg|png";
      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload("file"))
      {
        echo "failed to upload file(s)";
      }
    }
  }

  public function remove()
  {
    ini_set('display_errors', 0);     // do not display errors
    $file = $this->input->post("file");
    if ($file && file_exists($this->upload_path . "/" . $file)){
      unlink($this->upload_path . "/" . $file);
    }
  }

  public function list_files()
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->load->helper("file");
    $files = get_filenames($this->upload_path);
          //we need name and size for dropzone mockfile
    foreach ($files as &$file)
    {
      $file = array (
        'name' => $file,
        'size' => filesize($this->upload_path . "/" . $file)
      );
    }

    header("Content-type: text/json");
    header("Content-type: application/json");
    echo json_encode($files);
  }

}
