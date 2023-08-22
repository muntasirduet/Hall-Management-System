<?php 
include '../inc/header.php';
include '../inc/admin_nav.php';

?>

<?php

include '../lib/Student.php';
$std = new Student();
$uHall = $std->getHallById($_SESSION['id']);
$hall = $uHall['hallName'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
	$hallS = $std->setRoomChoice($_POST,$hall,$_SESSION['id']);
	
}	

$result = $std->getAllRoomByHall($hall);
$choice = $std->getSeatChoiceById($_SESSION['id']);
$roomChoice = $std->getRoomSeat($_SESSION['id']);





?>

<form action="" method="POST">
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					<h4 class="modal-title custom_align" id="Heading">Choice Room</h4>
				</div>
				<div class="modal-body">
					<?php 
					if (isset($hallS)){
						echo $hallS;
					}



					?>

					
					
					<input type="hidden" name="student_id" id="pd" value="<?php echo $_SESSION['id']?>">
					
					<div class="form-group">
						<label class="control-lebel">First Choice</label>
						<select class="form-control" name="first" aria-label="Default select example">
							<option selected>Select Room</option>
							<?php foreach($result as $data) {

								?>
								<option value="<?php echo $data['roomNumber']?> "><?php echo $data['roomNumber']?> - <?php echo $data['totalSeat'] - $data['currentSeat'] ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<label class="control-lebel">Second Choice</label>
						<select class="form-control" name="second" aria-label="Default select example">
							<option selected>Select Room</option>
							<?php foreach($result as $data) {

								?>
								<option value="<?php echo $data['roomNumber']?> "><?php echo $data['roomNumber']?> - <?php echo $data['totalSeat'] - $data['currentSeat'] ?> </option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label class="control-lebel">Third Choice</label>
						<select class="form-control" name="third" aria-label="Default select example">
							<option selected>Select Room</option>
							<?php foreach($result as $data) {

								?>
								<option value="<?php echo $data['roomNumber']?> "><?php echo $data['roomNumber']?> -<?php echo $data['totalSeat'] - $data['currentSeat'] ?> </option>
							<?php } ?>
						</select>
					</div>

					
					
				</div>
				<div class="modal-footer ">
					<button type="submit" name="signup" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
				</div>
			</div>
			<!-- /.modal-content --> 
		</div>
		<!-- /.modal-dialog --> 
	</div>
</form>



<div class="container" style="padding-top:30px;">
	<div class="row">
		<?php 
					if (isset($hallS)){
						echo $hallS;
					}



					?>
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
					<h4 style="float:left;">Choose Room</h4>
				</div>
				<div class="col-sm-1">
					<button type="button" id="abb" class="btn btn-primary float-end" data-toggle="modal" data-target="#edit">Create
					</button>
				</div>
			</div>



			<div class="table-responsive">


				<table id="mytable" class="table table-bordred table-striped">

					<thead>

						<th>First Choice</th>
						<th>Second Choice</th>
						<th>Third Choice</th>
						<th>Hall Name</th>
						<th>Status</th>

					</thead>
					<tbody>
						
						<tr>
							
							<td><?php echo $choice['firstChoice'] ?></td>
							<td><?php echo $choice['secondChoice'] ?></td>
							<td><?php echo $choice['thirdChoice'] ?></td>
							<td><?php echo $choice['hallName'] ?></td>
							<?php if($choice['status'] == 'pending') {

								?>
								<td><button class="btn btn-xs btn-outline-warning">Pending</button></td>

							<?php  } else if($choice['status'] == 'Accepted') { ?>
								<td><button class="btn btn-xs btn-outline-info">Accepted</button></td>

							<?php } ?>



						</tr>
						<?php ?>






					</tbody>

				</table>

				<div class="clearfix"></div>

			</div>

		</div>
	</div>


	<div class="card">
		<div class="card-header">
			<h3><strong>Congratulation's </strong> <?php echo $_SESSION['id']?></h3>
		</div>
		<div class="card-body">
			<blockquote class="blockquote mb-0">
				<p>You are selected for ROOM	-	<strong><?php echo $roomChoice['roomNumber']?></strong></p>
				<footer class="blockquote-footer">Please Meetup account section. <cite title="Source Title"></cite></footer>
			</blockquote>
		</div>


</div>


<?php 
include '../inc/footer.php';
?>