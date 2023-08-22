	<?php 
	include '../inc/header.php';
	include '../inc/admin_nav.php';



	?>

	<?php

	include '../lib/Dsw.php';
	$dsw = new Dsw();

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_provost'])) {
		$provost = $dsw->addNewProvost($_POST);

	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
		$pUpdate = $dsw->updateProvost($_POST);

	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
		$pUpdate = $dsw->deleteProvost($_POST);

	}


	$result = $dsw->getAllHall();
	$allProvost = $dsw->getAllProvost();

	?>


	
	<!-- Modal -->
	<form action="" method="POST">
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add New Provost</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="">
							<div class="">

								

								<!-- Form Name -->


								<!-- Text input-->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="textinput">Provost ID</label>
									<div class="col-sm-9">
										<input type="text" name="provost_id" placeholder="Enter Provost ID" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-5 control-label" for="textinput">Provost Name</label>
									<div class="col-sm-9">
										<input type="text" name="provost_name" placeholder="Enter HALL Name" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="textinput">Hall Name</label>
									<div class="col-sm-9">
										<select class="form-control" name="hall_name" aria-label="Default select example">
											<option selected>Select Hall</option>
											<?php foreach($result as $data) {

												?>
												<option value="<?php echo $data['hallName']?> "><?php echo $data['hallName']?> </option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="textinput">Department</label>
									<div class="col-sm-9">
										<input type="text" name="department" placeholder="Enter Department " class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-5 control-label" for="textinput">Designation</label>
									<div class="col-sm-9">
										<input type="text" name="designation" placeholder="Enter Designation" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-5 control-label" for="textinput">Mobile Number</label>
									<div class="col-sm-9">
										<input type="text" name="m_number" placeholder="Enter Mobile Number" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" for="textinput">Email</label>
									<div class="col-sm-9">
										<input type="email" name="email" placeholder="Enter Email" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="textinput">Password</label>
									<div class="col-sm-9">
										<input type="password" name="pass" placeholder="Enter Password" class="form-control">
									</div>
								</div>







							</div><!-- /.col-lg-12 -->
						</div><!-- /.row -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
						<button type="submit" name="create_provost" class="btn btn-primary">Create</button>
					</div>
				</div>
			</div>
		</div>
	</form>





	<div class="container" style="padding-top:30px;">
		<div class="row">
			<?php 
				if (isset($provost)){
					echo $provost;
				}
				if(isset($pUpdate)){
					echo $pUpdate;
				}


								?>
			<div class="col-md-12">
				<div class="row" style="padding:20px;">
				<div class="col-sm-11">
					<h4 style="float:left;">Show All Provost</h4>
				</div>
				<div class="col-sm-1">
					<button type="button" id="abb" class="btn btn-primary float-end" data-toggle="modal" data-target="#exampleModal">Create
	</button>
				</div>
				</div>
				
				

				<div class="table-responsive">


					<table id="mytable" class="table table-bordred table-striped">

						<thead>

							<th>Provost Name</th>
							<th>HALL NAME</th>
							<th>DESIGNATION</th>
							<th>Department</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<tbody>
						<?php foreach($allProvost as $data) { ?>

							<tr>
							
								<td><?php echo $data['provostName'] ?></td>
								<td><?php echo $data['hallName'] ?></td>
								<td><?php echo $data['Designation'] ?></td>
								<td><?php echo $data['Department'] ?></td>
								<td><?php echo $data['email'] ?></td>
								<td><?php echo $data['mobileNumber'] ?></td>

								<td><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="editP(<?php echo $data['provostId'] ?>)">Edit</button></td>
								<td><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteP(<?php echo $data['provostId'] ?>)" >Delete</button></td>
							</tr>
						<?php } ?>

							




						</tbody>

					</table>

					<div class="clearfix"></div>

				</div>

			</div>
		</div>
	</div>

	<form action="" method="POST">
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					<h4 class="modal-title custom_align" id="Heading">Edit Provost Detail</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="uprovost_id" id="pid" value="">
					<div class="form-group">
						<label class="control-lebel">Name</label>
						<input class="form-control " name="uprovost_name" id="name" value="" type="text">
					</div>
					<div class="form-group">
						<label class="control-lebel">Hall Name</label>
						<input class="form-control " name="uhall_name" id="hname" value="" type="text">
					</div>

					<div class="form-group">
						<label class="control-lebel">Desgnation</label>
						<input class="form-control " name="udesignation" id="des" value="" type="text" placeholder="">
					</div>

					<div class="form-group">
						<label class="control-lebel">Department</label>
						<input class="form-control " name="udepartment" id="dept" value="" type="text" placeholder="">
					</div>

					<div class="form-group">
						<label class="control-lebel">Email</label>
						<input class="form-control " name="uemail" id="email" value="" type="text" placeholder="">
					</div>

					<div class="form-group">
						<label class="control-lebel">Mobile</label>
						<input class="form-control " name="um_number" id="mob" value="" type="text" placeholder="">
					</div>
					
				</div>
				<div class="modal-footer ">
					<button type="submit" name="edit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
				</div>
			</div>
			<!-- /.modal-content --> 
		</div>
		<!-- /.modal-dialog --> 
	</div>
	</form>

	<form action="" method="POST">
		 
	
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					<h4 class="modal-title custom_align" id="Heading">Delete this Record</h4>
				</div>
				<div class="modal-body">

					<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
					<input type="hidden" id="deletePid" name="id" value = "">
				</div>
				<div class="modal-footer ">
					<button type="submit" name="delete" onclick="" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
				</div>
			</div>
			<!-- /.modal-content --> 
		</div>
		<!-- /.modal-dialog --> 
	</div>
	</form>

	<script type="text/javascript">
		function editP(data){
			var value;
			var pname;
			<?php foreach ($allProvost as $key){ ?>

				value = "<?php echo $key['provostId']; ?>";
				if(value == data){
					document.getElementById('pid').value = "<?php echo $key['provostId']; ?>";
					document.getElementById('name').value = "<?php echo $key['provostName']; ?>";
					document.getElementById('hname').value = "<?php echo $key['hallName']; ?>";
					document.getElementById('des').value = "<?php echo $key['Designation']; ?>";
					document.getElementById('dept').value = "<?php echo $key['Department']; ?>";
					document.getElementById('email').value = "<?php echo $key['email']; ?>";
					document.getElementById('mob').value = "<?php echo $key['mobileNumber']; ?>";
				}

				
			<?php  } ?>

			 
		}

		function deleteP(data){
			<?php foreach ($allProvost as $key){ ?>

				value = "<?php echo $key['provostId']; ?>";
				if(value == data){
					document.getElementById('deletePid').value = "<?php echo $key['provostId']; ?>";
					
				}

				
			<?php  } ?>
		}
	</script>

	<?php 
	include '../inc/footer.php';
?>