<?php
	$host = "localhost";
	$user = "root";
	$passwort = "";
	$dbname = "runewater";
	mysql_connect($host,$user,$passwort)or die(mysql_error());
	mysql_select_db($dbname)or die(mysql_error());
	$fetch = mysql_query("SELECT * FROM votes WHERE id = $_GET[db]") or die(mysql_error());
	while($vote = mysql_fetch_array($fetch)or die(mysql_error())){
		echo $vote["num"];
	}
?>