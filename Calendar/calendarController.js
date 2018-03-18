
// For our purposes, we can keep the current month in a variable in the global scope
var currentMonth = new Month(2017, 9); // October 2017
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
	console.log(key+value);
	// hard to explain, but it have to be this way
	const key2=key;
	const value2=value;
	document.getElementsByName(""+key)[0].addEventListener("click", function (event){
		console.log(key);
		var checkBox = document.getElementsByName(key2)[0];
		console.log(""+value2);
		var events = document.getElementsByClassName(value2);
		console.log(events);
		var index ;
		for(index = 0;index<events["length"];index++){
			console.log(index);
			console.log(events[index]);
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
	console.log(weeks.length);
	// some month have 5 weeks, some month have 6 weeks. Make all of them have 6 weeks.
	if(weeks.length == 5){
		weeks.push(weeks[4].nextWeek());
	}
	console.log(weeks.length);
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
		var dayNode = document.getElementsByName("week"+week+"day"+day)[0];
		console.log(dayNode+"week"+week+"day"+day);
		
		// remove all the childs of current node
		// reference : https://stackoverflow.com/questions/3955229/remove-all-child-elements-of-a-dom-node-in-javascript
		// dayNode.innerHTML=""; // not working
		while(dayNode.firstChild){
			dayNode.removeChild(dayNode.firstChild);
		}
		
		//add day information:
		var date = document.createElement("lable");
		date.innerHTML=sqlDate.slice(8,10);
		dayNode.appendChild(date);
		if(eventsData.length>0){

			
			
			var ul = document.createElement("ul");
			ul.setAttribute('calss','events');
			for(var aEvent in eventsData){
				var li = document.createElement("li");
				console.log(eventsData[aEvent].title);
				//li.innerHtml = ""+eventsData[aEvent].title; // do not use this. not working
				li.appendChild(document.createTextNode(eventsData[aEvent].title));
				li.setAttribute('class',eventsData[aEvent].category);
				ul.appendChild(li);
			}
			dayNode.appendChild(ul);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}