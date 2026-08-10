<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * LOCAL DEV ONLY - instant stage switcher for client demos.
 *
 * Works on the demo account 1106900014 (tsang.mankit@example.test), which
 * already carries mark-sheet + upload data from db/seed_fake_data.php.
 * The floating demo bar (views/partials/demo_bar.php) calls these actions:
 *
 *   demo/login    sign in as the demo account, skipping captcha/OTP
 *   demo/fresh    first-login state (PICS + survey pending), stays signed in
 *   demo/upload   documents / mark-sheet stage (Stage C)
 *   demo/offer    offer issued - reply-slip stage (Stage D)
 *   demo/payment  payment proof requested - payment stage (Stage D)
 *   demo/done     payment received - completed state
 *
 * Every entry point 404s on the production hostname (same guard as
 * config/database.php), so none of this exists outside local dev.
 */
class Demo extends CI_Controller
{
  const DEMO_APPNO = '1106900014';
  const DEMO_NAME  = 'TSANG Mankit';

  function __construct ()
  {
    parent::__construct ();
    $this->load->library('session');

    if (($_SERVER['HTTP_HOST'] ?? '') === 'tpgadmission.engg.hku.hk')
      show_404();
  }

  public function index ()
  {
    redirect("demo/login");
  }

  // sign in as the demo account without captcha / OTP
  public function login ()
  {
    $appNo = self::DEMO_APPNO;

    $row = $this->db->select('studStatus')->where('appNo', $appNo)->get('application')->row();
    if (!$row)
    {
      echo "Demo account $appNo not found - run: php db/seed_fake_data.php";
      return;
    }

    $_SESSION = array ();
    $_SESSION['user_logged'] = TRUE;
    $_SESSION['appNo'] = $appNo;
    $_SESSION['userID'] = $appNo;
    $_SESSION['username'] = $appNo;
    $_SESSION['currentStatus'] = $row->studStatus;
    $_SESSION['getRS'] = $this->hasOffer();
    $_SESSION['staff'] = '';
    $_SESSION['lastAction'] = time();

    redirect("display/start");
  }

  // first-login state: PICS + survey pending. Stays signed in and lands on
  // the survey; use the Logout menu item to demo PICS/captcha from scratch.
  public function fresh ()
  {
    $this->requireDemoSession();
    $this->db->where('appNo', self::DEMO_APPNO)->delete('offerReply');
    $this->updateApp(array ('appStatus' => 'C', 'mediaSurvey' => 'N'));
    $_SESSION['getRS'] = FALSE;
    redirect("display/start");
  }

  // Stage C: documents / mark sheet
  public function upload ()
  {
    $this->requireDemoSession();
    $this->db->where('appNo', self::DEMO_APPNO)->delete('offerReply');
    $this->updateApp(array ('appStatus' => 'C', 'mediaSurvey' => 'Y'));
    $_SESSION['getRS'] = FALSE;
    redirect("display/upload");
  }

  // Stage D: offer issued, waiting for reply
  public function offer ()
  {
    $this->requireDemoSession();
    $this->setOffer('X');
    $this->updateApp(array ('appStatus' => 'O', 'mediaSurvey' => 'Y'));
    $_SESSION['getRS'] = TRUE;
    redirect("display/start");
  }

  // Stage D: reply accepted, payment proof requested by department
  public function payment ()
  {
    $this->requireDemoSession();
    $this->setOffer('P');
    $this->updateApp(array ('appStatus' => 'S', 'mediaSurvey' => 'Y'));
    $_SESSION['getRS'] = TRUE;
    redirect("display/start");
  }

  // payment proof received - completed state
  public function done ()
  {
    $this->requireDemoSession();
    $this->setOffer('Q');
    $this->updateApp(array ('appStatus' => 'S', 'mediaSurvey' => 'Y'));
    $_SESSION['getRS'] = TRUE;
    redirect("display/payment");
  }

  private function requireDemoSession ()
  {
    if (empty($_SESSION['user_logged']) || ($_SESSION['appNo'] ?? '') != self::DEMO_APPNO)
      redirect("demo/login");
  }

  private function hasOffer ()
  {
    return $this->db->where('appNo', self::DEMO_APPNO)->count_all_results('offerReply') > 0;
  }

  private function updateApp ($fields)
  {
    $this->db->where('appNo', self::DEMO_APPNO)->update('application', $fields);
  }

  // insert-or-update the offerReply row in the wanted state. Uses the
  // account's own currCode; recommendation 'C' so accepting the offer
  // exercises the payment-slip upload inside the reply form.
  private function setOffer ($replyStatus)
  {
    $appNo = self::DEMO_APPNO;
    $currCode = $this->db->select('currCode')->where('appNo', $appNo)->get('application')->row()->currCode;

    $accepted = ($replyStatus == 'P' || $replyStatus == 'Q' || $replyStatus == 'Y');
    $row = array (
      'appNo'          => $appNo,
      'replyStatus'    => $replyStatus,
      'currCode'       => $currCode,
      'appName'        => self::DEMO_NAME,
      'studyMode'      => 'F',
      'acadPlanCode'   => '9T001M',
      'issueDate'      => date('Y-m-d', strtotime('-3 days')),
      'deadline'       => date('Y-m-d', strtotime('+14 days')),
      'replyDate'      => $accepted ? date('Y-m-d', strtotime('-1 days')) : null,
      'provisional'    => 'N',
      'recommendation' => 'C',
      'signature'      => $accepted ? self::DEMO_NAME : null,
      'admYear'        => 2026,
      'isLocal'        => 'N',
    );

    $this->db->where('appNo', $appNo)->delete('offerReply');
    $this->db->insert('offerReply', $row);
  }
}
