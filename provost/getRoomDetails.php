<?php
$q = ($_GET['room']);

  

$con = mysqli_connect('localhost','root','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"HALL_MANAGEMENT_SYSTEM");
$sql="SELECT * FROM selectRoom WHERE roomNumber = '".$q."' ";
$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['student_id'] . "</td>";
  
  echo "<td>" . $row['hallName'] . "</td>";
  
  echo "</tr>";
  
}
mysqli_close($con);
?>