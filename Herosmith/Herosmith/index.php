<?
include 'Styles/settings.php';

session_start();
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name']) && isset($_COOKIE['user_rang'])){
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['user_name'] = $_COOKIE['user_name'];
      $_SESSION['user_rang'] = $_COOKIE['user_rang'];
   }
$User_rang = $_SESSION['user_rang'];
mysql_connect("localhost","user323934","*ekat00*") or die("keine Verbindung möglich");
mysql_select_db("db323934-main") or die("unmöglich die datenbank zufinden");
$abfrage=mysql_query("SELECT * FROM News ORDER BY `datum` DESC");

function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	return $data;
}

function News($abfrage,$User_rang) {
  if($User_rang == 3 && $_POST["addnews"] == 'Hinzufügen'){
  foreach($_POST as $key => $value) {
   $data[$key] = $value;
  }
  mysql_query("INSERT into News (id,Nachricht,datum,Uberschrift)VALUES('$data[id]','$data[Nachricht]',now(),'$data[Uberschrift]')") or die(mysql_error());
 }
 if($User_rang == 3 && $_POST["edit"] == 'ändern'){
  foreach($_POST as $key => $value) {
   $data[$key] = $value;
  }
  $News_id = $data['id'];
  $News_Nachricht = $data['Nachricht'];
  mysql_query("UPDATE News SET Nachricht = '$News_Nachricht' WHERE id='$News_id'") or die(mysql_error());
 }
 while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
	if($User_rang == 3 && $_POST["Hinzufügen"] == $ausgabe["id"]){
  		echo '<p>Schreib immer vor einem Text ein<noscript><p></noscript> und danach ein <noscript><p></noscript>. Fals dich das ein wenig verwirrt, schau nach wie die anderen News geschrieben worden sind.</p>
  			<form action="index.php" method="post" name="logForm" id="logForm">
  				<h2><input name="Uberschrift" type="text" maxlength="50" ></h2>
 				<p><textarea name="Nachricht" rows="5" cols="70"></textarea></p>
  				<p><input name="addnews" type="submit" value="Hinzufügen"></p>
  			</form>
		';
 	}
 	if($User_rang == 3 && $_POST["Löschen"] == $ausgabe["id"]){
  		mysql_query("DELETE FROM News WHERE id='$ausgabe[id]'") or die(mysql_error());
 	} 
 	echo '<div class="post">
 		<div class="title"><form action="index.php" method="post" name="logForm" id="logForm"><h2>
	';
 	if($User_rang == 3){
  		echo '<input src="Icon/add.png" name="Hinzufügen" type="image" value="' . $ausgabe["id"] . '" alt="Hinzufügen">
 			<input src="Icon/delete.png" name="Löschen" type="image" value="' . $ausgabe["id"] . '" alt="Löschen">
 		 	<input src="Icon/edit.png" name="Bearbeiten" type="image" value="' . $ausgabe["id"] . '" alt="Bearbeiten">
		';
 	}
 	echo $ausgabe["Uberschrift"] . '</h2></form></div>
 		<p class="date">' . $ausgabe["datum"] . '</p>
 		<div class="entry">
	';
 	if($User_rang == 3 && $_POST["Bearbeiten"] == $ausgabe["id"]){
  		echo '<p>Schreib immer vor einem Text ein<noscript><p></noscript> und danach ein <noscript><p></noscript>. Fals dich das ein wenig verwirrt, schau nach wie die anderen News geschrieben worden sind.</p>
  			 <form action="index.php" method="post" name="logForm" id="logForm">
   			<input type="hidden" name="id" value="' . $ausgabe["id"] . '">
   			<p><textarea name="Nachricht" rows="5" cols="70">' . $ausgabe["Nachricht"] . '</textarea></p>
   			<p><input name="edit" type="submit" value="ändern"></p>
   			</form>
		';
 	} else {
  		echo "<p>" . $ausgabe["Nachricht"] . "</p>";
 	}
 	echo '</div>
 		</div>
	';
 }
}
echo '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
';
Layout();
echo '
<div id="wrapper">
';
Menu();
echo '
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->
 <div id="page">
  <div id="content">
';
News($abfrage,$User_rang);
echo '
 </div>
';
Sidebar();
Footer();
?>
