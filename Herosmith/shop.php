<?
session_start();
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name']) && isset($_COOKIE['user_rang'])){
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['user_name'] = $_COOKIE['user_name'];
      $_SESSION['user_rang'] = $_COOKIE['user_rang'];
   }
$User_rang = $_SESSION['user_rang'];
mysql_connect("localhost","user323934","0987654321") or die("keine Verbindung möglich");
mysql_select_db("db323934-main") or die("unmöglich die datenbank zufinden");

function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	return $data;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="Designs/
<?
include 'design.php';
?>
" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
<?
include 'menu.php';
?>
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->
 <div id="page">
  <div id="content">
   <div class="post">
    <div class="title"><h2>Shoping Center</h2></div>
     <div class="entry">
      <form action="shop.php" method="post" name="logForm" id="logForm">
<?
 if($_POST["kaufen"]){
  $item_id = $_POST["kaufen"];
  $daten = mysql_query("select * from items where id='$item_id'");
  while($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)){
   $item_preis = $ausgabe["Preis"];
   $item_besitzer = $ausgabe["Besitzer"];
  }
  $daten = mysql_query("select Geld from users where id='$_SESSION[user_id]'");
  while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
   $user_Geld = $ausgabe["Geld"];
  }
  if($item_preis < $user_Geld){
   $user_Geld -= $item_preis;
   $Steuern = floor(($item_preis/10));
   $gehalt = ($item_preis - $Steuern);
  mysql_query("UPDATE users SET Geld = $user_Geld WHERE id='$_SESSION[user_name]'") or die(mysql_error());
  mysql_query("UPDATE users SET Geld = Geld + $item_preis WHERE id='$item_besitzer'") or die(mysql_error());
  mysql_query("UPDATE items SET Besitzer = $_SESSION[user_name],Ort = 1 WHERE id='$item_id'") or die(mysql_error());
  }
 }
 if($_POST["Shop"]){
  $Shop_id = $_POST["Shop"];
  $daten = mysql_query("select Name from items where Besitzer='$Shop_id' AND Art='1' AND Ort='2'");
  $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
  if (mysql_num_rows($daten)!= 0){
   echo'
       <p>Hüte:</p>
       <div style="width: 200px;overflow: auto;">
        ';
   foreach ($ausgabe as $Key){
    $daten = mysql_query("select * from Equipment where Name='$Key'");
    while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
     echo'
      <input src="/Kleider/' . $Geschlecht . '/Hut/' . $ausgabe["Name"] . '.png" name="kaufen" type="image" value="' . $ausgabe["id"] . '" alt="kaufen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
     ';
    }
   }
   echo'</div>';
  }
  $daten = mysql_query("select Name from items where Besitzer='$Shop_id' AND Art='2'  AND Ort='2'");
  $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
  if (mysql_num_rows($daten)!= 0){
   echo'
      <p>Hemden:</p>
      <div style="width: 200px;overflow: auto;">
        ';
   foreach ($ausgabe as $Key){
    $daten = mysql_query("select * from Equipment where Name='$Key'");
    while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
     echo'
      <input src="/Kleider/' . $Geschlecht . '/Hemd/' . $ausgabe["Name"] . '.png" name="kaufen" type="image" value="' . $ausgabe["id"] . '" alt="kaufen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
      ';
    }
   }
   echo'</div>';
  }
  $daten = mysql_query("select Name from items where Besitzer='$Shop_id' AND Art='3' AND Ort='2'");
  $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
  if (mysql_num_rows($daten)!= 0){ 
   echo'
      <p>Hosen:</p>
       <div style="width: 200px;overflow: auto;">
        ';
   foreach ($ausgabe as $Key){
    $daten = mysql_query("select * from Equipment where Name='$Key'");
    while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
     echo'
     <input src="/Kleider/' . $Geschlecht . '/Hose/' . $ausgabe["Name"] . '.png" name="kaufen" type="image" value="' . $ausgabe["id"] . '" alt="Kaufen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
      ';
    }
   }
   echo'</div>';
  }
  $daten = mysql_query("select Name from items where Besitzer='$Shop_id' AND Art='4' AND Ort='2'");
  $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
  if (mysql_num_rows($daten)!= 0){
   echo'
       <p>Hemden:</p>
       <div style="width: 200px;overflow: auto;">
        ';
   foreach ($ausgabe as $Key){
    $daten = mysql_query("select * from Equipment where Name='$Key'");
    while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
     echo'
      <input src="/Kleider/' . $Geschlecht . '/Schuhe/' . $ausgabe["Name"] . '.png" name="kaufen" type="image" value="' . $ausgabe["id"] . '" alt="Kaufen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
     ';
    }
   }
   echo'</div>';
  }
 } else {
  $abfrage=mysql_query("SELECT * FROM shop Where Besitzer='$_SESSION[user_id]' ORDER BY `Exp` DESC");
  if (mysql_num_rows($abfrage) == 0){
   if($_POST["erstellen"] == 'yes'){
    foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
    }
   $new_shop = $data['new_shop'];
   mysql_query("INSERT into shop (Name,Besitzer)VALUES('$new_shop','$_SESSION[user_id]')") or die(mysql_error());
   } else {
    echo '
   <p><input name="new_shop" type="text" size="50"><input name="erstellen" type="submit" value="yes"></p>
    ';
   }
  }
  $abfrage=mysql_query("SELECT * FROM shop ORDER BY `Exp` DESC");
  while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
   if (mysql_num_rows($abfrage)!= 0){
    echo '
     <input src="' . $ausgabe["img"] . '" name="Shop" type="image" value="' . $ausgabe["id"] . '" alt="in den Laden gehen" onmouseover="' . "return overlib('" . $Beschreibung . "')" . ';" onmouseout="return nd();"><br>
    ';
   }
  }
 }
?>
      </form>
     </div>
    </div>
   </div>
<?
include 'sidebar.php';
include 'footer.php';
?>
