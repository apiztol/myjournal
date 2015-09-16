<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition:attachment;filename="Journal_List_Classification.xls"');
header('Cache-Control: max-age=0');

/** Include path **/
require_once 'CSV/Classes/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'CSV/Classes/PHPExcel/Writer/Excel5.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("UM");
$objPHPExcel->getProperties()->setTitle("e-PUBLICATION UM");
$objPHPExcel->getProperties()->setSubject("Journal List With Classification");

$i = 11;
$O = 12;
$index = 0;
$i++;

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');

$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Journal Detail');
$objPHPExcel->getActiveSheet()->getStyle("B2:B2")->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Title:');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Dicipline:');
$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Publisher:');
$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Year Evaluate:');
$objPHPExcel->getActiveSheet()->SetCellValue('B8', 'Form:');
$objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Score:');
$objPHPExcel->getActiveSheet()->SetCellValue('B10', 'Level:');

$objPHPExcel->getActiveSheet()->SetCellValue('C4', $journal['journal_name']);
$objPHPExcel->getActiveSheet()->SetCellValue('C5', $disciplineTitle);
$objPHPExcel->getActiveSheet()->SetCellValue('C6', $journal['publisher']);
$objPHPExcel->getActiveSheet()->SetCellValue('C7', $journal['year']);
$objPHPExcel->getActiveSheet()->SetCellValue('C8', $_GET['f']);
$objPHPExcel->getActiveSheet()->SetCellValue('C9', $journal['totalMarks'] . ' / ' . $fullMarks . ' (' . round(($journal['totalMarks'] / $fullMarks) * 100, 2) . '%)');
$objPHPExcel->getActiveSheet()->SetCellValue('C10', '-');


$objPHPExcel->getActiveSheet()->SetCellValue('B12', '');
$objPHPExcel->getActiveSheet()->SetCellValue('C12', 'Criteria');
$objPHPExcel->getActiveSheet()->SetCellValue('D12', 'Choice');
$objPHPExcel->getActiveSheet()->SetCellValue('E12', 'Score');
$objPHPExcel->getActiveSheet()->SetCellValue('F12', 'Remarks');


$x = 0 ;
$scores = [];
$i++;
foreach ($journal['resultList'] as $row):
	$i++;
	$x++;
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $x);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row['criteria_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row['choice_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row['marks']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row['remarks']);

	array_push($scores, [ 'value' => ($row['marks'] / $fullMarks * 100)]);
	
endforeach;

$scores = array_reverse($scores); // reverse array to show criteria 1 start from top when in graph

$objPHPExcel->getActiveSheet()->getStyle("B12:F12")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B4:B10")->getFont()->setBold(true);



/*csv border style*/
$styleArray = array(
   'borders' => array(
     'allborders' => array(
       'style' => PHPExcel_Style_Border::BORDER_THIN
     )
   )
);

foreach(range('B','E') as $columnID) {
$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
         ->setAutoSize(true);
}

$objPHPExcel->getActiveSheet()->getStyle("B$O:F".$i)->applyFromArray($styleArray);
unset($styleArray);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

$objWriter->save('php://output');


?>
