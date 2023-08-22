<?php 
include '../inc/header.php';
include '../inc/admin_nav.php';



?>
<?php
include '../lib/Student.php';
$user = new Student();




if (isset($_GET['id'])) {
  $id =  (int)$_GET["id"];
  $result = $user->getStudentById($id);
}
if (isset($_GET['id'])) {
  $id =  (int)$_GET["id"];
  $room = $user->getSeatChoiceById($id);
}

$hallName = $room['hallName'];

$first = $user->getSeat($room['firstChoice']);
$second = $user->getSeat($room['secondChoice']);
$third = $user->getSeat($room['thirdChoice']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['first'])) {
  $std = $user->setStudentSeatStatus($_POST);
  echo $std;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['second'])) {
  $std = $user->setStudentSeatStatus($_POST);  
  //echo $std;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['third'])) {

  $std = $user->setStudentSeatStatus($_POST);
 // echo $std;
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
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="">

            <hr>
            <div class=" text-center">
              <div class="card-header">
                <h3>Select Seat for this student</h3>
              </div>
              <div class="card-body text-center">
                <div class="row " style="" role="group" aria-label="Basic example">


                  <form action="" method="POST">
                    <button type="submit" style="margin:10px;" name="first" class="btn btn-outline-info"><?php echo $room['firstChoice']?> - <?php echo ($first['totalSeat']) - ($first['currentSeat']) ?></button>
                    <input type="hidden" name="room_number" value="<?php echo $room['firstChoice']?>">
                    <input type="hidden" name="std_id" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="hall_name" value="<?php echo $hallName ?>">
                  </form>


                  <form action="" method="POST">
                    <button type="submit" style="margin:10px;" name="second" class="btn btn-outline-success"><?php echo $room['secondChoice']?> - <?php echo ($second['totalSeat']) - ($second['currentSeat']) ?></button>
                    <input type="hidden" name="room_number" value="<?php echo $room['secondChoice']?>">
                    <input type="hidden" name="std_id" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="hall_name" value="<?php echo $hallName ?>">
                  </form>

                  
                  <form action="" method="POST">
                    <button type="submit" style="margin:10px;" name="third" class="btn btn-outline-primary"><?php echo $room['thirdChoice']?> - <?php echo ($third['totalSeat']) - ($third['currentSeat']) ?></button>
                    <input type="hidden" name="room_number" value="<?php echo $room['thirdChoice']?>">
                    <input type="hidden" name="std_id" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="hall_name" value="<?php echo $hallName ?>">
                  </form>
                  
                </div>
              </div>
              <div class="card-footer text-muted">

              </div>
            </div>

          </div>
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