<?php
	include 'dbc.php';
	page_protect();
	$id = $_GET["id"];
	$mes = $_GET["mes"];
	$user_id = $_SESSION['user_id'];
	$typ = $_GET["typ"];
	if($typ == 0){
		mysql_query("INSERT INTO topics (`text`,`forum`,`user`) VALUES ('$mes','$id','$user_id')") or die(mysql_error());
	} else {
		mysql_query("INSERT INTO posts (`text`,`topic`,`user`) VALUES ('$mes','$id','$user_id')") or die(mysql_error());
	}
	?>