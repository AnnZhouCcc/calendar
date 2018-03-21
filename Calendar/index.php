<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Home</title>
	
	<style>
		<?php
		ini_set("session.cookie_httponly", 1);
			for($week =0; $week<6;$week++){
				for($day = 0;$day < 7;$day++){
					echo "#addevent".$week.$day."{display:none}";
				}
			}
		?>
		#registerform { display:none }
		#loginform { display:none }
		#modevent { display:none }
	</style>
	
	<script src="global.js" ></script>
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" /> <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
	
	<script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script><!-- The main library.  Note: must be listed before the jquery-ui library -->
	
	<script  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script><!-- jquery-UI  hosted on Google's Ajax CDN-->
	<!-- Note: you can download the javascript file from the link provided on the google doc, or simply provide its URL in the src attribute (microsoft and google also host the jQuery library-->

	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="global.js" ></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<script>
		$.noConflict();
		
		var pkofevent = pkofevent;
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
		
		if (empty($_SESSION['token'])){
					$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		}
				
		$previous_ua = @$_SESSION['useragent'];
		$current_ua = $_SERVER['HTTP_USER_AGENT'];
		
		if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
			die("Session hijack detected");
		}else{
			$_SESSION['useragent'] = $current_ua;
		}
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
				echo "<strong id = \"helloMessage\">Hellllllllo ".$_SESSION['username']."</strong><br>";
			}else{
				echo "<strong id = \"helloMessage\">Hi guest, please login or regeister first</strong><br>";
			}
		?>
		<br>
		<input type="text" id="newgroupname" placeholder="Group Name" />
		<button id="newgroup_btn">Create Group</button><br><br><br>
		
		<input type="text" id="addgroupname" placeholder="Group Name" />
		<input type="text" id="addgroupmember" placeholder="Group Member" /><br>
		<button id="addmember_btn">Add Member</button><br><br><br>
		
		<input type="text" id="sharename" placeholder="Who to share with" /><br>
		<button id="share_btn">Share</button><br><br><br>
		

		
		
		<strong>Categories:</strong><br>
		<ul class="eventsCheck">
			<li class="workCheck"><input type="checkbox" class="categoriesCheckBox" name="workCheckbox" checked> <label >work</label><br></li>
			<li class="studyCheck"><input type="checkbox" class="categoriesCheckBox" name="studyCheckbox" checked> <label >study</label><br></li>
			<li class="entertainmentCheck"><input type="checkbox" class="categoriesCheckBox" name="entertainmentCheckbox" checked> <label >entertainment</label><br></li>
			<li class="othersCheck"><input type="checkbox" class="categoriesCheckBox" name="othersCheckbox" checked> <label >others</label><br></li>
		</ul>
		<br>
		<strong>Show the calendar of:</strong>
		<form class="shareCalendar" id="shareCalendar">
			<input type="radio" name="share" id="<?php echo $_SESSION["username"]?>" checked><label>me</label>
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
		<input type="time" id="<?php echo 'time'.$week.$day;?>"  /><br>
		<input type="radio" class="addeventcat" name="cat" id="<?php echo 'cat_work'.$week.$day;?>" value="work"> work<br>
		<input type="radio" class="addeventcat" name="cat" id="<?php echo 'cat_study'.$week.$day;?>" value="study"> study<br>
		<input type="radio" class="addeventcat" name="cat" id="<?php echo 'cat_entertainment'.$week.$day;?>" value="entertainment"> entertainment<br>
		<input type="radio" class="addeventcat" name="cat" id="<?php echo 'cat_others'.$week.$day;?>" value="others"> others<br>
		<input type="text" id="<?php echo 'gpname'.$week.$day;?>" placeholder="Group name (if applicable)" />
		<input type="hidden" id="<?php echo 'addeventuser'.$week.$day;?>" value="<?php echo $_SESSION['username'];?>" />
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />

		<button id="<?php echo 'addevent_btn'.$week.$day;?>">Submit</button><br>
	</div>
	
	<?php
		}
	}
	
	$eventID = "<script>document.writeln(pkofevent);</script>";
	$event = Event::fetchEventByID($eventID);
	//echo $eventID;
	?>
	
	
	
	<div id="modevent" title="Modify or Delete Event">
		<!--<p id="trial"></p>
		<input type="text" id="trialtoo" /><br>-->
		<input type="text" id="modtitle" value="<?php echo htmlentities($event->title); ?>"/><br>
		<input type="time" id="modtime" value="<?php echo htmlentities($event->time); ?>"/><br>
		<input type="radio" class="modeventcat" name="cat" id="modcat_work" value="work"> work<br>
		<input type="radio" class="modeventcat" name="cat" id="modcat_study" value="study"> study<br>
		<input type="radio" class="modeventcat" name="cat" id="modcat_entertainment" value="entertainment"> entertainment<br>
		<input type="radio" class="modeventcat" name="cat" id="modcat_others" value="others"> others<br>
		<input type="hidden" id="modeventuser" value="<?php echo $_SESSION['username'];?>" />
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<label>Group: </label><input type="text" id="modgpname" />
		<!--<input type="hidden" id="modpk"/>-->

		<button id="mod_btn">Submit</button><br>
		<button id="delete_btn">Delete</button><br>
	</div>
	
	<!--<script type="text/javascript" src="eventController.js"></script>-->
	
	<div class="calendar">
		<div class = "CalendarButtons">
		<button id="previous_month_btn">previous month</button>
		<label id="thisMonth">this month</label>
		<button id="next_month_btn">next month</button>
		
		</div>
		
	<?php
	Calendar::showCalendar();
	?>
	<div id="scripts">
		<script src="shareController.js"></script>
		<script src="calendarController.js"></script>
		<script src="eventController.js"></script>
		<script src="userController.js"></script>
		<script src="groupController.js"></script> <!-- load the JavaScript file -->
	</div>

	</div>



</body>
</html>