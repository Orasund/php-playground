<?

function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	$data = mysql_real_escape_string($data);
	
	return $data;
}

function NextX($wert){
 $Zaehler = 1;
 $addexp = 1;
 while ($Zaehler != $wert){
  $addexp += $Zaehler;
  $Zaehler += 1;
 }
 return $addexp;
}

function Monster_Skill($monster) {
 $abfrage=mysql_query("select * from Monster where Name='$monster'");
//Startfunktion
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $Max_Skill = $ausgabe["Skills"];
  $rand_Skill = rand(1,$Max_Skill);
  if ($rand_Skill == 1)
  {
   $skill_name = $ausgabe["Skill1"];
  }
  if ($rand_Skill == 2)
  {
   $skill_name = $ausgabe["Skill2"];
  }
  if ($rand_Skill == 3)
  {
   $skill_name = $ausgabe["Skill3"];
  }
  if ($rand_Skill == 4)
  {
   $skill_name = $ausgabe["Skill4"];
  }
  if ($rand_Skill == 5)
  {
   $skill_name = $ausgabe["Skill5"];
  }
 }
 return $skill_name;
}

function Monster_erscheinen($User_id) {
 $abfrage = mysql_query("select * from Saver where Player_ID='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $monster = $ausgabe["Monster_Name"];
 }
 //Bild kommt auf den Bildschirm
 $abfrage = mysql_query("select * from Monster where Name='$monster'"); 
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  echo '<p>Ein ' . $ausgabe["Rasse"] . ' greift dich an!</p>
  <p><img src="monster/' . $ausgabe["Name"] . '.png"/></p>
  <div style="position:relative;top:-80px;left: 80px;width:200px">
  <p><select name="SkillSelect" size="5">';
 }
 //Skills werden angezeigt
 $abfrage = mysql_query("select * from users where id='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  if ($ausgabe["Skill1"]) {
   echo '<option selected="selected">' . $ausgabe["Skill1"] . '</option>';
  }
  if ($ausgabe["Skill2"]) {
   echo '<option>' . $ausgabe["Skill2"] . '</option>';
  }
  if ($ausgabe["Skill3"]) {
   echo '<option>' . $ausgabe["Skill3"] . '</option>';
  }
  if ($ausgabe["Skill4"]) {
   echo '<option>' . $ausgabe["Skill4"] . '</option>';
  }
  if ($ausgabe["Skill5"]) {
   echo '<option>' . $ausgabe["Skill5"] . '</option>';
  }
 }
 echo '</select></p>
 </div>';
}

function Angriff($User_id,$monster,$Preis,$Grad) {
 //Angabe umwandeln in $data
 foreach($_POST as $key => $value) {
  $data[$key] = filter($value);
 }
 $abfrage = mysql_query("select * from Saver where Player_ID='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $monster = $ausgabe["Monster_Name"];
 }
  /*******************Werte Sammeln************************/
  //Eigene Werte
  $Gewicht = 0;
  //Userdaten
  $abfrage = mysql_query("select * from users where id='$User_id'");
  while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
   $Schnellichkeit = $ausgabe["Schnellichkeit"];
   $Staerke = $ausgabe["Staerke"];
   $Leben = $ausgabe["Leben"];
   $MaxLeben = $ausgabe["MaxLeben"];
   $Exp = $ausgabe["Exp"];
   $Level = $ausgabe["Level"];
   $Waffe = $ausgabe["Waffe"];
   $Skill_points = $ausgabe["Skill_points"];
   $Geld = $ausgabe["Geld"];
  }
  $abfrage = mysql_query("select * from Waffen where Name ='$Waffe'");
  while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
   $Waffenschaden = $ausgabe["Schaden"];
  }
  $Skill_system = "Waffensystem";
  $skill = $data['SkillSelect'];
  //Monsterdaten
  $monster_skill = Monster_Skill("Lou_1");
  $abfrage=mysql_query("select * from Monster where Name='$monster'");
  while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
   $Rasse = $ausgabe["Rasse"];
   $Monster_Leben = $ausgabe["Leben"];
   $Monster_staerke = $ausgabe["Staerke"];
   $Monster_Schnellichkeit = $ausgabe["Schnellichkeit"];
   $Rang = $ausgabe["Rang"];
   $addExp = $ausgabe["Exp"];
  }
  /**********************Kampfsysteme***********************/
  //Waffensystem
  $abfrage=mysql_query("select * from Waffensystem where Name='$skill'");
  while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
   $QSchnelligkeit = Wertesystem($ausgabe["QSchnelligkeit"],$Schnellichkeit);
   $QGewicht = Wertesystem($ausgabe["QGewicht"],$Gewicht);
   $AStaerke = Wertesystem($ausgabe["AStaerke"],$Staerke);
   $AWaffenschaden = Wertesystem($ausgabe["AWaffenschaden"],$Waffenschaden);
  }
  $Quote = 1 + $QSchnelligkeit - $QGewicht;
  $Angriff = 1 + $AStaerke + $AWaffenschaden;
  $abfrage = mysql_query("select * from Natursystem where Name='$monster_skill'");
  while ($ausgabe = mysql_fetch_array($abfrage, MYSQL_ASSOC)) {
   $QSchnelligkeit = Wertesystem($ausgabe["QSchnelligkeit"],$Monster_Schnellichkeit);
   $AStaerke = Wertesystem($ausgabe["AStärke "],$Monster_staerke);
  }
  $monster_Angriff = 1 + $AStaerke;
  $monster_Quote = 1 + $QSchnelligkeit;
  //schleifenfunktion
  $rs_duplicate = mysql_query("select count(*) as total from Saver where Player_ID='$User_id'") or die(mysql_error());
  list($total) = mysql_fetch_row($rs_duplicate);
  if ($total > 0){
   $abfrage = mysql_query("select * from Saver where Player_ID='$User_id'");
   while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
    $Monster_Leben = $ausgabe["Monster_Leben"];
   }
  }
  //Ende
  $Monster_Leben2 = Skill($Quote,$Angriff,$Monster_Leben,$monster_Quote);
  $Leben2 = Skill($monster_Quote,$monster_Angriff,$Leben,$Quote);
  $rs_duplicate = mysql_query("select count(*) as total from Saver where Player_ID='$User_id'") or die(mysql_error());
  list($total) = mysql_fetch_row($rs_duplicate);
  if ($total > 0){
   mysql_query("UPDATE Saver SET Monster_Leben = '$Monster_Leben2' WHERE Player_ID='$User_id'") or die(mysql_error());
  } else {
   mysql_query("INSERT into Saver (Player_ID,Monster_Name,Monster_Leben)VALUES('$User_id','$monster','$Monster_Leben2')") or die(mysql_error());
  }
  $NextQuest = 0;
  if ($Leben2 != 0) {
   echo "<p><strong>Du hast nur noch " . $Leben2 . " Leben</strong></p>";
  }
  if ($Leben2 == 0) {
   mysql_query("UPDATE users SET QLevel = '',QName = '' WHERE id='$User_id'") or die(mysql_error());
   mysql_query("DELETE FROM Saver WHERE Player_ID='$User_id'") or die(mysql_error());
   echo "<p><strong>Du wurdest besiegt</strong></p>";
   $NextQuest = 2;
  }
  if ($Monster_Leben2 != 0) {
   echo "<p><strong>" . $Rasse . " hat nur noch " . $Monster_Leben2 . " Leben</strong></p>";
  }
  if ($Monster_Leben2 == 0){
   NextQuest($User_id,$Preis,$Grad,$Geld);
   mysql_query("DELETE FROM Saver WHERE Player_ID='$User_id'") or die(mysql_error());
   echo "<p><strong>" . $Rasse . " wurde besiegt</strong></p>"; 
   //Exp
   $Exp += $addExp;
   $NextLevel = NextX($Level);
   if ($Exp >= $NextLevel){
    $Level += 1;
    $Skill_points += 1;
    $MaxLeben += 1000;
    $Leben2 += 1000;
    $Exp -= $NextLevel;
   }
   mysql_query("UPDATE users SET Level = '$Level',Exp = '$Exp',Skill_points = '$Skill_points',MaxLeben = '$MaxLeben',Leben = '$Leben2' WHERE id='$User_id'") or die(mysql_error());
   $NextQuest = 1;
  }
  return $NextQuest;
}

function NextQuest($User_id,$Preis,$Grad,$Geld){
 $abfrage = mysql_query("select * from users where id='$User_id'");
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $QName = $ausgabe["QName"];
  $QLevel = $ausgabe["QLevel"];
 }
 $abfrage = mysql_query("select * from Quest where Name='$QName'") or die(mysql_error());  
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $MaxLevel = $ausgabe["MaxLevel"];
 }
 if ($QLevel < $MaxLevel){
  $QLevel += 1;
  mysql_query("UPDATE users SET QLevel = '$QLevel' WHERE id='$User_id'") or die(mysql_error());
 } else {
  if ($Preis = 2) {
   $abfrage = mysql_query("select * from Preise where Rang='$Grad' ORDER BY RAND() LIMIT 1");
   while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
    $Geld += $ausgabe["Geld"];
   }
  }
  mysql_query("UPDATE users SET QLevel = '',QName = '',Geld = '$Geld' WHERE id='$User_id'") or die(mysql_error());
 }
}

function Skill($Quote,$Angriff,$Monster_Leben,$Monster_Quote) {
 if($Quote > rand(1, $Monster_Quote))
 {
  if($Monster_Leben > $Angriff)
  {
   $Monster_Leben -= $Angriff;
  } else {
   $Monster_Leben = 0;
  }
 }
 return $Monster_Leben;
}


function Wertesystem($ausgabe,$Wert) {
 if ($ausgabe == 1) $Wert = $Wert / 4;
 if ($ausgabe == 2) $Wert = $Wert / 2;
 if ($ausgabe == 4) $Wert = $Wert * 2;
 if ($ausgabe == 5) $Wert = $Wert * 4;
 return $Wert;
}
