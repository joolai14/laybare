<?php
include('functions/list_of_functions.php');
if(isset($_POST['cmdType'])){
    $cmdType = $_POST['cmdType'];

    if($cmdType == "getData"){
		$action = new myaction();
		$id = $_POST['id'];
        $result = $action->getData($id);  
		echo json_encode($result);
    }
}

class myaction {
	
	public function getData($id){
		$conn = databaseConnect();
		//FETCH DATA
		$result = $conn->query("SELECT *FROM jf_products where id = " . $id);
		$d = '<table class="table">';
			while($row = $result->fetch_assoc()) {	
				$d .= '<tr>';
					$d .= "<th>ID</th>";
					$d .= "<td>".$row['id']."</td>";
				$d .= '</tr>';
				$d .= '<tr>';
					$d .= "<th>Name</th>";
					$d .= "<td>".$row['Name']."</td>";
				$d .= '</tr>';
				$d .= '<tr>';
					$d .= "<th>Description</th>";
					$d .= "<td>".$row['Description']."</td>";
				$d .= '</tr>';
				$d .= '<tr>';
					$d .= "<th>Price</th>";
					$d .= "<td>".$row['Price']."</td>";
				$d .= '</tr>';
				$d .= '<tr>';
					$d .= "<th colspan='2'><a href='products.php?id=".$row['id']."&update=1' class='btn btn-primary'><i class='fa fa-edit' aria-hidden='true'></i> Update</a></th>";
				$d .= '</tr>';
			}
		$d .= "</table>";
		return $d;
	}
}