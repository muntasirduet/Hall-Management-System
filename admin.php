<?php 
	include './inc/header.php';
	include './inc/admin_nav.php';
	
?>
<?php 
    
  include 'lib/User.php';

  $user = new User();
  $result = $user->getAllStudent();

  $loginMsz = SESSION::get("loginmsz");
  $sta = (int)SESSION::get("login_status");
  if (isset($loginMsz)) {
    echo $loginMsz;
  }

  $loginMsz = SESSION::set("loginmsz", null);
?>

<div class="container-fluid mt-3">
<div class='alert alert-primary'>Show All Student</div>
  <?php 
      $user_ro = Session::get("user_role");
      
      if($user_ro == 1){
        //dsw
        header("Location: student/ReqStudent.php");
        
  ?>

   <?php 
      } else if($user_ro == 2){ 
        //provost
        header("Location: provost/addmisson.php");

        
  ?>

    
	
  
  <?php 
     }  else{ 
      //student
      
      header("Location: student/hallRequest.php");
  ?>

    

    <?php 
      }
    ?>
  
</div>

<?php 
	include 'inc/footer.php';
?>