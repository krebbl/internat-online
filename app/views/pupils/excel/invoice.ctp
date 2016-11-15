<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel/Writer/Excel2007', array('file' => 'Excel2007.php'));

$boldStyle = array('font' => array('bold' => true));

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("Internat Meiningen")
    ->setLastModifiedBy("Internat Meiningen")
    ->setTitle("Rechnung")
    ->setSubject("Rechnung")
    ->setDescription("Rechnung fr...");
$row_counter = array();

$name = 'overview';
$sheet = $objPHPExcel->setActiveSheetIndex(0);
if ($sheet == null) {
    $sheet = $objPHPExcel->createSheet($name);
    $sheet->setTitle('Rechnung');

    $row_counter[$name] = 2;
    $row = 1;

    // TODO: add headers
}

$sheet->getColumnDimension("A")->setWidth(20);

$sheet->getCell("A1")->setValue("Internat der Meininger Berufsschulen");
$sheet->getCell("A2")->setValue("Am Drachenberg 4b, 98617 Meiningen");

$sheet->getCell("A5")->setValue("FIRMA NAME");
$sheet->getCell("A6")->setValue("FIRMA Straße");
$sheet->getCell("A7")->setValue("FIRMA Stadt");

$sheet->getCell("F10")->setValue("Meiningen, ");
$sheet->getCell("G10")->setValue(date("d.m.Y"));

$cell = $sheet->getCell("A11")->setValue("Rechnung");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCell("B11")->setValue($invoiceNr);

$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('alignment' => array('horizontal' => 'right'), 'font' => array('bold' => true)));

$cell = $sheet->getCell("C11")->setValue("-" . date("Y"));
$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('alignment' => array('horizontal' => 'left'), 'font' => array('bold' => true)));

$sheet->getCell("A13")->setValue("Internatsgebühren Ihrer Auszubildenden");
$sheet->getCell("A15")->setValue("Wir berechnen Ihnen für die Unterbringung Ihrer Auszubildenden im Internat wie folgt: ");

$startDate = date_parse($invoiceStart);
$endDate = date_parse($invoiceEnd);

$startTime = mktime(0, 0, 0, $startDate["month"], $startDate["day"], $startDate["year"]);
$endTime = mktime(0, 0, 0, $endDate["month"], $endDate["day"], $endDate["year"]);
if ($startTime > $endTime) {
    $t = $startTime;
    $startTime = $endTime;
    $endTime = $t;
}
$currentTime = $startTime;

function getBillData($bills, $cw, $type)
{
    foreach ($bills as $bill) {
        if ($bill['cw'] == $cw && $bill['type'] == $type) {
            return $bill;
        };
    }

    return null;
}

$startRow = 18;
$currentRow = $startRow;
$valueCol = 1;
foreach ($pupils as $k => $pupil) {
    $p = $pupil["Pupil"];
    $bills = $pupil["PupilBill"];
    $valueCol = 1;
    $currentTime = $startTime;
    for (; $currentTime <= $endTime; $valueCol++, $currentTime += (7 * 60 * 60 * 24)) {
        $year = date("Y", $currentTime);
        $cw = intval(date("W", $currentTime));
        $currentCw = sprintf('%02d', $cw);
        $shortYear = substr($year, 2);
        $cell = $sheet->getCellByColumnAndRow($valueCol, $startRow - 1)->setValue("{$currentCw}. KW {$shortYear}");
        $sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);
        
        $cwyear = $year . "-" . $currentCw;
        $food = getBillData($bills, $cwyear, "FOOD");
        $rent = getBillData($bills, $cwyear, "RENT");
        $value = 0;
        if($type === "BOTH" || $type === "FOOD") {
            $value += isset($food) ? $food['value'] : 0;
        }
        if($type === "BOTH" || $type === "RENT") {
            $value += isset($rent) ? $food['value'] : 0;
        }

        $cell = $sheet->getCellByColumnAndRow($valueCol, $currentRow);
        $cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
        $cell->setDataType("A")->setValue($value);
    }

    $sheet->getCellByColumnAndRow(0, $currentRow)->setValue("{$p['lastname']}, {$p['firstname']}");

    $currentRow++;
}

$cell = $sheet->getCellByColumnAndRow(0, $currentRow + 2)->setValue("Gesamtbetrag:");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCellByColumnAndRow(1, $currentRow + 2);
$cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat()->setFormatCode('#,##0.00_-[$€]');
$startCell = $sheet->getCellByColumnAndRow(1, $startRow);
$endCell = $sheet->getCellByColumnAndRow($valueCol - 1, $currentRow - 1);

$cell->setValue("=SUM({$startCell->getCoordinate()}:{$endCell->getCoordinate()})");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

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
$tmpFilename = TMP . "xlsx/rechnung.xlsx";
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