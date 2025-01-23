<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8  user-scalable=0">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      h3{
        color: red;
        
      }
      input[type=checkbox] {
         appearance: none;
         padding: 14px !important;
         /* background-color: ; */
         border: 1px solid black;
         border-radius:80%;
         cursor: pointer;
      }
      input[type=checkbox]:checked {
         background-color: green;
      }
      
    </style>

    <script>
      function changeColor(result){
        if(result.checked){
          result.parentNode.parentNode.style.backgroundColor="#005F54 ";
          result.parentNode.parentNode.style.color="white";
        }else{
          result.parentNode.parentNode.style.backgroundColor="white ";
          result.parentNode.parentNode.style.color="black";
        }
      }
      function changeColor1(result){
        if(result.checked){
          result.parentNode.parentNode.style.backgroundColor="white ";
          result.parentNode.parentNode.style.color="";
        }
        else{
          result.parentNode.parentNode.style.backgroundColor="white ";
          result.parentNode.parentNode.style.color="";
        }
      }
    </script>
    
  </head>
  <body>

<?php
// require("../Templete/header.html");
require("../Server/config.php");
session_start();
ob_start();
// print_r($_SESSION);
if (!(isset($_SESSION['teacher_mob']))) {
    echo "Helllo";
    header("location: ../index.php");
}

// After submitting Attendance
if(isset($_GET['submit_attendance'])=='Submit'){
    echo "Attendance Submitted";
    echo$s_rollno = $_GET['s_rollno'];
    echo$l_rollno = $_GET['l_rollno'];
    echo$semester = $_GET['semester'];
    echo$department = $_GET['department'];
    echo$division = $_GET['division'];
    echo$table_name = $_GET['table_name'];
    $s;
    
    for($i=$s_rollno;$i<=$l_rollno;$i++){
        $s["s".$i] = $_GET["s".$i];
    }
    extract($s);
    // echo "</br>",$s30;


    $str = ",";
    echo "</br>";
    for($i=$s_rollno;$i<$l_rollno;$i++){
        $str = $str."`s".$i."`,";
    }
    $str = $str."`s".$i."`";
    echo "</br> $str </br>";

    $str_val ="";
    
    for($i = $s_rollno;$i<=$l_rollno;$i++){
        echo $str_val =$str_val.",'".$s["s$i"]."'";
      }
      // getting all records in the $str_val 
      echo "</br>".$str_val;
    $date = date("Y-m-d");
    $query = "INSERT INTO `$table_name`( `semester`, `department`, `division`".$str.",`date`) VALUES ('$semester','$department','$division'".$str_val.",'$date');";

    $result = mysqli_query($conn,$query);
    if($result){
      echo "Data inserted successfully";
      header("location: practicalBatches.php");
    }
    else{
      echo "Data not inserted";
    }
    
    echo $query;


}
// End of after submitting Attendance

if(!(isset($_GET['attend'])=='true')){
    echo "Not a Get Command";
}
else{
    // echo "Get Command";
    $table_name = $_GET['table_name'];
    $year = substr($table_name, -2);
    $s_rollno = $_GET['s_rollno'];
    $l_rollno = $_GET['l_rollno'];
    $dept = $_GET['dept'];
    $semester = $_GET['semester'];
    $division = $_GET['division'];

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
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="#">Attendence Report</a>
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


<!-- Attendance Form -->

<div class="container w-75 mt-3">
    <h3 class="text text-center m-5" style="font-size: 20px;"><?php echo $table_name." Division: ".$division;?></h3>
<form class="row g-5 needs-validation" action="" method="get" novalidate>
    <!-- <table class="text-center table table-striped"> -->
    <table class="text-center  table-striped  shadow">
        <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Attendance</th>
            <!-- <th>Absent</th> -->
        </tr>
        <input type="text" name="s_rollno" value="<?php echo $s_rollno ?>" hidden></input>
        <input type="text" name="table_name" value="<?php echo $table_name ?>" hidden></input>
        <input type="text" name="l_rollno" value="<?php echo $l_rollno ?>" hidden></input>
        <input type="text" name="semester" value="<?php echo $semester ?>" hidden></input>
        <input type="text" name="division" value="<?php echo $division ?>" hidden></input>
        <input type="text" name="department" value="<?php echo "$dept" ;?>" hidden></input>
        <?php
        for($i=$s_rollno;$i<=$l_rollno;$i++){
          $query_new = "select * from `student_details` where rollNo =$i and department = '$dept' and division = '$division' and semester = $semester and year = $year ;";
          $result_new = mysqli_query($conn,$query_new);
          $row_new = mysqli_fetch_assoc($result_new);
          // echo  $row_new['name'];
        ?>
        
        
        
        <tr  class="table-group-divider">
            <td style="font-weight: bold; font-size: 19px;"> <label style=" z-index: 5; width: 100%; padding: 15px; cursor: pointer;" for="<?php echo 'ls'.$i ?>"> <?php echo $i ?> </label>
            </td>
            <td><label style=" z-index: 5; cursor: pointer; width: 100%; padding: 15px;" for="<?php echo 'ls'.$i ?>"><?php echo "$row_new[name]" ;?></label></td> 
            <td class="p-2"><input type="checkbox" onclick="changeColor1(this);" value="Absent" style="padding: 10px;" hidden  name="s<?php echo $i ?>" checked />
            <input style="position: absolute;  left: 70%; "  type="checkbox" onclick="changeColor(this);" value="Present" id="<?php echo 'ls'.$i ?>" name="s<?php echo $i ?>"/>
            <label style="position: relative; cursor: pointer; z-index: 5; width: 100%; padding: 15px; " for="<?php echo 'ls'.$i ?>"> </label>
          </td>
            
        </tr> </label>
        <?php
        }?>
            </div>
        </table>
            
            <div class="col-12">
              <input class="btn btn-primary" type="submit" name="submit_attendance"></input>
            </div>
            </form>
</div>


<?php
}
require("../Templete/footer.html")
?>