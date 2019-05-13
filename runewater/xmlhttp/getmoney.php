<?php
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	
	$fetch = mysql_query("SELECT * FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error()); //Steinholz
	$num = mysql_num_rows($fetch);
	if($num > 0){
		while($output = mysql_fetch_array($fetch)){$txt = $output["count"];}
	} else {
		$txt = 0;
	}
	echo $txt;
?>