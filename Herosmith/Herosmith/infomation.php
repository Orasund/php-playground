<?php
include 'scripts/dbc.php';
include 'Styles/settings.php';
page_protect();

$spieler_daten = mysql_query("select * from users where id='$_SESSION[user_id]'");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <title>Herosmith</title>
 <meta name="keywords" content="" />
 <meta name="description" content="" />
 <script type="text/javascript" src="overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<?
Layout();
?>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id="wrapper">
<?
Menu();
?>
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->
 <div id="page">
  <div id="content">
   <div class="post">
    <h2 class="title">
<?
while ($ausgabe = mysql_fetch_array($spieler_daten, MYSQL_ASSOC)) {
 $Staerke = $ausgabe["Staerke"];
 $Schnellichkeit = $ausgabe["Schnellichkeit"];
 $Intelligenz = $ausgabe["Intelligenz"];
 $Mut = $ausgabe["Mut"];
 if($ausgabe["Skill_points"] != 0 && $_POST["Up"]){
  $User_id = $_SESSION[user_id];
  if($_POST["Up"] == 'Staerke') {$Staerke += 100;}
  if($_POST["Up"] == 'Schnellichkeit') {$Schnellichkeit += 100;}
  if($_POST["Up"] == 'Intelligenz') {$Intelligenz += 100;}
  if($_POST["Up"] == 'Mut') {$Mut += 100;}
  $Skill_points = $ausgabe["Skill_points"] - 1;
  mysql_query("UPDATE users SET Staerke = '$Staerke',Schnellichkeit = '$Schnellichkeit',Intelligenz = '$Intelligenz',Mut = '$Mut',Skill_points = '$Skill_points' WHERE id='$User_id'") or die(mysql_error());
 } 
echo $ausgabe["user_name"] . "'s Daten</h2>"
. '<div class="entry">
    <div style="position:relative;height:100px;">
     <p>Beruf =' . $ausgabe["Beruf"] . '</p>
     <p>Geld =' . $ausgabe["Geld"] . '</p>
     <p>Leben =' . $ausgabe["Leben"] . ' von ' . $ausgabe["MaxLeben"] . '</p>
     <p>Level =' . $ausgabe["Level"] . '</p>
    </div>
    <div style="position:relative;top:-100px;left: 200px;">';
   if ($ausgabe["Skill_points"] != 0){
    echo '<form action="infomation.php" method="post" name="logForm" id="logForm">
     <p><input src="Icon/Up2.png" name="Up" type="image" value="Staerke" alt="Stärke Up">Stärke =' . $Staerke/100 . '</p>
     <p><input src="Icon/Up2.png" name="Up" type="image" value="Schnellichkeit" alt="Schnelligkeit Up">Schnelligkeit =' . $Schnellichkeit/100 . '</p>
     <p><input src="Icon/Up2.png" name="Up" type="image" value="Intelligenz" alt="Intelligenz Up">Intelligenz =' . $Intelligenz/100 . '(Intelligenz exestiert noch nicht)</p>
     <p><input src="Icon/Up2.png" name="Up" type="image" value="Mut" alt="Mut Up">Mut =' . $Mut/100 . '(Mut exestiert noch nicht)</p>
    </form>';
   } else {
    echo '
     <p>Stärke =' . $ausgabe["Staerke"]/100 . '</p>
     <p>Schnelligkeit =' . $ausgabe["Schnellichkeit"]/100 . '</p>
     <p>Intelligenz =' . $ausgabe["Intelligenz"]/100 . '</p>
     <p>Mut =' . $ausgabe["Mut"]/100 . '</p>
     <br>
    ';
   }
 $Haare = $ausgabe["Haare"];
 $Geschlecht = $ausgabe["Geschlecht"];
 $Hut = $ausgabe["Hut"];
 $Hemd = $ausgabe["Hemd"];
 $Hose = $ausgabe["Hose"];
 $Schuhe = $ausgabe["Schuhe"];
}
render_char($Haare,$Geschlecht,$Hut,$Hemd,$Hose,$Schuhe);
 echo '
     <div style="position:relative;left: -200px;top:-100px;width: 200px;">
      <p><h2>Inventar</h2></p>
      <form action="infomation.php" method="post" name="logForm" id="logForm">
      <p>Hüte:</p>
      <div style="width: 200px;overflow: auto;">
        ';
 $daten = mysql_query("select Name from items where Besitzer='$_SESSION[user_id]' AND Art='1'");
 $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
if (mysql_num_rows($daten)!= 0){
 foreach ($ausgabe as $Key){
  $daten = mysql_query("select * from Equipment where Name='$Key'");
  while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
   echo'
      <input src="/Kleider/' . $Geschlecht . '/Hut/' . $ausgabe["Name"] . '.png" name="Anziehen_Hut" type="image" value="' . $ausgabe["Name"] . '" alt="Hut anziehen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
   ';
  }
 }
}
echo'
       </div>
      <p>Hemden:</p>
      <div style="width: 200px;overflow: auto;">
        ';
 $daten = mysql_query("select Name from items where Besitzer='$_SESSION[user_id]' AND Art='2'");
 $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
if (mysql_num_rows($daten)!= 0){
 foreach ($ausgabe as $Key){
  $daten = mysql_query("select * from Equipment where Name='$Key'");
  while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
   echo'
      <input src="/Kleider/' . $Geschlecht . '/Hemd/' . $ausgabe["Name"] . '.png" name="Anziehen_Hemd" type="image" value="' . $ausgabe["Name"] . '" alt="Hemd anziehen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
   ';
  }
 }
}
echo'
       </div>
      <p>Hosen:</p>
      <div style="width: 200px;overflow: auto;">
        ';
 $daten = mysql_query("select Name from items where Besitzer='$_SESSION[user_id]' AND Art='3'");
 $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
if (mysql_num_rows($daten)!= 0){
 foreach ($ausgabe as $Key){
  $daten = mysql_query("select * from Equipment where Name='$Key'");
  while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
   echo'
      <input src="/Kleider/' . $Geschlecht . '/Hose/' . $ausgabe["Name"] . '.png" name="Anziehen_Hose" type="image" value="' . $ausgabe["Name"] . '" alt="Hose anziehen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
   ';
  }
 }
}
echo'
       </div>
      <p>Schuhe:</p>
      <div style="width: 200px;overflow: auto;">
        ';
 $daten = mysql_query("select Name from items where Besitzer='$_SESSION[user_id]' AND Art='4'");
 $ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC);
if (mysql_num_rows($daten)!= 0){
 foreach ($ausgabe as $Key){
  $daten = mysql_query("select * from Equipment where Name='$Key'");
  while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
   echo'
      <input src="/Kleider/' . $Geschlecht . '/Schuhe/' . $ausgabe["Name"] . '.png" name="Anziehen_Schuhe" type="image" value="' . $ausgabe["Name"] . '" alt="Schuhe anziehen" onmouseover="' . "return overlib('Preis:" . $ausgabe["Preis"] . "<br>Stärke:" . $ausgabe["Staerke"] . "<br>Schnelligkeit:" . $ausgabe["Schnelligkeit"] . "<br>Intelligenz:" . $ausgabe["Intelligenz"] . "<br>Mut:" . $ausgabe["Mut"] . "<br>Gewicht:" . $ausgabe["Gewicht"] . "', CAPTION, '" . $ausgabe["Name"] . "')" . ';" onmouseout="return nd();">
   ';
  }
 }
}
echo'
       </div>
      </form>
     </div>
    </div>
   </div>';
?>
   </div>
  </div>
<?
Sidebar();
Footer();
?>
