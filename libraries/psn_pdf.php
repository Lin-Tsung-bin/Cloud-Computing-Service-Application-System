<?php
require_once(COMMONS_PATH.'/libraries/pdf_lib/tcpdf_v6.2.8/tcpdf.php');
require_once(COMMONS_PATH.'/libraries/pdf_lib/fpdi.php');
//require_once(COMMONS_PATH.'/libraries/pdf_lib/FPDI_Protection.php');

class Psn_pdf extends FPDI {
	 
	var $_tplIdx;
	var $lang = "cn";
	function Header() {
          
	}

	function Footer() {
		 // 浮水印
		$this->SetAlpha(0.2);
		$this->Image('images/nckulogo2011-2.jpg', 50, 80, 120, 120, '', '', '', true, 600);

		//設定顯示位置
		$this->SetY(-15);
		$this->SetX(50);
		$this->setBarcode(date('Y-m-d H:i:s'));
		// Set font
		$this->SetFont('kaiu', '', 10);
		// 頁碼
		$this->Cell(0, 20, "第 ".$this->getAliasNumPage().'頁，共 '.$this->getAliasNbPages()."頁", 0, false, 'C', 0, '', 0, false, 'T', 'M');

		
	}

	private function en_font($size = 10){
		$this->SetFont('helvetica', '', $size, '', true);
	}
	 
	private function cn_font($size = 12){
		$this->SetFont('kaiu', '', $size, '', true);
	}

	
	 //left?
	public function mcell($w, $h, $x, $y, $val, $lan="cn"){
		if($lan == "cn"){
			$this->cn_font();
			$this->MultiCell(  $w, $h, $val, 1, 'L', 1, 0, $x, $y, true, 0, false, true, $h, 'M');
		}else if($lan == "en"){
			$this->en_font();
			$this->MultiCell(  $w, $h, $val, 0, 'L', 1, 0, $x, $y, true, 0, false, true, $h, 'M');
			$this->cn_font();
		}
	}
    //center
	public function ccell($w, $h, $x, $y, $val, $lan="cn"){
		if($lan == "cn"){
			$this->cn_font();
			$this->MultiCell(  $w, $h, $val, 0, 'C', 1, 0, $x, $y, true, 0, false, true, $h, 'M');
		}else if($lan == "en"){
			$this->en_font();
			$this->MultiCell(  $w, $h, $val, 0, 'C', 1, 0, $x, $y, true, 0, false, true, $h, 'M');
			$this->cn_font();
		}
	}
	 
	
	 
	 
	public function generate_pdf($user, $path, $type="D"){
		$this->AddPage();
		
        // $this->SetFont('kaiu', '', 12, '', true);
           
           
		$this->setSourceFile('views/ex34/psn.pdf');
		$tplIdx = $this->importPage(1);
		$this->useTemplate($tplIdx);
        $this->SetFillColor(255, 255, 255);
        $this->ccell(  37, 14,  16, 52, $user['dept_abbr']);
        $this->ccell(  37, 14,  53, 52, $user['pos_name']);
        $this->ccell(  40, 14,  90, 52, $user['psn_name']);
        $this->ccell(  67, 14,  130, 52, $user['eng_name']);
        $this->ccell(  36, 7,  135, 68, $user['idno']);
       
        
        $this->ccell(  37, 34,  16, 122, $user['psn_code']);
        
        $this->ccell(  37, 34,  53, 122, $user['begin_date']);

		

		
		        
		$this->Output($path  , $type);

	}

}




?>
