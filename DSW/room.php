<?php 
include '../inc/header.php';
include '../inc/admin_nav.php';



?>

<?php

include '../lib/Dsw.php';
$user = new Dsw();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
	$hallS = $user->create($_POST);
	
}


	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
		$hUpdate = $user->updateHall($_POST);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
		$hDelete = $user->deleteHall($_POST);

	}

	$hall = $user->getAllHall();


?>


<!-- Modal -->
<form action="" method="POST">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add New HALL</h5>
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
								<label class="col-sm-3 control-label" for="textinput">Hall Name</label>
								<div class="col-sm-9">
									<input type="text" name="hall_name" placeholder="Enter HALL Name" class="form-control">
								</div>
							</div>



							

							
						</div><!-- /.col-lg-12 -->
					</div><!-- /.row -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Show</button>
					<button type="submit" name="signup" class="btn btn-primary">Create</button>
				</div>
			</div>
		</div>
	</div>
</form>


<div class="container" style="padding-top:30px;">
		<div class="row">
			<?php 
				if (isset($hUpdate)){
					echo $hUpdate;
				}
				if(isset($hDelete)){
					echo $hDelete;
				}


								?>
			<div class="col-md-12">
				<div class="row" style="padding:20px;">
				<div class="col-sm-11">
					<h4 style="float:left;">Show All Hall</h4>
				</div>
				<div class="col-sm-1">
					<button type="button" id="abb" class="btn btn-primary float-end" data-toggle="modal" data-target="#exampleModal">Create
	</button>
				</div>
				</div>
				
				

				<div class="table-responsive">


					<table id="mytable" class="table table-bordred table-striped">

						<thead>

							<th>HALL NAME</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<tbody>
						<?php foreach($hall as $data) { ?>

							<tr>
							
								<td><?php echo $data['hallName'] ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								

								<td><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="editP(<?php echo $data['hallID'] ?>)">Edit</button></td>
								<td><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteP(<?php echo $data['hallID'] ?>)" >Delete</button></td>
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
					<input type="hidden" name="hall_id" id="pd" value="">
					<div class="form-group">
						<label class="control-lebel">Hall Name</label>
						<input class="form-control " name="ha_name" id="hall_name" value="" type="text">
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

	<!-- /.modal-delete --> 

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
			
		</div>
		
	</div>
	</form>
	<!-- /.modal-delete --> 
<script type="text/javascript">
	//document.getElementById("bb").style.display = "none";
	

	function editP(data){
			var value;
			var pname;
			<?php foreach ($hall as $key){ ?>

				value = "<?php echo $key['hallID']; ?>";
				if(value == data){
					document.getElementById('hall_name').value = "<?php echo $key['hallName']; ?>";
					document.getElementById('pd').value = "<?php echo $key['hallID']; ?>";
					
				}

				
			<?php  } ?>

			 
		}

		function deleteP(data){
			<?php foreach ($hall as $key){ ?>

				value = "<?php echo $key['hallID']; ?>";
				if(value == data){
					document.getElementById('deletePid').value = "<?php echo $key['hallID']; ?>";
					
				}

				
			<?php  } ?>
		}

</script>

<?php 
include '../inc/footer.php';
?>