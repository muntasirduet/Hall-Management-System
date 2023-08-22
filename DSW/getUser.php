<?php
$q = ($_GET['dept']);

$con = mysqli_connect('localhost','root','');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"HALL_MANAGEMENT_SYSTEM");
$sql="SELECT * FROM student  WHERE hallStatus = 'pending' and department = '".$q."'";
$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['student_id'] . "</td>";
  echo "<td>" . $row['firstname'] ." ".$row['lastname']. "</td>";
  echo "<td>" . $row['department'] . "</td>";
  echo "<td>" . $row['running_year'] . "</td>";
  echo "<td>" . $row['CGPA'] . "</td>";
  echo "<td>" ."<a href='../DSW/requestDetails.php?id=".$row['student_id']." '><button class = 'btn btn-info'>View</button></a>". "</td>";
  echo "</tr>";
}
mysqli_close($con);
?>