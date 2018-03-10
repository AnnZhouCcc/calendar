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
		
		static function newGroup($usernname, $groupname){
			include "global.php";
					
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				//echo "Username is invalid";
				return false;
			}
			
			$isRepeated = False;
			$stmt0 = $mysqli->prepare("SELECT username FROM Users WHERE EXISTS(SELECT username FROM Users WHERE username=?)");
			if(!$stmt0){
				return false;
			}
			
			$stmt0->bind_param('s', $username);
				
			$stmt0->execute();
			
			$stmt0->bind_result($check_repetition);
			
			while($stmt0->fetch()){
				//echo $check_existence;
				if ($check_repetition == $username){
					$isRepeated = True;
				}
			}
				
			if($isRepeated == True){
				return false;
			} 
			
			$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt = $mysqli->prepare("insert into Users (username, email, password) values (?, ?, ?)");
			if(!$stmt){
				//printf("Query Prep Failed: %s\n", $mysqli->error);
				//exit;
				return false;
			}
			
			$stmt->bind_param('sss', $username, $email, $hashedpassword);
			
			$stmt->execute();
			
			$stmt->close();
			
			//check whether added
			$isFound = False;
			$stmt1 = $mysqli->prepare("SELECT username FROM Users WHERE EXISTS(SELECT username FROM Users WHERE username=?)");
			if(!$stmt1){
					//printf("Query Prep Failed: %s\n", $mysqli->error);
					//exit;
					return false;
			}
			
			$stmt1->bind_param('s', $username);
				
			$stmt1->execute();
			
			$stmt1->bind_result($check_existence);
			//echo $check_existence;
			//echo $username;
			
			while($stmt1->fetch()){
				//echo $check_existence;
				if ($check_existence == $username){
					$isFound = True;
				}
			}
				
			if($isFound == True){
				return true;
			} else{
				return false;
			}
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