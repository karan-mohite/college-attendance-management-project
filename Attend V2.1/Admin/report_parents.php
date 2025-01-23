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
        <a class="nav-link " href="batchAttendance.php">Practical Attendance</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="faculty_registration.php">Faculty Registration</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manageBatch.php">Manage Batch</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="report_parents.php">Report_to_Parents</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link " aria-current="page" href="attendence_report.php">Attendence Report</a>
      </li> -->
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

  <h5 class="text-center mt-2"> Daily Report</h5>

  <?php
  $query = "SELECT DISTINCT division,year,dept,semester,s_rollno,l_rollno  FROM `all_classes` ORDER BY year DESC , division ASC";
  $result = mysqli_query($conn, $query);

  ?>

  <!-- Subject Attendance -->
  <div id="sub" class="">
    <form class="row g-2 needs-validation col-md-6 mx-auto d-flex align-items-center" action="" method="get">
      <div class="col-md-11 mt-3">
        <label for="validationCustom01" class="form-label">Select: Department | Semester | Division | Year </label>
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
          //   echo " <input type='text' name='dept' id='dept' hidden value='$row[dept]'>";
          //   echo " <input type='text' name='semester' id='semester' hidden value='$row[semester]'>";
          //   echo " <input type='text' name='division' id='division' hidden value='$row[division]'>";
          //   echo " <input type='text' name='year' id='year' hidden value='$row[year]'>";
        }

        ?>
      </div>
      <div class="col-1">
        <input class="btn btn-primary" type="submit" name="get_details"></input>
      </div>
    </form>
    <!-- End of Semester Attendance -->



    <!-- New Report Container -->
    <?php
    if (isset($_GET['get_details'])) {
      // echo "get_details";
      $unique_id = $_GET['className'];
      $str = explode(" ", $unique_id);
      $dept = $str[0];
      $semester = $str[1];
      $division = $str[2];
      $year = $str[3];
      $s_rollno = $_GET['s_rollno'];
      $l_rollno = $_GET['l_rollno'];
      global $hours;
      global $total_hours;
    ?>

      <table class='table text-center table-striped ' id='dataTable'>
        <thead>
          <tr>
            <th style="width: 100%;" colspan="100%" class='text-center  mt-3'> <?php echo $_GET['className'] ?></th>
          </tr>
          <tr>
            <th scope='col'>ROll NO</th>
            <th scope='col'>Name</th>
            <th scope='col'>Hours</th>
            <th scope='col'>Send Report</th>
          </tr>
        </thead>
        <tbody>
        <?php
        for ($i = $s_rollno; $i <= $l_rollno; $i++) {
          $total_hours = 0;
          $hours = 0;
          $query_0 = "SELECT * FROM `student_details` WHERE division = '$division' and semester = $semester and year=$year and department = '$dept' and rollNo =$i ;";
          $result_0 = mysqli_query($conn, $query_0);
          $row_studName = mysqli_fetch_assoc($result_0);

          // Classes Calculation
          $query_1 = "SELECT * FROM `all_classes` WHERE division = '$division' and semester = $semester and year=$year and dept = '$dept' and s_rollno <=$i and l_rollno >= $i;";
          $result_1 = mysqli_query($conn, $query_1);
          while ($row = mysqli_fetch_assoc($result_1)) {
            // echo $row['className'];

            $query_check = "SELECT * FROM `$row[className]` where date ='" . date("Y-m-d") . "' order by id desc";
            $result_check = mysqli_query($conn, $query_check);
            // echo mysqli_num_rows($result);

            $num_row = mysqli_num_rows($result_check);
            while ($num_row > 0) {
              $total_hours += 1;
              $num_row--;
            }

            while ($row_check = mysqli_fetch_assoc($result_check)) {
              // echo $row["s1"];
              if ($row_check["s$i"] == "Present") {
                $hours += 1;
              }
            }
          }

          // Practical Calculation
          $query_2 = "SELECT * FROM `all_batches` WHERE division = '$division' and semester = $semester and year=$year and department = '$dept' and s_rollno <=$i and l_rollno >= $i;";
          $result_2 = mysqli_query($conn, $query_2);
          while ($row = mysqli_fetch_assoc($result_2)) {
            // echo $row['batchName'];


            $query_check = "SELECT * FROM `$row[batchName]` where date ='" . date("Y-m-d") . "' order by id desc";
            $result_check = mysqli_query($conn, $query_check);
            $num_row = mysqli_num_rows($result_check);
            while ($num_row > 0) {
              $total_hours += 2;
              $num_row--;
            }
            // echo mysqli_num_rows($result);
            while ($row_check = mysqli_fetch_assoc($result_check)) {

              // echo $row["s1"];
              if ($row_check["s$i"] == "Present") {
                $hours += 2;
              }
            }
          }

          echo "
    <tr>
    <td>$i</td>
    <td>$row_studName[name]</td>
    <td>$hours / $total_hours</td>
    ";
          if ($hours < $total_hours) {
            $absent_hours = $total_hours - $hours;
            $absent_hours = $absent_hours <= 1 ? $absent_hours . " hour" : $absent_hours . " hour`s";
            $curr_date = date("Y-m-d");
            echo " <td> <a target='_blank' href='https://wa.me/91$row_studName[parents_no]?text=Hi, %0a*$row_studName[name]*, %0awas absent *$absent_hours* out of *$total_hours hour`s* lecture. %0a*Date:* $curr_date %0a%0a%0a*This is System Generated Message*,%0a*Don`t Reply to this message.*  '><i style='font-size: 30px;' class='fa-brands fa-whatsapp' ></i> </a> </td>";
          } else {
            echo " <td> <i style='font-size: 30px;' class='fa-brands fa-whatsapp'></i></td>";
          }
          echo "
    </tr>
    ";
        }
      }

        ?>


        <!-- End of New Report Container -->
  </div>
  <!-- End of Attendance Report Container -->


  <?php
  require("../Templete/footer.html")
  ?>