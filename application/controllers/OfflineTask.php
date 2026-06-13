<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 0); 

include_once APPPATH."config/userConstants.php";


class OfflineTask extends CI_Controller 
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('SpoutModel');
    $this->load->model('EmailModel');
    $this->load->model('StatisticsModel');
    $this->load->model('FollowupModel');
    $this->load->model('OfferLetterModel');
    $this->load->model('AuthModel');
    $this->load->model('BatchListModel');
    $this->load->model('MasterListModel');
  }

  public function main()
  {
  }

  // reset type count in masterlist
  public function resetTypeCount ()
  {
    $this->MasterListModel->resetTypeCount ();
  }

  // temp
  // import reject list offline
  public function offlineImportReject ()
  {
    $this->db->select('id, portalID, fileLoc');
    $this->db->where('action', 'R');
    $query = $this->db->get('scheduledUpload');

    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $row)
      {
        $processID = $row->id;
        $uid = $row->portalID;
        $source = $row->fileLoc;
        $temppos = strpos ($source, $uid.'/');
        $temppos = $temppos + strlen($uid) + 1;
        $filename = substr ($source, $temppos);
        $toEmail = $uid . '@hku.hk';
        $name = '';
        $dept = '';
        $pos = '';
        $this->AuthModel->getUserInfo ($uid, $name, $dept, $pos);
        $subject = 'import reject list completed';
        $msg = 'Dear '.$name.'<br/><br/>';

        if (file_exists($source))
        {
          $countOrig = 0;
          $this->db->trans_start();
          $rejectArray = array ();
          $countOrig = $this->SpoutModel->prepareRejectArray ($source, $rejectArray);

          $allBatch = array ();
          if (!empty ($rejectArray))
          {
            $this->BatchListModel->readBatchNo ($rejectArray, $allBatch);
            $this->db->update_batch ('importApplication', $rejectArray, 'appNo');
          }
          $this->db->trans_complete();

          if (!empty($rejectArray))
          {
            $len = count($allBatch);
            for ($i=0; $i<$len; $i++)
            {
              $batchNo = $allBatch[$i]['batch'];
              $currCode = $allBatch[$i]['code'];
              $this->StatisticsModel->createBatchStatus ($batchNo, $currCode, $dept);
              $this->MasterListModel->markTypeCount ($currCode, $batchNo);
            }
            $appNoArray = array_column($rejectArray, 'appNo');
            $len = count ($appNoArray);
            for ($i=0; $i<$len; $i++)
              $appNoArray[$i] = trim ($appNoArray[$i]);
            
            $batchArray = array ();
            $countRec = $this->BatchListModel->prepareRejectLetterList ($appNoArray, $batchArray);

            if (($countRec == 0) || empty ($batchArray))
              $msg = 'no application data found. if this is not the case, please report to IT admin.';
            else
            {
              // save details to database table importApplication
              
              // verified OL cannot be saved again, update $batchArray with verified info
              $verifiedList = array ();
              $facOwnList = array ();
              $this->MasterListModel->filterOLverifiedStatus ($batchArray, $verifiedList, $facOwnList, false);

              $this->MasterListModel->saveOfferInfo ($batchArray, '', '', '', '', '');

              if (!empty ($verifiedList))
              {
                $list = '';
                foreach ($verifiedList as $appNo) 
                {
                  $list = $msg . $list . ' ';
                }
                $msg = $msg . 'Reject letter(s) for '. $list . 'were verified, therefore nothing is generated.<br/>';
              }
              if (!empty ($facOwnList))
              {
                $list2 = '';
                foreach ($facOwnList as $appNo) 
                {
                  $list2 = $msg . $list2 . ' ';
                }
                $msg = $msg . 'Faculty admin is now working on these reject letter(s) '. $list2 . ', therefore nothing is generated.<br/>';
              }

              $countRec = count($batchArray) - count ($verifiedList) - count ($facOwnList);

              if ($countRec > 0)
                $msg = $msg . $countRec.' letter(s) generated [original excel: '.$filename.'] and saved in a temporary location. TPg system needs 5 minutes to transport the letter(s) to the viewing location.<br/>';
              if ($countRec < $countOrig)
                $msg = $msg . $countOrig. " records read from excel '.$filename.', but only ".$countRec." records were marked as reject."; 

              log_message('info', 'OfflineTask/offlineImportReject: '.$countRec.' reject letter generated');
                
              $codeCheckerArray = array ();
              $this->AuthModel->getFirstChecker ($codeCheckerArray);
              $this->FollowupModel->reportToChecker ($batchArray, $codeCheckerArray, $uid);
              
              $this->OfferLetterModel->generateOfferLetter ($batchNo, $batchArray, '', '', '', '', '', false);
            }
          }
          else
          {
            $msg = 'not enough information to generate reject letter.';
          }

          if ($toEmail != '')
          {
            $msg = $msg . '<br/><br/><br/>'. EMAIL_FOOTER_INT;
            $this->EmailModel->quickReply($toEmail, $subject, $msg);
          }
          unlink ($source);
        }

        $this->db->where('id', $processID);
        $this->db->delete('scheduledUpload');
      }
    }
  }

  // generate reject letter offline (when user wants to generate > 30 letters)
  public function offlineGenerateRejectLetter ()
  {
    $this->db->select('id, portalID, batch, currCode');
    $this->db->where('action', 'L');
    $query = $this->db->get('scheduledUpload');

    if ($query->num_rows() > 0)
    {
      $row = $query->first_row();
      //foreach ($query->result() as $row)
      {
        $processID = $row->id;
        $uid = $row->portalID;
        $batchNo = $row->batch;
        $currCode = $row->currCode;
        $toEmail = $uid . '@hku.hk';
        $name = '';
        $dept = '';
        $pos = '';
        $this->AuthModel->getUserInfo ($uid, $name, $dept, $pos);
        $subject = 'reject letters generated';
        $msg = 'Dear '.$name.'<br/><br/>';

        $appNoArray = array ();
        $this->BatchListModel->getAppNo ($currCode, $batchNo, $appNoArray);
        $len = count ($appNoArray);
        
        $batchArray = array ();
        $countRec = $this->BatchListModel->prepareRejectLetterList ($appNoArray, $batchArray);
      
        if (($countRec == 0) || empty ($batchArray))
          $msg = 'no application data found. if this is not the case, please report to IT admin.';
        else
        {
          // save details to database table importApplication
          
          // verified OL cannot be saved again, update $batchArray with verified info
          $verifiedList = array ();
          $facOwnList = array ();
          $sentList = array ();
          $this->MasterListModel->filterOLverifiedStatus ($batchArray, $verifiedList, $facOwnList, $sentList, false);

          $this->MasterListModel->saveOfferInfo ($batchArray, '', '', '', '', '');

          if (!empty ($verifiedList))
          {
            $list = '';
            foreach ($verifiedList as $appNo) 
            {
              $list = $msg . $list . ' ';
            }
            $msg = $msg . 'Reject letter(s) for '. $list . 'were verified, therefore nothing is generated.<br/>';
          }
          if (!empty ($facOwnList))
          {
            $list = '';
            foreach ($facOwnList as $appNo) 
            {
              $list = $msg . $list . ' ';
            }
            $msg = $msg . 'Faculty is working on these letter(s) '. $list . ', therefore nothing is generated.<br/>';
          }
          if (!empty ($sentList))
          {
            $list = '';
            foreach ($sentList as $appNo) 
            {
              $list = $msg . $list . ' ';
            }
            $msg = $msg . 'These letter(s) '. $list . ' already sent out, therefore nothing is generated.<br/>';
          }

          $countRec = count($batchArray) - count ($verifiedList);

          if ($countRec > 0)
            $msg = $msg . $countRec.' letter(s) generated and saved in a temporary location. TPg system needs 5 minutes to transport the letter(s) to the viewing location.<br/>';

          log_message('info', 'OfflineTask/offlineGenerateRejectLetter: '.$countRec.' reject letter generated');
          
          $this->OfferLetterModel->generateOfferLetter ($batchNo, $batchArray, '', '', '', '', '', false, $uid, true);

          if ($toEmail != '')
          {
            $msg = $msg . '<br/><br/><br/>'. EMAIL_FOOTER_INT;
            $this->EmailModel->quickReply($toEmail, $subject, $msg);
          }
        }

        $this->db->where('id', $processID);
        $this->db->delete('scheduledUpload');
      }
    }
  }

  // generate and issue reject letter offline
  public function offlineIssueRejectLetter ()
  {
    $this->db->select('id, portalID, batch, currCode');
    $this->db->where('action', 'S');

    // assuming reject letter is huge per batch, so do one by one
    $query = $this->db->get('scheduledUpload', 1);
    $msg = '';
    $toEmail = '';

    if ($query->num_rows() > 0)
    {
      $row = $query->row();
      $processID = $row->id;
      $uid = $row->portalID;
      $batchNo = $row->batch;
      $currCode = $row->currCode;

      // mark the record to "working state"
      $this->db->set ('action', 'W');
      $this->db->where('id', $processID);
      $this->db->update('scheduledUpload');

      $toEmail = $uid . '@hku.hk';
      $name = '';
      $dept = '';
      $pos = '';
      $this->AuthModel->getUserInfo ($uid, $name, $dept, $pos);
      $subject = 'reject letters generated';
      $msg = 'Dear '.$name.'<br/><br/>';

      $appNoArray = array ();
      $this->BatchListModel->getAppNo ($currCode, $batchNo, $appNoArray);
      $len = count ($appNoArray);
      $totalCount = 0;
      $allList = '';

      // break down appNoArray into smaller size
      $appNoArray_chunk = array_chunk ($appNoArray, 20);
      foreach ($appNoArray_chunk as $appNoArray)
      {
        echo nl2br ("working on one chunk\n");
        print_r($appNoArray);
        echo nl2br ("\n\n");

        $batchArray = array ();
        $countRec = $this->BatchListModel->prepareRejectLetterList ($appNoArray, $batchArray);
        $totalCount += $countRec;
    
        if ($countRec > 0)
        {
          // save details to database table importApplication
        
          // verified OL cannot be saved again, update $batchArray with verified info
          $dummyVerifiedList = array ();
          $dummyFacOwnList = array ();
          $sentList = array ();
          $this->MasterListModel->filterOLverifiedStatus ($batchArray, $dummyVerifiedList, $dummyFacOwnList, $sentList, false);

          $this->MasterListModel->saveOfferInfo ($batchArray, '', '', '', '', '');

          if (!empty ($sentList))
          {
            $list = '';
            foreach ($sentList as $appNo) 
            {
              $list = $appNo . ' '. $list;
            }
            $allList = $allList . ' '. $list;
          }
        
          // generate reject letter
          $this->OfferLetterModel->generateOfferLetter ($batchNo, $batchArray, '', '', '', '', '', false, $uid, true);
        }
      }

      if ($allList != '')
      {
        $msg = $msg . 'These letter(s) '. $allList . ' already sent out, therefore nothing is generated.<br/>';
      }
      if ($totalCount == 0)
      {
        $msg = $msg . 'no application data found. if this is not the case, please report to IT admin.';
      }
      else
      { 
       $msg = $msg . $totalCount.' letter(s) generated and saved in a temporary location. TPg system needs 5 minutes to transport the letter(s) to the viewing location.<br/>';
      }

      log_message('info', 'OfflineTask/offlineIssueRejectLetter: '.$totalCount.' reject letter generated');

      echo nl2br ("process ID ".$processID." completed\n\n");
        
      $this->db->where('id', $processID);
      $this->db->delete('scheduledUpload');

      echo nl2br ("now mark issue dates\n\n");

      // mark issue date for reject letter
      $issueDate = date ('F j, Y');
      $issueDateDigits = date ('Y-m-d', strtotime ($issueDate));

      $tobeUpdatedOF = array ();
      $tobeUpdated = array ();
      
      $appNoArray = array ();
      $this->BatchListModel->getAppNo ($currCode, $batchNo, $appNoArray);
      $len = count ($appNoArray);

      $this->db->select('appNo, letterVerified, recommendation');
      $this->db->group_start();
      $appNoArray_chunk = array_chunk ($appNoArray, 100);
      foreach ($appNoArray_chunk as $temp)
      {
        $this->db->or_where_in ('appNo', $temp);
      }
      $this->db->group_end();
      $query = $this->db->get('importApplication');

      if ($query->num_rows() > 0)
      {
        foreach ($query->result() as $row)
        {
          $appNo = $row->appNo;
          $letterVerified = $row->letterVerified;
          $recommendation = $row->recommendation;

          if ($recommendation == 'R' && $letterVerified != 'S')  // reject and letter not yet sent out
          {
            $tobeUpdated[] = array (
              'appNo' => $appNo,
              'letterOwn' => 'F',
              'deptCheck' => 'Y',
              'letterVerified' => 'M',    // marked issued date
            );
            $tobeUpdatedOF[] = array (
              'appNo' => $appNo,
              'issueDate1' => $issueDateDigits,
            );
          }
        }
      }

      if (!empty($tobeUpdated))
      {
        // do transaction as a group
        $this->db->trans_start();

        $this->db->update_batch('importApplication', $tobeUpdated, 'appNo'); 
        $this->db->update_batch('offerFollowup', $tobeUpdatedOF, 'appNo'); 

        $this->db->trans_complete();
      }

      $msg = $msg. "Once reject letter(s) are ready, issue date will be marked and sent out later today.";
    }

    echo nl2br ($msg."\n\n");

    if ($toEmail != '')
    {
      $msg = $msg . '<br/><br/><br/>'. EMAIL_FOOTER_INT;
      $this->EmailModel->quickReply($toEmail, $subject, $msg);
    }
  }

  // generate offer letter offline (when user wants to generate > 30 letters)
  public function offlineGenerateOfferLetter ()
  {
    $this->db->select('id, portalID, batch, currCode, letterDate, replyDate, fee, docDeadline');
    $this->db->where('action', 'O');
    $query = $this->db->get('scheduledUpload');

    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $row)
      {
        $processID = $row->id;
        $uid = $row->portalID;
        $batchNo = $row->batch;
        $currCode = $row->currCode;
        $toEmail = $uid . '@hku.hk';
        $name = '';
        $dept = '';
        $pos = '';
        $this->AuthModel->getUserInfo ($uid, $name, $dept, $pos);

        $shortCode = $this->AuthModel->hasTextCode ($dept);

        $subject = 'offer letters generated';
        $msg = 'Dear '.$name.'<br/><br/>';

        $appNoArray = array ();
        $this->BatchListModel->getAppNo ($currCode, $batchNo, $appNoArray);
        $len = count ($appNoArray);
        
        $batchArray = array ();
        $incompleteList = array ();
        $countRec = $this->BatchListModel->prepareOfferLetterBatchList ($currCode, $batchNo, 'B', $batchArray, $incompleteList, $shortCode, $dept);
      
        if (($countRec == 0) || empty ($batchArray))
          $msg = 'no application data found. if this is not the case, please report to IT admin.';
        else
        {
          // save details to database table importApplication
          
          // verified OL cannot be saved again, update $batchArray with verified info
          $verifiedList = array ();
          $this->MasterListModel->filterOLverifiedStatus ($batchArray, $verifiedList, false);

          $this->MasterListModel->saveOfferInfo ($batchArray, '', '', '', '', '');

          if (!empty ($verifiedList))
          {
            $list = '';
            foreach ($verifiedList as $appNo) 
            {
              $list = $msg . $list . ' ';
            }
            $msg = $msg . 'Reject letter(s) for '. $list . 'were verified, therefore nothing is generated.<br/>';
          }

          $countRec = count($batchArray) - count ($verifiedList);

          if ($countRec > 0)
            $msg = $msg . $countRec.' letter(s) generated and saved in a temporary location. TPg system needs 5 minutes to transport the letter(s) to the viewing location.<br/>';

          log_message('info', 'OfflineTask/offlineGenerateOfferLetter: '.$countRec.' reject letter generated');
          
          $this->OfferLetterModel->generateOfferLetter ($batchNo, $batchArray, '', '', '', '', '', false, $uid);

          if ($toEmail != '')
          {
            $msg = $msg . '<br/><br/><br/>'. EMAIL_FOOTER_INT;
            $this->EmailModel->quickReply($toEmail, $subject, $msg);
          }
        }

        $this->db->where('id', $processID);
        $this->db->delete('scheduledUpload');
      }
    }
  }

  // import TOLA excel. after user submit the excel, system will do this offline
  public function offlineImportTOLA ()
  {
    $this->db->select('id, portalID, fileLoc');
    $this->db->where('action', 'T');
    $query = $this->db->get('scheduledUpload');

    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $row)
      {
        $processID = $row->id;
        $uid = $row->portalID;
        $source = $row->fileLoc;
        $temppos = strpos ($source, $uid.'/');
        $temppos = $temppos + strlen($uid) + 1;
        $filename = substr ($source, $temppos);
        $toEmail = $uid . '@hku.hk';
        $name = '';
        $dept = '';
        $pos = '';
        $this->AuthModel->getUserInfo ($uid, $name, $dept, $pos);
        $subject = 'import TOLA completed';
        $msg = 'Dear '.$name.'<br/><br/>';

        if (file_exists($source))
        {
          $countOrig = 0;

          $countNew = 0;
          $this->SpoutModel->importFileToTable ($source, $countNew, $countOrig, $uid);

          if ($countNew == 0)
            $msg = "Records in the TPg system are up to date, the file you have  uploaded is not added.";
          else
            $msg = "Thank you for updating the TPg system with new records. ". $countNew . " / " . $countOrig . " record(s) were uploaded to the system."; 

          $msg = $msg . '<br/><br/><br/>'. EMAIL_FOOTER_INT;

          $this->EmailModel->quickReply($toEmail, $subject, $msg);
          unlink ($source);
        }
        $this->db->where('id', $processID);
        $this->db->delete('scheduledUpload');
      }
    }
  }

  // send offer letter after user has marked issue date
  // this function is very similar to offerletter/send 
  public function offlineSendOL ()
  {
    $timeCheck = date('Y-m-d');
    $this->db->select('appNo');
    $this->db->where('issueDate1 <=', $timeCheck);
    $this->db->group_start();
      $this->db->where('sentDate1', null);
      $this->db->or_where('sentDate1', '');
    $this->db->group_end();
    $this->db->or_group_start();
      $this->db->where('issueDate2 <=', $timeCheck);
      $this->db->group_start();
        $this->db->where('sentDate2', null);
        $this->db->or_where('sentDate2', '');
      $this->db->group_end();
    $this->db->group_end();
    $query = $this->db->get('offerFollowup');
    $appNoFilterArray = array ();
    $msg = '';
    $counter = 0;

    $sentAppArray = array ();
    $tobeUpdatedStatus = array ();
    $tobeUpdatedReject = array ();
    $appNoLogArray = array ();
    $appNoRLogArray = array ();
    $appNoArray = array ();

    if ($query->num_rows() > 0)
    {
      $appNoFilterArray = array_column($query->result_array(), 'appNo');
    }

    if (!empty ($appNoFilterArray))
    {
      $this->db->reset_query();
      $this->db->select('appNo, recommendation');
      //$this->db->where('letterVerified', 'M');
      $this->db->where_in('appNo', $appNoFilterArray);
      $query = $this->db->get('importApplication');

      if ($query->num_rows() > 0)
      {
        foreach ($query->result() as $row)
        {
          $appNo = $row->appNo;
          $recommendation = $row->recommendation;
          $this->OfferLetterModel->processSend ($appNo, $recommendation, $msg, $counter, $sentAppArray, $tobeUpdatedReject, $tobeUpdatedStatus, $appNoLogArray, $appNoRLogArray);
        }
      }

      if (!empty ($sentAppArray))
      {
        $msg = $msg.'a total of '.$counter.' letter(s) sent.<br/><br/>';
        $this->MasterListModel->markLetterSent ($sentAppArray);
        $this->MasterListModel->updateAppStatusArray ($tobeUpdatedStatus);

        // Log: 29  OL: offer letter sent out
        $this->UtilityModel->writeEventLog ($appNoLogArray, 29);
        // Log: 30  OL: reject letter sent out
        $this->UtilityModel->writeEventLog ($appNoRLogArray, 30);
      }
        
      if (!empty($tobeUpdatedReject))
        $this->db->update_batch("offerFollowup", $tobeUpdatedReject, 'appNo');

      // email summary to faculty senior admin
      if ($msg != '')
      {
        $this->AuthModel->getSeniorAdminList ($seniorAdminArray);
        $emailTo = '';
        $subject = 'Offer letter sent';
        $message = 'Dear ';

        $len = count ($seniorAdminArray);
        for ($i=0; $i<$len; $i++)
        {
          $emailTo = $seniorAdminArray[$i]['portalID'].'@hku.hk,' . $emailTo;
          $message = $message . $seniorAdminArray[$i]['name'] . ', ';
        }
        $message = $message .'<br/><br/>TPg system had just queued up issued offer letters and will be sent out later today, below are the messages generated:<br/><br/>';

        if (!empty ($sentAppArray))
        {
          $seniorAdminArray = array ();
          $appInfoArray = array ();
          $appNoArray = array_column($sentAppArray, 'appNo');
          
          $this->db->reset_query();
          $this->db->select('appNo, recommendation, currCode, currTitle, surName, firstName, midName');
          $this->db->where_in('appNo', $appNoArray);
          $this->db->order_by ('currCode', 'ASC');
          $query = $this->db->get('importApplication');
          if ($query->num_rows() > 0)
          {
            foreach ($query->result() as $row)
            {
              $appNo = $row->appNo;
              $currCode = $row->currCode;
              $currTitle = $row->currTitle;
              $surName = $row->surName;
              $firstName = $row->firstName;
              if ($firstName == null)
                $firstName = '';
              $midName = $row->midName;
              if ($midName == null)
                $midName = '';
              $name = ucwords(strtolower(trim ($surName.' '.$firstName. ' '.$midName)));
              $recommendation = $row->recommendation;
              $appInfoArray[] = array (
                'appNo' => $appNo,
                'name' => $name,
                'currCode' => $currCode,
                'currTitle' => $currTitle,
                'recommendation' => $recommendation,
              );
            }
          }

          $len = count ($appNoArray);
          $line = '';
          for ($i=0; $i<$len; $i++)
          {
            $appNo = $appInfoArray[$i]['appNo'];
            $name = $appInfoArray[$i]['name'];
            $currTitle = $appInfoArray[$i]['currTitle'];
            $recommendation = $appInfoArray[$i]['recommendation'];
            $word = '';
            if ($recommendation == 'C')
              $word = 'conditional offer';
            else if ($recommendation == 'F')
              $word = 'firm offer';
            else if ($recommendation == 'CF')
              $word = 'conditional to firm offer';
            else if ($recommendation == 'R')
              $word = 'reject';

            $line = $line . '<li> applicant: '.$name.', application no: '.$appNo.', ' . $currTitle . ', '. $word. ' letter sent</li>';
                
          }
          if ($line != '')
            $message = $message . '<ul>' . $line . '</ul><br/>';
          if ($msg != '')
            $message = $message . $msg . '<br/>';
        }

        $this->EmailModel->sendEmail ($emailTo, '', '', '', $subject, $message, '', '', 'i', true);
      }

      // email summary to dept admin
      $len = count ($appNoArray);
      $subject = 'Offer letter to be sent';

      for ($i=0; $i<$len; $i++)
      {
        $OLcount = 0;
        $line = '';
        $message = '';
        $contactName = '';
        $currentEmailTo = '';
        $cc = '';
        $currentCurrCode = $appInfoArray[$i]['currCode'];

        if ($currentCurrCode != '')
        {
          $this->AuthModel->getReplyToNameAndEmail ($currentCurrCode, $contactName, $currentEmailTo);
          $cc = $this->AuthModel->getCcEmail ($currentCurrCode);
          $dummyCurrTitle = '';
          $facCheckerEmail = '';
          $facCheckerName = '';
          $this->AuthModel->getFirstCheckerEmail ($currentCurrCode, $dummyCurrTitle, $facCheckerEmail, $facCheckerName);
          $cc = $cc .','.$facCheckerEmail;

          $message = 'Dear ' . $contactName . ',<br/>(Cc to '.$facCheckerName.')<br/><br/>';
          $message = $message .'TPg system had just queued up issued offer letters and will be sent out later today, below are the messages generated:<br/><br/>';

          for ($j=$i; $j<$len; $j++)
          {
            $currCode = $appInfoArray[$j]['currCode'];
            if ($currCode != '')
            {
              $emailTo = '';
              $this->AuthModel->getReplyToNameAndEmail ($currCode, $contactName, $emailTo);
              if ($emailTo == $currentEmailTo)
              {
                $appNo = $appInfoArray[$j]['appNo'];
                $name = $appInfoArray[$j]['name'];
                $currTitle = $appInfoArray[$j]['currTitle'];
                $recommendation = $appInfoArray[$j]['recommendation'];
                $word = '';
                if ($recommendation == 'C')
                  $word = 'conditional offer';
                else if ($recommendation == 'F')
                  $word = 'firm offer';
                else if ($recommendation == 'CF')
                  $word = 'conditional to firm offer';
                else if ($recommendation == 'R')
                  $word = 'reject';

                $line = $line . '<li> applicant: '.$name.', application no: '.$appNo.', ' . $currTitle . ', '. $word. '</li>';

                $OLcount++;

                $appInfoArray[$j]['currCode'] = '';
              }
            }
          }
          if ($OLcount > 0)
          {
            $message = $message . '<ul>' . $line . '</ul><br/>';
            $message = $message . 'a total of '.$OLcount.' letter(s)<br/>';
       
            $bcc = 'mmchoy@hku.hk';
            $this->EmailModel->sendEmail ($currentEmailTo, '', $cc, $bcc, $subject, $message, '', '', 'i', true);
          }
        }
      }
    }
  }

  // email associate dean about pending approval
  public function autoEmailADFBCpendingApproval ()
  {
    $seniorAdminArray = array ();
    $this->AuthModel->getSeniorAdminList ($seniorAdminArray);
    $replyTo = '';

    $elen = count($seniorAdminArray);
    for ($i=0; $i<$elen; $i++)
    {
      $uid = $seniorAdminArray[$i]['portalID'];
      if ($uid != 'mmchoy')
      {
        if ($replyTo != '')
          $replyTo = $replyTo .','.$uid. "@hku.hk";
        else
          $replyTo = $uid. "@hku.hk";
      }
    }

    $IDlist = array ();
    $this->BatchListModel->getPendingApproval ($IDlist);

    //print_r($IDlist);

    $ADinfo = array ();
    $FBCinfo = array ();
    $msg = '';

    if (!empty ($IDlist))
    {
      $this->BatchListModel->prepareApprovalInfo ($IDlist, $ADinfo, $FBCinfo);
    
      $len = count ($ADinfo);
      if ($len > 0)   // associate Dean
      {
        $this->BatchListModel->emailApprover ($replyTo, 'D', $ADinfo);
        $msg = 'Email sent. A total of '.$len.' batch waiting for associate dean to approve.';
      }

      // FBC no need to approve - 2023.7.3
      /*
      $len = count ($FBCinfo);
      if ($len > 0)   // fac board chair
      {
        $this->BatchListModel->emailApprover ($replyTo, 'C', $FBCinfo);
        if ($msg == '')
          $msg = 'Email sent.';
        $msg = $msg . ' A total of '.$len.' batch waiting for faculty board chairman to approve.';
      }
      */

    }
    //echo nl2br ($msg);
  }
}

?>