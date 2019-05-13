<?
include 'scripts/dbc.php';
	$abfrage=mysql_query("SELECT * FROM shop ORDER BY `Exp` DESC");
	while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
		$shop_info = array (1 => $ausgabe["id"], 2 => $ausgabe["Name"],3 => $ausgabe["img"],4 => $ausgabe["Exp"],5 => $ausgabe["Beschreibung"]);
	}
	if($_POST["Shop"]){
		$Shop_id = $_POST["Shop"];
		$abfrage = mysql_query("SELECT * FROM items where Besitzer='$Shop_id' AND Ort='2'");
  		while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
			$item_info = array (1 => $ausgabe["Name"],2 => $ausgabe["Preis"],3 => $ausgabe["Art"],4 => $ausgabe["Ort"]);
  		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<? Layout(); ?>
<div id="wrapper">
<? Menu(); ?>
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->
 <div id="page">
  <div id="content">
<?
	if($_POST){
		if($_POST["Shop"]){
			foreach ($item_info["1"] as $ausgabe["1"]){
				foreach ($item_info["2"] as $ausgabe["2"]){
					echo 
									$ausgabe["1"] . "," . $ausgabe["2"]
    							';
							}
						}
					}
				}
			}
		}
	} else {
		foreach ($shop_info["1"] as $ausgabe["1"]){
			foreach ($shop_info["2"] as $ausgabe["2"]){
				foreach ($shop_info["3"] as $ausgabe["3"]){
					foreach ($shop_info["4"] as $ausgabe["4"]){
						foreach ($shop_info["5"] as $ausgabe["5"]){
    						echo '
     <input src="' . $ausgabe["3"] . '" name="Shop" type="image" value="' . $ausgabe["1"] . '" alt="in den Laden gehen">' . $ausgabe["2"] .'<br>' . $ausgabe["5"] . '<br>
    						';
						}
					}
				}
			}
		}
	}
?>
 </div>
<?
Sidebar();
Footer();
?>