<?php 
include 'dbc.php';
page_protect();

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}


include 'menu.php';
include 'npcs.php';

//bevor das eigendliche Skript geladen wird, wird noch geschaut, ob es irgendwelche erneuerungen gibt.

//Alle Daten zum User werden geholt und in $user gespeichert
$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript" type="text/javascript" src="overlib/overlib.js"></script>
 <script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
 <script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	<div id="header"></div>
	<div id="page">
		<div id="chat">
		<!-- BEGIN Shoutbox.de CODE
			<iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>
		END Shoutbox.de CODE-->
		</div>
		<div id="content">
<?php

	//Die Infomationen werden dem Spieler mitgeteilt
	
	//Die Error-Beschipfe-Leise
     if (isset($_GET['msg'])) {
	  echo "<div class=\"error\">$_GET[msg]</div>";
	  }
	
	npcs($user["map"]);
?>
		</div>
		<div id="sidebar"><?php  menu(); ?></div>
  </div>
	<div id="footer" style="text-align:center;"><p><span style="font: normal 9px verdana;">Pokémon (c) ist eine eingetragene Marke von Nintendo / Game Freak Inc.<br>ich verdiene kein Geld mit dieser Seite, PokeCastle soll lediglich als Freizeitbeschäftigung & Werbung für die genannten Marken stehen.</span><p></div>
</body>
</html>
