<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'PHPExcel/Writer/Excel2007', array('file' => 'Excel2007.php'));

$boldStyle = array('font' => array('bold' => true));
$cwStyle = array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$borderStyle = array('borders' => array(
    'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
    )
));

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
$sheet->getDefaultStyle()->applyFromArray(array('font' => array('name' => 'Calibri')));
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

if(isset($address)) {
    $contact = $address['Address']['contact'];
    if(!isset($contact)) {
        $contact = $address['Company']['name'];
    }
    $sheet->getCell("A5")->setValue($contact);
    $sheet->getCell("A6")->setValue($address['Address']['street']);
    $sheet->getCell("A7")->setValue($address['Address']['zipcode'] . " " . $address['Address']['city']);
}

$sheet->getCell("G10")->setValue("Meiningen, " . date("d.m.Y"));
$sheet->getStyle("G10")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));

$cell = $sheet->getCell("A12")->setValue("Rechnung");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCell("B12")->setValue($invoiceNr);

$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('alignment' => array('horizontal' => 'right'), 'font' => array('bold' => true)));

$cell = $sheet->getCell("C12")->setValue("-" . date("Y"));
$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('alignment' => array('horizontal' => 'left'), 'font' => array('bold' => true)));

$sheet->getCell("A14")->setValue("Internatsgebühren Ihrer Auszubildenden");
$sheet->getCell("A16")->setValue("Wir berechnen Ihnen für die Unterbringung Ihrer Auszubildenden im Internat wie folgt: ");

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

$startRow = 19;
$currentRow = $startRow;
$valueCol = 1;

$invoiceCols = array();

$currentTime = $startTime;
for (; $currentTime <= $endTime; $valueCol++, $currentTime += (7 * 60 * 60 * 24)) {
    $sum = 0;
    $invoiceCol = array();
    $currentRow = $startRow;
    foreach ($pupils as $k => $pupil) {
        $p = $pupil["Pupil"];
        $bills = $pupil["PupilBill"];
        $valueCol = 1;

        $year = date("Y", $currentTime);
        $cw = intval(date("W", $currentTime));
        $currentCw = sprintf('%02d', $cw);
        $shortYear = substr($year, 2);
        $invoiceCol[0] = "{$currentCw}. KW {$shortYear}";

        $cwyear = $year . "-" . $currentCw;
        $food = getBillData($bills, $cwyear, "FOOD");
        $rent = getBillData($bills, $cwyear, "RENT");
        $value = 0;
        if($type === "BOTH" || $type === "FOOD") {
            $value += isset($food) ? $food['value'] : 0;
        }
        if($type === "BOTH" || $type === "RENT") {
            $value += isset($rent) ? $rent['value'] : 0;
        }

        $sum += $value;
        $invoiceCol[$currentRow - $startRow + 1] = $value;
        $cell = $sheet->getCellByColumnAndRow(0, $currentRow);
        $cell->setValue("{$p['lastname']}, {$p['firstname']}");
        $style = $cell->getParent()->getStyle($cell->getCoordinate());
        $style->applyFromArray($borderStyle);
        $currentRow++;
    }

    if($sum > 0) {
        $invoiceCols[] = $invoiceCol;
    }
}

$style = $cell->getParent()->getStyleByColumnAndRow(0,$startRow-1);
$style->applyFromArray($borderStyle);

foreach($invoiceCols as $colIndex => $invoiceCol) {
    if($invoiceCol !== 0) {
        foreach ($invoiceCol as $rowIndex => $value) {
            if($rowIndex > 0) {
                $cell = $sheet->getCellByColumnAndRow($colIndex + 1, $startRow + $rowIndex - 1);
                $style = $cell->getParent()->getStyle($cell->getCoordinate());
                $style->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
                $cell->setDataType("A")->setValue($value);

            } else {
                $cell = $sheet->getCellByColumnAndRow($colIndex + 1, $startRow - 1)->setValue($value);
                $style = $sheet->getStyle($cell->getCoordinate());
                $style->applyFromArray($cwStyle);
                $sheet->getColumnDimensionByColumn($colIndex + 1)->setWidth(10);
            }
            $style->applyFromArray($borderStyle);
        }
    }
    $valueCol = $colIndex + 1;
}

$cell = $sheet->getCellByColumnAndRow(0, $currentRow + 2)->setValue("Gesamtbetrag:");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCellByColumnAndRow(1, $currentRow + 2);
$cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat()->setFormatCode('#,##0.00_-[$€]');
$startCell = $sheet->getCellByColumnAndRow(1, $startRow);
$endCell = $sheet->getCellByColumnAndRow($valueCol, $currentRow - 1);

$cell->setValue("=SUM({$startCell->getCoordinate()}:{$endCell->getCoordinate()})");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCellByColumnAndRow(0, $currentRow + 4)->setValue("Zahlbar: sofort");
$sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

$cell = $sheet->getCellByColumnAndRow(0, $currentRow + 6)->setValue("Bitte überweisen Sie den o. g. Betrag auf folgendes Konto:");

$bankData = array(
    'Bankinstitut' => 'Rhön-Rennsteig-Sparkasse Meiningen',
    'IBAN' => 'DE12840500001305004635',
    'BIC' => 'HELADEF1RRS',
    'Zahlungsgrund' => '24001 11010',
    'Kontoinhaber' => 'Landratsamt Schmalkalden Meiningen'
    );

$currentRow = $currentRow + 8;
foreach ($bankData as $label => $value) {
    $cell = $sheet->getCellByColumnAndRow(0, $currentRow)->setValue($label . ":");
    $sheet->getStyle($cell->getCoordinate())->applyFromArray($boldStyle);

    $cell = $sheet->getCellByColumnAndRow(1, $currentRow)->setValue($value);
    $currentRow++;
}

$currentRow += 4;

$cell = $sheet->getCellByColumnAndRow(0, $currentRow)->setValue("A. Krejpowicz");
$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

$currentRow++;
$cell = $sheet->getCellByColumnAndRow(0, $currentRow)->setValue("Internatsleiter");
$sheet->getStyle($cell->getCoordinate())->applyFromArray(array('font' => array('size' => 8), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

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