<?php 
	include 'dbc.php';
	page_protect();
	
	include 'menu.php';
	
	//Alle Daten zum User werden geholt und in $user gespeichert
	$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
	
	if(isset($_GET["game"]) && $_GET["game"] == 1){
		include 'plugins/games/verpixelt.php';
	}
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
		<!-- BEGIN Shoutbox.de CODE -->
			<iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>
		<!-- END Shoutbox.de CODE-->
		</div>
		<div id="content">
			<?php
				if ($user["guild"] != 0){
					if(isset($_GET["game"])){
						showgame();
					} else {
						echo'<p><div class="forms">
							<p><strong>Minispiele</strong></p>
							<p>Hier können alle Gildenmitglieder ein wenig Geld verdienen.</p>
							<p>Klick auf einen der unten angeführten Spiele um dies zu spielen.</p>
							<p>Die Zahl hinter dem Spiel sagt wie viel Geld das Spielen kostet.</p>
							<p><b>Spiele:</b></p>
							<p><a href="games.php?game=1" onmouseover="return overlib(' . "'" . 'Finde heraus, welches Pokemon hier verpixelt ist.' . "'" . ');" onmouseout="return nd();">Verpixelt! [50 Gold]</a></p>
						</div></p>';
					}
				}
			?>
		</div>
		<div id="sidebar"><?php cgear(); ?></div>
  </div>

</body>
</html>