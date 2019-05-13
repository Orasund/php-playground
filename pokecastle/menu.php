<?php
	if(isset($_SESSION["user_id"])){
		if(isset($_POST["add_guild"]) && $_POST["add_guild"] != 0){
			mysql_query("update users set guild='$_POST[add_guild]' where id='$_SESSION[user_id]'") or die(mysql_error());
		} elseif (isset($_POST["name"]) && mysql_num_rows( mysql_query( "SELECT * FROM guild WHERE name='$_POST[name]'" ) ) == 0) {
			mysql_query("insert into guild (name, leader) VALUES ('$_POST[name]','$_SESSION[user_id]')") or die(mysql_error());
			$guild_id = mysql_fetch_array(mysql_query("select id from guild where name='$_POST[name]'"));
			mysql_query("update users set guild='$guild_id[id]' where id='$_SESSION[user_id]'") or die(mysql_error());
		}
		
		if(isset($_GET["leave_guild"])){
			if($_GET["leave_guild"] == 1){
				mysql_query("update users set guild='0' where id='$_SESSION[user_id]'") or die(mysql_error());
			}
			if($_GET["leave_guild"] == 2){
				mysql_query("delete from guild where leader='$_SESSION[user_id]'") or die(mysql_error());
				mysql_query("update users set guild='0' where id='$_SESSION[user_id]'") or die(mysql_error());
			}
		}
		
		//Soll ein Pokemon gelöscht werden
		if(isset($_GET["delete_pokemon"])){
			mysql_query("DELETE FROM pokemons WHERE id='$_GET[delete_pokemon]'") or die(mysql_error());
		}
		
		$abfrage = mysql_query("select * from pokemons where userid='$_SESSION[user_id]'") or die(mysql_error());
		while($poke_id=mysql_fetch_array($abfrage)){
			//Schauen ob ein Pokemon gestreichelt worden ist
			if(isset($_GET["streicheln"]) && $_GET["streicheln"] == $poke_id["id"]){
				//Max. Streichelbar ist vom Level abhängig:
				$level_possible = floor((((pow($poke_id["level"] + 3, 3) *3) / $poke_id["level"]) / $poke_id["strength"])*2);
				
				//Ist die Liebe unter 28, kann man alle 480 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*7){
					$loved_plus = 480;
					$love_plus = 1;
				}
				//Ist die Liebe unter 21, kann man alle 240 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*6){
					$loved_plus = 240;
					$love_plus = 2;
				}
				//Ist die Liebe unter 16, kann man alle 120 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*5){
					$loved_plus = 120;
					$love_plus = 4;
				}
				//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
				if ($poke_id["love"] <= $level_possible){
					$loved_plus = 60;
					$love_plus = 8;
				}
				//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
				if ($poke_id["love"] <= ($level_possible/4)*3){
					$loved_plus = 60;
					$love_plus = 4;
				}
				//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
				if ($poke_id["love"] <= ($level_possible/4)*2){
					$loved_plus = 60;
					$love_plus = 2;
				}
				//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
				if ($poke_id["love"] <= ($level_possible/4)){
					$loved_plus = 60;
					$love_plus = 1;
				}
				
				if ($poke_id["love"] < $level_possible){
					if (($poke_id["loved"]) < date('Y-m-d H:i:s',time()-$loved_plus)){
						$love_new = $poke_id["love"] + $love_plus;
						$loved_new = date('Y-m-d H:i:s');
						mysql_query("update pokemons set loved='$loved_new', love='$love_new' where id='$poke_id[id]'") or die(mysql_error());
					}
				}
			}
			if(isset($_GET["sort"]) && $_GET["sort"] == $poke_id["id"]){
				$id_new = mysql_fetch_array(mysql_query("select * from pokemons where sort='1'"));
				mysql_query("update pokemons set sort='0' where id='$id_new[id]'");
				mysql_query("update pokemons set sort='1' where id='$_GET[sort]'");
			}
		}
	}
	
	//Soll ein Item benützt werden?
	if(isset($_POST["itemid"])){
		$itemid = $_POST["itemid"];
		$abfrage = mysql_query("select * from itemdex where id='$itemid'") or die(mysql_error());
		while($item = mysql_fetch_array($abfrage)){
			//Die verschiedenen Typen
			
			//Heiltränke/Liebe
			if($item["typ"] == 1){
				if($_POST["pokemon"]){
					$your_Pokemonid = $_POST["pokemon"];
					$your_Pokemon = mysql_fetch_array(mysql_query("select * from pokemons where id='$your_Pokemonid'")) or die(mysql_error());
					
					//Wie weit man geheilt werden kann.
					if($your_Pokemon["love"] <= $item["zahl"] * 15){
						$your_Pokemon["love"] += $item["zahl"];
						mysql_query("update pokemons set love='$your_Pokemon[love]' where id='$your_Pokemon[id]'") or die(mysql_error());
						$abfrage = mysql_query("select * from items where dexid='$item[id]' AND user='$_SESSION[user_id]'");
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
			}
			
			//Fluchtseil
			if($item["typ"] == 3){
				mysql_query("update users set map='$user[save]' where id='$_SESSION[user_id]'") or die(mysql_error());
			}
			
			//TMs
			if($item["typ"] == 4){
				if($_POST["pokemon"]){
					$your_Pokemon = mysql_fetch_array(mysql_query("select * from pokemons where id='$_POST[pokemon]'")) or die(mysql_error());
					
					//Raserei
					if($item["zahl"] == 1){
					
						//Schnelligkeit 50
						if($your_Pokemon["beauty"] >= 50){						
							mysql_query("update pokemons set abilities='$item[zahl]' where id='$your_Pokemon[id]'") or die(mysql_error());
						}
					}
				}
			}
		}
	}
	
	function cgear(){
		if (isset($_SESSION['user_id'])) {
			$your = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
			
			echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post" name="iform" id="iform">
				<p><div class="title" onmouseover="return overlib(' . "'";
											echo'<p>Mit dem C-Gear kannst du mit anderen Jederzeit in Kontakt bleiben und über Neuigkeiten Erfahren.</p>';
										echo"'" . ');" ';
										echo'onmouseout="return nd();"><table><tr><td width="64" height="32" align="center" valign="middle"><img src="maps/icons/laptop.png"></td><td><h1>C-Gear</h1></td></tr></table></div>
					<div class="myaccount">
						<p>
							<table>
								<tr width="192">
									<td width="64" height="32">
										<a href="world.php"><img src="maps/icons/tree.png"><br>die Welt</a>
									</td>
									<td width="64" height="32" align="center">';
										if($your["energie"] >= 100){$battery = "battery_charge";}
										if($your["energie"] <= 75){$battery = "battery_full";}
										if($your["energie"] <= 50){$battery = "battery_half";}
										if($your["energie"] <= 25){$battery = "battery_low";}
										if($your["energie"] <= 0){$battery = "battery";}
								echo'<img src="maps/icons/' . $battery . '.png">' . $your["energie"] . '<br>Energie
								</td>
									<td width="64" height="32" align="center">
										<img src="maps/icons/money.png">' . $your["money"] . '<br>Geld
									</td>
								</tr>
							</table>
							<table>
								<tr>
									<td width="32" height="32">
										<a href="logout.php"><img src="maps/icons/door_out.png"><br>
										Logout</a>
									</td>
									<td width="96" height="32" align="center">
										<img src="maps/sprites/' . $your["profil"] . '.png"><br>
										' . $your["user_name"] . '
									</td>
									<td width="32" height="32" align="center">
										<a href="showusers.php"><img src="maps/icons/group.png"><br>
										Andere Spieler</a>
									</td>
								</tr>
							</table>
							<table><tr>';
								//Pokemon werden angezeigt
								$abfrage = mysql_query("select * from pokemons where userid='$_SESSION[user_id]'") or die(mysql_error());
								while($poke = mysql_fetch_array($abfrage)){
									//Max. Streichelbar ist vom Level abhängig:
									$level_possible = floor((((pow($poke["level"] + 3, 3) *3) / $poke["level"]) / $poke["strength"])*2);

									//Ist die Liebe unter 28, kann man alle 480 sec streicheln
									if ($poke["love"] < ($level_possible/4)*7){
										$loved_plus = 480;
									}
									//Ist die Liebe unter 21, kann man alle 240 sec streicheln
									if ($poke["love"] < ($level_possible/4)*6){
										$loved_plus = 240;
									}
									//Ist die Liebe unter 16, kann man alle 120 sec streicheln
									if ($poke["love"] < ($level_possible/4)*5){
										$loved_plus = 120;
									}
									//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
									if ($poke["love"] <= $level_possible){
										$loved_plus = 60;
									}
									
									//Infomationen anzeigen	
									echo '<td width="32" height="32" align="center" valign="bottom">';
									if ($poke["love"] < $level_possible){
										if (($poke["loved"]) < date('Y-m-d H:i:s',time() - $loved_plus)){
										
											// Eine Anklickbare Grafik wird erstellt
											echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?streicheln=' . $poke["id"] . '"><img src="maps/oworld/' . $poke["dexid"] . '.png"';
											echo 'onmouseover="return overlib(' . "'";
													echo 'Lv. ' . $poke["level"] . '<br>';
													$erf_exp = exp_raten($poke["intelligence"], $poke["level"]);
													echo 'Exp ' . $poke["exp"] . '/' . $erf_exp . '<br>';
													echo 'Liebe ' . $poke["love"];
												echo "'" . ',CAPTION,' . "'Infomationen'" . ');" ';
												echo'onmouseout="return nd();"></a>';
									echo '</td>';
										} else {
											echo '<img src="maps/oworld/' . $poke["dexid"] . '.gif" ';
											echo 'onmouseover="return overlib(' . "'";
													echo 'Lv. ' . $poke["level"] . '<br>';
													$erf_exp = exp_raten($poke["intelligence"], $poke["level"]);
													echo 'Exp ' . $poke["exp"] . '/' . $erf_exp . '<br>';
													echo 'Liebe ' . $poke["love"];
												echo "'" . ',CAPTION,' . "'Statuswerte'" . ');" ';
												echo'onmouseout="return nd();">';
									echo '</td>';
										}
									} else {
										echo '<img src="maps/oworld/' . $poke["dexid"] . '.gif" ';
										echo 'onmouseover="return overlib(' . "'";
													echo 'Lv. ' . $poke["level"] . '<br>';
													$erf_exp = exp_raten($poke["intelligence"], $poke["level"]);
													echo 'Exp ' . $poke["exp"] . '/' . $erf_exp . '<br>';
													echo 'Liebe ' . $poke["love"];
												echo "'" . ',CAPTION,' . "'Statuswerte'" . ');" ';
												echo'onmouseout="return nd();">';
									echo '</td>';
									}
								}
							echo'</tr></table>
						</p>
					</div></p>';
			
			// Forum Themen
			echo'<p><div class="title" onmouseover="return overlib(' . "'";
											echo'<p>Das Forum bietet dir viele Möglichkeiten Pokecastle und ihre Mitspieler besser kennenzulernen.</p>';
										echo"'" . ');" ';
										echo'onmouseout="return nd();"><table><tr><td width="64" height="32" align="center" valign="middle"><img src="maps/icons/newspaper.png"></td><td><h1>Forum</h1></td></tr></table></div>
					<div class="forms">
						<table>
							<tr>
								<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/update.png"></td>
								<td><a href="index.php?forum_typ=1" onmouseover="return overlib(' . "'" . 'hier findest du alle Erneuerungen im Spiel oder wichtige Nachrichten' . "'" . ');" onmouseout="return nd();">Neuigkeiten</a></td>
							</tr>
							<tr>
								<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/administrator.png"></td>
								<td><a href="index.php?forum_typ=2" onmouseover="return overlib(' . "'" . 'hier können sich Gilden presentieren um Mitglieder zu bekommen.' . "'" . ');" onmouseout="return nd();">Gilden</a></td>
							</tr>
							
							<tr>
								<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/medal_gold_1.png"></td>
								<td><a href="index.php?forum_typ=3" onmouseover="return overlib(' . "'" . 'Hier kann man an Wettbewerbe und Minispiele teilnehmen.' . "'" . ');" onmouseout="return nd();">Wettbewerbe</a></td>
							</tr>
							<tr>
								<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/help.png"></td>
								<td><a href="index.php?forum_typ=4" onmouseover="return overlib(' . "'" . 'Hier sind Fragen und Antworten, sowie Anleitungen' . "'" . ');" onmouseout="return nd();">Hilfe und Anleitungen</a></td>
							</tr>
							<tr>
								<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/cup.png"></td>
								<td><a href="index.php?forum_typ=5" onmouseover="return overlib(' . "'" . 'Hier kann alles rein, was sonst nicht rein passt.' . "'" . ');" onmouseout="return nd();">Kaffestube</a></td>
							</tr>
						</table>
					</div>
				</p>';
		
			/*/ Pens
			echo'<p>
					<div class="forms">
						<p><strong>Beobachtete Diskusionen</strong></p>
					</div>
				</p>';*/
				
			// Gilde
			echo'<p><div class="title" onmouseover="return overlib(' . "'";
											echo'<p>Mit Gilden kann man mehr Geld bekommen. Wähle aus der Liste eine Gilde aus, um dieser Beizutreten oder gründe eine neue Gilde.</p>';
										echo"'" . ');" ';
										echo'onmouseout="return nd();"><table><tr><td width="64" height="32" align="center" valign="middle"><img src="maps/icons/reseller_programm.png"></td><td><h1>Gilde</h1></td></tr></table></div>
					<div class="forms">';
					if ($your["guild"] == 0){
						echo'<form action="index.php" method="post">';
						echo'<p><select name="add_guild">';
						echo'<option value="0">Gruppe Beitreten</option>';
							$abfrage = mysql_query("select * from guild order by id");
							while($ausgabe = mysql_fetch_array($abfrage)){
								echo'<option value="' . $ausgabe["id"] . '">' . $ausgabe["name"] . '</option>';
							}
						echo'</select></p>';
						echo'<p>Oder</p>';
						echo'<p><input name="name" type="text" class="required" id="txtbox" size="20"></p>';
						echo'<p><input name="new_guild" type="submit" id="new_guild" value="Gilde beitreten"></p>';
						echo'</form>';
					} else {
						$guild = mysql_fetch_array(mysql_query("select * from guild where id='$your[guild]'"));
						
						$anzahl = mysql_num_rows( mysql_query( "SELECT id FROM users WHERE guild='$guild[id]'") );
						echo'<table>
								<tr width="192">
									<td width="96" height="32" align="center" valign="bottom">
										<img src="maps/icons/flag_2.png"><br>' . $guild["name"] . '
									</td>
									<td width="64" height="32">
										<img src="maps/icons/user_suit.png">' . $anzahl . '
									</td>
									<td width="32" height="32">';
										if($guild["leader"] == $_SESSION["user_id"]){
											echo'<a href="index.php?leave_guild=2"><img src="maps/icons/bin_empty.png">löschen</a>';
										} else {
											echo'<a href="index.php?leave_guild=1"><img src="maps/icons/door_out">verlassen</a>';
										}
								echo'</td>
								</tr>
							</table>';
						
						echo '<table>
								<tr>
									<td width="32" height="16" align="center" valign="bottom"><img src="maps/icons/dice.png"></td>
									<td><a href="games.php" onmouseover="return overlib(' . "'" . 'Hier kannst du für die Gilde Geld verdienen.' . "'" . ');" onmouseout="return nd();">Minispiele</a></td>
								</tr>
							</table>';
					}

				echo'</div>
				</p>';
		
		} else {
			echo'
			<div class="myaccount">
			<p><strong>Login</strong></p>
			<form action="login.php" method="post" name="logForm" id="logForm" >
			<p>Username<br>
			<p><input name="usr_email" type="text" class="required" id="txtbox" size="20"></p>
			<p>Passwort<br>
			<p><input name="pwd" type="password" class="required password" id="txtbox" size="20"></p>
			<p><input name="doLogin" type="submit" id="doLogin3" value="Login"><input name="remember" type="checkbox" id="remember" value="1"> Passwort speichern</p>
			<p><a href="register.php">Registrieren</a><font color="#FF6600">|</font> <a href="forgot.php">Passwort vergessen?</a> <font color="#FF6600"></font></p>               
			</form>	
			</div>
			<p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.3</a></span></p>
			';
		}
	}
	
	function menu(){
		$your = mysql_fetch_array(mysql_query("select profil, money, user_name, energie from users where id='$_SESSION[user_id]'"));
	
	//Die Daten des Spielers werden gezeigt
	echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post" name="iform" id="iform">
	<p><div class="title" onmouseover="return overlib(' . "'";
								echo'<p>In der Welt kannst du deinen eigenen Status verbessern. Um zu wechseln, drück einfach auf das C-Gear Symbol.</p>';
							echo"'" . ');" ';
							echo'onmouseout="return nd();"><table><tr><td width="64" height="32" align="center" valign="middle"><img src="maps/icons/tree.png"></td><td><h1>In der Welt</h1></td></tr></table></div><div class="myaccount">
		<p>
			<table>
				<tr width="192">
					<td width="64" height="32">
						<a href="index.php"><img src="maps/icons/laptop.png"><br>C-Gear</a>
					</td>
					<td width="64" height="32">
						<img src="maps/icons/battery.png">' . $your["energie"] . '
					</td>
					<td width="64" height="32">
						<img src="maps/icons/money.png">' . $your["money"] . 
					'</td>
				</tr>
			</table>
		</p>
	</div></p>';
	
	//Die Pokemon werden gezeigt
	$title_poke = mysql_fetch_array(mysql_query("select * from pokedex order by rand() limit 1"));
	echo '<p><div class="title" onmouseover="return overlib(' . "'";
								echo'<p>Wenn das Pokemon sich nicht mehr bewegt, will es gestreichelt werden. Klick dafür einfach auf das Bild.</p>';
							echo"'" . ');" ';
							echo'onmouseout="return nd();"><table><tr><td width="64" height="32" align="center" valign="middle"><img src="maps/oworld/' . $title_poke["id"] . '.png"></td><td><h1>Pokemon</h1></td></tr></table></div><div class="forms" height="192" width="176">';	
		$abfrage = mysql_query("select * from pokemons where userid='$_SESSION[user_id]' order by sort DESC") or die(mysql_error());
		while($poke_id=mysql_fetch_array($abfrage)){
			$abfrage2 =mysql_query("select * from pokedex where id='$poke_id[dexid]'") or die(mysql_error());
			while($poke=mysql_fetch_array($abfrage2)){
				//Max. Streichelbar ist vom Level abhängig:
				$level_possible = floor((((pow($poke_id["level"] + 3, 3) *3) / $poke_id["level"]) / $poke_id["strength"])*2);

				//Ist die Liebe unter 28, kann man alle 480 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*7){
					$loved_plus = 480;
				}
				//Ist die Liebe unter 21, kann man alle 240 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*6){
					$loved_plus = 240;
				}
				//Ist die Liebe unter 16, kann man alle 120 sec streicheln
				if ($poke_id["love"] < ($level_possible/4)*5){
					$loved_plus = 120;
				}
				//Ist die Liebe unter $poke_id, kann man alle 60 sec streicheln
				if ($poke_id["love"] <= $level_possible){
					$loved_plus = 60;
				}
				
				/*Typen:
				Normal: 808080
				Feuer: de3232
				Wasser: 4144bd
				Elektro: b1aa38
				Pflanze: 256f32
				Flug: 7395e3
				Käfer: 0a4d1d
				Gift: 7eff7e
				Gestein: 746a58
				Boden: c39a49
				Kampf: 87451d
				Eis: 33c5d2
				Psycho: 9e40c1
				Geist: 5f3a6d
				Drachen: a22457
				Stahl: 747474
				Unlicht: 292929*/
				
				if ($poke["typ"] == 1){$typ_color = "808080";}
				if ($poke["typ"] == 2){$typ_color = "de3232";}
				if ($poke["typ"] == 3){$typ_color = "4144bd";}
				if ($poke["typ"] == 4){$typ_color = "b1aa38";}
				if ($poke["typ"] == 5){$typ_color = "256f32";}
				if ($poke["typ"] == 6){$typ_color = "7395e3";}
				if ($poke["typ"] == 7){$typ_color = "0a4d1d";}
				if ($poke["typ"] == 8){$typ_color = "7eff7e";}
				if ($poke["typ"] == 9){$typ_color = "746a58";}
				if ($poke["typ"] == 10){$typ_color = "c39a49";}
				if ($poke["typ"] == 11){$typ_color = "87451d";}
				if ($poke["typ"] == 12){$typ_color = "33c5d2";}
				if ($poke["typ"] == 13){$typ_color = "9e40c1";}
				if ($poke["typ"] == 14){$typ_color = "5f3a6d";}
				if ($poke["typ"] == 15){$typ_color = "a22457";}
				if ($poke["typ"] == 16){$typ_color = "747474";}
				if ($poke["typ"] == 17){$typ_color = "292929";}
				
				//Infomationen anzeigen	
				if ($poke_id["sort"] == 1) {
				
					if($poke_id["abilities"] == 0){$abilitie = "Keine";}
					if($poke_id["abilities"] == 1){$abilitie = "Raserei";}
					
					echo '<table><tr>';
					echo '<td width="16" height="32" align="center" valign="middle">
							<input type="radio" name="pokemon" value="' . $poke_id["id"] . '">
						</td>';
					echo '<td width="96" height="96" align="center" valign="middle">';
					if ($poke_id["love"] < $level_possible){
						if (($poke_id["loved"]) < date('Y-m-d H:i:s',time()-$loved_plus)){
							// Eine Anklickbare Grafik wird erstellt
							echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?streicheln=' . $poke_id["id"] . '">';
							echo'<img src="maps/dex/' . $poke["id"] . '.png" ';
						} else {
							echo '<a><img src="maps/dex/' . $poke["id"] . '.gif" ';
						}
					} else {
						echo '<a><img  src="maps/dex/' . $poke["id"] . '.gif" ';
					}
					
					//Die Statuswerte
							echo'onmouseover="return overlib(' . "'";
								echo"<img src=\'maps/icons/co2.png\'>" . $poke_id["intelligence"] . '[' . $poke["intelligence"] . '] ';
								echo"<img src=\'maps/icons/shuriken.png\'>" . $poke_id["strength"] . '[' . $poke["strength"] . ']<br>';
								echo"<img src=\'maps/icons/lightning.png\'>" . $poke_id["beauty"] . '[' . $poke["beauty"] . '] ';
								echo"<img src=\'maps/icons/shield.png\'>" . $poke_id["endurance"] . '[' . $poke["endurance"] . ']<br>';
								echo'Fähigkeit <b>' . $abilitie . '</b>';
							echo"'" . ',CAPTION,' . "'Statuswerte'" . ');" ';
							echo'onmouseout="return nd();">';
							
							echo'</a>';	
					
					echo '</td><td>';
					echo '<b style="color:#' . $typ_color . ';">' . $poke["name"] . '</b><br><img src="maps/icons/hslider.png">' . $poke_id["level"];
					$erf_exp = exp_raten($poke_id["intelligence"], $poke_id["level"]);
					if($poke_id["exp"] != 0){
						$pro_exp = floor(100 / ($erf_exp / $poke_id["exp"]));
					} else {
						$pro_exp = 0;
					}
					echo '<br><img src="maps/icons/marketwatch.png">' . $pro_exp . '%';
					echo '<br><img src="maps/icons/heart.png">' . $poke_id["love"];
					echo '</td></tr></table></p>';
				} else {
					echo '<table><tr>';
					echo '<td width="16" height="32" align="center" valign="middle">
							<input type="radio" name="pokemon" value="' . $poke_id["id"] . '">
						</td>';
					echo '<td width="32" height="32" align="center" valign="bottom">';
					if ($poke_id["love"] < 29){
						if (($poke_id["loved"]) < date('Y-m-d H:i:s',time()-$loved_plus)){
							// Eine Anklickbare Grafik wird erstellt
							echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?streicheln=' . $poke_id["id"] . '"><img src="maps/oworld/' . $poke["id"] . '.png" ';
						} else {
							echo '<img src="maps/oworld/' . $poke["id"] . '.gif" ';
						}
					} else {
						echo '<img src="maps/oworld/' . $poke["id"] . '.gif" ';
					}
					
					//Die Statuswerte
							echo'onmouseover="return overlib(' . "'";
								echo"<img src=\'maps/icons/co2.png\'>" . $poke_id["intelligence"] . '[' . $poke["intelligence"] . '] ';
								echo"<img src=\'maps/icons/shuriken.png\'>" . $poke_id["strength"] . '[' . $poke["strength"] . ']<br>';
								echo"<img src=\'maps/icons/lightning.png\'>" . $poke_id["beauty"] . '[' . $poke["beauty"] . '] ';
								echo"<img src=\'maps/icons/shield.png\'>" . $poke_id["endurance"] . '[' . $poke["endurance"] . ']<br>';
								echo'Fähigkeit <b>' . $abilitie . '</b>';
							echo"'" . ',CAPTION,' . "'Statuswerte'" . ');" ';
							echo'onmouseout="return nd();">';
							
							echo'</a>';	
							
					echo '</td>
						<td width="32" height="32" align="center">
							<a href="' . $_SERVER['SCRIPT_NAME'] . '?sort=' . $poke_id["id"] . '">
								<img src="maps/icons/award.png">
							</a>
						</td>
						<td width="80" height="32" valign="middle">';
					echo '<b style="color:#' . $typ_color . ';">' . $poke["name"] . '</b><br>';
					echo'<img src="maps/icons/hslider.png">' . $poke_id["level"] . ' ';
					//echo ' (' . $poke_id["exp"] . '/' . $erf_exp . ')';
					echo '<img src="maps/icons/heart.png">' . $poke_id["love"] . '<br>';
					echo '</td>
						<td width="16" height="32" align="center">
							<a href="' . $_SERVER['SCRIPT_NAME'] . '?delete_pokemon=' . $poke_id["id"] . '">
								<img src="maps/icons/bin_empty.png">
							</a>
						</td>
						</tr></table>';
				}
			}
		}
		if (mysql_num_rows( mysql_query( "SELECT * FROM items WHERE user='$_SESSION[user_id]'" ) ) != 0){
			echo '</div></p>';
			
			//Die Items Werden angezeigt
			$title_item = mysql_fetch_array(mysql_query("select * from itemdex order by rand() limit 1"));
			echo'<p><div class="title" onmouseover="return overlib(' . "'" . '<p>Um ein Heilitem zu nützen, muss zuerst ein Pokemon ausgewählt werden.</p>' . "'" . ');" ';
				echo'onmouseout="return nd();">
					<table><tr>
						<td width="64" height="32" align="center" valign="middle">
							<img src="items/' . $title_item["id"] . '.png">
						</td>
						<td><h1>Items</h1></td>
					</tr></table>
				</div>
				<div class="forms"><table>';
					$abfrage = mysql_query( "SELECT * FROM items WHERE user='$_SESSION[user_id]'" );
					while($item=mysql_fetch_array($abfrage)){
						$abfrage2 = mysql_query("select * from itemdex where id='$item[dexid]'");
						while($ausgabe = mysql_fetch_array($abfrage2)){
							$item["name"] = $ausgabe["name"];
							$item["text"] = $ausgabe["text"];
							$item["typ"] = $ausgabe["typ"];
						}
						echo '<tr>';
							echo '<td width="16" height="32" align="center" valign="middle">
									<input type="radio" name="pokemon" value="' . $item["dexid"] . '">
								</td>
								<td width="32" height="32" align="center" valign="bottom">
									<img src="items/' . $item["dexid"] . '.png">
								</td>
								<td width="16" height="32" align="center" valign="middle">' . $item["number"] . 'x</td>
								<td width="64" height="32" align="center" valign="bottom">' . $item["name"] . '<br></td>';
							echo'<td width="32" height="32" align="center" valign="bottom">';
							if($item["typ"] == 1){
								echo'<img src="maps/icons/heart_add.png">';
							}
							echo'</td>';
						echo '</tr>';
						//echo '<p><strong>x ' . $item["name"] . '</strong> ' . $item["text"] . '</p>';
					}
				echo'</table>';
			echo '<p><input type="submit" value="Benützen"></p></div>';
		}
		echo'</form></div></p>';
	}
?>