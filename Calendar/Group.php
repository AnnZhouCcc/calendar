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
			return $newGroup;
		}
		
		static function newgroup($username, $groupname){
			include "global.php";
				
			//check whether the username is valid, likely yes	
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				return false;
			}
			
			//check whether the group name is valid
			$isRepeated = False;
			$stmt0 = $mysqli->prepare("SELECT name FROM Groups WHERE EXISTS(SELECT name FROM Groups WHERE name=?)");
			if(!$stmt0){
				return false;
			}
			
			$stmt0->bind_param('s', $groupname);
				
			$stmt0->execute();
			
			$stmt0->bind_result($check_repetition);
			
			while($stmt0->fetch()){
				if ($check_repetition == $groupname){
					$isRepeated = True;
				}
			}
				
			if($isRepeated == True){
				return false;
			} 

			//put the group information into both Groups and Group_users tables
			//1. insert groupname into the Groups table
			$stmt = $mysqli->prepare("insert into Groups (name) values (?)");
			if(!$stmt){
				return false;
			}
			
			$stmt->bind_param('s', $groupname);
			
			$stmt->execute();
			
			$stmt->close();
			
			//2. retrieve the correspondent group id
			$stmt1 = $mysqli->prepare("SELECT id FROM Groups WHERE name=?");
			if(!$stmt1){
				return false;
			}
			
			$stmt1->bind_param('s', $groupname);
				
			$stmt1->execute();
			
			$stmt1->bind_result($output_groupid);
			
			$stmt1->fetch();
			
			$stmt1->close();
			
			//3. insert group id and the very first group member into Group_users
			$stmt2 = $mysqli->prepare("insert into Group_users (Users_username, Groups_id) values (?,?)");
			if(!$stmt2){
				return false;
			}
			
			$stmt2->bind_param('si', $username, $output_groupid);
			
			$stmt2->execute();
			
			$stmt2->close();
			
			//woohoo
			return true;
		}
		
		static function addmember($username, $membername, $groupname){
			include "global.php";
				
			//check whether the username is valid, likely yes	
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				//echo "D";
				return false;
			}
			
			//check whether the user is already a member of the group
			//1. retrieve the group id
			$stmt0 = $mysqli->prepare("SELECT id FROM Groups WHERE name=?");
			if(!$stmt0){
				//echo "C";
				return false; //if the group name is non existent, it should come to this false
			}
			
			$stmt0->bind_param('s', $groupname);
				
			$stmt0->execute();
			
			$stmt0->bind_result($outputt_groupid); //double t here
			
			$stmt0->fetch();
			
			$stmt0->close();
			
			//2. check Group_users table to see whether this user belongs to the group
			$isMember = False;
			$stmt1 = $mysqli->prepare("SELECT Users_username FROM Group_users WHERE Groups_id=?");
			if(!$stmt1){
				//echo 'B';
				return false;
			}
			
			$stmt1->bind_param('i', $outputt_groupid);
				
			$stmt1->execute();
			
			$stmt1->bind_result($check_match);
			
			while($stmt1->fetch()){
				if ($check_match == $username){
					$isMember = True;
				}
			}
				
			if($isMember == False){
				//echo "A";
				return false;
			} 

			//put added member information into table
			$stmt = $mysqli->prepare("insert into Group_users (Users_username, Groups_id) values (?, ?)");
			if(!$stmt){
				//echo "E";
				return false;
			}
			
			$stmt->bind_param('si', $membername, $outputt_groupid);
			
			$stmt->execute();
			
			$stmt->close();
			
			//woohoo
			return true;
		}
		
		// return an array of group objects related to the according to the current calendar user based on session.
		// this needs to be modified when adding share calendar function.
		static function getUserGroups(){
			include "global.php";
			sessionCheckStart();
			$user = $_SESSION["calendarUser"];
			$user = "test";
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
				//echo $id;
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
			//echo $name.$id;
			return Group::newFull($id,$name);
		}
	}
?>