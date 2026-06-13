<?php
  
require 'vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

	for ($nC=1; $nC <= strlen ($txt); $nC++)
	{
		$j = ord(substr($txt, $nC-1));
		$crc = $crc ^ $j;
		for ($j=1; $j <= 8; $j++)
		{
			$mask = 0;
			if ($crc % 2 == 1)
				$mask = 0xA001;
			$crc = $crc / 2;
			$crc = $crc & 0x7FFF;
			$crc = $crc ^ $mask;
		}
	}

	if ($crc < 0)
		$c = $crc & 0xFFFF;
	else
		$c = $crc;

	$c = $c & 0xFFFF;
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

	$output = hash4($s1) . hash4($s2) . hash4($s3);

	return $output;
}

function checkSum ($line)
{
	ini_set('display_errors', 0);     // do not display errors
	$output = hash12 ($line);
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

if ($argc < 2 )
{
    exit( "Usage: php csv2excel.php <filename>\n" );
}

$myfile = fopen($argv[1] . ".csv", "r") or die ("unable to open");
$outfile = fopen("tt.csv", "w");

$appNo = "";
$courseNo = "";
$courseTotal = "";
$sum1 = "";
$sum2 = "";
$gradeTotal = 0;
$checksum = "";

$calcString = "";
$counter = 0;
$dataEnd = false;

while (!$dataEnd && !feof($myfile)) {
	$temp = fgets($myfile);
	$tt = rtrim($temp);
	$tt = trim($tt, "\"");
	if ($appNo == "")
	{
		$pos = strpos($tt, ",");
		$appNo = substr($tt, $pos+1, 10);
	}
	else // get letter grade
	{
		if (isCalcString($tt))
		{
			$calcString = $tt;
			$dataEnd = true;
		}
		else // get letter grade
		{
			$grade = getItem ($tt, 8);
			if ($grade != "")
				$gradeTotal += ord($grade);
		}
	}
	if (!$dataEnd)

	{
		$tt = $tt . "\n";
		fwrite($outfile, $tt);
		$counter++;
	}
}

if ($dataEnd && !feof($myfile)) {
	$temp = fgets($myfile);
	$tt = rtrim($temp);
	$tt = trim($tt, "\"");
	$tt = rtrim($tt, ",");
	$checksum = $tt;
}

fclose ($myfile);
fclose($outfile);

$courseNo = getItem ($calcString, 1);
$courseTotal = $counter - 1;
$sum1 = getItem ($calcString, 6);
$sum2 = getItem ($calcString, 7);

// check sum
$line = $appNo . "*" . $courseNo . "*" . $courseTotal . "*" . $sum1 . "*" . $sum2 . "*" . $gradeTotal;

//echo $line . "\n";

$newchecksum = strtoupper (checkSum ($line));

if ($checksum != $newchecksum)
{
//	echo $newchecksum . "\n";
	echo "problem with checksum\n";
}
else
{
	$spreadsheetIN = new Spreadsheet();
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

	/* Set CSV parsing options */
	$reader->setDelimiter(',');
	$reader->setEnclosure('"');
	$reader->setSheetIndex(0);

	/* Load a CSV file and save as a XLS */
	$spreadsheetIN = $reader->load("tt.csv");
	$worksheetIN = $spreadsheetIN->getActiveSheet();

	// read csv to 2D array
	$dataArray = $worksheetIN->toArray();
	// print_r ($dataArray);

	$spreadsheetOUT = new Spreadsheet();
	$readerOUT = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$spreadsheetOUT = $readerOUT->load("templateTesting.xlsx");
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
	$writer->save($argv[1] . ".xlsx");

	$spreadsheetIN->disconnectWorksheets();
	unset($spreadsheetIN);

	$spreadsheetOUT->disconnectWorksheets();
	unset($spreadsheetOUT);

}

?>