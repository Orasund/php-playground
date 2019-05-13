<?php
	function addsection($des,$fun){
		echo '<div><table></table></div>
			<p class="desc">
				<b>Beschreibung:</b><br>
				' . $des . '<br><br>
				<b>Funktionen:</b><br>
				' . $fun . '
			</p>';
	}
?>

<!DOCTYPE html>
 <html>
	<head>
		<title>Ein T.E.S.T</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="codepage.js"></script>
	</head>
	<body>
		<header>
			<img
				src="images/castle.png" onclick="map('castle');changemenu(0);"><img
				src="images/market.png" onclick="map('market');changemenu(1);"><img
				src="images/arena.png" onclick="map('arena');changemenu(2);"><img
				src="images/mine.png" onclick="map('mine');changemenu(3);"><img
				src="images/tower.png" onclick="map('tower');changemenu(4);">
			<b>Rune</b><b>Water</b>
			<div id="user"><img onclick="changemenu(5);" src="http://icons.iconarchive.com/icons/creativenerds/google-plus/128/google-plus-2-icon.png"></div>
		</header>
		<article>
			<section id="castle">
				<?php addsection(
					'Das Schloss ist das einzige große Gebäude auf der Insel. Es schau sehr alt aus und hat viele versteckte Korridore und Räume. Nur der vordere Teil des Schlosses wird von euch benützt.<br>Räume:<i>Schlafsaal,Schmiede,Versammlungsraum,Mine,Trainningsraum</i>',
					'Im Schloss werden Statistiken angezeigt und Abstimmungen zu allen aktuellen Themen gemacht, es werden auch alle aktuellen Nachrichten angezeigt.<br>Einige Felder können ausgebaut werden, du kannst abstimmen welche'
				)?>
				<table id="vote_build"></table>
				<p><b>Nachrichten</b><br>
				<table>
					<tr>
						<td>Die <b>A insel</b> wurde von der <b>B Insel</b> Angegriffen</td>
					</tr>
				</table>
				</p>
			</section>
			<section id="tower">
				<?php addsection(
					'Der Wachturm schützt die Insel vor Feinde. Jeden Tag findet ein Angriff auf der Brücke statt. Hat eine Gruppe dabei gewonnen, so kann diese den feindlichen Wachturm einnehmen. Schafft es die Verteidigende Gruppe nicht am nächsten Tag den Wachturm wieder einzunehmen, so haben sie verloren.',
					'Jeden Tag musst du auf einen Wachturm gehen. Hier kannst du wählen auf welchen du gehst.'
				)?>
				<table id="vote_tower"></table>
			</section>
			<section id="mine">
				<?php addsection(
					'In der Mine ist es sehr stickig, und dunkel. Jeder hat die Möglichkeit hier Materialien abzubauen.',
					'Derzeit kann nichts in der Mine Gemacht werden'
				)?>
				<p><a>Abbauen</a></p>
			</section>
			<section id="arena">
				<?php addsection(
					'Hier können Testkämpfe durchgeführt werden um die Erfahrung zu verbessern.',
					'Hier kann noch nicht gekämpft werden'
				)?>
				<p>Exp:<meter value="0" max="10"></meter><br>
				<a>Kämpfen</a></p>
			</section>
			<section id="market">
				<?php addsection(
					'Der Markt ist nicht sehr groß, aber besitzt eine gute Übersicht von allen Produkten die auf der Insel hergestellt worden sind.',
					'Hier hast du die Möglichkeit Waffen und Runen mit anderen Leuten zu tauschen. Die Währung ist Steinholz(#), ein Rohstoff aus dem Waffen und Runen gemacht werden.'
				)?><p>Dein Steinholz: #24
				<table>
					<tr>
						<td>Name</td><td>Preis</td><td>Qualität</td><td>Besitzer</td>
					<tr></tr>
						<td>RT Rune</td><td>#6</td><td>Stärke+3<br>Erfahrung+10</td><td>Svixx</td>
					</tr>
				</table>
				</p>
			</section>
			<section id="settings">Testen</section>
		</article>
		<footer>Copyright by Orasund</footer>
		<script type="text/javascript">
			map("castle");
			map("market");
			map("arena");
			map("mine");
			map("tower");
			createvote("market","B2",["Mine","Arena","Markt","Turm"],1,"vote_build");
			createvote("arena","B3",["Mine","Arena","Markt","Turm"],2,"vote_build");
			createvote("mine","B4",["Mine","Arena","Markt","Turm"],3,"vote_build");
			createvote("tower","Wache",["Insel A","Insel B"],4,"vote_tower");
			//removevote("vote_build","vote_0"); beispiel
		</script>
	</body>
 </html>