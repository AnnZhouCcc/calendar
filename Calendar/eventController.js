function addeventAjax(event){
	//alert("here");
	var username = document.getElementById("addeventuser").value;
	var title = document.getElementById("title").value;
	var time = document.getElementById("time").value;
    //With help from:
    //https://stackoverflow.com/questions/1423777/how-can-i-check-whether-a-radio-button-is-selected-with-javascript
	var cat;
    if (document.getElementById('cat_work').checked){
        cat = "work";
    } else if (document.getElementById('cat_study').checked){
        cat = "study";
    } else if (document.getElementById('cat_entertainment').checked){
        cat = "entertainment";
    } else if (document.getElementById('cat_others').checked){
        cat = "others";
    }
	var type = "addevent";
    //alert("username"+username);
    //alert("title"+title);
    //alert("time"+time);
    //alert("cat"+cat);
	//alert("type"+type);
	
	var dataString = "username=" + encodeURIComponent(username) + "&title=" + encodeURIComponent(title) + "&time=" + encodeURIComponent(time) + "&cat=" + encodeURIComponent(cat) + "&type=" + encodeURIComponent(type);
	if (document.getElementById("gpname").value != null) {
		var groupname = document.getElementById("gpname").value;
		dataString = dataString + "&groupname=" + encodeURIComponent(groupname);
	}
	//alert("groupname: "+groupname);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "eventController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		//alert("response: "+event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Event has been added!");
		}else{
			alert("Adding event failed.  "+jsonData.message);
		}
	}, false);
	xmlHttp.send(dataString); 
}

//alert("register"+document.getElementById("reg_btn"));
document.getElementById("addevent_btn").addEventListener("click", addeventAjax, false);