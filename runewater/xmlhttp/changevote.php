<?php
	include 'dbc.php';
	page_protect();
	$user_island = $_SESSION['user_island'];
	$user_id = $_SESSION['user_id'];
	
	$vote = $_GET["vote"];
	$opt = $_GET["opt"];
	
	$fetch = mysql_query("SELECT * FROM votes WHERE user='20' AND vote='$vote' AND island='$user_island'") or die(mysql_error());
	
	$num = mysql_num_rows($fetch);
	if ( $num > 0 ) {
		while($output = mysql_fetch_array($fetch)){
			echo $output["opt"];
		}
		mysql_query("UPDATE votes SET opt='$opt' WHERE user='20' AND vote='$vote'") or die(mysql_error());
	} else {
		mysql_query("INSERT INTO votes (`user`,`vote`,`opt`,`island`) VALUES ('$user_id','$vote','$opt','$user_island')") or die(mysql_error());
		echo $opt;
	}
?>