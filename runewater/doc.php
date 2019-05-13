<?php
		
	function section(){
		$ids = array("Willkommen","Kampfsystem","Levelsystem","Taktiken","Abbauen","Map","Spielidee","Runen","Amulette","Waffen","Waffenschmieden","Runenschmieden","Berufe","Tipps und Tricks");
		foreach($ids as $id => $sec){
			
			echo '
				<section id="' . $ids[$id] . '"><table>
					<tr>
						<th>Men�</th>
						<th>' . $ids[$id] . '</th>
					</tr>';
					$i = 0;
					foreach($ids as $key => $sec){
						echo '<tr><td onclick="changemenu(' . $key . ');">' . $sec . '</td>';
						if($i == 0){
							echo '<td rowspan="' . count($ids) . '">';
							switch($ids[$id]){
								case "Willkommen": //Willkommen
									echo'
										<p>Willkommen in Runewater. Einem Spiel in dem es um Teamwork und Taktik.</p>
										<p>Die Spieler von Runewater sind auf 4 Inseln verteilt, die mit je drei Br�cken mit einander verbunden sind. Jeden Tag gehen verteilen die Mitspieler sich auf den Br�cken und versuchen die anderen Inseln zu st�rmen. Durch Abstimmungen der Spieler k�nnen Insel besser werden als andere und so an St�rke gewinnen. Jedoch besitzt jede Entscheidung ebenfalls eine Schwachstelle, die von den anderen Inseln erkannt und ben�tzt werden soll.</p>
										<p>Diese Hilfeseite steht f�r jeden Spieler zur Verf�gungung und enth�lt jede Formel, Taktik oder Information die gebraucht werden kann um das Verhalten der gegnerischen Inseln zu analysieren. Viel Spass!</p>
									';
									break;
								case "Kampfsystem": //Kampfsystem
									echo'
										<table>
											<tr class="header">
												<td colspan="5">Karten</td>
											</tr>
											<tr>
												<td></td>
												<td><b>Runenstein</b></td>
												<td><b>Silber</b></td>
												<td><b>Gold</b></td>
												<td><b>Steinholz</b></td>
											</tr>
											<tr>
												<td><b>Admiral<b></td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>4</i><br>
													Verteidigung: <i>1</i><br>
													Zusatz:<br>
													<i>Gegner - Stabilit�t/2</i><br><br><br>
												</td>
												<td>
													<br>
													Angriff: <i>3</i><br>
													Verteidigung: <i>2</i><br>
													Zusatz:<br>
													<i>Gegner - Stabilit�t/3<br>
													Du - St�rke/1.5<br>
													Du - Erfahrung/1.5</i>
												</td>
												<td>
													<br>
													Angriff: <i>2</i><br>
													Verteidigung: <i>3</i><br>
													Zusatz:<br>
													<i>Gegner - Stabilit�t/4<br>
													Du - St�rke/2<br>
													Du - Erfahrung/2</i>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>1</i><br>
													Verteidigung: <i>4</i><br>
													Zusatz:<br>
													<i>Gegner - Stabilit�t/5<br>
													Du - St�rke/2.5<br>
													Du - Erfahrung/2.5</i>
												</td>
											</tr>
											<tr>
												<td><b>K�mpfer<b></td>
												<td>
													<br>
													Angriff: <i>3</i><br>
													Verteidigung: <i>2</i><br>
													Zusatz:<br>
													<i>Gegner - St�rke/2</i><br><br><br>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>4</i><br>
													Verteidigung: <i>1</i><br>
													Zusatz:<br>
													<i>Gegner - St�rke/3<br>
													Du - Stabilit�t/1.5<br>
													Du - Leben/1.5</i>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>1</i><br>
													Verteidigung: <i>4</i><br>
													Zusatz:<br>
													<i>Gegner - St�rke/4<br>
													Du - Stabilit�t/2<br>
													Du - Leben/2</i>
												</td>
												<td>
													<br>
													Angriff: <i>2</i><br>
													Verteidigung: <i>3</i><br>
													Zusatz:<br>
													<i>Gegner - St�rke/5<br>
													Du - Stabilit�t/2.5<br>
													Du - Leben/2.5</i>
												</td>
											</tr>
											<tr>
												<td><b>Erfinder<b></td>
												<td>
													<br>
													Angriff: <i>2</i><br>
													Verteidigung: <i>3</i><br>
													Zusatz:<br>
													<i>Gegner - Erfahrung/2</i><br><br><br>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>1</i><br>
													Verteidigung: <i>4</i><br>
													Zusatz:<br>
													<i>Gegner - Erfahrung/3<br>
													Du - Leben/1.5<br>
													Du - Stabilit�t/1.5</i>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>4</i><br>
													Verteidigung: <i>1</i><br>
													Zusatz:<br>
													<i>Gegner - Erfahrung/4<br>
													Du - Leben/2<br>
													Du - Stabilit�t/2</i>
												</td>
												<td>
													<br>
													Angriff: <i>3</i><br>
													Verteidigung: <i>2</i><br>
													Zusatz:<br>
													<i>Gegner - Erfahrung/5<br>
													Du - Leben/2.5<br>
													Du - Stabilit�t/2.5</i>
												</td>
											</tr>
											<tr>
												<td><b>Helfer<b></td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>1</i><br>
													Verteidigung: <i>4</i><br>
													Zusatz:<br>
													<i>Gegner - Leben/2</i><br><br><br>
												</td>
												<td>
													<br>
													Angriff: <i>2</i><br>
													Verteidigung: <i>3</i><br>
													Zusatz:<br>
													<i>Gegner - Leben/3<br>
													Du - Erfahrung/1.5<br>
													Du - St�rke/1.5</i>
												</td>
												<td>
													<br>
													Angriff: <i>3</i><br>
													Verteidigung: <i>2</i><br>
													Zusatz:<br>
													<i>Gegner - Leben/4<br>
													Du - Erfahrung/2<br>
													Du - St�rke/2</i>
												</td>
												<td>
													<b>Asskarte</b><br>
													Angriff: <i>4</i><br>
													Verteidigung: <i>1</i><br>
													Zusatz:<br>
													<i>Gegner - Leben/5<br>
													Du - Erfahrung/2.5<br>
													Du - St�rke/2.5</i>
												</td>
											</tr>
										</table>
										<p>Beide Spieler haben am Anfang <b>100 Lebenspunkte</b> und <b>5 Karten</b>.</p>
										<p>In der ersten Runde w�hlt jeder <b>eine Zusatzkarte</b>. Die Zusatzkarte schw�cht entweder Stabilit�t, St�rke, Erfahrung oder Leben des Gegners. Daf�r musst du selber auch auch keinen kleinen Preis zahlen. Es ist <b>nicht</b> M�glich keine Zusatzkarte zu w�hlen. Nach der ersten Runde wird wieder <b>eine neue Karte gezogen</b>, sodass man <b>wieder 5 Karten</b> hat.</p>
										<p>Nun wird <b>abwechselt angegriffen</b>. Der Angreifer, also der, der den anderen herausgefordert hat, kann <b>drei Mal angreifen</b>. Der andere nur <b>zwei Mal</b>. In jedem Angriff ben�tzt man eine seiner Karten um seinen <b>Angriff</b> oder <b>Verteidigung</b> zu st�rken.</p>
										<p>Um das Spiel interessanter zu machen, wird angezeigt wie viele gute Karten der Gegner besitzt. Diese Karten nennt man <b>Asskarten</b></p>
										<table>
											<tr class="header"><td colspan="2">Formeln</td></tr>
											<tr>
												<td><b>Stärke = 2*(Waffenschaden + Amulett)</b></td>
												<td><b>Angriff = Stärke/Zusatzkarte*Level*Angriffskarte</b></td>
											</tr>
											<tr>
												<td><b>Stabilität = 2*(Level + Amulett)</b></td>
												<td><b>Verteidigung = Stabilität/Zusatzkarte*Level*Verteidigungskarte</b></td>
											</tr>
										</table>
									';
									break;
								case "Levelsystem":
									echo '
										<p>Erfahrung bekommt man durch K�mpfe. Pro gewonnen Kampf bekommt man 1 Exp plus weitere falls man eine besonderes Amulett hat.</p>
										<p>Pro Level Up kann man eine Fertigkeit verbessern.</p>
										<table>
											<tr class="header">
												<th>Level</th>
												<th>ben�tigte Exp</th>
												<th>Bot-F�higkeit</th>
											</tr>
											<tr>
												<td>1</td>
												<td></td>
												<td>
													<b>Neues Kampfsystem</b><br>
													Der Bot w�hlt zuf�llig aus allen seinen Karten aus.
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>6</td>
												<td>
													<b>Automatisch Abstimmen</b><br>
													Der Bot macht jeden Tag automatisch bei Abstimmungen mit. Dabei richtet er sich immer nach der Mehrheit.
												</td>
											</tr>
											<tr>
												<td>3</td>
												<td>8</td>
												<td>
													<b>Rohstoffe Abbauen</b><br>
													Der Bot baut nun jeden Tag selbstst�ndig Rohstoffe bei der Mine ab.
												</td>
											</tr>
											<tr>
												<td>4</td>
												<td>11</td>
												<td>
													<b>Waffen reparieren</b><br>
													Der Bot repariert alle Waffen die er besitzt oder die derzeit im Lager der Insel sind.
												</td>
											</tr>
											<tr>
												<td>5</td>
												<td>15</td>
												<td>
													<b>Waffen verbessern</b><br>
													Der Bot verbessert alle Waffen die er besitzt oder die derzeit im Lager der Insel sind.
												</td>
											</tr>
											<tr>
												<td>6</td>
												<td>20</td>
												<td>
													<b>Neues Kampfsystem</b><br>
													Der Bot sucht nach Karten die verdoppeln oder verdreifachen. Erst am Ende ben�tzt er Asse.
												</td>
											</tr>
											<tr>
												<td>7</td>
												<td>26</td>
												<td>
													<b>Waffen schmieden</b><br>
													schmiedet die st�rkste Waffe die derzeit m�glich ist.
												</td>
											</tr>
											<tr>
												<td>8</td>
												<td>33</td>
												<td>
													<b>Waffen verkaufen</b><br>
													schlechte Waffen werden verkauft, ist der Waffenschaden h�her als der der derzeit getragenen Waffe, legt er die neue Waffe an und verkauft die Alte.
												</td>
											</tr>
											<tr>
												<td>9</td>
												<td>41</td>
												<td>
													<b>Runen schmieden</b><br>
													Schmiedet Runen. Dabei wird m�glichst schlechtes Material ben�tzt, da die Runen eh nach einem Zufallsprinzip gew�hlt werden.
												</td>
											</tr>
											<tr>
												<td>10</td>
												<td>50</td>
												<td>
													<b>Runen verkaufen</b><br>
													Alle Runen werden verkauft, dabei wir vorallem darauf geachtet, keine billigen Preise zu machen.
												</td>
											</tr>
											<tr>
												<td>11</td>
												<td>60</td>
												<td>
													<b>Neues Kampfsystem</b><br>
													Der Bot ben�tzt ein <b>komplexes System</b>. Siehe <b>Taktiken</b>
												</td>
											</tr>
											<tr>
												<td>12</td>
												<td>71</td>
												<td></td>
											</tr>
											<tr>
												<td>13</td>
												<td>83</td>
												<td></td>
											</tr>
											<tr>
												<td>14</td>
												<td>96</td>
												<td></td>
											</tr>
											<tr>
												<td>15</td>
												<td>110</td>
												<td></td>
											</tr>
										</table>
									';
									break;
								case "Taktiken":
									echo'
										<p>Jeder Spieler besitzt einen Bot, der f�r ihn K�mpft, wenn er nicht gerade aktiv ist. Dieser Bot hat je nach Level ein anderes Kampfsystem. Es ist ganz praktisch zu wissen welche Taktiken Bots haben.</p>
										<p>Das erste Kampfsystem ben�tzt der Bot von Level 1 weg. Er sucht sich eine zuf�llige Karte aus und spielt diese. Es wird nicht empfohlen diese Taktik nachzumachen, da der Bot normalerweise schon nach dem zweiten Zug tot ist.</p>
										<p>Das zweite Kampfsystem erh�lt der Bot auf Level 6. Er spielt zuerst Karten, die den Wert 3 haben. Dann Karten die den Wert 2 haben und anschlie�end Asse(Karten mit den Werten 4 und 1). Diese Taktik ist relativ durchschnittlich, da man wenig denken muss. Es ist nie ein Fehler, seine Asse f�r das Ende aufzubewahren.</p>
										<p>Das dritte Kampfsystem erreicht der Bot auf Level 11.  Dabei ben�tzt er ein eher komplexeres System. Dieses System ist nicht das Beste, aber es kann Anf�nger und Bots mit Leichtigkeit besiegen.</p>
										<table>
											<tr class="header">
												<th>Zug</th>
												<th>Angreifer</th>
												<th>Verteidiger</th>
												<th>Theorie</th>
											</tr>
											<tr>
												<td>erster Angriff</td>
												<td>2,3,4, egal</td>
												<td>3,2,4, egal</td>
												<td>Im ersten Zug eine Ass zu spielen w�re nicht gut und da die Warscheinlichkeit zu hoch ist, dass der Gegner die Karte auf jeden Fall blocken kann, spielt man eine 2</td>
											</tr>
											<tr>
												<td>erste Verteidigung</td>
												<td>4,3,2, egal</td>
												<td>4,3,2, egal</td>
												<td>Der Gegner spielt nun eine Ass, da der Verteidiger seine Asse sofort spielen sollte. Eine Ass kann nur mit einer anderen Ass geblockt werden.</td>
											</tr>
											<tr>
												<td>weitere Z�ge</td>
												<td>3,2,4, egal</td>
												<td>3,2,4, egal</td>
												<td>nun werden alle 3 und 2 gespielt, bis keine mehr da sind</td>
											</tr>
											<tr>
												<td>Angriff mit nur Assen</td>
												<td>4, egal </td>
												<td>4,3,2</td>
												<td>Sobald nur noch Asse im Spiel sind, spielt man die h�hsten Karten zuerst.</td>
											</tr>
										</table>
									';
									break;
								case "Abbauen";
									echo'
										<p>Die Warscheinlichkeit ein Material zu bekommen h�ngt vom Abbaulevel deiner Figur ab.</p>
										<table>
											<tr>
												<th>Material</th>
												<th>Level 1</th>
												<th>Level 2</th>
												<th>Level 3</th>
												<th>Level 4</th>
												<th>Level 5</th>
											</tr>
											<tr>
												<td>Erde</td>
												<td>50%</td>
												<td>36%</td>
												<td>25%</td>
												<td>12%</td>
												<td>0%</td>
											</tr>
											<tr>
												<td>Steinholz</td>
												<td>25%</td>
												<td>24%</td>
												<td>23%</td>
												<td>21%</td>
												<td>20%</td>
											</tr>
											<tr>
												<td>Kupfer</td>
												<td>13%</td>
												<td>15%</td>
												<td>16%</td>
												<td>18%</td>
												<td>20%</td>
											</tr>
											<tr>
												<td>Eisen</td>
												<td>6%</td>
												<td>10%</td>
												<td>13%</td>
												<td>17%</td>
												<td>20%</td>
											</tr>
											<tr>
												<td>Silber</td>
												<td>4%</td>
												<td>8%</td>
												<td>12%</td>
												<td>16%</td>
												<td>20%</td>
											</tr>
											<tr>
												<td>Runenstein</td>
												<td>2%</td>
												<td>7%</td>
												<td>11%</td>
												<td>16%</td>
												<td>20%</td>
											</tr>
										</table>
										<p>Jede Woche kann ein Vote abgegeben werden, f�r ein gr��eres Lager oder f�r eine tiefere Mine.</p>
										<table>
											<tr>
												<th>Level</th>
												<th>gr��eres Lager</th>
												<th>tiefere Mine</th>
											</tr>
											<tr>
												<td>Level 1</td>
												<td>10x abbauen pro Tag</td>
												<td>Steinholz und Kupfer</td>
											</tr>
											<tr>
												<td>Level 2</td>
												<td>20x abbauen pro Tag</td>
												<td>Steinholz,Kupfer und Eisen</td>
											</tr>
											<tr>
												<td>Level 3</td>
												<td>40x abbauen pro Tag</td>
												<td>Steinholz,Kupfer,Eisen und Silber</td>
											</tr>
											<tr>
												<td>Level 5</td>
												<td>80x abbauen pro Tag</td>
												<td>Steinholz,Kupfer,Eisen,Silber und Runenstein</td>
											</tr>
										</table>
									';
									break;
								case "Map":
									echo'
										<p>Es gibt 4 Inseln, jede ist mit jeder verbunden.</p>
										<p>Jede Insel besteht aus 7 Feldern</p>
										<table>
											<tr>
												<th>Feld</th>
												<th>Art</th>
											</tr>
											<tr>
												<td>X1</td>
												<td>Schloss - Hier kann man den derzeitigen Verlauf auf den Br�cken sehen.</td>
											</tr>
											<tr>
												<td>X2,X3,X4</td>
												<td>Baubares Feld - Hier wir jeden Tag entschieden welches Gebaude auf das Feld gebaut wird.</td>
											</tr>
											<tr>
												<td>X5,X6,X7</td>
												<td>Wachturm - Von hier aus kann man auf die verschiedenen Insel gehen.</td>
											</tr>
										</table>
										<p>Baubare Geb�ude sind Wachturm, Mine, Arena und Markt</p>
										<table>
											<tr>
												<th>Geb�ude</th>
												<th>Funktion</th>
											</tr>
											<tr>
												<td>Burg</td>
												<td>Hier kann man �ber die Felder X2,X3 und X4 abstimmen. Auch gibt es hier eine Karte in der man sieht welches Feld gerade welcher Insel geh�rt.</td>
											</tr>
											<tr>
												<td>Wachturm</td>
												<td>Hier kann man entscheiden, gegen welche Insel man k�mpfen will.</td>
											</tr>
											<tr>
												<td>Mine</td>
												<td>Hier k�nnen neue Mineralien abgebaut werden und gleich zu Waffen und Amulette verarbeitet werden.</td>
											</tr>
											<tr>
												<td>Arena</td>
												<td>Hier kann dein Bot trainniert werden</td>
											</tr>
											<tr>
												<td>Markt</td>
												<td>Hier k�nnen Items verkauft werden und anderen auf der Insel zur Verf�gung gestellt werden.</td>
											</tr>
										</table>
									';
									break;
								default:
								 echo "Ein Fehler ist aufgetreten";
							}
							echo '</td>';
							$i++;
						}
						echo'</tr>';
					}
					echo'</td>
					</tr>
				</table></section>
			';
		}
	}
?>
<!DOCTYPE html>
 <html>
	<head>
		<title>Runewater</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="codepage.js"></script>
		<script type="text/javascript" src="js/vote.js"></script>
		<script type="text/javascript" src="js/news.js"></script>
		<script type="text/javascript" src="js/fight.js"></script>
		<script type="text/javascript" src="js/forum.js"></script>
		<script type="text/javascript" src="js/offer.js"></script>
		<script type="text/javascript" src="js/item.js"></script>
		<script type="text/javascript" src="js/mine.js"></script>
		<script type="text/javascript" src="js/map.js"></script>
	</head>
	<body>
		<header>
			<a href="index.php"><img src="http://icons.iconarchive.com/icons/treetog/junior/128/earth-icon.png" onclick="changemenu(0);"></a>
			<b>Rune</b><b>Water</b><b>Documentary</b>
			<div id="user">
				<a href="logout.php"><img src="http://icons.iconarchive.com/icons/visualpharm/must-have/128/Log-Out-icon.png"></a>
			</div>
		</header>
		<article>
			<aside id="error"></aside>
			<?php section(0); ?>
		</article>
		<footer>Copyright by Orasund</footer>
		<script type="text/javascript">
			if(navigator.appName != "Opera"){
				var txt = '<table><tr><td><img src="http://files.myopera.com/alexs/blog/OperaIcon_128x128.png"></td><td>Diese Seite w�rde f�r Opera ausgerichtet. Laden sie sich Opera herunter um die Seite besser genie�en zu k�nnen.</td></tr></table>';
				var error = document.getElementById("error");
				error.innerHTML = txt;
			}
			
			var ids = ["Willkommen","Kampfsystem","Levelsystem","Taktiken","Abbauen","Map","Spielidee","Runen","Amulette","Waffen","Waffenschmieden","Runenschmieden","Berufe","Tipps und Tricks"];
			changemenu(0);
		</script>
	</body>
 </html>