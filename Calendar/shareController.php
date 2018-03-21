<?php
	require_once "global.php";
	
	header("Content-Type: application/json"); 

	sessionCheckStart();
	$type = $_POST['type'];
	switch( $type){
		case 'newShare':{
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
		}
		
		case "fetchShare":{
			$shares=Share::getShares($_SESSION['username']);
			echo json_encode($shares);
			break;
		}
		
		case "refreshCalendar":{
			$_SESSION['calendarUser']=$_POST['from'];
			break;
		}
	}

?>