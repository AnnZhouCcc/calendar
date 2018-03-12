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
		function showaddevent() {
			$("#addevent").dialog();
		}
	</script>
</head>

<body>

<?php
	require_once "global.php";
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
	Calendar::showCalendar();
	
	?>
		<input type="button" value="Show Add Event" onclick=showaddevent() /> 
	    <div id="addevent" title="Add Event">
			<input type="text" id="title" placeholder="Title" />
			<input type="time" id="time" placeholder="Time" />
			<input type="radio" class="addeventcat" name="work"> work<br>
			<input type="radio" class="addeventcat" name="study"> study<br>
			<input type="radio" class="addeventcat" name="entertainment"> entertainment<br>
			<input type="radio" class="addeventcat" name="others"> others<br>
			<input type="text" id="gpname" placeholder="Group name (if applicable)" />
			<input type="hidden" name="addeventuser" value="<?php echo $_SESSION['username'];?>" />
			<button id="addevent_btn">Submit</button><br>
		</div>
		
		<script type="text/javascript" src="calendarController.js"></script>
  
		<button id="previous_month_btn">previous month</button>
		<p>this month<p>
		<button id="next_month_btn">next month</button>
		<script type="text/javascript" src="calendarController.js"></script>
	<?php
	
?>

</body>
</html>

<!--	1. copy over the showCalendar code for testing
	2. settle the form under div
	2.4 get username from session
	2.5. pass the clicked value automatically
	3. able to submit form
	4. add click to date-->
