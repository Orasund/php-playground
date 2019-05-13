<?php
	$str_full = "";
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	$user_island = $_SESSION['user_island'];
	if(isset($_GET["typ"])){$typ = $_GET["typ"];} else {$typ = 0;}
	$status = 1;
	if($typ == 1){
		//Die Sonderangebote
	} else {
		if($typ == 2){$status = 2 + $user_island;}
		$fetch = mysql_query("SELECT * FROM items WHERE status='$status'") or die(mysql_error());
		while($output = mysql_fetch_array($fetch)){
			/* *********** * /
				Itemliste
			typ - Name (level)
			0 - roheRune (0-7) (Zerst�ren, Erschaffen, Befestigen,L�sen,Verbrauchen,�berleben,Konzentrieren,Improvisieren)
			1 - Mineral (0-4) (Steinholz,Kupfererz,Eisenerz,Silbererz,Runenstein)
			2 - Steinschwert (0-3) (Schlechtes, , Gutes, Verbessertes)
			3 - Bronzeschwert
			4 - Eisenschwert
			5 - Silberschwert
			6 - Stahlschwert*/
			
			//id(count,typ,level,price,user)
			$str_full = $str_full . $output["id"] . '(' . 
			$output["count"] . "," . 
			$output["typ"] . "," . 
			$output["level"] . "," . 
			$output["price"] . ","; 
			if($user_id == $output["user"]){$str_full = $str_full . "0)";} else {$str_full = $str_full . "1)";}
		}
		echo $str_full;
	}
?>