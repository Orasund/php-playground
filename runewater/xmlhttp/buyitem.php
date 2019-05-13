<?
	/*******************************************************************
	1.	Also, zuerst Runenstein von dir und den Preis des Items bestimmen
	2.	Schauen ob genug Runenstein vorhanden
	3.	Preis abziehen
	4.	Benützer des Names ändern.
		eventuell auch anzahl verändern oder anzahl erhöhen,
		falls Item schon vorhanden
	*******************************************************************/
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	
	//OKEY; ROCK THIS PARTY!
	$item = $_GET["id"];
	
	//$money  zeigt die Anzahl des Runenstein
	$fetch = mysql_query("SELECT * FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error()); //Steinholz
	while($output = mysql_fetch_array($fetch)){$money = $output["count"];}
	
	//nun holen wir uns das Item
	$fetch = mysql_query("SELECT * FROM items WHERE id='$item' AND status='1'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	if($num > 0){
		while($output = mysql_fetch_array($fetch)){
			$price = $output["price"]; //$price bestimmt den Verkaufspreis
			$typ = $output["typ"];
			$level = $output["level"];
			$seller = $output["user"];
			$count = $output["count"] - 1; //Die Anzahl, erst später wichtig
		}
		if($money >= $price){
			
			//Geld wird abgezogen
			if($money > 0){
				$money -= $price;//Geld wird abgezogen
				//Das eigendliche abziehen
				mysql_query("UPDATE items SET count='$money' WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error());
			} else {
				//Kein Geld mehr?
				mysql_query("DELETE FROM items WHERE typ='1' AND level='0' AND user='$user_id'") or die(mysql_error());
			}
			
			//Geld wird hinzugefügt
			$fetch = mysql_query("SELECT * FROM items WHERE typ='1' AND level='0' AND user='$seller'") or die(mysql_error()); //Steinholz
			$num = mysql_num_rows($fetch);
			if($num > 0){
				//$his_money bestimmt den Wert des verkäufers
				while($output = mysql_fetch_array($fetch)){$his_money = $output["count"];}
				$his_money += $price;
				
				//Das eigendliche Hinzufügen
				mysql_query("UPDATE items SET count='$his_money' WHERE typ='1' AND level='0' AND user='$seller'") or die(mysql_error());
			} else {
				//Kein Geld?
				mysql_query("INSERT INTO items (`typ`,`level`,`user`,`count`) VALUES ('1','0','$seller','$price')") or die(mysql_error());
			}
			
			/************************************************/
			/**************DAS HINZUFÜGEN*************/
			//Das alte Item verliert ein exemplar
			if($count == 0 && $typ != 1){//Nur noch 1 exemplar und nicht stackable.(schwerter und so)
				mysql_query("UPDATE items SET status='0',user='$user_id' WHERE id='$item'") or die(mysql_error());
			} else {
				if($count > 0){
					//Noch was da, dann nur eines entfernen
					mysql_query("UPDATE items SET count='$count' WHERE id='$item'") or die(mysql_error());
				} else {
					//sonst weg damit.
					mysql_query("DELETE FROM items WHERE id='$item'") or die(mysql_error());
				}
				
				//Exestiert das neue Item vielleicht schon?
				$fetch = mysql_query("SELECT * FROM items WHERE typ='$typ' AND level='$level' AND user='$user_id'") or die(mysql_error()); //Steinholz
				$num = mysql_num_rows($fetch);
				if($num > 0){
					//Ja, exestiert. 
					while($output = mysql_fetch_array($fetch)){
						$its_num = $output["count"] + 1; //dessen anzahl
						$new_id = $output["id"]; //dessen Id
					}
					//nun hinzufügen
					mysql_query("UPDATE items SET count='$its_num' WHERE id='$new_id'") or die(mysql_error());
				} else {
					//Nein, neu hinzufügen
					mysql_query("INSERT INTO items (`typ`,`level`,`user`) VALUES ('$typ','$level','$user_id')") or die(mysql_error());
				}
				
			}
			echo 0;//WOW, geschafft!
		} else {
			echo 2; //Error: Zu wenig Geld!
		}
	} else {
		echo 1; //Error: Item exestiert nicht mehr
	}
?>