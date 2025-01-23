<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();
// print_r($_SESSION);
if (!(isset($_SESSION['teacher_mob']))) {
  echo "Helllo";
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
        <a class="nav-link " aria-current="page" href="teacher.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " aria-current="page" href="practicalBatches.php">Practical-Batches</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="view_attend.php">Attendence Report</a>
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


<!-- Defaulter List Collaps -->
<div class="container " style="display: inline;">

  <h3 class="text-center mt-5">Attendance List</h3>
  <?php
  $query = "select * from `all_classes` where tid = " . $_SESSION['teacher_mob'] ." order by year desc , division asc, semester asc, dept asc , className asc";
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    // echo $row['className']."</br>";
    $id = 'collapseWidthExample' . $row['id'];
    $start_rollno = $row['s_rollno'];
    $last_rollno = $row['l_rollno'];

  ?>
    <p class="text-center mt-3">
      <button class='btn btn-primary ' type='button' data-bs-toggle='collapse' data-bs-target='<?php echo "#" . $id ?>' aria-expanded='false' aria-controls='collapseWidthExample'>
        <?php echo  $row['className'] ?>
      </button>
    </p>
    <div style='min-height:2px ;' class='container'>
      <div class='collapse ' id='<?php echo $id ?>'>
        <table class='table text-center table-striped'>
          <thead>
            <tr>
              <th scope='col'>ROll NO</th>
              <th scope='col'>Attend</th>
              <th scope='col'>Total Days</th>
              <th scope='col'>Percentage</th>
            </tr>
          </thead>
          <tbody>
            <?php

            while ($start_rollno <= $last_rollno) {
              $roll = "s$start_rollno";

              $query1 = "select * from `$row[className]` ";
              $result1 = mysqli_query($conn, $query1);
              $counter = 0;
              $present = 0;
              while ($row1 = mysqli_fetch_assoc($result1)) {
                if ($row1[$roll] == 'Present') {
                  $present++;
                }
                $counter++;
              }
              if ($counter > 0) {
                $precentage = round(($present / $counter) * 100);
              }
              else{
                $precentage =0;
              }

              echo "
      <tr>
        <th scope='row'> $start_rollno </th>
        <td> $present</td>
        <td> $counter</td>
        <td> $precentage % </td>
      </tr>
    ";

              $start_rollno++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php
  }
  ?>

</div>













<?php
require("../Templete/footer.html")
?>