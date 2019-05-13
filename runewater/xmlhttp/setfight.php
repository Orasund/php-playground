<?php
	include 'dbc.php';
	page_protect();
	$choise = $_GET["choise"];
	$id = $_GET["id"];
	if(isset($_GET["user"])){$user_id = $_GET["user"];} else {$user_id = $_SESSION['user_id'];}
	
	$cards = array(
		array(4,1,1,1),
		array(3,2,1,2),
		array(2,3,1,3),
		array(1,4,1,4),
		array(3,2,2,1),
		array(4,1,2,2),
		array(1,4,2,3),
		array(2,3,2,4),
		array(2,3,3,1),
		array(1,4,3,2),
		array(4,1,3,3),
		array(3,2,3,4),
		array(1,4,4,1),
		array(2,3,4,2),
		array(3,2,4,3),
		array(4,1,4,4)
	);
	
	/*** Choise wird geändert ***/
	$query = "UPDATE fights SET a_choise='$choise' WHERE id='$id'";
	$fetch = mysql_query("SELECT * FROM fights WHERE attacker='$user_id' AND id='$id'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	$typ = 1;
	if ( $num == 0 ) { //vielleicht ist der angreifer ein verteidiger
		$query = "UPDATE fights SET d_choise='$choise' WHERE id='$id'";
		$fetch = mysql_query("SELECT * FROM fights WHERE defender='$user_id' AND id='$id'") or die(mysql_error());
		$num = mysql_num_rows($fetch);
		$typ = 0;
		if ( $num == 0 ) {echo 0;exit();}//ERROR! nichts gefunden!
	}
	mysql_query($query) or die(mysql_error());

	/*** Script Anfang ***/
	$a_cards = array(0,0,0,0,0);
	$d_cards = array(0,0,0,0,0);
	
	$fetch = mysql_query("SELECT 
		a_choise,d_choise,a_zcard,d_zcard,
		a_choise,d_choise,a_life,d_life,turn,attacker,defender, 
		a_card1,a_card2,a_card3,a_card4,a_card5,
		d_card1,d_card2,d_card3,d_card4,d_card5
			FROM fights WHERE id='$id'") or die(mysql_error());
	list(
		$a_old_choise,$d_old_choise,$a_zcard,$d_zcard,
		$a_choise,$d_choise,$a_life,$d_life,$turn,$attacker,$defender,
		$a_cards[0],$a_cards[1],$a_cards[2],$a_cards[3],$a_cards[4],
		$d_cards[0],$d_cards[1],$d_cards[2],$d_cards[3],$d_cards[4]
	) = mysql_fetch_row($fetch);
	
	
	/*** Botsystem ***/
	if($attacker == $defender){
		$fetch = mysql_query("SELECT * FROM users WHERE id='$attacker'") or die(mysql_error());
		while($output = mysql_fetch_array($fetch)){$botlevel = $output["botlevel"];}
		
		/*** Erstes System ***/
		if($botlevel < 6){
			$r = rand(1,5); //choise is 0-4
		}
		
		/*** Zweites System ***/
		if($botlevel > 5 && $botlevel < 11){
			for($i = 4; $i > 0;$i--){
				foreach($d_cards as $key => $card){
					switch($turn){
						case 0:
							if($cards[$card - 1][3] == $i){
								$r = $key +1;
								break 4;
							}
							break;
						case 1:
							if($cards[$card - 1][1] == $i){
								$r = $key +1;
								break 4;
							}
							break;
						case 2:
							if($cards[$card - 1][0] == $i){
								$r = $key +1;
								break 4;
							}
							break;
					}
				}
			}
			
		}
		
		/*** Drittes System ***/
		if($botlevel > 10){
			$gues = array(3,2,4,1);
			for($i = 0; $i <= 4;$i++){ //karten 
				foreach($d_cards as $key => $card){
					switch($turn){
						case 0:
							if($cards[$card - 1][3] == $gues[$i]){
								$r = $key +1;
								break 4;
							}
							break;
						case 1:
							if($cards[$card - 1][1] == $gues[$i]){
								$r = $key +1;
								break 4;
							}
							break;
						case 2:
							if($cards[$card - 1][0] == $gues[$i]){
								$r = $key +1;
								break 4;
							}
							break;
					}
				}
			}
			
		}
		
		//in die Datenbank schreiben.
		if($typ = 1){
			while($d_cards[$r-1] == 0){$r = rand(1,5);}
			$query = "UPDATE fights SET d_choise='$r' WHERE id='$id'";
			$d_choise = $r;
			$d_old_choise = $r;
			//echo "DEBUG: r = " . $r . "; d_choise = " . $d_cards[$r-1] . ";";
		} else {
			while($a_cards[$r-1] == 0){$r = rand(1,5);}
			$query = "UPDATE fights SET a_choise='$r' WHERE id='$id'";
			$a_choise = $r;
			$a_old_choise = $r;
			//echo "DEBUG: r = " . $r . "; a_choise = " . $a_cards[$r-1] . ";";
		}
		mysql_query($query) or die(mysql_error());
	}
	
	function damageAmulett($a_amulett,$d_amulett,$attacker,$defender){
		if($a_amulett[4] != 0){
			$a_amulett[5]--;
			if($a_amulett[5] == 0){
				mysql_query("DELETE FROM items WHERE id='$a_amulett[4]'") or die(mysql_error());
				mysql_query("UPDATE users SET equit_rune='0' WHERE id='$attacker'") or die(mysql_error());
			} else {mysql_query("UPDATE items SET life='$a_amulett[5]' WHERE id='$a_amulett[4]'") or die(mysql_error());}
		}
		if($d_amulett[4] != 0){
			$d_amulett[5]--;
			if($d_amulett[5] == 0){
				mysql_query("DELETE FROM items WHERE id='$d_amulett[4]'") or die(mysql_error());
				mysql_query("UPDATE users SET equit_rune='0' WHERE id='$defender'") or die(mysql_error());
			} else {mysql_query("UPDATE items SET life='$d_amulett[5]' WHERE id='$d_amulett[4]'") or die(mysql_error());}
		}
	}
	
	
	function damageWeapon($a_weapon,$d_weapon,$a_atklevel,$d_atklevel,$attacker,$defender){
		/*** Waffe beschädigen ***/
		$levels = array(5,10,20,40,80);
		if(rand(1,100) >= $levels[$a_atklevel]){$a_weapon[1]--;}
		if($attacker != $defender && $a_weapon[0] != 0){
			if(rand(1,100) >= $levels[$d_atklevel]){$d_weapon[1]--;}
			if($d_weapon[1] < 1){
				$query ="DELETE FROM items WHERE id='$d_weapon[0]'";
				mysql_query($query) or die(mysql_error());
				$query = "UPDATE users SET equit_weapon='0' WHERE id='$defender'";
			} else {$query = "UPDATE items SET life='$d_weapon[1]' WHERE id='$d_weapon[0]'";}
			mysql_query($query) or die(mysql_error());
		}
		
		if($d_weapon[0] != 0){
			if($a_weapon[1] < 1){
				$query ="DELETE FROM items WHERE id='$a_weapon[0]'";
				mysql_query($query) or die(mysql_error());
				$query = "UPDATE users SET equit_weapon='0' WHERE id='$attacker'";
			} else {$query = "UPDATE items SET life='$a_weapon[1]' WHERE id='$a_weapon[0]'";}
			mysql_query($query) or die(mysql_error());
		}
	}
	
	/******************************************
	 *              Kampfscript               *
	 ******************************************/
	if($a_choise != 0 && $d_choise != 0){
		$runes = array(
			array(3,-2,0,0),
			array(-2,3,0,0),
			array(0,0,30,-4),
			array(0,0,-20,6),
			array(3,0,-20,0),
			array(-2,0,30,0),
			array(0,3,0,-4),
			array(0,-2,0,6)
		);
	
		/*** Daten von Angreifer holen ***/
		$fetch = mysql_query("SELECT level,atklevel,equit_weapon,equit_rune FROM users WHERE id='$attacker'") or die(mysql_error());
		list($a_level,$a_atklevel,$a_weapon_id,$a_amulett_id) = mysql_fetch_row($fetch);
		
		$a_damage = 0;
		$a_weapon = array(0,0);
		if($a_weapon_id != 0){
			$fetch = mysql_query("SELECT * FROM items WHERE id='$a_weapon_id'") or die(mysql_error());
			while($output = mysql_fetch_array($fetch)){
				$a_damage = ($output["typ"] - 1) * ($output["level"] + 1);
				$a_weapon[0] = $output["id"];
				$a_weapon[1] = $output["life"];
			}
		}
		
		/*** Amulettsystem ***/
		$a_amulett = array(0,0,0,0,0,0);
		$a_rune = array(0,0,0);
		if($a_amulett_id != 0){
			$fetch = mysql_query("SELECT * FROM items WHERE id='$a_amulett_id'") or die(mysql_error());
			while($output = mysql_fetch_array($fetch)){
				$i = $output["typ"];
				$a_rune[0] = floor($i/64);
				$i -= $a_rune[0]*64;
				$a_rune[1] = floor($i/8);
				$i -= $a_rune[1]*8;
				$a_rune[2] = $i;
			
				$a_amulett = array(
					//St�rke, Stabilit�t, Leben, Erfahrung,id,leben
					$runes[$a_rune[0]][0] + $runes[$a_rune[1]][0] + $runes[$a_rune[2]][0],
					$runes[$a_rune[0]][1] + $runes[$a_rune[1]][1] + $runes[$a_rune[2]][1],
					$runes[$a_rune[0]][2] + $runes[$a_rune[1]][2] + $runes[$a_rune[2]][2],
					$runes[$a_rune[0]][3] + $runes[$a_rune[1]][3] + $runes[$a_rune[2]][3],
					$output["id"],
					$output["life"]
				);
			}
		}
		$a_life += $a_amulett[2];
		$a_strength = 2*$a_level*($a_damage + $a_amulett[0]);// die 0 steht f�r Amulette
		$a_stability = 2*$a_level*($a_level + $a_amulett[1]);// die 0 steht f�r Amulette
		
		/*** Daten von Verteidiger holen ***/
		$fetch = mysql_query("SELECT level,atklevel,equit_weapon,equit_rune FROM users WHERE id='$defender'") or die(mysql_error());
		list($d_level,$d_atklevel,$d_weapon_id,$d_amulett_id) = mysql_fetch_row($fetch);
		
		$d_damage = 0;
		$d_weapon = array(0,0);
		if($d_weapon_id != 0){
			$fetch = mysql_query("SELECT * FROM items WHERE id='$d_weapon_id'") or die(mysql_error());
			while($output = mysql_fetch_array($fetch)){
				$d_damage = ($output["typ"] - 1) * ($output["level"] + 1);
				$d_weapon[0] = $output["id"];
				$d_weapon[1] = $output["life"];
			}
		}
		
		/*** Amulettsystem ***/
		$d_amulett = array(0,0,0,0,0,0);
		$d_rune = array(0,0,0);
		if($d_amulett_id != 0){
			$fetch = mysql_query("SELECT * FROM items WHERE id='$d_amulett_id'") or die(mysql_error());
			while($output = mysql_fetch_array($fetch)){
				$i = $output["typ"];
				$d_rune[0] = floor($i/64);
				$i -= $d_rune[0]*64;
				$d_rune[1] = floor($i/8);
				$i -= $d_rune[1]*8;
				$d_rune[2] = $i;
			
				$d_amulett = array(
					//St�rke, Stabilit�t, Leben, Erfahrung
					$runes[$d_rune[0]][0] + $runes[$d_rune[1]][0] + $runes[$d_rune[2]][0],
					$runes[$d_rune[0]][1] + $runes[$d_rune[1]][1] + $runes[$d_rune[2]][1],
					$runes[$d_rune[0]][2] + $runes[$d_rune[1]][2] + $runes[$d_rune[2]][2],
					$runes[$d_rune[0]][3] + $runes[$d_rune[1]][3] + $runes[$d_rune[2]][3],
					$output["id"],
					$output["life"]
				);
			}
		}
		$d_life += $d_amulett[2];
		$d_strength = 2*$d_level*($d_damage + $d_amulett[0]);// die 0 steht f�r Amulette
		$d_stability = 2*$d_level*($d_level + $d_amulett[1]);// die 0 steht f�r Amulette
		
		
		/*** Spielzüge ***/
		switch($turn){
			case 0: //Zusatzkarte ausw�hlen
				$a_zcard = $a_cards[$a_choise -1] - 1;
				$d_zcard = $d_cards[$d_choise - 1] - 1;
				
				/* Zusatzkarte - Lebenscheck*/
				if($cards[$a_zcard][2] == 2){ //zweites
					$a_life = floor($a_life*2/$cards[$a_zcard][3]+1); //K�mpfer 2/n+1 Leben f�r die Person
				} else if($cards[$a_zcard][2] == 3){ //drittes
					$a_life = floor($a_life*2/$cards[$a_zcard][3]+1); //Erfinder 2/n+1 Leben f�r die Person
				} else if($cards[$a_zcard][2] == 4){ //viertes
					$d_life = floor($d_life/$cards[$a_zcard][3]+1); //Helfer 1/n+1 Leben f�r den anderen
				}
				if($cards[$d_zcard][2] == 2){ //zweites
					$d_life = floor($d_life*2/$cards[$d_zcard][3]+1); //K�mpfer 2/n+1 Leben f�r die Person
				} else if($cards[$d_zcard][2] == 3){ //drittes
					$d_life = floor($d_life*2/$cards[$d_zcard][3]+1); //Erfinder 2/n+1 Leben f�r die Person
				} else if($cards[$d_zcard][2] == 4){ //viertes
					$a_life = floor($a_life/$cards[$d_zcard][3]+1); //Helfer 1/n+1 Leben f�r den anderen
				}
				
				$a_cards[$a_choise - 1] = rand(0,15);
				$d_cards[$d_choise - 1] = rand(0,15);
				
				$turn = 1;
				break;
			default://sonst
				//Karten werden gew�hlt
				$a_card = $a_choise - 1;
				$d_card = $d_choise - 1;
				
				/* Zusatzkarte  Attacke und Balance */
				if($cards[$a_zcard][2] == 1){ //erstes
					$d_stability = floor($d_stability/$cards[$a_zcard][3]+1);
					$a_strength = floor($a_strength*2/$cards[$a_zcard][3]+1);
				} else if($cards[$a_zcard][2] == 2){ //zweites
					$d_strength = floor($d_strength/$cards[$a_zcard][3]+1);
					$a_stability = floor($a_stability*2/$cards[$a_zcard][3]+1);
				} else if($cards[$a_zcard][2] == 3){ //drittens
					$a_stability = floor($a_stability*2/$cards[$a_zcard][3]+1);
				} else if($cards[$a_zcard][2] == 4){ //viertes
					$a_strength = floor($a_strength*2/$cards[$a_zcard][3]+1);
				}
				if($cards[$d_zcard][2] == 1){ //erstes
					$a_stability = floor($a_stability/$cards[$d_zcard][3]+1);
					$d_strength = floor($d_strength*2/$cards[$d_zcard][3]+1);
				} else if($cards[$d_zcard][2] == 2){ //zweites
					$a_strength = floor($a_strength/$cards[$a_zcard][3]+1);
					$d_stability = floor($d_stability*2/$cards[$d_zcard][3]+1);
				} else if($cards[$d_zcard][2] == 3){ //drittens
					$d_stability = floor($d_stability*2/$cards[$d_zcard][3]+1);
				} else if($cards[$d_zcard][2] == 4){ //viertes
					$d_strength = floor($d_strength*2/$cards[$d_zcard][3]+1);
				}
				
				if($turn == 1){//Turn 1 und 2 �hneln sich so sehr!
					$attack = $a_strength * $cards[$a_cards[$a_card] - 1][0];
					$defence = $d_stability * $cards[$d_cards[$d_card] - 1][1];
					if($attack > $defence){$d_life -= $attack;}
					$turn = 2;
				} else {
					$attack = $d_strength * $cards[$d_cards[$d_card] - 1][0];
					$defence = $a_stability * $cards[$a_cards[$a_card] - 1][1];
					if($attack > $defence){$a_life -= $attack;}
					$turn = 1;
				}
				
				//Beide Karten entfernen
				$a_cards[$a_choise-1] = 0;
				$d_cards[$d_choise-1] = 0;
				//echo "turn ist " . $turn;
		}

		/*** Ende ***/
		if($d_life < 1 || $a_life < 1){//kein Leben mehr
			//es is vorbei
			mysql_query("DELETE FROM fights WHERE id='$id'") or die(mysql_error());
			//Exp
			$exp = 1;
			if($a_life < 1){
				$exp += $d_amulett[3];
			} else if($d_life < 1){
				$exp += $a_amulett[3];
			}
			
			damageWeapon($a_weapon,$d_weapon,$a_atklevel,$d_atklevel,$attacker,$defender); //Waffe beschädigen
			damageAmulett($a_amulett,$d_amulett,$attacker,$defender);
		} else if($a_cards[0] == 0 && $a_cards[1] == 0 && $a_cards[2] == 0 && $a_cards[3] == 0 && $a_cards[4] == 0){
			mysql_query("DELETE FROM fights WHERE id='$id'") or die(mysql_error());
			
			$exp = 1;
			$exp += $d_amulett[3];
			
			damageWeapon($a_weapon,$d_weapon,$a_atklevel,$d_atklevel,$attacker,$defender); //Waffe beschädigen
			damageAmulett($a_amulett,$d_amulett,$attacker,$defender);
		} else if($d_cards[0] == 0 && $d_cards[1] == 0 && $d_cards[2] == 0 && $d_cards[3] == 0 && $d_cards[4] == 0){
			mysql_query("DELETE FROM fights WHERE id='$id'") or die(mysql_error());
			
			$exp = 1;
			$exp += $a_amulett[3];
			
			damageWeapon($a_weapon,$d_weapon,$a_atklevel,$d_atklevel,$attacker,$defender); //Waffe beschädigen
			damageAmulett($a_amulett,$d_amulett,$attacker,$defender);
		}else{
			$query = "UPDATE fights SET 
				a_choise='0',d_choise='0',
				a_zcard='$a_zcard',d_zcard='$d_zcard',
				turn='$turn',a_life='$a_life',d_life='$d_life',
				a_card1='$a_cards[0]',a_card2='$a_cards[1]',a_card3='$a_cards[2]',a_card4='$a_cards[3]',a_card5='$a_cards[4]',
				d_card1='$d_cards[0]',d_card2='$d_cards[1]',d_card3='$d_cards[2]',d_card4='$d_cards[3]',d_card5='$d_cards[4]'
				WHERE id='$id'";
			mysql_query($query) or die(mysql_error());
		}
	}
	
	/*** Ausgabe ***/
	//Asse
	$a_ass = 0;
	foreach($a_cards as $ass){
		switch($ass){
			case 1:
			case 4:
			case 6:
			case 7:
			case 10:
			case 11:
			case 13:
				$a_ass++;
				break;
		}
	}
	$d_ass = 0;
	foreach($d_cards as $ass){
		switch($ass){
			case 1:
			case 4:
			case 6:
			case 7:
			case 10:
			case 11:
			case 13:
				$d_ass++;
				break;
		}
	}
	
	//Ausgabe formulieren
	$str_full = $id . ",";
	if($typ == 1){
		$str_full = $str_full . $a_zcard . "," . $d_zcard . "," . 
		$a_life . "," . $d_life . ",";
		if($a_old_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . ($a_cards[$a_old_choise - 1]) . ",";}
		if($d_old_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . "1,";}
		$str_full = $str_full . $turn . "," .
		$a_cards[0] . "," . 
		$a_cards[1] . "," . 
		$a_cards[2] . "," . 
		$a_cards[3] . "," . 
		$a_cards[4] . "," . 
		$a_ass . "," . $d_ass . ",0,0";
	} else {
		$str_full = $str_full . $d_zcard . "," . $a_zcard . "," . 
		$d_life . "," . $a_life . ",";
		if($d_old_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . ($d_cards[$d_old_choise - 1]) . ",";}
		if($a_old_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . "1,";}
		$str_full = $str_full . $turn . "," .
		$d_cards[0] . "," . 
		$d_cards[1] . "," . 
		$d_cards[2] . "," . 
		$d_cards[3] . "," . 
		$d_cards[4] . "," . 
		$d_ass . "," . $a_ass . ",0,0";
	}
	echo $str_full;
?>