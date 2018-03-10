<?php
	require_once "global.php";
	// this file will be called by userController.js and show json
	header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

	$act = $_POST['act'];
	
	// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)
	if ($act == 'login'){
		//$debug = $_SESSION['debug'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		if( User::login($username, $password)){
			sessionCheckStart();
			$_SESSION["username"] = $username;
			$_SESSION["calendarUser"] = $username;
			
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
	} else if ($act == 'register'){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		if( User::register($username, $email, $password)){
			sessionCheckStart();
			$_SESSION["username"] = $username;
			$_SESSION["calendarUser"] = $username;
			
			echo json_encode(array(
				"success" => true
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"message" => "Invalid username"
			));
			exit;
		}
	} else if ($act == 'logout'){
		if( User::logout()){
			echo json_encode(array(
				"success" => true
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"message" => "Unsuccessful"
			));
			exit;
		}
	}
?>