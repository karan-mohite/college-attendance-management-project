<?php
require("./Server/config.php");
require("./Templete/header.html");

if (isset($_POST['SemAttend_submit'])) {

   $s_rollno = 's' . $_POST['s_rollno'];
   $department = $_POST['department'];
   $semester = $_POST['semester'];
   $division = $_POST['division'];
   $year = $_POST['year'];

  // echo $query = "SELECT * FROM `all_classes` WHERE division = '$division' and semester = $semester and year=$year and dept = '$department' ";
  $query = "SELECT * FROM `all_classes` WHERE division = '$division' and semester = $semester and year=$year and dept = '$department' and s_rollno <=$_POST[s_rollno] and l_rollno >= $_POST[s_rollno];";
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
      if($_POST['s_rollno'] <= $row1['l_rollno'] && $_POST['s_rollno'] >= $row1['s_rollno']){
        $pract_count++;
        $s_rollno = $row1['s_rollno'];
       $l_rollno = $row1['l_rollno'];
       $batchName = $row1['batchName'];
        $row['practicalName'];

      // echo "<tr><td colspan=100%>$row1[batchName]</td></tr>";
      
        // $attendance1 = 0;
        // $j = 0;
        $rollno = 's' . $_POST['s_rollno'];
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

  // End of New Practical Attendance Count
}

if (isset($_POST['attend_submit'])) {
  // echo "Get request";
  $className = $_POST['className'];
  $rollNo = 's' . $_POST['s_rollno'];

  $query = "select $rollNo from " . $className . " where $rollNo = 'Present'";
  $result = mysqli_query($conn, $query);
  global $attendance;
  if ($result) {
    $row_count = mysqli_num_rows($result);

    $query1 = "select $rollNo from $className";
    $result1 = mysqli_query($conn, $query1);
    $total_rows = mysqli_num_rows($result1);
    if($row_count>0){
    $attendance = ($row_count / $total_rows) * 100;
    }
    else{
      $attendance = "";
    }
  }
} else {
  // echo "Not a get request";
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
        <a class="nav-link " aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="view_attendance.php">View Attendance</a>
      </li>
      <!-- <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li> -->
    </ul>
  </div>
  </div>
</nav>

<!-- End of Navbar -->

<div class="container mt-4 text-center">
  <h5>Student Portal</h5>
</div>
<!-- Attendance Form -->

<div class="container col-sm-6 col-12  mt-5 border p-2 rounded shadow m-2 mx-auto">


<?php
$query = "SELECT * FROM all_classes order by year desc , division asc, semester asc, dept asc , className asc";
$result = mysqli_query($conn, $query);

if(isset($_POST['SemAttend_submit'])){
  echo "<a href='view_attendance.php'><i class='ms-5 fa-solid fa-backward'></i></a>";
  if (isset($attendance)) {
    echo "<h5 class='text-center mt-3'>Your attendance </br>in   $_POST[semester] semester is: " . floor($attendance) . " %</h5>
    <h6 class='text-center mt-3'> Lecture Average: ".floor($lecture_attendance)."% and Practical Average: $pract_attend %</h6>";
    if(floor($attendance)<75){
      echo "<h5 class='text-center text-danger'>You are Defaulter.</h5>";
    }
    else{
      echo "<h5 class='text-center text-success'>Congratulations you are not Defaulter.</h5>";
    }
  }
}
if(isset($_POST['attend_submit'])){
  echo "<a href='view_attendance.php'><i class='ms-5 fa-solid fa-backward'></i></a>";
  if (isset($attendance)) {
    echo "<h5 class='text-center mt-3'>Your attendance in <br> $_POST[className] Subject is: " . floor($attendance) . " %</h5>";
  }
}

if(!(isset($_POST['attend_submit'])) && !(isset($_POST['SemAttend_submit']))){
?>
  <select name="formType" class="form-select" id="select">
    <option selected checked disabled value="">Select Option</option>
    <option value="1">Specific Subject</option>
    <option value="2">Semester Attendance</option>
    <!-- <option value="3">Detailed Report</option> -->
  </select>
  <?php } ?>
<hr>
  <!-- Subject Attendance -->
  <div id="sub" class="" style="display: none;">
    <form class="row g-2 needs-validation col-md-6 mx-auto" action="" method="post">
      <div class="col-md-12 mt-3">
        <label for="validationCustom01" class="form-label">Select Subject eg.<b> WT_CO_A_24</b></label>
        <!-- <input type="text" class="form-control" id="validationCustom01" name="className" placeholder="Sub_CO_Div_Year " required> -->
        <select class="form-select" name="className" id="validationCustomUsername" required>
          <option selected disabled value="">Choose...</option>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $class = $row['className'];
            echo " <option value='$class'>$class</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-12  ">
        <label for="validationCustom03" class="form-label">RollNo</label>
        <input type="number" class="form-control" id="validationCustom03" name="s_rollno" placeholder="eg. 1" autocomplete="off" required>
      </div>
      <div class="col-12">
        <input class="btn btn-primary" type="submit" name="attend_submit"></input>
      </div>
    </form>
  </div>
  <!-- End of Semester Attendance -->

  <div id="sub1" class="" style="display: none;">
    <form class="row g-2 needs-validation col-md-6 mx-auto" action="" method="POST">
      <div class="col-md-12">

      </div>
      <div class="col-md-12  ">
        <label for="validationCustom03" class="form-label">RollNo</label>
        <input type="number" class="form-control" id="validationCustom03" name="s_rollno" placeholder="eg. 1" autocomplete="off" required>
      </div>
      <div class="col-md-12  ">
        <label for="validationCustom03" class="form-label">Year</label>
        <input type="number" class="form-control" id="validationCustom03" name="year" placeholder="eg. 24" autocomplete="off" required>
      </div>
      <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Department</label>
        <select class="form-select" name="department" id="validationCustomUsername" required>
          <option selected disabled value="">Choose...</option>
          <option value="CO">CO</option>
          <option value="AI">AI</option>
          <option value="IT">IT</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Semester</label>
        <select class="form-select" name="semester" id="validationCustom02" required>
          <option selected disabled value="">Choose...</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Division</label>
        <select class="form-select" name="division" id="validationCustomUsername" required>
          <option selected disabled value="">Choose...</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
        </select>
      </div>
      <div class="col-12">
        <input class="btn btn-primary" type="submit" name="SemAttend_submit"></input>
      </div>
    </form>
  </div>
</div>


<!-- Credits -->
<!-- <div class="container mx-auto w-100 ">
    <p class="text-center mt-5 ">Made by 
</BR> <b><a target="_blank" href="https://adimore96.github.io/adimore.in/">Aditya More.</a></b> 
</BR><b><a target="_blank" href="https://www.linkedin.com/in/umesh-chimane-07b005250/">Umesh Chimane.</a></b>
</br><b><a target="_blank" href="https://www.linkedin.com/in/sahil-babar-10820a202/">Sahil Babar.</a></b></p>
    
</div> -->
<!-- End of Credits -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
  $("#select").change(function() {
    sub = document.getElementById("sub");
    sub1 = document.getElementById("sub1");
    if ($(this).val() == 1) {
      sub.style.display = 'block';
      sub1.style.display = 'none';
      console.log("you pressed one");
    } else if ($(this).val() == 2) {
      sub.style.display = 'none ';
      sub1.style.display = 'block ';
    } else if ($(this).val() == 3) {
      sub.style.display = 'none';
      sub1.style.display = 'none';
    }
    console.log("you changed the value");
  });
</script>
<script>
  window.onpageshow = function(event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === 'back_forward') {
        location.reload();
    }
};
</script>
<?php
require("./Templete/footer.html")
?>