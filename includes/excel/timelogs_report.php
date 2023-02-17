<?php
$options = $_GET['options'];
$datefrom = $_GET['datefrom'];
$dateto = $_GET['dateto'];
$employee_id = $_GET['employee_id'];

$condition = ' ';
if($employee_id != 'All'){
	$condition .= ' AND e.id = ' . $employee_id;
}
					
$order = ' ORDER BY  t.date ASC ';
if($options == 'date'){
	$order = ' ORDER BY  t.date ASC ';
}elseif($options == 'employee'){
	$order = ' ORDER BY  t.employee_id ASC ';
}

$sql = "
	SELECT t.*, e.*, e.id as eid, t.id as id
	FROM jf_timelogs as t
	LEFT JOIN jf_employees as e ON e.id = t.employee_id
	WHERE t.date BETWEEN '".$datefrom."' AND '".$dateto."' " . $condition . "
	".$order."
";
$result = $conn->query($sql);

if($result->num_rows > 0){
	$i = 0;
	$counter = 0;
	$fields = array('timein', 'lunchin', 'lunchout', 'timeout');
	$sheet = 0;
	$objPHPExcel->setActiveSheetIndex(0);
	$recent_date = ' ';
	$temp = ' ';
	$recent_emp = 0;
	$temp_e = 0;
	while($row = $result->fetch_assoc()) {	
	
		if($options == 'date'){
			$temp = $row['date'];
		}else{
			$temp_e = $row['eid'];
		}
						
		if($recent_date != $temp || $recent_emp != $temp_e){
			if($counter > 0){
				$objPHPExcel->getActiveSheet()->setTitle($sheet_title);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
				for ($col = 'A'; $col != 'M'; $col++) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);	 
				}
						
				$objPHPExcel->getActiveSheet()->getStyle('A5:K'. $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

				$sheet++;
				$objPHPExcel->createSheet($sheet);
				$objPHPExcel->setActiveSheetIndex($sheet);
			}

			if($options == 'date'){
				$sheet_title = date('F j, Y', strtotime($row['date']));
			}else{
				$sheet_title = $row['firstname'] . ' ' . $row['lastname'];
			}
			
			$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A1:K1');
			$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A2:K2');
			$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A3:K3');

			//Header for Time Logs
			$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A1', 'Jellyfish Education Philippines, Inc.')
					->setCellValue('A2', 'Time Logs Reporting')
					->setCellValue('A3', date('F j, Y', strtotime($datefrom)). ' - ' . date('F j, Y', strtotime($dateto)));
				
			$i = 5;

			if($options == 'date'){
				$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A' . $i, 'Employee');
			}else{
				$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A' . $i, 'Date');
			}
		
			$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('B' . $i, 'Day')
					->setCellValue('C' . $i, 'Time In')
					->setCellValue('D' . $i, 'Lunch In')
					->setCellValue('E' . $i, 'Lunch Out')
					->setCellValue('F' . $i, 'Time Out')
					->setCellValue('G' . $i, 'Late')
					->setCellValue('H' . $i, 'Remarks')
					->setCellValue('I' . $i, 'OT Start')
					->setCellValue('J' . $i, 'OT End')
					->setCellValue('K' . $i, 'OT Reason');	
					
			$i++;
		}
		if($options == 'date'){
			$objPHPExcel->setActiveSheetIndex($sheet)
				->setCellValue('A' . $i, $row['firstname'] . ' ' . $row['lastname']);
		}else{
			$objPHPExcel->setActiveSheetIndex($sheet)
				->setCellValue('A' . $i, date('F j, Y', strtotime($row['date'])));
		}
		
		$objPHPExcel->setActiveSheetIndex($sheet)
			->setCellValue('B' . $i, date('l', strtotime($row['date'])))
			->setCellValue('G' . $i, $row['late'])
			->setCellValue('H' . $i, $row['remarks']);
				
		if(!empty($row['timein'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C' . $i,date('h:i A', strtotime($row['timein'])));
		}		
		if(!empty($row['lunchin'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D' . $i,date('h:i A', strtotime($row['lunchin'])));
		}		
		if(!empty($row['lunchout'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E' . $i,date('h:i A', strtotime($row['lunchout'])));
		}		
		if(!empty($row['timeout'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F' . $i,date('h:i A', strtotime($row['timeout'])));
		}		
		if(!empty($row['otstart'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('I' . $i,date('h:i A', strtotime($row['otstart'])));
		}		
		if(!empty($row['otend'])){
			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('J' . $i,date('h:i A', strtotime($row['otend'])));
		}
		
		if($options == 'date'){
			$recent_date = $row['date'];
		}else{
			$recent_emp = $row['eid'];
		}
		$i++;
		$counter++;
	}
	
}	

$objPHPExcel->getActiveSheet()->setTitle($sheet_title);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
for ($col = 'A'; $col != 'M'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);	 
}
						
$objPHPExcel->getActiveSheet()->getStyle('A5:K'. $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$filename = 'JEP Timelogs Report';
?>