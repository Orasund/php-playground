<?php
    include 'dbc.php';
	page_protect();
	$r1 = $_GET["r1"] - 1; //1-8 convert to 0-7
	$r2 = $_GET["r2"] - 1; //1-8 convert to 0-7
	$r3 = $_GET["r3"] - 1; //1-8 convert to 0-7
	$level = $_GET["m"];
	$user_id = $_SESSION['user_id'];
	$m = array(0,0);
	
	/*** Material Check ***/
	//Baumaterial
	$fetch = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='$level' AND user='$user_id'") or die(mysql_error());
	if(mysql_num_rows($fetch) == 0){echo 1;exit();} //ERROR: Material nicht vorhanden
	list($m[0],$m[1]) = mysql_fetch_row($fetch);
	if($m[0] < 2){echo 1;exit();} //ERROR: Material nicht vorhanden
	$m[0] -= 2; //Material abziehen
	
	/*** Datenbank Eintrag ***/
	//Baumaterial
	//echo "Anzahl: " . $m[0] . "<br>";
	if($m[0] > 0){
		mysql_query("UPDATE items SET count='$m[0]' WHERE id='$m[1]'") or die(mysql_error());
	} else {
		mysql_query("DELETE FROM items WHERE id='$m[1]'") or die(mysql_error());
	}
	
	/*** Amulett machen ***/
	$a = $r1 + ($r2*8) + ($r3*64);
	$levels = array(5,10,20,40,80);
	
	$fetch = mysql_query("SELECT craftlevel FROM users WHERE id='$user_id'") or die(mysql_error());
	list($clevel) = mysql_fetch_row($fetch);
	
	if(rand(1,100) >= $levels[$clevel]){echo 2;exit();}//Schmieden fehlgeschlafen
	
	mysql_query("INSERT INTO items (`typ`,`level`,`user`) VALUES (0,'$a','$user_id')") or die(mysql_error());
	echo 0;
		
	
?>