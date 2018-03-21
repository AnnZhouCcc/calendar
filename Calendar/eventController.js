function addeventAjax(event){
	console.log("into addeventajax");
	//alert("here");
	//var numweek = document.getElementById("numweek"+id).value;
	//console.log(numweek);
	//var numday = document.getElementById("numday"+id).value;
	//console.log(numday);
	//var id=numweek*10+numday;
	//console.log("addevent id:"+id);
	
	var username = document.getElementById("addeventuser"+id).value;
	//console.log(username);
	//console.log(username == null);
	var title = document.getElementById("title"+id).value;
	//console.log(title);
	var time = document.getElementById("time"+id).value;
	//console.log(time);
	
	//With help from:
	//https://stackoverflow.com/questions/4228356/integer-division-with-remainder-in-javascript
	var numweek = Math.floor(id/10);
	console.log("numweek:"+numweek);
	var numday = id - numweek*10;
	//console.log(numday);
	
	//With help from:
	//https://stackoverflow.com/questions/2280104/convert-javascript-to-date-object-to-mysql-date-format-yyyy-mm-dd?noredirect=1&lq=1
	//conversion from javascript time to mysql time
	var weeks;
	if(numweek == 5){
		weeks = currentMonth.getWeeks()[4].nextWeek();
	}else{
		weeks = currentMonth.getWeeks()[numweek];
	}
	//console.log(weeks);
	var days = weeks.getDates()[numday];
	//console.log(days);
	var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
	//console.log(tzoffset);
	var localISOTime = (new Date(days - tzoffset)).toISOString().slice(0, -1);
	//console.log(localISOTime);
	//console.log(localISOTime.slice(0, 19).replace('T', ' '),weeks,days);
	var date = (localISOTime.slice(0, 10));
	//console.log(date);
			
    //With help from:
    //https://stackoverflow.com/questions/1423777/how-can-i-check-whether-a-radio-button-is-selected-with-javascript
	var cat;
    if (document.getElementById('cat_work'+id).checked){
        cat = "work";
    } else if (document.getElementById('cat_study'+id).checked){
        cat = "study";
    } else if (document.getElementById('cat_entertainment'+id).checked){
        cat = "entertainment";
    } else if (document.getElementById('cat_others'+id).checked){
        cat = "others";
    }
	//console.log(cat);
	var type = "addevent";
    //alert("username"+username);
    //alert("title"+title);
    //alert("time"+time);
    //alert("cat"+cat);
	//alert("type"+type);
	
	var dataString = "username=" + encodeURIComponent(username) + "&title=" + encodeURIComponent(title) + "&time=" + encodeURIComponent(time) + "&cat=" + encodeURIComponent(cat) + "&type=" + encodeURIComponent(type) + "&date=" + encodeURIComponent(date);
	if (document.getElementById("gpname"+id).value != null) {
		var groupname = document.getElementById("gpname"+id).value;
		dataString = dataString + "&groupname=" + encodeURIComponent(groupname);
	}
	//alert("groupname: "+groupname);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "eventController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Event has been added!");
		}else{
			alert("Adding event failed.  "+jsonData.message);
		}
		$("#addevent"+id).dialog("close");
		updateCalendar();
	}, false);
	xmlHttp.send(dataString);

}

for (var i=0; i<6; i++){
	for (var j=0; j<7; j++){
		const i2 = i;
		const j2 = j;
		document.getElementById("addevent_btn"+i2+j2).addEventListener("click", addeventAjax, false);
	}
}

function modeventAjax(event){
	var pk = pkofevent;
	var username = document.getElementById("modeventuser").value;
	var title = document.getElementById("modtitle").value;
	var time = document.getElementById("modtime").value;
	
	var numweek = Math.floor(id/10);
	var numday = id - numweek*10;
	var weeks;
	if(numweek == 5){
		weeks = currentMonth.getWeeks()[4].nextWeek();
	}else{
		weeks = currentMonth.getWeeks()[numweek];
	}
	var days = weeks.getDates()[numday];
	var tzoffset = (new Date()).getTimezoneOffset() * 60000;
	var localISOTime = (new Date(days - tzoffset)).toISOString().slice(0, -1);
	var date = (localISOTime.slice(0, 10));
	
	var cat;
    if (document.getElementById('modcat_work').checked){
        cat = "work";
    } else if (document.getElementById('modcat_study').checked){
        cat = "study";
    } else if (document.getElementById('modcat_entertainment').checked){
        cat = "entertainment";
    } else if (document.getElementById('modcat_others').checked){
        cat = "others";
    }
	
	var type = "modevent";
	
	var dataString = "username=" + encodeURIComponent(username) + "&title=" + encodeURIComponent(title) + "&time=" + encodeURIComponent(time) + "&cat=" + encodeURIComponent(cat) + "&type=" + encodeURIComponent(type) + "&date=" + encodeURIComponent(date) + "&pk=" + encodeURIComponent(pk);
	if (document.getElementById("modgpname").value != null) {
		var groupname = document.getElementById("modgpname").value;
		dataString = dataString + "&groupname=" + encodeURIComponent(groupname);
	}
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "eventController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Event has been modified!");
		}else{
			alert("Modifying event failed.  "+jsonData.message);
		}
		$("#modevent").dialog("close");
		updateCalendar();
	}, false);
	xmlHttp.send(dataString);

}

document.getElementById("mod_btn").addEventListener("click", modeventAjax, false);

function deleteeventAjax(event){
	var pk = pkofevent;
	var username = document.getElementById("modeventuser").value;
	
	var type = "deleteevent";
	
	var dataString = "pk=" + encodeURIComponent(pk) + "&type=" + encodeURIComponent(type) + "&username=" + encodeURIComponent(username);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "eventController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			alert("Event has been deleted!");
		}else{
			alert("Deleting event failed.  "+jsonData.message);
		}
		$("#modevent").dialog("close");
		updateCalendar();
	}, false);
	xmlHttp.send(dataString);

}

document.getElementById("delete_btn").addEventListener("click", deleteeventAjax, false);
