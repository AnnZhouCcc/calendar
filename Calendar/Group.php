<?php
	class Group{
		public $id;
		public $name;
		function __construct(){
		}
		
		static function newFull($id,$name){
			$newGroup = new Group();
			$newGroup->id = $id;
			$newGroup->name= $name;
		}
		
		// return an array of group objects related to the according to the current calendar user based on session.
		// this needs to be modified when adding share calendar function.
		static function getUserGroups(){
			include "global.php";
			sessionCheckStart();
			$user = $_SESSION["calendarUser"];
			$resultGroups=array();
			$stmt = $mysqli->prepare("SELECT Groups_id FROM Group_users WHERE Users_username = ?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			//$stmt->bind_param('s',$user->username); // use this after session contains User class
			$stmt->bind_param('s',$user);
			$stmt->bind_result($id);
			$stmt->execute();
			while($stmt->fetch()){
				$resultGroups[] = Group::fetchGroupbyID($id);
			}
			$stmt->close();
			//echo "I am here";
			return $resultGroups;
		}
		
		static function fetchGroupbyID($id){
			include "global.php";
			$stmt = $mysqli->prepare("SELECT name FROM Groups WHERE id = ?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('i',$id);
			$stmt->bind_result($name);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();
			return Group::newFull($id,$name);
			//echo "I am here";
		}
	}
?>