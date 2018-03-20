function shareAjax(event){
	var sharewithwho = document.getElementById("sharename").value;
	
	var dataString = "sharewithwho=" + encodeURIComponent(sharewithwho);
	
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