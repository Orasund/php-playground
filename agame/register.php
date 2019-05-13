<?php
session_start();

include("settings.php");

 echo "hello " . $_GET["name"] . '<br>'
 . "passwort " . $_GET["pass"] . '=' . $_GET["pass2"] . '<br>'
 . "fraction " . $_GET["fraction"] . '<br>'
 . "stat1 " . $_GET["stat1"] . '<br>'
 . "stat2 " . $_GET["stat2"] . '<br>'
 . "stat3 " . $_GET["stat3"] . '<br>';
 if($_GET["pass"]==$_GET["pass2"]){
	echo "passwort stimmt ;) <br>";
	$stats = [1,1,1];
	for($i=1;$i<4;$i++){
		$stats[$_GET["stat" . $i]]++;
	}
	echo "Macht " . $stats[0] . "<br>"
	. "Kontrolle " . $stats[1] . "<br>"
	. "Status" . $stats[2] . "<br>";
	
	mysql_query("INSERT INTO users (name,password,fraction,stat_m,stat_k,stat_s,online)
							VALUES ('" . $_GET["name"] . "','" . $_GET["pass"] . "','" . $_GET["fraction"] . "','" . $stats[0] . "','" . $stats[1] . "','" . $stats[2] . "',CURDATE())") or die(mysql_error());
	$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE name='$_GET[name]'"));
	echo $row["online"] . '=' . date('Y-m-d') . "<br>";
	echo days_past($row["online"]). " Tage";
	$_SESSION["userid"] = $row["id"];
	

 }
?>