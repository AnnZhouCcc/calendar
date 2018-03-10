<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	<script src="global.js" type="text/javascript"></script>
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
		<button id="previous_month_btn">previous month</button>
		<p>this month<p>
		<button id="next_month_btn">next month</button>
		<script type="text/javascript" src="calendarController.js"></script>
	<?php
	
?>

</body>
</html>
