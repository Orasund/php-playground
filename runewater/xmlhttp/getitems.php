<?php
	include 'dbc.php';
	page_protect();
	$u = $_SESSION['user_id'];
	list($w,$a) = mysql_fetch_row(mysql_query("SELECT equit_weapon,equit_rune FROM users WHERE id='$u'"));
	
	$q = array(
		"SELECT * FROM items WHERE user='$u' AND id='$w'",//Equipt Weapon
		"SELECT * FROM items WHERE user='$u' AND id='$a'",//Equipt Amulett
		"SELECT * FROM items WHERE user='$u' AND typ='0' AND NOT id='$a' ORDER BY level", //Amuletts
		"SELECT * FROM items WHERE user='$u' AND typ='1' ORDER BY level", //Materials
		"SELECT * FROM items WHERE user='$u' AND typ>'1' AND typ<'7' AND NOT id='$w' ORDER BY typ", //Weapons
		"SELECT * FROM items WHERE user='$u' AND typ='7' ORDER BY level", //Sonder Items
	);
	
	foreach($q as $k){
		$f = mysql_query($k) or die(mysql_error());
		if(mysql_num_rows($f) == 0){echo "0,0,0,0,0,0,0,0#";} else {
			while($o = mysql_fetch_array($f)){
				echo $o["id"] . "," . 
				$o["typ"] . "," . 
				$o["life"] . "," . 
				$o["level"] . "," . 
				$o["count"] . "," . 
				$o["price"] . "," .
				$o["status"] . "#";
			}
		}
		echo "/";
	}
?>