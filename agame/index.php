<?php
	session_start();
	
	include("settings.php");
?>
<html>
	<head>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<link rel="stylesheet" href="css/layouts/side-menu.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
			$(document).ready(function(){
			  $("#submit").click(function(){
			    $("#content").load(
					'register.php?name='+$("#name").val()+
								'&pass='+$("#pass").val()+
								'&pass2='+$("#pass2").val()+
								'&fraction='+$("#fraction").val()+
								'&stat1='+$('input[name="stat1"]:checked').val()+
								'&stat2='+$('input[name="stat2"]:checked').val()+
								'&stat3='+$('input[name="stat3"]:checked').val()
				,function(responseTxt,statusTxt,xhr){});
			  });
			});
		</script>
	</head>
	<body>
	<div id="layout">
		<!-- Menu toggle -->
		<a href="#menu" id="menuLink" class="menu-link">
			<!-- Hamburger icon -->
			<span></span>
		</a>

		<div id="menu">
			<div class="pure-menu pure-menu-open">
				<a class="pure-menu-heading" href="#">Company</a>

				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">About</a></li>

					<li class="menu-item-divided pure-menu-selected">
						<a href="#">Services</a>
					</li>

					<li><a href="#">Contact</a></li>
				</ul>
			</div>
		</div>
	<div id="main">
		<div class="header">
            <h1>aGame</h1>
            <h2>willkommen im spiel</h2>
        </div>
		<div id="content" class="content">
			
				<?php
					if(isset($_SESSION["userid"])){
						$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$_SESSION[userid]'")) or die(mysql_error());
						echo '
						<div class="pure-g">
						<div class="pure-u-1-2">
						<div class="pure-g">
							<div class="pure-u-1">name:'.$row["name"] . '</div>
							<div class="pure-u-1-2">Fraktion:</div>
							<div class="pure-u-1">Macht:'.$row["stat_m"] . '</div>
							<div class="pure-u-1">Kontrolle:'.$row["stat_k"] . '</div>
							<div class="pure-u-1">Status:'.$row["stat_s"] . '</div>
							<div class="pure-u-1">Geld:'.$row["gold"] . '</div>
							<div class="pure-u-1">Dabei seit '.days_past($row["online"]).' Tagen</div>
						</div>
						</div>
						<div class="pure-u-1-4"><img class="pure-img" src="img/frac'.$row["fraction"] . '.png"></div>
						</div>';
					} else {
						echo '
						<h1>Neuer Charakter</h1><br>
						<form class="pure-form pure-form-aligned">
							<fieldset class="pure-group">
								<legend>Über dich</legend>
								<input id="name" type="text" class="pure-input-1-2" placeholder="Name">
								<input id="pass" type="text" class="pure-input-1-2" placeholder="Passwort">
								<input id="pass2" type="text" class="pure-input-1-2" placeholder="Passwort wiederholen">
							</fieldset>
							<fieldset class="pure-group">
								<legend>Fraction</legend>
								<div class="pure-g">
								<div class="pure-u-1">
								<img class="pure-img" src="img/fraktionen.png">
								</div></div><br>
								<select id="fraction" class="pure-input-1-2">
									<option value=0>Innsbruck</option>
									<option value=1>Nördliche Innseite</option>
									<option value=2>Südliche innseite</option>
								</select>
							</fieldset>
							<fieldset>
								<legend>Eigenschaften</legend>
								<p>Verteile 3 Punkte auf deine Eigenschaften</p>
								<div class="pure-control-group">
									<label>Macht</label>
									<input type="radio" checked><input name="stat1" type="radio" value="0"><input name="stat2" type="radio" value="0"><input name="stat3" type="radio" value="0">
									<i>Macht ist deine Angriffstärke</i>
								</div>
								<div class="pure-control-group">
									<label>Kontrolle</label>
									<input type="radio" checked><input name="stat1" type="radio" value="1"><input name="stat2" type="radio" value="1"><input name="stat3" type="radio" value="1">
									<i>Kontrolle bestimmt die Anzahl deiner Züge</i>
								</div>
								<div class="pure-control-group">
									<label>Status</label>
									<input type="radio" checked><input name="stat1" type="radio" value="2"><input name="stat2" type="radio" value="2"><input name="stat3" type="radio" value="2">
									<i>Status bestimmt dein Einkommen.</i>
								</div>
							</fieldset>
							<a id="submit" class="pure-button pure-button-primary pure-input-1-2" href="#">Registrieren</a>
						</form>
						';
					}
				?>
				
		</div>
	</div>
	</div>
	</body>
</html>