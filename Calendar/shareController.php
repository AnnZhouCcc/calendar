<?php
	require_once "global.php";
	
	header("Content-Type: application/json"); 

	sessionCheckStart();
	
    $username = $_SESSION['username'];
    $sharename = $_POST['sharewithwho'];
    if( Share::share($username, $sharename)){
        echo json_encode(array(
            "success" => true
        ));
        exit;
    }else{
        echo json_encode(array(
            "success" => false,
            "message" => "Invalid user to share or to share with."
        ));
        exit;
    }
?>