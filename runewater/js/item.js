/**********************************************************************************************
******************                                                     ************************
******************          	            Items                      ************************
******************                                                     ************************
**********************************************************************************************/
function items(){
	var url = 'xmlhttp/getitems.php';
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var out = xmlhttp.responseText;
			var item, tab, tr, th, td, r1,r2,r3,r,x,level,str,bal,life,exp,l,name;
			var w=window.outerWidth; //Mobile!
			var i = 0;
			var names = [0,1,2];
				names[0] = ["Amulette","Mineralien","Waffen","Sonder items"];
				names[1] = [0,1,2,3,4,5,6,7];
					//St�rke, Stabilit�t, Leben, Erfahrung
					names[1][0] = [3,-2,0,0];
					names[1][1] = [-2,3,0,0];
					names[1][2] = [0,0,30,-4];
					names[1][3] = [0,0,-20,6];
					names[1][4] = [3,0,-20,0];
					names[1][5] = [-2,0,30,0];
					names[1][6] = [0,3,0,-4];
					names[1][7] = [0,-2,0,6];
			var cut = ["","",""];
			/* String to code */
			while (out != ""){
				cut[0] = out.indexOf("/");
				cut[1] = out.substring(0, cut[0]); //String aus Items
				out = out.slice(cut[0] + 1);
				
				if(i > 1){
					name = "items" + (i-2);
					tab = document.getElementById(name);
						tab.innerHTML = ""; //Inhalt löschen
						tr = document.createElement("tr");
							th = document.createElement("th");
								th.setAttribute("colspan", "6");
								th.innerHTML = names[0][i-2];
						tr.appendChild(th);
					tab.appendChild(tr);
				}
				
				l = 0;
				while (cut[1] != ""){
					cut[2] = cut[1].indexOf("#");
					item = cut[1].substring(0, cut[2]).split(",");
					/* ARRAYINDEX -> item
					* 0 - id
					* 1 - typ
					* 2 - life
					* 3 - level
					* 4 - count
					* 5 - price 
					* 6 - status */
					cut[1] = cut[1].slice(cut[2] + 1);
					
					/* Drawing */
					switch(i){
						case 0:
							draw_item(tr,item,1);
							str = (new Number(item[3])+1)*(item[1]-1);
							document.getElementById("damage").innerHTML = str;
						break;
						case 1:
							draw_item(tr,item,1);
							r = item[3];
							r1 = Math.floor(r/64);
							r -= r1*64;
							r2 = Math.floor(r/8);
							r -= r2*8;
							r3 = r;
							
							x = names[1][r1][0] + names[1][r2][0] + names[1][r3][0];
							document.getElementById("amulett_str").innerHTML = x;
							str = 2*(x+str);
							
							x = names[1][r1][1] + names[1][r2][1] + names[1][r3][1];
							document.getElementById("amulett_bal").innerHTML = x;
							level = new Number(document.getElementById("level").innerHTML);
							document.getElementById("bal_level").innerHTML = level;
							bal = 2*(level+x);
							
							x = names[1][r1][2] + names[1][r2][2] + names[1][r3][2];
							document.getElementById("amulett_life").innerHTML = x;
							life = 100+x;
							
							x = names[1][r1][3] + names[1][r2][3] + names[1][r3][3];
							document.getElementById("amulett_exp").innerHTML = x;
							exp = 1 + x;
							
							document.getElementById("str").innerHTML = str;
							document.getElementById("bal").innerHTML = bal;
							document.getElementById("life").innerHTML = life;
							document.getElementById("exp_s").innerHTML = exp;
						break;
						default:
							if(l == 0){
								tr = document.createElement("tr");
								tab.appendChild(tr);
								l++;
							} else {
								if(w <= 650){  //MOBILE ONLY
									tr = document.createElement("tr");
									tab.appendChild(tr);
								}
								l = 0;
							}
							draw_item(tr,item,0);
					}
				}
				i++;
			}
		}
	}
	xmlhttp.send(null);
}

function draw_item(tr,str_parts,typ){
	var names = [0,1,2];
		names[0] = [0,1,2,3];
			//Itemtyps: 0 Amulett; 1 Mineral; 2 Steinschwert; 3 Bronzeschwert; 4 Silberschwert; 5 Stahlschwert
			names[0][0] = ["Zerst�rung","Erschaffung","Befestigung","L�slichkeit","Verschwendung","Lebenskraft","Konzentration","Improvisation"];
			names[0][1] = ["Steinholz","Kupfer","Eisen","Silber","Stahl"];
			names[0][2] = ["Steinschwert","Bronzeschwert","Eisenschwert","Silberschwert","Stahlschwert"];
			names[0][3] = ["Schlechtes<br>","","Gutes<br>","Verbessertes<br>"];
		names[1] = [0,1,2,3,4,5,6,7];
			//St�rke, Stabilit�t, Leben, Erfahrung
			names[1][0] = [3,-2,0,0];
			names[1][1] = [-2,3,0,0];
			names[1][2] = [0,0,30,-4];
			names[1][3] = [0,0,-20,6];
			names[1][4] = [3,0,-20,0];
			names[1][5] = [-2,0,30,0];
			names[1][6] = [0,3,0,-4];
			names[1][7] = [0,-2,0,6];
	var w=window.outerWidth; //Mobile!
	
	if(typ == 1){
		if(str_parts[0] == 0){ //Kein Objekt
			error('Ihnen fehlt Ausrüstung.<br><a onclick="changemenu(1);">kaufen Sie sich die passende Ausrüstung auf dem Markt</a>');
			if(str_parts[1] == 0){ //Amulett
				document.getElementById("eq_a_info").innerHTML = '<p onclick="changemenu(1);">Kein Amulett</p>';
			} else {
				document.getElementById("eq_w_info").innerHTML = '<p onclick="changemenu(1);">Keine Waffe</p>';
			}
		}
		if(str_parts[1] == 0){
			document.getElementById("eq_a_pic").innerHTML = '<img src="images/items/' + str_parts[1] + '.svg">';
			var info = document.getElementById("eq_a_info");
			if(str_parts[2] == 8){
				info.innerHTML = "<b>Amulett(100%)</b>";
			} else if (str_parts[2] > 5 && str_parts[2] < 8){
				info.innerHTML = "<b>Amulett(80%)</b>";
			} else if(str_parts[2] > 3 && str_parts[2] < 6){
				info.innerHTML = "<b>Amulett(60%)</b>";
			} else if(str_parts[2] > 1 && str_parts[2] < 4){
				info.innerHTML = "<b>Amulett(40%)</b>";
			} else {
				info.innerHTML = "<b>Amulett(20%)</b>";
			}
			var rune1,rune2,rune3,i,x;
			i = str_parts[3];
			rune1 = Math.floor(i/64);
			i -= rune1*64;
			rune2 = Math.floor(i/8);
			i -= rune2*8;
			rune3 = i;
			x = names[1][rune1][0] + names[1][rune2][0] + names[1][rune3][0];
			if(x != 0){info.innerHTML += "<br>" + x + " Stärke";}
			x = names[1][rune1][1] + names[1][rune2][1] + names[1][rune3][1];
			if(x != 0){info.innerHTML += "<br>" + x + " Stabilität";}
			x = names[1][rune1][2] + names[1][rune2][2] + names[1][rune3][2];
			if(x != 0){info.innerHTML += "<br>" + x + " Leben";}
			x = names[1][rune1][3] + names[1][rune2][3] + names[1][rune3][3];
			if(x != 0){info.innerHTML += "<br>" + x + " Erfahrung";}
		} else {
			document.getElementById("eq_w_pic").innerHTML = '<img src="images/items/' + str_parts[1] + '.svg">';
			var info = document.getElementById("eq_w_info");
			
			info.innerHTML = '<b>' + names[0][3][str_parts[3]] + names[0][2][str_parts[1]-2] + '</b>';
			info.innerHTML += "<br><i>" + (new Number(str_parts[3])+1)*(str_parts[1]-1) + " Schaden</i>";
			info.innerHTML += "<br>";
			if(str_parts[2] == 8){
				info.innerHTML += '<b>Wie neu</b>';
			} else if(str_parts[2] > 5 && str_parts[2] < 8){
				info.innerHTML += '<b>So gut wie neu</b>';
			} else if(str_parts[2] > 3 && str_parts[2] < 6){
				info.innerHTML += '<b>Ben�tzt</b>';
			} else if(str_parts[2] > 1 && str_parts[2] < 4){
				info.innerHTML += '<b>Stark abgen�tzt</b>';
			} else {
				info.innerHTML += '<b>Kaputt</b>';
			}
		}
	} else {
		td = document.createElement("td");
		td.setAttribute("class", "pic");
		switch(str_parts[1]){
			case "5":
			case "4":
			case "3":
			case "2":
			case "0":
				td.innerHTML += '<img src="images/items/' + str_parts[1] + '.svg">';
				break;
			case "1":
				td.innerHTML += '<img src="images/items/' + str_parts[1] + '/' + str_parts[3] + '.png">';
				break;
			default:
				td.innerHTML = '<img src="images/sword.png">';
		}
		tr.appendChild(td);
		td = document.createElement("td");
			td.setAttribute("class", "info");
			b = document.createElement("b"); //Name des Items
			td.appendChild(b);
		tr.appendChild(td);
		if(str_parts[1] == 0){ //Amulett
			var rune1,rune2,rune3,i,x;
			i = str_parts[3];
			rune1 = Math.floor(i/64);
			i -= rune1*64;
			rune2 = Math.floor(i/8);
			i -= rune2*8;
			rune3 = i;
			if(str_parts[2] == 8){
				b.innerHTML = "Amulett(100%)";
			} else if (str_parts[2] > 5 && str_parts[2] < 8){
				b.innerHTML = "Amulett(80%)";
			} else if(str_parts[2] > 3 && str_parts[2] < 6){
				b.innerHTML = "Amulett(60%)";
			} else if(str_parts[2] > 1 && str_parts[2] < 4){
				b.innerHTML = "Amulett(40%)";
			} else {
				b.innerHTML = "Amulett(20%)";
			}
			x = names[1][rune1][0] + names[1][rune2][0] + names[1][rune3][0];
			if(x != 0){td.innerHTML += "<br>" + x + " Stärke";}
			x = names[1][rune1][1] + names[1][rune2][1] + names[1][rune3][1];
			if(x != 0){td.innerHTML += "<br>" + x + " Stabilität";}
			x = names[1][rune1][2] + names[1][rune2][2] + names[1][rune3][2];
			if(x != 0){td.innerHTML += "<br>" + x + " Leben";}
			x = names[1][rune1][3] + names[1][rune2][3] + names[1][rune3][3];
			if(x != 0){td.innerHTML += "<br>" + x + " Erfahrung";}
		} else if(str_parts[1] == 1){//ist es ein Material
			b.innerHTML = names[0][str_parts[1]][str_parts[3]];
			td.innerHTML += "<br><i>+" + (new Number(str_parts[3])+1) + " Angriff</i>";
			td.innerHTML += '<br><b>Anzahl:</b> ' + str_parts[4];
		} else if(str_parts[1] >= 2 && str_parts[1] <= 6){//ist es ein Schwert
			b.innerHTML = names[0][3][str_parts[3]] + names[0][2][str_parts[1]-2];
			td.innerHTML += "<br><i>" + (new Number(str_parts[3])+1)*(str_parts[1]-1) + " Schaden</i>";
			td.innerHTML += "<br>";
			if(str_parts[2] == 8){
				td.innerHTML += '<b>Wie neu</b>';
			} else if(str_parts[2] > 5 && str_parts[2] < 8){
				td.innerHTML += '<b>So gut wie neu</b>';
			} else if(str_parts[2] > 3 && str_parts[2] < 6){
				td.innerHTML += '<b>Ben�tzt</b>';
			} else if(str_parts[2] > 1 && str_parts[2] < 4){
				td.innerHTML += '<b>Stark abgen�tzt</b>';
			} else {
				td.innerHTML += '<b>Kaputt</b>';
			}
		} else {
			b.innerHTML = "Unbekanntes Objekt";
		}
	
		/*** Optionen ***/
		td = document.createElement("td");
			if(w <= 650){ //MOBILE ONLY
				td.setAttribute("width", "50%");
			} else { 
				td.setAttribute("width", "25%");
			}
			switch(typ){
				case 0: // Profil
					if(str_parts[6] > 0){ // Profil - Am Markt
						a = document.createElement("a");
							a.setAttribute("class", "button");
							a.innerHTML = "vom Markt nehmen";
							a.setAttribute("onclick", "sell(" + str_parts[0] + ",1);");
						td.appendChild(a);
					} else { //Normal
						td.innerHTML += 'Preis:';
						input = document.createElement("input");
							input.setAttribute("id", "price_" + str_parts[0]);
							input.setAttribute("type", "number");
							input.setAttribute("size", "4");
							input.defaultValue = str_parts[5];
						td.appendChild(input);
						td.innerHTML += '#';
						
						a = document.createElement("a");
							a.setAttribute("class", "button");
							a.innerHTML = "Verkaufen";
							a.setAttribute("onclick", "sell(" + str_parts[0] + ",0);");
						td.appendChild(a);
					
						if(str_parts[1] >= 2 && str_parts[1] <= 6){ //Eine Waffe
							if(str_parts[3] != 3){
								a = document.createElement("a");
									a.setAttribute("class", "button");
									if(str_parts[2] == 8){a.innerHTML = "Verbessern";} else {a.innerHTML = "Reparieren";}
									a.setAttribute("onclick", "upgrade(" + str_parts[0] + ");");
								td.appendChild(a);
							}
							a = document.createElement("a");
								a.setAttribute("class", "button");
								a.innerHTML = "Anlegen";
								a.setAttribute("onclick", "equip(" + str_parts[0] + ");");
							td.appendChild(a);
						} else if(str_parts[1] == 0){
							if(str_parts[2] != 8){
								a = document.createElement("a");
									a.setAttribute("class", "button");
									a.innerHTML = "Aufladen";
									a.setAttribute("onclick", "upgrade(" + str_parts[0] + ");");
								td.appendChild(a);
							}
							
							a = document.createElement("a");
								a.setAttribute("class", "button");
								a.innerHTML = "Anlegen";
								a.setAttribute("onclick", "equip(" + str_parts[0] + ");");
							td.appendChild(a);
						}
					}
					break;
				case 2: //Markt
					a = document.createElement("a");
						a.setAttribute("class", "button");
						switch(str_parts[6]){
							case 2:
								if(str_parts[1] >= 2 && str_parts[1] <= 6){ //Eine Waffe
									if(str_parts[3] != 3){
										a = document.createElement("a");
											a.setAttribute("class", "button");
											if(str_parts[2] == 8){a.innerHTML = "Verbessern";} else {a.innerHTML = "Reparieren";}
											a.setAttribute("onclick", "upgrade(" + str_parts[0] + ");");
										td.appendChild(a);
									}
									a = document.createElement("a");
										a.setAttribute("class", "button");
										a.innerHTML = "Anlegen";
										a.setAttribute("onclick", "equip(" + str_parts[0] + ");");
									td.appendChild(a);
								}
								a.innerHTML = "Am Markt verkaufen";
								a.setAttribute("onclick", "sell(" + str_parts[0] + ",1);");
								break;
							case 0:
								if(str_parts[6] == 0){
									a.innerHTML = "Anderen zur Verfügung stellen";
									a.setAttribute("onclick", "sell(" + str_parts[0] + ",2);");
								} else {
									a.innerHTML = "Kaufen";
									a.setAttribute("onclick", "buy(" + str_parts[0] + ");");
								}
								//Anlegen?!
								break;
							default:
								a.innerHTML = "Typ ist " + str_parts[7];
						}
					td.appendChild(a);
					break;
			}
		tr.appendChild(td);
	}
}

function sell(id,typ){
	if(typ == 0){
		price = document.getElementById("price_" + id);
		if(price.value == ""){price.value = 0}
		if(isNaN(price.value) == false){
			var url = 'xmlhttp/sellitem.php?id=' + id + '&price=' + price.value;
			xmlhttp.open('get', url,false);
			xmlhttp.onreadystatechange = function(){
				if (xmlhttp.readyState == 4 && xmlhttp.status==200){
					if(xmlhttp.responseText == 0){//Alles ging gut
						items();
						error("clear");
					} else {
						if(xmlhttp.responseText == 1){
							error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
						} else {
							error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
						}
					}
				}
			}
			xmlhttp.send(null);
		} else {
			error("Vorgang abgebrochen: Der Preis ist nicht gülitig");
		}
	} else if(typ < 3){
		var url = 'xmlhttp/sellitem.php?id=' + id + '&typ=' + typ;
		xmlhttp.open('get', url,false);
		xmlhttp.typ = typ;
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status==200){
				if(xmlhttp.responseText == 0){//Alles ging gut
					if(xmlhttp.typ == 1){
						items();
					} else {
						document.getElementById("offer_" + 0).innerHTML = "";
						offer(0);
						document.getElementById("offer_" + 2).innerHTML = "";
						offer(2);
						error("clear");
					}
				} else {
					if(xmlhttp.responseText == 1){
						error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
					} else {
						error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
					}
				}
			}
		}
		xmlhttp.send(null);
	}
}

function equip(id){
	var url = 'xmlhttp/equip.php?id=' + id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			if(xmlhttp.responseText == 0){//Alles ging gut
				items();
				error("clear");
			} else {
				if(xmlhttp.responseText == 1){
					error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
				} else {
					error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
				}
			}
		}
	}
	xmlhttp.send(null);
}

function upgrade(id){
	var url = 'xmlhttp/upgrade.php?id=' + id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			if(xmlhttp.responseText == 0){//Alles ging gut
				items();
				error("clear");
			} else {
				if(xmlhttp.responseText == 1){
					error("Vorgang abgebrochen: Ein unbekannter Fehler ist aufgetreten");
				} else if(xmlhttp.responseText == 2) {
					error("Vorgang abgebrochen: Nicht genügend Materialien");
				} else if(xmlhttp.responseText == 3){
					error("Vorgang abgebrochen: Nicht genügend Steinholz");
				} else {
					error("Vorgang abgebrochen:<i>" + xmlhttp.responseText + "</i>");
				}
			}
		}
	}
	xmlhttp.send(null);
}