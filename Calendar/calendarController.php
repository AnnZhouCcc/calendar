<?php
	require "global.php";
	$type = $_POST["type"];
	switch ($type){
		case "fetchDay":{
					ini_set('display_errors',1);
		error_reporting(E_ALL);
			$time = $_POST["time"];
			//echo json_encode($time);
			$Events=Event::fetchDay($time);
			echo json_encode($Events);
		}
		
		case "addevent":{
			$username = $_POST['username'];
			$title = $_POST['title'];
			$time = $_POST['time'];
			$date = $_POST['post'];
			$cat = $_POST['cat'];
			
			if ($_POST['groupname'] == null) {
				if( Calendar::addeventindiv($username, $title, $date, $time, $cat)){
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
				if( Calendar::addeventgroup($username, $title, $date, $time, $cat, $groupname)){
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
		}
	}
?>