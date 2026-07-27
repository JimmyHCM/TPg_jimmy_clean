<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha extends CI_Controller
{
  function __construct() 
  {
    parent::__construct();

    // Load session library
    $this->load->library('session');

    // Load helpers
    $this->load->helper('captcha');
    $this->load->helper('string');

    $this->load->model('AppAuthModel');
    $this->load->model('CodeModel');

    if($_SESSION['user_logged'] == FALSE)   
    {
      $this->session->set_flashdata("error", "redirecting to login page...");
      redirect("auth");
    }
  }

  public function index ()
  {
    ini_set('display_errors', 0);     // do not display errors
    $this->session->set_flashdata("error", "redirecting to login page...");
    redirect("auth");
  }

  // setup captcha
  private function setupCaptcha($captcha)
  {
    ini_set('display_errors', 0);     // do not display errors
    // Unset previous captcha and set new captcha word
    $this->session->unset_userdata('captchaCode');
    $this->session->set_userdata('captchaCode', $captcha['word']);

    // Pass captcha image to view
    $data['captchaImg'] = $captcha['image'];
    return $data;
  }

  // setup OTP
  private function setupOTP($recipientEmail, $show)
  {
    ini_set('display_errors', 0);     // do not display errors
    //generate otpCode
    $data['otpCode'] = random_string('numeric', 6);
    $data['otpCodePrefix'] = random_string('alpha',4);
                
    $this->session->unset_userdata('otpCode');
    $this->session->set_userdata('otpCode', $data['otpCode']);
    $this->session->unset_userdata('otpCodePrefix');
    $this->session->set_userdata('otpCodePrefix', $data['otpCodePrefix']);

    // local dev has no mail transport: skip SMTP (it hangs then fatals) and
    // reveal the OTP on screen so login can proceed
    // (same hostname guard as config/database.php - never true on production)
    if (($_SERVER['HTTP_HOST'] ?? '') !== 'tpgadmission.engg.hku.hk')
    {
      $this->session->set_flashdata("info", "[local dev] OTP is <strong>" . $data['otpCodePrefix'] . "-" . $data['otpCode'] . "</strong> (enter the 6 digits below)");
      return;
    }

    $result = $this->AppAuthModel->sendOtpCode($data['otpCodePrefix'], $data['otpCode'], $recipientEmail);

    if ($result)
    {
      if ($show)
        $this->session->set_flashdata("info", "A 6 digits OTP authorization code has been sent to your mail box, please check and enter below.");
    }
    else
    {
      $this->session->set_flashdata("info", "Authorization code cannot send to your mail box, please try later.");
    }
  }

  // setup captcha and OTP
  private function securitySetup($recipientEmail, $show)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (isset($_SESSION['captcha']))
    {
      if ($_SESSION['attempt'] > 0)
      {
        // first time OR code expired OR refresh counter < 1
        if ($_SESSION['captcha'] == FALSE || time() - $_SESSION['lastAction'] > 180 ||
            (isset($_SESSION['capRefresh']) && $_SESSION['capRefresh'] < 2))
        {
          $_SESSION['captcha'] = TRUE;
          $captcha = $this->CodeModel->createCaptcha();
          $data = $this->setupCaptcha($captcha);
          $_SESSION['capRefresh']++;

          $_SESSION['lastAction'] = time();

          $this->setupOTP($recipientEmail, $show);
          return $data;
        }
        else
        {
          $this->session->set_flashdata("info", "Security codes have expired, please try again after 3 minutes.");
        }
      }
      else
      {
        $this->session->set_flashdata("info", "Too many errors, account inactive for one day. Please try again after a few hours.");
        log_message('info', 'Captcha/securitySetup: account set inactive due to too many failed authentication');
        $this->AppAuthModel->setInactive();
      }
    }
    return NULL;
  }

  public function captchaSubmit()
  {
    ini_set('display_errors', 0);     // do not display errors
    // If captcha form is submitted
    $data = array ();

    if($this->input->post('submit'))
    {
      $errorMsg = "";

      if ($this->AppAuthModel->sessionExpired(180))
      {
        $_SESSION['attempt']--;
        $errorMsg = "Code expired, please try again.
          Remaining attempt(s) = ".$_SESSION['attempt'];
        $recipientEmail = $_SESSION['temp'];
      }
      else
      {
        $recipientEmail = $_SESSION['temp'];

        $inputCaptcha = $this->input->post('captcha');
        $sessCaptcha = $this->session->userdata('captchaCode');
        $inputOtpCode = $this->input->post('otpCode');
        $sessOtpCode = $this->session->userdata('otpCode');
        $sessOtpCodePrefix = $this->session->userdata('otpCodePrefix');

        if (($inputCaptcha === $sessCaptcha) && ($inputOtpCode === $sessOtpCode))
        {
          redirect("captcha/done","refresh");
        }
        else
        {
          $_SESSION['attempt']--;
          $errorMsg = "Input information not match, please try again. Remaining attempt(s) = ".$_SESSION['attempt'];
        }
      }

      if ($errorMsg != "")
      {
        // show error msg
        $this->session->set_flashdata("info", $errorMsg);
        $_SESSION['captcha'] = FALSE;
        $_SESSION['capRefresh'] = 0;
        $data = $this->securitySetup($recipientEmail, FALSE);
        $data['currentYear'] = getDate()['year'];
        $this->load->view('appCaptchaView', $data);
      }
    }
    else
    {
      $this->session->set_flashdata("error", "oops.... something is wrong, please login again");
      $data['currentYear'] = getDate()['year'];
      $data['currentTime'] = getDate()['year'].'-'.getDate()['mon'].'-'.getDate()['mday'].' '.getDate()['hours'].':'.getDate()['minutes'];
      $this->load->view('appLoginView', $data);
    }
  }

  public function done()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = array ();
    $_SESSION['captcha'] = NULL;
    $_SESSION['capRefresh'] = NULL;
    $_SESSION['temp'] = NULL;
    $_SESSION['lastAction'] = time();
    $_SESSION['attempt'] = NULL;
    $_SESSION['otpCode'] = NULL;
    $_SESSION['captchaCode'] = NULL;
    $_SESSION['otpCodePrefix'] = NULL;

    //write SQLlog if TRUE
    $log = array(
      'sqlDetails'  => TRUE,
      'oldData'     => '',
      'newData'     => '',
      'sqlAction'   => 'captcha passed, '.$_SESSION['userID'],
    );

    $this->AppAuthModel->writeSQLlog($log);

    $data['currentYear'] = getDate()['year'];

    // do once throughout the whole application
    $appNo = $_SESSION['appNo'];
    if (!$this->AppAuthModel->takenSurvey ($appNo))   // first time login
      $this->load->view('appPICSView', $data);
    else
      redirect("display/start");
  }

  public function start()
  {
    ini_set('display_errors', 0);     // do not display errors
    $data = $this->securitySetup($_SESSION['temp'], TRUE);
    $data['currentYear'] = getDate()['year'];
    $this->load->view('appCaptchaView', $data);
  }

}
?>
