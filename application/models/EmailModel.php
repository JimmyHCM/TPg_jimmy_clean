<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH."config/userConstants.php";

class EmailModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();
    $this->load->model('AppAuthModel');
  }

  private function isLeap ($year)
  {
    ini_set('display_errors', 0);     // do not display errors
    if (($year%400 == 0) || ($year%4 == 0 && $year%100 != 0))
      return true;
    else
      return false;
  }

  private function countDays ($year, $month, $day)
  {
    ini_set('display_errors', 0);     // do not display errors
    $daysInMonth = array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    if ($this->isLeap ($year))
      $daysInMonth[1] = 29;

    $total = $day;
    for ($i=0; $i<$month-1; $i++)
      $total = $total + $daysInMonth[$i];
    return $total;
  }

  private function dateDiff ($date1, $date2)
  {
    ini_set('display_errors', 0);     // do not display errors
    $diff = 0;

    $d1 = str_replace("-", "", $date1);
    $d2 = str_replace("-", "", $date2);
    $m1 = intval (substr ($d1, 4, 2));
    $m2 = intval (substr ($d2, 4, 2));
    $y1 = intval (substr ($d1, 0, 4));
    $y2 = intval (substr ($d2, 0, 4));
    $d1 = intval (substr ($d1, 6, 2));
    $d2 = intval (substr ($d2, 6, 2));

    if ($y1 == $y2)   // same year
    {
      $diff = $this->countDays ($y2, $m2, $d2) - $this->countDays ($y1, $m1, $d1);
    }
    else 
    {
      $diff = $this->countDays ($y2, $m2, $d2) - $this->countDays ($y2, 1, 1) + $this->countDays ($y1, 12, 31) - $this->countDays ($y1, $m1, $d1);
    }
    return $diff;
  }

  function generateStatusMsg (&$msg, $appNo, $appStatus, $replyStatus)
  {
    ini_set('display_errors', 0);     // do not display errors
    $alreadyUploaded = array ();
    if (isset($_SESSION['uploaded']))
      $alreadyUploaded = $_SESSION['uploaded'];

    $head = EMAIL_HEAD_NOREPLY;

    $msg = $head . "Application status update for <strong>" . $appNo. "</strong>:<br/>"; 

    $msg = $msg . "<p>Thank you for your interest in applying our taught postgraduate programme in the faculty of Engineering, HKU. Our admission team is working hard to process your application.</p>";

    $msg = $msg . "As of " . mdate('%Y-%m-%d %H:%i', now()) .", ";
    $fileNo = count($alreadyUploaded);

    $today = mdate('%Y-%m-%d', now());
    $createDate = $this->AppAuthModel->getAppCreatedDate ($appNo);
    if ($createDate !== false)
    {
      $createDate = substr ($createDate, 0, 10);
    }
    else
    {
      $createDate = $today;
    }
    $dateDiff = $this->dateDiff ($createDate, $today);
    //echo nl2br($dateDiff);

    $moreFiles = false;

    if ($appStatus == 'P') // payment received and confirmed
    {
      $msg = $msg . "<p>The system noticed that we have received and confirmed your payment......</p>";
    }
    else if ($appStatus == 'S') // reply slip not yet received, can ignore
    {
      $msg = $msg . "<p>The system noticed that we have not yet received reply slip from you, ......</p>";
    }
    else if ($appStatus == 'O') // offer letter sent
    {
      if ($replyStatus == 'Y' || $replyStatus == 'N')
        $msg = $msg . "<p>The system noticed that you have submitted the reply slip to us. We will verify and let you know the next step to follow.</p>";
      else if ($replyStatus == 'X')
        $msg = $msg . "<p>The system noticed that offer letter has been sent to you via email. Please observe the deadline and reply to us.</p>";
      else
        $msg = $msg . "<p>The system noticed an error, please report error code: 12345 to us. Sorry to get you confused.</p>";
    }
    else if ($appStatus == 'R') // recommendation made, sent to vetting
    {
      $msg = $msg . "<p>The system noticed that recommendation has been made for your application and sent to central office for vetting. Once the recommendation is confirmed, our team will contact you via email.</p>";
    }
    else if ($appStatus == 'B') // batch list created
    {
      $msg = $msg . "<p>The system noticed that your application is under consideration, if there is any need for further information, our team will contact you via email. Your prompt reply will greatly shorten the review process.</p>";
      $moreFiles = true;
    }
    else if ($appStatus == 'C')  // record created
    {
      $msg = $msg . "<p>The system has a friendly reminder for you:<br/>You might like to make use of <strong>my upload summary</strong> to check if you have uploaded all necessary supporting documents. Once the review process get started, any outstanding documents will induce overheads to the complexity of your application process.</p>";
      $moreFiles = true;
    }
    else // nothing happended yet???? what's appStatus?
    {
      if ($fileNo > 0)
      {
        $msg = $msg . "<p>The system record shows we have received a total of " . $fileNo . " document";
        if ($fileNo > 1)
          $msg = $msg . 's';
        $msg = $msg . ' from you.</p>';
      }
      else
      {
        $msg = $msg . "<p>The system has a friendly reminder for you:</p><p>Please take time to upload necessary supporting documents as the processing time of your application depends on the complexity of your application and on the need for further information.</p>";
      }
    }

    if ($moreFiles)
      $msg = $msg . "<p>On behalf of the admission team, we wish you all the best for the application. If you would like to upload more files or get a summary of files uploaded, click <a href='https://tpgadmission.engg.hku.hk'>here</a> to start the session again.</p>";

    $msg = $msg . '<br/>';
  }

  function generateShortMsg (&$shortMsg)
  {
    ini_set('display_errors', 0);     // do not display errors
    $head = EMAIL_HEAD_NOREPLY;
    $counter = 0;
    $alreadyUploaded = $_SESSION['uploaded'];
    $title = "";

    foreach (FILE_FIELD_MAP as $key => $value) 
    {
      if (in_array(UPLOAD_ITEMS[$key][0], $alreadyUploaded)) 
      {
        if ($title != UPLOAD_ITEMS[$key][5])
        {
          if ($title != "")
            $shortMsg = $shortMsg . "</ul>";
          $title = UPLOAD_ITEMS[$key][5];
          $shortMsg = $shortMsg . $title . ":<ul>";
        }
        $shortMsg = $shortMsg . "<li>" . UPLOAD_ITEMS[$key][6];
        if (substr(UPLOAD_ITEMS[$key][6], -1, 1) == "[")
        {
          $shortMsg = $shortMsg . $_SESSION[UPLOAD_ITEMS[$key][0]."title"] . "]";
        }
        $shortMsg = $shortMsg . "</li>";
        $counter++;
      }
    }
    $shortMsg = $head . "As of " . mdate('%Y-%m-%d %H:%i', now()) .",<br/>a total of " . $counter . " file(s) were received, listed below:<br/><br/>" . $shortMsg . "</ul>";
    $shortMsg = $shortMsg . "<p>--- end of summary ---</p><br/><p>If you would like to upload more files, click <a href='https://tpgadmission.engg.hku.hk'>here</a>.</p>";
  }

  function generateLongMsg ($appNo, &$longMsg, $alreadyUploaded, $pNo, $titleArray)
  {
    ini_set('display_errors', 0);     // do not display errors
    $title = "";
    $head = EMAIL_HEAD_NOREPLY;
    $counter = 0;
    $groupCounter = 0;
    $pEnd = ($pNo+1)*12;

    $lastPempty = TRUE;
    for ($i=$pEnd; $i>$pEnd-10; $i--)
    {
      if (in_array(UPLOAD_ITEMS[$i][0], $alreadyUploaded)) 
        $lastPempty = FALSE;
    }
    if ($lastPempty)
      $pEnd = $pEnd - 10;

    foreach (FILE_FIELD_MAP as $key => $value) 
    {
      if ($key < $pEnd || $key > 47)
      {
        if (UPLOAD_ITEMS[$key][1] != "")
        {
          if ($title != UPLOAD_ITEMS[$key][5])
          {
            if ($title != "")
            {
              if ($groupCounter == 0)
                $longMsg = $longMsg . " nil";

              $longMsg = $longMsg . "</ul>";
              $groupCounter = 0;
            }
            
            $title = UPLOAD_ITEMS[$key][5];

            $longMsg = $longMsg . $title;
            $ok = false;
            for ($j=0; $j<3 && !$ok; $j++)
            {
              if ($key < 12*$j)   // titleD11a / titleD21a / titleD31a
              {
                if ($titleArray[$j] != '')
                  $longMsg = $longMsg . " [". $titleArray[$j] ."]";  
                $ok = true;
              }
            }

            $longMsg = $longMsg . ":<ul style='list-style-type:none'>";
          }
          if (in_array(UPLOAD_ITEMS[$key][0], $alreadyUploaded)) 
          {
            $longMsg = $longMsg . "<li>&#10003; " . UPLOAD_ITEMS[$key][6];
            if (substr(UPLOAD_ITEMS[$key][6], -1, 1) == "[")
            {
              $longMsg = $longMsg . $_SESSION[UPLOAD_ITEMS[$key][0]."title"] . "]";
            }
            $longMsg = $longMsg . "</li>";
            $counter++;
            $groupCounter++;
          }
          /*
          else  // not uploaded
          {
            if (!(substr ($title, 0, 5) == "Other" && $_SESSION[UPLOAD_ITEMS[$key][0]."title"] == ""))
            {
              $longMsg = $longMsg . "<li>&#10061; " . UPLOAD_ITEMS[$key][6];
              if (substr(UPLOAD_ITEMS[$key][6], -1, 1) == "[")
                $longMsg = $longMsg . "]";
              $longMsg = $longMsg . "</li>";
            }
          }
          */
        }
      }
    }

    $longMsg = $head . "File upload summary for <strong>".$appNo."</strong>:<br/>"."As of " . mdate('%Y-%m-%d %H:%i', now()) .",<br/>a total of " . $counter . " file(s) were received, marked with a tick (&#10003;) below:<br/><br/>" . $longMsg;
    if ($groupCounter == 0)
          $longMsg = $longMsg . " nil";

    $longMsg = $longMsg . "</ul>";
    $longMsg = $longMsg . "<br/><br/>--- end of summary ---<br/><br/>If you would like to upload more files, please click <a href='https://tpgadmission.engg.hku.hk'>here</a>.";
  }

}

?>
