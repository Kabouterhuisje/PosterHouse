<?php

    $connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV5");
    
     if ($connect->connect_errno) {
         die("ERROR : -> ".$connect->connect_error);
     }

?>
