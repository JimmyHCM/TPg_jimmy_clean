<?php
class ErrorHandler extends CI_Controller
{

  function __construct () {
    parent::__construct ();
  }

  public function index()
  {
    $data = array ();
    $this->output->set_status_header('404');
    $data['currentYear'] = getDate()['year'];
    $this->load->view('app404View', $data); 
  }

}

?>
