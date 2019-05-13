<?php
 mysql_connect("localhost","user323934","0987654321") or die("keine Verbindung möglich");
 mysql_select_db("db323934-main") or die("unmöglich die datenbank zufinden");
 $monster = Lou_1;
 $abfrage=mysql_query("select * from Monster where Name='$monster'");
//Startfunktion
 while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
  $rand_Skill = mt_rand(1,$ausgabe["Skills"]);
  echo "er gibt $rand_Skill";
  if ($rand_Skill == 6)
   {
   echo "nicht 6";
   }
  if ($rand_Skill == 5)
   {
   echo "nicht 5";
   }
  $skill_name = array($ausgabe["Skill1"], $ausgabe["Skill2"], $ausgabe["Skill3"], $ausgabe["Skill4"], $ausgabe["Skill5"]);
  //$rand_Skill = array_rand($skill_name);
  echo $skill_name[$rand_Skill];
 }
?>
