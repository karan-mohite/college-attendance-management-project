<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['admin_mob']))) {
  header("location: ../index.php");
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
        <a class="nav-link " href="admin.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="faculty_registration.php">Faculty Registration</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="attendence_report.php">Attendence Report</a>
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

<!-- Attendance Report Container -->
<div class="container col-sm-6 col-12  mt-5 border p-2 rounded shadow m-2 mx-auto">

  <?php
  $query = "SELECT DISTINCT division,year,dept,semester,s_rollno,l_rollno  FROM `all_classes`";
  $result = mysqli_query($conn, $query);

  ?>

  <!-- Subject Attendance -->
  <div id="sub" class="">
    <form class="row g-2 needs-validation col-md-6 mx-auto d-flex align-items-center" action="" method="get">
      <div class="col-md-11 mt-3">
        <label for="validationCustom01" class="form-label">Select Department | Semester | Division | Year </label>
        <!-- <input type="text" class="form-control" id="validationCustom01" name="className" placeholder="Sub_CO_Div_Year " required> -->
        <select class="form-select" name="className" id="validationCustomUsername" required>
          <option selected disabled value="">Choose...</option>
          <?php
          $i = 0;
          // global $s_rollno;
          while ($row = mysqli_fetch_assoc($result)) {
            //  $s_rollno = 
            $class = $row['dept'] . " " . $row['semester'] . " " . $row['division'] . " " . $row['year'];
            echo " <option value='$class'>$class</option>";
          }
          ?>
        </select>
        <?php
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo " <input type='text' name='s_rollno' value='$row[s_rollno]' hidden> ";
          echo " <input type='text' name='l_rollno' value='$row[l_rollno]' hidden> ";
        }

        ?>
      </div>
      <div class="col-1">
        <input class="btn btn-primary" type="submit" name="attend_submit"></input>
      </div>
    </form>
    <!-- End of Semester Attendance -->
  </div>
  <!-- End of Attendance Report Container -->

  <?php
  if (isset($_GET['attend_submit'])) {
  $unique_id = $_GET['className'];
  $str = explode(" ", $unique_id);
  $dept = $str[0];
  $semester = $str[1];
  $division = $str[2];
  $year = $str[3];
  $s_rollno = $_GET['s_rollno'];
  $l_rollno = $_GET['l_rollno'];

  $query1 = "SELECT * FROM `all_classes` WHERE dept = '$dept' and semester = '$semester' and division = '$division' and year = '$year';";


  global $attendance;

  echo "
  <h3 class='text-center mt-3'> $_GET[className] </h3>
  <div class='container'>
  <table class='table text-center table-striped'>
    <thead>
      <tr>
        <th scope='col'>ROll NO</th>
        <th scope='col'>Dept</th>
        <th scope='col'>Semester </th>
        <th scope='col'>Percentage</th>
      </tr>
    </thead>
    <tbody>
  ";
  for ($i = $s_rollno; $i <= $l_rollno; $i++) {
    $j = 0;
    $attendance = 0;
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
      $className = $row1['className'];

      $rollno = "s" . $i;
      $query3 = "select $rollno from $className  where $rollno = 'Present'";
      $result3 = mysqli_query($conn, $query3);

      if ($result3) {
        $row_count = mysqli_num_rows($result3);
        $query4 = "select $rollno from $className";
        $result4 = mysqli_query($conn, $query4);
        $total_rows = mysqli_num_rows($result4);

        $attendance = ($attendance + ($row_count / $total_rows) * 100);
      }
      $j++;
    }
    if ($j > 0) {
      $attendance = floor($attendance / $j);
    }
    // echo "</br></br> Attendance of RollNo $i is: $attendance %</br></br>";
    echo " 
    <tr>
        <th scope='row'>  $i</th>
        <td> $dept </td>
        <td> $semester </td>
        <td> $attendance % </td>
      </tr>
  ";
  }
  echo "
  </tbody>
  </table>
  </div>";
}
?>





  <?php
  require("../Templete/footer.html")
  ?>