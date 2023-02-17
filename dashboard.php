<?php
if(empty($_COOKIE['id'])){
	echo "<script> location.href='dashboard_intern.php'; </script>";
}

$employee_id =  $_COOKIE['id'];
include('includes/header.php');
include('functions/list_of_functions.php');
$conn = databaseConnect();

if(empty($_GET['count'])){
	$count = 5;
	$limit = ' LIMIT 5';
}else{
	$count = $_GET['count'];
	$limit = ' LIMIT ' . $count;
}

//FEED QUERY
$sql2 = "
	SELECT f.*, f.id as id, e.firstname, e.lastname
	FROM jf_feeds as f
	LEFT JOIN jf_employees as e ON e.id = f.user_id	
	ORDER BY id DESC " .$limit;
$dashboard = $conn->query($sql2);

$total_feed_sql = "SELECT *FROM jf_feeds ";
$total_feed = $conn->query($total_feed_sql);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<!-- Content Row -->


<div class="row">
	
	

       
</div>   
</div>   
</div><br/>
<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>	
<script type="text/javascript">


</script>
