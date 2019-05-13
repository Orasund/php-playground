<?
function NextY($wert){
 $Zaehler = 1;
 $addexp = 1;
 while ($Zaehler != $wert){
  $addexp += $Zaehler;
  $Zaehler += 1;
 }
 return $addexp;
}

echo ' <div id="sidebar">
  <ul>';
if(isset($_SESSION['user_id']))
{
 $User_id = $_SESSION['user_id'];
 $abfrage = mysql_query("select * from users where id='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
 // $lastTime = $ausgabe["lastTime"];
  $heute = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
  $Leben = $ausgabe["Leben"];
  $MaxLeben = $ausgabe["MaxLeben"];
 // if (!$lastTime) $lastTime = $heute;
 // while ($lastTime < $heute) {
 //  $lastTime = mktime(0, 0, 0, date("m",$lastTime)  , date("d",$lastTime)+1, date("Y",$lastTime));
 //  if ($Leben < $MaxLeben){
 //   $Leben += 100;
 //  }
 // }
 // mysql_query("UPDATE users SET Leben = '$Leben',lastTime ='$lastTime' WHERE id='$User_id'") or die(mysql_error());
  echo "
   <li>
    <h2>" . $ausgabe["user_name"] . "'s Daten
  ";
  if ($ausgabe["Skill_points"] != 0){
   echo '
     (' . $ausgabe["Skill_points"] . '<a href="infomation.php"><img src="/Icon/Up2.png"></a>)
   ';
  } 
  echo '
    </h2>
     <div style="padding:0px;height:80px;width:80px;overflow:hidden;">
      <div style="background-image:url(Kleider/' . $ausgabe["Geschlecht"] . '/Haare/' . $ausgabe["Haare"] . '.png);">';
 if($ausgabe["Hut"]){
echo '
       <img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hut/' . $ausgabe["Hut"] . '.png"><br>';
} else {
echo '<img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hut/Leer.png"><br>';
}

 if($ausgabe["Hemd"]){
echo'
       <img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hemd/' . $ausgabe["Hemd"] . '.png"><br>';
} else {
echo '<img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hemd/Leer.png"><br>';
}
 if($ausgabe["Hose"]){
echo'
       <img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hose/' . $ausgabe["Hose"] . '.png"><br>';
} else {
echo '<img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Hose/Leer.png"><br>';
}
 if($ausgabe["Schuhe"]){
echo'
       <img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Schuhe/' . $ausgabe["Schuhe"] . '.png">';
} else {
echo '<img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Schuhe/Leer.png"><br>';
}
$Leben_T = floor(($ausgabe["Leben"]/($ausgabe["MaxLeben"]/70)));
echo'
      </div>
      <div style="position:relative;top:-80px;height:80px;overflow:hidden;">
       <img src="/Kleider/' . $ausgabe["Geschlecht"] . '/Waffe/' . $ausgabe["Waffe"] . '.png">
      </div>
    </div>
	<img src="Icon/live.png"<img src="Icon/Leben.png" width="' . $Leben_T . '" height="10">
    <div style="position:relative;top:-90px;left: 80px;width:200px">
     <p>Geld =' . $ausgabe["Geld"] . '</p>
     <p>Level =' . $ausgabe["Level"] . '</p>
     <p>Exp =' . $ausgabe["Exp"] . ' von ' . NextY($ausgabe["Level"]) . '</p>
    </div>
   </li>
  ';
 }
 echo '
   <li>
    <h2>Menü</h2>
    <p><a href="infomation.php">Spieler Daten</a></p>
    <p><a href="Quest.php">Questmanager</a></p>
    <p><a href="shop.php">**NEU**shop</a></p>';
 $abfrage=mysql_query("SELECT * FROM shop Where Besitzer='$_SESSION[user_id]' ORDER BY `Exp` DESC");
 if (mysql_num_rows($abfrage) == 1){
    echo'<p><a href="myshop.php">Mein Shop</a></p>';
 }
 echo'
    </li>
 ';
}
echo '
   <li>
    <h2>Status</h2>
    <p>Ich arbeite gerade an:</p>
    <p>Shop</p>
   </li>
  </ul>
 </div>
';
?>
