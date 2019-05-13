/***Waffe Schmieden***/
function forge(){
	var typ = document.getElementById("sel_1").value;
	var level = document.getElementById("sel_2").value;
	var url = 'xmlhttp/createitem.php?typ=' + typ + '&level=' + level;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			switch(output){
				case "0": //Alles ging gut
					error("clear");
					var info = document.getElementById("forge_info");
					info.innerHTML = "Waffe erfolgreich geschmiedet";
					break;
				case "2": //Schmieden fehlgeschlagen
					error("clear");
					var info = document.getElementById("forge_info");
					info.innerHTML = "Schmieden fehlgeschlagen";
					break;
				case "1": //Unbekannter Error
				 	error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
					break;
				default:
					error("Vorgang abgebrochen:<i>" + output + "</i>");
			}
		}
	}
	xmlhttp.send(null);
}

/***Amueltt Schmieden***/
function forge2(){
	var r1 = document.getElementById("sel_3").value;
	var r2 = document.getElementById("sel_4").value;
	var r3 = document.getElementById("sel_5").value;
	var m = document.getElementById("sel_6").value;
	var url = 'xmlhttp/createamulett.php?r1=' + r1 + '&r2=' + r2 + '&r3=' + r3 + '&m=' + m;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			switch(output){
				case "0": //Alles ging gut
					error("clear");
					var info = document.getElementById("forge2_info");
					info.innerHTML = "Amueltt erfolgreich geschmiedet";
					break;
				case "2": //Schmieden fehlgeschlagen
					error("clear");
					var info = document.getElementById("forge2_info");
					info.innerHTML = "Amulett schmieden fehlgeschlagen";
					break;
				case "1": //Unbekannter Error
				 	error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
					break;
				default:
					error("Vorgang abgebrochen:<i>" + output + "</i>");
			}
		}
	}
	xmlhttp.send(null);
}