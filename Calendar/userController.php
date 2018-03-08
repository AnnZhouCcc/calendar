<?php
	require_once "global.php";
	// this file will be called by userController.js and show json
	header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)
	
	if( User::login()){
		session_start();
		$_SESSION['username'] = $username;
		
	
		echo json_encode(array(
			"success" => true
		));
		exit;
	}else{
		echo json_encode(array(
			"success" => false,
			"message" => "Incorrect Username or Password"
		));
		exit;
	}
?>