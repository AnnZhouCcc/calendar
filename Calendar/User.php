<?php
	// User class, consists all the fields and methods user needs.
	class User{
		public $username;
		public $email;
		// primary constructor, remain empty intentionally
		function __construct(){
		}
		
		/**
		 * This function will regester a user.
		 */
		Static function register($username,$email,$password){
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
		
		/**
		 * If the username and password matche, this function will create session for a user and return true
		 * If the doesn't match, return false
		 */
		Static function login($username,$submitPassword){
			include "global.php";
			sessionCheckStart();
			
			//$mysqli = new mysqli('localhost', 'M5', '123456', 'Calendar');
			//if($mysqli->connect_errno) {
			//	printf("Connection Failed: %s\n", $mysqli->connect_error);
			//	exit;
			//}
			
			// fetch password from database
			$stmt = $mysqli->prepare("SELECT password FROM Users WHERE username=?");
			if(!$stmt){
				//printf("Query Prep Failed: %s\n", $mysqli->error);
				//exit;
				return false;
			}
			
			//// Bind the parameter
			$stmt->bind_param('s', $username);

			$stmt->execute();
			
			// Bind the results
			$stmt->bind_result($realPassword);
			
			//fetch from database, if user does not exist, alert error.
			if(!$stmt->fetch()){
				//echo "User does not exist, try again";
				//$_SESSION['debug']="fetch";
				return false;
			}
			
			// check password,
			// alert error message if password is wrong and return false,
			// return true if password is correct
			$check = password_verify($submitPassword, $realPassword);
			if($check){
				// Login succeeded!
				//echo(password_verify($realPassword, $submitPassword));
				
				$_SESSION['token'] = substr(md5(rand()), 0, 10);
				$_SESSION['username'] = $username;
				$_SESSION['calendarUser']=$username;
				return true;
			} else{
				// Login failed
					//echo "Wrong password, try again";
					//echo(password_verify($realPassword, $submitPassword));
					////echo("msg2 ".$check);
					//echo ("realpw: ".$realPassword);
					//echo ("submitpw: ".$submitPassword);
				//$_SESSION['debug']="password";
				return false;
			}
		}
		
		/**
		 *	This function will destroy user's session
		 */
		Static function logout(){
			include "global.php";
			sessionCheckStart();
			//echo ("user php logout");
			//echo $_SESSION['username'];
			
			if(isset($_SESSION['username'])){
				unset($_SESSION['username']);
				//echo $_SESSION['username'];
				session_unset();
				session_destroy();
			}
			
			//check whether session destroyed
			if (isset($_SESSION['username'])) {
				return false;
			} else{
				return true;
			}
		}
		
		/**
		 * This function fetch a user by its user name from database
		 * return a User, if no user exist, return null;
		 */
		static function fetchUserByUsername($username){
			require "global.php";
			$user = new User();
			
			// check if user exist, if not return null;
			if(!User::WhetherUserExists($username)){
				return $user;
			}
			
			// if user exist, fetch information from database
			$stmt = $mysqli -> prepare("SELECT username,email from Users WHERE username = ?");
			$stmt->bind_param('s',$username);
			$stmt->execute();
			$stmt->bind_result($username,$email);
			$stmt->fetch();
			
			// put data into the object and return
			$user->userName =$username;
			$user->email = $email;
			return $user;
		}
		
		/**
		 * This function return curren User from session
		 * return the user current logged in, if no user have logged in, return null
		 */
		static function getCurrentUser(){
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			if(isset($_SESSION["userName"])){
				return User::fetchUserByUserName($_SESSION["userName"]);
			}
			$userName = $_SESSION["userName"];
			return User::fetchUserByUserName($userName);
			
		}
	}
?>