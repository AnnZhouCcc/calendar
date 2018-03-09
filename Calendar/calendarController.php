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
	}
?>