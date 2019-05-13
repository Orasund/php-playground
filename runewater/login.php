<html>
	<head>
		<title>Runewater</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="codepage.js"></script>
		<script type="text/javascript" src="js/login.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
		<script>
			$(document).ready(function(){
			$("#logForm").validate();
			});
		</script>
	</head>
	<body>
		<header>
			<a class="info" href="index.php"><img src="http://icons.iconarchive.com/icons/gakuseisean/radium/128/Key-icon.png"></a>
			<a class="info" href="register.php"><img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/96/Actions-document-sign-icon.png"></a>
			<b>Rune</b><b>Water</b>
		</header>
		<article>
			<aside id="error"></aside>
			
			<section id="login">
				<table>
						<tbody>
							<tr>
								<td class="info">
									<h1>Willkommen auf Runewater!</h1>
									<p>Diese Seite ist erst in der Alpha Phase, wird aber flei�ig bearbeitet<br>
									Du kannst dich jedoch jetzt schon Anmelden und die Entwicklungen mit verfolgen.</p>
								</td>
								<td>
									<h1>Login</h1>
									<input class="input" id="usr_input" type="text" class="required" size="25" placeholder="Benützername"><br>
									<input class="input" id="pwd_input" type="password" class="required password" placeholder="Passwort" size="25"><br>
									<input id="remember" type="checkbox" value="1"> Eingeloggt bleiben?<br>
									<a class="button" onclick="login();">Spielen</a>
								</td>
								<td class="info">
									<a class="button" href="register.php">Jetzt Registrieren</a>
									<!---<a class="button" href="forgot.php">Passwort vergessen?</a>-->
									<span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.3</a></span>
								</td>
							</tr>
							<tr>
							<td class="info">
								<h1>News</h1>
								<p><b>Alpha 5: Polishing</b><br>
								Mit Alpha 5 ist nun eine kleine Polierung des Layouts und ein paar neue Funktionen gekommen. Allerdings ist Alpha 5 noch nicht ganz abgeschlossen,es ist nur ein kleiner Savepoint.
								</p>
								<p><b>Vorbereitung auf ein gemeinsames Arbeiten</b><br>
								Einige eher unwichtige �nderungen. So wurde das Copyright von Orasund auf Falconface ver�ndert, da ich das Projekt online anmelden musste und als Ben�tzername Falconface gew�hlt habe.<br>
								Des weiteren wurde das Projekt für eine �bertragung vorbereitet.<br>
								Mal sehen was uns erwarten wird.</p>
								<p><b>Alpha 4: Ein Meilenstein</b><br>
								Alpha 4 ist da. Jetzt sind fast alle Funktionen fertig. Als n�chsters kommen die Tagesabl�ufe, dann ist es Spielbar! Jedoch ist das Spiel durch dieses Update ein wenig langsamer geworden. 
								Viel spass mit dem neuen Update!
								</p>
								<p><b>Alpha 3 is da!</b><br>
								Uns so kanns nun los gehen. Mit Alpha 3 kommt das neue Kampfsystem dazu und eine angedeutete Doku, die allerdings noch nicht als diese ben�tzt werden kann.<br>
								Des weiteren kann man jetzt diese Seite auch auf dem Handy recht gut betrachten, leider kann man auf dem Handy nur mit Opera die Seite perfekt Anzeigen. Aber wir arbeiten daran! Versprochen
								</p>
								<p><b>Firefox vs. Opera</b><br>
								Da wir 100% auf Funktionen setzen k�nnen wir leider nicht daf�r sorgen, dass die Seite derzeit f�r jeden Browser perfekt angepasst wird.<br>
								hier einen �berblick �ber alle fehlenden Funktionen:<br>
								<i>Firefox - Anzeige von Messanzeigen<br>
								Firefox - Anzeige von Zahleneingaben<br>
								Opera - Limit von Zeichen in einem Textfeld</i></p>
							</td>
							<td colspan="2">
								<h1>Changelog</h1>
								<p><i>
									<b>Zukunft</b><br>
									[*]Tagesabläufe<br>
									[*]Status Anzeige<br>
									[*]Fertige Dokumentation<br>
									[*]Amulette Regenarieren<br>
									[fix]Item Anzeige<br>
								</i></p>
								<p>
									<b>Alpha 5(18.3.12)</b><br>
									[*]Mapstatus und neue Map<br>
									[*]Limitiertes Abbauen<br>
									[*]PvP-System<br>
									[fix]neues Design
									[*]Neue Grafiken
									[*]Amulett Craften
									[fix]Schmiede und Mine sind nun zusammen<br>
									[*]Forum -  Antworten hinzufügen<br>
								</p>
								<p>
									<b>Alpha 4(26.2.12)</b><br>
									[*]Waffen besch�digen<br>
									[fix] Exp f�r K�mpfe<br>
									[*]Botleveln<br>
									[*]Waffen schmieden<br>
									[*]Waffengrafik<br>
									[*]Gemeinschaftsraum
								</p>
								<p>
									<b>Alpha 3(17.2.12)</b><br>
									[fix]Jetzt f�r Handy Kompaktibel<br>
									[*]Forum-Thema hinzuf�gen<br>
									[*]Waffen upgraden<br>
									[*]Items Anlegen<br>
									[*]Amulette<br>
									[*]Doku<br>
									[fix]Getragene Waffen<br>
									[*]Neues Kampfsystem
								</p>
								<p>
									<b>Alpha 2(14.2.12)</b><br>
									[*]Materialiengrafik<br>
									[*]Marktsystem<br>
									[Fix]Mobile Compactible<br>
								</p>
							</td>
						</tbody>
					</tr>
				</table>
			</section>
		</article>
		<footer>Copyright by Orasund</footer>
		<script type="text/javascript">
			if(navigator.appName != "Opera"){
				error('<img src="http://files.myopera.com/alexs/blog/OperaIcon_128x128.png">Diese Seite w�rde f�r Opera ausgerichtet. Laden sie sich Opera herunter um die Seite besser genie�en zu k�nnen.');
			}
			
			var ids =["login","register","info"];
			
			changemenu(0);
		</script>
	</body>
</html>
