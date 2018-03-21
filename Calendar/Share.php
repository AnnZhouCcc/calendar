<?php
	class Share{
		public $share; // to
		public $user; //from
        
		function __construct(){
		}
		
		static function newShare($from, $to){
			$share = new Share();
			$share->user=$from;
			$share->share = $to;
			return $share;
		}
		
		static function getShares($to){
			$result = array();
			include "global.php";
			sessionCheckStart();
			
			//echo $date;
			$stmt = $mysqli->prepare("SELECT Users_username FROM Calendar_Share_Access WHERE share_with=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('s',$to); //Change this after session use User class
			$stmt->bind_result($from);
			$stmt->execute();
			while($stmt->fetch()){
				$result[] = Share::newShare($from,$to);
			}
			$stmt->close();
			//echo "I am here";
			return $result;
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
					//echo "A".$check_existence;
                    $isMatched = True;
                }
            }   
            if($isMatched == True){
                
				//check whether repeated
				$isRep = False;
				$stmt_check2 = $mysqli->prepare("SELECT share_with FROM Calendar_Share_Access WHERE EXISTS(SELECT share_with FROM Calendar_Share_Access WHERE Users_username=?)");      
				if(!$stmt_check2) {
					//echo "B";
					return false;
				}
				$stmt_check2->bind_param('s', $username);
				$stmt_check2->execute();
				$stmt_check2->bind_result($check_rep);
				while($stmt_check2->fetch()){
					if ($check_rep == $sharename){
						//echo "C".$check_rep;
						$isRep = True;
					}
				}   
				if($isRep == False){
				
					//we can proceed with putting info into share table
					$stmt = $mysqli->prepare("insert into Calendar_Share_Access (Users_username, share_with) values (?, ?)");
					if(!$stmt){
						//echo "F";
						return false;
					}
					//echo $username;
					//echo $sharename;
					$stmt->bind_param('ss', $username, $sharename);
					$stmt->execute();
					$stmt->close();
					return true;
            
				} else{
					//echo "D";
					return false;
				}
			} else{
				//echo "E";
				return false;
			}
        }
	}
?>