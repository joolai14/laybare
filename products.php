<?php
include('includes/header.php'); 
include('functions/list_of_functions.php');
$conn = databaseConnect();



if(isset($_POST['saveData'])){
	$sql = "INSERT into jf_products (Name, Description, Price, status) VALUES ('".$_POST['Name']."', '".$_POST['Description']."', ".$_POST['Price'].",1)";
	if (mysqli_query($conn, $sql)) {
	  // $last_id = mysqli_insert_id($conn);
	  // echo "New record created successfully. Last inserted ID is: " . $last_id;
	} else {
	  // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

if(isset($_POST['updateData'])){
	$sql = "UPDATE jf_products SET Name = '".$_POST['Name']."', Description = '".$_POST['Description']."', Price = ".$_POST['Price']." WHERE id = ".$_POST['id']."";
	if (mysqli_query($conn, $sql)) {
		echo '<div class="alert alert-primary" role="alert"> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Changes Saved!</strong>
			</div>';
	} else {
	  // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
	


?>

<!-- Begin Page Content -->
<div class="container-fluid">



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">New Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input class="modal-title_eid" id="modal-title_eid" hidden>
				<div class="data_holder" id="data_holder"></div>
			</div>
		</div>
	</div>
</div>

<!-- Page Heading -->
<a href="products.php" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-sync"></i>&nbsp;Products</a>
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-fw fa-plus-circle"></i> New Product</button>
                    

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">New Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form method="POST">
								<div class="modal-body">
									<table class="table-sm" cellspacing="0" role="grid" style="width: 100%;">
										<tr>
											<td>Product Name</td>
											<td><input type="input" name="Name" class="form-control" required></td>
										</tr>
										<tr>
											<td>Description</td>
											<td>
												<textarea name="Description" class="form-control" required></textarea>
											</td>
										</tr>
										<tr>
											<td>Price</td>
											<td><input name="Price" class="form-control" onchange="checkIfNumber();" id="Total" required></td>
										</tr>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
									<input type="submit" name="saveData" class="btn btn-primary btn-sm" value="Save Data" id="myBtn" disabled>
									
								</div>
								</form>
							</div>
						</div>
					</div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Products</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
								<form method="POST">
								<table class="table table-striped dataTable" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
										if(empty($_GET['update'])){
											$sql = "
												SELECT
												*FROM jf_products ORDER BY Name DESC
												";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc()) {		
												echo '<tr>';
													echo '<td>' . $row['id'] . '</td>';
													echo '<td>' . $row['Name'] . '</td>';
													echo '<td>' . $row['Description'] . '</td>';
													echo '<td>' . $row['Price'] . '</td>';
													// echo '<td>' . $status[$row['status']] . '</td>';
													echo '<td>';
														echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$row['id'].'" style="background: transparent; border: 0; padding: 0; text-align: center; color: #4e73df"><i class="fa fa-eye" aria-hidden="true"></i></button>&nbsp;&nbsp;';
														echo '<a href="products.php?id='.$row['id'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;';
														echo "<small><a href='delete_record.php?id=".$row['id']."&table=jf_peoducts&redirect=products.php' onclick='return confirm(\"Are you sure you want to submit this data?\");'><i class='fa fa-trash' aria-hidden='true'></i></a></small>";
													echo '</td>';
												echo '</tr>';
											}
										}else{
											$sql = "
												SELECT
												*FROM jf_products WHERE id = ".$_GET['id']."
											";
											
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc()) {														
												echo '<tr>';
													echo '<td><input name="id" value="'.$row['id'].'" hidden>' . $row['id'] . '</td>';
													echo '<td><input name="Name" value="'.$row['Name'].'" class="form-control" required></td>';
													echo '<td><input name="Description" value="'.$row['Description'].'" class="form-control" required></td>';
													echo '<td><input name="Price" value="'.$row['Price'].'" class="form-control" onchange="checkIfNumber();" id="Total" required></td>';
													
													echo '<td>';
														echo '<input type="submit" name="updateData" class="btn btn-primary btn-sm" value="Update Data" id="updateButton" >';
														
													echo '</td>';
												echo '</tr>';
												
											}

										}
										
										
									?>
                                    </tbody>
                                </table>
								</form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php include('includes/footer.php'); ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
function checkIfNumber(){
	var string = document.getElementById("Total").value;
	string = parseFloat(string);
	
	if ((typeof string === 'number' && !isNaN(string) && string !== Infinity && string !== -Infinity) || (typeof string === 'string' && /^\-?[0-9]+(e[0-9]+)?(\.[0-9]+)?$/.test(string))) {
		document.getElementById("myBtn").disabled = false;
	}else{
		document.getElementById("myBtn").disabled = true;
		console.log(string);
	}
}

$('#exampleModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var product_id = button.data('whatever') // Extract info from data-* attributes
	// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	var modal = $(this)
	document.getElementById("modal-title_eid").value = product_id;
	
	getData(product_id);
}) 

function getData(id){
	$.ajax({
		async: false,
		url: 'action.php',
		type: 'post',
		data: { 
			cmdType : 'getData',
			id : id,
		},
		success:function(response){
			console.log(response);
			var data = JSON.parse(response);
			$('#data_holder').empty();
			$('#data_holder').append(data);
			 
			
		}				
    });
} 

window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2000);
</script>