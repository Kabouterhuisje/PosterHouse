<?php

	 $host = "localhost";
	 $account = "root";
	 $pass = "";
	 $name = "posterhouse_database";

		$connect = new MySQLi($host,$account,$pass,$name);
    
     if ($connect->connect_errno) {
         die("ERROR : -> ".$connect->connect_error);
     }

?>
