<?php
	//Will jemand Karte wechseln?
	if(isset($_GET["go"])) {
		include '../dbc.php';
		page_protect();
		//Das st�rkste Pokemon im Team wird ausgesucht
		$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
		//Alle Daten zum User werden geholt und in $user gespeichert
		$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
		//$Map Id suchen
		$map = mysql_fetch_array(mysql_query("select * from maps where id='$user[map]'"));
		//schauen ob dein Pokemon K�mpfen kann
		if ($user[map] > 1000 && rand(0,2) != 1) {
		} else {
			if ($your_pokemon["level"] > 3 && $your_pokemon["love"] > 7) {
				mysql_query("update users set map='$_GET[go]' where id='$_SESSION[user_id]'") or die(mysql_error());
			}
		}
		header("Location: ../world.php");
	}

//Warper
function portal($id, $dir, $x, $y) {
	
	if($dir == "dun" && mysql_num_rows( mysql_query("select * from items where dexid='4' and user='$_SESSION[user_id]'") ) == 0){
	} else {
		//Das st�rkste Pokemon im Team wird ausgesucht
		$your_pokemon = mysql_fetch_array(mysql_query("select * from pokemons where userid='$_SESSION[user_id]' and sort='1'"));
		//Kann das Pokemon k�mpfen
		if ($your_pokemon["level"] > 3 && $your_pokemon["love"] > 7) {
			if(($dir == "speed_left" or $dir == "speed_right" or $dir == "speed_up" or $dir == "speed_down") && $your_pokemon["abilities"] != 1){
			} else {
				$x = $x * 16;
				$y = $y * 16;
				echo '<a href="plugins/portal.php?go=' . $id . '" style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;"><img src="maps/' . $dir . '_arrow.png" onmouseover="return overlib(' . "'" . 'Karte wechseln' . "'" . ');" onmouseout="return nd();"></a>';
			}
		}
	}
}
?>