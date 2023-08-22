<?php 
include '../inc/header.php';
include '../inc/admin_nav.php';

?>

<?php

	include '../lib/Dsw.php';
	$user = new Dsw();

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
		$hallS = $std->hallReques($_POST);
	
	}	
	$req = $user->getStudentSort();
	
	?>

<div class="container" style="padding-top:30px;">
		<div class="row">
			<?php ?>
			<div class="col-md-12">
				<div class="row" style="padding:20px;">
				<div class="col-sm-11">
					<h4 style="float:left;">Addmisson </h4>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						
						<select class="form-control" name="first" onchange="showData(this.value)">
							<option selected>Select Department</option>
							<option value="CSE">CSE</option>
							<option value="ME">ME</option>
							<option value="EEE">EEE</option>
							<option value="CE">CE</option>
							<option value="TE">TE</option>
							<option value="MME">MME</option>
							<option value="IPE">IPE</option>
							<option value="ARCH">ARCH</option>
							<option value="CFE">CFE</option>
							
						</select>
					</div>
					
				</div>
				</div>
				
				

				<div class="table-responsive">


					<table id="mytable" class="table table-bordred table-striped">

						<thead>

							<th>Studnet ID</th>
							<th>Student Name</th>
							<th>Department</th>
							<th>Year</th>
							<th>CGPA</th>
							<th>Action</th>
						</thead>
						<tbody id="txtHint">
						<?php foreach($req as $data) { ?>

							<tr>
							
								<td><?php echo $data['student_id'] ?></td>
								<td><?php echo $data['firstname']." ".$data['lastname'] ?></td>
								<td><?php echo $data['department'] ?></td>
								<td><?php echo $data['running_year'] ?></td>
								<td><?php echo $data['CGPA'] ?></td>
								
								<td><a name=""  href='../DSW/requestDetails.php?id=<?php echo $data['student_id']; ?>'><button type="submit" name="" class="btn btn-primary">view</button></a></td>
							</tr>
						<?php } ?>

							




						</tbody>

					</table>

					<div class="clearfix"></div>

				</div>

			</div>
		</div>
	</div>


	<script>
function showData(str) {
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
    xmlhttp.open("GET","getUser.php?dept="+str,true);
    xmlhttp.send();
  }
}
</script>

<?php 
include '../inc/footer.php';
?>