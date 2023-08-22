<?php
    include 'inc/login_header.php';
?>

<?php 

    include 'lib/User.php';
    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
        $userAuth = $user->userAuthentication($_POST);
    }
?>

<div style="">
    

<div class="login-form" style="padding-top: 90px;" >
	 <?php if (isset($userAuth)) {
                echo $userAuth;
            } ?>
    <form action="" method="post">
        <h2 class="text-center">User Login</h2>       
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="signin" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="#" class="pull-right">Forgot Password?</a>
        </div>        
    </form>
</div>
</div>
<style type="">
    body{
        background-image: url('img/duet.jpeg');background-repeat: no-repeat;background-attachment: fixed;
  background-size: cover;
    }
</style>
<?php
    include 'inc/footer.php';

?>