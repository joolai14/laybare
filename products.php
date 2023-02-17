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

	// echo "<script> location.href='products.php'; </script>";
}
	


?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<a href="users.php" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-lists"></i>Products</a>
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
											<td><input type="decimal" name="Price" class="form-control" onchange="checkIfNumber();" id="Total" required></td>
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
													// echo '<a href="feed_management.php?id='.$row['id'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>';
													echo '<a href="products.php?id='.$row['id'].'&update=1"><i class="fa fa-view" aria-hidden="true"></i></a>&nbsp;&nbsp;';
													echo '<a href="products.php?id='.$row['id'].'&update=1"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;';
													echo "<small><a href='delete_record.php?id=".$row['id']."&table=jf_peoducts&redirect=products.php' onclick='return confirm(\"Are you sure you want to submit this data?\");'><i class='fa fa-trash' aria-hidden='true'></i></a></small>";
												echo '</td>';
											echo '</tr>';
										}
									?>
                                    </tbody>
                                </table>
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

</script>