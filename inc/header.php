
<?php 
  $filepath = realpath(dirname(__FILE__));
  
  include_once $filepath.'/../lib/Session.php';
  //include 'lib/Warehouse.php';

  Session::init();

  if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
  }

  Session::checkSession();

?>


<!doctype html>
<html lang="en">
  <head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <title>HALL</title>




  </head>

<body>
