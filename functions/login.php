<?php
include('list_of_functions.php');
$conn = databaseConnect();

if(isset($_POST['login'])){
	$username = $_POST['username'];
	$password = hash('ripemd160', $_POST['password']);
	
	$sql = "
		SELECT u.*, e.lastname, e.firstname, u.id as uid, u.*	
		FROM jf_users as u
		LEFT JOIN jf_employees as e ON e.id = u.employee_id
		WHERE username = '".$username."' AND password = '".$password."' ";
	$result = $conn->query($sql);
	
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql = "UPDATE jf_users SET lastaccess = " . time() ." WHERE id = " . $row['id'];
			mysqli_query($conn, $sql);
			
			if($row['employee_id'] == 0){
				$fullname = $row['fullname'];
			}else{
				$fullname = $row['firstname'] . ' ' . $row['lastname'];
			}
			setcookie("username", $_POST['username'], time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("id", $row['employee_id'], time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("userid", $row['uid'], time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("fullname", $fullname, time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("internid", $row['intern_id'], time()+ 36000000,'/'); // expires after 60 seconds
			if($row['passwordchange'] == 0){				
				echo "<script> location.href='/laybare/changemypassword.php'; </script>";
			}else{
				echo "<script> location.href='/laybare/dashboard.php'; </script>";
			}
		}
	}else{
		echo '<script>alert("Incorrect Log In.");</script>';
		// echo "<script> location.href='/laybare/'; </script>";
	}
	// setcookie("user_name", $_POST['email'], time()+ 6000,'/'); // expires after 60 seconds
    // setcookie("id", "12", time()+ 6000,'/'); // expires after 60 seconds
	// echo "<script> location.href='dashboard.php?email=$email'; </script>";
}elseif(isset($_POST['changePassword'])){
	$username = $_POST['username'];
	$password = hash('ripemd160', $_POST['password']);
	
	$sql = "SELECT *FROM jf_users WHERE username = '".$username."' AND password = '".$password."'";
	$result = $conn->query($sql);
	
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$sql = "UPDATE jf_users SET lastaccess = " . time() ." WHERE id = " . $row['id'];
			mysqli_query($conn, $sql);
			setcookie("username", $_POST['username'], time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("id", $row['employee_id'], time()+ 36000000,'/'); // expires after 60 seconds
			setcookie("userid", $row['id'], time()+ 36000000,'/'); // expires after 60 seconds
			if($row['passwordchange'] == 0){				
				echo "<script> location.href='/laybare/changemypassword.php'; </script>";
			}else{
				echo "<script> location.href='/laybare/dashboard.php?email=$email'; </script>";
			}
		}
	}
	// setcookie("user_name", $_POST['email'], time()+ 6000,'/'); // expires after 60 seconds
    // setcookie("id", "12", time()+ 6000,'/'); // expires after 60 seconds
	// echo "<script> location.href='dashboard.php?email=$email'; </script>";
}
?>
