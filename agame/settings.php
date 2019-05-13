<?php
$link = mysql_connect("localhost","root","");
mysql_select_db("agame",$link);

function days_past($date){
	$date1 = date_create($date);
	$date2 = date_create(date('Y-m-d'));
	$date_diff = date_diff($date2, $date1);
	return $date_diff->d;
}
?>