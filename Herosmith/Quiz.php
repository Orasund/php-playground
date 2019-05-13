<?php
//Daten übertragungen
mysql_connect("localhost","user323934","0987654321") or die("keine Verbindung möglich");
mysql_select_db("db323934-main") or die("unmöglich die datenbank zufinden");

/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/
session_start();

//check for cookies

if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['user_name'] = $_COOKIE['user_name'];
   }


if (!isset($_SESSION['user_id']))
{
header("Location: login.php");
}

/*******************END********************************/
function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	$data = mysql_real_escape_string($data);
	
	return $data;
}

function testen($id,$Ausgaben) {
 foreach($_POST as $key => $value) {
  $data[$key] = filter($value);
 }
 $Antwort = $data['SkillSelect'];
 echo '<p>$id' . $id . '</p>';
 echo '<p>$Antwort' . $Antwort . '</p>';
 if ($id == 1) {
  echo '<p>$Ausgaben' . $Ausgaben[1] . '</p>';
  $Richtig = $Ausgaben[1]; 
 }
 if ($id == 2) {
  echo '<p>$Ausgaben' . $Ausgaben[2] . '</p>';
  $Richtig = $Ausgaben[2]; 
 }
 if ($id == 3) {
  echo '<p>$Ausgaben' . $Ausgaben[3] . '</p>';
  $Richtig = $Ausgaben[3]; 
 }
 if ($Antwort == $Richtig) {
  echo "Die Antwort ist Richtig";
 } else {
  echo "Die Antwort ist Falsch";
 }
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<link href="mainstyle.css" rel="stylesheet" type="text/css" media="screen" />
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
    <h2 class="title">Beantworte eine Frage</h2>
    <form action="Quiz.php" method="post" name="logForm" id="logForm" >
<?
 $abfrage=mysql_query("select * from Quiz where Gruppe='1' ORDER BY RAND() LIMIT 1");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  echo "<p>" . $ausgabe["Frage"] . '</p>
  <p><select name="SkillSelect" size="3">
   <option>' . $ausgabe["Antwort1"] . '</option>
   <option>' . $ausgabe["Antwort2"] . '</option>
   <option>' . $ausgabe["Antwort3"] . '</option>
  </select></p>';
  $Ausgaben = array ($ausgabe["Antwort1"], $ausgabe["Antwort2"], $ausgabe["Antwort3"]);
  $id = $ausgabe["id"];
 }
 echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Absenden"></p>';

 if ($_POST['doLogin']=='Absenden')
 {
  testen($id,$Ausgaben);
 }
?>
    </form>
  </div>
 </div>
<?
include 'sidebar.php';
include 'footer.php';
?>
