<?php
	//this is a Calendar class
	//This class will contain all the information about the calendar and provide methods to show the calendar.
	class Calendar{
		public $currentUser;
		public $showUser;
		public $categories;
		
		function __construct(){
			
		}
		
		
		static function showCalendar(){
			echo "<table name = \"calendar\">";
			?>
			<tr>
			  <th>Sun</th>
			  <th>Mon</th> 
			  <th>Tue</th>
			  <th>Wed</th>
			  <th>Thu</th>
			  <th>Fri</th>
			  <th>Sat</th>
			</tr>
			<?php
			for($week =0;$week<6;$week++){
				echo "<tr name=\"week".$week."\">";
					for($day = 0;$day < 7;$day++){
						echo "<td name=\"week".$week."day".$day."\">";
							echo "<p>".$week.$day."</p>";
						echo "</td>";
					}
				echo "</tr>";
			}
			echo "</table>";
			?>
			<?php
		}
		
		static function addeventindiv($username, $title, $time, $cat) {
			$datetime = "1000-01-01 ".$time;
			$stmt = $mysqli->prepare("insert into Events (title, time, category, Users_username) values (?, ?, ?, ?)");
			if(!$stmt){
				return false;
			}
			
			$stmt->bind_param('ssss', $title, $datetime, $cat, $username);
			
			$stmt->execute();
			
			$stmt->close();
			
			return true;
		}
		
		static function addeventgroup($username, $title, $time, $cat, $groupname) {
			$datetime = "1000-01-01 ".$time;
			
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
	}
	
	// this is an enum that provide categories
	class Categories{
		const work = 0;
		const study = 1;
		const enterainment = 2;
		const others =3;
	}
?>