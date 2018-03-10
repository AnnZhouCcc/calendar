<?php
	require_once "global.php";
	// this file will be called by groupController.js and show json
	header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

	sessionCheckStart();
	$act = $_POST['act'];
	
	// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)
	if ($act == 'newgroup'){
		$username = $_SESSION['username'];
		$groupname = $_POST['newgroupname'];
		if( Group::newgroup($username, $groupname)){
			echo json_encode(array(
				"success" => true
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"message" => "Invalid group name"
			));
			exit;
		}
	} else if ($act == 'addmember'){
		$username = $_SESSION['username'];
		$membername = $_POST['member'];
		$groupname = $_POST['groupname'];
		if( Group::addmember($username, $membername, $groupname)){
			
			echo json_encode(array(
				"success" => true
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"message" => "You are not authorized to do so."
			));
			exit;
		}
	} 
?>