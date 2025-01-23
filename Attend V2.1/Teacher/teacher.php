<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (isset($_POST['email'])) {

  // print_r($_SESSION);

  $email = $_POST['email'];
  $pass = $_POST['password'];
  $query = "Select * from teacher_details where email = '$email' and password = '$pass'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  //  $row['phone'];
  if ($row['email'] == $email && $row['password'] == $pass) {
    $_SESSION['teacher_mob'] = $row['phone'];
    // print_r($_SESSION);
  } else {
    header("location: ../index.php");
  }
}
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
        <a class="nav-link active" aria-current="page" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " aria-current="page" href="practicalBatches.php">Practical-Batches</a>
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


<!-- Modal -->
<div class="container mt-5 mb-5">

  <h5 class="text-center mt-5"> Subject Attendance</h5>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add Class
  </button>
  <!-- Modal  fade-->
  <!-- <div class="modal fade   modal-dialog modal-dialog-centered modal-dialog-scrollable" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
  <div class="modal  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Class</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


          <form class="row g-3 needs-validation" action="./create_class.php" method="get">
            <div class="col-md-6">
              <label for="validationCustom01" class="form-label">Subject Name eg.<b> WT</b></label>
              <input type="text" class="form-control" id="validationCustom01" autocomplete="off" name="className" placeholder="eg. WT " required>
            </div>
            <div class="col-md-6">
              <label for="validationCustom05" class="form-label">Year eg.<b> 24</b></label>
              <input type="number" class="form-control" id="validationCustom05" name="year" placeholder="Year eg. 24 " required>
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
            <div class="col-md-6">
              <label for="validationCustom03" class="form-label">Starting RollNo</label>
              <input type="number" min="1" class="form-control" id="validationCustom03" name="s_rollno" autocomplete="off" placeholder="eg. 1" required>
              <label for="validationCustom03" class="form-label"></label>
            </div>
            <div class="col-md-6">
              <label for="validationCustom04" class="form-label">Ending RollNo</label>
              <input type="number" class="form-control" id="validationCustom04" name="l_rollno" autocomplete="off" placeholder="eg. 77" required>
              <label for="validationCustom04" class="form-label"></label>
            </div>
            <div class="col-12">
              <input class="btn btn-primary" type="submit" value="Create Class"></input>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal -->

<!-- Logic of Display Classes -->
<?php
// echo date("h:i"); 
$t_id = $_SESSION['teacher_mob'];
$query = "select * from all_classes where tid = " . $t_id . " order by year desc , division asc, semester asc, dept asc , className asc";
$result = mysqli_query($conn, $query);
// if($result){
//   echo $row_count = mysqli_num_rows($result);
// }

?>

<?php
if (isset($_GET['deleteClass'])) {
  echo "<h4 class='text-success text-center'>Class Deleted.</h4>";
}
if (isset($_GET['lect_attendance'])) {
  echo "<h4 class='text-success text-center'>Attendance of $_GET[lect_attendance] Submitted.</h4>";
}
?>
<div class="container d-flex gap-5 mt-5 flex-wrap justify-content-center   ">
  <?php

  while ($row = mysqli_fetch_assoc($result)) {
    $className =  $row['className'];
    $s_rollno = $row['s_rollno'];
    $l_rollno = $row['l_rollno'];
    $semester = $row['semester'];
    $dept = $row['dept'];
    $division = $row['division'];
  ?>
    <!-- Classes  -->
    <div class="card" style="width: 18rem;">

      <div class="card-body ">
        <span class="position-absolute top-0  start-100 translate-middle badge rounded-pill bg-danger text-white">
          <a style="text-decoration: none; color: white;" onclick="return confirm_delete('<?php echo $className ?>')" href=<?php echo "delete_class.php?table_name=$className" ?> <i style="cursor: pointer;" class="fa-solid fa-trash "></i> </a>
          <span class="visually-hidden">unread messages</span>
        </span>
        <h5 class="card-title"><?php echo $className ?></h5>
        <p class="card-text"><b>Semester:</b> <?php echo $row['semester'] . "</br>"; ?>
          <b>Department:</b> <?php echo $row['dept'] . "</br>"; ?>
          <b>Division:</b> <?php echo $row['division'] . "</br>"; ?>
          <b>Year:</b> <?php echo $row['year'] . "</br>"; ?>
        </p>
        <a href=<?php echo "take_attendance.php?table_name=$className&semester=$semester&dept=$dept&s_rollno=$s_rollno&l_rollno=$l_rollno&division=$division&attend=true"; ?> class="btn btn-primary">Take Attendance</a>
      </div>
    </div>
    <!-- End of Classes -->

  <?php
  }
  ?>
  <!-- End of Logic of Display Classes -->
</div>








<script>
  function confirm_delete(subject) {
    let choice = confirm(`Are you really want to delete\n   ${subject} \nIt can't be revert.`)
    return choice;
  }
</script>
<?php
require("../Templete/footer.html")
?>