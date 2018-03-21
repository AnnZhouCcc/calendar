<?php
    //echo "A";
	require "global.php";
    //echo "B";
	$type = $_POST['type'];
    //echo "C";
    //echo $type;
	switch ($type){
		case "addevent":{
	//if ($type == 'addevent'){
            //echo "into addevent switch case";
			$username = $_POST['username'];
			//echo "username: ".$username;
			$title = $_POST['title'];
			//echo $title;
			$time = $_POST['time'];
			$date = $_POST['date'];
			//$date = "1000-01-01";
			$cat = $_POST['cat'];
			//echo $cat;
            
            //echo $date;
			//echo $username;
			
			if ($_POST['groupname'] == null) {
				if(Event::addeventindiv($username, $title, $date, $time, $cat)){
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
			} else {
				$groupname = $_POST['groupname'];
				if(Event::addeventgroup($username, $title, $date, $time, $cat, $groupname)){
					echo json_encode(array(
						"success" => true
					));
					exit;
				}else{
					echo json_encode(array(
						"success" => false,
						"message" => "Unauthorized"
					));
					exit;
				}
			}
			break;
		}
		
		case "deleteevent":{
			$eventID = $_POST['pk'];
			$username = $_POST['username'];
	
			if(Event::deleteevent($username, $eventID)){
				echo json_encode(array(
					"success" => true
				));
				exit;
			}else{
				echo json_encode(array(
					"success" => false,
					"message" => "Unauthorized"
				));
				exit;
			}
			
			break;
		}
		
		case "modevent":{
			$username = $_POST['username'];
			$title = $_POST['title'];
			$time = $_POST['time'];
			$date = $_POST['date'];
			$cat = $_POST['cat'];
			$eventID = $_POST['pk'];
			
			if ($_POST['groupname'] == null) {
				if(Event::modeventindiv($eventID, $username, $title, $date, $time, $cat)){
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
			} else {
				$groupname = $_POST['groupname'];
				if(Event::modeventgroup($eventID, $username, $title, $date, $time, $cat, $groupname)){
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
			break;
		}
	}
?>
