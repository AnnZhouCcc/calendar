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
			echo "<table name = \"calendar\" class = \"calendar\">";
			?>
			<tr class="calendar">
			  <th class="calendar">Sun</th>
			  <th class="calendar">Mon</th> 
			  <th class="calendar">Tue</th>
			  <th class="calendar">Wed</th>
			  <th class="calendar">Thu</th>
			  <th class="calendar">Fri</th>
			  <th class="calendar">Sat</th>
			</tr>
			<?php
			for($week =0;$week<6;$week++){
				echo "<tr name=\"week".$week."\" class = \"calendar\" >";
					for($day = 0;$day < 7;$day++){
							//echo "<button id=".$week.$day." onclick='showaddevent(this.id)'>".$week.$day."</button>";
						echo "<td name=\"week".$week."day".$day."\" class = \"calendar\" >";
							echo "<p id=".$week.$day.">".$week.$day."</p>";
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