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
		
		#registerform { display:none }
		#loginform { display:none }
	</style>
	
	<script src="global.js" type="text/javascript"></script>
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" /> <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script><!-- The main library.  Note: must be listed before the jquery-ui library -->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script><!-- jquery-UI  hosted on Google's Ajax CDN-->
	<!-- Note: you can download the javascript file from the link provided on the google doc, or simply provide its URL in the src attribute (microsoft and google also host the jQuery library-->

	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="global.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<script>
		$.noConflict();
	$( function() {
	  $( "#dialog" ).dialog({
		autoOpen: false,
	  });
   
	  $( "#opener" ).on( "click", function() {
		$( "#dialog" ).dialog( "open" );
	  });
	} );
	</script>
</head>

<body>
	<?php
		//require_once "global.php";
		include "global.php";
		sessionCheckStart();
	?>
	<!--Top navigation bar-->
	<ul class="navBar">
		<?php
			if(isset($_SESSION['username'])){
				?>
				<li class="navRight"><a class="navElement" id="logout_btn">Logout   <i class="material-icons">directions_run</i></a></li>
				
				<script type="text/javascript" src="userController.js"></script>
				<?php
			}else{
				?>
				<li class="navRight"><a class="navElement" id="login_dialog">Login   <i class="material-icons">person</i></a></li>
				<li class="navRight"><a class="navElement" id="register_dialog">Register   <i class="material-icons">person_add</i></a></li>
				
				<script type="text/javascript" src="calendarController.js"></script>
				<?php
			}
		?>
	</ul>
<?php
	//sessionCheckStart();


	
	
	//$_SESSION["username"] = "renhao";
	//$_SESSION["calendarUser"] = "renhao";
	// This is the home page for the calendar website
	// Users can and only can see this page but not others.
	
	// top navigation bar: include login, regester button or logout buttion
	// no implemented yet
	?>
	
	<div id="registerform" title="Register">
		<input type="text" id="regusername" placeholder="Username" />
		<input type="password" id="regpassword" placeholder="Password" />
		<input type="text" id="regemail" placeholder="Email" />
		<button id="reg_btn">Register</button><br>
	</div>
		
	<div id="loginform" title="Login">
		<input type="text" id="username" placeholder="Username" />
		<input type="password" id="password" placeholder="Password" />
		<button id="login_btn">Log In</button><br> 
	</div>
	
	<script type="text/javascript" src="userController.js"></script>
	
	<div class="topBar">
		<input type="text" id="newgroupname" placeholder="Group Name" />
		<button id="newgroup_btn">Create Group</button><br>
		
		<input type="text" id="addgroupname" placeholder="Group Name" />
		<input type="text" id="addgroupmember" placeholder="Group Member" />
		<button id="addmember_btn">Add Member</button><br>
		
		<script type="text/javascript" src="groupController.js"></script> <!-- load the JavaScript file -->
	</div
	<?php
	
	
	// side navigation bar:
	// show/ not show certain type of event
	// show others' calendar
	// other functions
	// not implemented yet
	?>
	<div class="sideBar">
		<input type="checkbox" class="categoriesCheckBox" name="workCheckbox"> work<br>
		<input type="checkbox" class="categoriesCheckBox" name="studyCheckbox"> study<br>
		<input type="checkbox" class="categoriesCheckBox" name="entertainmentCheckbox"> entertainment<br>
		<input type="checkbox" class="categoriesCheckBox" name="othersCheckbox"> others<br>
	</div>
	<?php
	
	
	// calendar:
	// show the calendar
	// not implemented yet
	//Calendar::showCalendar();
	
	for($week =0; $week<6;$week++){
		for($day = 0;$day < 7;$day++){
	?>
	
	<div id="<?php echo 'addevent'.$week.$day;?>" title="Add Event">
		<input type="text" id="<?php echo 'title'.$week.$day;?>" placeholder="Title" /><br>
		<input type="time" id="<?php echo 'time'.$week.$day;?>" placeholder="Time" /><br>
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
	
	<script type="text/javascript" src="eventController.js"></script>
	
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
	
	You are logged in as: <?php echo $_SESSION['username'];?>
	
	<div class="calendar">
		<div class = "CalendarButtons">
		<button id="previous_month_btn">previous month</button>
		<label>this month</label>
		<button id="next_month_btn">next month</button>
		
		</div>
	<?php
	Calendar::showCalendar();
	?>
	<script type="text/javascript" src="calendarController.js"></script>
	</div>



</body>
</html>