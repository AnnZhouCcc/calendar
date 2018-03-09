<?php
	require_once Calendar.php;
	require_once Event.php;
	require_once Group.php;
	require_once User.php;

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
	
	if (!empty($_POST['token'])){
		if(!hash_equals($_SESSION['token'], $_POST['token'])){
			die("<h3>Request forgery detected</h3>");
		}	
	}
	
	// a function to start session
	function sessionCheckStart(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	}
?>