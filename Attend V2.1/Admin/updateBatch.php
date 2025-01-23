<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['admin_mob']))) {
    header("location: ../index.php");
}

if(isset($_GET['updateBatch'])){
     $batchName = $_GET['batchName'];
     $t_id = $_GET['t_id'];
    //  $s_rollno = $_GET['s_rollno'];
    //  $l_rollno = $_GET['l_rollno'];

    $query = "select * from `teacher_details` where phone = '$t_id';";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
     $tName = $row['name'];

    $query = "UPDATE `all_batches` SET `tid`= '$t_id' , `tName` = '$tName'   where batchName = '$batchName'; ";
    // $query = "UPDATE `all_batches` SET `tid` = '$t_id' , `tName` = '$tName', `s_rollno` = $s_rollno, `l_rollno` = $l_rollno where batchName = '$batchName'; ";
    if(mysqli_query($conn,$query)){
        echo "Details Updated";
        header("location: manageBatch.php");
    }
    else{
        echo "Details not updated";
    }
    
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
                <a class="nav-link " aria-current="page" href="attendence_report.php">Attendence Report</a>
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
if (isset($_GET['attend'])) {
    $batchName =  $_GET['batchName'];
    $batch =  $_GET['batch'];
    $semester =  $_GET['semester'];
    $dept =  $_GET['dept'];
    $s_rollno =  $_GET['s_rollno'];
    $l_rollno =  $_GET['l_rollno'];
    $division =  $_GET['division'];
    $tid =  $_GET['tid'];
    $tName =  $_GET['tName'];
    ?>

    <!-- Form -->

    <div class="container w-50 shadow p-3 rounded mt-5">
    <form class="row g-3 needs-validation" action="" method="get" >
        <h3><?php echo$batchName ?></h3>
        <input type="text" name="batchName" id="batchName" value="<?php echo $batchName ?>" hidden>
           
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
              <input type="number" class="form-control" id="validationCustom03"  disabled name="s_rollno" autocomplete="off" value="<?php echo $s_rollno ?>" placeholder="eg. 1" required>
              <label for="validationCustom03" class="form-label"></label>
            </div>
            <div class="col-md-6">
              <label for="validationCustom04" class="form-label">Ending RollNo</label>
              <input type="number" class="form-control" disabled id="validationCustom04" name="l_rollno" value="<?php echo $l_rollno ?>" autocomplete="off" placeholder="eg. 20" required>
              <label for="validationCustom04" class="form-label"></label>
            </div>
            <div class="col-12">
              <input class="btn btn-primary" type="submit" name="updateBatch" value="Update Batch" ></input>
            </div>
          </form>
    </div>

    <!-- End of Form -->
    <?php
}
?>



<?php
require("../Templete/footer.html")
?>