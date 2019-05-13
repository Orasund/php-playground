<?php
include 'dbc.php';
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
<link href="Designs/
<?
include 'design.php';
?>
" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
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
$daten = mysql_query("select * from Equipment where Name='$Hut'");
while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
 $Hut_info = array (1 => $ausgabe["Preis"], 2 => $ausgabe["Staerke"],3 => $ausgabe["Schnelligkeit"],4 => $ausgabe["Intelligenz"],5 => $ausgabe["Mut"],6 => $ausgabe["Gewicht"]);
}
$daten = mysql_query("select * from Equipment where Name='$Hemd'");
while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
 $Hemd_info = array (1 => $ausgabe["Preis"], 2 => $ausgabe["Staerke"],3 => $ausgabe["Schnelligkeit"],4 => $ausgabe["Intelligenz"],5 => $ausgabe["Mut"],6 => $ausgabe["Gewicht"]);
}
$daten = mysql_query("select * from Equipment where Name='$Hose'");
while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
 $Hose_info = array (1 => $ausgabe["Preis"], 2 => $ausgabe["Staerke"],3 => $ausgabe["Schnelligkeit"],4 => $ausgabe["Intelligenz"],5 => $ausgabe["Mut"],6 => $ausgabe["Gewicht"]);
}
$daten = mysql_query("select * from Equipment where Name='$Schuhe'");
while ($ausgabe = mysql_fetch_array($daten, MYSQL_ASSOC)) {
 $Schuhe_info = array (1 => $ausgabe["Preis"], 2 => $ausgabe["Staerke"],3 => $ausgabe["Schnelligkeit"],4 => $ausgabe["Intelligenz"],5 => $ausgabe["Mut"],6 => $ausgabe["Gewicht"]);
}
if($_POST["Ausziehen"]){
 if($_POST["Ausziehen"] == "Hut"){
  mysql_query("INSERT into items (Besitzer,Name,Art,Ort)VALUES('$_SESSION[user_id]','$Hut','1','1')") or die(mysql_error());
  mysql_query("UPDATE users SET Hut = '' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
  $Hut = "";
 }
 if($_POST["Ausziehen"] == "Hemd"){
  mysql_query("INSERT into items (Besitzer,Name,Art,Ort)VALUES('$_SESSION[user_id]','$Hemd','2','1')") or die(mysql_error());
  mysql_query("UPDATE users SET Hemd = '' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
  $Hemd = "";
 }
 if($_POST["Ausziehen"] == "Hose"){
  mysql_query("INSERT into items (Besitzer,Name,Art,Ort)VALUES('$_SESSION[user_id]','$Hose','3','1')") or die(mysql_error());
  mysql_query("UPDATE users SET Hose = '' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
  $Hose = "";
 }
 if($_POST["Ausziehen"] == "Schuhe"){
  mysql_query("INSERT into items (Besitzer,Name,Art,Ort)VALUES('$_SESSION[user_id]','$Schuhe','4','1')") or die(mysql_error());
  mysql_query("UPDATE users SET Schuhe = '' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
  $Schuhe = "";
 }
}
if($_POST["Anziehen_Hut"]){
 $Hut = $_POST["Anziehen_Hut"];
 mysql_query("DELETE FROM items WHERE Name='$Hut'") or die(mysql_error());
 mysql_query("UPDATE users SET Hut = '$Hut' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
}
if($_POST["Anziehen_Hemd"]){
 $Hemd = $_POST["Anziehen_Hemd"];
 mysql_query("DELETE FROM items WHERE Name='$Hemd'") or die(mysql_error());
 mysql_query("UPDATE users SET Hemd = '$Hemd' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
}
if($_POST["Anziehen_Hose"]){
 $Hose = $_POST["Anziehen_Hose"];
 mysql_query("DELETE FROM items WHERE Name='$Hose'") or die(mysql_error());
 mysql_query("UPDATE users SET Hose = '$Hose' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
}
if($_POST["Anziehen_Schuhe"]){
 $Schuhe = $_POST["Anziehen_Schuhe"];
 mysql_query("DELETE FROM items WHERE Name='$Schuhe'") or die(mysql_error());
 mysql_query("UPDATE users SET Schuhe = '$Schuhe' WHERE id='$_SESSION[user_id]'") or die(mysql_error());
}
    echo'
     <div style="padding:0px;height:80px;width:80px;overflow:hidden;">
      <div style="background-image:url(Kleider/' . $Geschlecht . '/Haare/' . $Haare . '.png);">
       <form action="infomation.php" method="post" name="logForm" id="logForm">';
if($Hut){
        echo '<input src="/Kleider/' . $Geschlecht . '/Hut/' . $Hut . '.png" name="Ausziehen" type="image" value="Hut" alt="Hut ausziehen" onmouseover="' . "return overlib('Preis:" . $Hut_info[1] . "<br>Stärke:" . $Hut_info[2] . "<br>Schnelligkeit:" . $Hut_info[3] . "<br>Intelligenz:" . $Hut_info[4] . "<br>Mut:" . $Hut_info[5] . "<br>Gewicht:" . $Hut_info[6] . "', CAPTION, '" . $Hut . "')" . ';" onmouseout="return nd();"><br>';
} else {
	echo '<img src="/Kleider/' . $Geschlecht . '/Hut/Leer.png">';
}
if($Hemd){
        echo'
        <input src="/Kleider/' . $Geschlecht . '/Hemd/' . $Hemd . '.png" name="Ausziehen" type="image" value="Hemd" alt="Hemd ausziehen" onmouseover="' . "return overlib('Preis:" . $Hemd_info[1] . "<br>Stärke:" . $Hemd_info[2] . "<br>Schnelligkeit:" . $Hemd_info[3] . "<br>Intelligenz:" . $Hemd_info[4] . "<br>Mut:" . $Hemd_info[5] . "<br>Gewicht:" . $Hemd_info[6] . "', CAPTION, '". $Hemd . "')" . ';" onmouseout="return nd();"><br>';
} else {
	echo '<img src="/Kleider/' . $Geschlecht . '/Hemd/Leer.png">';
}
if($Hose){
        echo'
        <input src="/Kleider/' . $Geschlecht . '/Hose/' . $Hose . '.png" name="Ausziehen" type="image" value="Hose" alt="Hose ausziehen" onmouseover="' . "return overlib('Preis:" . $Hose_info[1] . "<br>Stärke:" . $Hose_info[2] . "<br>Schnelligkeit:" . $Hose_info[3] . "<br>Intelligenz:" . $Hose_info[4] . "<br>Mut:" . $Hose_info[5] . "<br>Gewicht:" . $Hose_info[6] . "', CAPTION, '". $Hose . "')" . ';" onmouseout="return nd();"><br>';
} else {
	echo '<img src="/Kleider/' . $Geschlecht . '/Hose/Leer.png">';
}
if($Schuhe){
        echo'
        <input src="/Kleider/' . $Geschlecht . '/Schuhe/' . $Schuhe . '.png" name="Ausziehen" type="image" value="Schuhe" alt="Schuhe ausziehen" onmouseover="' . "return overlib('Preis:" . $Schuhe_info[1] . "<br>Stärke:" . $Schuhe_info[2] . "<br>Schnelligkeit:" . $Schuhe_info[3] . "<br>Intelligenz:" . $Schuhe_info[4] . "<br>Mut:" . $Schuhe_info[5] . "<br>Gewicht:" . $Schuhe_info[6] . "', CAPTION, '". $Schuhe . "')" . ';" onmouseout="return nd();">';
} else {
	echo '<img src="/Kleider/' . $Geschlecht . '/Schuhe/Leer.png">';
}
        echo'
       </form>
      </div>
     </div>
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
include 'sidebar.php';
include 'footer.php';
?>
