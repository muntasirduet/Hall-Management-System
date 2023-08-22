



<div class="container-fluid">
	<div class="row" style= "">
		<div class="col-md-12">
			<nav class="navbar navbar-expand-lg navbar-light bg-light " style="background-color: #333A40  !important; ">
				 
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="navbar-toggler-icon"></span>
				</button> 
				<a href="../admin.php"><strong><span class="navbar-brand" href="#" style="color: #019DE0 !important;">
					
					<?php 
						$user_ro = Session::get("user_role");
						if($user_ro == 1){
							echo "DSW";
						}
						else if($user_ro == 3){
							echo "Student";
						}
						else{
							echo "Provost";
						}
					?>
				</span></strong></a>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="navbar-nav">
						<li class="nav-item">
							<div class="">
								<?php 
        							$checkUser = Session::get("user_role");
        							if ($checkUser == 3) {

      							?>

      							<?php 
      								$a = Session::get("hall_status");
        							if( $a == "Accepted"){ 
      							?>
      							<a href="../student/hallRequest.php"><button type="button" class="btn btn-outline-success">Status</button></a>
      							<a href="../student/seatRequest.php"><button type="button" class="btn btn-outline-success">Req. for Seat</button></a>


      							<?php 
        							} else { 

      							?>
      							<a href="../student/hallRequest.php"><button type="button" class="btn btn-outline-success">Req. for Hall</button></a>

      							<?php 
        							}

      							?>
      							
  									
  									<button type="button" class="btn btn-outline-success">Profile</button>
  								<?php
        							} else if($checkUser == 1){
      							?>
      							<span onclick="btn1()"><a href="../student/ReqStudent.php"><button id = "one"  type="button" class="btn btn-outline-success" >Admit Request</button></a></span>
      							<a href="../student/RegularStudent.php"><button id = "two" onclick="btn2()" type="button" class="btn btn-outline-success">Running Studnet</button></a>
      							<a href="../DSW/request.php"><button type="button" class="btn btn-outline-success">Hall Request</button></a>
  								<a href="../DSW/room.php"><button type="button" class="btn btn-outline-success">HALL</button></a>
  								
  								<a href="../DSW/provost.php"><button type="button" class="btn btn-outline-success">Provost</button></a>



      							<?php
       								} else{ 
      							?>	

      							<a href="../provost/addmisson.php"><button type="button" class="btn btn-outline-success">Addmisson</button></a>

      							<a href="../provost/showStudent.php"><button type="button" class="btn btn-outline-success">Student</button></a>

      							<a href="../provost/showRoom.php"><button type="button" class="btn btn-outline-success">Show Room</button></a>

      							<a href="../provost/seat.php"><button type="button" class="btn btn-outline-success">Add New Seat</button></a>

								<a href="../provost/addmisson.php"><button type="button" class="btn btn-outline-success">Profile</button></a>






      							<?php
       								} 
      							?>
							</div>
						</li>
						
					</ul>
					
					<span class="navbar-nav ml-md-auto btn-group">
						<a href="?action=logout"><button type="button" class="btn btn-outline-success">Logout</button></a>
						
							
					</span>
				</div>
			</nav>
		</div>
		
	</div>
</div>

<script type="text/javascript">
	
</script>




