function loginAjax(event){
	//hasUser = true;
	var username = document.getElementById("username").value; // Get the username from the form
	var password = document.getElementById("password").value; // Get the password from the form
	var act = "login";
	//alert(username);
	//alert(password);
	//alert(act);

	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password)+ "&act=" + encodeURIComponent(act);
	
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "userController.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		//alert(jsonData);
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged In!");
			$("#loginform").dialog("close");
			updateCalendar();
			$("#login_dialog").hide();
			$("#register_dialog").hide();
			$("#logout_btn").show();
			$("#helloMessage").text("Hellllo"+username);
			
		}else{
			alert("You were not logged in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data

}

//alert("login"+document.getElementById("login_btn"));
document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click

function regAjax(event){
	var username = document.getElementById("regusername").value;
	var password = document.getElementById("regpassword").value; 
	var email = document.getElementById("regemail").value;
	var act = "register";
	//alert(act);
	
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password) + "&act=" + encodeURIComponent(act) + "&email=" + encodeURIComponent(email);
	//alert("here");
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "userController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		//alert("response"+event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("You've been registered!");
			$("#registerform").dialog("close");
		}else{
			alert("You were not successfully registered.  "+jsonData.message);
		}
	}, false);
	xmlHttp.send(dataString);
	
}

//alert("register"+document.getElementById("reg_btn"));
document.getElementById("reg_btn").addEventListener("click", regAjax, false);

function logoutAjax(event){
	//hasUser = false;
	console.log("into logout");
	var act = "logout";
	
	var dataString = "act=" + encodeURIComponent(act);
	//alert(act);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "userController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Logout completed");
			updateCalendar();
		}else{
			alert("Logout unsuccessful.  "+jsonData.message);
		}
	}, false);
	xmlHttp.send(dataString);
	console.log("tryting to refresh");
	$("#login_dialog").show();
	$("#register_dialog").show();
	$("#logout_btn").hide();
	$("#helloMessage").text("Hi guest, please login or regeister first");
}

//alert("register"+document.getElementById("reg_btn"));
document.getElementById("logout_btn").addEventListener("click", logoutAjax, false);
