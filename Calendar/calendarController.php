<?php
	require "global.php";
	sessionCheckStart();
	$type = $_POST["type"];
	//echo "type: ".$type;
	switch ($type){
		case "fetchDay":{
					ini_set('display_errors',1);
		error_reporting(E_ALL);
			$time = $_POST["time"];
			//echo json_encode($time);
			$Events=Event::fetchDay($time);
			echo json_encode($Events);
			break;
		}
		
		case "fetchpkofevent":{
			//echo "into calendarcontroller php fetchpkofevent";
			
			$username = $_SESSION['username'];
			$title = $_POST['title'];
			$datetime = $_POST['datetime'];
			$cat = $_POST['cat'];
				
			$pkid = Event::fetchpk($username, $title, $datetime, $cat);
			echo json_encode($pkid);
			break;
		}
	}
?>