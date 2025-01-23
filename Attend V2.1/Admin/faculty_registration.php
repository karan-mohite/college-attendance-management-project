<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

    if(!(isset($_SESSION['admin_mob']))){
        header("location: ../index.php");
    }

    if(isset($_POST['register'])){
         $name = $_POST['fname']." ".$_POST['lname'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $phone = $_POST['phone'];

        $query = "INSERT INTO `teacher_details`(`name`, `email`, `password`, `phone`) VALUES ('$name','$email','$password','$phone')";

        $result = mysqli_query($conn,$query);
        $reg_successful = false;
        if($result){
            //  "Registration Successful";
            $reg_successful = true;
        }
        else{
            // echo "Registration Unsuccessful";
        }
    }

?>

    <!-- NavBar -->
<nav class=" navbar-expand-lg  navbar bg-dark border-bottom border-body" data-bs-theme="dark"">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">PGMCOE Attendance</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="admin.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">Faculty Registration</a>
              </li>
              <li class="nav-item">
        <a class="nav-link" href="manageBatch.php">Manage Batch</a>
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

      <!-- Add Faculty -->

      <div class="container w-75 mt-3 ">
        <h4 class="text-center">Faculty Registration</h4>
        <?php 
        if(isset($_POST['register'])){
        if($reg_successful==true){
           echo " <h5 class='text-success'> Registration Successful  </h5>";
        }}?>
      <form class="row g-2 col-sm-8 mx-auto mt-4 needs-validation border p-3 rounded shadow" novalidate action="" method="post">
  <div class="col-sm-5">
    <label for="validationCustom01" class="form-label" >First name</label>
    <input type="text" class="form-control" id="validationCustom01" name="fname" placeholder="First Name" required>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationCustom02" name="lname" placeholder="Last Name"  required>
  </div>
  <div class="col-md-4">
    <label for="validationCustomUsername" class="form-label">Email</label>
    <div class="input-group has-validation">
      <!-- <span class="input-group-text" id="inputGroupPrepend">Email</span> -->
      <input type="email" class="form-control" id="validationCustomUsername" placeholder="Email"  name="email" aria-describedby="inputGroupPrepend" required>
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustomUsername" class="form-label">Password</label>
    <div class="input-group has-validation">
      <!-- <span class="input-group-text" id="inputGroupPrepend">Email</span> -->
      <input type="email" class="form-control" id="validationCustomUsername" placeholder="Password"  name="password" aria-describedby="inputGroupPrepend" required>
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustomUsername" class="form-label">Phone Number</label>
    <div class="input-group has-validation">
      <!-- <span class="input-group-text" id="inputGroupPrepend">Email</span> -->
      <input type="text" class="form-control" id="validationCustomUsername" placeholder="Phone Number"  name="phone" aria-describedby="inputGroupPrepend" required>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="register" value="true">Add Teacher</button>
  </div>
</form>
      </div>


<?php
require("../Templete/footer.html")
?>
  