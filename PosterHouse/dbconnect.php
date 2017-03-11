<?php

	 $connect = mysqli_connect("localhost", "root", "", "posterhouse_databaseV2");
    
     if ($connect->connect_errno) {
         die("ERROR : -> ".$connect->connect_error);
     }

?>
