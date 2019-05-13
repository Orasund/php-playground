/**********************************************************************************************
******************                                                     ************************
******************          	            Offer                      ************************
******************                                                     ************************
**********************************************************************************************/
var xmlhttp = new XMLHttpRequest();

function market(){
	//Hier wird der Markt zusammengebat
	var tr,th;
	document.getElementById("offer_" + 0).innerHTML = "";
	offer(0);
	document.getElementById("offer_" + 2).innerHTML = "";
	offer(2);
}

function offer(typ){
	//Hier werden die einzelenen arten des Markts zusammengebaut
	var url = 'xmlhttp/getoffers.php?typ=' + typ;
	xmlhttp.open('get', url,false);
	xmlhttp.offer_typ = typ;
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText; //Der Output
			var str1,str2,str_parts,tr,td,th; //Alle Variablen
			var typ = xmlhttp.offer_typ;
			var market = document.getElementById("offer_" + typ);
			
			/*** ** * Script Anfang * ** ***/
			if (output == ""){
				tr = document.createElement("tr");
					td = document.createElement("td");
						td.setAttribute("colspan", "4");
						td.innerHTML = "Es wird derzeit nichts verkauft";
					tr.appendChild(td);
				market.appendChild(tr);
			}
			
			/* String to code */
			while (output != ""){
				//id(count,typ,level,price,user)
				str1 = output.indexOf("(");
				str2 = output.indexOf(")");
				str_parts = [
					output.substring(0, str1),					//0 - id
					output.substring(str1+1, str2).split(",")[1],	//1 - typ
					0,	//2 - life
					output.substring(str1+1, str2).split(",")[2],	//3 - level
					output.substring(str1+1, str2).split(",")[0],	//4 - count
					0,	//5 - name
					output.substring(str1+1, str2).split(",")[3],	//6 - price
					typ,	//7 - status
					output.substring(str1+1, str2).split(",")[4],	//8 - user
				];
				output = output.slice(str2 + 1);
				
				/* Item Anzeige */
				tr = document.createElement("tr");
					item(tr,str_parts,2);
				market.appendChild(tr);
			}
			
			if(typ == 0){money();}
		}
	}
	xmlhttp.send(null);
}

function money(){
	var url = 'xmlhttp/getmoney.php';
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var th = document.getElementById("money");
			th.innerHTML = "Dein Steinholz: " + xmlhttp.responseText + "#";
		}
	}
	xmlhttp.send(null);
}

function buy(id){
	var url = 'xmlhttp/buyitem.php?id=' + id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			output = xmlhttp.responseText;
			switch(output){
				case "0"://Alles ging gut!
					market();
					error("clear");
					break;
				case "1":
					error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
					break;
				case "2":
					error("Vorgang abgebrochen: Nicht genug Geld");
					break;
				default:
					error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
			}
		}
	}
	xmlhttp.send(null);
}