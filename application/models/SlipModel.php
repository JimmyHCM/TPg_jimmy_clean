<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/Sftp.php";
include_once APPPATH."config/userConstants.php";

class SlipModel extends CI_Model {

  function __construct () 
  {
    parent::__construct ();

    $this->load->library('Pdf');
    $this->dblog = $this->load->database('tpglog',TRUE);
    $this->load->model('AppAuthModel');
    $this->load->model('UploadModel');
  }

  private function initPdf ($pdf, $RS)
  {
    ini_set('display_errors', 0);     // do not display errors
      // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Faculty of Engineering, HKU');
      $pdf->SetTitle('reply slip');

      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      // set default font subsetting mode
      $pdf->setFontSubsetting(false);
      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

      // set margins
      if ($RS['acadPlanTitle'] != '')
        $pdf->SetMargins(23, 12, 24);
      else
        $pdf->SetMargins(23, 16, 24);

      $pdf->setCellHeightRatio (1.13);
      $pdf->SetFooterMargin (0);
      $pdf->setPageOrientation (PDF_PAGE_ORIENTATION, false, 5);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
      {
          require_once(dirname(__FILE__).'/lang/eng.php');
          $pdf->setLanguageArray($l);
      }   
  }

  // generate offer details for reply slip
  private function genReplySlipOfferDetail ($pdf, $RS)
  {
    ini_set('display_errors', 0);     // do not display errors

    $line = PARA_SPACE.PARA_SPACE.'<strong>Notice of Admission '.$RS['acadYear'].': </strong>'.PARA_SPACE.PARA_SPACE.$RS['currTitle'].PARA_SPACE. '('.$RS['studyMode'].')<br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);

    $line = PARA_SPACE.'<em>(To be completed by the Faculty Office.)</em><br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);

    $line = PARA_SPACE.'The candidate named below:<br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);

    $table = '<table><tr><td style="width:10%"><br/></td><td style="width:25%">Candidate:</td><td style="width:65%">'.$RS['appName'].'</td></tr>';
    $table = $table.'<tr><td></td><td>Application Number:</td><td>'.$RS['appNo'].'</td></tr></table><br/>';
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);

    $line = PARA_SPACE.'is offered admission to the following programme commencing in '.$RS['commencingDate'].':<br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);

    $titleDisplay = $RS['titleDisplay'];
    $acadPlanDisplay = false;
    if ($RS['acadPlanTitle'] != '')
    {
      $titleDisplay = $titleDisplay.'<br/>('.$RS['acadPlanTitle'].')';
      $acadPlanDisplay = true;
    }

    $table = '<table><tr><td style="width:10%"><br/></td><td style="width:25%" valign="bottom">Programme:</td><td style="width:65%">'.$titleDisplay.'</td></tr>';
    $table = $table . '<tr><td></td><td>Mode of Study:</td><td>'.$RS['studyMode'].'</td></tr>';
    $table = $table . '<tr><td></td><td>Programme Duration:</td><td>';
    $table = $table . $RS['currLen'].' year';

    if ($RS['currLen'] == 1 || $RS['currLen'] == '1')
      $table = $table . '</td></tr></table><br/>';
    else
      $table = $table . 's</td></tr></table><br/>';

    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);

    $lineStyle = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    
    if ($acadPlanDisplay)  // 2 lines for curriculum
      $extra = 0;
    else
      $extra = 4;

    if ($RS['currCode'] == 421)
      $adjust = 5;
    else
      $adjust = 0;

    $pdf->Line(85, 24+$extra, 170, 24+$extra, $lineStyle);

    $pdf->Line(78, 48+$extra, 170+$adjust, 48+$extra, $lineStyle);
    $pdf->Line(78, 52+$extra, 170+$adjust, 52+$extra, $lineStyle);

    $pdf->Line(78, 72, 170+$adjust, 72, $lineStyle);
    $pdf->Line(78, 76, 170+$adjust, 76, $lineStyle);
    $pdf->Line(78, 80, 170+$adjust, 80, $lineStyle);
  }

  // generate acceptance notes for reply slip
  private function genReplySlipAcceptanceNotes ($pdf, $RS)
  {
    ini_set('display_errors', 0);     // do not display errors
    $empty = APPPATH.'../assets/images/empty.jpg';
    $tick = APPPATH.'../assets/images/tick.jpg';
    $circleBullet = APPPATH.'../assets/images/bullet.jpg';

    if ($RS['reply'] == 'Y' || $RS['reply'] == 'P')
    {
      $acceptBullet = $tick;
      $rejectBullet = $empty;
    }
    else
    {
      $acceptBullet = $empty;
      $rejectBullet = $tick;
    }

    $pdf->SetFont('times', '', 9.5, '', true);

    $block = '<table><tr><td style="width:5%"><img src="'.$acceptBullet.'" height="15px"></td><td colspan="2" style="width:95%" align="justify">ACCEPTANCE<br/>';

    if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF')
      $block = $block.'I, the candidate named above, accept this <strong>firm offer of admission</strong>, and in so doing and without prejudice to other rights and remedies of the University,</td></tr>';
    else if ($RS['recommendation'] == 'C')
      $block = $block.'I, the candidate named above, accept this <strong>conditional offer of admission</strong> under the conditions laid down in the offer of admission of '.date ('M j, Y', strtotime ($RS['issueDate'])).', and in so doing and without prejudice to other rights and remedies of the University,</td></tr>';

    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td style="width:92%" align="justify">I understand and agree that the University may, at its absolute discretion exercisable at any time, request me to produce the originals of transcripts, certificates, references, reports, assignments, publications and any other relevant documents in support of and/or in connection with my application and/or admission, regardless of whether such documents have been previously submitted to it.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">I understand and agree that if there are any discrepancy, misrepresentation, forgery, falsification, plagiarism or other irregularities in respect of my application and/or the above documents which the University deems to be material, the University has the right at any time to withdraw the offer of admission, treat any acceptance of the offer as null and void, terminate my enrolment and student status in the University, and make a report to the relevant law enforcement agencies which may result in criminal prosecution.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">I agree to obey all rules and regulations of the University as long as they apply to me as a member of the University.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">I understand that I am liable to pay the first instalment of composition fee';

    if ($RS['studyMode'] == 'Full-time')
      $block = $block . ', caution money of HK$350 and the Student Activity Fee of HK$100 (applicable to full-time students only) ';
    else
      $block = $block . 'and caution money of HK$350 ';

    $block = $block . 'upon acceptance of the offer and that fees once paid are non-refundable and non-transferable.  The composition fee<sup>#</sup> of this '.$RS['currLen'].' year';

    if ($RS['currLen'] != '1')
      $block = $block . 's';
    $block = $block .' ['. lcfirst($RS['studyMode']).'] programme for '.$RS['acadYear'].' is '.$RS['compFeeCurr'];

    if ($RS['provisional'] == 'Y')
      $block = $block.'<sup>*</sup> (provisional)';

    $block = $block.' for '.$RS['totalCredit'].' credit-units.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">Pursuant to the Personal Data (Privacy) Ordinance, I agree that the personal data provided by me can be used by the University for all academic and administrative purposes.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">I understand that The University of Hong Kong is a ‘public body’ and is therefore subject to the meaning of the Prevention of Bribery Ordinance.</td></tr>';
    $block = $block.'<tr><td></td><td style="width:3%"><img src="'.$circleBullet.'" height="5px"></td><td align="justify">I understand that concurrent registration by a student of this University for another post-secondary qualification either at this University or another institution without the approval of the Senate <em>given in advance</em> is prohibited by University regulations and that breach of this regulation may result in discontinuation of my studies at the University.<br/></td></tr>';

    $block = $block.'<tr><td><img src="'.$rejectBullet.'" height="15px"></td><td colspan="2" style="width:95%"  align="justify">REJECTION<br/>I, the candidate named above, decline this <strong>';

    if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF')
      $block = $block . 'firm';
    else if ($RS['recommendation'] == 'C')
      $block = $block . 'conditional';

    $block = $block . ' offer of admission</strong>.</td></tr></table>';
    $pdf->writeHTMLCell(0, 0, '', '', $block, 0, 1, 0, true, '', true);
  }

  // generate bottom footnotes for reply slip
  private function genReplySlipFootnotes ($pdf, $RS)
  {
    ini_set('display_errors', 0);     // do not display errors
    // Set font
    $pdf->SetFont('times', '', 9, '', true);

    $table = '<br/><table><tr><td style="width:3%">#</td><td style="width:92%" align="justify">'.$RS['RSfooter'].'</td></tr>';

    if ($RS['provisional'] == 'Y')
      $table = $table.'<tr><td>*</td><td align="justify">Pending the University’s announcement on the composition fee for '.$RS['acadYear'].'.</td></tr>';
    $table = $table.'</table>';

    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);
  }

  function genReplySlip ($RS, &$rawName, &$dest, $keyfile, $fileExt, $regen=false)
  {       
    ini_set('display_errors', 0);     // do not display errors        
    $rawName = 'reply'.$RS['appNo'].$RS['recommendation'];      
    if (!is_dir(UPLOAD_DIR . $RS['appNo'])) {
      mkdir('./'.UPLOAD_DIR . $RS['appNo'], 0755, true);    // create dir
    }
    $dest = PDF_DIR . $RS['appNo'] . "/".$rawName.".pdf";

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
    $this->initPdf ($pdf, $RS);
    $pdf->AddPage(); 
    // Set font
    $pdf->SetFont('times', '', 10, '', true);   

    $line = '<strong>THE UNIVERSITY OF HONG KONG</strong><br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p align="center">'.$line.'</p>', 0, 1, 0, true, '', true);

    $this->genReplySlipOfferDetail ($pdf, $RS);

    $image_file = APPPATH.'../assets/images/signature.png';
    
    $table = '<table><tr><td style="width:35%"><br/><br/><br/><br/><br/>'.PARA_SPACE_HALF.'Date:'.PARA_SPACE.PARA_SPACE.$RS['issueDate'].'</td><td style="width:20%"><br/><br/><br/><br/><br/>Signature:</td><td style="width:35%" align="center"><img src="'.$image_file.'" height="80px"></td><td style="width:10%"><br/></td></tr>';
    $table = $table.'<tr><td><br/></td><td><br/></td><td align="center">'.FAC_SEC.'<br/>Secretary, Faculty of Engineering<br/>for Registrar</td><td><br/></td></tr></table>';
    $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);

    $lineStyle = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    $lineStyleThick = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

    $pdf->Line(38, 103.5, 78, 103.5, $lineStyle);
    $pdf->Line(98, 103.5, 177, 103.5, $lineStyle);
    $pdf->Line(21, 122, 185, 122, $lineStyleThick);

    if ($RS['recommendation'] == 'C')
      $wordO = 'CONDITIONAL';
    else if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF')
      $wordO = 'FIRM';

    $line = '<br/><strong>'.$wordO.' OFFER OF ADMISSION</strong><br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p align="center">'.$line.'</p>', 0, 1, 0, true, '', true);

    $line = '<em>To be completed and submitted by the candidate by </em>'.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE;
    $line = $line .$RS['deadline'].'<br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);
    //*******
//    $pdf->Line(100, 132, 185, 132, $lineStyle);
    $pdf->Line(100, 135.5, 185, 135.5, $lineStyle);

    $line = '<em>Please tick the appropriate box below.</em><br/>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);

    $this->genReplySlipAcceptanceNotes ($pdf, $RS);

    $line = '<br/>';
    if ($RS['recommendation'] == 'F' || $RS['recommendation'] == 'CF')
      $line = $line . '<br/>';
    $line = $line.PARA_SPACE.'Date:'.PARA_SPACE.PARA_SPACE.$RS['replyDate'].PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.PARA_SPACE.'Signature: '.PARA_SPACE.PARA_SPACE.PARA_SPACE.$RS['signature'];
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);
    $currentY = $pdf->GetY();

    $block = '<p align="center">Candidate<br/></p>';
    $pdf->writeHTMLCell('', '', 108, '', $block, 0, 1, 0, true, '', true);

    $lineStyle = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    //********
//    $pdf->Line(38, 267, 78, 267, $lineStyle);
//    $pdf->Line(98, 267, 185, 267, $lineStyle);
    //$pdf->Line(38, 271, 78, 271, $lineStyle);
    //$pdf->Line(98, 271, 185, 271, $lineStyle);
    $pdf->Line(38, $currentY, 76, $currentY, $lineStyle);
    $pdf->Line(100, $currentY, 185, $currentY, $lineStyle);

    $this->genReplySlipFootnotes ($pdf, $RS);
    $pdf->endPage();

    if (!$regen)   // if regen of reply slip, no need to add payment page
    {
      if (($RS['recommendation'] == 'C' || $RS['recommendation'] == 'F') && ($RS['reply'] == 'Y' || $RS['reply'] == 'P'))
      {
        $this->genPaymentPage ($pdf, $RS, $keyfile, $fileExt);
      }
    }

    // Close and output PDF document
    ob_clean();
    // output to screen for testing
//        $pdf->Output('offer'.$batchArray[$i]['appNo'].'.pdf', 'I');
    $pdf->Output($dest, 'F');   
    log_message('info', 'SlipModel/genReplySlip: generated for '.$RS['appNo'].' '.$RS['recommendation'].' '.$RS['replyStatus']);
  } 

  // gen pdf for payment slip (this is a re-upload)
  function genPaymentSlip ($RS, &$rawName, &$dest, $keyfile, $fileExt)
  {    
    ini_set('display_errors', 0);     // do not display errors           
    $rawName = 'payment'.$RS['appNo'].$RS['recommendation'];      
    if (!is_dir(UPLOAD_DIR . $RS['appNo'])) {
      mkdir('./'.UPLOAD_DIR . $RS['appNo'], 0755, true);    // create dir
    }
    $dest = PDF_DIR . $RS['appNo'] . "/".$rawName.".pdf";

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
    $this->initPdf ($pdf, $RS);
    $this->genPaymentPage ($pdf, $RS, $keyfile, $fileExt);

    // Close and output PDF document
    //ob_clean();
    $pdf->Output($dest, 'F');   
    log_message('info', 'SlipModel/genPaymentSlip: payment upload again for '.$RS['appNo'].' '.$RS['recommendation'].' '.$RS['replyStatus']);
  }

  // pdf page for payment slip image
  private function genPaymentPage (&$pdf, $RS, $keyfile, $fileExt)
  {
    ini_set('display_errors', 0);     // do not display errors
    $pdf->addPage();
    $paymentSlip = PDF_DIR . $RS['appNo'] . "/". $RS['appNo'] .$keyfile.$fileExt;
    $imageFile = $paymentSlip;

    $line = '<p>Payment Slip<br/>Uploaded on '.date('F j, Y').'</p>';
    $pdf->writeHTMLCell(0, 0, '', '', '<p>'.$line.'</p>', 0, 1, 0, true, '', true);
    $currentY = $pdf->GetY();
    $currentY = $currentY + 5;
    $currentX = 15;

    $boxW = 200 - $currentX;
    $boxH = 285 - $currentY;

    if (strtolower($fileExt) == ".png")
    {
      $pngImage = imagecreatefrompng($paymentSlip);
    
      if ($pngImage === false) 
      {
        die("Failed to create image from PNG");
      }
    
      // Convert to JPG
      $paymentSlipJPG = PDF_DIR . $RS['appNo'] . "/". $RS['appNo'] .$keyfile.".jpg";
      imagejpeg($pngImage, $paymentSlipJPG, 90);
      imagedestroy($pngImage);
      $imageFile = $paymentSlipJPG;
    }

    list($imgWpx, $imgHpx) = getimagesize($imageFile);  // [w, h]
    $ratio = $imgWpx / $imgHpx;

    // candidate sizes
    $wByWidth  = $boxW;
    $hByWidth  = $wByWidth / $ratio;

    $hByHeight = $boxH;
    $wByHeight = $hByHeight * $ratio;

    // choose the size that fits both width and height
    if ($hByWidth <= $boxH) 
    {
      $imgWmm = $wByWidth;
      $imgHmm = $hByWidth;
    } 
    else 
    {
      $imgWmm = $wByHeight;
      $imgHmm = $hByHeight;
    }

    $pdf->Image($imageFile, $currentX, $currentY, $imgWmm, $imgHmm);
    unlink ($imageFile);

    $pdf->endPage();      
  }

  // get value of $code from DB table variations
  // return XXXX to indicate error
  public function getUserDefinedText ($code)
  {
    $this->db->select("replaceBy");
    $this->db->where('code', $code);
    $query = $this->db->get('variations');

    if ($query->num_rows() > 0)
    {
      $text = $query->row()->replaceBy;
      if ($text != null && $text != '')
        return $text;
    }
    return 'XXXX';
  }

}

?>
