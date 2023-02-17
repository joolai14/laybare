<?php
include('includes/header.php'); 
include('functions/list_of_functions.php');
$conn = databaseConnect();

if(empty($_GET['datefrom'])){
	$datefrom = date('Y-m-d');
}else{
	$datefrom = $_GET['datefrom'];
} 

$options = 'employee';


$condition = ' ';
if(empty($_GET['employee_id']) || $_GET['employee_id'] == 'All'){
	$employee_id = 'All';
}else{
	$options = 'employee';
	$employee_id = $_GET['employee_id'];
	$condition .= ' AND e.id = ' . $employee_id;
}

$sql = "
	SELECT er.*, e.firstname, e.lastname, e.id as eid
	FROM jf_employeereports as er
	LEFT JOIN jf_employees as e ON e.id = er.employee_id
	WHERE date = '".$datefrom . "' " . $condition . "
	ORDER BY employee_id ASC, started DESC, id DESC
";

$array = array('timein' => 'Time In', 'lunchin' => 'Lunch In', 'lunchout' => 'Lunch Out', 'timeout' => 'Time Out');


if(isset($_POST['filterTimelogs'])){	
	$datefrom = date('Y-m-d', strtotime($_POST['datefrom']));
	$employee_id = $_POST['employee_id'];
	
	echo "<script> location.href='daily_reports.php?datefrom=".$datefrom."&employee_id=".$employee_id."'; </script>";
}/*elseif(isset($_POST['Acknowledge'])){	
	$datefrom = date('Y-m-d', strtotime($_POST['date']));
	$employee_id = $_POST['employee_id'];
	
	$sql = "UPDATE jf_employeereports SET checked = 1 WHERE employee_id = " . $employee_id . " AND date = '".$datefrom."'";
	mysqli_query($conn, $sql);
	echo "<script> location.href='daily_reports.php?datefrom=".$datefrom."'; </script>";
}*/

?>

<div class="container-fluid">
	<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">New message</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input class="modal-title_eid" id="modal-title_eid" hidden>
					<input class="modal-title_date" id="modal-title_date" hidden>
					<input class="modal-title_string" id="modal-title_string" hidden>
					<div class="report_holder" id="report_holder" >
						Test123
					</div>
				</div>
				<!--<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Send message</button>
				</div>-->
			</div>
		</div>
	</div>
	
	<?php
	$sql = "SELECT e.id as eid, e.*, d.name as dname FROM jf_employees as e LEFT JOIN jf_departments as d ON d.id = e.department_id ORDER BY firstname ASC";
	$employees = $conn->query($sql);
	
	
	$content = '';
	if(empty($_GET['date'])){
		$date = date('Y-m-d');
	}else{
		$date = date('Y-m-d', strtotime($_GET['date']));
	}
	
	
	$prev = date('Y-m-d', strtotime('-1 month',  strtotime($date)));
	$next = date('Y-m-d', strtotime('+1 month',  strtotime($date)));
	
	$first_day = date('Y-m-01', strtotime($date));
	$date = $first_day;
	$last_day =  date('Y-m-t', strtotime($date));

	$days = array(0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday');
			
	$month = date('F', strtotime($date));
	
	$content .= "
		<div class='table-responsive'>
		<caption class='calendar-controls'>
						<a href='daily_reports.php?date=".$prev."' class='arrow_link previous' title='Previous month' data-year='2021' data-month='1'><span class='arrow'>◄</span></a>
						<span class='hide'> | </span>
						<span class='current'>
							<a href='daily_reports.php' title='This month'><a href='daily_reports.php?date=".date('Y-m-d', strtotime($date))."' title='This month'>".date('F Y', strtotime($date))."</a>
						</span>
						<span class='hide'> | </span>
						<a href='daily_reports.php?date=".$next."' class='arrow_link next' title='Next month' data-year='2021' data-month='3'><span class='arrow'>►</span></a>
					</caption>
		<table class='table table-bordered table-striped' style='width: 99%; align: center; background-color: white; border-radius: 3px;'>
			
			
			<tr>
				<td colspan='7' style='padding: 5px; text-align: center; font-size: 12px;'><b><a href='daily_reports.php?date=".date('Y-m-01')."' class='arrow_link next'>Current Month</a></td>
			</tr>
	";
	
	$content .=	"
			<tr>";
				foreach ($days as $d){
					$content .= "<th style='width: 14%; font-size: 12px; background-color: beige; padding: 7px;'>".$d."</th>";
				}
	$content .=  "
			</tr>";
	$content .=  "
			<tr>";
				while($date <= $last_day){
					$sd = date('Y-m-d', strtotime($date));
					if(date('l', strtotime($date)) == 'Sunday'){
						$content .= "
								</tr>
								<tr>
						";
					} 
					
					$content .= "<td>";
						$content .= "
									<div class='row'>
										<div class='col-md-1'>
											<div class='date_number'>
											<span class='label label-gray date_label'>". date('d', strtotime($date))."</span></a>
										</div>
										
										<div class='col-md-11'>
						";
											//CHECK IF THERE'S A RECORD ON THAT DAY
											$sql_reports = "SELECT *FROM jf_employeereports WHERE date = '$sd'";
											$total_report = $conn->query($sql_reports);
											if($total_report->num_rows > 0){
												$employees = $conn->query($sql);
												while($e = $employees->fetch_assoc()) {
													//CHECK IF THE REPORT OF THE EMPLOYEE WAS CHECKED 
													$sql_reports_emp = "SELECT *FROM jf_employeereports WHERE date = '$sd' AND employee_id = " . $e['id'] . " and checked = 0";
													$check_report = $conn->query($sql_reports_emp);
													
													// echo $check_report->num_rows . '<br/>';
													if($check_report->num_rows > 0){
														$st = '<i class="fa fa-times-circle" aria-hidden="true"></i>';
														$color = 'red';
													}else{
														$st = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
														$color = 'gray';
													}
													$string_date = $e['eid'].','.$sd.','.$e['firstname'].' '.$e['lastname'];
													$id2 = $e['eid'].'_'.$sd;
													$content .= '<button type="button" class="btn btn-blk" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$string_date.'" style="font-size: 10px; background: transparent; border: 0; padding: 0; width: 100px; text-align: center; color: '.$color.'"><div id="'.$id2.'">'.$st . ' ' . $e['firstname'].'</div></button>';
												} 
											}
						$content .= "
										</div>
									</div>
						";


					$content .= "</td>";
					$i++; 
					$cols = 7 - ($i%7);
					$date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
				}					
				
	if($cols != 0){
		$content .= "
				<td colspan='".$cols."'>&nbsp;</td>
			</tr></table></div>
		";
	}else{
	$content .= "
			</tr></table></div>";
	}
				
	echo $content;  
	?>
</div>
</div>

<?php include('includes/footer.php'); ?>

<script type="text/javascript">
$('#exampleModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var recipient = button.data('whatever') // Extract info from data-* attributes
	// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	var modal = $(this)
  
	originalString = recipient;
    separatedArray = originalString.split(',');
	
	var id = separatedArray[0];
	var date = separatedArray[1];
	var name = separatedArray[2] + '\n' + separatedArray[1];
	modal.find('.modal-title').text(name)
	modal.find('.modal-body input').val(name);
  
	document.getElementById("modal-title_eid").value = id;
	document.getElementById("modal-title_date").value = date;
	document.getElementById("modal-title_string").value = originalString;
	
	getReport(id,date);
	// modal.find('.report_holder').text(name);
	$("14_2023-01-06").empty();
}) 

function getReport(id,date){
	$.ajax({
		async: false,
		url: 'saveData.php',
		type: 'post',
		data: { 
			cmdType : 'getReport',
			date : date,
			id : id,
		},
		success:function(response){
			// console.log(response);
			var data = JSON.parse(response);
			$('#report_holder').empty();
			$('#report_holder').append(data);
			 
			
		}				
    });
} 

function acknowledgeReport(){
	var id = document.getElementById("modal-title_eid").value;
	var date = document.getElementById("modal-title_date").value;
	var divname = id+'_'+date;
	
	$.ajax({
		async: false,
		url: 'saveData.php',
		type: 'post',
		data: { 
			cmdType : 'acknowledgeReport',
			date : date,
			id : id,
		},
		success:function(response){
			console.log(response);
			var data = JSON.parse(response);
		}				
    });
	
	$("acknowledgetext").empty();
	$("acknowledgetext").append("Report has been checked.");
	console.log(divname); 
}
</script>


