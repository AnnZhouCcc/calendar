<?php
	$debug = true;
	if($debug){
		ini_set('display_errors',1);
		error_reporting(E_ALL);
	}
	
	require_once "Calendar.php";
	require_once "Event.php";
	require_once "Group.php";
	require_once "User.php";

	//this file contains global variables like databse and debug message
	// print debug message

	//connect to database
	$mysqli = new mysqli('localhost', 'M5', '123456', 'Calendar');
	if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
	}
	
	// a function to start session
	if(!function_exists("sessionCheckStart")){
		function sessionCheckStart(){
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
	}
	}

	//<script src="global.js" type="text/javascript"></script>
?>
