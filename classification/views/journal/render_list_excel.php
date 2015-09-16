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

foreach($forms as $form_): 
endforeach; 

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("UM");
$objPHPExcel->getProperties()->setTitle("e-PUBLICATION UM");
$objPHPExcel->getProperties()->setSubject("Journal List With Classification");

$i = 12;
$O = 10;
$index = 0;

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:C3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D10:G10');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B10:B11');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C10:C11');

$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Journal With Classification');
$objPHPExcel->getActiveSheet()->getStyle("B2:B2")->getFont()->setBold(true);

/*FILTER FIELD*/

$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Year:');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Dicipline:');
$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Form Category:');
$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Full Mark:');

$objPHPExcel->getActiveSheet()->SetCellValue('C4', $_GET['y']);
$objPHPExcel->getActiveSheet()->SetCellValue('C5', $_GET['d']);
$objPHPExcel->getActiveSheet()->SetCellValue('C6', $_GET['f']);
$objPHPExcel->getActiveSheet()->SetCellValue('C7', $fullMarks);

if($_GET['s'] != ""){
	$objPHPExcel->getActiveSheet()->SetCellValue('B8', 'Search:');
	$objPHPExcel->getActiveSheet()->SetCellValue('C8', $_GET['s']);
}

$objPHPExcel->getActiveSheet()->SetCellValue('B10', 'No.');
$objPHPExcel->getActiveSheet()->SetCellValue('C10', 'Journal Title');
$objPHPExcel->getActiveSheet()->SetCellValue('D10', 'Score');

$objPHPExcel->getActiveSheet()->SetCellValue('D11', 'Wajib');
$objPHPExcel->getActiveSheet()->SetCellValue('E11', 'Optional');
$objPHPExcel->getActiveSheet()->SetCellValue('F11', 'Total');
$objPHPExcel->getActiveSheet()->SetCellValue('G11', '%');



$c = $offset;

// variables to keep number of journal have for each level
$counts = [0, 0, 0, 0, 0];

// to keep the threshold value of each level
$classes = [90, 70, 30, 20, 10];

// labels for each levels
$levels = ['A1', 'A2', 'B1', 'B2', 'B5'];

$curentLevel = '';
$a = 0;

foreach ($journals as $journal): 
	
	$c++;
	$index++;
	$percentage = round(($journal['totalMarks'] / $fullMarks) * 100, 2);

	 for ($k = 0; $k < count($classes); $k++) {
                                if ($percentage >= $classes[$k]) {
                                    $counts[$k]++;
                                    if ($curentLevel != $levels[$k]) {
										
										$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':G'.$i);
										$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i,'Tahap ' . $levels[$k]);
                                        
										$curentLevel = $levels[$k];
                                    }
                                    break;
                                }
                            }
	
	$i++;
	
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $c);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $journal['name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $journal['compulsory']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $journal['optional']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $journal['totalMarks']);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $percentage);


	//$objPHPExcel->getActiveSheet()->getStyle("C:G")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

endforeach; 


$objPHPExcel->getActiveSheet()->getStyle("B11:G11")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B10:G10")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B4:B8")->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);



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

$objPHPExcel->getActiveSheet()->getStyle("D10:D10")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("D11:G11")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B10:B$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->getStyle("B$O:G".$i)->applyFromArray($styleArray);
unset($styleArray);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
//$objWriter->save(str_replace('.php', '.xls', __FILE__));

$objWriter->save('php://output');


?>
