<?php
App::import('Vendor', 'fpdf/fpdf'); 

class XFPDF extends FPDF{
	
	var $xheadertext  = 'PDF created using CakePHP and TCPDF'; 
    var $xheadercolor = array(255,255,255); 
    var $xfootertext  = 'Copyright © %d XXXXXXXXXXX. All rights reserved.'; 
    var $xfooterfontsize = 8 ; 
	var $labelCellHeight = 3.0;
	var $labelTextHeight = 6.0;
	var $valueCellHeight = 5.0;
	var $valueTextHeight = 10.0;
	var $cellSpacing = 2.0;
	var $x;
	
	function NewRow(){
		$this->Ln();
		$this->SetXY($this->GetX(),$this->GetY() + ($this->labelCellHeight / 2) + $this->valueCellHeight);
	}
	
	function Field($width, $label, $value, $lalign = 'L', $valign = 'L'){
		$this->SetFont('Arial','',$this->labelTextHeight); 
		$this->Cell($width,$this->labelCellHeight,utf8_decode($label),'LR',0,$lalign,false);
		$this->SetXY($this->GetX() - $width, $this->GetY() + $this->labelCellHeight);
		
		$this->SetFont('Arial','',$this->valueTextHeight); 
		$this->Cell($width,$this->valueCellHeight,utf8_decode($value),'LRB',0,$valign,false);
		$this->SetXY($this->GetX(), $this->GetY() - $this->labelCellHeight);
	}
	
	function SimpleField($width, $label, $value, $lalign = 'L'){
		$this->Field($width, $label, $value, $lalign = 'L');
		$this->GoToNextCell();
	} 
	
	function NumberField($numbers, $label = NULL, $numWidth = 10){
		$width = count($numbers)*$numWidth;
		if($label != NULL){
			$this->SetXY($this->GetX(), $this->GetY() - $this->labelCellHeight);
			$this->SetFont('Arial','',$this->labelTextHeight); 
			$this->Cell($width,$this->labelCellHeight,utf8_decode($label),'',0,'C',false);
			
			$this->SetXY($this->GetX() - $width, $this->GetY() + $this->labelCellHeight);
		}
		foreach($numbers as $nlabel => $value){
			if(is_string($nlabel)){
				$this->Field($numWidth, $nlabel, $value, 'C', 'C');
			}else{
				$this->Field($numWidth, '', $value, 'C', 'C');
			}
		}
		$this->GoToNextCell();
	}
	
	function DateField($date, $label){
		$n = explode("-",$date);
		$a = array('Tag' => $n[2],'Monat' => $n[1], 'Jahr' => $n[0]);
		$this->NumberField($a,$label);
	}
	
	function SignField($width,$label){
		$this->SetFont('Arial','',$this->valueTextHeight); 
		$this->Cell($width,$this->valueCellHeight,'','B',0,'C',false);
		$this->SetXY($this->GetX() - $width, $this->GetY() + $this->valueCellHeight);
		
		$this->SetFont('Arial','',$this->labelTextHeight); 
		$this->Cell($width,$this->labelCellHeight,utf8_decode($label),0,0,'C',false);
		$this->SetXY($this->GetX(), $this->GetY() - $this->valueCellHeight);
		
		$this->GoToNextCell();
	}
	
	function GoToNextCell(){
		$x = $this->GetX();
		$x += $this->cellSpacing;
		$this->SetX($x);
	}
	
	function Address($address){	
		$this->SimpleField(134, 'Straße, PLZ, Ort', trim($address['street']).', '.$address['zipcode'].' '.$address['city']);
		$this->SimpleField(40, 'Telefonnummer', $address['home_nr']);
	}
	
	function smallHeading($text,$n = 0){
		if($n > 0){
			$this->SetFont('Arial','B',8);
			$this->SetLineWidth(0.5); 
			$this->Cell(5,5,utf8_decode($n),'TLRB',0, 'C');
			$this->SetLineWidth(0.1);
		}
		$this->SetFont('Arial','B',9);
		$this->Text($this->GetX()+1.5,$this->getY()+3.5,utf8_decode($text));
		$this->Ln();
		$this->SetXY($this->GetX(), $this->getY()+1.5);
	}

}
?>