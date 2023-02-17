<?php
function databaseConnect(){	
	// $conn3 = $conn = new mysqli('localhost', 'jellyfishedu_admin', 'Jellyfish@123', 'jellyfishedu_hris') or die("Connect failed: %s\n". $conn -> error);
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "inventory";
	$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
	return $conn;
}
 
function CloseCon($conn){
	$conn -> close();
}

function get_array($table){
	if($table == 'jf_employees'){
		$fields = array(
			0 => array(
			  'lastname', 'Last Name', 'input', 'required'
			),
			1 => array(
			  'firstname', 'First Name', 'input', 'required'
			),
			2 => array(
			  'middlename', 'Middle Name', 'input', 'required'
			),
			3 => array(
			  'suffix', 'Suffix', 'input', ''
			),
			4 => array(
			  'birthdate', 'Birth Date', 'date', 'required'
			),
			5 => array(
			  'educationAttaintment', 'Educational Attaintment', 'select', 'required'
			),
			6 => array(
			  'course', 'Course', 'input', 'required'
			),
			7 => array(
			  'contactNumber', 'Contact Number', 'input', 'required'
			),
			8 => array(
			  'personalEmail', 'Personal Email', 'email', 'required'
			),
			9 => array(
			  'address1', 'Present Address', 'textarea', 'required'
			),
			10 => array(
			  'address2', 'Permanent Address', 'textarea', ''
			),	
			11 => array(
			  'companyEmail', 'Company Email', 'email', 'required'
			),
			12 => array(
			  'companyContactNumber', 'Company Contact Number', 'input', ''
			),	
			13 => array(
			  'datehired', 'Date Hired', 'date', 'required'
			),
			14 => array(
			  'employmentStatus', 'Employment Status', 'select', 'required'
			),
			15 => array(
			  'department_id', 'Department', 'select', 'required'
			),
			16 => array(
			  'position', 'Position', 'input', 'required'
			),
			17 => array(
			  'TIN', 'Tax Identification Number', 'input', 'required'
			),
			18 => array(
			  'HDMF', 'Pag-ibig Number', 'input', 'required'
			),
			19 => array(
			  'SSS', 'SSS Number', 'input', 'required'
			),
			20 => array(
			  'philhealth', 'Philhealth Number', 'input', 'required'
			),
			21 => array(
			  'emergencyContactName', 'Emergency Contact Person', 'input', 'required'
			),
			22 => array(
			  'emergencyContactNumber', 'Emergency Contact Number', 'input', 'required'
			),
			23 => array(
			  'emergencyAddress', 'Emergency Contact Address', 'textarea', 'required'
			)
		);
	}elseif($table == 'jf_interns'){
		$fields = array(
			0 => array(
			  'lastname', 'Last Name', 'input', 'required'
			),
			1 => array(
			  'firstname', 'First Name', 'input', 'required'
			),
			2 => array(
			  'middlename', 'Middle Name', 'input', 'required'
			),
			3 => array(
			  'suffix', 'Suffix', 'input', ''
			),
			4 => array(
			  'birthdate', 'Birth Date', 'date', 'required'
			),
			5 => array(
			  'email', 'Email Address', 'email', 'required'
			),
			6 => array(
			  'contactnumber', 'Contact Number', 'input', 'required'
			),
			7 => array(
			  'address', 'Address', 'textarea', 'required'
			),
			8 => array(
			  'school', 'School', 'textarea', 'required'
			),
			9 => array(
			  'schoolAddress', 'School Address', 'textarea', 'required'
			),
			10 => array(
			  'ojtAdviser', 'OJT Adviser', 'input', 'required'
			),
			11 => array(
			  'ojtAdviserContact', 'Adviser Contact Number', 'input', 'required'
			),
			12 => array(
				'course', 'Course', 'textarea', 'required'
			),	
			13 => array(
			  'datestarted', 'Date Started', 'date', 'required'
			),
			14 => array(
			  'dateend', 'Date Finished', 'date', ''
			),
			15 => array(
			  'department_id', 'Department', 'select', 'required'
			),
			16 => array(
			  'requiredhours', 'Required Hours', 'number', ''
			)
		);
	}elseif($table == 'jf_assessments'){
		$fields = array(
			'agent_code' => 'Agent Code', 
			// 'jf_assessments_id' => '',
			'agent' => 'Agent Name',	
			'first_name'  => 'First Name',
			'last_name' => 'Last Name', 
			'age' => 'Age', 
			'gender' => 'Gender', 
			'present_address' => 'Address', 
			'educational_attainment' => 'Educational Attaintment', 
			'email_address' => 'Email Address', 
			'contact_number' => 'Contact Number', 
			'fb_profile_name' => 'FB Profile Name', 
			'pref_program' => 'Preferred Program', 
			// 'have_agent_code' => 'Have Agent Code', 
			'pref_way' => 'Preferred Way to Call', 
			'skype_id' => 'Skype ID', 
			'pref_day' => 'Preferred Day', 
			'pref_time' => 'Preferred Time', 
			'dateadded' => 'Date Added'
		);
	}

	return $fields;
}

function getLists($table){
	$status = array('Inactive', 'Active');
	$conn = databaseConnect();
	
		
	if($table == 'jf_products'){
		$sql = "
			SELECT
			*FROM ".$table." ORDER BY Name DESC
			";
		$result = $conn->query($sql);
		$d = '';
		$i = 1;
		while($row = $result->fetch_assoc()) {		
			$d .= '<tr>';
				$d .= '<td>' . $row['id'] . '</td>';
				$d .= '<td>' . $row['Name'] . '</td>';
				$d .= '<td>' . $row['Description'] . '</td>';
				$d .= '<td>' . $row['Price'] . '</td>';
				// $d .= '<td>' . $status[$row['status']] . '</td>';
				$d .= '<td>';
					// $d .= '<a href="feed_management.php?id='.$row['id'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>';
					$d .= '<a href="products.php?id='.$row['id'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;';
					$d .= "<small><a href='delete_record.php?id=".$row['id']."&table=jf_influencers&redirect=feeds.php' onclick='return confirm(\"Are you sure you want to submit this data?\");'><i class='fa fa-trash' aria-hidden='true'></i></a></small>";
				$d .= '</td>';
			$d .= '</tr>';
			
			$i++;
		}
	}
	
	return $d;
}

function getEmployees($id =0){
	$status = array('', 'Active', 'Inactive');
	$conn = databaseConnect();
	
	$sql = "SELECT e.id as eid, e.*, d.name as dname FROM jf_employees as e LEFT JOIN jf_departments as d ON d.id = e.department_id ORDER BY id DESC";
	if($id == 0){
		$result = $conn->query($sql);
		
		$d = '';
		while($row = $result->fetch_assoc()) {		
			$d .= '<tr>';
				$d .= '<td>';
					$d .= '<a href="view_employee.php?id='.$row['eid'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>';
					$d .= '&nbsp;&nbsp;<a href="view_employee.php?id='.$row['eid'].'&type=update"><i class="fa fa-eye" aria-hidden="true"></i></a>';
					$d .= "&nbsp;&nbsp;<a href='delete_record.php?id=".$row['eid']."&table=jf_employees&redirect=employees.php' onclick='return confirm(\"Are you sure you want to submit this data?\");'><i class='fa fa-trash' aria-hidden='true'></i> </a>";
				$d .= '</td>';
				$d .= '<td>' . $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['suffix'] .  '</td>';
				$d .= '<td>' . $row['contactNumber'] . '</td>';
				$d .= '<td>' . $row['companyEmail'] . '</td>';
				$d .= '<td>' . $row['dname'] . '</td>';
				$d .= '<td>' . $row['position'] . '</td>';
				$d .= '<td>' . $row['employmentStatus'] . '</td>';
				$d .= '<td>' . date('F j, Y', strtotime($row['datehired'])) . '</td>';
			$d .= '</tr>';
		}
	}else{
		$sql = "SELECT *FROM mr_users  WHERE id = " . $id;
		$result = $conn->query($sql);
		
		$d = '';
		while($row = $result->fetch_assoc()) {	
			if($row['status_id'] == 1){
				$checked = ' checked';
				$checked1 = ' ';
			}else{
				$checked1 = ' checked';
				$checked = ' ';
			}
			$d .= '<tr>';
				$d .= '<td>';
					
				$d .= '</td>';
				$d .= '<td>' . $row['username'] . '</td>';
				$d .= '
						<td>
							<label>First Name</label>
							<input name="firstname" class="form-control" value="'.$row['firstname'].'">
							
							<label>Last Name</label>
							<input name="lastname" class="form-control" value="'.$row['lastname'].'">						
						</td>
				';
				$d .= '<td><label>Position</label><input name="position" class="form-control" value="'.$row['position'].'"></td>';
				$d .= '
						<td>
							<input type="radio" name="status_id" '.$checked.'> Active<br/>
							<input type="radio" name="status_id" '.$checked1.'> Inactive<br/>
						</td>
				';
				$d .= '<td>' . $row['lastaccess'] . '</td>';
				$d .= '<td><input type="submit" name="updateData" class="btn btn-primary" value="Update"></td>';
			$d .= '</tr>';
			$d .= '<tr>';
			$d .= '</tr>';
		}
	}
	return $d;
}

function gettimeLogs($id, $datefrom, $dateto, $options){
	$condition = ' ';
	if($id != 'All'){
		$condition .= ' AND e.id = ' . $id;
	}
	
	$order = ' ORDER BY  t.date ASC ';
	if($options == 'date'){
		$order = ' ORDER BY  t.date ASC ';
	}elseif($options == 'employee'){
		$order = ' ORDER BY  e.firstname ASC ';
	}
	
	$conn = databaseConnect();
	$sql = "
		SELECT 
		*FROM jf_timelogs as t
		LEFT JOIN jf_employees as e ON e.id = t.employee_id
		WHERE t.date BETWEEN '".$datefrom."' AND '".$dateto."' " . $condition . "
		".$order."
	";
	$result = $conn->query($sql);
		
	$d = '';	
	$fields = array('timein', 'lunchin', 'lunchout', 'timeout');
	while($row = $result->fetch_assoc()) {		
		$d .= '<tr>';
			$d .= '<td>';
				$d .= '<a href="timelogs.php?id='.$row['id'].'&type=update"><i class="fa fa-edit" aria-hidden="true"></i> </a>';
				// $d .= "<a href='delete.php?id=".$row['id']."&type=delete' onclick='return confirm(\'Are you sure you want to submit this form?\');'><i class='fa fa-trash' aria-hidden='true'></i> </a>";
			$d .= '</td>';
			
			if($options == 'date' || $options == 'employee'){
				$d .= '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
			}
			
			$d .= '<td>' . date('M j, Y', strtotime($row['date'])) . '</td>';
			
			
			foreach ($fields as $f){
				$d .= '<td>';
					if(!empty($row[$f])){
						$d .= date('h:i A', strtotime($row[$f]));
					}
				$d .= '</td>';
			}
			$d .= '<td>' . $row['late'] . '</td>';
			$d .= '<td>' . $row['remarks'] . '</td>';
			
			if($options != 'timelogs'){
				$d .= '<td>';
					if(!empty($row['otstart'])){
						$d .= date('h:i A', strtotime($row['otstart']));
					}
				$d .= '</td>';
				
				$d .= '<td>';
					if(!empty($row['otend'])){
						$d .= date('h:i A', strtotime($row['otend']));
					}
				$d .= '</td>';
				
				$d .= '<td>'.$row['otreason']. '</td>';
			}
		$d .= '</tr>';
	}
	return $d;
}


function employees($form_name, $condition){
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = 0;
	}
	
	$conn = databaseConnect();
	$sql = " 
		SELECT  id, firstname, lastname, CONCAT(firstname,' ',lastname) as Fullname 
		FROM jf_employees 
		WHERE ".$condition."
		ORDER BY firstname ASC";
	$employees = $conn->query($sql);
	
	
	$d = '<select name="'.$form_name.'" class="form-control select2">';
		$d .= '<option value="All">Select One</option>';
		while($row = $employees->fetch_assoc()) {
			$selected = '';
			if($id == $row['id']){
				$selected = ' selected';
			}
			$d .= '<option value="'.$row['id'].'" '.$selected.'>'.$row['Fullname'].'</option>';
		}
	
	$d .= '</select>';
	return $d;
}

function getNotes($action, $datefrom, $dateto, $employee_id, $showdate, $field,  $table){
	$condition = ' ';
	if($employee_id != 'All'){
		$condition .= ' AND e.id = ' .$employee_id ;
	}
	
	$conn = databaseConnect();
	$sql = "
		SELECT n.*, e.firstname, e.lastname, n.id as nid
		FROM jf_notes as n
		JOIN ".$table." as e ON e.id = n.".$field."
		WHERE n.date BETWEEN '".$datefrom."' AND '".$dateto."' ".$condition." 
		ORDER BY n.date ASC, e.firstname ASC";
	$employees = $conn->query($sql);
	if($action == 'notes'){
		$content = '
			<table class="table table-striped" width="100%" cellspacing="0">
				<thead class="thead-dark"><tr><th colspan="3">Notes</th></thead>
		';
	}else{
		$content = '
			<table class="table" width="100%" cellspacing="0">
		';
	}
	if($employees->num_rows == 0){
		$content .= '
			<tbody><tr><td colspan="3" style="border: 0"><br/><center><small>No Notes for Today</small><br/><br/></center></td></tr></tbody>
		';
	}
	
	while($row = $employees->fetch_assoc()) {
		$content .= '
			
				<tr>
					<td> 
						' .$row['firstname'] . ' 
		';
						if($showdate == 1){
							$content .= '<br/><small>'.date('F j, Y', strtotime($row['date'])).'</small>';
						}
		$content .= '
					</td>
					<td>'.$row['note'].'<br/><small>' . $row['remarks'] . '</small></td>
					<td>
		';				
						if($action == 'notes'){
							$content .= "<small><a href='delete_record.php?id=".$row['nid']."&table=jf_notes&redirect=notes.php' onclick='return confirm(\"Are you sure you want to submit this data?\");'><i class='fa fa-trash' aria-hidden='true'></i></a></small>";
						}
		$content .= '				
					</td>
				</tr>
		';
	}
		$content .= '</table>';
	
	return $content;
}

function getMenu($option){
	if($option == 'leaves'){
		$d = '
			<a href="leaves_management.php" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-home"></i> Home</a>
			<a href="leave_filing.php" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-file"></i> File Leave</a>
			<a href="leaves_report_all.php?action=summary" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-umbrella"></i> Show Summary</a>
			<a href="leaves_report_all.php?action=incoming" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-calendar-alt"></i> Incoming Leave</a>
			<a href="leaves_report_all.php?action=notapproved" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-times-circle"></i> Not Yet Approved Leave</a><br/>
		';
	}elseif($option == 'employees'){
		$d = '<a href="view_employee.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-chevron-left"></i> Back</a>';
		$d .= '&nbsp;<a href="leaves.php?id='.$_GET['id'].'" class="btn btn-info btn-sm"><i class="fas fa-fw fa-umbrella"></i> Leaves</a>';
		$d .= '&nbsp;<a href="timelogs.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-clock"></i> Time Logs</a>';
		$d .= '&nbsp;<a href="requirements.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-poll-h"></i> Requirements</a>';
		$d .= '&nbsp;<a href="password_reset.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-key"></i> Reset Password</a>';
	}elseif($option == 'leaves_emp'){
		$d = '
			<a href="myleave.php" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-home"></i> Home</a>
		<a href="leave_filing.php" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-fw fa-file"></i> File Leave</a>';
		
	}
	
	return $d;
}

function sendEmail($body, $email, $title, $cc){
	//SEND EMAIL TO JELLYFISH
	require 'phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();                              // Set mailer to use SMTP
	$mail->Host = "mail.jellyfisheducation.com.ph";		// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                       // Enable SMTP authentication
	$mail->Username = 'noreply@jellyfisheducation.com.ph';            // SMTP username
	$mail->Password = 'p334atAl2h2U';         // SMTP password
	$mail->SMTPSecure = 'ssl';          // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;   
		
	$mail->setFrom('noreply@jellyfisheducation.com.ph', 'JEP');
	$mail->addAddress($email, 'JEP');     // Add a recipient
	if($cc != NULL){
		// $mail->addCC($cc, $USER->firstname . ' ' . $USER->lastname);     // CC
	}
		
	$mail->Subject  = $title; 
			
	$mail->Body    = 	$body;	
	$mail->AltBody = 'JEP.';
					
	$mail->SMTPOptions = 
		array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
		);
								
		if(!$mail->send()) {
			// echo '<div class="alert alert-warning alert-dismissible" role="alert"  style="margin-top: 20px; text-align: center; font-size: 16px;">';
				// echo 'Message could not be sent.';
				// echo 'Mailer Error: ' . $mail->ErrorInfo;
			// echo '</div>';
		}	
		
}

function get_days_difference($from, $to){
	$date1 = $to;
	$date2 = $from;

	$diff = abs(strtotime($date2) - strtotime($date1));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	return $days;
}

function getname($id){
	$conn = databaseConnect();
	$name = $conn->query("Select *from jf_employees where id = " . $id );
	while($row = $name->fetch_assoc()) {	
		$fullname = $row['firstname'] . ' ' . $row['lastname'];
	}
	
	return $fullname;
}

function getInterns($id = 0){
	$status = array('Finished', 'Active');
	$conn = databaseConnect();
	
	$sql = "SELECT i.id as eid, i.*, d.name as dname FROM jf_interns as i LEFT JOIN jf_departments as d ON d.id = i.department_id ORDER BY status DESC";
	if($id == 0){
		$result = $conn->query($sql);
		
		$d = '';
		while($row = $result->fetch_assoc()) {		
			$d .= '<tr>';
				$d .= '<td>';
					$d .= '<a href="view_intern.php?id='.$row['eid'].'&type=update"><i class="fa fa-eye" aria-hidden="true"></i></a>';
					$d .= "&nbsp;&nbsp;<a href='delete_record.php?id=".$row['eid']."&table=jf_interns&redirect=intern.php' onclick='return confirm(\"Are you sure you want to delete this data?\");'><i class='fa fa-trash' aria-hidden='true'></i> </a>";
				$d .= '</td>';
				$d .= '<td>' . $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['suffix'] .  '</td>';
				$d .= '<td>' . $row['dname'] . '</td>';
				$d .= '<td>' . $row['contactnumber'] . '</td>';
				$d .= '<td>' . $row['email'] . '</td>';
				$d .= '<td>' . $row['course'] . '</td>';
				$d .= '<td>' . $row['school'] . '</td>';
				$d .= '<td>' . $row['requiredhours'] . '</td>';
				$d .= '<td>';
					$d .= date('F j, Y', strtotime($row['datestarted']));
					if(!empty($row['dateend'])) { 
						$d .= '<br/> - ' . date('F j, Y', strtotime($row['dateend']));
					}else{
						$d .= ' - Present';
					}
				$d .= '</td>';
				$d .= '<td>' . $status[$row['status']] . '</td>';
			$d .= '</tr>';
		}
	}
	return $d;
}

function getLogs($table, $join_table, $join_var){
	$conn = databaseConnect();
	$sql = "
		SELECT t.*, e.*, e.id as eid, t.id as tid
		FROM ".$table." as t
		JOIN ".$join_table." as e ON e.id = t.".$join_var."
		WHERE t.date = '".date('Y-m-d')."' AND t.timein IS NOT NULL
		ORDER BY  t.id DESC
	";
	
	$result = $conn->query($sql);
	
	$d = '
		<table class="table table-striped" width="100%" cellspacing="0">
			<thead>
			<tr>	
				<th style="width: 5%"></th>
				<th style="width: 8%"><small><b>In</b></small></th>
				<th style="width: 8%"><small><b>Lunch </b></small></th>
				<th style="width: 8%"><small><b>Out</b></small></th>
				<th style="width: 10%"><small><b>Remarks</b></small></th>
			</tr>
			</thead>
	';
	while($row = $result->fetch_assoc()) {
		$d .= '<tr>';
			$d .= '<th style="width: 8%"><small><b>'.$row['firstname'] . '</b></small></th>';
			$d .= '<th style="width: 8%"><small><b>'. date('H:i', strtotime($row['timein'])) . '</b></small></th>';
			
			if(!empty($row['lunchin'])){
				$d .= '
					<th style="width: 8%">
						<small><b>'.date('H:i', strtotime($row['lunchin'])).'</b></small>';
						if(!empty($row['lunchout'])){
							$d .= '<small><b>-'.date('H:i', strtotime($row['lunchout'])).'</b>';
						}
				$d .= '</th>';
			}else{
				$d .= '<th></th>';
			}
			
			if(!empty($row['timeout'])){
				$d .= '<th style="width: 8%"><small><b>'.date('H:i', strtotime($row['timeout'])).'</b></small></th>';
			}else{
				$d .= '<th></th>';
			}
				
			$d .= '<th style="width: 8%"><small><b>'.$row['remarks'].'</b></small></th>';
		$d.= '</tr>	';
	}
	
	$d .= '</table>';
	return $d;
}

function getInternsLists($form_name, $condition){
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = 0;
	}
	
	$conn = databaseConnect();
	$sql = " 
		SELECT  id, firstname, lastname, CONCAT(firstname,' ',lastname) as Fullname 
		FROM jf_interns 
		WHERE ".$condition."
		ORDER BY firstname ASC";
	$employees = $conn->query($sql);
	
	
	$d = '<select name="'.$form_name.'" class="form-control select2">';
		$d .= '<option value="All">Select One</option>';
		while($row = $employees->fetch_assoc()) {
			$selected = '';
			if($id == $row['id']){
				$selected = ' selected';
			}
			$d .= '<option value="'.$row['id'].'" '.$selected.'>'.$row['Fullname'].'</option>';
		}
	
	$d .= '</select>';
	return $d;
}
?>