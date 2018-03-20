<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="global.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<script>
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
		require_once "global.php";
		//sessionCheckStart();
	?>
	<!--Top navigation bar-->
	<ul class="navBar">
		<?php
			if(isset($_SESSION['username'])){
				?>
				<li class="navRight"><a class="navElement" id="logout_btn">Logout   <i class="material-icons">directions_run</i></a></li>
				<?php
			}else{
				?>
				<li class="navRight"><a class="navElement" href="userLoginPart1.php">Login   <i class="material-icons">person</i></a></li>
				<li class="navRight"><a class="navElement" href="userRegistrationPart1.php">Register   <i class="material-icons">person_add</i></a></li>
				<?php
			}
		?>
	</ul>
<?php

	
	
	//$_SESSION["username"] = "renhao";
	//$_SESSION["calendarUser"] = "renhao";
	// This is the home page for the calendar website
	// Users can and only can see this page but not others.
	
	// top navigation bar: include login, regester button or logout buttion
	// no implemented yet
	?>
	<div class="topBar">
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
	</div
		<script type="text/javascript" src="groupController.js"></script> <!-- load the JavaScript file -->
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
	?>
	<div class="calendar">
		<div class = "CalendarButtons">
		<button id="previous_month_btn">previous month</button>
		<label>this month</label>
		<button id="next_month_btn">next month</button>
		<script type="text/javascript" src="calendarController.js"></script>
		</div>
	<?php
	Calendar::showCalendar();
	?>
	</div>
	<?php

	
?>

</body>
</html>
