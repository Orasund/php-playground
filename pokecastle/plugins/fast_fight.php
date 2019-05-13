<?php

if(isset($_GET["his_poke"]) && isset($_GET["level"])){
	include '../dbc.php';
	page_protect();
	kampfsystem($_GET["his_poke"],$_GET["level"]);
	header("Location: ../world.php");
}

function kampfsystem($his_pokemon_id,$his_level) {
	/******************Deine Daten werden gesammelt********************/
	$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
	$abfrage2 = mysql_query("select * from pokedex where id='$your_pokemon[dexid]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage2)){
		$your_pokemon["name"] = $ausgabe["name"];
		$your_pokemon["typ"] = $ausgabe["typ"];
		$your_pokemon["intelligence_plus"] = $ausgabe["intelligence"];
		$your_pokemon["strength_plus"] = $ausgabe["strength"];
		$your_pokemon["beauty_plus"] = $ausgabe["beauty"];
		$your_pokemon["endurance_plus"] = $ausgabe["endurance"];
		$your_pokemon["evolution"] = $ausgabe["evolution"];
	}
	
	/******************Seine Daten werden gesammelt********************/
	$his_pokemon = array();
	$his_pokemon["id"] = $his_pokemon_id;
	$his_pokemon["level"] = $his_level;
			
	// Seine Daten werden aus der Datenbank geholt
	$abfrage = mysql_query("select * from pokedex where id='$his_pokemon[id]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage)){
		$his_pokemon["dexid"] = $ausgabe["id"];
		$his_pokemon["name"] = $ausgabe["name"];
		$his_pokemon["typ"] = $ausgabe["typ"];
		$his_pokemon["intelligence_plus"] = $ausgabe["intelligence"];
		$his_pokemon["strength_plus"] = $ausgabe["strength"];
		$his_pokemon["beauty_plus"] = $ausgabe["beauty"];
		$his_pokemon["endurance_plus"] = $ausgabe["endurance"];
	}
			
	// Das Pokemon wird gesteigert, so wie einer Reifekammer Uahahahahah.
	$his_pokemon["strength"] = $his_pokemon["strength_plus"] * $his_pokemon["level"];
	$his_pokemon["intelligence"] = $his_pokemon["intelligence_plus"] * $his_pokemon["level"];
	$his_pokemon["beauty"] = $his_pokemon["beauty_plus"] * $his_pokemon["level"];
	$his_pokemon["endurance"] = $his_pokemon["endurance_plus"] * $his_pokemon["level"];
			
	// Dein Zusatz wird gefunden
	$abfrage = mysql_query("select * from typs where id='$your_pokemon[typ]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage)){
		$your_pokemon["typ_plus"] = $ausgabe[$his_pokemon["typ"]+1];
	}
			
	// sein Zusatz wird gefunden
	$abfrage = mysql_query("select * from typs where id='$his_pokemon[typ]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage)){
		$his_pokemon["typ_plus"] = $ausgabe[$your_pokemon["typ"]+1];
	}
			
	/******************Der Kampf und die Auswertung********************/
	// Deine Punkte
	echo "<p>" . $your_pokemon["level"] . " mal " . $your_pokemon["strength"] . " mal " . $your_pokemon["love"] . " mal " . $your_pokemon["typ_plus"] . " durch zwei</p>";
	$your_points = ($your_pokemon["level"] * $your_pokemon["strength"] * ($your_pokemon["love"] / 2) * $your_pokemon["typ_plus"]);
	
	//Seine Punkte
	$his_points = ($his_pokemon["level"] * $his_pokemon["strength"] * ($his_pokemon["level"] * 1.5) * $his_pokemon["typ_plus"]);
	
	echo "<p>Das gegnerische " . $his_pokemon["name"] . " hat " . $his_points . " Angriffspunkte.</p>";
	echo "<p>Dein " . $your_pokemon["name"] . " hat " . $your_points . " Angriffspunkte.</p>";
	
	//Pokeball eingesetzt?
	if (isset($_GET["pokeball"])){
		echo "<p>Ein Pokeball wird eingesetzt</p>";
		$your = mysql_fetch_array(mysql_query("select energie from users where id='$_SESSION[user_id]'"));
		if($_GET["pokeball"] == 5 && $your["energie"] >= 50){
			$your["energie"] -= 50;
			mysql_query("update users set energie='$your[energie]' where id='$_SESSION[user_id]'") or die(mysql_error());
		} else {
			$abfrage = mysql_query("select * from items where dexid='$_GET[pokeball]' AND user='$_SESSION[user_id]'");
			while($ausgabe = mysql_fetch_array($abfrage)){
				if($ausgabe["number"] > 1){
					$item["number"] = $ausgabe["number"] - 1;
					mysql_query("update items set number='$item[number]' where id='$ausgabe[id]'") or die(mysql_error());
				} else {
					mysql_query("DELETE FROM items WHERE id='$ausgabe[id]'") or die(mysql_error());
				}
			}
		}
	}
	
	//Ist er st�rker als du?
	if ($your_points > $his_points){
		echo "<p>Dein " . $your_pokemon["name"] . " hat das gegnerische " . $his_pokemon["name"] . " besiegt.</p>";
		echo "<p>Dein " . $your_pokemon["name"] . " hat " . (($his_pokemon["level"] - $your_pokemon["level"]) + 4) . " Erfahrungspunkte von " . $your_pokemon["exp"] . " erhalten</p>";
		$your_pokemon["exp"] += ($his_pokemon["level"] - $your_pokemon["level"]) + 4;
		$erf_exp = exp_raten($your_pokemon["intelligence"], $your_pokemon["level"]);
		if($your_pokemon["exp"] > $erf_exp){
			//echo"<p>Dein " . $your_pokemon[name] . " ist einen Level Aufgestiegen!</p>";
			$your_pokemon["intelligence"] += $your_pokemon["intelligence_plus"];
			$your_pokemon["strength"] += $your_pokemon["strength_plus"];
			$your_pokemon["beauty"] += $your_pokemon["beauty_plus"];
			$your_pokemon["endurance"] += $your_pokemon["endurance_plus"];
			//Hat das Pokemon sich verwandelt? erste Verwandlung level 15 zweite level 30
			if ($your_pokemon["level"] == 15 && $your_pokemon["evolution"] != 000){
				$your_pokemon["dexid"] = $your_pokemon["evolution"];
			}
			if ($your_pokemon["level"] == 30 && $your_pokemon["evolution"] != 000){
				$your_pokemon["dexid"] = $your_pokemon["evolution"];
			}
			mysql_query("update pokemons set dexid='$your_pokemon[dexid]', intelligence='$your_pokemon[intelligence]', strength='$your_pokemon[strength]', beauty='$your_pokemon[beauty]', endurance='$your_pokemon[endurance]' where id='$your_pokemon[id]'") or die(mysql_error());
			$your_pokemon["exp"] -= $erf_exp;
			$your_pokemon["level"] += 1;
		}
		$level_possible = floor((((pow($your_pokemon["level"] + 3, 3) *3) / $your_pokemon["level"]) / $your_pokemon["strength"])*2);
		echo "<p>Level_possible ist " . $level_possible . "</p>";
		if($your_pokemon["love"] <= $level_possible){
			$your_pokemon["love"] += (5 - ($your_pokemon["level"] - $his_pokemon["level"]));
			echo "<p>" . $your_pokemon["name"] . "'s Liebe zu dir ist um " . (5 - ($your_pokemon["level"] - $his_pokemon["level"])) . " gestiegen</p>";
		}
		
		//Pokemon Fangen
		if(isset($_GET["pokeball"])){
			echo "<p>Der Pokeball hat die Id " . $_GET["pokeball"];
			$pokeball =  mysql_fetch_array(mysql_query("select * from itemdex where id='$_GET[pokeball]'")) or die(mysql_error());
			echo " und einen Fangwert von " . $pokeball["zahl"];
			$new_zahl = $pokeball["zahl"] * 3;
			echo ", also ein Maxlevel von " . $new_zahl . "</p>";
			$rand_points = mt_rand($pokeball["zahl"], $new_zahl);
			echo "<p>Der Ball erziehlt " . $rand_points . " Punkte und braucht aber " . $his_pokemon["level"] . "</p>";
			if ($rand_points >= $his_pokemon["level"]){
				mysql_query("insert into pokemons
				(userid,dexid, level, intelligence, strength, beauty, endurance)
				VALUES ('$_SESSION[user_id]','$his_pokemon[dexid]','$his_pokemon[level]','$his_pokemon[intelligence]','$his_pokemon[strength]','$his_pokemon[beauty]','$his_pokemon[endurance]')") or die(mysql_error());
			}
		}
	} else{
		//echo "<P>Das gegnerische " . $his_pokemon[name] . " hat dein " . $your_pokemon[name] . " besiegt.</p>";
		$your_pokemon["love"] -= (($his_pokemon["level"] - $your_pokemon["level"]) + 1) * 4;
	}
	mysql_query("update pokemons set exp='$your_pokemon[exp]', level='$your_pokemon[level]',love='$your_pokemon[love]' where id='$your_pokemon[id]'");
}

function fishing($sporns, $x, $y){
	$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
	$array = array_rand($sporns);
	$his_pokemon_id = $sporns["$array"];
	$his_pokemon = array();
	$his_pokemon["level"] = rand(($your_pokemon["level"]-3),($your_pokemon["level"]+3));
	$abfrage = mysql_query("select * from poke_rassen where id='$his_pokemon_id'") or die(mysql_error());
	while($ausgabe = mysql_fetch_array($abfrage)){
		// Das Aussehen seines Pokemon h�ngt vom Level ab.
		if ($his_pokemon["level"] > 29){
			$his_pokemon["id"] = $ausgabe["poke3"];
		} else {
			if ($his_pokemon["level"] > 14){
				$his_pokemon["id"] = $ausgabe["poke2"];
			} else {
				$his_pokemon["id"] = $ausgabe["poke1"];
			}
		}
	}
	
	// Seine Daten werden aus der Datenbank geholt
	$abfrage = mysql_query("select * from pokedex where id='$his_pokemon[id]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage)){
		$his_pokemon["name"] = $ausgabe["name"];
	}
	
	//Kann das Pokemon kämpfen?
	if ($your_pokemon["level"] > 3 && $your_pokemon["love"] > 7) {
		/****** Anzeigen ******/
		$x = ($x * 16 );
		$y = ($y * 16 );
		
		echo '<img src="maps/npcs/11.png" 
		onmouseover="return overlib(' . "'" . "Klick auf das Gras um zu Trainnieren" . "'" . ', CAPTION,' . "'" . "Trainnieren" . "'" . ');" 
		onclick="return overlib(' . "'" . "<a href=\'plugins/fast_fight.php?his_poke=" . $his_pokemon["id"] . "&level=" . $his_pokemon["level"] . "\'><img src=\'maps/dex/" . $his_pokemon["id"] . ".png\'></a><p>"; 
	
		/*//Items werden aufgelistet
		foreach ($items as $itemid) {
			$item = mysql_fetch_array(mysql_query("select * from itemdex where id='$itemid'"));
			echo "<p><a href=\'" . $_SERVER['SCRIPT_NAME'] . '?kaufen=' . $item["id"] . "\'><img src=\'items/" . $item["id"] . ".png\'></a>" . $item["name"] . ' $' . $item["wert"] . ' ' . $item["text"] . '</p>';
		}*/
		
		if (mysql_num_rows( mysql_query( "SELECT * FROM pokemons WHERE userid='$_SESSION[user_id]'") ) >= 4){
		} else {
			//Items werden aufgelistet
			$abfrage = mysql_query( "SELECT * FROM items WHERE user='$_SESSION[user_id]'" );
			while($item=mysql_fetch_array($abfrage)){
				$abfrage2 = mysql_query("select * from itemdex where id='$item[dexid]' and typ='2'");
				while($item = mysql_fetch_array($abfrage2)){
					echo "<a href=\'plugins/fast_fight.php?his_poke=" . $his_pokemon["id"] . "&level=" . $his_pokemon["level"] . '&pokeball=' . $item["id"] . "\'><img src=\'items/" . $item["id"] . ".png\'></a>" . $item["name"] . "<br>";
				}
			}
		}
		
		echo "</p>" . "'" . ', STICKY, CAPTION,
		' . "'" . $his_pokemon["name"] . ' Level ' . $his_pokemon["level"] . "'" . ');"
		onmouseout="return nd();"
		style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';
	}
}

function fight($sporns, $x, $y){
	$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
	$array = array_rand($sporns);
	$his_pokemon_id = $sporns["$array"];
	$his_pokemon = array();
	$his_pokemon["level"] = rand(($your_pokemon["level"]-3),($your_pokemon["level"]+3));
	$abfrage = mysql_query("select * from poke_rassen where id='$his_pokemon_id'") or die(mysql_error());
	while($ausgabe = mysql_fetch_array($abfrage)){
		// Das Aussehen seines Pokemon h�ngt vom Level ab.
		if ($his_pokemon["level"] > 29){
			$his_pokemon["id"] = $ausgabe["poke3"];
		} else {
			if ($his_pokemon["level"] > 14){
				$his_pokemon["id"] = $ausgabe["poke2"];
			} else {
				$his_pokemon["id"] = $ausgabe["poke1"];
			}
		}
	}
	
	// Seine Daten werden aus der Datenbank geholt
	$abfrage = mysql_query("select * from pokedex where id='$his_pokemon[id]'") or die(mysql_error());
	while($ausgabe=mysql_fetch_array($abfrage)){
		$his_pokemon["name"] = $ausgabe["name"];
	}
	
	//Kann das Pokemon kämpfen?
	if ($your_pokemon["level"] > 3 && $your_pokemon["love"] > 7) {
		/****** Anzeigen ******/
		$x = ($x * 16 );
		$y = ($y * 16 );
		
		echo '<img src="maps/npcs/10.png" 
		onmouseover="return overlib(' . "'" . "Klick auf das Gras um zu Trainnieren" . "'" . ', CAPTION,' . "'" . "Trainnieren" . "'" . ');" 
		onclick="return overlib(' . "'" . "<a href=\'plugins/fast_fight.php?his_poke=" . $his_pokemon["id"] . "&level=" . $his_pokemon["level"] . "\'><img src=\'maps/dex/" . $his_pokemon["id"] . ".png\'></a><p>"; 
	
		/*//Items werden aufgelistet
		foreach ($items as $itemid) {
			$item = mysql_fetch_array(mysql_query("select * from itemdex where id='$itemid'"));
			echo "<p><a href=\'" . $_SERVER['SCRIPT_NAME'] . '?kaufen=' . $item["id"] . "\'><img src=\'items/" . $item["id"] . ".png\'></a>" . $item["name"] . ' $' . $item["wert"] . ' ' . $item["text"] . '</p>';
		}*/
		
		if (mysql_num_rows( mysql_query( "SELECT * FROM pokemons WHERE userid='$_SESSION[user_id]'") ) >= 4){
		} else {
			//Items werden aufgelistet
			$abfrage = mysql_query( "SELECT * FROM items WHERE user='$_SESSION[user_id]'" );
			while($item=mysql_fetch_array($abfrage)){
				$abfrage2 = mysql_query("select * from itemdex where id='$item[dexid]' and typ='2'");
				while($item = mysql_fetch_array($abfrage2)){
					echo "<a href=\'plugins/fast_fight.php?his_poke=" . $his_pokemon["id"] . "&level=" . $his_pokemon["level"] . '&pokeball=' . $item["id"] . "\'><img src=\'items/" . $item["id"] . ".png\'></a>" . $item["name"] . "<br>";
				}
			}
		}
		
		echo "</p>" . "'" . ', STICKY, CAPTION,
		' . "'" . $his_pokemon["name"] . ' Level ' . $his_pokemon["level"] . "'" . ');"
		onmouseout="return nd();"
		style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';
	}
}

function first_fight($sporn){
	$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
	if ($your_pokemon["level"] > 3 && $your_pokemon["love"] > 7) {
		$array = array_rand($sporn);
		$his_pokemon["level"] = rand(($your_pokemon["level"]-3),($your_pokemon["level"]+3));
		$abfrage = mysql_query("select * from poke_rassen where id='$sporn[$array]'") or die(mysql_error());
		while($ausgabe = mysql_fetch_array($abfrage)){
			// Das Aussehen seines Pokemon h�ngt vom Level ab.
			if ($his_pokemon["level"] > 29){
				$his_pokemon["id"] = $ausgabe["poke3"];
			} else {
				if ($his_pokemon["level"] > 14){
					$his_pokemon["id"] = $ausgabe["poke2"];
				} else {
					$his_pokemon["id"] = $ausgabe["poke1"];
				}
			}
		}
		kampfsystem($his_pokemon["id"],$his_pokemon["level"]);
	}
}
?>