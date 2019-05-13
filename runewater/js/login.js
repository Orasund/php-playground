function login(id,typ){
	user = document.getElementById("usr_input");
	password = document.getElementById("pwd_input");
	remember = document.getElementById("remember");
	if(user.value != "" && password.value != ""){
		var url = 'xmlhttp/login.php?user=' + user.value + '&password=' + password.value + '&remember=' + remember.value;
		xmlhttp.open('get', url,false);
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status==200){
				if(xmlhttp.responseText == 0){
					//error("clear");
					error('<a href="index.php">Sie können nun spielen</a>');
				} else {
					if(xmlhttp.responseText == 1){
						error("Vorgang abgebrochen: Das Passwort ist falsch");
					} else if(xmlhttp.responseText == 2){
						error("Vorgang abgebrochen: Dieser Benützername exestiert nicht");
					} else {
						error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
					}
				}
			}
		}
		xmlhttp.send(null);
	} else {
		error("Vorgang abgebrochen: Sie müssen Benützername und Passwort eingeben.");
	}
}