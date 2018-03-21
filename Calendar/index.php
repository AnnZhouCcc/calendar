<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	
	<style>
		<?php
			for($week =0; $week<6;$week++){
				for($day = 0;$day < 7;$day++){
					echo "#addevent".$week.$day."{display:none}";
				}
			}
		?>
		#registerform { display:none }
		#loginform { display:none }
	</style>
	
	<script src="global.js" type="text/javascript"></script>
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" /> <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
	
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
	//$( function() {
	//  $( "#dialog" ).dialog({
	//	autoOpen: false,
	//  });
	//  
	//  $( "#opener" ).on( "click", function() {
	//	$( "#dialog" ).dialog( "open" );
	//  });
	//} );
	</script>
</head>

<body>
	<?php
		//require_once "global.php";
		include "global.php";
		sessionCheckStart();
	?>
	<!--Top navigation bar-->
	<ul class="navBar" id= "navBar">
		<li class="navRight"><a class="navElement" id="logout_btn">Logout   <i class="material-icons">directions_run</i></a></li>
		<li class="navRight"><a class="navElement" id="login_dialog">Login   <i class="material-icons">person</i></a></li>
		<li class="navRight"><a class="navElement" id="register_dialog">Register   <i class="material-icons">person_add</i></a></li>
		<?php
			if(isset($_SESSION['username'])){
				?>
					<script>
						$("#login_dialog").hide();
						$("#register_dialog").hide();
					</script>
				<?php
			}else{
				?>
					<script>
						$("#logout_btn").hide();
					</script>
				
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
	
	
	
	<div class="topBar">
	</div>
	<?php
	
	
	// side navigation bar:
	// show/ not show certain type of event
	// show others' calendar
	// other functions
	?>
	<div class="sideBar" id="sideBar">
		<?php
			if(isset($_SESSION['username'])){
				echo "<p id = \"helloMessage\">Hellllllllo ".$_SESSION['username']."</p>";
			}else{
				echo "<p id = \"helloMessage\">Hi guest, please login or regeister first</p>";
			}

		?>
		<input type="text" id="newgroupname" placeholder="Group Name" />
		<button id="newgroup_btn">Create Group</button><br>
		
		<input type="text" id="addgroupname" placeholder="Group Name" />
		<input type="text" id="addgroupmember" placeholder="Group Member" />
		<button id="addmember_btn">Add Member</button><br>
		
		<input type="text" id="sharename" placeholder="Who to share with" />
		<button id="share_btn">Share</button><br><br><br>
		

		
		
		<strong>Categories:</strong><br>
		<input type="checkbox" class="categoriesCheckBox" name="workCheckbox" checked> <label class="work">work</label><br>
		<input type="checkbox" class="categoriesCheckBox" name="studyCheckbox" checked> <label class="study">study</label><br>
		<input type="checkbox" class="categoriesCheckBox" name="entertainmentCheckbox" checked> <label class="entertainment">entertainment</label><br>
		<input type="checkbox" class="categoriesCheckBox" name="othersCheckbox" checked> <label class="others">others</label><br>
		<br>
		<strong>Show the calendar of:</strong>
		<form class="shareCalendar" id="shareCalendar">
			<input type="radio" name="share" id="<?php echo $_SESSION["username"]?>"><label>me</label>
		</form>
		<button type="button" id="refreshShare">Refresh</button>
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
	
	
	
	<!--<p>trial</p>-->
	

	
	<div class="calendar">
		<div class = "CalendarButtons">
		<button id="previous_month_btn">previous month</button>
		<label>this month</label>
		<button id="next_month_btn">next month</button>
		
		</div>
	<?php
	Calendar::showCalendar();
	?>
	<div id="scripts">
		<script type="text/javascript" src="shareController.js"></script>
		<script type="text/javascript" src="calendarController.js"></script>
		<script type="text/javascript" src="eventController.js"></script>
		<script type="text/javascript" src="userController.js"></script>
		<script type="text/javascript" src="groupController.js"></script> <!-- load the JavaScript file -->
	</div>

	</div>



</body>
</html>