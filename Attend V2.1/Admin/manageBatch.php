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
        <a class="nav-link active" href="manageBatch.php">Manage Batch</a>
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


<!-- Batches -->

<?php
    // $t_id = $_SESSION['teacher_mob'];
  $query = "select * from `all_batches` order by year desc , division asc, semester asc, department asc , batchName asc ";
  $result = mysqli_query($conn,$query);
  // if($result){
  //   echo $row_count = mysqli_num_rows($result);
  // }

?>
<?php
if (isset($_GET['deleteBatch'])) {
  echo "<h4 class='text-success mt-3 text-center'>Batch Deleted Successfully.</h4>";
}
?>
<div class="container d-flex gap-2 mt-5 gap-5 flex-wrap justify-content-center   ">


  <?php


   
   while($row = mysqli_fetch_assoc($result)){
    $batchName =  $row['batchName']; 
    $batch = $row['batch'];
    $s_rollno = $row['s_rollno'];
    $l_rollno = $row['l_rollno'];
    $semester = $row['semester'];
    $dept = $row['department']; 
    $division = $row['division'];
    $tid = $row['tid']; 
    $tName = $row['tName']; 
    ?>
    <!-- Classes  -->
    <div class="card " style="width: 18rem;">
  
  <div class="card-body">
  <span class="position-absolute top-0  start-100 translate-middle badge rounded-pill bg-danger text-white">
          <a style="text-decoration: none; color: white;" onclick="return confirm_delete('<?php echo $batchName ?>')" href=<?php echo "delete_batch.php?table_name=$batchName" ?> <i style="cursor: pointer;" class="fa-solid fa-trash "></i> </a>
          <span class="visually-hidden">unread messages</span>
        </span>
    <h5 class="card-title"><?php echo $batchName ?></h5>
    <p class="card-text">
    <b>Lab Name:</b> <?php echo $row['practicalName']."</br>";?>
    <b>Batch:</b> <?php echo $row['batch']."</br>";?>
    <b>Semester:</b> <?php echo $row['semester']."</br>";?>
    <b>Division:</b> <?php echo $row['division']."</br>";?>
    <b>Department:</b> <?php echo $row['department']."</br>";?>
    <b>Teacher:</b> <?php echo $tName."</br>";?>
    <!-- <b>Year:</b> <?php echo $row['year']."</br>";?> -->
    <b>S RollNo:</b> <?php echo $row['s_rollno']."</br>";?>
    <b>L RollNo:</b> <?php echo $row['l_rollno']."</br>";?>
  </p>
    <a href=<?php echo "updateBatch.php?batchName=$batchName&batch=$batch&semester=$semester&dept=$dept&s_rollno=$s_rollno&l_rollno=$l_rollno&division=$division&attend=true&tid=$tid&tName=$tName";?> class="btn btn-primary">Update Details</a>
  </div>
</div>
<?php
  }
  ?>
 <!-- End of Classes -->


<!-- End of Batches -->


<!-- Create Batch -->

<div class="container mt-5 ">

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add Batch
  </button>
  <!-- Modal  fade-->
  <!-- <div class="modal fade   modal-dialog modal-dialog-centered modal-dialog-scrollable" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
  <div class="modal  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Batch</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


          <form class="row g-3 needs-validation" action="./createBatch.php" method="get" novalidate>
            <div class="col-md-6">
              <label for="validationCustom01" class="form-label">Practical Name eg.<b> WTL</b></label>
              <input type="text" class="form-control" id="validationCustom01" autocomplete="off" name="practicalName" placeholder="eg. WTL " required>
            </div>
            <div class="col-md-4">
              <label for="validationCustomBatchName" class="form-label">Batch</label>
              <select class="form-select" name="batchName" id="validationCustomBatchName" required>
                <option selected disabled value="">Choose...</option>
                <option value="A">A-Batch</option>
                <option value="B">B-Batch</option>
                <option value="C">C-Batch</option>
                <option value="D">D-Batch</option>
                <option value="E">E-Batch</option>
              </select>
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
                <option value="1">FE-1</option>
                <option value="2">FE-2</option>
                <option value="3">SE-1</option>
                <option value="4">SE-2</option>
                <option value="5">TE-1</option>
                <option value="6">TE-2</option>
                <option value="7">BE-1</option>
                <option value="8">BE-2</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="validationCustomDivision" class="form-label">Division</label>
              <select class="form-select" name="division" id="validationCustomDivision" required>
                <option selected disabled value="">Choose...</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="validationTeacher" class="form-label">Teacher</label>
              <select class="form-select" name="t_id" id="validationTeacher" required>
                <option selected disabled value="">Choose...</option>
                <?php
                $query = "select * from `teacher_details`";
                $result = mysqli_query($conn,$query);
                while($row = mysqli_fetch_assoc($result)){
                  
                    echo "<option value='$row[phone]'>$row[name]</option>";
                }

                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="validationCustom03" class="form-label">Starting RollNo</label>
              <input type="number" class="form-control" id="validationCustom03" name="s_rollno" autocomplete="off" placeholder="eg. 1" required>
              <label for="validationCustom03" class="form-label"></label>
            </div>
            <div class="col-md-6">
              <label for="validationCustom04" class="form-label">Ending RollNo</label>
              <input type="number" class="form-control" id="validationCustom04" name="l_rollno" autocomplete="off" placeholder="eg. 20" required>
              <label for="validationCustom04" class="form-label"></label>
            </div>
            <div class="col-12">
              <input class="btn btn-primary" type="submit" name="createBatch" value="Create Batch" ></input>
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

<!-- End of Create Batch -->


<script>
  function confirm_delete(subject) {
    let choice = confirm(`Are you really want to delete\n   ${subject} \nIt can't be revert.`)
    return choice;
  }
</script>

<?php
require("../Templete/footer.html")
?>
  