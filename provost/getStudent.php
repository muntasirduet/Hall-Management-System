<?php
$q = ($_GET['id']);

$con = mysqli_connect('localhost','root','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"HALL_MANAGEMENT_SYSTEM");
$sql="SELECT * FROM uniqueHall  WHERE  status = 'pending' and student_id = '".$q."'";
$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['student_id'] . "</td>";
  
  echo "<td>" . $row['hallName'] . "</td>";
  echo "<td><button class = 'btn btn-outline-success'>" . $row['status'] . "</button></td>";
  echo "<td> <a href='../provost/student.php?id=".$row['student_id']." '><button class = 'btn btn-info'>View</button></a></td>";
  echo "</tr>";
}
mysqli_close($con);
?>