/**********************************************************************************************
******************                                                     ************************
******************          	             News                      ************************
******************                                                     ************************
**********************************************************************************************/
var xmlhttp = new XMLHttpRequest();

function news(){
	var url = 'xmlhttp/getnews.php';
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			var str1,str2,str_date,str_parts,tr,td;
			var i = 0;
			var archiv = document.getElementById("archiv");
			var names = ["islands"];
				names["islands"] = ["Armun","Baltar","Cardul","Dales"];
			
			/*str_parts
				0 - Kämpfe A und B
				1 - Kämpfe B und C
				2 - Kämpfe C und A
				3 - sonstiges
			*/
			str_parts = [];
			/* String to code */
			while (output != ""){
				//date(typ,who,whom)
				str1 = output.indexOf("(");
				str2 = output.indexOf(")");
				str_date = output.substring(str1, str2).split(",")[2];
				str_parts.length++;
				str_parts[i] = [
					output.substring(0, str1),					//0 - date
					output.substring(str1 + 1, str2).split(",")[0],	//1 - typ
					output.substring(str1, str2).split(",")[1],	//2 - who
					output.substring(str1, str2).split(",")[2],	//3 - whom
				];
				output = output.slice(str2 + 1);
				i++;
			}	
			for (var i=new Number(0); i<str_parts.length; i++){
				tr = document.createElement("tr");
					td = document.createElement("td");
						
						switch(str_parts[i][1]){
							case "0": // Insel gegen Insel(gewinnt)
								/*if(str_parts[i+1][1] <= 1 && str_parts[i+1][2] == str_parts[i][2] && str_parts[i+1][3] != str_parts[i][3]){//Zwei auf einen
									td.innerHTML = "<b>Insel " + names["islands"][str_parts[i][2]] + "</b> wurde von <b>Insel " + names["islands"][str_parts[i][3]] + "</b> und <b>Insel " + names["islands"][str_parts[i+1][3]] + "</b> Angegriffen";
									i++;
								} else {*/
									td.innerHTML = "<b>Insel " + names["islands"][str_parts[i][2]] + "</b> wurde von <b>Insel " + names["islands"][str_parts[i][3]] + "</b> Angegriffen";
								//}
							break;
							case "1": // Verliert
								td.innerHTML = "<b>Insel " + names["islands"][str_parts[i][2]] + "</b> hat <b>Insel " + names["islands"][str_parts[i][3]] + "</b> in die Flucht geschlagen";
							break;
							default:
								td.innerHTML = "Ein Fehler ist aufgetreten";
						}
						
					tr.appendChild(td);
				archiv.appendChild(tr);
			}
		}
	}
	xmlhttp.send(null);
}