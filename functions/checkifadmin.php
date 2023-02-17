<?php
function admin(){
	//CHECK USER ROLE OF USER
	$conn3 = new mysqli('localhost', 'root', '', 'inventory') or die("Connect failed: %s\n". $conn3 -> error);
	$sql = "SELECT *from jf_useraccounts WHERE employee_id = " . $_COOKIE['id'];
	$result = $conn3->query($sql);
	if($result->num_rows < 2){
		return false;
	}else{
		return true;
	}
	
}
?>