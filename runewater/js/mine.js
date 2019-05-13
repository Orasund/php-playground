function mine(id){
	xmlhttp.mineid = id;
	var url = 'xmlhttp/setmine.php?id=' + id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			var mine = document.getElementById("mining");
			switch(output){
				case "0":
					mine.innerHTML = "du hast nichts gefunden";
					break;
				case "1":
					mine.innerHTML = "du hast 1 Steinholz gefunden";
					break;
				case "2":
					mine.innerHTML = "du hast 1 Kupfererz gefunden";
					break;
				case "3":
					mine.innerHTML = "du hast 1 Eisenerz gefunden";
					break;
				case "4":
					mine.innerHTML = "du hast 1 Silbererz gefunden";
					break;
				case "5":
					mine.innerHTML = "du hast 1 Runenstein gefunden";
					break;
				default:
			}
			var count = document.getElementById("mcnt");
			count.innerHTML = parseInt(count.innerHTML) - 1;
		}
	}
	xmlhttp.send(null);
}