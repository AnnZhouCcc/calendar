
// For our purposes, we can keep the current month in a variable in the global scope
//var currentMonth = new Month(2017, 9); // October 2017
updateCalendar();
// Change the month when the "next" button is pressed
document.getElementById("next_month_btn").addEventListener("click", function(event){
	currentMonth = currentMonth.nextMonth(); // get next month
	updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
	alert("The new month is "+currentMonth.month+" "+currentMonth.year);
}, false);

// Change the month when the "previous month" button is pressed
document.getElementById("previous_month_btn").addEventListener("click", function(event){
	currentMonth = currentMonth.prevMonth(); // get previous month
	updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
	alert("The new month is "+currentMonth.month+" "+currentMonth.year);
}, false);

console.log(categoriesMap);
// See/not see certain category
for(var [key,value] of categoriesMap.entries()){
	//console.log(key+value);
	// hard to explain, but it have to be this way
	const key2=key;
	const value2=value;
	document.getElementsByName(""+key)[0].addEventListener("click", function (event){
		//console.log(key);
		var checkBox = document.getElementsByName(key2)[0];
		//console.log(""+value2);
		var events = document.getElementsByClassName(value2);
		//console.log(events);
		var index ;
		for(index = 0;index<events["length"];index++){
			//console.log(index);
			//console.log(events[index]);
			if (checkBox.checked == true){
					events[index].style.display = "block";
				} else {
				   events[index].style.display = "none";
				}
			}
	},false);
}



// This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
// it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
function updateCalendar(){
	var weeks = currentMonth.getWeeks();
	//console.log(weeks.length);
	// some month have 5 weeks, some month have 6 weeks. Make all of them have 6 weeks.
	if(weeks.length == 5){
		weeks.push(weeks[4].nextWeek());
	}
	//console.log(weeks.length);
	for(var w in weeks){
		var days = weeks[w].getDates();
		// days contains normal JavaScript Date objects.
		
		//alert("Week starting on "+days[0]);
		
		for(var d in days){
			// You can see console.log() output in your JavaScript debugging tool, like Firebug,
			// WebWit Inspector, or Dragonfly.
			
			// convert javascript date to mysql date
			// reference:
			// https://stackoverflow.com/questions/5129624/convert-js-date-time-to-mysql-datetime
			// convert time: https://stackoverflow.com/questions/10830357/javascript-toisostring-ignores-timezone-offset
			var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
			var localISOTime = (new Date(days[d] - tzoffset)).toISOString().slice(0, -1);
			updateADay(localISOTime.slice(0, 19).replace('T', ' '),w,d);
			//console.log(days[d].toISOString(),w,d);
		}
	}

}

function updateADay(sqlDate,week,day){
		// Make a URL-encoded string for passing POST data:
	var dataString = "type=fetchDay&time=" + encodeURIComponent(sqlDate);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "calendarController.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		//console.log("start");
		console.log(event.target.responseText);
		var eventsData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		// if there exist at least one event in this day
		var dayNode = document.getElementsByName("week"+week+"day"+day)[0];
		console.log(dayNode+"week"+week+"day"+day);
		
		// remove all the childs of current node
		// reference : https://stackoverflow.com/questions/3955229/remove-all-child-elements-of-a-dom-node-in-javascript
		// dayNode.innerHTML=""; // not working
		while(dayNode.firstChild){
			dayNode.removeChild(dayNode.firstChild);
		}
		
		//add day information:
		var date = document.createElement("p");
		//With help from:
		//https://stackoverflow.com/questions/9422974/createelement-with-id
		date.setAttribute("id", week+day);
		date.innerHTML=sqlDate.slice(8,10);
		dayNode.appendChild(date);
		if(eventsData.length>0){

			
			
			var ul = document.createElement("ul");
			ul.setAttribute('class','events');
			for(var aEvent in eventsData){
				var li = document.createElement("li");
				//console.log(eventsData[aEvent].title);
				//console.log(eventsData[aEvent].time);
				//li.innerHtml = ""+eventsData[aEvent].title; // do not use this. not working
				li.appendChild(document.createTextNode(eventsData[aEvent].time.substring(11,16)+" "+eventsData[aEvent].title));
				li.setAttribute('class',eventsData[aEvent].category);
				ul.appendChild(li);
			}
			dayNode.appendChild(ul);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data	
}

//With help from:
//https://stackoverflow.com/questions/14636536/how-to-check-if-a-variable-is-an-integer-in-javascript
function isInt(value) {
  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value));
}

//With help from:
//https://stackoverflow.com/questions/4825295/javascript-onclick-to-get-the-id-of-the-clicked-button
function showaddevent(clicked_id) {
	//console.log("here3");
	$("#addevent"+clicked_id).dialog();
}

//function modifyevent(clicked_id){
//	console.log("inside modifyevent");
//	
//}

function showDialogAjax() {
	//console.log("here0");
	//With help from:
	//https://stackoverflow.com/questions/41373686/event-target-id-or-this-attrid-not-working-in-firefox
	//$(document).ready(function(){
		//$("td").click(function(){
			//console.log("here1");
			//console.log(event.target.nodeName);
			//console.log(event.target.nodeName == 'P');
			$(document).click(function(event) {
				//console.log("here2");
				if (event.target.nodeName == 'P'){
					var data = $(event.target).attr('id');
					//console.log(event.target);
					//console.log(data);
					if (isInt(data)) {
						id = data;
					}
					//console.log(id);
					showaddevent(id);
				} else if (event.target.nodeName == 'LI') {
					var eventid = $(event.target.parentNode.previousSibling).attr('id');
					console.log(eventid);
					var eventtitle = event.target.innerHTML.substring(6);
					//console.log(eventtitle);
					var eventtime = event.target.innerHTML.substring(0,5);
					//console.log(eventtime);
					var eventcat = $(event.target).attr('class');
					//console.log(eventcat);
					
					if (isInt(eventid)) {
						//console.log("into a wrong if");
						id = eventid;
						var numweek = Math.floor(id/10);
						var numday = id - numweek*10;
						var weeks = currentMonth.getWeeks()[numweek];
						var days = weeks.getDates()[numday];
						var tzoffset = (new Date()).getTimezoneOffset() * 60000; 
						var localISOTime = (new Date(days - tzoffset)).toISOString().slice(0, -1);
						var eventdate = (localISOTime.slice(0, 10));
						//fetchpkofevent(eventtitle, eventtime, eventdate, eventcat);
						
						var datetime = eventdate+" "+eventtime+":00";
						var dataString = "type=fetchpkofevent"+ "&title=" + encodeURIComponent(eventtitle) + "&datetime=" + encodeURIComponent(datetime) + "&cat=" + encodeURIComponent(eventcat);
						var xmlHttp = new XMLHttpRequest(); 
						xmlHttp.open("POST", "calendarController.php", true); 
						xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
						xmlHttp.addEventListener("load", function(event){
							console.log(event.target.responseText);
							pkofevent = JSON.parse(event.target.responseText);
						},false);
						xmlHttp.send(dataString);	
						console.log(datetime);
						//document.getElementById("trial").innerHTML=pkofevent;
						//document.getElementById("trialtoo").value=pkofevent;
						//With help from:
						//https://stackoverflow.com/questions/14845710/javascript-variable-access-in-html
						//document.getElementById("modpk").value=pkofevent;
						$("#modevent").dialog();
					}
					//console.log("at end of showdialogajax");
					//var curruser = User::getCurrentUser();
					//console.log(curruser);
					//console.log(id);
					//console.log(event.target);
					//console.log(event.target.parentNode);
					//console.log(event.target.parentNode.previousSibling);
					//console.log(eventid);
				}
			});
		//});
	//});
}

for (var i=0; i<6; i++){
	for (var j=0; j<7; j++){
		const i2 = i;
		const j2 = j;
		//console.log(document.getElementsByName("week"+i2+"day"+j2)[0]);
		document.getElementsByName("week"+i2+"day"+j2)[0].addEventListener("click", showDialogAjax, false);
	}
}

//for (var a=1; a<5; a++){
//	const a2 = a;
//	console.log(document.getElementsByName("week10"+"day"+a2)[0]);
//	document.getElementsByName("week10"+"day"+a2)[0].addEventListener("click", showDialogAjax, false);
//}

function showregister() {
	$("#registerform").dialog();
}

function showlogin() {
	$("#loginform").dialog();
}

function loginregisterAjax() {
	//console.log("here0");
		//$("a").click(function(){
			//console.log("here1");
			//console.log($(event.target).attr('id'));
			$(document).click(function(event) {
				//console.log("here2");
				if ($(event.target).attr('id') == "login_dialog"){
					//console.log("able to login");
					showlogin();
				} else if ($(event.target).attr('id') == "register_dialog") {
					//console.log("able to register");
					showregister();
				}
			});
		//});
	//});
}
		
document.getElementById("login_dialog").addEventListener("click", loginregisterAjax, false);
console.log("after listener");
document.getElementById("register_dialog").addEventListener("click", loginregisterAjax, false);

//private function fetchpkofevent(title, time, date, cat){
//	console.log("into fetchpkofevent");
//	var datetime = date+" "+time+":00";
//	var dataString = "atype=fetchpkofevent"+ "&title=" + encodeURIComponent(title) + "datetime = " + encodeURIComponent(datetime) + "cat = " + encodeURIComponent(cat);
//	var xmlHttp = new XMLHttpRequest(); 
//	xmlHttp.open("POST", "calendarController.php", true); 
//	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
//	xmlHttp.addEventListener("load", function(event){
//		console.log(event.target.responseText);
//		pkofevent = JSON.parse(event.target.responseText);
//	},false);
//	xmlHttp.send(dataString);	
//}