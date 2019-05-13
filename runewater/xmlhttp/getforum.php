<?php
	include 'dbc.php';
	page_protect();
	$str_full = "";
	if(isset($_GET["forum"])){$forum = $_GET["forum"];} else {$forum = 0;};
	if($forum == 1){} else {$fetch = mysql_query("SELECT * FROM topics WHERE forum='$forum'");};
	if(mysql_num_rows($fetch) == 0){echo 0; exit();}
	while($output = mysql_fetch_array($fetch)){
		//id("text",typ,date,user,visits,pins,vote,forum)
		$str_text = str_replace('"',"",$output["text"]);
		$str_text = str_replace('<',"&lt",$str_text);
		$str_text = str_replace('>',"&gt",$str_text);
		$str_full = $str_full . $output["id"] . '("' .
		$str_text . '",' .
		$output["typ"] . ","
		. $output["date"] . ","
		. "Orasund,"//. $output["user"] . ","
		. $output["visits"] . ","
		. $output["pins"] . ","
		. $output["vote"] . ")";
	}
	echo $str_full;
?>