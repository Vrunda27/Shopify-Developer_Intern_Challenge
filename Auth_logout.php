<?php
	session_start();
	// echo "<script>alert('You have logged out!');</script>";
	session_destroy();
    header("Location:index.php");
    die();
?>