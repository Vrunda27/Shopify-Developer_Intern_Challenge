<?php

	require('session_create.php');

	if(!isset($_SESSION['logged']) or $_SESSION['logged'] != TRUE) {
		echo "<script>alert('Login to access!');</script>";
		session_destroy();
        header("Refresh:0; url=ui_login.php");
        die();
	}

	if($_SESSION['browser'] != $_SERVER['HTTP_USER_AGENT']) {
		echo "<script>alert('Session hijacking detected');</script>";
		session_destroy();
        header("Refresh:0; url=ui_login.php");
        die();
	}

?>