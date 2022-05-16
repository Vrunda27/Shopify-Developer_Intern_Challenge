<?php
	$LIFETIME 	= 60 * 60; // 15 minutes
	$PATH 		= "/";
	$DOMAIN 	= "localhost";
	$SECURE 	= TRUE;
	$HTTPONLY 	= TRUE;
	
	session_set_cookie_params($LIFETIME, $PATH, $DOMAIN, $SECURE, $HTTPONLY);

	session_start();
?>