<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();
print_r($_SESSION);
if (!(isset($_SESSION['teacher_mob']))) {
    echo "Helllo";
    header("location: ../index.php");
}
else{
    
    echo $semester = $_GET['semester'];
    echo $department = $_GET['department'];
    echo $division = $_GET['division'];
    echo $s_rollno = $_GET['s_rollno'];
    echo $l_rollno = $_GET['l_rollno'];
    echo $year = $_GET['year'];
    echo $className = $_GET['className']."_".$department."_".$division."_".$year;

    /* Create New Table Course Dynamically */
    $str = ",";
    echo "</br>";
    for($i=$s_rollno;$i<$l_rollno;$i++){
        $str = $str."s".$i." varchar(255),";
    }
    $str = $str."s".$i." varchar(255)";

     $query = "create table ".$className." (id int primary key auto_increment,semester varchar(255),department varchar(255),division varchar(255)
      "."$str".",attendance varchar(255),date date);";
     echo "</br>".$query;
     $result = mysqli_query($conn,$query);
     if($result){
        echo "Table Created Successfully";
     }
     else{
        echo "Error occured";
     }

     /*End of Create New Table Course Dynamically */


// Inserting Into all_classes Table
     print_r($_SESSION['teacher_mob']);
     $query1 = "INSERT INTO `all_classes`( `tid`, `className`, `semester`, `year`, `dept`, `s_rollno`, `l_rollno`, `division`) VALUES ($_SESSION[teacher_mob],'$className','$semester','$year','$department','$s_rollno','$l_rollno','$division');";

     $result1 = mysqli_query($conn,$query1);
     if($result1){
        echo "Data inserted Successfully";
        header("location: teacher.php");  
     }
     else{
        echo "Error occured when inserting Data";
     }

}



?>


<h1>Hello</h1>

<?php
require("../Templete/footer.html")
?>