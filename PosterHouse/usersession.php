<?php
// We starten de sessie en includen de database connectie
session_start();
include 'dbconnect.php';

// Checkt of de usersessie is gezet
if (isset($_SESSION['userSession'])) {
	$query = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
	$userRow=$query->fetch_array();
}
?>