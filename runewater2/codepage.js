var names = ["places"];
	names["places"] = ["castle","market","arena","mine","tower"];
		names["places"]["castle"] = ["Burg","Castle"];
		names["places"]["market"] = ["Markt","Market"];
		names["places"]["arena"] = ["Arena","Arena"];
		names["places"]["mine"] = ["Mine","Mine"];
		names["places"]["tower"] = ["Turm","Tower"];
var ids =["castle","market","arena","mine","tower","settings"];
var insel = "B";
var user_count = 12;
var votes = ["vote_build","vote_tower"];
	votes["vote_build"] = ["B2","B3","B4"];
	votes["vote_build"]["B2"] = [0,7,3,2];
	votes["vote_build"]["B3"] = [9,1,1,1];
	votes["vote_build"]["B4"] = [3,3,3,3];
	votes["vote_tower"] = ["Wache"];
	votes["vote_tower"]["Wache"] = [4,8];
var xmlhttp = new XMLHttpRequest();

function changemenu(id){
	var domid;
	for(i in ids){
		domid = document.getElementById(ids[i]);
		if(ids[i] == ids[id]){
			domid.style.display = "block";
		} else {
			domid.style.display = "none";
		}
	}
}
function removevote(vote, id){
	document.getElementById(vote).removeChild(document.getElementById(id));
}

function createvote(tip,name,options,id,voteid){
	var vote = document.getElementById(voteid);
	var tr = document.createElement("tr");
	vote.appendChild(tr);
	var th = document.createElement("th");
	th.setAttribute("class", tip + " focus");
	tr.appendChild(th);
	var txt = document.createTextNode(name);
	th.appendChild(txt);
	var td = document.createElement("td");
	tr.appendChild(td);
	var select = document.createElement("select");
	td.appendChild(select);
	td = document.createElement("td");
	tr.appendChild(td);
	
	var option, meter, br;
	for(opt in options){
		option = document.createElement("option");
		select.appendChild(option);
		txt = document.createTextNode(options[opt]);
		option.appendChild(txt);
		meter = document.createElement("meter");
		meter.setAttribute("id", id);
		meter.setAttribute("max", user_count);
		td.appendChild(meter);
		checkdb(id); //Das XMLHTTP id ist nur ne Zahl
		txt = document.createTextNode(options[opt]);
		td.appendChild(txt);
		br = document.createElement("br");
		td.appendChild(br);
	}
}

function map(id){
	this.focus = function(num, focus){
		var txt;
		if(id == typs[num]){
			focus.setAttribute("class", typs[num] + " focus");
			txt = document.createTextNode(names["places"][typs[num]][0]);
		} else {
			focus.setAttribute("class", typs[num]);
			txt = document.createTextNode(insel + (num+1));
		}
		focus.appendChild(txt);
	}
	var map = document.getElementById(id);
	map.childNodes[1].removeChild(map.childNodes[1].childNodes[0]);
	var target = document.createElement("table");
	map.childNodes[1].appendChild(target);
	//durch castle/table sollte map gefunden werden. Der Inhalt wird gelöscht.
	var th;
	var typs = ["castle","market","arena","mine","tower","tower"];
	var tr1 =  document.createElement("tr");
	target.appendChild(tr1);
	th = document.createElement("th");
	tr1.appendChild(th);
	var p6 = document.createElement("th");
	this.focus(5, p6);
	tr1.appendChild(p6);
	
	var tr2 =  document.createElement("tr");
	target.appendChild(tr2);
	th = document.createElement("th");
	tr2.appendChild(th);
	var p3 = document.createElement("th");
	this.focus(2, p3);
	tr2.appendChild(p3);
	var p4 = document.createElement("th");
	this.focus(3, p4);
	tr2.appendChild(p4);
	
	var tr3 =  document.createElement("tr");
	target.appendChild(tr3);
	var p5 = document.createElement("th");
	this.focus(4, p5);
	tr3.appendChild(p5);
	var p2 = document.createElement("th");
	this.focus(1, p2);
	tr3.appendChild(p2);
	var p1 = document.createElement("th");
	this.focus(0, p1);
	tr3.appendChild(p1);
}

function checkdb(id){
	var url = "xmlhttp.php?db=" + id;
	xmlhttp.open('get', url,true); //xmlhttp.php?db=1
	xmlhttp.onreadystatechange = function(){
		var value, meter;
		var id = 1;
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			meter = document.getElementById(id);
			value = xmlhttp.responseText;
			meter.setAttribute("value", value);
		}
	}
	xmlhttp.send(null);
}