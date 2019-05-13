<?php
	include 'dbc.php';
	include 'menu.php';
?>
<html>
	<head>
		<title><?php echo SITE_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
		<link href="styles.css" rel="stylesheet" type="text/css">
	</head>
</html>

<body>
	<div id="header"></div>
	<div id="page">
		<div id="chat">
			<!-- BEGIN Shoutbox.de CODE -->
				<iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>
			<!-- END Shoutbox.de CODE-->
		</div>
		<div id="content">
			<div class="forms">
				<h1>Impressum</h1>
				<table>
					<tr>
						<td><b>Betreiber</b></td>
						<td><b>Orasund</b></td>
						<td>orasund@gmail.com</td>
					</tr>
					<tr><td>&nbsp </td></tr>
					<tr><td>&nbsp </td></tr>
					<tr><td>&nbsp </td></tr>
					<tr><td><b>Grafischer Inhalt</b></td></tr>
					<tr>
						<td>Layout</td>
						<td colspan="2"><i>Für das Layout wurden Bilder von folgenen Personen verwendet.</i></td>
					</tr>
					<tr>
						<td></td>
						<td>Thunderwest</td>
						<td>thunderwest.deviantart.com</td>
					</tr>
					<tr>
						<td>Tileset</td>
						<td>Kyledove</td>
						<td>kymotonian.deviantart.com</td>
					</tr>
					<tr>
						<td>Iconset</td>
						<td>FatCow</td>
						<td>fatcow.com</td>
					</tr>
					
					<tr><td>&nbsp </td></tr>
					<tr><td><b>Pokemon Inhalt</b></td></tr>
					<tr>
						<td>Inhaltliche Daten</td>
						<td>pokewiki</td>
						<td>pokewiki.de</td>
					</tr>
					<tr>
						<td>Daten</td>
						<td>ThePokémonCompany</td>
						<td>pokemon.de</td>
					</tr>
					<tr>
						<td></td>
						<td>GAME FREAK Inc.</td>
						<td>gamefreak.co.jp</td>
					</tr>
					<tr>
						<td></td>
						<td>Nintendo</td>
						<td>nintendo.de</td>
					</tr>
					<tr><td>&nbsp </td></tr>
					<tr><td><b>Technischer Inhalt</b></td></tr>
					<tr>
						<td>Login Script</td>
						<td>PHP Login Script v2.3</td>
						<td>php-login-script.com</td>
					</tr>
					<tr>
						<td>popup Script</td>
						<td>overlib</td>
						<td>bosrup.com/web/overlib</td>
					</tr>
					<tr>
						<td>Chat Room</td>
						<td>Shoutbox</td>
						<td>Shoutbox.de</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="sidebar"><?php cgear(); ?></div>
	</div>
	<div id="footer" style="text-align:center;"><p><span style="font: normal 9px verdana;"><a href="impressum.php">Impressum</a><br>Pokémon&copy ist eine eingetragene Marke von Nintendo / Game Freak Inc.<br>ich verdiene kein Geld mit dieser Seite, PokeCastle soll lediglich als Freizeitbeschäftigung & Werbung für die genannten Marken stehen.</span><p></div>
</body>