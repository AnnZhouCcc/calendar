<?php
	class Share{
		public $share;
		public $user;
        
		function __construct(){
		}
		
		static function share($username, $sharename){
            //echo $username;
            //echo $sharename;
            
			include "global.php";
					
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				return false;
			}
            
            //check whether the person to share with is also registered
            $isMatched = False;
            $stmt_check = $mysqli->prepare("SELECT username FROM Users WHERE EXISTS(SELECT username FROM Users WHERE username=?)");      
            if(!$stmt_check) {
                return false;
            }
            $stmt_check->bind_param('s', $sharename);
            $stmt_check->execute();
            $stmt_check->bind_result($check_existence);
            while($stmt_check->fetch()){
                if ($check_existence == $sharename){
                    $isMatched = True;
                }
            }   
            if($isMatched == True){
                
                //we can proceed with putting info into share table
                $stmt = $mysqli->prepare("insert into Calendar_Share_Access (Users_username, share_with) values (?, ?)");
                if(!$stmt){
                    return false;
                }
                //echo $username;
                //echo $sharename;
                $stmt->bind_param('ss', $username, $sharename);
                $stmt->execute();
                $stmt->close();
                return true;
            
            } else{
                return false;
            }
        }
	}
?>