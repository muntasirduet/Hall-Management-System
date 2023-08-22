<?php 
	include '../inc/header.php';
	include '../inc/admin_nav.php';
	


?>
<?php
  include '../lib/User.php';
  $user = new User();
    
  

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acceptStudent'])) {

    $update = $user->setStudentStatus($_POST);
    echo "<div class='alert alert-success'><strong>Success</strong> Student Request Accepted</div>";
  }

	if (isset($_GET['id'])) {
    $id =  (int)$_GET["id"];
    	$result = $user->getStudentById($id);
    
    	
    }
	
    
?>

<div class="container">
    <div class="main-body">
        <form action="" method="post">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?php echo $result['firstname'] . " ". $result['lastname']?></h4>
                      <p class="text-secondary mb-1"><?php echo $result['department']?></p>
                      <p class="text-muted font-size-sm"><?php echo $result['student_id']?></p>
                      <input type="hidden" name="s_id" value="<?php echo $result['student_id']?>">
                      <div id="acBtn">
                        <?php 
                          if($result['status'] == 1){ 
                         ?>
                      <button id="sub" class="btn btn-outline-success" onclick="Ac" type="submit" name="acceptStudent" >Accept</button>
                      <button class="btn btn-outline-danger">Decline</button>
                        <?php 
                          } else{ 
                        ?>
                          <button class="btn btn-outline-success" disabled>Accepted</button>

                        <?php 
                           }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3" style="padding:20px">
                <div>
                	<h3>Academic Info</h3>
                </div>
                 <hr>
                  <div class="row">
                    <div class="col-sm-9">
                      <h6 class="mb-0">Department</h6>
                    </div>
                    <div class="col-sm-3 text-secondary">
                      <?php echo $result['department']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-9">
                      <h6 class="mb-0">CGPA</h6>
                    </div>
                    <div class="col-sm-3 text-secondary">
                      <?php echo $result['CGPA']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-9">
                      <h6 class="mb-0">Year</h6>
                    </div>
                    <div class="col-sm-3 text-secondary">
                      <?php echo $result['running_year']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-9">
                      <h6 class="mb-0">Semister</h6>
                    </div>
                    <div class="col-sm-3 text-secondary">
                      <?php echo $result['semister']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-9">
                      <h6 class="mb-0">Total Credit</h6>
                    </div>
                    <div class="col-sm-3 text-secondary">
                      <?php echo $result['total_credit']?>
                    </div>
                  </div>
                  <hr>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['email']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Father Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['father_name']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mother Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['mother_name']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">NID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['NID']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Blood Group</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['blood_group']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone Number</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['phone_number']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['address']?>
                    </div>
                  </div>
                  <hr>
                  
                  
              </div>

             
               



            </div>
          </div>
        </form>

        </div>
    </div>



    <script type="text/javascript">
      function Ac(){
        document.getElementById("acBtn").innerHTML = "<button class=\"btn btn-outline-success\">Accepted</button>";
        document.getElementById('sub').submit();
      }
    </script>

<style type="text/css">
	body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
</style>


<?php 
	include '../inc/footer.php';
?>