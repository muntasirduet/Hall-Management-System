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
	$req = $provost->getRoomNumber($hall);

	
	?>

<div class="container" style="padding-top:30px;">
		<div class="row">
			<?php ?>
			<div class="col-md-12">
				<div class="row" style="padding:20px;">
				<div class="col-sm-11">
					<h4>Show Room Wise Student</h4>

				</div>
				<hr>


				<div class="col-md-12">
					

					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<select class="form-control" name="second" id="" onchange="showData(this.value)" placeholder="Search by ID">
									<option selected>Select Floor</option>
									<?php foreach ($req as $key) { ?>
										<option value="<?php echo $key['roomNumber'] ?>"><?php echo $key['roomNumber'] ?></option>
									<?php }?>
									
								</select>
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
						
						</thead>
						<tbody id="txtHint">
						

							




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
    xmlhttp.open("GET","getRoomDetails.php?room="+str,true);
    xmlhttp.send();
  }
}
</script>

<?php 
include '../inc/footer.php';
?>