<?php
	include 'dbc.php';
	page_protect();
	$str_full = "";
	$id = $_GET["id"];
	$fetch = mysql_query("SELECT * FROM posts WHERE topic='$id'");
	if(mysql_num_rows($fetch) == 0){echo 0; exit();}
	while($output = mysql_fetch_array($fetch)){
		//id("text",date,user)
		$str_text = str_replace('"',"",$output["text"]);
		$str_text = str_replace('<',"&lt",$str_text);
		$str_text = str_replace('>',"&gt",$str_text);
		$str_full = $str_full . $output["id"] . '("' .
		$str_text . '",'
		. $output["date"] . ","
		. $output["user"] . ")";
	}
	echo $str_full;
?>