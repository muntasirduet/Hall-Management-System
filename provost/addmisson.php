<?php 
include '../inc/header.php';
include '../inc/admin_nav.php';

?>

<?php

	include '../lib/Provost.php';
	$provost = new Provost();

	//if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
		//$hallS = $std->hallReques($_POST);
	
	//}	
	$id = Session::get('id');
	$add = $provost->getProvostById($id);
	$hall = $add['hallName'];
	$req = $provost->getStudentByHall($hall);

	
	?>

<div class="container" style="padding-top:30px;">
		<div class="row">
			<?php ?>
			<div class="col-md-12">
				<div class="row" style="padding:20px;">
				<div class="col-sm-11">
					<h4>Addmisson </h4>

				</div>
				<hr>


				<div class="col-sm-4">
					

					<div class="form-group">
						<div class="row">
							<div class="col-md-9">
								<input class="form-control" name="second" id="s_val" onchange="" placeholder="Search by ID">
							</div>

							<div class="col-md-3">
								<button class="btn btn-outline-success pull-left" onclick="showData()">Search</button>
							</div>

						</div>
						
						
						
							
					</div>
					
				</div>
				</div>
				
				

				<div class="table-responsive">


					<table id="mytable" class="table table-bordred table-striped">

						<thead>

							<th>Studnet ID</th>
							
							<th>Hall Name</th>
							<th>Status</th>
							<th>Action</th>
						</thead>
						<tbody id="txtHint">
						<?php foreach($req as $data) { ?>
							<?php if($data['status'] == 'pending'){  ?>
							<tr>
							
								<td><?php echo $data['student_id'] ?></td>
								<td><?php echo $data['hallName'] ?></td>
								<td><button class="btn btn-outline-warning"><?php echo $data['status'] ?></button></td>

								
								
								<td><a name=""  href='../provost/student.php?id=<?php echo $data['student_id']; ?>'><button type="submit" name="" class="btn btn-primary">view</button></a></td>
							</tr>
							<?php } ?>
						<?php } ?>

							




						</tbody>

					</table>

					<div class="clearfix"></div>

				</div>

			</div>
		</div>
	</div>


	<script>
function showData() {
	var str = document.getElementById("s_val").value;
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getStudent.php?id="+str,true);
    xmlhttp.send();
  }
}
</script>

<?php 
include '../inc/footer.php';
?>