<?
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

function DatenAbfragen($QName,$QLevel){
 $abfrage = mysql_query("select * from Quest where Name='$QName'") or die(mysql_error());  
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  if ($QLevel == 1) {
   $Text = $ausgabe["Text1"];
   $Aufgabe = $ausgabe["Aufgabe1"];    
  }
  if ($QLevel == 2) {
   $Text = $ausgabe["Text2"];
   $Aufgabe = $ausgabe["Aufgabe2"];    
  }
  if ($QLevel == 3) {
   $Text = $ausgabe["Text3"];
   $Aufgabe = $ausgabe["Aufgabe3"];    
  }
  if ($QLevel == 4) {
   $Text = $ausgabe["Text4"];
   $Aufgabe = $ausgabe["Aufgabe4"];    
  }
  if ($QLevel == 5) {
   $Text = $ausgabe["Text5"];
   $Aufgabe = $ausgabe["Aufgabe5"];    
  }
  if ($QLevel == 6) {
   $Text = $ausgabe["Text6"];
   $Aufgabe = $ausgabe["Aufgabe6"];    
  }
  if ($QLevel == 7) {
   $Text = $ausgabe["Text7"];
   $Aufgabe = $ausgabe["Aufgabe7"];    
  }
  if ($QLevel == 8) {
   $Text = $ausgabe["Text8"];
   $Aufgabe = $ausgabe["Aufgabe8"];    
  }
  if ($QLevel == 9) {
   $Text = $ausgabe["Text9"];
   $Aufgabe = $ausgabe["Aufgabe9"];    
  }
  if ($QLevel == 10) {
   $Text = $ausgabe["Text10"];
   $Aufgabe = $ausgabe["Aufgabe10"];    
  }
  echo '<h2 class="title">' . $Text . '</h2>';
 }
 return $Aufgabe;
}

function Check($User_id){
 $abfrage = mysql_query("select * from users where id='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $QName = $ausgabe["QName"];
  $QLevel = $ausgabe["QLevel"];
  $Leben = $ausgabe["Leben"];
  $Rang = $ausgabe["Rang"];
 }
 // Wenn Gerade in einer Quest: Quest einleiten
 if ($QName) {
  $Aufgabe = DatenAbfragen($QName,$QLevel);
  $abfrage = mysql_query("select * from Quest where Name='$QName'") or die(mysql_error());  
  while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
   $Grad = $ausgabe["Grad"];
   $Preis = $ausgabe["Preis"];
  }
  // Appear = Monster beschwören
  if ($Aufgabe == "Appear(2)") {
   //Checken ob ein Kampf am laufen ist
   $rs_duplicate = mysql_query("select count(*) as total from Saver where Player_ID='$User_id'") or die(mysql_error());
   list($total) = mysql_fetch_row($rs_duplicate);
   if ($total > 0){
    //Wenn ja, dann erscheinen.
    Monster_erscheinen($User_id);
    if ($_POST['doLogin']=='Angriff')
    {
     $next = Angriff($User_id,$monster_id,$Preis,$Grad);
     if($next == 1){
      echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Weiter" ></p>';
     }
     if($next == 2){
      echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Zurück"></p>';
     }
     if($next == 0){
      echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Angriff"></p>';
     }
    } else {
     echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Angriff"></p>';
    }
   } else {
    //Wenn nein, dann einen neuen Kampf eröffnen
    $abfrage = mysql_query("select * from Monster where Rang='$Grad' ORDER BY RAND() LIMIT 1");
    while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
    //Name und Leben abfragen
     $monster = $ausgabe["Name"];
     $Monster_Leben = $ausgabe["Leben"];
    }
    mysql_query("INSERT into Saver (Player_ID,Monster_Name,Player_Leben,Monster_Leben)VALUES('$User_id','$monster','$Leben','$Monster_Leben')") or die(mysql_error());
    Monster_erscheinen($User_id);
 
    echo '<p><input name="doLogin" type="submit" id="doLogin3" value="Angriff"></p>';
   }
  }
 } else {
  echo '<h2 class="title">Questmanager</h2>
  <p><select name="SkillSelect" size="5">';
  $abfrage = mysql_query("select * from Quest where Grad='$Rang'");
  while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
   echo '<option>' . $ausgabe["Name"] . '</option>';
  }
  echo '</select></p>
  <p><input name="doLogin2" type="submit" id="doLogin3" value="Annehmen"></p>';
  $abfrage = mysql_query("select * from Quest where Grad='$Rang'");
  while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
   echo '<p>Name:' . $ausgabe["Name"]  . '</p>
   <p>Beschreibung:' . $ausgabe["Beschreibung"] . '</p>';
  }
 }
}
/*******************END********************************/
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
    <form action="Quest.php" method="post" name="logForm" id="logForm" >
<?
 if ($_POST['doLogin2']=='Annehmen')
 {
  foreach($_POST as $key => $value) {
   $data[$key] = filter($value);
  }
  mysql_query("UPDATE users SET QName = '$data[SkillSelect]',QLevel = 1 WHERE id='$_SESSION[user_id]'") or die(mysql_error());
 }
 Check($User_id);

?>
    </form>
   </div>
  </div>
<?
include 'sidebar.php';
include 'footer.php';
?>
