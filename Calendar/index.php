<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	
	<style>
		#addevent00 { display:none }
		#addevent01 { display:none }
		#addevent02 { display:none }
		#addevent03 { display:none }
		#addevent04 { display:none }
		#addevent05 { display:none }
		#addevent06 { display:none }
		#addevent10 { display:none }
		#addevent11 { display:none }
		#addevent12 { display:none }
		#addevent13 { display:none }
		#addevent14 { display:none }
		#addevent15 { display:none }
		#addevent16 { display:none }
		#addevent20 { display:none }
		#addevent21 { display:none }
		#addevent22 { display:none }
		#addevent23 { display:none }
		#addevent24 { display:none }
		#addevent25 { display:none }
		#addevent26 { display:none }
		#addevent30 { display:none }
		#addevent31 { display:none }
		#addevent32 { display:none }
		#addevent33 { display:none }
		#addevent34 { display:none }
		#addevent35 { display:none }
		#addevent36 { display:none }
		#addevent40 { display:none }
		#addevent41 { display:none }
		#addevent42 { display:none }
		#addevent43 { display:none }
		#addevent44 { display:none }
		#addevent45 { display:none }
		#addevent46 { display:none }
		#addevent50 { display:none }
		#addevent51 { display:none }
		#addevent52 { display:none }
		#addevent53 { display:none }
		#addevent54 { display:none }
		#addevent55 { display:none }
		#addevent56 { display:none }
	</style>
	
	<script src="global.js" type="text/javascript"></script>
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" /> <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script><!-- The main library.  Note: must be listed before the jquery-ui library -->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script><!-- jquery-UI  hosted on Google's Ajax CDN-->
	<!-- Note: you can download the javascript file from the link provided on the google doc, or simply provide its URL in the src attribute (microsoft and google also host the jQuery library-->
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
		
		<script type="text/javascript" src="groupController.js"></script> <!-- load the JavaScript file -->

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
	
	for($week =0; $week<6;$week++){
		for($day = 0;$day < 7;$day++){
	?>
	
	<div id="<?php echo 'addevent'.$week.$day;?>" title="Add Event">
		You are logged in as: <?php echo $_SESSION['username'];?>
		ID of the form is: <?php echo 'addevent'.$week.$day;?>
		<input type="text" id="<?php echo 'title'.$week.$day;?>" placeholder="Title" />
		<input type="time" id="<?php echo 'time'.$week.$day;?>" placeholder="Time" />
		<input type="radio" class="addeventcat" name="work" id="<?php echo 'cat_work'.$week.$day;?>" value="work"> work<br>
		<input type="radio" class="addeventcat" name="study" id="<?php echo 'cat_study'.$week.$day;?>" value="study"> study<br>
		<input type="radio" class="addeventcat" name="entertainment" id="<?php echo 'cat_entertainment'.$week.$day;?>" value="entertainment"> entertainment<br>
		<input type="radio" class="addeventcat" name="others" id="<?php echo 'cat_others'.$week.$day;?>" value="others"> others<br>
		<input type="text" id="<?php echo 'gpname'.$week.$day;?>" placeholder="Group name (if applicable)" />
		<input type="hidden" id="<?php echo 'addeventuser'.$week.$day;?>" value="<?php echo $_SESSION['username'];?>" />

		<button id="<?php echo 'addevent_btn'.$week.$day;?>">Submit</button><br>
	</div>
	
	<?php
		}
	}
	?>
	
	<!--<p>trial</p>-->
	
	<!--<table>-->
	<!--	<tr>-->
	<!--		<th> Sun</th>-->
	<!--		<th> Mon</th>-->
	<!--	</tr>-->
	<!--	<tr>-->
	<!--		<td name=week10day1> <p id=01> 01 </p></td>-->
	<!--		<td name=week10day2> <p id=02> 02 </p></td>-->
	<!--	</tr>-->
	<!--	<tr>-->
	<!--		<td name=week10day3> <p id=03> 03 </p></td>-->
	<!--		<td name=week10day4> <p id=04> 04 </p></td>-->
	<!--	</tr>-->
	<!--</table>-->
	
	<script type="text/javascript" src="calendarController.js"></script>
	
	<script type="text/javascript" src="eventController.js"></script>
	
	<button id="previous_month_btn">previous month</button>
	<p>this month<p>
	<button id="next_month_btn">next month</button>
	<script type="text/javascript" src="calendarController.js"></script>

</body>
</html>