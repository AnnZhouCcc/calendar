<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	<script src="global.js" type="text/javascript"></script>
</head>

<body>

<?php
	require_once "global.php";
	
	// This is the home page for the calendar website
	// Users can and only can see this page but not others.
	
	// top navigation bar: include login, regester button or logout buttion
	// no implemented yet
	?>
		<input type="text" id="username" placeholder="Username" />
		<input type="password" id="password" placeholder="Password" />
		<button id="login_btn">Log In</button><br>
		<script type="text/javascript" src="userController.js"></script> <!-- load the JavaScript file -->
		
		<input type="text" id="regusername" placeholder="Username" />
		<input type="password" id="regpassword" placeholder="Password" />
		<input type="text" id="regemail" placeholder="Email" />
		<button id="reg_btn">Register</button>
		<script type="text/javascript" src="userController.js"></script> <!-- load the JavaScript file -->
	<?php
	
	
	// side navigation bar:
	// show/ not show certain type of event
	// show others' calendar
	// other functions
	// not implemented yet
	?>
	
	<?php
	
	
	// calendar:
	// show the calendar
	// not implemented yet
	Calendar::showCalendar();
	?>
		<button id="last_month_btn">last month</button>
		<p>this month<p>
		<button id="next_month_btn">next month</button>
		<script type="text/javascript" src="calendarController.js"></script>
	<?php
	
?>

</body>
</html>
