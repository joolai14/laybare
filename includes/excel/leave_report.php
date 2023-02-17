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
	$order = ' ORDER BY  et.datefrom ASC ';
}elseif($options == 'employee'){
	$order = ' ORDER BY  et.employee_id ASC ';
}

$sql = "
	SELECT  et.*, e.*, e.id as eid, et.id as id, l.name
	FROM jf_employeeleavetakens as et
	LEFT JOIN jf_employees as e ON e.id = et.employee_id
	LEFT JOIN jf_leavetypes as l ON l.id = et.leavetype_id
	WHERE et.datefrom BETWEEN '".$datefrom."' AND '".$dateto."' ".$condition." AND et.leavestatus < 2
	ORDER BY datefrom ASC
";
$result = $conn->query($sql);
$sheet_title = '';
if($result->num_rows > 0){
	$i = 0;
	$counter = 0;
	$sheet = 0;
	$objPHPExcel->setActiveSheetIndex(0);
	$recent_date = ' ';
	$temp = ' ';
	$recent_emp = 0;
	$temp_e = 0;
	while($row = $result->fetch_assoc()) {	
	
		if($options == 'date'){
			$temp = $row['datefrom'];
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
				$sheet_title = date('F Y', strtotime($row['datefrom']));
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
					->setCellValue('A3', date('F Y', strtotime($datefrom)). ' - ' . date('F Y', strtotime($dateto)));
				
			$i = 5;

			if($options == 'date'){
				$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A' . $i, 'Employee');
			}else{
				$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A' . $i, 'Date');
			}
		
			$objPHPExcel->setActiveSheetIndex($sheet)
					->setCellValue('A' . $i, 'Employee')
					->setCellValue('B' . $i, 'Type')
					->setCellValue('C' . $i, 'Start Date')
					->setCellValue('D' . $i, 'End Date')
					->setCellValue('E' . $i, 'Day')
					->setCellValue('F' . $i, 'Reason')
					->setCellValue('G' . $i, 'Remarks')
					->setCellValue('H' . $i, 'Status');	
					
			$i++;
		}
		
		$remarks = '';
		if($row['halfdayleave'] == 1){
			$remarks = 'Half day Leave';
		}
		
		$approved = array('Not Yet Approved', 'Approved Leave');						
		$objPHPExcel->setActiveSheetIndex($sheet)
			->setCellValue('A' . $i, $row['firstname'] . ' ' . $row['lastname'])
			->setCellValue('B' . $i, $row['name'])
			->setCellValue('C' . $i, date('F j, Y', strtotime($row['datefrom'])))
			->setCellValue('D' . $i, date('F j, Y', strtotime($row['dateto'])))
			->setCellValue('E' . $i, date('l', strtotime($row['datefrom'])))
			->setCellValue('F' . $i, $row['reason'])
			->setCellValue('G' . $i, $remarks)
			->setCellValue('H' . $i, $approved[$row['halfdayleave']]);
				
		
		
		if($options == 'date'){
			$recent_date = $row['datefrom'];
		}else{
			$recent_emp = $row['eid'];
		}
		$i++;
		$counter++;
	}
	
}	

$objPHPExcel->getActiveSheet()->setTitle($sheet_title);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
for ($col = 'A'; $col != 'I'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);	 
}
						
$objPHPExcel->getActiveSheet()->getStyle('A5:H'. $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$filename = 'JEP Leave Report';
?>