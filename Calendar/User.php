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
			require_once "global.php";
			
			?>
				<script>
					alert ("Here");
				</script>
			<?php
					
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				?>
				<script>
					alert ("Username is invalid");
				</script>
				<?php
				exit;
			}
			
			$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt = $mysqli->prepare("insert into Users (username, email, password) values (?, ?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt->bind_param('sss', $username, $hashedpassword, $email);
			
			$stmt->execute();
			
			$stmt->close();
			
			header('Location: index.php');
		}
		
		/**
		 * If the username and password matche, this function will create session for a user and return true
		 * If the doesn't match, return false
		 */
		Static function login($username,$submitPassword){
			include "global.php";
			
			//$mysqli = new mysqli('localhost', 'M5', '123456', 'Calendar');
			//if($mysqli->connect_errno) {
			//	printf("Connection Failed: %s\n", $mysqli->connect_error);
			//	exit;
			//}
			
			// fetch password from database
			$stmt = $mysqli->prepare("SELECT password FROM Users WHERE username=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			//// Bind the parameter
			$stmt->bind_param('s', $username);

			$stmt->execute();
			
			// Bind the results
			$stmt->bind_result($realPassword);
			
			//fetch from database, if user does not exist, alert error.
			if(!$stmt->fetch()){
				echo ("User does not exist, try again");
				//$_SESSION['debug']="fetch";
				return false;
			}
			
			// check password,
			// alert error message if password is wrong and return false,
			// return true if password is correct
			$check = password_verify($realPassword, $submitPassword);
			if($check){
				// Login succeeded!
				return true;
			} else{
				// Login failed
					echo ("Wrong password, try again");
					echo("msg1 ".password_verify($realPassword, $submitPassword));
					echo("msg2 ".$check);
					echo ("realpw: ".$realPassword);
					echo ("submitpw: ".$submitPassword);
				//$_SESSION['debug']="password";
				return false;
			}
			
			$_SESSION['token'] = substr(md5(rand()), 0, 10);
		}
		
		/**
		 *	This function will destroy user's session
		 */
		function logout(){
			require_once "global.php";
			
			if(isset($_SESSION['username'])){
					unset($_SESSION['username']);
					session_unset;
					session_destroy;
			}
			
			header('Location: index.php');
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