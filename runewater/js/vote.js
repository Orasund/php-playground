/**********************************************************************************************
******************                                                     ************************
******************          	            Votes                      ************************
******************                                                     ************************
**********************************************************************************************/

var xmlhttp = new XMLHttpRequest();

function createvote(votename,name,tip,options){
	var th,tr,vote,td, td2, select, option, meter, br;
	vote = document.getElementById(votename); //Table finden
	tr = document.createElement("tr"); //�berschrift
		th = document.createElement("th");
			th.setAttribute("colspan", 4);
			th.innerHTML = "Abstimmung";
		tr.appendChild(th);
	vote.appendChild(tr);
	
	for (id in name){
		id = new Number(id);
		
		if(votename == "vote_tower"){
			voteid = id + 4;
		} else if(votename == "vote_mine"){
			voteid = id + 5;
		} else {
			voteid = id;
		}
		
		tr = document.createElement("tr");
			th = document.createElement("th"); //Tip
				th.setAttribute("class", tip[id] + " focus");
				th.innerHTML = name[id];
			tr.appendChild(th);
			
			td = document.createElement("td"); //Die Auswahl der M�glichkeiten
				select = document.createElement("select");
				td.appendChild(select);
			tr.appendChild(td);
			
			td = document.createElement("td"); //Anzeige, gespeichert als td
				td.setAttribute("class", "info");
			tr.appendChild(td);
			
			if(options.length > 2){
				td2= document.createElement("td"); //Anzeige, gespeichert als td
					td2.setAttribute("class", "info");
				tr.appendChild(td2);
			}
		vote.appendChild(tr);
		
		for(opt in options){ //f�r jede option
			option = document.createElement("option"); //Option hinzuf�gen
				option.setAttribute("onClick", "changeselect(" + voteid + "," + opt + ");checkvote(" + voteid + "," + opt + ");");
				option.innerHTML = options[opt];
			select.appendChild(option);
			
			meter = document.createElement("meter");//Meter anzeige hinzuf�gen
				meter.setAttribute("id", voteid + "_" + opt);
				meter.setAttribute("max", user_count);
			if(opt > 1){
				td2.appendChild(meter);
				td2.innerHTML += options[opt] + "<br>";//Anzeige hinzuf�gen
			} else {
				td.appendChild(meter);
				td.innerHTML += options[opt] + "<br>";//Anzeige hinzuf�gen
			}

			
			
			checkvote(voteid, opt); //XMLHTTP
		}
	}
}

function checkvote(id, opt){
	var url = 'xmlhttp/getvotes.php?vote=' + id + '&opt=' + opt;
	xmlhttp.meterid = id;
	xmlhttp.meteropt = opt;
	xmlhttp.open('get', url,false); //xmlhttp.php?db=1
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var value, meter;
			meter = document.getElementById(xmlhttp.meterid + "_" + xmlhttp.meteropt);
			value = xmlhttp.responseText;
			meter.setAttribute("value", value);
			meter.innerHTML = value + " Votes f�r ";
		}
	}
	xmlhttp.send(null);
}

function changeselect(id, opt){
	var url = 'xmlhttp/changevote.php?vote=' + id + '&opt=' + opt;
	xmlhttp.meterid = id;
	xmlhttp.meteropt = opt;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			checkvote(xmlhttp.meterid, xmlhttp.responseText);
		}
	}
	xmlhttp.send(null);
}