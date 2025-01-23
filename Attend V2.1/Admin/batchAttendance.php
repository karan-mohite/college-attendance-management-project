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
        <a class="nav-link active" href="batchAttendance.php">Practical Attendance</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="faculty_registration.php">Faculty Registration</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manageBatch.php">Manage Batch</a>
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
<h5 class="text-center mt-2"> Practical Attendance</h5>

  <?php
  $query = "SELECT DISTINCT division,year,department,semester  FROM `all_batches` ORDER BY year DESC , division ASC";
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
            echo $row['department'];
            echo $class = $row['department'] . " " . $row['semester'] . " " . $row['division'] . " " . $row['year'];
            echo " <option value='$class'>$class</option>";
          }
          ?>
        </select>
        <?php
        $query = "SELECT DISTINCT division,year,department,semester,s_rollno,l_rollno  FROM `all_batches` ORDER BY year DESC , division ASC, batch ASC , practicalName ASC";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo " <input type='text' name='s_rollno' value='$row[s_rollno]' hidden> ";
        // while ($row = mysqli_fetch_assoc($result)) {
          echo " <input type='text' name='l_rollno' value='$row[l_rollno]' hidden> ";
        // }

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
  if(isset($_GET['attend_submit'])){
  $unique_id = $_GET['className'];
  $str = explode(" ", $unique_id);
  $dept = $str[0];
  $semester = $str[1];
  $division = $str[2];
  $year = $str[3];
  $s_rollnoM = $_GET['s_rollno'];
  $l_rollnoM = $_GET['l_rollno'];
?>
 <div class='container'>
    <table class='table text-center table-striped' id='dataTable'>
      <thead>
        <tr>
          <th style="width: 100%;" colspan="100%" class='text-center  mt-3'> <?php echo $_GET['className'] ?></th>
        </tr>
        <tr>
          <th scope='col'>ROll NO</th>
          <!-- <?php
           $query = "SELECT DISTINCT division,year,department,semester,practicalName from `all_batches` where semester = '$semester' and year = '$year' and division='$division' and department = '$dept' order by batch ASC, practicalName ASC, division ASC;";
           $result = mysqli_query($conn,$query);
           while($row = mysqli_fetch_assoc($result)){
             echo "<th scope='col'>$row[practicalName] </th>";
           }
          ?> -->
          <th scope='col'>Percentage</th>
        </tr>
<?php
  $query = "SELECT DISTINCT division,year,department,semester,practicalName from `all_batches` where semester = '$semester' and year = '$year' and division='$division' and department = '$dept' order by batch ASC, practicalName ASC, division ASC;";
  $result = mysqli_query($conn,$query);
  while($row = mysqli_fetch_assoc($result)){
      $practicalName = $row['practicalName'];
    //  $s_rollno = $row['s_rollno'];
    //  $l_rollno = $row['l_rollno'];
    // echo $batchName = $row['batchName'];
    // echo "</br>";
    ?>
   
          
<?php
    $query1 = "SELECT * from `all_batches` where semester = '$semester' and year = '$year' and division='$division' and department = '$dept' and practicalName= '$row[practicalName]' order by batch ASC, practicalName ASC, division ASC ;";
    $result1 = mysqli_query($conn,$query1);
    // echo mysqli_num_rows($result1);
    while($row1 = mysqli_fetch_assoc($result1)){
       $s_rollno = $row1['s_rollno'];
       $l_rollno = $row1['l_rollno'];
       $batchName = $row1['batchName'];
        $row['practicalName'];

      echo "<tr><td colspan=100%>$row1[batchName]</td></tr>";
      for ($i = $s_rollno; $i <= $l_rollno; $i++) {
        $attendance = 0;
        $j = 0;
        $rollno = "s" . $i;
      $query2 = "select * from `$batchName` where $rollno = 'Present';";
      $result2 = mysqli_query($conn,$query2);
      if ($result2) {
          $row_count = mysqli_num_rows($result2);
        $query4 = "select $rollno from $batchName";
        $result4 = mysqli_query($conn, $query4);
        $total_rows = mysqli_num_rows($result4);
        if ($total_rows > 0) {
          $attendance = ($attendance + ($row_count / $total_rows) * 100);
        }
      }

      
       
      echo "<tr><td>$i</td> <td> $attendance %</td></tr> ";
    }
  }
  
}
echo " </tbody>
</table>
<button id='dwnldBtn' class='btn btn-success'>
Download Excel Sheet
</button>
</div>";


  }
    ?>



    <script>
      $(document).ready(function() {
        $('#dwnldBtn').on('click', function() {
          $("#dataTable").table2excel({
            filename: "studAttendance.xls"
          });
        });
      });
    </script>

    <?php
    require("../Templete/footer.html")
    ?>