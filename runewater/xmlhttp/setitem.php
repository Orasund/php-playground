<?php
	/**************************************************************
			SICHERHEITSLÜCKE!!!!!
	**************************************************************/
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	$item = $_GET["item"];
	if(isset($_GET["user"])){$user = $_GET["user"];} else {$user = $_SESSION['user_id'];}
	if(isset($_GET["num"])){$num = $_GET["num"];} else {$num = 1;}
	if(isset($_GET["typ"]) && $_GET["typ"] == 0){
		//Neues item Machen!
		if(isset($_GET["level"])){$level = $_GET["level"];} else {$level = 0;}
		
		$fetch = mysql_query("SELECT * FROM items WHERE typ='$item' AND level='$level' AND user='$user'") or die(mysql_error());
		$num = mysql_num_rows($fetch);
		if($item < 2 && $num > 0){//Material und Rohrunen(stackable)
				while($output = mysql_fetch_array($fetch)){
					$id = $output["id"];
					$count = $output["count"] + $num;
				}
				mysql_query("UPDATE items SET count='$count' WHERE id='$id'") or die(mysql_error());
			}	
		}else{
			mysql_query("INSERT INTO items (`typ`,`level`,`user`,`count`) VALUES ('$user_id','$vote','$opt','$num')") or die(mysql_error());
		}
	}
?>