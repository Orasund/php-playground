<?php
	include 'plugins/fast_fight.php';
	include 'plugins/portal.php';
	include 'plugins/quest.php';
	
	//Falls etwas gekauft werden soll
	if(isset($_GET["kaufen"])){
		//Alle Daten zum User werden geholt und in $user gespeichert
		$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
		// hat die Person �berhaupt genug Geld?
		$item = mysql_fetch_array(mysql_query("select * from itemdex where id='$_GET[kaufen]'"));
		if ($item["wert"] <= $user["money"]){
			$user["money"] -= $item["wert"];
			mysql_query("update users set money='$user[money]' where id='$_SESSION[user_id]'");
			
			// Hat die Person so ein Item schon?
			if (mysql_num_rows( mysql_query( "SELECT * FROM items WHERE dexid='$_GET[kaufen]' AND user='$_SESSION[user_id]'" ) ) != 0){
				$item = mysql_fetch_array(mysql_query("select * from items where dexid='$_GET[kaufen]' and user='$_SESSION[user_id]'"));
				$number = $item["number"] + 1;
				mysql_query("update items set number='$number' where id='$item[id]'") or die(mysql_error());
			} else {
				mysql_query("insert into items (dexid,user, number) VALUES ('$_GET[kaufen]','$_SESSION[user_id]','1')");
			}
		}
	}

function npcs($id){
	//Alle Daten zum User werden geholt und in $user gespeichert
	$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));

	//Die Spielfl�che um das Bild herum
	echo '<p><form action="world.php" method="post" name="form" id="form">
                <div class="forms">
                    <div style="position:relative;height:416px;width:416px;">';
		
		//Das Bild
		echo '<img src="maps/' . $id . '.png">';
	
		//Index:
		/********************* NICHT MIT ENTER RUMSPIELEN!!!! *************************/
		/********************* JEDER NPC MUSS IN EINE ZEILE!!! ****************************/
		
		// Alerbastia
		if($id == 1){
			sign(1, "Alabastia", "<p>das letzt Dorf vor Johto<p>", 13, 14);
			talk(52, "kleiner Junge", "<p>Meine Mamma hat mir erzählt das es irgendwo da drausen eine große Insel gibt.<br>Ich darf noch nicht so weit raus schwimmen, aber wenn ich groß bin will ich umbedingt einmal dorthin.</p>",15, 23);
			portal(2, "up", 16, 0);
			portal(3, "left", 0, 10);
			//$quest = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='2' AND userid='$_SESSION[user_id]'" ));
			//if ($quest["num"] >= 1){
				portal(502, "indoor", 19, 16);
			//}
			shop(50, "Reisender Händler", "<p>Hallo Neuling, Willkommen in Alabastia. <br>Für dein Abenteuer wirst du Items brauchen. <br>Ich kann dir welche verkaufen.</p>",array(1,2), 14, 11);
		}
	
		//Route 1
		if($id == 2){
			// Hornliu und Rattikarl
			$sporn = array(5, 7);
			first_fight($sporn);			
			sign(1, "Holpriger Feldweg", "<p>ein kleiner Feldweg mit vielen Hügeln. Ein Auto wurde große Probleme haben hier durch zukommen.<p>", 15, 12);
			portal(1, "down", 16, 24);
			portal(4, "up", 12, 0);
			fight($sporn, 6, 3);
			fight($sporn, 18, 4);
			fight($sporn, 17, 14);
			fight($sporn, 18, 20);
			fight($sporn, 6, 19);
		}
		
		
		// Strand von Alerbastia
		if($id == 3){
			portal(1, "right", 24, 10);
			sign(1, "Srand von Alerbastia", "<p>Ein kleiner Strand der auch als Trainningsplatz für junge Trainner geeignet ist.<p>", 19, 13);
			talk(52, "kleiner Junge", "<p>Irgendwo da drausen ist Johto. Im Sommer fahr ich mal mit meinem Papa hinüber.</p>", 6, 11);
		}
	
		//Vertania - Vorstadt
		if($id == 4){
			// Hornliu und Rattikarl
			$sporn = array(5, 7);
			sign(1, "Vertania Markt", "<p>Der Markt vor Vertania, mitten in der Wildnis.<p>", 15, 6);
			portal(2, "down", 12,24);
			portal(5, "up", 4,0);
			portal(7, "left", 0,14);
			portal(501, "indoor", 12,7);
			talk(54, "Trainner von Prismania City", "<p>Es gibt einen schleichweg nach Prismania City. Ich kann ihn dir zeigen, wenn du mir einen Kaffee besorgst.</p>", 12, 11);
			talk(55, "Trainnerin auf Durchreise", "<p>Ich kann dir was verraten:<br>wenn du durch den Vertania Wald gehst, dann nimm ein Fluchtseil und viele Tränke mit. Die wirst du dort brauchen.</p>", 8, 17);
			fight($sporn, 3, 20);
		}
		
		//Vertania Markt
		if($id == 501){
			portal(4, "down", 14,24);
			talk(55, "Trainnerin von Jotho", "<p>Hey, ich bin froh das ich entlich in Kanto bin.<br> Entlich komm ich zu Siph & Co.</p>", 9, 18);
			$quest = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='2' AND userid='$_SESSION[user_id]'" ));
			if ($quest["num"] == 1){
				talk(56, "Angestellter vom Silph & Co.", "<p>Hast das Packet schon an Prof. Eich geliefert?</p>", 20, 13);
			} else {
				$quest = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='2' AND userid='$_SESSION[user_id]'" ));
				if ($quest["num"] > 1){
					shop(56, "Angestellter vom Silph & Co.", "<p>Du kannst bei mir neue E-Produkte kaufen. Sie sind mit Strom betrieben. Besorge dir also davor besser noch ein Elektro-Pokemon.</p>",array(5), 20, 13);
				} else {
					quest(56, "Angestellter vom Silph & Co.", "<p>Ich komme von Silph & Co um einige neue Obejekte vorzustellen.<br> Kennst du Prof. Eich?<br>Eingedlich sollte er hier vorbeikommen und ein Packet abholen, aber er ist nicht erschienen.<br> könntest du es nicht zu ihm bringen?<br> Als Belohnung kannst du einige neue Objekte von mir kaufen.</p>", 2, 1, 20, 13);
				}			
			}
			shop(57, "Vertania Markt verkäuferin", "<p>Willkommen im Vertania Markt. Hier gibt es die mordernsten Items.</p>",array(1,2,3,4), 5, 11);
		}
		
		//Prof. Eichs Haus
		if($id == 502){
			portal(1, "down", 7,24);
			$quest = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='2' AND userid='$_SESSION[user_id]'" ));
			if ($quest["num"] == 1){
				quest(58, "Professor Eich", "<p>Ach, du hast ein Packet für mich?Endlich! Es ist ein neuer Chip für den PokeComb. Danke, ich werde ihn sofort einbauen.</p>", 2, 2, 6, 16);
			} else {
				$quest = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='2' AND userid='$_SESSION[user_id]'" ));
				if ($quest["num"] >= 2){
					talk(58, "Professor Eich", "<p>Bald ist der PokeComb Eingerichtet. Hab bitte bis dorthin noch ein wenig Geduld.</p>",6, 16);
				}
			}
		}
		
		//Vertania - Gildenhaus
		if($id == 5){
			if($user["citys"] == 0){mysql_query("update users set citys='1' where id='$_SESSION[user_id]'");}
			sign(1, "Vertania City", "<p>Eine Stadt am Fuße des Silberbergs. Sie besitzt einen eigenen See und einen Wald.</p>", 7, 11);
			sign(1, "Gildenhaus[Unbesetzt]", "<p>Bodenorden, Gildenhaus. Besitzt Zugriff auf alle Aktivitäten des Silberbergs.</p>", 20, 9);
			sign(1, "Fantasikus Caffee", "<p>Komm rein und trink mit uns einen leckeren Kaffee.</p>", 6, 7);
			portal(6, "left", 0,8);
			portal(4, "down", 4,24);
			portal(503, "indoor", 8,8);
			talk(66, "Ältester von Vertania", "<p>Vor der Besprächung drink ich immer meinen Kaffee in der Sonne.<br>Falls du einen leckeren Kaffee brauchst, hier in Vertania City gibt es den Besten Kaffee.</p>", 3, 7);
			portal(8, "up", 3,0);
		}
		
		//Fantasikus Caffee
		if($id == 503){
			shop(57, "Kaffee verkäuferin", "<p>Willst du einen Kaffee haben?</p>",array(6), 22, 14);
			portal(5, "down", 12,24);
		}
		
		//Vertania - Silbermine
		if($id == 6){
			sign(1, "Silbermine", "<p>Die Silbermine von Vertania ist Eigentum einer Gilde. Betreten verboten!</p>", 5, 8);
			sign(1, "Ausenstation", "<p>Der Lorenbahnhof ist Eigentum einer Gilde. Betreten verboten!</p>", 14, 7);
			portal(5, "right", 24,8);
			if($user["citys"] >= 2){
				portal(10, "speed_up", 18,5);
			}
			talk(60, "Minenarbeiter", "<p>Endlich wieder Sonne! Du kannst dir garnicht vorstellen wie stickig es dort unten ist! Ich bleib nur so lang ich wirklich muss.</p>", 15, 8);
			talk(60, "Minenarbeiter", "<p>Dort unten ist es so Dunkel, zum Glück bin ich jetzt wieder oben.</p>", 10, 14);
		}
		
		//Vertania - Vertania See
		if($id == 7){
			sign(1, "Anglerclub", "<p>Dieses Haus kann derzeit noch nicht benützt werden.</p>", 23, 7);
			portal(4, "right", 24,14);
			talk(62, "Angler", "<p>Der Vertania See ist für seine Schiggys bekannt. Vielleicht fängst du ja eines.</p>", 21, 20);
			talk(62, "Angler", "<p>Das Angeln ist schon eine schöne Sache.<br>Willst du auch Angeln? dann geh in den Anglerclub und melde dich an.</p>", 12, 4);
			talk(62, "Angler", "<p>Ich hab einen Fisch gefangen, der war Soo groß!</p>", 5, 17);
			$sporn = array(26,26,63,63,3,);
			fishing($sporn, 20, 12);
			fishing($sporn, 20, 17);
			fishing($sporn, 11, 20);
		}
		
		
		//Route 2
		if($id == 8){
			$sporn = array(4,5, 6, 7);
			first_fight($sporn);
			sign(1, "Waldweg", "<p>Ein kleiner Pfad, der zum Vertania Wald führt.</p>", 14, 14);
			talk(68, "Pokemon Sammler", "<p>Bevor du in den Vertania Wald gehst, brauchst du umbedingt ein Fluchtseil. Sonst kann es sein, dass du nie wieder hinaus findest.</p>", 9, 7);
			portal(5, "down", 3,24);
			portal(1001, "dun", 12,3);
		}
		
		//Vertania Wald - Dungeon
		if($id == 1001){
			$sporn = array(4,5, 6, 7, 10);
			first_fight($sporn);
			fight($sporn, 2, 6);
			fight($sporn, 7, 3);
			fight($sporn, 9, 7);
			fight($sporn, 18, 17);
			sign(1, "Vertania Wald", "<p>Ein schöner kleiner Wald der zwischen Vertania Wald und Marmoria City liegt</p>", 13, 17);
			talk(68, "Pokemon Sammler", "<p>Anscheined gibt es im Vertania Wald ein Elektropokemon. Das will ich haben!</p>", 9, 10);
			talk(69, "Pikachu Fan", "<p>Ich will eins dieser Süßen kleinen Pikachus haben, die hier im Wald sein soll.</p>", 19, 16);
			portal(8, "down", 12,24);
			portal(9, "up", 12,0);
		}
		
		//Route 2 - Anderes Ende
		if($id == 9){
			$sporn = array(4,5, 6, 7);
			first_fight($sporn);
			fight($sporn, 2, 5);
			fight($sporn, 9, 7);
			fight($sporn, 3, 4);
			fight($sporn, 18, 17);
			talk(54, "Wanderer aus Johto", "<p>Hier irgendwo muss es doch eine Arena geben oder?</p>", 13, 12);
			sign(1, "Felder von Marmoria City", "<p>Ein schöner Feldweg, der sich durch die Felder schlägelt.</p>", 13, 17);
			portal(10, "up", 20,0);
			portal(1001, "dun", 12,22);
		}
		
		//Marmoria City - Arena
		if($id == 10){
			if($user["citys"] == 1){mysql_query("update users set citys='2' where id='$_SESSION[user_id]'");}
			sign(1, "Marmoria City", "<p>Die Stadt in den Bergen</p>", 18, 20);
			sign(1, "Gildenhaus[Unbesetzt]", "<p>Steinorden, Gildenhaus. Besitzt Zugriff auf alle Aktivitäten des Fossillabors.</p>", 7, 9);
			portal(9, "down", 20,24);
			portal(11, "right", 24,22);
			talk(69, "junges Mädchen", "<p>Marmoria ist eine Schöne Stadt, aber ich mag lieber zur Küste.</p>", 4, 10);
		}
		
		//Marmoria Hügel
		if($id == 11){
			sign(1, "Unbebautes Grundstück", "<p>Es ist noch unklar was hier stehen wird. Falls es Ideen gibt, einfach melden. Eventuell werden hier einfach leerstehende Häuser sein.</p>", 13, 19);
			portal(10, "left", 0,22);
			portal(12, "up", 22,0);
			portal(14, "right", 24,21);
			talk(69, "Marmoria Göre", "<p>Ach ist das Leben nicht schön? Am liebsten würd ich hier den ganzen Tag lang liegen.</p>", 16, 11);
			talk(50, "Wanderer", "<p>Ha ha, ein herlicher Tag, den wir heute haben. Ich spüre den Sonnenschein und höre den Geschrei der Taubsis zu, was wünscht man sich mehr?</p>", 8, 19);
		}
		
		//Marmoria Hinterstadt
		if($id == 12){
			portal(11, "down", 22,24);
			portal(504, "indoor", 3,21);
			portal(13, "left", 1, 21);
			if($user["citys"] >= 3){
				portal(16, "speed_right", 16,3);
			}
			talk(54, "Quer-Feld-ein Trainner", "<p>Ich hasse die Straßen, weißt du was cool ist? Einfach Quer-Feld-ein über die Berge zu gehen, da findet man auch viel stärkere Pokemon.</p>", 7, 5);
			talk(65, "ältere Dame", "<p>Ich bin einfach zu alt für die neuen Schnellstraßen, aber für dich sind sie sicher sehr Praktisch, nicht war?</p>", 14, 13);
			talk(64, "Bürgermeister von Marmoria", "<p>Es wird sich alles ändern, diese Schwachköpfe, alles ändern.</p>", 5, 22);
		}

		//Marmoria Markt
		if($id == 504){
			shop(57, "Vertania Markt verkäuferin", "<p>Willkommen im Marmoria Markt. Der Herr da drüben kann dir ein VM verkaufen. geh doch einfach mal zu ihm.</p>",array(1,2,3,4), 5, 7);
			shop(58, "VM Raserei Verkäufer", "<p>Mit Raserei kannst du Schnellstraßen benützen. Sobald du einfach in einer Stadt warst kannst du sie mit der Schnellstraße blitzschnell erreichen. Bedenke das jedes Pokemon nur eine Attacke erlernen kann.</p>",array(7), 15, 8);
			portal(12, "down", 14,23);
			talk(68, "Kleiner Sammler", "<p>wenn man lang genug Sucht findet man manchmal in all dem Müll auch gutes Zeug. Man muss nur suchen...</p>", 12, 17);
			talk(56, "Auffälliger Typ", "<p>... ...<br>WAS WILLST DU HIER?, VERSCHWINDE!</p>", 4, 17);
		}
		
		//Marmoria Museum
		if($id == 13){
			sign(1, "Museum", "<p>Das Museum ist Eigentum einer Gilde. Betreten verboten!</p>", 13, 4);
			sign(1, "Labor", "<p>Das Labor ist Eigentum einer Gilde. Betreten verboten!</p>", 22, 5);
			sign(1, "Schnellstraße nach Vertania City", "<p>Dies ist eine Schnellstraße, langsame Reisene dürfen hier nicht durch.</p>", 2, 13);
			portal(12, "right", 23,21);
			if($user["citys"] >= 2){
				portal(5, "speed_left", 1,14);
			}
			talk(59, "Schöne Forscherin", "<p>Wenn ich nicht mehr weiter weiß, jetzt ich mich unter diesen Baum und denke nach. Manchmal ist Ruhe dass Beste in solchen Situationen.</p>", 12, 19);
			talk(58, "Marmoria Forscher", "<p>Ich habs bald! Bald hab ich die Formel zum Requmation!</p>", 18, 15);
			talk(58, "Forscher", "<p>Als Forscher muss man ständig Arbeiten, allerdings kann man auch immer was entdecken.</p>", 18, 8);
			talk(68, "kleiner Irrer", "<p>Hier irgendwo gibt es ein besonderes Pokemon namens Mew!</p>", 11, 11);
		}
		
		//Route 3
		if($id == 14){
			$sporn = array(6,7,8,11,16,24);
			first_fight($sporn);
			portal(11, "left", 0,20);
			portal(1002, "dun", 22,7);
			fight($sporn, 15, 16);
			fight($sporn, 16, 19);
		}
		
		//Mondberg
		if($id == 1002){
			$sporn = array(6,7,8,11,16,24);
			first_fight($sporn);
			fight($sporn, 2, 9);
			fight($sporn, 17, 7);
			fight($sporn, 15, 20);
			portal(14, "down", 4,6);
			portal(15, "up", 21,15);
		}
		
		//Route 4
		if($id == 15){
			$sporn = array(7,8,11,24);
			first_fight($sporn);
			fight($sporn, 2, 11);
			fight($sporn, 15, 3);
			fight($sporn, 12, 20);
			portal(1002, "dun", 3,9);
			portal(16, "right", 24, 20);
		}
		
		//Azuria City
		if($id == 16){
			if($user["citys"] == 2){mysql_query("update users set citys='3' where id='$_SESSION[user_id]'");}
			if($user["citys"] >= 3){
				portal(12, "speed_up", 23,12);
			}
			portal(15, "left", 0, 20);
			portal(17, "down", 6, 24);
			portal(19, "right", 24, 18);
		}
		
		//Azuria Markt-Vorplatz
		if($id == 17){
			portal(16, "up", 6, 0);
			portal(18, "right", 24, 15);
			portal(505, "indoor", 16, 13);
			sign(1, "Azuria Supermarkt", "<p>Treten ein, Treten ein, der Supermarkt von Azuria ist jetzt Offen!</p>", 14, 12);
		}
		
		//Azuria Supermarkt
		if($id == 505){
			talk(57, "Supermarkt Angestellte", "<p>Willkommen im Supermarkt von Azuria City, Hier findest du viele verschiedene Items. Auf der linken Seite befindet sich die Standart Ausrüstung und auf der Rechten ist die Sonderabteilung.</p>", 11, 20);
			talk(56, "Supermarkt Verkäufer", "<p>Du bist hier ist der Beeren-mix Abteilung, leider haben wir gerade nichts mehr da, aber die nächste Lieferung sollte bald kommen.</p>", 22, 13);
			talk(57, "Supermarkt Angestellte", "<p>Du bist nicht von Hier, Richtig? Du kommst vom Mondpass oder?<br> Dann verrate ich dir was: Hier im Zentrum von Kanto gibt es Bessere Pokebälle. Du hast sicher schon was von den Superball und dem Hyperball gehört. Hier bei uns haben sie den Pokeball komplett ersetzt.</p>", 6, 10);
			talk(56, "Supermarkt Angestellter", "<p>Hinter mir befindet sich die Deluxe Abteilung, hier darfst du nicht durch.</p>", 12, 13);
			shop(57, "VM Schwimmen Verkäufer", "<p>Mit Schwimmen kannst du Wasserstraßen benützen. Dafür brauchst du aber auch ein Wasser Pokemon. Angel dir eins doch im Vertania See.</p>",array(9), 15, 14);
			shop(57, "Supermarkt Verkäufer", "<p>Willkommen, was kann ich für dich tun?</p>",array(3,4,8), 10, 14);
			portal(17, "down", 12, 23);
		}
		
		//Azuria Felder
		if($id == 18){
			$sporn = array(7,7,7,8,8,1,);
			fight($sporn, 13, 18);
			fight($sporn, 11, 22);
			portal(17, "left", 0, 15);
		}
		
		//Azuria Arena
		if($id == 19){
			portal(16, "left", 0, 18);
			sign(1, "Gildenhaus[Unbesetzt]", "<p>Wasserorden, Gildenhaus. Besitzt Zugriff auf alle Forschungen mit Beeren oder anderen Pflanzen</p>", 13, 21);
		}
	//Die Spielfläche endet hier
	echo '</div></div></form></p>';
}

/*****************NPC arten***********************/
//talk
function talk($id, $title, $text, $x, $y) {
	$x = ($x * 16 ) - 8;
	$y = ($y * 16 ) - 16;
	echo '<img src="maps/npcs/' . $id . '.png"
	onmouseover="return overlib(' . "'";
		echo "<img src=\'maps/sprites/" . $id . ".png\'>";
		echo $text . "'" . ', CAPTION,' . "'" . $title . "'" . ');"
	onmouseout="return nd();"
	style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';

}

//Sign
function sign($id, $title, $text, $x, $y) {
	$x = $x * 16;
	$y = $y * 16;
	echo '<img src="maps/npcs/' . $id . '.png"
	onmouseover="return overlib(' . "'" . 
	$text . "'" . ', CAPTION,' . "'" . $title . "'" . ');"
	onmouseout="return nd();"
	style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';
}

//H�ndler
function shop($id, $title, $text, $items, $x, $y) {
	//weil das Sprite so eine Komische gr��e hat:
	$x = ($x * 16 ) - 8;
	$y = ($y * 16 ) - 8;
	echo '<img src="maps/npcs/' . $id . '.png" 
	onmouseover="return overlib(' . "'" . 
		"<img src=\'maps/sprites/" . $id . ".png\'>" . 
		$text . "'" . ', CAPTION,'
		. "'" . $title . "'" . ');" 
	onclick="return overlib(' . "'" .
		"<img src=\'maps/sprites/" . $id . ".png\'>"
		. '<p>klick auf ein item um es zu kaufen</p>'
		. "<form action=\'world.php\' method=\'post\' name=\'form\' id=\'form\'>"; 
	
	//Items werden aufgelistet
	foreach ($items as $itemid) {
		$item = mysql_fetch_array(mysql_query("select * from itemdex where id='$itemid'"));
		echo "<p><a href=\'" . $_SERVER['SCRIPT_NAME'] . '?kaufen=' . $item["id"] . "\'><img src=\'items/" . $item["id"] . ".png\'></a>" . $item["name"] . ' $' . $item["wert"] . ' ' . $item["text"] . '</p>';
	}
	
	echo '</form>' . "'" . ', STICKY, CAPTION,
	' . "'" . $title . "'" . ');"
	onmouseout="return nd();"
	style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';
}
?>