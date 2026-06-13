<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
include_once APPPATH."config/userConstants.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CSVModel extends CI_Model 
{

  function __construct () 
  {
    parent::__construct ();

  }

  function isCalcString ($line)
  {
    ini_set('display_errors', 0);     // do not display errors
    $end = substr ($line, -4);
    if ($end == ",,,,")
      return false;
    else
    {
      $pos = strpos ($line, ",");
      $num = (int) substr($line, 0, $pos);
      if ($num < 110) {
        return true;
      }
    }
    return false;
  }

  function hash4($txt)
  {
    ini_set('display_errors', 0);     // do not display errors
    $crc = 0x7FFF;
    $mask1 = 0x7FFF;
    $mask2 = 0xFFFF;

    for ($nC=1; $nC <= strlen ($txt); $nC++)
    {
      $j = ord(substr($txt, $nC-1));
      $crc = $crc ^ $j;
      for ($j=1; $j <= 8; $j++)
      {
        $mask = 0;
        if ($crc % 2 == 1)
          $mask = 0xA001;
        $crc = intval($crc / 2);
        $crc = $crc & $mask1;
        $crc = $crc ^ $mask;
      }
    }

    if ($crc < 0)
      $c = $crc & $mask2;
    else
      $c = $crc;

    $c = $c & $mask2;
    $out = sprintf ("%04x", $c);
    return $out;
  }

  function hash12($s)
  {
    ini_set('display_errors', 0);     // do not display errors
    $len = intdiv (strlen($s), 3);
    $s1 = substr($s, 0, $len);
    $s2 = substr($s, $len, $len);
    $s3 = substr($s, $len+$len);

    $output = $this->CSVModel->hash4($s1) . $this->CSVModel->hash4($s2) . $this->CSVModel->hash4($s3);

    return $output;
  }

  function calcCheckSum ($line)
  {
    ini_set('display_errors', 0);     // do not display errors
    $output = $this->CSVModel->hash12 ($line);
    return $output;
  }

  function getItem ($line, $n)
  {
    ini_set('display_errors', 0);     // do not display errors
    $posFront = -1;
    $posBack = strpos ($line, ",");
    for ($i = 0; $i < $n-1; $i++)
    {
      $posFront = $posBack;
      $posBack = strpos ($line, ",", $posFront+1);
    }
    return substr ($line, $posFront+1, $posBack-$posFront-1);
  }

  function validateChecksum ($uploadData, &$markSheet, &$errMsg)
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileName = $uploadData['file_name'];

    $markSheet['appNo'] = $_SESSION['appNo'];

    $source = UPLOAD_DIR . $_SESSION['appNo'] . "/" . $fileName;
    $myfile = fopen($source, "r") or die ("unable to open");

    $appNo = "";
    $courseNo = "";
    $courseTotal = "";
    $sum1 = "";
    $sum2 = "";
    $calcSum1 = 0;
    $calcSum2 = 0;
    $gradeTotal = 0;
    $checksum = "";

    $calcString = "";
    $counter = 0;
    $dataEnd = false;

    while (!$dataEnd && !feof($myfile)) 
    {
      $temp = fgets($myfile);
      $tt = rtrim($temp);
      $tt = trim($tt, "\"");
      $buffer = explode(",", $tt);
      if ($appNo == "")
      {
        $appNo = $buffer[1];
        $markSheet['name'] = $buffer[0];
        $markSheet['deg'] = $buffer[2];
        $markSheet['uni'] = $buffer[3];
        $markSheet['u985'] = $buffer[4];
        $markSheet['u211'] = $buffer[5];
        $markSheet['passing'] = $buffer[6];
        $markSheet['avgMarkByStudent'] = $buffer[7];
        $markSheet['calcDate'] = $buffer[8];
        $markSheet['key'] = $buffer[9];
      }
      else // get letter grade, sum1, sum2
      {
        $end = substr ($tt, -4);
        if ($end == ",,,,")  // last line with original checksum
        {
          $dataEnd = true;
          $calcString = $tt;
        }
        else // parse the course details
        {
          // buffer: year semester coursecode title creditunit mark gpa grade
          for ($i=0; $i<8; $i++)
          {
            $markSheet['row'][$counter][$i] = $buffer[$i];
          }
          
          $grade = $buffer[7];
          if ($grade != "")
            $gradeTotal += ord($grade);

          $c = $buffer[4];  // course credits
          $m = $buffer[5];  // score / mark
          $g = $buffer[6];  // gpa
          if ($m != "")
          {
            $s1 = doubleval($c) * doubleval($m);
            $calcSum1 += $s1;
          }
          if ($g != "")
          {
            $s2 = doubleval($c) * doubleval($g);
            $calcSum2 += $s2;
          }
          $counter++;
        }
      }
    }

    if ($dataEnd && !feof($myfile)) 
    {
      $tt = rtrim($calcString);
      $tt = trim($tt, "\"");
      $tt = rtrim($tt, ",");
      $checksum = $tt;
    }
    fclose ($myfile);

    $courseTotal = $counter;
    $markSheet['courseTotal'] = $courseTotal;

    // check sum
    $line = $appNo . "*" . $courseTotal . "*" . $calcSum1 . "*" . $calcSum2 . "*" . $gradeTotal;
    $newchecksum = strtoupper ($this->CSVModel->calcCheckSum ($line));

    if ($checksum != $newchecksum)    // checksum not match
    {
      $errMsg = "calculated checksum: ".$newchecksum." original checksum: ".$checksum." checksum not match. modified mark sheet will not be accepted. ";
      return -1;
    }
    else
    {
      $errMsg = '';
      return $courseTotal;
    }
  }

  function genMStxt ($markSheet)
  {
    ini_set('display_errors', 0);     // do not display errors
    $checksum = $this->genChecksum ($markSheet);
    //echo nl2br($checksum."\n");

    $appNo = $markSheet['appNo'];
    $name = $markSheet['name'];
    $deg = $markSheet['deg'];
    $uni = $markSheet['uni'];
    $u985 = $markSheet['u985'];
    $u211 = $markSheet['u211'];
    $passing = $markSheet['passing'];
    $avgMarkByStudent = $markSheet['avgMarkByStudent'];
    $key = $markSheet['key'];
    $calcDate = date ('Y-m-d');
    $courseTotal = $markSheet['courseTotal'];

    //Upload to the local server
    if (!is_dir(UPLOAD_DIR . $appNo)) 
    {
      mkdir('./'.UPLOAD_DIR . $appNo, 0777, true);    // create dir
    }
    $rawName = $appNo . '_' . $key;
    $tmpFile = UPLOAD_DIR . $appNo . "/" . $rawName . ".txt";
    $outfile = fopen ($tmpFile, "w");

    $line = '"' . $name . ',' . $appNo . ',' . $deg . ',' . $uni . ',' . $u985 . ',' . $u211 . ',' . $passing . ',' . $avgMarkByStudent . ',' . $calcDate . ',' . $key . ',,,,"' . "\n";
    fwrite ($outfile, $line);
    
    for ($i=0; $i<$courseTotal; $i++)
    {
      $line = '"';
      for ($j=0; $j<8; $j++)
      {
        $line = $line . $markSheet['row'][$i][$j] . ',';
      }
      $line = $line . '"' . "\n";
      fwrite ($outfile, $line);
    }
    $line = '"' . $checksum . ',,,,,,"' . "\n";
    fwrite ($outfile, $line);
    fclose ($outfile);

    $this->load->helper('download');
    force_download ($tmpFile, NULL);
  }

  function genChecksum ($markSheet)
  {
    ini_set('display_errors', 0);     // do not display errors
    $appNo = $markSheet['appNo'];
    $courseTotal = $markSheet['courseTotal'];

    $calcSum1 = 0;
    $calcSum2 = 0;
    $gradeTotal = 0;
    $checksum = "";

    // row: year, semester, course code, course title, credit unit, mark, gpa, grade
    for ($i=0; $i<$courseTotal; $i++)
    {
      $grade = $markSheet['row'][$i][7];
      if ($grade != "")
        $gradeTotal += ord($grade);

      $c = $markSheet['row'][$i][4];  // credit unit
      $m = $markSheet['row'][$i][5];  // mark
      $g = $markSheet['row'][$i][6];  // gpa
      if ($m != "")
      {
        $s1 = doubleval($c) * doubleval($m);
        $calcSum1 += $s1;
      }
      if ($g != "")
      {
        $s2 = doubleval($c) * doubleval($g);
        $calcSum2 += $s2;
      }
    }

    // check sum
    $line = $appNo . "*" . $courseTotal . "*" . $calcSum1 . "*" . $calcSum2 . "*" . $gradeTotal;
    $checksum = strtoupper ($this->CSVModel->calcCheckSum ($line));

    return $checksum;
  }

  function toExcel ($uploadData, $courseTotal)
  {
    ini_set('display_errors', 0);     // do not display errors
    $fileName = $uploadData['file_name'];
    $rawName = $uploadData['raw_name'];
    $origFile = UPLOAD_DIR . $_SESSION['appNo'] . "/".$rawName.".txt"; 
    $tmpFile = UPLOAD_DIR . $_SESSION['appNo'] . "/".$rawName."_tmp.txt";
    $outXlsxFile = UPLOAD_DIR . $_SESSION['appNo'] . "/".$rawName.".xlsx";
    $outPdfFile = UPLOAD_DIR . $_SESSION['appNo'] . "/".$rawName.".pdf";
    $template = MARKSHEET_TEMPLATE;

    $spreadsheetIN = new Spreadsheet();
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

    /* Set CSV parsing options */
    $reader->setDelimiter(',');
    $reader->setEnclosure('"');
    $reader->setSheetIndex(0);

    /* Load a CSV file and save as a XLS */
    $spreadsheetIN = $reader->load($tmpFile);
    $worksheetIN = $spreadsheetIN->getActiveSheet();

    // read csv to 2D array
    $dataArray = $worksheetIN->toArray();
    // print_r ($dataArray);

    $spreadsheetOUT = new Spreadsheet();
    $readerOUT = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheetOUT = $readerOUT->load($template);
    $worksheetOUT = $spreadsheetOUT->getActiveSheet();

    // write header data
    $worksheetOUT->setCellValue ('C2', $dataArray[0][0]);
    $worksheetOUT->setCellValue ('C3', $dataArray[0][1]);
    $worksheetOUT->setCellValue ('C4', $dataArray[0][2]);
    $worksheetOUT->setCellValue ('C5', $dataArray[0][3]);
    $worksheetOUT->setCellValue ('H4', $dataArray[0][4]);
    $worksheetOUT->setCellValue ('H5', $dataArray[0][5]);
    $worksheetOUT->setCellValue ('H2', $dataArray[0][6]);
    $worksheetOUT->setCellValue ('H3', $dataArray[0][7]);

    // write body data
    for ($i=0; $i<$courseTotal; $i++)
    {
      for ($j=0; $j<8; $j++)
      {
        $worksheetOUT->setCellValueByColumnAndRow ($j+2, $i+8, $dataArray[$i+1][$j]);
      }
    }
    $emptyRows = 114-$courseTotal-7;

    if ($emptyRows > 0)
    {
      $worksheetOUT->removeRow (8+$courseTotal, $emptyRows);

      // re-position formulae
      $offset1 = 114-(int)$emptyRows;
      $offset2 = 118-(int)$emptyRows;
      $offset3 = 120-(int)$emptyRows;
      $offset4 = 122-(int)$emptyRows;
      $offset5 = 124-(int)$emptyRows;
      $offset6 = 126-(int)$emptyRows;
      $offset7 = 128-(int)$emptyRows;
      $offset8 = 130-(int)$emptyRows;
      $offset9 = 133-(int)$emptyRows;
      $offset10 = 135-(int)$emptyRows;
      $offset11 = 137-(int)$emptyRows;

      $formula = "=counta(G8:G" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset2, $formula);
      $formula = "=sumif(J8:J" . (string) $offset1 . ', "<>0", F8:F' . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset3, $formula);
      $formula = "=sumif(K8:K" . (string) $offset1 . ', "<>0", F8:F' . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset4, $formula);
      // total mark
      $formula = "=sum(G8:G" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset5, $formula);
      $formula = "=sum(H8:H" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset6, $formula);
      $formula = "=sum(J8:J" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset7, $formula);
      $formula = "=sum(K8:K" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset8, $formula);

      $formula = "=if(F" . (string) $offset2 . ">0,F" . (string) $offset5 . "/F" . (string) $offset2 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset9, $formula);
      $formula = "=if(G" . (string) $offset4 . ">0,G" . (string) $offset8 . "/G" . (string) $offset4 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset10, $formula);
      $formula = "=if(F" . (string) $offset3 . ">0,F" . (string) $offset7 . "/F" . (string) $offset3 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset11, $formula);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheetOUT);
    $writer->save($outXlsxFile);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheetOUT);
    $writer->save($outPdfFile);
    
    unlink($tmpFile);   // remove $tmpFile
    unlink($origFile);  // remove original csv

    $spreadsheetIN->disconnectWorksheets();
    unset($spreadsheetIN);

    $spreadsheetOUT->disconnectWorksheets();
    unset($spreadsheetOUT);
  }

  function genMSexcel ($uploadData, $markSheet, &$avg, $checksumValid)
  {
    ini_set('display_errors', 0);     // do not display errors
    $courseTotal = $markSheet['courseTotal'];
    $appNo = $markSheet['appNo'];
    //Upload to the local server
    if (!is_dir(UPLOAD_DIR . $appNo)) 
    {
      mkdir('./'.UPLOAD_DIR . $appNo, 0777, true);    // create dir
    }
    $rawName = $uploadData['raw_name'];
    $outXlsxFile = UPLOAD_DIR . $appNo . "/".$rawName.".xlsx";
    $outPdfFile = UPLOAD_DIR . $appNo . "/".$rawName.".pdf";
    $template = MARKSHEET_TEMPLATE;

    $spreadsheetOUT = new Spreadsheet();
    $readerOUT = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheetOUT = $readerOUT->load($template);
    $worksheetOUT = $spreadsheetOUT->getActiveSheet();

    // write header data
    $worksheetOUT->mergeCells('A1:C1');
    if ($checksumValid == -1)
    {
      $worksheetOUT->mergeCells('D1:J1');
      $worksheetOUT->getStyle('D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
      $worksheetOUT->setCellValue ('D1', 'checksum error, applicant might have modified the mark sheet before upload');
    }
    $worksheetOUT->setCellValue ('C2', $markSheet['name']);
    $worksheetOUT->setCellValue ('C3', $markSheet['appNo']);
    $worksheetOUT->setCellValue ('C4', $markSheet['deg']);
    $worksheetOUT->setCellValue ('C5', $markSheet['uni']);
    $worksheetOUT->setCellValue ('H2', $markSheet['passing']);
    $worksheetOUT->setCellValue ('I3', $markSheet['avgMarkByStudent']);
    $worksheetOUT->setCellValue ('H4', $markSheet['calcDate']);
    $worksheetOUT->setCellValue ('H5', $markSheet['u985']);
    $worksheetOUT->setCellValue ('H6', $markSheet['u211']);

    // write body data start from row 9 in excel template
    $startExcelRow = 9;
    $endExcelRow = 115;
    for ($i=0; $i<$courseTotal; $i++)
    {
      for ($j=0; $j<8; $j++)
      {
        $worksheetOUT->setCellValueByColumnAndRow ($j+2, $i+$startExcelRow, $markSheet['row'][$i][$j]);
      }
    }
    $emptyRows = $endExcelRow-$courseTotal-($startExcelRow-1);

    if ($emptyRows > 0)
    {
      $worksheetOUT->removeRow ($startExcelRow+$courseTotal, $emptyRows);

      // re-position formulae
      // need to update when template changes
      $offset1 = 115-(int)$emptyRows;
      $offset2 = 119-(int)$emptyRows;
      $offset3 = 121-(int)$emptyRows;
      $offset4 = 123-(int)$emptyRows;
      $offset5 = 125-(int)$emptyRows;
      $offset6 = 127-(int)$emptyRows;
      $offset7 = 129-(int)$emptyRows;
      $offset8 = 131-(int)$emptyRows;
      $offset9 = 134-(int)$emptyRows;
      $offset10 = 136-(int)$emptyRows;
      $offset11 = 138-(int)$emptyRows;

      $formula = "=counta(G9:G" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset2, $formula);
      $formula = "=sumif(J9:J" . (string) $offset1 . ', "<>0", F9:F' . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset3, $formula);
      $formula = "=sumif(K9:K" . (string) $offset1 . ', "<>0", F9:F' . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset4, $formula);
      // total mark
      $formula = "=sum(G9:G" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset5, $formula);
      $formula = "=sum(H9:H" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset6, $formula);
      $formula = "=sum(J9:J" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset7, $formula);
      $formula = "=sum(K9:K" . (string) $offset1 . ")";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset8, $formula);

      $formula = "=if(F" . (string) $offset2 . ">0,F" . (string) $offset5 . "/F" . (string) $offset2 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset9, $formula);
      $avg = $worksheetOUT->getCellByColumnAndRow(6, (string) $offset9)->getCalculatedValue();

      $formula = "=if(G" . (string) $offset4 . ">0,G" . (string) $offset8 . "/G" . (string) $offset4 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (7, (string) $offset10, $formula);
      $formula = "=if(F" . (string) $offset3 . ">0,F" . (string) $offset7 . "/F" . (string) $offset3 . ",0)";
      $worksheetOUT->setCellValueByColumnAndRow (6, (string) $offset11, $formula);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheetOUT);
    $writer->save($outXlsxFile);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheetOUT);
    $writer->save($outPdfFile);
    
    //echo nl2br($outXlsxFile."\n\n");
    //echo nl2br($outPdfFile."\n\n");

    $spreadsheetOUT->disconnectWorksheets();
    unset($spreadsheetOUT);
  }

  function writeSQLlog($log)
  {
    ini_set('display_errors', 0);     // do not display errors
    if ($log['sqlDetails'] == FALSE )
    {
      $sqlText = '';
    }
    else
    {
      $sqlText = $this->db->last_query();
    }

    $sqlData = array(
  //      'userID'    => $_SESSION['userID'],
  //      'username'  => $_SESSION['username'],
      'username'  => 'testing',
      'sqlText'   => $sqlText,
      'oldData'   => $log['oldData'],
      'newData'   => $log['newData'],
      'sqlAction' => $log['sqlAction'],
    );

    $this->dblog->insert('sqllog', $sqlData); 
  }

}

?>
