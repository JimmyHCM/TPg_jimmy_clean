<?php defined('BASEPATH') OR exit('No direct script access allowed');

// TEMPORARY local-dev smoke-test controller — renders each reworked view
// with dummy data so the redesign can be checked in a browser. DELETE ME.
class Zpreview extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->helper('form');
    if (($_SERVER['HTTP_HOST'] ?? '') === 'tpgadmission.engg.hku.hk')
      show_404();
  }

  private function base($extra = array())
  {
    $data = array();
    $data['currentYear'] = getDate()['year'];
    $data['currentTime'] = date('Y-n-j G:i');
    $data['menu'] = 'DSRP';
    return array_merge($data, $extra);
  }

  public function captcha()
  {
    $_SESSION['otpCodePrefix'] = 'ABCD';
    $this->load->view('appCaptchaView', $this->base(array('captchaImg' => '<img src="'.base_url().'assets/images/favicon.ico" alt="captcha">')));
  }

  public function pics()     { $this->load->view('appPICSView', $this->base()); }

  public function survey()
  {
    $mediaList = array('HKU website', 'Social media', 'Friends or family', 'Education fair', 'Newspaper');
    $this->load->view('appSurveyView', $this->base(array('mediaList' => $mediaList, 'mediaCount' => count($mediaList))));
  }

  public function statusmsg()
  {
    $this->load->view('statusMsgView', $this->base(array('appNo' => '1105123456', 'statusMsg' => 'Dear applicant,<br><br>Your application is being processed. Please upload any outstanding supporting documents.<br><br>Faculty of Engineering')));
  }

  public function checkstatus() { $this->load->view('appCheckStatusView', $this->base()); }
  public function summary()     { $this->load->view('appUploadSummaryView', $this->base()); }
  public function faq()         { $this->load->view('appFAQView', $this->base()); }

  public function messages()
  {
    $this->load->view('checkMessageView', $this->base(array(
      'appNo' => '1105123456',
      'allMessage' => '2026-08-01 10:12 [to dept]<br>May I know the status of my transcript verification?<br><br>2026-08-02 09:30 [from dept]<br>Your transcript is being verified, thank you for your patience.',
      'newMessage' => '',
    )));
  }

  public function reply()
  {
    $RS = array(
      'currLen' => '1', 'acadYear' => '2026-27', 'currTitle' => 'MSc(Eng) in Energy Engineering',
      'studyMode' => 'Full-time', 'appName' => 'CHAN Tai Man', 'appNo' => '1105123456',
      'commencingDate' => 'September 2026', 'titleDisplay' => 'Master of Science in Engineering (Energy Engineering)',
      'issueDate' => 'July 15, 2026', 'deadline' => '2026-08-30', 'recommendation' => 'F',
      'provisional' => 'N', 'compFeeCurr' => 'HK$180,000', 'totalCredit' => '60',
      'RSfooter' => 'The composition fee is payable in instalments.',
    );
    $this->load->view('appReplyView', $this->base(array('RS' => $RS, 'replied' => false)));
  }

  public function replied()  { $this->load->view('appReplyView', $this->base(array('replied' => true))); }

  public function payment()  { $this->load->view('appPaymentView', $this->base(array('RS' => array(), 'replied' => false))); }
  public function paid()     { $this->load->view('appPaymentView', $this->base(array('replied' => true))); }

  public function logout()   { $this->load->view('appLogoutView', $this->base()); }
  public function maint()    { $this->load->view('appMaintView', $this->base()); }
}
