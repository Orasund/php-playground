<?php
	/************************************************
		Unter dem GETfight sollte folgendes Passieren
		Es soll ein Kampf geladen werden, wo User und enemy gefunden werden können.
			Ist Typ gleich 0, so ist enemy und user gleich(Bot)
		gibt es kein solchen kampf, so wird ein neuer erstellt.
		Anschließend werden die Werte gesendet.
	************************************************/
	include 'dbc.php';
	page_protect();
	$user_island = $_SESSION['user_island'];
	$user_id = $_SESSION['user_id'];
	if(isset($_GET["enemy"])){$enemy = $_GET["enemy"];} else {$enemy = $user_id;};
	if(isset($_GET["typ"]) && $_GET["typ"] == 0){
		$attacker = $enemy;
		$defender = $user_id;
		$typ = 0;
	} else {
		$attacker = $user_id;
		$defender = $enemy;
		$typ = 1;
	};
	//TODO: Später sollte auch ein fall sein, wo angreifer und verteidiger beide nicht Userers sind.
	$str_full = "";
	$fetch = mysql_query("SELECT * FROM fights WHERE attacker='$attacker' AND defender='$defender'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	if ( $num == 0 ) { //vielleicht ist der angreifer ein verteidiger
		$fetch = mysql_query("SELECT * FROM fights WHERE attacker='$defender' AND defender='$attacker'") or die(mysql_error());
		$num = mysql_num_rows($fetch);
		if ( $num == 0 ) {
			//okey, es muss nun ein neuer Kampf erstellt werden.
			//Beide ziehen bereits cards
			$a_card1 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$d_card1 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$a_card2 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$d_card2 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$a_card3 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$d_card3 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$a_card4 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$d_card4 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$a_card5 = ((rand(0,3)*4) + rand(0,3)) + 1;
			$d_card5 = ((rand(0,3)*4) + rand(0,3)) + 1;
			mysql_query("INSERT INTO fights (`attacker`,`defender`,`a_card1`,`d_card1`,`a_card2`,`d_card2`,`a_card3`,`d_card3`,`a_card4`,`d_card4`,`a_card5`,`d_card5`) 
				VALUES ('$attacker','$defender','$a_card1','$d_card1','$a_card2','$d_card2','$a_card3','$d_card3','$a_card4','$d_card4','$a_card5','$d_card5')") or die(mysql_error());
			$fetch = mysql_query("SELECT * FROM fights WHERE attacker='$attacker' AND defender='$defender'") or die(mysql_error());
			
		}
	}
	/***********************
		id,
		a_zcard,d_zcard,
		a_life,d_life,
		a_choise,d_choise,
		turn,
		a_card1,a_card2,a_card3,a_card4,a_card5,
		d_card1,d_card2,d_card3,d_card4,d_card5
	***********************/
	while($output = mysql_fetch_array($fetch)){
		$id = $output["id"];
		$a_zcard = $output["a_zcard"];
		$d_zcard = $output["d_zcard"]; 
		$a_choise = $output["a_choise"];
		$d_choise = $output["d_choise"];
		$a_life = $output["a_life"];
		$d_life = $output["d_life"];
		$turn = $output["turn"];
		$attacker = $output["attacker"];
		$defender = $output["defender"];
		$a_cards = array($output["a_card1"],$output["a_card2"],$output["a_card3"],$output["a_card4"],$output["a_card5"]);
		$d_cards = array($output["d_card1"],$output["d_card2"],$output["d_card3"],$output["d_card4"],$output["d_card5"]);
	}
	
	$a_ass = 0;
	foreach($a_cards as $ass){
		switch($ass){
			case 1:
			case 4:
			case 6:
			case 7:
			case 10:
			case 11:
			case 13:
				$a_ass++;
				break;
		}
	}
	$d_ass = 0;
	foreach($d_cards as $ass){
		switch($ass){
			case 1:
			case 4:
			case 6:
			case 7:
			case 10:
			case 11:
			case 13:
				$d_ass++;
				break;
		}
	}
	
	$str_full = $id . ",";
	if($typ == 1){
		$str_full = $str_full . $a_zcard . "," . $d_zcard . "," . 
		$a_life . "," . $d_life . ",";
		if($a_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . ($a_cards[$a_choise - 1] - 1) . ",";}
		if($d_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . "1,";}
		$str_full = $str_full . $turn . "," .
		$a_cards[0] . "," . 
		$a_cards[1] . "," . 
		$a_cards[2] . "," . 
		$a_cards[3] . "," . 
		$a_cards[4] . "," . 
		$a_ass . "," . $d_ass . ",0,0";
	} else {
		$str_full = $str_full . $d_zcard . "," . $a_zcard . "," . 
		$d_life . "," . $a_life . ",";
		if($d_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . ($d_cards[$d_choise - 1] - 1) . ",";}
		if($a_choise == 0){$str_full = $str_full . "0,";}else{$str_full = $str_full . "1,";}
		$str_full = $str_full . $turn . "," .
		$d_cards[0] . "," . 
		$d_cards[1] . "," . 
		$d_cards[2] . "," . 
		$d_cards[3] . "," . 
		$d_cards[4] . "," . 
		$d_ass . "," . $a_ass . ",0,0";
	}
	echo $str_full;
?>