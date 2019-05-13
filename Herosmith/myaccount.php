<?
session_start();
mysql_connect("localhost","user323934","0987654321") or die("keine Verbindung möglich");
mysql_select_db("db323934-main") or die("unmöglich die datenbank zufinden");
$abfrage=mysql_query("SELECT * FROM News ORDER BY `datum` DESC");
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
<?
while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
echo '<div class="post">
<h2 class="title">' . $ausgabe["Uberschrift"] . '</h2>
<p class="date">' . $ausgabe["datum"] . '</p>
<div class="entry">' . $ausgabe["Nachricht"] . '</div>
</div>';
}
?>
 </div>
<?
include 'sidebar.php';
include 'footer.php';
?>
