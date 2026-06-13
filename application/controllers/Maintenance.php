<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller
{

  function __construct () {
    parent::__construct ();

    $this->load->library('session');
    $this->load->library('user_agent');
    $this->load->model('MaintModel');
    $this->load->model('AppAuthModel');
  }
  
  // dump all user input to screen
  private function dumpInput()
  {
    $post = array();
    foreach ($_POST as $key => $value) {
      $post[$key] = $this->input->post($key);
    }
    var_dump($post);
  }

  public function index()
  {
      session_unset();
      session_destroy();
      session_start();
      $data = array ();
    $data['currentYear'] = getDate()['year'];
    $this->load->view('maintLoginView', $data);
  }

  public function login()
  {
    ini_set('display_errors', 0);     // do not display errors
    $result = $this->MaintModel->validateUser();
    $data = array ();
    $data['currentYear'] = getDate()['year'];

    if ($result) 
    {
      $this->load->view('maintImportView', $data);
    }
    else 
    {
      $this->session->set_flashdata("error", "No such account exists in database");
      $this->load->view('maintLoginView', $data);
    }
  }

  public function logout()
  {
    ini_set('display_errors', 0);     // do not display errors
    unset($_SESSION);
    session_destroy();
  }

  public function import()
  {
    ini_set('display_errors', 0);     // do not display errors
    if(!$_SESSION['user_logged'] || ($_SESSION['privilegeLevel'] != 9))   {            
      $this->session->set_flashdata("error", "Please login first to view this page!!!");
      redirect("maintenance");
    }
    else 
    {
      $filename = $_POST['filename'];

      $result = $this->AppAuthModel->importRecord($filename);
      $data = array ();
      $data['currentYear'] = getDate()['year'];

      if ($result >= 0) 
      {

    	//write SQLlog if TRUE
        $log = array(
          'sqlDetails'  => TRUE,
          'oldData'     => '',
          'newData'     => '',
          'sqlAction'   => $result . ' records added',
        );

        $this->AppAuthModel->writeSQLlog($log);

        $this->session->set_flashdata("success", $result . " records added.");

        $this->load->view('maintImportView', $data);
      }
      else 
      {
    	// show error msg
        $this->session->set_flashdata("error", "File error during opening, please check.");
        $this->load->view('maintImportView', $data);
      }
    }
  }

}

?>
