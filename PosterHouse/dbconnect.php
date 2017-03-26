<?php

    $connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV6");
    
     if ($connect->connect_errno) {
         die("ERROR : -> ".$connect->connect_error);
     }

     $DBconnect = new mysqli("localhost", "root", "", "posterhouse_databaseV6");

?>
