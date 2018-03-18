<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	
	<style>
		#addevent { display:none }
	</style>
	
	<script src="global.js" type="text/javascript"></script>
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" /> <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script><!-- The main library.  Note: must be listed before the jquery-ui library -->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script><!-- jquery-UI  hosted on Google's Ajax CDN-->
	<!-- Note: you can download the javascript file from the link provided on the google doc, or simply provide its URL in the src attribute (microsoft and google also host the jQuery library-->
	<script type="text/javascript">
		function showaddevent(clicked_id) {
			$("#addevent").dialog();
			alert(clicked_id);
			$.post("eventController.php",
			{
			  date: clicked_id
			});
		}
		
		//With help from:
		//https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_ajax_post
		$(document).ready(function(){
			$("button").click(function(){
				$.post("demo_test_post.asp",
				//$.post("eventController.php",
				{
				  name: "Donald Duck",
				  city: "Duckburg"
				},
				function(data,status){
					alert("Data: " + data + "\nStatus: " + status);
				});
			});
		});
		
		//With help from:
		//https://stackoverflow.com/questions/4825295/javascript-onclick-to-get-the-id-of-the-clicked-button
		function reply_click(clicked_id)
		{
			alert(clicked_id);
		}
		
		$(document).ready(function(){
			$("p").click(function(){
				$(this).hide();
				//$(this).showaddevent();
			});
		});
	
		//With help from:
		//https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_click
		//https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_ajax_post
		$(document).ready(function(){
			//$("p").click(function(){
			$("#date").click(function(){
				$(this).showaddevent();
				//$.post("demo_test_post.asp",
				//$.post("eventController.php",
				//{
				//  date: currdate()
				//});
			});
		});
		
		//With help from:
		//https://stackoverflow.com/questions/9012537/how-to-get-the-element-clicked-for-the-whole-document
		//https://stackoverflow.com/questions/16091823/get-clicked-element-using-jquery-on-event
		function currdate() {
			$(document).click(function(event) {
				return $(event.target).text();
			});
		}
		
		//$(document).ready(function(){
		//	$("button").click(function(){
		//		$.post("demo_test_post.asp",
		//		{
		//		  name: "Donald Duck",
		//		  city: "Duckburg"
		//		},
		//		function(data,status){
		//			alert("Data: " + data + "\nStatus: " + status);
		//		});
		//	});
		//});
	</script>
</head>

<body>

<?php
	require_once "global.php";
	sessionCheckStart();
	//$_SESSION["username"] = "renhao";
	//$_SESSION["calendarUser"] = "renhao";
	// This is the home page for the calendar website
	// Users can and only can see this page but not others.
	
	// top navigation bar: include login, regester button or logout buttion
	// no implemented yet
	?>
		<input type="text" id="username" placeholder="Username" />
		<input type="password" id="password" placeholder="Password" />
		<!--<input type="hidden" id="login" value="login" />-->
		<button id="login_btn">Log In</button><br> 
		
		<input type="text" id="regusername" placeholder="Username" />
		<input type="password" id="regpassword" placeholder="Password" />
		<input type="text" id="regemail" placeholder="Email" />
		<!--<input type="hidden" id="register" value="register" />-->
		<button id="reg_btn">Register</button><br>
		
		<!--<input type="hidden" id="register" value="register" />-->
		<button id="logout_btn">Log Out</button><br>
		
		<script type="text/javascript" src="userController.js"></script> <!-- load the JavaScript file -->
		
		<input type="text" id="newgroupname" placeholder="Group Name" />
		<button id="newgroup_btn">Create Group</button><br>
		
		<input type="text" id="addgroupname" placeholder="Group Name" />
		<input type="text" id="addgroupmember" placeholder="Group Member" />
		<button id="addmember_btn">Add Member</button><br>
		
<<<<<<< HEAD
		<script type="text/javascript" src="groupController.js"></script> <!-- load the JavaScript file -->
=======
>>>>>>> 312a273eaaf8e2d7392834cdc3fc78b0532b18c4
	<?php
	
	
	// side navigation bar:
	// show/ not show certain type of event
	// show others' calendar
	// other functions
	// not implemented yet
	?>
		<input type="checkbox" class="categoriesCheckBox" name="workCheckbox"> work<br>
		<input type="checkbox" class="categoriesCheckBox" name="studyCheckbox"> study<br>
		<input type="checkbox" class="categoriesCheckBox" name="entertainmentCheckbox"> entertainment<br>
		<input type="checkbox" class="categoriesCheckBox" name="othersCheckbox"> others<br>
		
	<?php
	
	
	// calendar:
	// show the calendar
	// not implemented yet
	//Calendar::showCalendar();
	
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
					echo "<button id=".$week.$day." onclick='showaddevent(this.id)'>".$week.$day."</button>";
					//echo "<button id=".$week.$day." onclick='showaddevent()'>".$week.$day."</button>";
				echo "</td>";
			}
		echo "</tr>";
	}
	echo "</table>";
	
	echo "<p> text </p>";
	?>
	
		<input type="button" value="Show Add Event" onclick=showaddevent() />
	    <div id="addevent" title="Add Event">
			You are logged in as: <?php echo $_SESSION['username'];?>
			<input type="text" id="title" placeholder="Title" />
			<input type="time" id="time" placeholder="Time" />
			<input type="radio" class="addeventcat" name="work" id="cat_work" value="work"> work<br>
			<input type="radio" class="addeventcat" name="study" id="cat_study" value="study"> study<br>
			<input type="radio" class="addeventcat" name="entertainment" id="cat_entertainment" value="entertainment"> entertainment<br>
			<input type="radio" class="addeventcat" name="others" id="cat_others" value="others"> others<br>
			<input type="text" id="gpname" placeholder="Group name (if applicable)" />
			<input type="hidden" id="addeventuser" value="<?php echo $_SESSION['username'];?>" />
			<button id="addevent_btn">Submit</button><br>
		</div>
		
		<script type="text/javascript" src="eventController.js"></script>
		
		<button id="previous_month_btn">previous month</button>
		<p>this month<p>
		<button id="next_month_btn">next month</button>
		<script type="text/javascript" src="calendarController.js"></script>

</body>
</html>

<!--	1. [DONE] copy over the showCalendar code for testing
	2. [DONE] settle the form under div
	2.4 [DONE] get username from session
	2.5. pass the clicked value automatically
	3. [DONE] able to submit form
	4. [DONE] add click to date-->
