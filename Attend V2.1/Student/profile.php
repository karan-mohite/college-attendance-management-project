<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['student_mob']))) {
    // echo "Helllo";
    header("location: ../index.php");
  }


//   Logic to Update Details
    if(isset($_POST['UD_submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_SESSION['student_mob'];

    $query = "UPDATE  `student_details` SET `name`='$name', `email`= '$email', `password`= '$password' where mobile_no = $phone";
        $result1 = mysqli_query($conn,$query);
    }


//   print_r($_SESSION['student_mob']);

  $query = "select * from `student_details` where mobile_no = $_SESSION[student_mob]";
  $row = mysqli_fetch_assoc(mysqli_query($conn,$query));
   $name = $row['name'];
   $email = $row['email'];
   $password = $row['password'];
   $phone = $row['mobile_no'];
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
        <a class="nav-link active" aria-current="page" href="student.php">Home</a>
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



<div class="container  w-75">
    <h3 class="mt-4 text-center">Update Profile</h3>
   <?php 
   if(isset($_POST['UD_submit'])){
    if($result1){
    echo "<h5 class='text-success'>Data Updated Successfully</h5>";
  }
  else{
    echo "Data not inserted";
  }
}
  ?>
    <form action="" method="post">
<table class="table mt-5 w-50  mx-auto">
  <tbody>
    <tr>
      <th scope="row">Name</th>
      <td> <input type="text" name="name" id="name" value="<?php echo $name ?>"> </td>
    </tr>
    <tr>
      <th scope="row">Email</th>
      <td> <input type="text" name="email" id="email" value="<?php echo $email ?>"> </td>
    </tr>
    <tr>
      <th scope="row">Password</th>
      <td style="display: flex; gap: 12px;"> 
      <input type="password" name="password" id="password" value="<?php echo $password ?>">
      <input  type="checkbox" name=""  onclick="myFunction()" id="">
    </td>
    </tr>
    <tr>
      <th scope="row">Phone No.</th>
      <td> <input type="text" name="phone" disabled  id="phone"  value="<?php echo $phone ?>"> </td>
    </tr>
    <tr>
      <td colspan="2"> <input class="btn bg-success text-white"  type="submit" value="Update" name="UD_submit"  id="UD_submit" > </td>
    </tr>
   
  </tbody>
</table>
</form>

</div>




<script>
  function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>


<?php
require("../Templete/footer.html")
?>