<?php
$datefrom = $_GET['datefrom'];
$dateto = $_GET['dateto'];
$code = $_GET['code'];

$fields = get_array('jf_assessments');
$condition = ' ';
if($code != 'All'){
	$condition .= ' AND agent_code = "' . $code . '"';
}

$sql = "
	SELECT 
	*FROM jf_assessments as a
	LEFT JOIN jf_influencers as i ON i.code = a.agent_code
	WHERE a.dateadded BETWEEN '".$datefrom."' AND '".$dateto."' ".$condition." 
	ORDER BY a.dateadded DESC
";
$result = $conn->query($sql);

$filename = 'JEP_Assessment_' . date('Ymd', strtotime($datefrom)) . '_' . date('Ymd', strtotime($dateto));

if($result->num_rows > 0){
	$i = 0;
	$counter = 1;
	$sheet = 0;
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A1:K1');
	$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A2:K2');
	$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A3:K3');

	$objPHPExcel->setActiveSheetIndex($sheet)
		->setCellValue('A1', 'Jellyfish Education Philippines, Inc.')
		->setCellValue('A2', 'Assessment Reports')
		->setCellValue('A3', date('F j, Y', strtotime($datefrom)). ' - ' . date('F j, Y', strtotime($dateto)));
	
	$col = 'B';
	$i = 5;
	foreach ($fields as $f => $x){
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($col . $i, $x);
		$col++;
	}
	
	$i++;
	while($row = $result->fetch_assoc()) {
		
		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A' . $i, $counter);
		
		$col = 'B';
		foreach ($fields as $f => $x){
			if($f == 'agent'){
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($col . $i,  $row['firstname'] . ' ' . $row['lastname']);
			}else{
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue($col . $i, $row[$f]);
			}
			$col++;
		}
		
		$i++;
		$counter++;
	}
	
}	

$objPHPExcel->getActiveSheet()->setTitle('JEP Assessment');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
for ($col = 'A'; $col != 'T'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);	 
}
						
$objPHPExcel->getActiveSheet()->getStyle('A5:S'. $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$filename = $filename;
?>