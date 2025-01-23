<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['teacher_mob']))) {
    // echo "Helllo";
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
        <a class="nav-link active" aria-current="page" href="practicalBatches.php">Practical-Batches</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_attend.php">Attendence Report</a>
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


<?php
    $t_id = $_SESSION['teacher_mob'];
  $query = "select * from all_batches where tid = ".$t_id ." order by year desc , division asc, semester asc, department asc , batchName asc ;";
  $result = mysqli_query($conn,$query);
  // if($result){
  //   echo $row_count = mysqli_num_rows($result);
  // }

?>

<h5 class="text-center mt-5"> Practical Attendance</h5>
<div class="container d-flex gap-2 mt-5 flex-wrap justify-content-center   ">
  <?php
   
   while($row = mysqli_fetch_assoc($result)){
    $batchName =  $row['batchName']; 
    $s_rollno = $row['s_rollno'];
    $l_rollno = $row['l_rollno'];
    $semester = $row['semester'];
    $dept = $row['department']; 
    $division = $row['division']; 
    ?>
    <!-- Classes  -->
    <div class="card" style="width: 18rem;">
  
  <div class="card-body">
    <h5 class="card-title"><?php echo $batchName ?></h5>
    <p class="card-text"><b>Semester:</b> <?php echo $row['semester']."</br>";?>
    <b>Department:</b> <?php echo $row['department']."</br>";?>
    <b>Division:</b> <?php echo $row['division']."</br>";?>
    <b>Year:</b> <?php echo $row['year']."</br>";?>
  </p>
    <a href=<?php echo "pract_attend.php?table_name=$batchName&semester=$semester&dept=$dept&s_rollno=$s_rollno&l_rollno=$l_rollno&division=$division&attend=true";?> class="btn btn-primary">Take Attendance</a>
  </div>
</div>
 <!-- End of Classes -->

<?php
  }
  ?>


<?php
require("../Templete/footer.html")
?>