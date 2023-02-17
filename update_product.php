<?php
include('includes/header.php'); 
include('functions/list_of_functions.php');
$conn = databaseConnect();


$fields = get_array('jf_employees');
$sql = "SELECT *FROM jf_employees WHERE id = " . $_GET['id'];
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {	
	$fullname = $row['firstname'] . ' ' . $row['lastname']; 
}

if(!empty($_GET['update'])){
	$disabled = '';
}else{
	$disabled = 'disabled';
}

if(isset($_POST['saveData'])){
	$total_fields = count($fields);
	$i = 0;
	
	$f_string = '';
	$value_string = '';
	while($i < $total_fields){
		if($fields[$i][2] == 'date'){
			$date = date('Y-m-d', strtotime($_POST[$fields[$i][0]]));
			$sql2 = " UPDATE jf_employees SET ".$fields[$i][0]." = '".$date."' WHERE id = " . $_GET['id'];
			echo '<br/>';
		}else{
			$sql2 = " UPDATE jf_employees SET ".$fields[$i][0]." = '".$_POST[$fields[$i][0]]."' WHERE id = " . $_GET['id'];
		}
		
		mysqli_query($conn, $sql2);		
		
		$i++;
	}

	$sql2 = "SELECT *from jf_useraccounts WHERE employee_id = " . $_GET['id'];
	$result2 = $conn->query($sql2);
			
	while($row2 = $result2->fetch_assoc()){
		$sql3 = "DELETE FROM jf_useraccounts WHERE id = " . $row2['id'];
		mysqli_query($conn, $sql3);
	}
	
	
	$roles = $_POST['userrole'];
	foreach($roles as $r){
		// echo $r . '<br/>';
		$sql2 = "INSERT into jf_useraccounts (user_id, usertype_id, employee_id) VALUES (".$_COOKIE['userid'].", ".$r.", ".$_GET['id'].")";
		mysqli_query($conn, $sql2);
	}
	
	echo "<script> location.href='view_employee.php?id='".$_COOKIE['id']."; </script>";
}
?>

 <!-- Begin Page Content -->
 Test1 122
<div class="container-fluid">

<!-- Page Heading -->
<?php
if(!empty($_GET['update'])){
	echo '<a href="view_employee.php?id='.$_GET['id'].'" class="btn btn-info btn-sm"><i class="fas fa-fw fa-chevron-left"></i> Back</a>';
}else{
	echo '<a href="view_employee.php?id='.$_GET['id'].'&update=1" class="btn btn-info btn-sm"><i class="fas fa-fw fa-edit"></i> Update</a>';
}
					
echo '&nbsp;<a href="leaves.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-umbrella"></i> Leaves</a>';
echo '&nbsp;<a href="timelogs.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-clock"></i> Time Logs</a>';
echo '&nbsp;<a href="requirements.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-poll-h"></i> Requirements</a>';
echo '&nbsp;<a href="password_reset.php?id='.$_GET['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-key"></i> Reset Password</a>';
?>
                    

					
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $fullname; ?></h6>
    </div>
    <div class="card-body">
    <form method="post">
        <div class="row">
		<?php
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {		
			$total_fields = count($fields);
			$i = 0;
			while($i < $total_fields){
				echo '<div class="col-md-4">';
					echo '<label style="margin-top: 10px;">' . $fields[$i][1] . '</label>';
					if($fields[$i][2] != 'textarea'){
						if($fields[$i][0] == 'department_id'){
							$status = array('Inactive', 'Active');
							$dept = " SELECT  *FROM jf_departments ORDER BY name ASC";
							$departments = $conn->query($dept);
													
							echo '<select name="department_id" class="form-control" '.$fields[$i][3].' '.$disabled.'>';
							while($department = $departments->fetch_assoc()) {
								if($department['id'] == $row['department_id']){
									$selected = ' selected';
								}else{
									$selected = ' ';
								}
								echo '<option value="'.$department['id'].'" '.$selected.'>' . $department['name'] . '</option>';
							}
							echo '</select>';
						}elseif($fields[$i][0] == 'educationAttaintment'){
							$array = array('Bachelor Degree' => 'Bachelor Degree', 'Masteral' => 'Masteral', 'Doctorate' => 'Doctorate');
							echo '<select name="educationAttaintment" class="form-control" '.$fields[$i][3].' '.$disabled.'>';
								foreach ($array as $a => $x){
									if($a == $row['educationAttaintment']){
										$selected = ' selected';
									}else{
										$selected = ' ';
									}
									echo '<option value="'.$a.'" '.$selected.'>'.$x.'</option>';
								}
							echo '</select>';
						}elseif($fields[$i][0] == 'employmentStatus'){
							$array = array('Contractual' => 'Contractual', 'Probationary' => 'Probationary', 'Regular' => 'Regular', 'Resigned' => 'Resigned', 'AWOL' => 'AWOL');
							echo '<select name="employmentStatus" class="form-control" '.$fields[$i][3].' '.$disabled.'>';
								foreach ($array as $a => $x){
									if($a == $row['employmentStatus']){
										$selected = ' selected';
									}else{
										$selected = ' ';
									}
									echo '<option value="'.$a.'" '.$selected.'>'.$x.'</option>';
								}
							echo '</select>';
						}else{
							echo '<input type="'.$fields[$i][2].'" name="'.$fields[$i][0].'" class="form-control" '.$fields[$i][3].' value="'.$row[$fields[$i][0]].'" '.$disabled.'>';
						}												
					}else{
						echo '<textarea name="'.$fields[$i][0].'" class="form-control" '.$disabled.'>'.$row[$fields[$i][0]].'</textarea>';
					}
				echo '</div>';
				$i++;
			}
			
			$sql = "SELECT *from jf_useraccounts WHERE employee_id = " . $_GET['id'];
			$result2 = $conn->query($sql);
			
			$admin = '';
			$employee = '';
			while($row2 = $result2->fetch_assoc()){
				if($row2['usertype_id'] == 1){
					$admin = ' checked';
				}
				
				if($row2['usertype_id'] == 2){
					$employee = ' checked';
				}
			}
			
			echo '
				<div class="col-md-4">
					<label>System Role</label><br/>
					<input type="checkbox" name="userrole[]" value="2" '.$employee.'>&nbsp;Employee<br/>
					<input type="checkbox" name="userrole[]" value="1" '.$admin.'>&nbsp;Admin
				</div>
			';
		}
								
		if(!empty($_GET['update'])){
			echo '
				<div class="col-md-12">
					<br/><input type="submit" name="saveData" class="btn btn-primary" value="Update Details">
				</div>
			';
		}
		?>
		</div>
        </form>
    </div>
</div>

</div>
</div>
            <!-- End of Main Content -->

<?php include('includes/footer.php'); ?>
