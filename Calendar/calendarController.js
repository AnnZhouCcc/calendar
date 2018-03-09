
// For our purposes, we can keep the current month in a variable in the global scope
var currentMonth = new Month(2017, 9); // October 2017

// Change the month when the "next" button is pressed
document.getElementById("next_month_btn").addEventListener("click", function(event){
	currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
	updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
	alert("The new month is "+currentMonth.month+" "+currentMonth.year);
}, false);


// This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
// it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
function updateCalendar(){
	var weeks = currentMonth.getWeeks();
	
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
			updateADay(days[d].toISOString().slice(0, 19).replace('T', ' '),w,d);
			console.log(days[d].toISOString(),w,d);
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
		if(eventsData.length>0){
			var dayNode = document.getElementsByName("week"+week+"day"+day)[0];
			console.log(dayNode+"week"+week+"day"+day);
			dayNode.innerHTML="";
			var ul = document.createElement("ul");
			for(var aEvent in eventsData){
				var li = document.createElement("li");
				console.log(eventsData[aEvent].title);
				li.innerHtml = ""+eventsData[aEvent].title;
				console.log(li.innerHtml);
				ul.appendChild(li);
			}
			dayNode.appendChild(ul);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}