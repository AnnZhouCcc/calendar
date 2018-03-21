function newgroupAjax(event){
	var newgroupname = document.getElementById("newgroupname").value; // Get the password from the form
	var act = "newgroup";

	// Make a URL-encoded string for passing POST data:
	var dataString = "newgroupname=" + encodeURIComponent(newgroupname) + "&act=" + encodeURIComponent(act);
	
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "groupController.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Creating new group completed!");
		}else{
			alert("Creating new group unsuccessful.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

//alert("login"+document.getElementById("login_btn"));
document.getElementById("newgroup_btn").addEventListener("click", newgroupAjax, false); // Bind the AJAX call to button click

function addmemberAjax(event){
	var member = document.getElementById("addgroupmember").value;
	var groupname = document.getElementById("addgroupname").value;
	var act = "addmember";
	
	var dataString = "member=" + encodeURIComponent(member) + "&groupname=" + encodeURIComponent(groupname) + "&act=" + encodeURIComponent(act);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "groupController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Member has been added!");
		}else{
			alert("Adding member failed.  "+jsonData.message);
		}
	}, false);
	xmlHttp.send(dataString); 
}

document.getElementById("addmember_btn").addEventListener("click", addmemberAjax, false);