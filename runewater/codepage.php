<?php
	$user_id = $_SESSION['user_id'];
	$fetch = mysql_query("SELECT mine_count FROM users WHERE id='$user_id'") or die(mysql_error());
	list($mine_count) = mysql_fetch_row($fetch);
	$user_island = $_SESSION['user_island'];
	
	/*** Tagesablauf ***/
	if(isset($_GET["time"]) && $_GET["time"]= 1){
		$islands = array(
			array(0,1,2,3,0,1), //land
			array(1,2,3,0,2,3),
			array(0,0,0,0,1,1), //opt
			array(2,2,2,2,1,1)
		);
		for ($i = 0; $i < 6; $i++) { //für jede Brücke
			/*** Get Infomation ***/
			$opt = $islands[2][$i];
			$island = $islands[0][$i];
			$front_a = array();
			$fetch = mysql_query("SELECT user FROM votes WHERE vote='4' AND opt='$opt' AND island='$island'") or die(mysql_error());
			while ($row = mysql_fetch_array($fetch)){$front_a[] = $row["user"];}
			
			$opt = $islands[3][$i];
			$island = $islands[0][$i];
			$front_b = array();
			$fetch = mysql_query("SELECT user FROM votes WHERE vote='4' AND opt='$opt' AND island='$island'") or die(mysql_error());
			while ($row = mysql_fetch_array($fetch)){$front_b[] = $row["user"];}
			/*** Sort them out ***/
			$winners = 0;
			$c = 0;
			shuffle($front_a);
			shuffle($front_b);
			if(count($front_a) > count($front_b)){
				$winners = count($front_a) - count($front_b);
				$c = count($front_b);
			}
			if(count($front_b) > count($front_a)){
				$winners = count($front_b) - count($front_a);
				$c = count($front_a);
			}
			
			for ($x = 0; $x < $c; $x++) {
				//Insert into fights, kämpfer 1und 2, auch anzeigen, dass dies zur Brücke gehört
			}
		}	
	}
	
	/*** User ***/
	class user{
		public $atklevel;
		public $minelevel;
		public $craftlevel;
		public $id;
		public $level;
		public $job;
		public $names = array(array("Kämpfer","Helfer","Erfinder","Kommander"));
		public function draw(){
			$this->id = $_SESSION['user_id'];
			$fetch = mysql_query("SELECT atklevel,minelevel,craftlevel,level,job FROM users WHERE id='$this->id'") or die(mysql_error());
			list($this->atklevel,$this->minelevel,$this->craftlevel,$this->level,$this->job) = mysql_fetch_row($fetch);
			
			echo '<table>
				<tr><th colspan="2" class="info"></th><th colspan="4" width="75%">' . $this->names[0][$this->job] . ' Lv.<span id="level">' . $this->level . '</span></th></tr>
				<tr>
					<td class="pic" id="eq_w_pic"></td>
					<td class="info" id="eq_w_info"></td>
					<td rowspan="2">
						<b>Waffenlevel: <span id="atklevel">' . $this->atklevel . '</span></b><br>
						<b>Abbaulevel: <span id="minelevel">' . $this->minelevel . '</span></b><br>
						<b>Schmiedelevel: <span id="craftlevel">' . $this->craftlevel . '</span></b><br>
					</td><td rowspan="2">
						<b>Stärke: <span id="str"></span></b> [2*(<span id="damage"></span> + <span id="amulett_str"></span>)]<br>
						<b>Stabilität: <span id="bal"></span></b> [2*(<span id="bal_level"></span> + <span id="amulett_bal"></span>)]<br>
						<b>Leben: <span id="life"></span></b> [100 + <span id="amulett_life"></span>]<br>
						<b>Exp pro Sieg: <span id="exp_s"></span></b> [1 + <span id="amulett_exp"></span>]<br>
					</td>
					<th width="1px" rowspan="2"><img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/32/Actions-configure-icon.png" onclick="changemenu(5);"></th>
				</tr>
				<tr>
					<td class="pic" id="eq_a_pic"></td>
					<td class="info" id="eq_a_info"></td>
				</tr>
			</table>';
		}
	}
	
	
	/*** Battles ***/
	class battles{
		public $gress = array(
			array(0,0,0,0,0,0,0),
			array(1,1,1,1,1,1,1),
			array(2,2,2,2,2,2,2),
			array(3,3,3,3,3,3,3)
		);
		public $islands = array(
			array(0,1,2,3,0,1), //land
			array(1,2,3,0,2,3),
			array(0,0,0,0,1,1), //opt
			array(2,2,2,2,1,1)
		);
		public $names = array("A","B","C","D");
			
		public function progress($id, $land){return '<td class="i_' . $this->names[$this->gress[$land][$id-1]] . ' focus">' . $this->names[$land] . $id . '</td>';}
		public function empty_td(){return'<td class="empty"></td>';}
	
		public function draw(){// Progress anzeigen
			$fetch = mysql_query("SELECT id,progress,front_a,front_b FROM battle") or die(mysql_error());
			while($o = mysql_fetch_array($fetch)){
				switch($o[1]){
					case 0://a2
						$this->gress[$this->islands[0][$o[0]-1]][1+$this->islands[2][$o[0]-1]] = $this->islands[1][$o[0]-1];
					case 1://a5
						$this->gress[$this->islands[0][$o[0]-1]][4+$this->islands[2][$o[0]-1]] = $this->islands[1][$o[0]-1];
						break;
					case 4://b4
						$this->gress[$this->islands[1][$o[0]-1]][1+$this->islands[3][$o[0]-1]] = $this->islands[0][$o[0]-1];
					case 3://b7
						$this->gress[$this->islands[1][$o[0]-1]][4+$this->islands[3][$o[0]-1]] = $this->islands[0][$o[0]-1];
						break;
					default:
				}
			}
		
		
			echo '<table>
				<tr>
					<th colspan="6">Map</th>
					<th>Archiv</th>
				</tr>
				<tr>' . 
					$this -> progress(1, 0) . 
					$this -> progress(2, 0) . 
					$this -> progress(5, 0) . 
					$this -> progress(7, 1) . 
					$this -> progress(4, 1) . 
					$this -> progress(1, 1) . 
					'<td rowspan="6"><table id="archiv"></table></td>
				</tr>
				<tr>' . 
					$this -> progress(4, 0) . 
					$this -> progress(3, 0) . 
					$this -> empty_td() . 
					$this -> empty_td() . 
					$this -> progress(3, 1) . 
					$this -> progress(2, 1) . 
				'</tr>
				<tr>' . 
					$this -> progress(7, 0) . 
					$this -> empty_td() . 
					$this -> progress(6, 0) . 
					$this -> progress(6, 1) . 
					$this -> empty_td() . 
					$this -> progress(5, 1) . 
				'</tr>
				<tr>' . 
					$this -> progress(5, 3) . 
					$this -> empty_td() . 
					$this -> progress(6, 3) . 
					$this -> progress(6, 2) . 
					$this -> empty_td() . 
					$this -> progress(7, 2) . 
				'</tr>
				<tr>' . 
					$this -> progress(2, 3) . 
					$this -> progress(3, 3) . 
					$this -> empty_td() . 
					$this -> empty_td() . 
					$this -> progress(3, 2) . 
					$this -> progress(4, 2) . 
				'</tr>
				<tr>' . 
					$this -> progress(1, 3) . 
					$this -> progress(4, 3) . 
					$this -> progress(7, 3) . 
					$this -> progress(5, 2) . 
					$this -> progress(2, 2) . 
					$this -> progress(1, 2) . 
				'</tr>
			</table>';
		}
	}
?>
<!DOCTYPE html>
 <html>
	<head>
		<title>Runewater</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="codepage.js"></script>
		<script type="text/javascript" src="js/vote.js"></script>
		<script type="text/javascript" src="js/news.js"></script>
		<script type="text/javascript" src="js/fight.js"></script>
		<script type="text/javascript" src="js/forum.js"></script>
		<script type="text/javascript" src="js/offer.js"></script>
		<script type="text/javascript" src="js/item.js"></script>
		<script type="text/javascript" src="js/mine.js"></script>
		<script type="text/javascript" src="js/map.js"></script>
		<script type="text/javascript" src="js/login.js"></script>
		<script type="text/javascript" src="js/smith.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
	</head>
	<body>
		<header>
			<img
				src="http://icons.iconarchive.com/icons/treetog/junior/128/earth-icon.png" onclick="changemenu(0);"><img
				src="http://icons.iconarchive.com/icons/kyo-tux/delikate/128/Network-icon.png" onclick="changemenu(7);"><img 
				src="http://icons.iconarchive.com/icons/iconshock/windows-7-general/128/administrator-icon.png" onclick="items();changemenu(6);">
			<b>Rune</b><b>Water</b>
			<div id="user">
				<?php
					if($_SESSION['user_level'] >= 5){
						echo '<img class="info" src="http://icons.iconarchive.com/icons/iconshock/real-vista-development/256/admin-privilege-icon.png" onclick="changemenu(9);">';
					}
				?>
				<a class="info" href="doc.php"><img src="http://icons.iconarchive.com/icons/treetog/junior/96/document-icon.png"></a>
				<a href="logout.php"><img src="http://icons.iconarchive.com/icons/visualpharm/must-have/128/Log-Out-icon.png"></a>
			</div>
		</header>
		
		<!-- ************************************************
						--- ARTICLE ---
		************************************************* -->
		<article>
			<aside id="error"></aside>
			
			
			<!-- ********************************************
								Castle
			********************************************* -->
			<section id="castle">
				<table></table>
				
				<table id="vote_build">
					<tr><th colspan="4">Abstimmung</th></tr>
					<tr>
						<th class="empty focus">X2</th>
						<td><select>
							<option onclick="changeselect(0,0);checkvote(0,0);">Mine</option>
							<option onclick="changeselect(0,1);checkvote(0,1);">Arena</option>
							<option onclick="changeselect(0,2);checkvote(0,2);">Markt</option>
							<option onclick="changeselect(0,3);checkvote(0,3);">Turm</option>
						</select></td>
						<td class="info">
							<meter id="0_0" max="12" value="0">0 Votes für </meter>Mine<br>
							<meter id="0_1" max="12" value="0">0 Votes für </meter>Arena<br>
						</td>
						<td class="info">
							<meter id="0_2" max="12" value="0">0 Votes für </meter>Markt<br>
							<meter id="0_3" max="12" value="1">1 Votes für </meter>Turm<br>
						</td>
					</tr>
					<tr>
						<th class="empty focus">X3</th>
						<td><select>
							<option onclick="changeselect(1,0);checkvote(1,0);">Mine</option>
							<option onclick="changeselect(1,1);checkvote(1,1);">Arena</option>
							<option onclick="changeselect(1,2);checkvote(1,2);">Markt</option>
							<option onclick="changeselect(1,3);checkvote(1,3);">Turm</option>
						</select></td>
						<td class="info">
							<meter id="1_0" max="12" value="0">0 Votes für </meter>Mine<br>
							<meter id="1_1" max="12" value="0">0 Votes für </meter>Arena<br>
						</td>
						<td class="info">
							<meter id="1_2" max="12" value="0">0 Votes für </meter>Markt<br>
							<meter id="1_3" max="12" value="1">1 Votes für </meter>Turm<br>
						</td>
					</tr>
					<tr>
						<th class="empty focus">X4</th>
						<td><select>
							<option onclick="changeselect(2,0);checkvote(2,0);">Mine</option>
							<option onclick="changeselect(2,1);checkvote(2,1);">Arena</option>
							<option onclick="changeselect(2,2);checkvote(2,2);">Markt</option>
							<option onclick="changeselect(2,3);checkvote(2,3);">Turm</option>
						</select></td>
						<td class="info">
							<meter id="2_0" max="12" value="0">0 Votes für </meter>Mine<br>
							<meter id="2_1" max="12" value="0">0 Votes für </meter>Arena<br>
						</td>
						<td class="info">
							<meter id="2_2" max="12" value="0">0 Votes für </meter>Markt<br>
							<meter id="2_3" max="12" value="1">1 Votes für </meter>Turm<br>
						</td>
					</tr>
				</table>
				<?php 
					$battle = new battles;
					$battle->draw();
				?>
			</section>
			
			<!-- ********************************************
								TOWER
			********************************************* -->
			<section id="tower">
				<table></table>
				<table id="vote_tower"></table>
				<table>
					<tr class="header">
						<td>Kampf</td>
						<td>Status: Warte auf anderen Spieler...</td>
					</tr>
					<tr>
						<td colspan="3">Der Gegner ist am Zug, du kannst gerade nichts tun.</td>
					</tr>
				</table>
			</section>
			
			<!-- ********************************************
								MINE
			********************************************* -->
			<section id="mine">
				<table></table>
				<table id="vote_mine"></table>
				<table>
					<tr class="header">
						<th colspan="3">Abbauen(<span id="mcnt"><?php echo $mine_count; ?></span>/10)</th>
						<th class="info">Mine</th>
					</tr>
					<tr>
						<td onclick="mine(1);">?</td>
						<td onclick="mine(2);">?</td>
						<td onclick="mine(3);">?</td>
						<td class="info" rowspan="2" width="50%">
							<meter value="4" max="4">Level 4 </meter>Tiefe<br>
							<meter value="3" max="4">Level 3 </meter>Lager
						</td>
						
					</tr>
					<td colspan="3" id="mining">Klick auf eines der Felder um etwas abzubauen</td>
				</table>
				
				<table>
					<tr class="header">
						<th>Waffe</th>
						<th>Qualität</th>
						<th> </th>
					</tr>
					<tr>
						<td rowspan="2" width="33%">
							<input type="hidden" id="sel_1">
							<img class="select" onclick="selection(1,1,4);" id="opt_1_1" width="48%" src="images/items/2.svg">
							<img class="select" onclick="selection(1,2,4);" id="opt_1_2" width="48%" src="images/items/3.svg">
							<img class="select" onclick="selection(1,3,4);" id="opt_1_3" width="48%" src="images/items/4.svg">
							<img class="select" onclick="selection(1,4,4);" id="opt_1_4" width="48%" src="images/items/5.svg">
						</td><td rowspan="2" width="33%">
							<input type="hidden" id="sel_2">
							<img class="select" onclick="selection(2,1,4);" id="opt_2_1" width="48%" src="images/count/1.svg">
							<img class="select" onclick="selection(2,2,4);" id="opt_2_2" width="48%" src="images/count/2.svg">
							<img class="select" onclick="selection(2,3,4);" id="opt_2_3" width="48%" src="images/count/3.svg">
							<img class="select" onclick="selection(2,4,4);" id="opt_2_4" width="48%" src="images/count/4.svg">
						</td>
						<td id="forge_info"></td>
					</tr>
					<tr><td><a class="button" onclick="forge();">Schmieden</a></td></tr>
				</table>
				
				<table>
					<tr class="header">
						<th colspan="4">Rune Schmieden</th>
					</tr>
					<tr>
						<td width="33%">
							<input type="hidden" id="sel_3">
							<select>
								<option>Wähle!</option>
								<option onclick="selection(3,1,8);" id="opt_3_1">Feuer</option>
								<option onclick="selection(3,2,8);" id="opt_3_2">Wasser</option>
								<option onclick="selection(3,3,8);" id="opt_3_3">Erde</option>
								<option onclick="selection(3,4,8);" id="opt_3_4">Luft</option>
								<option onclick="selection(3,5,8);" id="opt_3_5">Tod</option>
								<option onclick="selection(3,6,8);" id="opt_3_6">Leben</option>
								<option onclick="selection(3,7,8);" id="opt_3_7">Glück</option>
								<option onclick="selection(3,8,8);" id="opt_3_8">Wissen</option>
							</select>
						</td>
						<td width="33%">
							<input type="hidden" id="sel_4">
							<select>
								<option>Wähle!</option>
								<option onclick="selection(4,1,8);" id="opt_4_1">Feuer</option>
								<option onclick="selection(4,2,8);" id="opt_4_2">Wasser</option>
								<option onclick="selection(4,3,8);" id="opt_4_3">Erde</option>
								<option onclick="selection(4,4,8);" id="opt_4_4">Luft</option>
								<option onclick="selection(4,5,8);" id="opt_4_5">Tod</option>
								<option onclick="selection(4,6,8);" id="opt_4_6">Leben</option>
								<option onclick="selection(4,7,8);" id="opt_4_7">Glück</option>
								<option onclick="selection(4,8,8);" id="opt_4_8">Wissen</option>
							</select>
						</td>
						<td>
							<input type="hidden" id="sel_5">
							<select>
								<option>Wähle!</option>
								<option onclick="selection(5,1,8);" id="opt_5_1">Feuer</option>
								<option onclick="selection(5,2,8);" id="opt_5_2">Wasser</option>
								<option onclick="selection(5,3,8);" id="opt_5_3">Erde</option>
								<option onclick="selection(5,4,8);" id="opt_5_4">Luft</option>
								<option onclick="selection(5,5,8);" id="opt_5_5">Tod</option>
								<option onclick="selection(5,6,8);" id="opt_5_6">Leben</option>
								<option onclick="selection(5,7,8);" id="opt_5_7">Glück</option>
								<option onclick="selection(5,8,8);" id="opt_5_8">Wissen</option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="forge2_info">
							Wähle drei Elemente und ein Material<br>
							Eine Rune kostet 2 Kupfer,Eisen,Silber oder Runenstein
						</td>
						<td>
							<input type="hidden" id="sel_6">
							<select>
								<option onclick="selection(5,0,8);">Wähle!</option>
								<option onclick="selection(5,0,8);">2 Kupfer</option>
								<option onclick="selection(5,0,8);">2 Eisen</option>
								<option onclick="selection(5,0,8);">2 Silber</option>
								<option onclick="selection(5,0,8);">2 Runenstein</option>
							</select>
						</td>
						<td><a class="button" onclick="forge2();">Amulett Schmieden</a></td>
					</tr>
				</table>
				<table id="items1"></table>
			</section>
			
			<!-- ********************************************
								Arena
			********************************************* -->
			<section id="arena">
				<table></table>
				<table>
					<tr class="header">
						<th class="info">Bot</th>
						<th>Du</th>
						<th>Gegner</th>
					</tr>
					<tr>
						<td class="info">
							<meter value="1" max="10">1 </meter>Level<br>
							<meter value="3" max="10">3 </meter>Exp<br>
						</td>
						<td id="arena_attacker"></td>
						<td id="arena_defender"></td>
					</tr>
					<tr>
						<td class="info" rowspan="2">
							<b>Funktionen:</b><br>
							<input type="checkbox">[Level 02]Automatisch abstimmen<br>
							<input type="checkbox">[Level 03]Rohstoffe Abbauen<br>
							<input type="checkbox">[Level 04]Waffen reparieren<br>
							<input type="checkbox">[Level 05]Waffen verbessern<br>
							<input type="checkbox">[Level 07]Waffen schmieden<br>
							<input type="checkbox">[Level 08]Waffen verkaufen<br>
							<input type="checkbox">[Level 09]Runen schmieden<br>
							<input type="checkbox">[Level 10]Runen verkaufen
						</td>
						
						<td colspan="2" class="info" id="arena_info"></td>
					</tr>
					<tr><td colspan="2" id="arena_fight"></td></tr>
				</table>
			</section>
			
			<!-- ********************************************
								Market
			********************************************* -->
			<section id="market">
				<table></table>
				<table>
					<thead><tr class="header"><th colspan="5">Gemeinschaftsraum</th></tr></thead>
					<tbody id="offer_2"></tbody>
					
				</table>
				<table>
					<thead><tr class="header"><th colspan="5">Spezial Items</th></tr></thead>
					<tbody id="offer_1"></tbody>
				</table>
				<table>
					<thead><tr class="header"><th colspan="5">Markt</th></tr></thead>
					<tbody id="offer_0"></tbody>
					<tfoot><tr><th colspan="5" id="money"></th></tr></tfoot>
				</table>
				<table id="items3"></table>
			</section>
			
			<!-- ********************************************
								Settings
			********************************************* -->
			<section id="settings">Testen</section>
			
			<!-- ********************************************
								Profil
			********************************************* -->
			<section id="profil">
				<?php 
					$user = new user;
					$user->draw();
				?>
				<table id="items0"></table>
				<table id="items2"></table>
			</section>
			
			<!-- ********************************************
								Forum
			********************************************* -->
			<section id="forum">
				<div id="f0"> </div>
				<div id="f1"> </div>
			</section>
			<section id="topic"> </section>
		
			<!-- ********************************************
								Admin
			********************************************* -->
			<section id="admin">
				<table>
					<tr><th colspan="2">Admin</th></tr>
					<tr>
						<td>Bot hinzufügen</td>
						<td>Name: <input type="text"><br>
							Beruf:
							<select>
								<option id="0">K�mpfer</option>
								<option id="1">Helfer</option>
								<option id="2">Erfinder</option>
							</select><br>
							Insel:
							<select>
								<option id="0">A</option>
								<option id="1">B</option>
								<option id="2">C</option>
								<option id="2">D</option>
							</select><br>
						</td>
					</tr>
				</table>
			</section>
		<!-- ************************************************
								Footer
		************************************************* -->
		</article>
		<footer>Copyright by Falconface</footer>
		<script type="text/javascript">
			var ids =["castle","market","arena","mine","tower","settings","profil", "forum","topic","admin"];
			changemenu(0); // Hier umstellen um nicht lange suchen zu müssen
			map(0);
			map(1);
			map(2);
			map(3);
			map(4);
			
			//Kann abgestellt werden um anzeige zu verschnellern
			//createvote("vote_build",["B2","B3","B4"],["market","arena","mine"],["Mine","Arena","Markt","Turm"]);
			createvote("vote_tower",["Wache"],["tower"],["Armun","Dales","Baltar"]);
			createvote("vote_mine",["Upgrade"],["mine"],["Mine - Bessere Materialien","Lager - öfters Abbauen"]);
			//offer(1);
			fight("arena");
			forum("0");
			news();
		</script>
	</body>
 </html>