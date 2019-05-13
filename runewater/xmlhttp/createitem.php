<?php
    include 'dbc.php';
	page_protect();
	$typ = $_GET["typ"] - 1; //1-4 convert to 0 - 3
	$level = $_GET["level"] - 1; //1-4 convert to 0-3
	$m = array(0,0);
	$st = array(0,0);
	$user_id = $_SESSION['user_id'];
	
	/*** Material Check ***/
	//Baumaterial
	$fetch = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='$typ' AND user='$user_id'") or die(mysql_error());
	if(mysql_num_rows($fetch) == 0){echo 1;exit();} //ERROR: Material nicht vorhanden
	list($m[0],$m[1]) = mysql_fetch_row($fetch);
	if($m[0] < $level){echo 1;exit();} //ERROR: Material nicht vorhanden
	
	//echo "typ: " . $typ;
	if($typ != 0){
		//Steinholz
		$fetch = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error());
		if(mysql_num_rows($fetch) == 0){echo 1;exit();} //ERROR: Material nicht vorhanden
		list($st[0],$st[1]) = mysql_fetch_row($fetch);
		//echo "Anzahl von Steinholz: " . $st[0] . "<br>";
		if($st[0] < $level+1){echo 1;exit();} //ERROR: Material nicht vorhanden
	} else if($m[0] < 2*($level+1)){echo 1;exit();} //ERROR: Material nicht vorhanden
	
	//Material abziehen
	if($typ != 0){
		$m[0] -= $level+1;
		$st[0] -= $level+1;
	} else {
		$m[0] -= 2*($level+1);
	}
	
	/*** Datenbank Eintrag ***/
	//Baumaterial
	if($m[0] > 0){
		mysql_query("UPDATE items SET count='$m[0]' WHERE id='$m[1]'") or die(mysql_error());
	} else {
		mysql_query("DELETE FROM items WHERE id='$m[1]'") or die(mysql_error());
	}
	
	if($typ != 0){
		//Steinholz
		if($st[0] > 0){
			mysql_query("UPDATE items SET count='$st[0]' WHERE id='$st[1]'") or die(mysql_error());
		} else {
			mysql_query("DELETE FROM items WHERE id='$st[1]'") or die(mysql_error());
		}
	}
	
	/*** Schmiede Erfolg***/
	$fetch = mysql_query("SELECT * FROM users WHERE id='$user_id'") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){$level = $output['craftlevel'];}
	$levels = array(5,10,20,40,80);
	if(rand(1,100) < $levels[$level]){//Schmieden erfolgreich
		//Waffe
		$typ += 2; //0-3 convert to 2-5
		mysql_query("INSERT INTO items (`typ`,`level`,`user`) VALUES ('$typ','$level','$user_id')") or die(mysql_error());
		echo 0;
	} else {
		echo 2;
	}
	
?>