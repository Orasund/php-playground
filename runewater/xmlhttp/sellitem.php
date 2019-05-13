<?
	include 'dbc.php';
	page_protect();
	$user_id = $_SESSION['user_id'];
	$user_island = $_SESSION['user_island'];
	$item = $_GET["id"];
	if(isset($_GET["price"])){$price = $_GET["price"];} else {$price = 0;}
	if(isset($_GET["typ"])){$typ = $_GET["typ"];} else {$typ = 0;}
	//zuerst wird gesehen ob das item exestiert/ zum verkauf steht
	$fetch = mysql_query("SELECT status,price FROM items WHERE id='$item' AND user='$user_id'") or die(mysql_error());
	$num = mysql_num_rows($fetch);
	if($num > 0){//ja, ein solches Item exestiert
		list($status,$price_new) = mysql_fetch_row($fetch);
		if($price == 0){$price = $price_new;}
		if($status == 0){
			mysql_query("UPDATE items SET status='1', price='$price' WHERE id='$item'") or die(mysql_error());
		} else if($status > 1){
			mysql_query("UPDATE items SET status='1' WHERE id='$item'") or die(mysql_error());
		} else {
			if($typ == 2){ //Ins Lager Legen
				//echo "user_island: " . $user_island . "<br>";
				$status = 2 + $user_island;
				//echo "status: " . $status . "<br>";
				mysql_query("UPDATE items SET status='$status' WHERE id='$item'") or die(mysql_error());
			} else {mysql_query("UPDATE items SET status='0' WHERE id='$item'") or die(mysql_error());}
		}
		echo 0;
	}else{
		echo 1;
	}
?>