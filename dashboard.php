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
	<div class="col-md-8">
	<?php
		$d = '';
		
		if ($dashboard->num_rows > 0){
			$i = 1;
			while($row = $dashboard->fetch_assoc()){
				$react = 'react_' .$row['id'] ;
				$comment = 'comment_' .$row['id'] ;
				$last_id = $row['id'];
				$d .= '
					<div class="card shadow" id="'.$last_id.'">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">' .strtoupper($row['title']).'<br/><small>'.$row['firstname'] . ' ' . $row['lastname'].' | '.date('F j, Y', $row['dateadded']).'</small></h6>
						</div>
						<div class="card-body">
							<input value="'.$row['id'].'" id="div_'.$react.'" hidden>
							<input value="'.$row['id'].'" id="div_'.$comment.'" hidden>
				';
				
							//GET ATTCHEMENTS
							$attachment_sql = "SELECT *FROM jf_feedattachments WHERE feed_id = " . $row['id'] . " ORDER BY filetype DESC";
							$attachments = $conn->query($attachment_sql);
							$image= '<div class="row">';
							$files= '';
							while($att = $attachments->fetch_assoc()) {
								if (strpos($att['filetype'], 'image') !== false) {
									$image .= '
										<div class="col-md-6">
											<center><img src="data:image/png;base64, '.$att['imagebase64'].'" alt="'.$att['filename'].'" width="90%"/></center>
										</div>
									';
								}else{
									//Check if the file is pdf so the browser can preview
									$pdf = strpos($att['filename'], 'pdf');
									if($pdf === false){
										//OTher file Type
										$files .= '
											
											<a href="uploads/'.$att['filename'].'" target="_blank"><i class="fa fa-download"></i> Click Here to download</a><br/>';
									}else{
										$files .= '<a href="uploads/'.$att['filename'].'" target="_blank"><i class="fa fa-download"></i> Click Here to view</a><br/>';
									}										
								}
							}
							$image .= '</div>';
							$d .= $image . '<br/>' . $row['content'] .'<small>Attachments</small><br/>
							'. $files . '<br/>';
							
							//COUNT THE NUMBER OF REACT
							$sql = "SELECT *FROM jf_feedreacts WHERE feed_id = ".$row['id'];
							$result = $conn->query($sql);
							if ($result->num_rows == 0) {
								$total = '';
							}else{
								$total = $result->num_rows;
							}
							
							//CHECK IF THE LOGGED USER ALREADY LIKE THE POST
							$sql = "SELECT *FROM jf_feedreacts WHERE feed_id = ".$row['id'] . " AND employee_id = " . $_COOKIE['id'];
							$result = $conn->query($sql);
							if ($result->num_rows == 0) {
								$color = ' blue';
							}else{
								$color = ' red';
							}
								
							$d .='
								<hr/>
								<div id="'.$react.'">
									<i class="fas fa-fw fa-heart" onclick="addReaction(\''.$react.'\');" style="color: '.$color.'; font-size: 18px;"></i>&nbsp;'.$total.'&nbsp;<small>Reaction</small><br/>
									
								</div>
								
								
								<div class="row">								
									<div class="col-md-12">
										<small>Comments</small><br/>
										<br/>
										<div id="'.$comment.'">
							';
											$sql2 = "SELECT f.*, e.lastname, e.firstname, f.id as fid
												FROM jf_feedcomments as f
												LEFT JOIN jf_employees as e ON e.id = f.employee_id
												WHERE feed_id = " . $row['id'] . " ORDER BY dateadded ASC
											";
											$result2 = $conn->query($sql2);

											while($row2 = $result2->fetch_assoc()) {
												$commentd = 'cid_' . $row2['id'];
												$d .= '
													<input value="'.$row2['id'].'" id="'.$commentd.'" hidden>
													<div class="row">
														<div class="col-md-12">
															<table class="table no-border">
																<tr>
																	<td style="width: 100px; padding-top: 30px;">
																		<img class="img-profile rounded-circle img" style="width: 50px;" src="img/undraw_profile.svg">
																	</td>
																	
																	<td style="padding-left: 10px;">
												';
																		$class = $commentd . " " . $comment;
																		if($_COOKIE['id'] == $row2['employee_id']){
																			$d .= '<i class="fa fa-trash" aria-hidden="true" style="font-size: 14px;" onclick="confirmf(\''.$class.'\');">';
																		}
																		
																		$name = '';
																		if($row2['employee_id'] != 0){
																			$name = $row['firstname'] . ' ' . $row['lastname'];
																		}else{
																			$sql_intern = "SELECT *FROM jf_interns WHERE id = " . $row2['intern_id'];
																			$intername = $conn->query($sql_intern);

																			if($intername->num_rows > 0){
																				while($intname = $intername->fetch_assoc()) {
																					$name = $intname['firstname'] . ' ' . $intname['lastname'];
																				}
																			}
																		}
															$d .= '
																		</i> '.$row2['comment'].'<br/><small>'.$name.'<br/>'.date('F j, Y H:i A', $row2['dateadded']).'</small>
																	</td>
																</tr>
															</table>
														</div>
													</div>
													
												';
											}
							$d .= '
										</div>
									</div>									
									<div class="col-md-12">
										<table style="width: 100%;">
											<tr>
												<td style="width: 90%; padding-right: 10px;">
													<textarea name="comment" class="form-control" placeholder="Add Comment" id="input_'.$comment.'"></textarea>
												</td>
												<td style="width: 10%;">
													<button class="btn btn-primary" onclick="addComment(\''.$comment.'\');" id="'.$comment.'"> Add</button>
												</td>
											</td>
										</table>											
									</div>
								</div>
								
						</div>
					</div>
					<br/>
				';
				$i++;
			}
		}else{
			// $d = 'Empty';
		}
		echo $d;
		
		$count = $count + 5;
		if($total_feed->num_rows > 5 &&  $i <= $total_feed->num_rows){
			echo '<a href="dashboard.php?count='.$count.'">Load More</a>';
		}
	?>
	</div>
	
<?php
//TIME LOG QUERY
$sql = "SELECT *FROM jf_timelogs WHERE date = '".date('Y-m-d')."' AND employee_id = " . $employee_id;
$result = $conn->query($sql);
$result_number = $result->num_rows;

?>
    <!-- TIme In  -->
    <div class="col-md-4">
        <div class="card shadow">
		<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Time Log</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<table class="table">
					<tr>
						<td>Time In</td>
						<td>
							<div id="timein">
							<?php
								$result = $conn->query($sql); 
								if($result->num_rows == 0){
									echo '<button class="btn btn-sm btn-primary" onclick="timein();">Time In</button>';
								}else{
									while($row = $result->fetch_assoc()) {										
										if(empty($row['timein'])){
											echo '<button class="btn btn-sm btn-primary" onclick="timein();">Time In</button>';
										}else{
											if(!empty($row['timein'])){
												echo date('h:i A', strtotime($row['timein']));
											}																	
											if($row['late'] > 0){
												echo '<br/><small>' . $row['late'] . ' minutes late</small>';
											}
										}	
									}													
								}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>Lunch In</td>
						<td>
							<div id="lunchin">
							<?php
								$result = $conn->query($sql); 
								if($result_number > 0){
									$time = '2022-09-08 12:30:00';
									while($row = $result->fetch_assoc()) {
										if(!empty($row['timein']) && empty($row['lunchin'])){
											if($row['timein'] < '12:00:00'){
												echo '<button class="btn btn-sm btn-primary" onclick="lunchin();">Lunch In</button>';
											}
										}else{
											if(!empty($row['lunchin'])){
												echo date('h:i A', strtotime($row['lunchin']));
											}
										}
									}														
								}													
								?>
							</div>
						</td>
					</tr>
					<tr>
						<td>Lunch Out</td>
						<td>
							<div id="timeout">
							<?php
								$result = $conn->query($sql); 
								if($result_number > 0){
									while($row = $result->fetch_assoc()) {
										if(!empty($row['lunchin']) && empty($row['lunchout'])){
											echo '<button class="btn btn-sm btn-primary" onclick="lunchout();">Lunch Out</button>';
										}else{
											if(!empty($row['lunchout'])){
												echo date('h:i A', strtotime($row['lunchout']));
											}
										}
									}														
								}													
							?>													
							</div>
						</td>
					</tr>
					<tr>
						<td>Time Out</td>
						<td>
							<div id="timeout">
							<?php
								$result = $conn->query($sql); 
								if($result_number > 0){
									while($row = $result->fetch_assoc()) {
										if(!empty($row['timeout'])){
											echo date('h:i A', strtotime($row['timeout']));
										}elseif((!empty($row['lunchout']) && empty($row['timeout']))){
											echo '<button class="btn btn-sm btn-primary" onclick="timeout();">Time Out</button>';
										}elseif(!empty($row['timein']) && ((($row['timein'] > '12:00:00')))){
											echo '<button class="btn btn-sm btn-primary" onclick="timeout();">Time Out</button>';
										}
									}														
								}													
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Remarks</label>
							<?php
								$result = $conn->query($sql);
								if($result_number > 0){
									while($row = $result->fetch_assoc()) {
										echo '<textarea name="remarks" id="remarks" class="form-control" onchange="saveRemarks();">'.$row['remarks'].'</textarea>';		
									}
								}else{
									echo '<textarea name="remarks" id="remarks" class="form-control" onchange="saveRemarks();"></textarea>';		
								}
							?>
						</td>
					</tr>
					<?php
					
					
					?>
					<tr>
						<td colspan="2">
							<?php
								$sql_log = "
									SELECT t.*, e.*, e.id as eid, t.id as tid
									FROM jf_timelogs as t
									LEFT JOIN jf_employees as e ON e.id = t.employee_id
									WHERE timeout IS NULL AND date != '".date('Y-m-d')."' AND timein IS NOT NULL AND employee_id = ".$_COOKIE['id']." ORDER BY t.date DESC";
								$logs = $conn->query($sql_log);
								if($logs->num_rows > 0){
									echo '<center><small>Some of your logs are incomplete. <a href="my_time_logs.php?action=notimeout"><br/> Click Here </a> to view details</a></center>';
								}
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<br/>
		<div class="card shadow">
		<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Today's Logs</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body table-responsive">
				<?php echo getLogs('jf_timelogs', 'jf_employees', 'employee_id'); ?>
			</div>
		</div>
		
		<br/>
		<div class="card shadow">
		<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Intern's Logs</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body table-responsive">
				<?php echo getLogs('jf_internlogs', 'jf_interns', 'intern_id'); ?>
			</div>
		</div>
		
		<br/>
		<div class="card shadow">
		<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Notes</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<?php echo getNotes('dashboard', date('Y-m-d'), date('Y-m-d'), 'All', 0, 'employee_id', 'jf_employees'); ?>
			</div>
		</div>
		
		<br/>
		<div class="card shadow">
		<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Notes - Interns</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<?php echo getNotes('dashboard', date('Y-m-d'), date('Y-m-d'), 'All', 0, 'intern_id', 'jf_interns'); ?>
			</div>
		</div>
	</div>        
</div>   
</div><br/>
<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>	
<script type="text/javascript">
function saveRemarks(){
    var remarks = document.getElementById("remarks").value;
	// console.log(remarks);
	$.ajax({
		async: false,
		url: 'saveData.php',
		type: 'post',
		data: { 
			cmdType : 'saveRemarks',
			remarks : remarks,
			table: 'jf_timelogs',
		},
		success:function(response){
			console.log(response);
			window.location.href = window.location.href;
		}				
    });
}       	

function timein(){
	saveData('timein');
}
function timeout(){
	saveData('timeout');
}
function lunchin(){
	saveData('lunchin');
}
function lunchout(){
	saveData('lunchout');
}

function saveData(action){
	$.ajax({
		async: false,
		url: 'saveData.php',
		type: 'post',
		
		data: { 
			cmdType : action,
			table: 'jf_timelogs',
		},
		success:function(response){
			console.log(response);
			window.location.href = window.location.href;
			// $('#timein').html(data);
			// $('#timein').empty();
			// $('#timein').append('Time In');
		}				
    });
}

function runningTime() {
  $.ajax({
    url: 'timeScript.php',
    success: function(data) {
       $('#runningTime').html(data);
     },
  });
}

function addReaction(divname){
	var divname = divname;
	var div = '#' + divname;
	$(div).empty();
	
	var div_id = 'div_' + divname;
	var id = document.getElementById(div_id).value;
	
	saveFeed(div, id, 'react', '');
}

function addComment(divname){
	var divname = divname;
	
	var inputname = 'input_' + divname;
	var input = document.getElementById(inputname).value;

	var div_id = 'div_' + divname;
	var id = document.getElementById(div_id).value;
	
	var div = '#' + divname;
	$(div).empty();
	
	saveFeed(div, id, 'comment', input);
	document.getElementById(inputname).value = '';
}

function confirmf(divname){
	if (confirm("Are you sure you want to delete you comment?")) {
		const classname = divname.split(" ");
		
		var id = document.getElementById(classname[0]).value;
	
		var div = '#' + classname[1];
		var input = '';
		
		$(div).empty();
		
		console.log(id);
		saveFeed(div, id, 'delete', input);
	}
}

function saveFeed(div, id, action, data){
	$.ajax({
		async: false,
		url: 'saveData.php',
		type: 'post',
		data: { 
			cmdType : 'saveFeed',
			action : action,
			data : data,
			field : 'employee_id',
			id : id,
		},
		success:function(response){
			// console.log(response);
			var data = JSON.parse(response);
			$(div).append(data[0]);
			
		}				
    });
}


</script>
