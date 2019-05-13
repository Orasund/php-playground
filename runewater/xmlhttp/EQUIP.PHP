<?php
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	
	//Kann dieses Item �berhaupt equipt werden?
	if(isset($_GET["id"])){$item = $_GET["id"];} else {$item = 0;}
	$fetch = mysql_query("SELECT * FROM items WHERE id='$item' AND status='0' AND (typ < 1 OR typ > 1) AND user='$user_id'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	if($num > 0){//dieses Item exestiert
		while($output = mysql_fetch_array($fetch)){
			$typ = $output["typ"];
		}
		
		// Equipen
		if($typ == 0){$equip = "equit_rune";} else {$equip = "equit_weapon";}
		mysql_query("UPDATE users SET $equip='$item' WHERE id='$user_id'") or die(mysql_error());
		echo 0;
	} else {
		echo 1;
	}	
	
	
?>