<?php
	$host = "localhost";
	$user = "root";
	$passwort = '';
	$dbname = "runewater";
	$str_full = "";
	mysql_connect($host,$user,$passwort)or die(mysql_error());
	mysql_select_db($dbname)or die(mysql_error());
	$fetch = mysql_query("SELECT * FROM news") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){
		//date(typ,who,whom)
		$str_full = $str_full . $output["date"] . '(' . 
		$output["typ"] . "," . 
		$output["who"] . "," . 
		$output["whom"] . ")";
	}
	echo $str_full;
?>