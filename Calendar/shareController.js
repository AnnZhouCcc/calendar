
function refreshShareList(){
	
	const dataString = "type="+encodeURIComponent("fetchShare");
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "shareController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var shareData = JSON.parse(event.target.responseText);
		const form = document.getElementById("shareCalendar");
		console.log(form.childNodes.length);
		while (form.childNodes.length>3){
			form.removeChild(form.lastChild);
		}
		for(var aShare in shareData){
			var input = document.createElement("input");
			input.setAttribute('type',"radio");
			input.setAttribute('name',"share");
			input.setAttribute('id',shareData[aShare].user);
			var lable = document.createElement("lable");
			lable.innerHTML=shareData[aShare].user;
			form.appendChild(input);
			form.appendChild(lable);
			input.addEventListener("click",refreshCalendar,false);
		}
	}, false); 
	xmlHttp.send(dataString); 
		
}
refreshShareList();
function shareAjax(event){
	var sharewithwho = document.getElementById("sharename").value;
	
	var dataString = "sharewithwho=" + encodeURIComponent(sharewithwho)+"&type="+encodeURIComponent("newShare");
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "shareController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){ 
			alert("Sharing completed!");
		}else{
			alert("Sharing unsuccessful.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(dataString); 
}

document.getElementById("share_btn").addEventListener("click", shareAjax, false);

function refreshCalendar(event){
	console.log(event.target.id);
	const from = event.target.id;
	const dataString = "type="+encodeURIComponent("refreshCalendar")+"&from="+encodeURIComponent(from);
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "shareController.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		console.log(event.target.responseText);
	});
	xmlHttp.send(dataString);
	updateCalendar();
}

$(function(){
	$("#refreshShare").click(refreshShareList);
});

document.getElementsByName("share")[0].addEventListener("click",refreshCalendar,false);