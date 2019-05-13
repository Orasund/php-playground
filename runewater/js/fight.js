var xmlhttp = new XMLHttpRequest();

var life_e_count = 200;
var life_y_count = 200;

var fightround = 0;
var hand_y, hand_e, zc_y, zc_e;

function cards(id){
	var cards = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
	cards[0] = [4,1,1,"Runen Admiral", "Rune admiral",0];
	cards[1] = [3,2,1,"Runen Kämpfer", "Rune fighter",1];
	cards[2] = [2,3,1,"Runen Erfinder", "Rune creator",2];
	cards[3] = [1,4,1,"Runen Helfer", "Rune helper",3];
	cards[4] = [3,2,2,"Silber Admiral", "Silver admiral",0];
	cards[5] = [4,1,2,"Silber Kämpfer", "Silver fighter",1];
	cards[6] = [1,4,2,"Silber Erfinder", "Silver creator",2];
	cards[7] = [2,3,2,"Silber Helfer", "Silver helper",3];
	cards[8] = [2,3,3,"Gold Admiral", "Gold admiral",0];
	cards[9] = [1,4,3,"Gold Kämpfer", "Gold fighter",1];
	cards[10] = [4,1,3,"Gold Erfinder", "Gold creator",2];
	cards[11] = [3,2,3,"Gold Helfer", "Gold helper",3];
	cards[12] = [1,4,4,"Holz Admiral", "Stone admiral",0];
	cards[13] = [2,3,4,"Holz Kämpfer", "Stone fighter",1];
	cards[14] = [3,2,4,"Holz Erfinder", "Stone creator",2];
	cards[15] = [4,1,4,"Holz Helfer", "Stone helper",3];
	return(cards[id]);
}

var xmlhttp = new XMLHttpRequest();
		
function fight(fight){
	var url = 'xmlhttp/getfight.php'; //vorerst
	xmlhttp.fightid = fight;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			var id = xmlhttp.fightid;
			var fight = document.getElementById(id + "_fight");
			var attacker = document.getElementById(id + "_attacker");
			var defender = document.getElementById(id + "_defender");
			var info = document.getElementById(id + "_info");
			var txt = '';
			
			var parts = [
				output.split(",")[0],	//0 - id
				output.split(",")[1],	//1 - a_zcard
				output.split(",")[2],	//2 - d_zcard
				output.split(",")[3],	//3 - a_life
				output.split(",")[4],	//4 - d_life
				output.split(",")[5],	//5 - a_choise
				output.split(",")[6],	//6 - d_choise
				output.split(",")[7],	//7 - turn
				output.split(",")[8],	//8 - a_card1
				output.split(",")[9],	//9 - a_card2
				output.split(",")[10],	//10 - a_card3
				output.split(",")[11],	//11 - a_card4
				output.split(",")[12],	//12 - a_card5
				output.split(",")[13],	//13 - a_ass
				output.split(",")[14],	//14 - d_ass
			];
			
			attacker.innerHTML = fight_player(0,parts);
			defender.innerHTML = fight_player(1,parts);
			fight.innerHTML = fight_buttons(id,parts);
			
			if(parts[7] == 0){
				if(parts[5] != 0 && parts[6] != 0){
					txt += 'Ihr müsst eure Zusatzkarte wählen.<br>';
				} else {
					txt += 'Ihr müsst eure Zusatzkarte wählen.<br>';
					if(parts[5] == 0){
						txt += 'Du musst deine Zusatzkarte wählen';
					} else {
						txt += 'Dein Gegner muss noch eine Zusatzkarte wählen';
					}
				}
			} else if(parts[7] == 1){ //TODO: Nicht ausgereift man weiß nicht ob er wirklich angreift oder nicht
				txt += 'Du greifst an.<br>';
				if(parts[5] == 0){
					txt += 'Du musst deine Angriffskarte wählen';
				} else {
					txt += 'Dein Gegner muss noch eine Verteidigungskarte wählen';
				}
			} else if(parts[7] == 2){
				txt += 'Dein Gegner greift an.<br>';
				if(parts[5] == 0){
					txt += 'Du musst deine Verteidungskarte wählen';
				} else {
					txt += 'Dein Gegner muss noch eine Angriffskarte wählen';
				}
			} else {
				txt += 'Ein Fehler wurde gefunden';
			}
			info.innerHTML = txt;
		}
	}
	xmlhttp.send(null);
}

function fight_player(id,parts){
	var txt = '';
	var x,i;
	txt += '<b><meter value="' + parts[3+id] + '" max="100">' + parts[3+id] + '</meter><span class="info"> Leben</span></b><br>';
	txt += '<meter value="' + parts[13+id] + '" max="5">' + parts[13+id] + '</meter><span class="info"><b>Ass(e)</b></span><br>';
	if(parts[1+id] != 0){txt += '<b>Zusatzkarte:</b>' + cards(parts[1+id])[3] + '<br>';}
	if(parts[5+id] == 0){txt += '<b><span class="info">Status:</span> Überlegt...</b><br>';} else {
		if(id == 0){
			i = parts[5+id]-1;
			txt += '<span class="info"><b>Status:</b> Du hast ' + cards(i)[3] + ' Ausgewählt</span><br>';
		} else {
			txt += '<b class="info">Status:</b> Fertig<br>';
		}
	}
	return(txt);
}

function fight_buttons(fight,parts){
	var txt = '';
	var card,x;
	if(parts[3] <= 0 || parts[4] <= 0 ){
		txt += '<a class="button" onclick="fight(' + "'" + fight + "'" + ');">Neues Spiel beginnen?</a>';
	} else {
		for(var i=1; i<=5; i++){
			x = 7+i;
			if(parts[x]!=0){
				var card = cards(parts[x]-1);
				txt += '<a class="button" onclick="setfight(' + "'" + fight + "'" + ',' + parts[0] + ',' + i + ');">' + card[2-parts[7]] + "-" + card[3] + '</a>';
			}
		}
	}
	return(txt);
}

function setfight(fight,id,opt){
	var url = 'xmlhttp/setfight.php?id=' + id + '&choise=' + opt;
	xmlhttp.fightid = fight;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var output = xmlhttp.responseText;
			var id = xmlhttp.fightid;
			var txt = '';
			var fight = document.getElementById(id + "_fight");
			var attacker = document.getElementById(id + "_attacker");
			var defender = document.getElementById(id + "_defender");
			var info = document.getElementById(id + "_info");
			var exit;
			
			var parts = [
				output.split(",")[0],	//0 - id
				output.split(",")[1],	//1 - a_zcard
				output.split(",")[2],	//2 - d_zcard
				output.split(",")[3],	//3 - a_life
				output.split(",")[4],	//4 - d_life
				output.split(",")[5],	//5 - a_choise
				output.split(",")[6],	//6 - d_choise
				output.split(",")[7],	//7 - turn
				output.split(",")[8],	//8 - a_card1
				output.split(",")[9],	//9 - a_card2
				output.split(",")[10],	//10 - a_card3
				output.split(",")[11],	//11 - a_card4
				output.split(",")[12],	//12 - a_card5
				output.split(",")[13],	//13 - a_asse
				output.split(",")[14],	//14 - d_asse
			];
			attacker.innerHTML = fight_player(0,parts);
			defender.innerHTML = fight_player(1,parts);
			fight.innerHTML = fight_buttons(id,parts);
			//txt = output; Debug Mode
			if(output == 0){ //Fehler im Php script?
				txt = 'Ein Fehler wurde gefunden';
			} else if(parts[3] <= 0){ //Du hast kein Leben mehr?
				txt = 'du hast kein Leben mehr.<br> du hast verloren';
			} else if(parts[4] <= 0){ //Dein Gegner hat kein Leben mehr?
				txt = 'dein Gegner hat kein Leben mehr<br> du hast Gewonnen!';
			} else if(parts[7] == 0){ //Es wurden Zusatzkarten ausgesucht
				txt += 'Ihr müsst eure Zusatzkarte wählen.<br>';
				if(parts[5] == 0){
					txt += 'Du musst deine Zusatzkarte wählen';
				} else {
					txt += 'Dein Gegner muss noch eine Zusatzkarte wählen';
				}
			} else if(parts[7] == 1){ //TODO: Nicht ausgereift
				txt += 'Du greifst an.<br>';
				if(parts[5] == 0){
					txt += 'Du musst deine Angriffskarte wählen';
				} else {
					txt += 'Dein Gegner muss noch eine Verteidigungskarte wählen';
				}
			} else if(parts[7] == 2){
				txt += 'Dein Gegner greift an.<br>';
				if(parts[5] == 0){
					txt += 'Du musst deine Verteidungskarte wählen';
				} else {
					txt += 'Dein Gegner muss noch eine Angriffskarte wählen';
				}
			} else {
				txt += 'Ein Fehler wurde gefunden';
			}
			info.innerHTML = txt;
		}
	}
	xmlhttp.send(null);
}