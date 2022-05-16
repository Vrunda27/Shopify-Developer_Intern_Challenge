<?php
	require('constants.php');

	$mysqli = new mysqli($DB_SERVER, $DB_USER , $DB_PASSWORD, $DB_NAME);

	if($mysqli->connect_errno) {
		error_log("miniFacebook: " + "Database Connection Failed - " +  $mysqli->connect_error);
		exit();
	}  
?>