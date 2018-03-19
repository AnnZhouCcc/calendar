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
							echo "<p id=".$week.$day.">".$week.$day."</p>";
							//echo "<button id=".$week.$day." onclick='showaddevent(this.id)'>".$week.$day."</button>";
						echo "</td>";
					}
				echo "</tr>";
			}
			echo "</table>";
			?>
			
			<!--<script type="text/javascript" src="calendarController.js"></script>-->
			
			<?php
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