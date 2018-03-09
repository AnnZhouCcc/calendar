<?php
	// Event class
	class Event{
		public $id;
		public $title;
		public $time;
		public $category;
		function __construct(){
		}
		
		// As user and goup are not avaliable yet, this only create other details.
		// a user or group should be added in future.
		static function createFull($id,$title,$time,$category){
			$result = new Event();
			$result->id=$id;
			$result->title = $title;
			$result->time = $time;
			$result->category = $category;
			return $result;
		}
		
		// this function will return all the events in a day
		// param: 
		// return: a array of Events
		static function fetchDay($date){
			include "global.php";
			$resultEvents=array();
			//echo $date;
			$stmt = $mysqli->prepare("SELECT id,title,time,category FROM Events WHERE time>=? AND time<DATE_ADD(?,INTERVAL 1 DAY)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('ss',$date,$date);
			$stmt->bind_result($id,$title,$time,$category);
			$stmt->execute();
			while($stmt->fetch()){
				$resultEvents[] = Event::createFull($id,$title,$time,$category);
			}
			$stmt->close();
			//echo "I am here";
			return $resultEvents;
		}
		
		static function fetchByID($id){
		}
	}
?>