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
	
			if(!hash_equals($_SESSION['token'], $_POST['token'])){
				die("<h3>Request forgery detected</h3>");
			}
					
			$userReg=$_POST['regusername'];
			if( !preg_match('/^[\w_\-]+$/', $userReg) ){
				?>
				<script>
					alert ("Username is invalid");
				</script>
				<?php
				exit;
			}
			
			require_once 'database.php';
			$name = $userReg;
			$pw = $_POST['regpassword'];
			$pass = password_hash($pw, PASSWORD_DEFAULT);
			$email = $_POST['regemail'];
			
			$stmt = $mysqli->prepare("insert into users (name, password, email) values (?, ?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt->bind_param('sss', $name, $pass, $email);
			
			$stmt->execute();
			
			$stmt->close();
			
			//check whether added
			$isFound = False;
			$stmt = $mysqli->prepare("SELECT name FROM users WHERE EXISTS(SELECT name FROM users WHERE email=?)");
			if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
			}
			
			$stmt->bind_param('i', $email);
				
			$stmt->execute();
			
			$stmt->bind_result($check_existence);
			
			while($stmt->fetch()){
				if ($check_existence == $name){
					$isMatched = True;
				}
			}
				
			if($isMatched == True){
				header('Location: http://ec2-52-14-68-17.us-east-2.compute.amazonaws.com/~annzhou/goodregister.php');
				exit;
			} else{
				header('Location: http://ec2-52-14-68-17.us-east-2.compute.amazonaws.com/~annzhou/badlogin.php');
				exit;
			}
		}
		
		/**
		 * If the username and password matche, this function will create session for a user and return true
		 * If the doesn't match, return false
		 */
		Static function login($username,$submitPassword){
			require_once "global.php";
			
			// fetch password from database
			$stmt = $mysqli->prepare("SELECT password FROM User WHERE username=?");
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
				?>
				<script>
					alert ("User does not exist, try again");
				</script>
				<?php
				return false;
			}
			
			// check password,
			// alert error message if password is wrong and return false,
			// return true if password is correct
			if(password_verify($realPassword, $submitPassword)){
				// Login succeeded!
				return true;
			} else{
				// Login failed
				?>
				<script>
					alert("Wrong password, try again");
				</script>
				<?php
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