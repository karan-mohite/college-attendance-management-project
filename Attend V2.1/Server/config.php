<?php

    $conn = mysqli_connect("localhost","root","","attendance_db");
    if($conn){
        // echo "Connection Successful";
    }
    else{
        echo " COnnection Unsuccessful";
    }

?>