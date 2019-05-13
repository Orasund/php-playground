<?php
	include 'dbc.php';
	page_protect();
	$user_island = $_SESSION['user_island'];
	
	$str_full = "";
	$fetch = mysql_query("SELECT * FROM islands WHERE id='$user_island'") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){
		/* *********** * /
			Itemliste
		typ - Name (level)
		0 - roheRune (0-7) (Zerstören, Erschaffen, Befestigen,Lösen,Verbrauchen,Überleben,Konzentrieren,Improvisieren)
		1 - Mineral (0-4) (Steinholz,Kupfererz,Eisenerz,Silbererz,Runenstein)
		2 - Steinschwert (0-3) (Schlechtes, , Gutes, Verbessertes)
		3 - Bronzeschwert
		4 - Eisenschwert
		5 - Silberschwert
		6 - Stahlschwert*/
		
		//id,z2,z3,z4,mine,save
		$str_full = $user_island . "," . 
		$output["z2"] . "," . 
		$output["z3"] . "," . 
		$output["z4"] . "," . 
		$output["mine"] . "," . 
		$output["save"];
	}
	echo $str_full;
?>