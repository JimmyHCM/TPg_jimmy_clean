<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/libraries/tcpdf/tcpdf.php";

class Pdf extends TCPDF
{
	function __construct()
	{
		parent::__construct();
	}

	//Page header
	public function Header() 
	{
	  // Logo
		$image_file = APPPATH.'../assets/images/facultyLetterHead153.png';
		if ($this->PageNo() == 1)
			$this->Image($image_file, 28, '', '', 33, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}

	// Page footer
	public function Footer() 
	{
		// ENGG
		$image_file = APPPATH.'../assets/images/facultyLetterFooter153.png';
		if ($this->PageNo() == 1)
			$this->Image($image_file, 17, 269, '', 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
}

?>

