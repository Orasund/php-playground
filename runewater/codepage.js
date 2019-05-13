var xmlhttp = new XMLHttpRequest();
var user_count = 12; //Spielt anscheinend einee wichtige Rolle(leider vergessen welche^^)

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

function selection(id,opt,count){
	var select;
	var opacity;
	for(var i=1; i<=count; i++){
		select = document.getElementById("opt_" + id + "_" + i);
		if(opt == i){opacity = "1";} else {opacity = "0.5";}
		select.style.opacity = opacity;
	}
	document.getElementById("sel_" + id).value = opt;
}

function error(mes){
	if(mes == "clear"){
		var error = document.getElementById("error");
		error.innerHTML = '';
	} else {
		var txt = '<table><tr><td>' + mes + '</td></tr></table>';
		var error = document.getElementById("error");
		error.innerHTML = txt;
	}
}