<?php
	include 'dbc.php';
	page_protect();
	$user_island = $_SESSION['user_island'];
	
	$vote = $_GET["vote"];
	$opt = $_GET["opt"];
	$num = 0;
	
	$fetch = mysql_query("SELECT * FROM votes WHERE vote='$vote' AND opt='$opt' AND island='$user_island'") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){
		$num += 1;
	}
	echo $num;
?>