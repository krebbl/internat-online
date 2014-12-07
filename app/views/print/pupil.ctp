<?php 
	 App::import('Vendor', 'xfpdf'); 

	$pdf = new XFPDF();
	$pdf->AddPage();
	$pdf->SetTopMargin(30); 
	$pdf->SetLeftMargin(20);
    
	
	$pdf->SetFont('Arial','B',7);
	$pdf->Text($pdf->GetX(),$pdf->getY()+10,utf8_decode('Drachenberg 4, 98617 Meiningen'));
	
	
	
    $pdf->SetFont('Arial','B',14);
	$pdf->Text($pdf->GetX(),$pdf->getY()+17,utf8_decode('Anmeldung für das Internat der Meininger Berufsschulen'));
	
	
	
	$pdf->SetFont('Arial','',10);
	if(empty($pupil)){
		$pdf->Text($pdf->GetX(),$pdf->GetY()+24,utf8_decode('Bitte in Blockschrift ausfüllen und 2 (zwei!) Passbilder beifügen bzw. nachreichen!'));
	}else{
		$pdf->Text($pdf->GetX(),$pdf->GetY()+24,utf8_decode('Bitte 2 (zwei!) Passbilder beifügen bzw. nachreichen!'));
	}
	
	$pdf->NewRow();
	$pdf->NewRow();
	$pdf->NewRow();
	$pdf->NewRow();
	$pdf->NewRow();
	
	$pdf->Ln();
	$pdf->smallHeading('Angaben zur Person und Adresse:',1);
	 
	 
	 
	$pdf->SimpleField(92, 'Name', $pupil['Pupil']['lastname']);
	$pdf->SimpleField(82, 'Vorname', $pupil['Pupil']['firstname']);
	
	$pdf->NewRow();
	
	$birthdate = explode("-", $pupil['Pupil']['birthdate']);
	
    $pdf->NumberField(
		array(
			'Tag' => $birthdate[2],
			'Monat' => $birthdate[1], 
			'Jahr' => $birthdate[0] ),'Geburtsdatum');
			
	$pdf->SimpleField(60, 'Geburtsort', $pupil['Pupil']['birthplace']);
	$pdf->SimpleField(40, 'Nationalität', $pupil['Nationality']['name']);
	$pdf->SimpleField(40, 'Geschlecht', ($pupil['Pupil']['male']?'männlich':'weiblich'));
	
	$pdf->NewRow();
	
	$pdf->Address($pupil['Address']);
	
	$pdf->NewRow();
	
	$pdf->SimpleField(92, 'Landkreis', $pupil['County']['name']);
	$pdf->SimpleField(82, 'Bundesland', $pupil['County']['State']['name']); 
	
	$pdf->NewRow();
	$pdf->smallHeading('Angaben zu den gesetzlichen Vertretern:',2);
	
	foreach($pupil['PupilParent'] as $pp){
		if(empty($pp['address'])){
			$pdf->SimpleField(70, 'Name', $pp['lastname']);
			$pdf->SimpleField(70, 'Vorname', $pp['firstname']);
			$pdf->SimpleField(32, 'Adresse', 'siehe oben');
		}else{
			$pdf->SimpleField(92, 'Name', $pp['lastname']);
			$pdf->SimpleField(82, 'Vorname', $pp['firstname']);
			$pdf->NewRow();
			$pdf->Address($pp['address']);
		}
		$pdf->NewRow();
	}
	
	$pdf->smallHeading('Angaben zur Ausbildung:',3);
	
	$pdf->SimpleField(92, 'Schule', $pupil['School']['name']); 
	$pdf->SimpleField(82, 'Ausbildungsrichtung (Abkürzung)', $pupil['SchoolClass']['SchoolClassType']['abbreviation']." ".substr($pupil['SchoolClass']['SchoolSemester']['start_date'], 2,2));
	
	$pdf->NewRow();
	
	
	$pdf->SimpleField(176, 'Firma', $pupil['Company']['name']); 
	
	$pdf->NewRow();
	if(!empty($pupil['Company']['address'])){
		$pdf->Address($pupil['Company']['address']); 
		$pdf->NewRow();
	}
	
	$pdf->smallHeading('Angaben zur Internatsnutzung:',4);
	
	$pdf->SimpleField(60, 'Belegungstyp', ($pupil['Pupil']['permanent'])?'Dauerbelegung':'Turnusbelegung');
	$pdf->DateField($pupil['Pupil']['arrival_day'],'Anreise am' );
	
	$pdf->NewRow();
	// $pdf->SimpleField(60, 'Dauer der Hinfahrt (Min)', @$pupil['Pupil']['time_to_arrive']);
	// $pdf->SimpleField(62, 'Dauer der Rueckfahrt (Min)', @$pupil['Pupil']['time_to_depart']);
	
	$pdf->NewRow();
	
	$pdf->Cell(180, 5, utf8_decode('Die/Der Unterzeichner bestätigen die Richtigkeit der o.g. persönlichen Angaben und'),0,1,'L');
	$pdf->Cell(180, 5, utf8_decode('erkennen die Internatsvereinbarung und Hausordnung in vollem Umfang an.'),0,1,'L');
	
	$pdf->NewRow();
	
	
	$pdf->Cell(180, 5, utf8_decode('Sollten Punkte der Internatsvereinbarung und/oder der Hausordnung unwirksam werden,'),0,1,'L');
	$pdf->Cell(180, 5, utf8_decode('berührt dies die Wirksamkeit der übrigen Punkte nicht.'),0,1,'L');
	
	$pdf->NewRow();
	
	$pdf->SimpleField(60, 'Ort', '  ');
	$pdf->SimpleField(40, 'Datum', '  ');
	
	$pdf->NewRow();
	$pdf->Ln();
	$pdf->NewRow();
	
	$pdf->SignField(60,'Unterschrift des Auszubildenden');	
	$pdf->SignField(50,'Unterschrift des Gesetzlichen Vertreters 1');
	$pdf->SignField(50,'Unterschrift des Gesetzlichen Vertreters 2');
	
	
	
    $pdf->Output($pupil['Pupil']['lastname'].'_'.$pupil['Pupil']['firstname'].'.pdf','D');
?>