<?php 
	include '../inc/header.php';
	include '../inc/admin_nav.php';
	


?>
<?php
  include '../lib/Student.php';
  $user = new Student();
  $result = $user->getReqStudent();
  

    
?>

<div class="container-fluid mt-3">
<div class="row" style="padding:10px;">
        <div class="col-sm-11">
          <h4 style="float:left;">New Student Request</h4>
        </div>

        
</div>
<hr>
  <?php 
      
        foreach($result as $data) {
  ?>

  
  <div class="card text-center" style="width:220px;float: left;margin-right: 10px;">
    <div class="card-body" style="">
      <h4 class="card-title"><?php echo $data['firstname']." <br>".$data['lastname']; ?></h4>
      <p class="card-text">He is a student of <?php echo $data['department']." <br>ID ".$data['student_id']; ?></p>
      <a name="save_rec"  href='../student/edit.php?id=<?php echo $data['student_id']; ?>'><button type="submit" name="save_rec" class="btn btn-primary">See Profile</button></a>
    </div>
  </div>
  <?php 
     } 
  ?>

</div>
<?php 
	include '../inc/footer.php';
?>