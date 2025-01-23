<?php
require("../Templete/header.html");
require("../Server/config.php");
session_start();

if (!(isset($_SESSION['teacher_mob']))) {
    // echo "Helllo";
    header("location: ../index.php");
}

if(isset($_GET['table_name'])){
    $className = $_GET['table_name'];
    $query = "delete from all_classes where className  = '$className';";
    $result = mysqli_query($conn,$query);
    if($result){
        $query = " drop table $className;";
        $result = mysqli_query($conn,$query);
        if($result){
            header("location: teacher.php?deleteClass=True");
        }
    }
}

?>
