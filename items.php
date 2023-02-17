<?php
include('includes/header.php'); 
include('functions/list_of_functions.php');
$conn = databaseConnect();



if(isset($_POST['saveData'])){
	$fields = array('name' => '');
	
	$f_string = 'status_id, ';
	$value_string = '1, ';
	foreach ($fields as $f => $x){
		$f_string .= $f . " ";
			$value_string .= "'" . $_POST[$f] . "' ";
	}
		
	$sql = "INSERT into jf_departments (".$f_string.") VALUES (".$value_string.")";
	if (mysqli_query($conn, $sql)) {
	  // $last_id = mysqli_insert_id($conn);
	  // echo "New record created successfully. Last inserted ID is: " . $last_id;
	} else {
	  // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	echo "<script> location.href='departments.php'; </script>";
}
	


?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <a href="users.php" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-lists"></i>Lists Item</a>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-fw fa-plus-circle"></i> New Item</button>
                    

					<!-- Modal -->
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">New Item</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form method="POST">
								<div class="modal-body">
									<table class="table-sm" cellspacing="0" role="grid" style="width: 100%;">
										<tr>
											<td>Prduct Name</td>
											<td><input type="name" name="name" class="form-control"></td>
										</tr>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
									<input type="submit" name="saveData" class="btn btn-primary btn-sm" value="Save Data">
									
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
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
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
                                        <?php echo getLists('jf_products'); ?>
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
