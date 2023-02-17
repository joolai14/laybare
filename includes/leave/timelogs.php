<?php
$options = $_GET['options'];
$datefrom = $_GET['datefrom'];
$dateto = $_GET['dateto'];
$sql = "
	SELECT 
	*FROM jf_timelogs as t
	LEFT JOIN jf_employees as e ON e.id = t.employee_id
	WHERE e.id = ".$_GET['id']." AND t.date BETWEEN '".$datefrom."' AND '".$dateto."'
";
$result = $conn->query($sql);

if($result->num_rows == 0){
	$sql2 = "SELECT *FROM jf_employees WHERE id = ".$_GET['id'];
	$result2 = $conn->query($sql2);
}else{
	$result2 = $conn->query($sql);
}

while($row = $result2->fetch_assoc()) {	
	$filename = $row['firstname'] . '_' . $row['lastname'] . '_' . date('Ymd', strtotime($datefrom)) . '-' . date('Ymd', strtotime($dateto));
		
	$fullname = strtoupper($row['firstname'] . ' ' . $row['lastname']);
	$position = $row['position'];
}
	

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:J1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:J2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:J3');

//Header for Time Logs
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Name')
		->setCellValue('B1', $fullname)
		->setCellValue('A2', 'Position')
		->setCellValue('B2', $position)
		->setCellValue('A3', 'Date')
		->setCellValue('B3', date('F j, Y', strtotime($datefrom)). ' - ' . date('F j, Y', strtotime($dateto)));
	
$i = 5;
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $i, 'Date')
		->setCellValue('B' . $i, 'Time In')
		->setCellValue('C' . $i, 'Lunch In')
		->setCellValue('D' . $i, 'Lunch Out')
		->setCellValue('E' . $i, 'Time Out')
		->setCellValue('F' . $i, 'Late')
		->setCellValue('G' . $i, 'Remarks')
		->setCellValue('H' . $i, 'OT Start')
		->setCellValue('I' . $i, 'OT End')
		->setCellValue('J' . $i, 'OT Reason');
	
$i++;
$result = $conn->query($sql);
if($result->num_rows > 0){
	while($row = $result->fetch_assoc()) {	
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, date('F j, Y', strtotime($row['date'])))
			->setCellValue('F' . $i, $row['late'])
			->setCellValue('G' . $i, $row['remarks'])
			->setCellValue('J' . $i, $row['otreason']);
				
		if(!empty($row['timein'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i,date('h:i A', strtotime($row['timein'])));
		}		
		if(!empty($row['lunchin'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i,date('h:i A', strtotime($row['lunchin'])));
		}		
		if(!empty($row['lunchout'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i,date('h:i A', strtotime($row['lunchout'])));
		}		
		if(!empty($row['timeout'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i,date('h:i A', strtotime($row['timeout'])));
		}		
		if(!empty($row['otstart'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i,date('h:i A', strtotime($row['otstart'])));
		}		
		if(!empty($row['otend'])){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i,date('h:i A', strtotime($row['otend'])));
		}
		$i++;
	}
}		

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
for ($col = 'A'; $col != 'L'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);	 
}
		
$objPHPExcel->getActiveSheet()->getStyle('A5:J'. $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle($fullname);
?>