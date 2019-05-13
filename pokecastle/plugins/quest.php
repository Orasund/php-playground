<?php
	if(isset($_GET["quest"]) && isset($_GET["num"])){
		include '../dbc.php';
		page_protect();
		//ist die Quest bereits vorhanden?
		if (mysql_num_rows( mysql_query( "SELECT * FROM quest WHERE art='$_GET[quest]' AND userid='$_SESSION[user_id]'" ) ) == 0 && $_GET["num"] == 1){
			mysql_query("insert into quest (art,userid, num) VALUES ('$_GET[quest]','$_SESSION[user_id]','$_GET[num]')") or die(mysql_error());
		} else {
			$num = mysql_fetch_array(mysql_query( "SELECT num FROM quest WHERE art='$_GET[quest]' AND userid='$_SESSION[user_id]'" ));
			if ($num["num"] == ($_GET["num"] - 1)){
				mysql_query("update quest set num='$_GET[num]' where userid='$_SESSION[user_id]' and art='$_GET[quest]'") or die(mysql_error());
			}
		}
		header("Location: ../world.php");
	}
	
	//Quester
	function quest($id, $title, $text, $quest, $num, $x, $y) {
		$x = ($x * 16 ) - 8;
		$y = ($y * 16 ) - 16;
		echo '<a href="plugins/quest.php?quest=' . $quest . '&num=' . $num . '" style="position:absolute;left:' . $x . 'px;top:' . $y . 'px;">';
		echo'<img src="maps/npcs/' . $id . '.png"
		onmouseover="return overlib(' . "'";
			echo "<img src=\'maps/sprites/" . $id . ".png\'>";
			echo $text . "'" . ', CAPTION,' . "'" . $title . "'" . ');"
		onmouseout="return nd();"></a>';
	}
?>