<?php

if(isset($_POST['cmdType'])){
    $cmdType = $_POST['cmdType'];

    if($cmdType == "getEntries"){
		// $actiont = $_POST["actiont"];
		$action = new myaction();
        $result = $action->getEntries();  
		echo json_encode($result);
    }
};


class myaction {
	public function getEntries(){
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$db = "menorian";
		$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);	
		
	$sql = "
		SELECT mr.*, sa.id as sid, sa.invoicenumber
		FROM 
			mr_monitorings as mr
		LEFT JOIN 
			mr_statementofaccounts as sa ON mr.id = sa.monitoring_id
		
		ORDER BY
			mr.id DESC 
		"; 
	
	$result = $conn->query($sql);
	$types = array('', 'Import', 'Export', 'Trucking');
	
	$d = '
            <thead>
				<tr>
                    <th></th>
                    <th>Type</th>
                   <th></th>
                                            
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Weight</th>
                                            <th>Size of Cargo</th>
                                            <th># of Container</th>
                                            <th>PRO Number</th>
                                            <th>Client DR Number</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>TQype</th>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Weight</th>
                                            <th>Size of Cargo</th>
                                            <th># of Container</th>
                                            <th>PRO Number</th>
                                            <th>Client DR Number</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                   ';

									while($row = $result->fetch_assoc()) {
		if(!empty($row['type'])){
			$type_e = $types[$row['type']];
		}else{
			$type_e = '';
		}
		
		$d .= '<tr>';
			$d .= '<td>';
				if($soaid == 0){
					$d . '<a href="" class="btn btn-sm btn-primary">Create SOA</a>';
				}else{
					$d . '<a href="" class="btn btn-sm btn-primary">Update SOA</a>';
				}
				$d . '<a href="" class="btn btn-sm btn-primary">Update Details</a>';
			$d .= '</td>';
			$d .= '<td>' . $type_e . '</td>';
			$d .= '<td></td>';
			$d .= '<td>' . date('F j, Y', strtotime($row['date'])) . '</td>';
			$d .= '<td>' . $row['client'] . '</td>';
			$d .= '<td>' . $row['weight'] . '</td>';
			$d .= '<td>' . $row['SizeOfCargo'] . '</td>';
			$d .= '<td>' . $row['numberOfContainer'] . '</td>';
			$d .= '<td>' . $row['PRONumber'] . '</td>';
			$d .= '<td>' . $row['clientDRNumber'] . '</td>';
		$d .= '</tr>';
	};
								$d .= '
                                    </tbody>
                                ';
	
		
		return $d;
	}}

