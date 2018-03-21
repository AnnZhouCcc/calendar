<?php
	// Event class
	interface Comparable {
    public function compareTo($other);
}
	class Event implements Comparable{
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
		
		static function addeventindiv($username, $title, $date, $time, $cat) {
			include "global.php";
			
			echo "into Event php addeventindiv";
			
			if ($username == null){
				echo "username is null";
				return false;
			}
			
			$datetime = $date." ".$time.":00";
			$stmt = $mysqli->prepare("insert into Events (title, time, category, Users_username) values (?, ?, ?, ?)");
			if(!$stmt){
				prinf ("Query Prep Failed: %s\n", $mysqli->error);
				return false;
			}
			
			echo $title;
			echo $datetime;
			echo $cat;
			echo $username;
			
			$stmt->bind_param('ssss', $title, $datetime, $cat, $username);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		static function addeventgroup($username, $title, $date, $time, $cat, $groupname) {
			include "global.php";
			
			if ($username == null){
				return false;
			}
			
			$datetime = $date." ".$time.":00";
			
			//the following chunk can potentially be summarized as a method under Group.php named fetchGroupIDByName
			$stmt0 = $mysqli->prepare("SELECT id FROM Groups WHERE name=?");
			if(!$stmt0){
				return false; //if the group name is non existent, it should come to this false
			}
			
			$stmt0->bind_param('s', $groupname);
				
			$stmt0->execute();
			
			$stmt0->bind_result($outputtt_groupid); //triple t here
			
			$stmt0->fetch();
			
			$stmt0->close();
			
			$stmt = $mysqli->prepare("insert into Events (title, time, category, Users_username, Groups_id) values (?, ?, ?, ?, ?)");
			if(!$stmt){
				return false;
			}
			
			$stmt->bind_param('ssssi', $title, $datetime, $cat, $username, $outputtt_groupid);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		static function modeventindiv($eventID, $username, $title, $date, $time, $cat) {
			include "global.php";
			
			if ($username == null){
				echo "username is null";
				return false;
			}
			
			$datetime = $date." ".$time.":00";
			$stmt = $mysqli->prepare("update Events set title=?, time=?, category=?, Users_username=? where id=?");
			if(!$stmt){
				prinf ("Query Prep Failed: %s\n", $mysqli->error);
				return false;
			}
			
			//echo $title;
			//echo $datetime;
			//echo $cat;
			//echo $username;
			
			$stmt->bind_param('ssssi', $title, $datetime, $cat, $username, $eventID);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		static function modeventgroup($eventID, $username, $title, $date, $time, $cat, $groupname) {
			include "global.php";
			
			if ($username == null){
				return false;
			}
			
			$datetime = $date." ".$time.":00";
			
			//the following chunk can potentially be summarized as a method under Group.php named fetchGroupIDByName
			$stmt0 = $mysqli->prepare("SELECT id FROM Groups WHERE name=?");
			if(!$stmt0){
				return false; //if the group name is non existent, it should come to this false
			}
			
			$stmt0->bind_param('s', $groupname);
				
			$stmt0->execute();
			
			$stmt0->bind_result($outputtt_groupid); //triple t here
			
			$stmt0->fetch();
			
			$stmt0->close();
			
			$stmt = $mysqli->prepare("update Events set title=?, time=?, category=?, Users_username=?, Groups_id=? where id=?");
			if(!$stmt){
				return false;
			}
			
			$stmt->bind_param('ssssii', $title, $datetime, $cat, $username, $outputtt_groupid, $eventID);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		static function deleteevent($eventID) {
			include "global.php";
			
			$stmt = $mysqli->prepare("delete from Events where id=?");
			if(!$stmt){
				prinf ("Query Prep Failed: %s\n", $mysqli->error);
				return false;
			}
			
			$stmt->bind_param('i', $eventID);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		// this function will return all the events in a day
		// param: 
		// return: a array of Events
		static function fetchDay($date){
			include "global.php";
			$resultEvents=array();
			$resultEvents = $resultEvents+self::fetchDayByUser($date);
			$resultEvents = $resultEvents+self::fetchDayByGroup($date);
			sort($resultEvents); // sort all events base on thier time.
			//echo "I am here";
			return $resultEvents;
		}
		
		private static function fetchDayByUser($date){
			include "global.php";
			$resultEvents=array();
			sessionCheckStart();
			if(isset($_SESSION["calendarUser"])){
				$username = $_SESSION["calendarUser"];
			}else{
				return $resultEvents;
			}
			
			//echo $date;
			$stmt = $mysqli->prepare("SELECT id,title,time,category FROM Events WHERE Users_username=? AND time>=? AND time<DATE_ADD(?,INTERVAL 1 DAY)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('sss',$username,$date,$date); //Change this after session use User class
			$stmt->bind_result($id,$title,$time,$category);
			$stmt->execute();
			while($stmt->fetch()){
				$resultEvents[] = Event::createFull($id,$title,$time,$category);
			}
			$stmt->close();
			//echo "I am here";
			return $resultEvents;
			
		}
		private static function fetchDayByGroup($date){
			include "global.php";
			$resultEvents=array();
			$groups = Group::getUserGroups();
			foreach($groups as $aGroup){
				$stmt = $mysqli->prepare("SELECT id,title,time,category FROM Events WHERE Groups_id=? AND time>=? AND time<DATE_ADD(?,INTERVAL 1 DAY)");
				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}
				$stmt->bind_param('sss',$aGroup->id,$date,$date);
				$stmt->bind_result($id,$title,$time,$category);
				$stmt->execute();
				while($stmt->fetch()){
					$resultEvents[] = Event::createFull($id,$title,$time,$category);
				}
				$stmt->close();
			}

			//echo "I am here";
			return $resultEvents;
			
		}
		
		
		static function fetchByID($id){
		}
		
		// compare two events base on their time.
		public function compareTo($other){
			if($value instanceof Event){
				if($self->time>$value->time){
					return 1;
				}
				if($self->time<$value->time){
					return -1;
				}else{
					return 0;
				}
			}
			else{
				echo "not a event type";
			}
		}
		
		static function fetchpk($username, $title, $datetime, $cat){
			//echo $username;
			//echo $title;
			//echo $datetime;
			//echo $cat;
			
			include "global.php";
			
			$stmt = $mysqli->prepare("SELECT id FROM Events WHERE title=? AND time=? AND category=? AND Users_username=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('ssss',$title, $datetime, $cat, $username);
			$stmt->bind_result($output_pkid);
			$stmt->execute();
			while($stmt->fetch()){
				$pkid = $output_pkid;
			}
			$stmt->close();
			return $pkid;
		}
		
		static function fetchEventByID($id){
			include 'global.php';
			$stmt = $mysqli->prepare("select title, time, category from Events WHERE id=?");
			$stmt->bind_param('i',$id);
			$stmt->execute();
			$stmt->bind_result($output_title,$output_time, $output_category);
			$stmt->fetch();
			$event = Event::createFull($id, $output_title, $output_time,$output_category);
	
			$stmt->close();
			return $event;
		}
	}
?>