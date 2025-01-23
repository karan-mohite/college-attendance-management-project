<?php
require("./Templete/header.html");
session_start();
if (isset($_SESSION['teacher_mob'])) {
  // echo "Helllo";
  header("location: Teacher/teacher.php");
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


<!-- Login Form Old -->
<!-- <div class="container w-75 mt-5  shadow rounded p-4 ">
  <div class="row gap-3 ">
    <div class="col login mt-5 border p-3 rounded col-xs-12">
      <h2>Teacher Login</h2>
      <form action="./Teacher/teacher.php" method="POST">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" autocomplete="off" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" placeholder="Password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-success">Login</button>
      </form>
    </div>


    <div class="col-sm-6 mt-5 mb-5 border p-3 rounded ">
      <h2>Admin Login</h2>
      <form action="./Admin/admin.php" method="get">
        <div class="mb-3">
          <label for="exampleInputEmail11" class="form-label">Username</label>
          <input type="text" autocomplete="off" class="form-control" name="username" placeholder="Username" id="exampleInputEmail11" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword11" class="form-label">Password</label>
          <input type="password" placeholder="Password" name="password" class="form-control" id="exampleInputPassword11">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div> -->
<!-- EndOf Login Form Old -->


<!-- New Login From -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .login-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 100px;
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

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">

        <div class="login-container">

        
          <!-- Selector -->
          <div class="text-center m-3">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
              <input id="admin-btn" type="radio" class="btn-check" name="btnradio" autocomplete="off" checked>
              <label class="btn btn-outline-primary" for="admin-btn">Admin</label>

              <input id="student-btn" type="radio" class="btn-check" name="btnradio" autocomplete="off">
              <label class="btn btn-outline-primary" for="student-btn">Student</label>

              <input id="teacher-btn" type="radio" class="btn-check" name="btnradio" autocomplete="off">
              <label class="btn btn-outline-primary" for="teacher-btn">Teacher</label>
            </div>
          </div>
          <!-- End of Selector -->
          <h3 class="text-center mb-4" id="login">Admin Login</h3>

          <div id="admin-login-form-container">
              <form action="./Admin/admin.php" method="get" id="admin-login-form" style="display: block;">
                <div class="mb-3">
                  <label for="exampleInputEmail11" class="form-label">Admin Username</label>
                  <input type="text" autocomplete="off" class="form-control" name="username" placeholder="Username" id="exampleInputEmail11" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword11" class="form-label">Password</label>
                  <input type="password" placeholder="Password" name="password" class="form-control" id="exampleInputPassword11">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
              </form>
          </div>
          <div id="student-login-form-container">
            <form id="student-login-form" style="display: none;" action="./Student/student.php" method="post">
              <div class="mb-3">
                <label for="student-username" class="form-label">Student Email</label>
                <input type="email" class="form-control" id="student-username" name="email" placeholder="Email">
              </div>
              <div class="mb-3">
                <label for="student-password" class="form-label">Password</label>
                <input type="password" class="form-control" id="student-password" name="password" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Student Login</button>
              </br><p>Not Registered yet? <a href="register_student.php" id="register_id">Click Here to register.</a></p>
            </form>

          </div>
          <div id="teacher-login-form-container">
            <form id="teacher-login-form" style="display: none;" action="./Teacher/teacher.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" autocomplete="off" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" placeholder="Password" name="password" class="form-control" id="exampleInputPassword1">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Teacher Login</button>
            </form>
          </div>



          <!-- <button  class="btn btn-link bg-primary text-white btn-group">Admin</button>
            <button  class="btn btn-link bg-primary text-white btn-group">Student</button>
            <button  class="btn btn-link bg-primary text-white btn-group">Teacher</button> -->

        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap JS (optional, only needed if you want to use Bootstrap JS components) -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
  <script>
    let login = document.getElementById('login');
    document.getElementById('admin-btn').addEventListener('click', function() {
      document.getElementById('admin-login-form').style.display = 'block';
      document.getElementById('student-login-form').style.display = 'none';
      document.getElementById('teacher-login-form').style.display = 'none';
      login.innerHTML = "Admin Login";
    });

    document.getElementById('student-btn').addEventListener('click', function() {
      document.getElementById('admin-login-form').style.display = 'none';
      document.getElementById('student-login-form').style.display = 'block';
      document.getElementById('teacher-login-form').style.display = 'none';
      login.innerHTML = "Student Login";
    });

    document.getElementById('teacher-btn').addEventListener('click', function() {
      document.getElementById('admin-login-form').style.display = 'none';
      document.getElementById('student-login-form').style.display = 'none';
      document.getElementById('teacher-login-form').style.display = 'block';
      login.innerHTML = "Teacher Login";
    });
  </script>
</body>

</html>

<!-- End of New Login From -->


<!-- Credits -->
<!-- <div class="container mx-auto w-100  ">
  <p class="text-center mt-5">Made by
    </BR> <b><a target="_blank" href="https://adimore96.github.io/adimore.in/">Aditya More.</a></b>
    </BR><b><a target="_blank" href="https://www.linkedin.com/in/umesh-chimane-07b005250/">Umesh Chimane.</a></b>
    </br><b><a target="_blank" href="https://www.linkedin.com/in/sahil-babar-10820a202/">Sahil Babar.</a></b></p>

</div> -->
<!-- End of Credits -->
<?php
require("./Templete/footer.html")
?>