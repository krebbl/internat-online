<?php
	App::import('Vendor', 'xfpdf'); 
	
	$pdf=new XFPDF();
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'Hallo Welt!');
	$pdf->Output('test.pdf','D');
?>