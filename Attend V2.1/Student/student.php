<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();
if (isset($_POST['email'])) {

  // print_r($_SESSION);

  $email = $_POST['email'];
  $pass = $_POST['password'];
  $query = "Select * from student_details where email = '$email' and password = '$pass'";
  $result = mysqli_query($conn, $query);
  //   if($result){
  //     echo "Hello";
  //   }
  $row = mysqli_fetch_assoc($result);
  //  $row['phone'];
  if ($row['email'] == $email && $row['password'] == $pass) {
    $_SESSION['student_mob'] = $row['mobile_no'];
    // print_r($_SESSION);






  } else {
    header("location: ../index.php");
  }
}
if (!(isset($_SESSION['student_mob']))) {
  // echo "Helllo";
  header("location: ../index.php");
}
else{
  $query = "Select * from student_details where mobile_no = $_SESSION[student_mob]";
  $result = mysqli_query($conn, $query);
  //   if($result){
  //     echo "Hello";
  //   }
  $row = mysqli_fetch_assoc($result);
  $s_rollno = 's' . $row['rollNo'];
  $Stud_ROllNo = $row['rollNo'];
  $department = $row['department'];
  $semester = $row['semester'];
  $division = $row['division'];
  $year = $row['year'];

 // echo $query = "SELECT * FROM `all_classes` WHERE division = '$division' and semester = $semester and year=$year and dept = '$department' ";
 $query = "SELECT * FROM `all_classes` WHERE division = '$division' and semester = $semester and year=$year and dept = '$department' and s_rollno <=$row[rollNo] and l_rollno >= $row[rollNo];";
 $result3 = mysqli_query($conn, $query);
 global $lecture_attendance;
 $i=0;
 while ($row = mysqli_fetch_assoc($result3)) {
    $className = $row['className'];
    $s_rollno;

   $query = "select $s_rollno from " . $className . " where $s_rollno = 'Present'";
   $result = mysqli_query($conn, $query);

   if ($result) {
     $row_count = mysqli_num_rows($result);
     $query1 = "select $s_rollno from $className";
     $result1 = mysqli_query($conn, $query1);
     $total_rows = mysqli_num_rows($result1);
     if($total_rows>0){
       $lecture_attendance = ($lecture_attendance + ($row_count / $total_rows) * 100);
       $i++;
     }
     
     }
     
 }
 // echo $i -= 1;
 if($i>0){
  $lecture_attendance = $lecture_attendance/$i;
 }

 // New Practical Attendance Count
 $query = "SELECT DISTINCT division,year,department,semester,practicalName from `all_batches` where semester = '$semester' and year = '$year' and division='$division' and department = '$department' order by batch ASC, practicalName ASC, division ASC;";
 $result = mysqli_query($conn,$query);
 $pract_count = 0;
 $pract_attend = 0;
 while($row = mysqli_fetch_assoc($result)){
     
     $practicalName = $row['practicalName'];


 $query1 = "SELECT * from `all_batches` where semester = '$semester' and year = '$year' and division='$division' and department = '$department' and practicalName= '$row[practicalName]' order by batch ASC, practicalName ASC, division ASC ;";
   $result1 = mysqli_query($conn,$query1);
   // echo mysqli_num_rows($result1);
   $attendance1 = 0;
   while($row1 = mysqli_fetch_assoc($result1)){
     if($Stud_ROllNo <= $row1['l_rollno'] && $Stud_ROllNo >= $row1['s_rollno']){
       $pract_count++;
       $s_rollno = $row1['s_rollno'];
      $l_rollno = $row1['l_rollno'];
      $batchName = $row1['batchName'];
       $row['practicalName'];

     // echo "<tr><td colspan=100%>$row1[batchName]</td></tr>";
     
       // $attendance1 = 0;
       // $j = 0;
       $rollno = 's' . $Stud_ROllNo;
     $query2 = "select * from `$batchName` where $rollno = 'Present';";
     $result2 = mysqli_query($conn,$query2);
     if ($result2) {
         $row_count = mysqli_num_rows($result2);
       $query4 = "select $rollno from $batchName";
       $result4 = mysqli_query($conn, $query4);
       $total_rows = mysqli_num_rows($result4);
       if ($total_rows > 0) {
         $attendance1 = ($attendance1 + ($row_count / $total_rows) * 100);
       }
     }
     // echo " $attendance1 %";
   }
 }
  $pract_attend += $attendance1;
}
// echo "Practical Count : $pract_count  and Practical attendance is: $pract_attend </br> Avererage Practical Attendance is: ".($pract_attend/$pract_count); 
if($pract_attend > 0){
$pract_attend = $pract_attend/$pract_count;
}
else{
 $pract_attend = 0;
}
 $attendance = ($lecture_attendance +($pract_attend))/2;
}
?>


<!-- NavBar -->
<nav class=" navbar-expand-lg  navbar bg-dark border-bottom border-body" data-bs-theme="dark"">
        <div class=" container-fluid">
  <a class="navbar-brand" href="#">PGMCOE Attendance</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
      <!-- <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li> -->
    </ul>
  </div>
  </div>
</nav>
<!-- End of Navbar -->

<!-- Main Container -->
<div class="container col-sm-6 col-12  mt-5 border p-2 rounded shadow m-2 mx-auto">
  
<?php
   $query = "Select * from student_details where mobile_no = $_SESSION[student_mob] ";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  echo "<h5 class=' mt-2'> Welcome, $row[name]</h5>";

  if (isset($attendance)) {
    echo "<h5 class='text-center mt-3'>Your attendance </br>in   this semester is: " . floor($attendance) . " %</h5>
    <h6 class='text-center mt-3'> Lecture Average: ".floor($lecture_attendance)."% and Practical Average: $pract_attend %</h6>";
    if(floor($attendance)<75){
      echo "<h5 class='text-center text-danger'>You are Defaulter.</h5>";
    }
    else{
      echo "<h5 class='text-center text-success'>Congratulations you are not Defaulter.</h5>";
    }
  }
  ?>
  <h6 class="text-center">Your attendance is: <?php echo $attendance."%"; ?></h6>
 




</div>










<?php

require("../Templete/footer.html")
?>