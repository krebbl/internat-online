<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel/Writer/Excel2007', array('file' => 'Excel2007.php'));


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("Internat Meiningen")
    ->setLastModifiedBy("Internat Meiningen")
    ->setTitle("test")
    ->setSubject("test")
    ->setDescription("test fu das Jahr ...");
$row_counter = array();

$name = 'overview';
$sheet = $objPHPExcel->setActiveSheetIndex(0);
if ($sheet == null) {
    $sheet = $objPHPExcel->createSheet($name);
    $sheet->setTitle('Schülerübersicht');

    $row_counter[$name] = 2;
    $row = 1;

    // TODO: add headers
}
$row = 1;

$headers = array(
    "room" => "Raum",
    "school_class" => "Ausbildungsrichtung",
    "lastname" => "Nachname",
    "firstname" => "Vorname",
    "food_on_account" => "Essen auf Rechnung",
    "rent_on_account" => "Miete auf Rechnung",
    'permanent' => "Dauerbeleger",
    "gender" => "Geschlecht",
    "birthdate" => "Geburtstag",
    "is_adult" => "Über 18",
    "min_to_arrive" => "Hinfahrt (min)",
    "min_to_depart" => "Rückfahrt (min)",
    "zipcode" => "PLZ",
    "city" => "Ort",
    "school_name" => "Schule",
    "company_name" => "Firma",
    "deposit_block" => "Kautionsblock",
    "deposit_nr" => "Belegnr.",
    "deposit_paid_in" => "Eingezahlt",
    "deposit_paid_out" => "Ausgezahlt",
);

$time = time() - 7 * 24 * 60 * 60 * 51;
$currentCw = date("Y-oW", time());
$cws = array();

for ($i = 0; $i < 52; $i++) {
    $cwYear = date("o-W", $time);
    $cw = date("W", $time);
    $y = date("y",$time);
    $headers['RENT-' . $cwYear] = 'M ' . $cw . '.KW' . ' '.$y;
    $time += 7 * 24 * 60 * 60;
    $cws[] = $cwYear;
}
$time = time() - 7 * 24 * 60 * 60 * 51;
for ($i = 0; $i < 52; $i++) {
    $cwYear = date("o-W", $time);
    $cw = date("W", $time);
    $y = date("y", $time);
    $headers['FOOD-' . $cwYear] = 'E ' . $cw . '.KW' . ' ' . $y;
    $time += 7 * 24 * 60 * 60;
}

$col = 0;
foreach ($headers as $header) {
    $cell = $sheet->getCellByColumnAndRow($col, $row);
    $cell->setValue($header);
    $col++;
};
$col = 0;
$row = 2;
$cell = $sheet->getCellByColumnAndRow($col, $row);

function getBillData($bills, $cw, $type)
{

    foreach ($bills as $bill) {
        if ($bill['cw'] == $cw && $bill['type'] == $type) {
            return $bill;
        };
    }

    return null;
}
// $cell->setValue(count($pupils));

foreach ($pupils as $pupil) {
    //$row = $row_counter[$name]+1;
    $col = 0;
    $cols = array(
        $pupil['Pupil']['room'],
        $pupil['SchoolClassType']['abbreviation'] . " " . substr($pupil[0]['start'], 2),
        $pupil['Pupil']['lastname'],
        $pupil['Pupil']['firstname'],
        ($pupil['Pupil']['food_on_account'] == 1) ? 'HP' : ($pupil['Pupil']['food_on_account'] == 2 ? 'VP' : ''),
        ($pupil['Pupil']['rent_on_account'] == 1) ? 'X' : '',
        $pupil['Pupil']['permanent'] ? "X" : "",
        ($pupil['Pupil']['male'] == 1) ? 'M' : 'W',
        $pupil['Pupil']['birthdate'],
        ($pupil[0]['is_adult'] == 1) ? 'JA' : 'NEIN',
        $pupil['Pupil']['min_to_arrive'],
        $pupil['Pupil']['min_to_depart'],
        $pupil['Address']['zipcode'],
        $pupil['Address']['city'],
        $pupil['School']['name'],
        $pupil['Company']['name'],
        $pupil['Deposit']['block'],
        $pupil['Deposit']['nr'],
        $pupil['Deposit']['paid_in'],
        $pupil['Deposit']['paid_out'],
    );

    foreach ($cols as $val) {
        $cell = $sheet->getCellByColumnAndRow($col, $row);
        $cell->setValue($val);
        $col++;
    }


    foreach ($cws as $cw) {
        $cell = $sheet->getCellByColumnAndRow($col, $row);
        $bill = getBillData($pupil['PupilBill'], $cw, "RENT");
        $cell->setValue($bill['value']);
        $col++;
    }

    foreach ($cws as $cw) {
        $cell = $sheet->getCellByColumnAndRow($col, $row);
        $bill = getBillData($pupil['PupilBill'], $cw, "FOOD");
        $cell->setValue($bill['value']);
        $col++;
    }

    // $cell->setValue(count($pupil['Pupil']));
    $row++;
}

// $objPHPExcel->removeSheetByIndex(0);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
/*
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=File.xls");
header("Content-Transfer-Encoding: binary ");
*/
$tmpFilename = TMP . "xlsx/overview.xlsx";
//$tmpFilename = dirname(__FILE__)."/tmp/test.xlsx";
$objWriter->save($tmpFilename);
/*
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="test.xlsx"');
header('Cache-Control: max-age=0');
*/
// $objWriter->save('php://output');

readfile($tmpFilename, false, NULL);
unlink($tmpFilename);
// return $contents;
?>