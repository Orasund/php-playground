<?php
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	
	//item bekommen
	if(isset($_GET["id"])){$id = $_GET["id"];} else {$id = 0;}
	$fetch = mysql_query("SELECT * FROM items WHERE id='$id' AND count='1' AND user='$user_id'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	if($num != 1){echo 1;exit();}//dieses Item exestiert
	while($output = mysql_fetch_array($fetch)){
		$typ = $output["typ"] - 2;
		$level = $output["level"];
		$status = $output["status"];
		$life = $output["life"];
	}
	if($level == 3){echo 1;exit();} //Kein Upgrade vorhanden
	if($life == 8){ //Upgrade
		if($typ == -2){exit();}
		$stone = 2;
		$material = 2;
		if($typ == 0){$material += $stone;}
		
		/***Mineral***/
		
			$fetch = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='$typ' AND user='$user_id'") or die(mysql_error());
			$num = mysql_num_rows($fetch);
			if($num <= 0){ echo 2; exit();} //Resource gibt es nicht
			list($m_count,$m_id) = mysql_fetch_row($fetch); //Anzahl und Id
			if($m_count >= $material){$m_count -= $material;} else {echo 2; exit();}

		
		/***Steinholz***/
		$fetch2 = mysql_query("SELECT * FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error());
		$num2 = mysql_num_rows($fetch2);
		if($num2 <= 0){ echo 3; exit();} //Steinholz gibt es nicht
		list($st_count,$st_id) = mysql_fetch_row($fetch2); //Anzahl und Id
		if($st_count >= $material){$st_count -= $material;} else {echo 2; exit();}
		
		/***Mineralien und Steinholz abziehen***/
		if($m_count > 0){
			mysql_query("UPDATE items SET count='$m_count' WHERE id='$m_id'") or die(mysql_error());
		} else {
			mysql_query("DELETE FROM items WHERE id='$m_id'") or die(mysql_error());
		}
		if($typ != 0){
			if($st_count > 0){
				mysql_query("UPDATE items SET count='$st_count' WHERE id='$st_id'") or die(mysql_error());
			} else {
				mysql_query("DELETE FROM items WHERE id='$st_id'") or die(mysql_error());
			}
		}
		
		$level++; //Das eigentliche Upgraden
		mysql_query("UPDATE items SET level='$level' WHERE id='$id'") or die(mysql_error());
		echo 0;
		
	} else { //Repair!
		$stone = 1;
		$material = 1;
		$life += 2;
		if($typ == 0){$material += $stone;}
		if($typ == -2){$stone == 4;}
		
		/***Mineral***/
		if($typ != -2){
			$fetch = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='$typ' AND user='$user_id'") or die(mysql_error());
			$num = mysql_num_rows($fetch);
			if($num <= 0){ echo 2; exit();} //Resource gibt es nicht
			list($m_count,$m_id) = mysql_fetch_row($fetch); //Anzahl und Id
			if($m_count >= $material){$m_count -= $material;} else {echo 2; exit();}
		}
		
		/***Steinholz***/
		$fetch2 = mysql_query("SELECT count,id FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error());
		$num2 = mysql_num_rows($fetch2);
		if($num2 <= 0){ echo 3; exit();} //Steinholz gibt es nicht
		list($st_count,$st_id) = mysql_fetch_row($fetch2); //Anzahl und Id
		if($st_count >= $material){$st_count -= $stone;} else {echo 2; exit();}
		
		/***Mineralien und Steinholz abziehen***/
		if($typ != -2){
			if($m_count > 0){
				mysql_query("UPDATE items SET count='$m_count' WHERE id='$m_id'") or die(mysql_error());
			} else {
				mysql_query("DELETE FROM items WHERE id='$m_id'") or die(mysql_error());
			}
		}
		if($typ != 0){
			if($st_count > 0){
				mysql_query("UPDATE items SET count='$st_count' WHERE id='$st_id'") or die(mysql_error());
			} else {
				mysql_query("DELETE FROM items WHERE id='$st_id'") or die(mysql_error());
			}
		}
		
		mysql_query("UPDATE items SET life='$life' WHERE id='$id'") or die(mysql_error());
	}
?>