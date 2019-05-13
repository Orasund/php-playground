<?php
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	$island = $_SESSION['user_island'];
	//$choise = $_GET["choise"];
	$mine = "mine" . $_GET["id"];
	
	//Das alte Minenscript
	//Mine
	$fetch = mysql_query("SELECT * FROM islands WHERE id='$island'") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){
		$update = $output["mine"];
	}
	$fetch = mysql_query("SELECT * FROM users WHERE id='$user_id'") or die(mysql_error());
	while($output = mysql_fetch_array($fetch)){
		$num = $output[$mine] + 1;
		$level = $output["minelevel"];
		$mine_count = $output["mine_count"] - 1;
	}
	$change = array(array(50,25,12,6,2),array(64,40,25,15,7),array(75,52,36,23,11),array(88,67,49,32,16),array(100,80,60,40,20));
	$r = rand(0,99);
	if($r < $change[$level][4] && $update > 2){
		$item = 5;
		echo 5;
	} else if($r < $change[$level][3] && $update > 1){
		$item = 3;
		echo 4;
	} else if($r < $change[$level][2] && $update > 0){
		$item = 2;
		echo 3;
	} else if($r < $change[$level][1]){
		$item = 1;
		echo 2;
	} else if($r < $change[$level][0]){
		$item = 0;
		echo 1;
	} else {
		$item = 6;
		echo 0;
	}
	//1 - Mineral (0-4) (Steinholz,Kupfererz,Eisenerz,Silbererz,Runenstein)
		
	if ($item != 6) {
		$fetch = mysql_query("SELECT * FROM items WHERE typ='1' AND level='$item' AND user='$user_id'") or die(mysql_error());
		$num = mysql_num_rows($fetch);
		if($num > 0){//Material und Rohrunen(stackable)
			while($output = mysql_fetch_array($fetch)){
				$id = $output["id"];
				$count = $output["count"] + 1;
			}
			mysql_query("UPDATE items SET count='$count' WHERE id='$id'") or die(mysql_error());
		}else{
			mysql_query("INSERT INTO items (`typ`,`level`,`user`) VALUES ('1','$item','$user_id')") or die(mysql_error());
		}
	}
	
	//Counter 
	mysql_query("UPDATE users SET mine_count='$mine_count' WHERE id='$user_id'") or die(mysql_error());
?>