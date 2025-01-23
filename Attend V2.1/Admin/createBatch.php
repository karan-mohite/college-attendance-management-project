<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['admin_mob']))) {
    header("location: ../index.php");
}

if(isset($_GET['createBatch'])){
    echo $practicalName = $_GET['practicalName'];
    echo $batchName = $_GET['batchName'];
    echo $year = $_GET['year'];
    echo $department = $_GET['department'];
    echo $semester = $_GET['semester'];
    echo $division = $_GET['division'];
    echo $s_rollno = $_GET['s_rollno'];
    echo $l_rollno = $_GET['l_rollno'];
    echo $tid = $_GET['t_id'];
    echo "</br>";
    echo $batch = $practicalName."_".$batchName."_".$department."_".$division."_".$year;
    echo "</br>";
    echo "Get request";
    $str="";
    for($i=$s_rollno;$i<$l_rollno;$i++){
        $str = $str."s".$i." varchar(255),";
    }
    $str = $str."s".$i." varchar(255)";
    echo "</br>".$str."</br>";

    $query = "create table $batch (id int primary key auto_increment,semester varchar(255),department varchar(255),division varchar(255),".$str.",date date)";

    $result = mysqli_query($conn,$query);
    if($result){
        echo "Table Created Successfully";

        $query3 = "select * from `teacher_details` where phone = '$tid';";
        $result3 = mysqli_query($conn,$query3);
        $row = mysqli_fetch_assoc($result3);

        $query1 = "insert into `all_batches` (`tid`,`tName`, `batchName`, `batch`, `year`, `semester`, `practicalName`, `s_rollno`, `l_rollno`, `division`, `department`) values('$tid','$row[name]','$batch','$batchName',$year,$semester,'$practicalName',$s_rollno,$l_rollno,'$division','$department');";
        $result1 = mysqli_query($conn,$query1);
        if($result1){
            echo "Data inserted successfully";
            header("location: manageBatch.php");
        }
        else{
            echo "Data not inserted";
        }
    }
    else{
        echo "Table not created";
    }

    
}

?>
