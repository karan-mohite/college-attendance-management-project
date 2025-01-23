<?php
require("./Server/config.php");
require("./Templete/header.html");

$status = false;
if(isset($_POST['stud_register'])){
   echo $name = $_POST['name'];
   echo $mobile_no = $_POST['mobile-no'];
   echo $password = $_POST['password'];
   echo $email = $_POST['email'];
   echo $parents_no = $_POST['parents-wa-no'];
   echo $rollNo = $_POST['roll-no'];
   echo $prn_No = $_POST['prn-no'];
  //  echo $class = $_POST['class'];
   echo $department = $_POST['department'];
   echo $division = $_POST['division'];
   echo $year = $_POST['year'];
   echo $semester = $_POST['semester'];

   $query = "select * from `student_details`; ";
   $result = mysqli_query($conn,$query);
   $row = mysqli_fetch_assoc($result);

   if($row['email']=="$email" || $row['mobile_no']==$mobile_no){
    echo "Email or Mobile Already Regestired ";
   }
   else if($row['prn_No']==$prn_No){
      echo "PRN No already Registered";
   }
   else{

   $query = "INSERT INTO `student_details`( `name`, `mobile_no`, `password`, `email`, `parents_no`, `rollNo`, `prn_No`,  `department`, `division`, `year`, `semester`) VALUES ('$name',$mobile_no,'$password','$email',$parents_no,$rollNo,'$prn_No','$department','$division',$year,$semester) ; ";
  //  $query = "INSERT INTO `student_details`( `name`, `mobile_no`, `password`, `email`, `parents_no`, `rollNo`, `prn_No`, `class`, `department`, `division`, `year`, `semester`) VALUES ('$name',$mobile_no,'$password','$email',$parents_no,$rollNo,'$prn_No','$class','$department','$division',$year,$semester) ; ";

   $result = mysqli_query($conn,$query);
   if($result){
    echo "Registration Successful";
    $status = true;
   }
   else{
    echo "RollNo already Registered.";
   }
         
}


}

?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .registration-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }
  </style>
</head>
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
        <a class="nav-link active" aria-current="page" href="./">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_attendance.php">View Attendance</a>
      </li>
      <!-- <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li> -->
    </ul>
  </div>
  </div>
</nav>

<!-- End of Navbar -->




<div class="container">
   <?php if($status){
       echo" <h3 class='text-success mt-5 text-center'>Registration Successful</h3>";
    }
    ?>
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="registration-container">
          <h3 class="text-center mb-4">Student Registration</h3>
          <form id="student-registration-form" action="" method="post">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="mobile-no" class="form-label">Mobile Number</label>
              <input type="text" class="form-control" id="mobile-no" name="mobile-no" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="parents-wa-no" class="form-label">Parent's WhatsApp Number</label>
              <input type="text" class="form-control" id="parents-wa-no" name="parents-wa-no" required>
            </div>
            <div class="mb-3">
              <label for="roll-no" class="form-label">Roll Number</label>
              <input type="text" class="form-control" id="roll-no" name="roll-no" required>
            </div>
            <div class="mb-3">
              <label for="prn-no" class="form-label">PRN Number</label>
              <input type="text" class="form-control" id="prn-no" name="prn-no" required>
            </div>
            <div class="mb-3">
            <label for="class" class="form-label">Class</label>
              <select class="form-select" id="class" name="semester" required>
                <option value="">Select Class</option>
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
            <div class="mb-3">
              <label for="department" class="form-label">Department</label>
              <select class="form-select" id="department" name="department" required>
                <option value="">Select Dept.</option>
                <option value="CO">CO</option>
                <option value="AI">AI</option>
                <option value="IT">IT</option>
            </select>
            </div>
            <div class="mb-3">
              <label for="division" class="form-label">Division</label>
              <select class="form-select" id="division" name="division" required>
                <option value="">Select Division</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            </div>
            <div class="mb-3">
              <label for="year" class="form-label">Year eg.24</label>
              <input type="number" class="form-control" id="year" name="year" placeholder="eg 24" required>
            </div>
            <!-- <div class="mb-3">
              <label for="semester" class="form-label">Semester</label>
              <input type="number" min="1" max="8" class="form-control" id="semester" name="semester" required>
            </div> -->
            <button type="submit" name="stud_register" class="btn btn-primary btn-block">Register</button>
            </br><p class="mt-2"><a class="text-decoration-none" href="index.php" id="register_id">Go to Login.</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional, only needed if you want to use Bootstrap JS components) -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->







<!-- Credits -->
<div class="container mx-auto w-100  ">
  <p class="text-center mt-5">Made by
    </BR> <b><a target="_blank" href="https://adimore96.github.io/adimore.in/">Aditya More.</a></b>
    </BR><b><a target="_blank" href="https://www.linkedin.com/in/umesh-chimane-07b005250/">Umesh Chimane.</a></b>
    </br><b><a target="_blank" href="https://www.linkedin.com/in/sahil-babar-10820a202/">Sahil Babar.</a></b></p>

</div>
<!-- End of Credits -->
<?php
require("./Templete/footer.html")
?>