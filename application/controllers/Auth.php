<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

  function __construct () {
    parent::__construct ();

    $this->load->library('session');
    $this->load->library('user_agent');
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
    $_SESSION = array ();   // clear data
    
    ini_set('display_errors', 0);     // do not display errors
    $data = array();
    $data['currentYear'] = getDate()['year'];
    $data['currentTime'] = getDate()['year'].'-'.getDate()['mon'].'-'.getDate()['mday'].' '.getDate()['hours'].':'.getDate()['minutes'];
    $this->load->view('appLoginView', $data);
  }

  public function logout ()
  {
    $_SESSION = array ();
    $data = array();
    $data['currentYear'] = getDate()['year'];
    $data['currentTime'] = getDate()['year'].'-'.getDate()['mon'].'-'.getDate()['mday'].' '.getDate()['hours'].':'.getDate()['minutes'];
    $this->load->view('appLoginView', $data);
  }

  public function login ()
  {
    ini_set('display_errors', 0);     // do not display errors
    // testing
    $appNo = $_POST['appNo'];
    $email = $_POST['email'];
    $staffEmail = $_POST['email'];
    $downTime = true;
    $specialMaintenance = false;
    $verified = false;
    $isStaff = false;
    $status = '';
    $_SESSION['staff'] = '';

    $checkStaff = $this->AppAuthModel->verifyStaff ($appNo, $staffEmail);

    if ($checkStaff == 'M') // special maintenance or testing
    {
      $specialMaintenance = true;
      $_SESSION['user_logged'] = true;
      $data = array();

      $data['uploaded'] = array();
      $_SESSION['appNo'] = $appNo;
      $_SESSION['uploaded'] = array();
      $data['verified'] = array();
      $data['Pno'] = 1;

      $data['titleArray'] = array ('', '', '', '');;
      $_SESSION['fileT2title'] = "";
      $_SESSION['fileV1title'] = "";
      $_SESSION['fileV2title'] = "";
      $_SESSION['fileV3title'] = "";

      $data['menu'] = 'DS';
      $data['effectiveByDate'] = 'Aug 2024';
      $data['currentYear'] = getDate()['year'];

      $this->load->view('upload2024View', $data);
    }
    else
    {
      if ($checkStaff == 'A')
      {
        $downTime = false;
        $isStaff = true;
        $_SESSION['staff'] = $email;    // portal ID
        $email = $staffEmail;
      }
      else
      {
        $downTime = $this->AppAuthModel->isSystemDownTime ();
      }

      if ($downTime)
      {
        $data = array();
        $data['currentYear'] = getDate()['year'];
        $this->load->view('appMaintView', $data);
      }
      else
      {
        $verified = FALSE;
        $_SESSION['appNo'] = $appNo;
        $status = $this->AppAuthModel->verifyUser($appNo, $email, $isStaff);
        
        $appStatus = $this->AppAuthModel->getAppStatus ($appNo);
        if ($status == 'A')   // active
        {
          $verified = TRUE;
          $RS = array ();
          $hasRS = $this->AppAuthModel->getAppReplySlip ($appNo, $RS);
          if ($hasRS)
            $_SESSION['getRS'] = true;
          else
            $_SESSION['getRS'] = false;
        }

        if ($appStatus == 'J')  // application closed
        {
          $verified = FALSE;
        }

        if ($verified) 
        {
          //set session variables
          $_SESSION['user_logged'] = TRUE;
          if ($isStaff)
            $_SESSION['userID'] = $_SESSION['uid'];
          else
            $_SESSION['userID'] = $appNo;
          $_SESSION['username'] = $appNo;

          $_SESSION['temp'] = $email;    // temporary storage for OTP only

          $_POST['email'] = "";
          $_SESSION['captcha'] = FALSE;
          $_SESSION['capRefresh'] = 0;

          /*
          $_SESSION['ipAddress']= $this->input->ip_address();
          $_SESSION['browser']= $this->agent->browser();
          $_SESSION['browser_version']= $this->agent->version();
          $_SESSION['os']= $this->agent->platform();
          */
          
          $_SESSION['lastAction'] = time();
          $_SESSION['attempt'] = 3;

        	//write SQLlog if TRUE
          $log = array(
            'sqlDetails'  => TRUE,
            'oldData'     => '',
            'newData'     => '',
            'sqlAction'   => 'login, '.$_SESSION['userID'].', from '.$this->input->ip_address().' using '.$this->agent->browser(),
          );

          $this->AppAuthModel->writeSQLlog($log);

          redirect("captcha/start");
          
          // use below to skip captcha for testing
          //////////////
          //$data = array();
          //$data['currentYear'] = getDate()['year'];
          //$this->load->view('appPICSView', $data);     
          /////////////
        }
        else // show error msg
        {
          if ($status == 'O')  // application does not belong to current admission year
            $this->session->set_flashdata("error", "Input information not match, please try again.");
          else if ($appStatus == 'J')  // application closed
            $this->session->set_flashdata("error", "Login not successful because your application is closed. If you believe something is wrong, please contact us.");
        	else if ($status == 'I')  // inactive
            $this->session->set_flashdata("error", "Sorry, your account is inactive for one day due to too many unsuccessful login attempts. Please try again after a few hours.");
          else if ($status == 'X')  // login error
            $this->session->set_flashdata("error", "Input information not match, please try again.<br><br>OR<br><br>The preparation of your user account is in progress, please try again after you have received corresponding email notification.");

          $data = array();
          $data['currentYear'] = getDate()['year'];
          $data['currentTime'] = getDate()['year'].'-'.getDate()['mon'].'-'.getDate()['mday'].' '.getDate()['hours'].':'.getDate()['minutes'];
          $this->load->view('appLoginView', $data);
        }
      }
    }
  }


}

?>
