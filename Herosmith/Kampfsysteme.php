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
$User_id = $_SESSION['user_id'];

include 'Kampfsystem.php';
/*******************END********************************/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
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
    <h2 class="title">Monster taucht auf</h2>
    <form action="Kampfsysteme.php" method="post" name="logForm" id="logForm" >
<?
Monster_erscheinen($User_id);
 if ($_POST['doLogin']=='Angriff')
 {
  $next = Angriff($User_id,$monster_id);
  echo "<p>Test<p>";
  echo "<p>Next Quest:" . $next . "<p>";
  if($next == 1){
   echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Weiter" onClick="parent.location='Quest.html'"></p>';
  }
  if($next == 2){
   echo '<p><input name="doLogin" type="button" id="doLogin3" value="Zurück" onClick="parent.location='Quest.html'"></p>';
  }
 } else {
   echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Angriff"></p>';
 }
?>
    </form>
  </div>
 </div>
<?
include 'sidebar.php';
include 'footer.php';
?>


