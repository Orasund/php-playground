	var names = ["places","maps"];
		names["places"] = [0,1,2,3,4];
			names["places"][0] = ["Burg","Castle"];
			names["places"][1] = ["Markt","Market"];
			names["places"][2] = ["Arena","Arena"];
			names["places"][3] = ["Mine","Mine"];
			names["places"][4] = ["Turm","Tower"];
		names["maps"] = [0,1];
			names["maps"][0] = ["A","B","C","D"];
			names["maps"][1] = ["Armun","Baltar","Cardul","Dales"];
		
	var desc = [0,1,2,3,4];
		desc[0] = [0,1];
			desc[0][0] = ["Das Schloss ist das einzige gro�e Geb�ude auf der Insel. Es schau sehr alt aus und hat viele versteckte Korridore und R�ume. Nur der vordere Teil des Schlosses wird von euch ben�tzt.<br>R�ume:<i>Schlafsaal,Schmiede,Versammlungsraum,Mine,Trainningsraum</i>",""];
			desc[0][1] = ['Im Schloss werden Statistiken angezeigt und Abstimmungen zu allen aktuellen Themen gemacht, es werden auch alle aktuellen Nachrichten angezeigt.<br>Einige Felder k�nnen ausgebaut werden, du kannst abstimmen welche',""];
		desc[1] = [0,1];
			desc[1][0] = ['Der Markt ist nicht sehr gro�, aber besitzt eine gute �bersicht von allen Produkten die auf der Insel hergestellt worden sind.',""];
			desc[1][1] = ['Hier hast du die M�glichkeit Waffen und Runen mit anderen Leuten zu tauschen. Die W�hrung ist Steinholz(#), ein Rohstoff aus dem Waffen und Runen gemacht werden.',""];
		desc[2] = [0,1];
			desc[2][0] = ['Hier k�nnen Testk�mpfe durchgef�hrt werden um die Erfahrung zu verbessern.',""];
			desc[2][1] = ['Das spiel ist wie ein Kartenspiel aufgebaut. Die Zusatzkarte, welche ganz am Anfang bestimmt wird, ist dabei am wichtisten. Sie bestimmt gro�teils des Spiels.',""];
		desc[3] = [0,1];
			desc[3][0] = ['In der Mine ist es sehr stickig, und dunkel. Neben der Mine befindet sich ein kleiner Lagerraum, in dem einige Materialien gelagert werden. Jeder kann mithelfen die Mine zu vergr��ern um bessere Sch�tze zu finden oder er kann auch an dem Lager arbeiten, es deine Entscheidung',""];
			desc[3][1] = ['In der Mine gibt es Steinholz(#),Kupfererz,Eisenerz,Silbererz und Runenstein. Durch Abstimmungen kann beschlossen werden, an was als n�chsters gearbeitet wird. Die Vergr��erung der Mine bringt bessere Mineralien, doch die Vergr�erung des Lagers bringt zusa�tzlich Geld f�r alle Mitspieler.',""];
		desc[4] = [0,1];
			desc[4][0] = ['Der Wachturm sch�tzt die Insel vor Feinde. Jeden Tag findet ein Angriff auf der Br�cke statt. Hat eine Gruppe dabei gewonnen, so kann diese den feindlichen Wachturm einnehmen. Schafft es die Verteidigende Gruppe nicht am n�chsten Tag den Wachturm wieder einzunehmen, so haben sie verloren.',""];
			desc[4][1] = ['Jeden Tag musst du auf einen Wachturm gehen. Hier kannst du w�hlen auf welchen du gehst.',""];

function focus(num, focus,id,typs_num,insel){
	var txt;
	if(id == typs_num[num]){
		focus.setAttribute("class", ids[typs_num[num]] + " focus");
		txt = document.createTextNode(names["places"][typs_num[num]][0]);
	} else {
		focus.setAttribute("class", ids[typs_num[num]]);
		txt = document.createTextNode(names["maps"][0][insel] + (num+1));
	}
	if(typs_num[num] == 1){
		focus.setAttribute("onClick", "market();changemenu(" + typs_num[num] + ");");
	} else {focus.setAttribute("onClick", "changemenu(" + typs_num[num] + ");");}
	focus.appendChild(txt);
}

function map(id){
	xmlhttp.mapid = id;
	var url = 'xmlhttp/getisland.php';
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var id = xmlhttp.mapid;
			var output = xmlhttp.responseText;
			
			var islands = [0,1,2,3];
				islands[0] = [0,1,2];
					islands[0][0] = [1,2,5];
					islands[0][1] = [4,3,0];
					islands[0][2] = [7,0,6];
				islands[1] = [0,1,2];
					islands[1][0] = [7,4,1];
					islands[1][1] = [0,3,2];
					islands[1][2] = [6,0,5];
				islands[2] = [0,1,2];
					islands[2][0] = [6,0,7];
					islands[2][1] = [0,3,4];
					islands[2][2] = [5,2,1];
				islands[3] = [0,1,2];
					islands[3][0] = [5,0,6];
					islands[3][1] = [2,3,0];
					islands[3][2] = [1,4,7];
		
			/* Old System
				islands[0] = [0,1,2,3];
					islands[0][0] = [0,0,0,0];
					islands[0][1] = [0,1,2,5];
					islands[0][2] = [7,4,3,0];
					islands[0][3] = [0,0,6,0];
				islands[1] = [0,1,2,3];
					islands[1][0] = [0,0,7,0];
					islands[1][1] = [6,3,4,0];
					islands[1][2] = [0,2,1,0];
					islands[1][3] = [0,5,0,0];
				islands[2] = [0,1,2,3];
					islands[2][0] = [0,0,6,0];
					islands[2][1] = [5,2,3,0];
					islands[2][2] = [0,1,4,7];
					islands[2][3] = [0,0,0,0];
				islands[3] = [0,1,2,3];
					islands[3][0] = [0,6,0,0];
					islands[3][1] = [0,3,4,7];
					islands[3][2] = [0,1,2,0];
					islands[3][3] = [0,0,5,0];*/
			
			/* String to code */
			//z2,z3,z4,mine,save
			var str_parts = [
				output.split(",")[0],	//0 - id
				output.split(",")[1],	//1 - z2
				output.split(",")[2],	//2 - z3
				output.split(",")[3],	//3 - z4
				output.split(",")[4],	//4 - mine
				output.split(",")[4],	//4 - save
			];
			var typs_num = [0,str_parts[1],str_parts[2],str_parts[3],4,4,4];
	
			var map = document.getElementById(ids[id]);
			var target = map.childNodes[1];
				target.setAttribute("class", "map");
			
			var th,tr,td;
			
			tr = document.createElement("tr");//�berschrift
				tr.setAttribute("class", "header"); // alle folgenden th werden normal angezeigt
				th = document.createElement("th"); //Karten�brschrift
					th.setAttribute("colspan", "3");
					th.innerHTML = "Karte von " + names["maps"][1][str_parts[0]];
				tr.appendChild(th);
				th = document.createElement("th");
					th.setAttribute("class", "info");
					th.innerHTML = names["places"][id][0];
				tr.appendChild(th);
			target.appendChild(tr);
			
			/***************************
					DIE MAP
			***************************/
			for(x in islands[str_parts[0]]){
				tr = document.createElement("tr");//Neue Reihe
				for(i in islands[str_parts[0]][x]){
					switch(islands[str_parts[0]][x][i]){
						case 0: //Leeres Feld
							td = document.createElement("td");
								td.setAttribute("class", "empty");
							tr.appendChild(td);
							break;
						default: //Burg
							th = document.createElement("td");
								focus(islands[str_parts[0]][x][i]-1, th, id,typs_num,str_parts[0]);
							tr.appendChild(th);
					}
				}
				if (x == 0){
					td = document.createElement("td");
						td.setAttribute("rowspan", "3");
						td.setAttribute("class", "info");
						td.innerHTML = "<b>Beschreibung</b><br>" + desc[id][0][0] + "<br><br><b>Funktionen:</b><br>" + desc[id][1][0];
					tr.appendChild(td);
				}
				target.appendChild(tr);//Ende der Reihe
			}
		}
	}
	xmlhttp.send(null);
}