<?php 
	include 'inc/login_header.php';
?>


<?php

	include 'lib/User.php';
	$user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
        $usrRegi = $user->userRegistration($_POST);
    }
?>

<div class="container">
    <h2 class="" style="border-bottom: 2px solid green; padding:20px;">Student Registration Form</h2>
      <?php if (isset($usrRegi)) {
                echo $usrRegi;
            } ?>
	<div class="row" style="padding-top:20px;">
		<form action="" method="POST">
			<div class="col-sm-12">
				<div class="row">
							<div class="col-sm-6 form-group">
								<label>First Name</label>
								<input type="text" name="firstname" placeholder="First Name" class="form-control">
							</div>
							<div class="col-sm-6 form-group">
								<label>Last Name</label>
								<input type="text" name="lastname" placeholder="Last Name" class="form-control">
							</div>
						</div>	
						<div class="row">
							<div class="col-sm-6 form-group">
								<label>Father Name</label>
								<input type="text" name="father_name" placeholder="Enter Father Name" class="form-control">
							</div>
							<div class="col-sm-6 form-group">
								<label>Mother Name</label>
								<input type="text" name="mother_name" placeholder="Enter Mother Name" class="form-control">
							</div>
						</div>					
						
						<div class="row">
							<div class="col-sm-4 form-group">
								<label>Student ID</label>
								<input type="text" name="student_id" placeholder="Enter Student ID" class="form-control">
							</div>	
							<div class="col-sm-4 form-group">
								<label>Year</label>
								<input type="text" name="running_year" placeholder="Enter Year" class="form-control">
							</div>	
							<div class="col-sm-4 form-group">
								<label>Semister</label>
								<input type="text" name="semister" placeholder="Enter Semister" class="form-control">
							</div>		
						</div>
						<div class="row">
							<div class="col-sm-4 form-group">
								<label>Department</label>
								<input type="text" name="department" placeholder="Enter Department" class="form-control">
							</div>	
							<div class="col-sm-4 form-group">
								<label>Blood Group</label>
								<input type="text" name="blood_group" placeholder="Enter Blood Group" class="form-control">
							</div>	
							<div class="col-sm-4 form-group">
								<label class="control-lebel">NID</label>
								<input type="text" name="NID" placeholder="Enter NID" class="form-control">
							</div>		
						</div>
						<div class="row">
							<div class="col-sm-6 form-group">
								<label>Password</label>
								<input type="password" name="password" placeholder="Enter Password" class="form-control">
							</div>		
							<div class="col-sm-6 form-group">
								<label>ReType Password</label>
								<input type="password" name="password_check" placeholder="Enter Password" class="form-control">
							</div>	
						</div>	
						<div class="row">
							<div class="col-sm-6 form-group">
								<label>CGPA</label>
								<input type="text" name="CGPA" placeholder="Enter CGPA" class="form-control">
							</div>		
							<div class="col-sm-6 form-group">
								<label>Total Credit</label>
								<input type="text" name="total_credit" placeholder="Enter Total Credit" class="form-control">
							</div>	
						</div>						
					<div class="form-group">
						<label>Phone Number</label>
						<input type="text" name="phone_number" placeholder="Enter Phone Number" class="form-control">
					</div>		
					<div class="form-group">
						<label>Email Address</label>
						<input type="text" name="email" placeholder="Enter Email Address" class="form-control">
					</div>	
					
					<div class="form-group">
							<label>Address</label>
							<textarea name="address" placeholder="Enter Address" rows="3" class="form-control"></textarea>
						</div>	
					<button type="submit" name="signup" class="btn btn-lg btn-info">Submit</button>					
					</div>
				</form> 
				</div>
    <style type="text/css">
@import "font-awesome.min.css";
@import "font-awesome-ie7.min.css";
body {
  padding-bottom: 20px;
}
.form-control{
	border: 1px solid green;
}

.header,
.marketing,
.footer {
  padding-right: 15px;
  padding-left: 15px;
}

.header {
  border-bottom: 1px solid #e5e5e5;
}
.header h3 {
  padding-bottom: 19px;
  margin-top: 0;
  margin-bottom: 0;
  line-height: 40px;
}

/* Custom page footer */
.footer {
  padding-top: 19px;
  color: #777;
  border-top: 1px solid #e5e5e5;
}

@media (min-width: 768px) {
  .container {
    max-width: 730px;
  }
}
.container-narrow > hr {
  margin: 30px 0;
}

.jumbotron {
  text-align: center;
  border-bottom: 1px solid #e5e5e5;
}
.jumbotron .btn {
  padding: 14px 24px;
  font-size: 21px;
}

.marketing {
  margin: 40px 0;
}
.marketing p + h4 {
  margin-top: 28px;
}

@media screen and (min-width: 768px) {
  /* Remove the padding we set earlier */
  .header,
  .marketing,
  .footer {
    padding-right: 0;
    padding-left: 0;
  }
  .header {
    margin-bottom: 30px;
  }
  .jumbotron {
    border-bottom: 0;
  }
}
    </style>


 <?php 
	include 'inc/footer.php';
?>
