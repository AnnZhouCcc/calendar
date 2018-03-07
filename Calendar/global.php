<?php
	//this file contains global variables like databse and debug message
	// print debug message
	$deubug = true;
	if($debug){
		ini_set('display_errors',1);
		error_reporting(E_ALL);
	}
	
	//connect to database
	$mysqli = new mysqli('localhost', 'M5', '123456', 'Calendar');
	if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
	}
?>