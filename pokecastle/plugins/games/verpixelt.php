<?php
	//Alle Daten zum User werden geholt und in $user gespeichert
	$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));

	if(isset($_POST["picture"])){
		if($_POST["picture"] == $_POST["antwort"]){
			$user["money"] += 30;
			mysql_query("update users set money='$user[money]' where id='$_SESSION[user_id]'");
		}
		if(isset($_POST["beenden"]) && $_POST["beenden"] == 1){
			header("Location: index.php");
		}
	}
	
	function showgame(){
		
		//Alle Daten zum User werden geholt und in $user gespeichert
		$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
		mysql_query("update users set money='$user[money]' where id='$_SESSION[user_id]'");
		$pix = mysql_fetch_array(mysql_query("select * from pokedex order by rand() limit 1"));
		echo'<p><div class="forms">
			<p><strong>Verpixelt!</strong></p>
			<p>
				<b>Spielanleitung:</b><br>
				<ul>
					<li>Pro Runde zahlt man 25 Geld.</li>
					<li>Pro erratenes Pokemon bekommt man <b>30 Geld</b></li>
					<li>Pro erratenes Pokemon bekommt jedes Gildenmitglied <b>1 Geld</b></li>
				</ul>
			</p>';
		if($user["money"] >= 25){
			$user["money"] -= 25;
			mysql_query("update users set money='$user[money]' where id='$_SESSION[user_id]'");
			echo'<p><img src="maps/pix/' . $pix["id"] . '.png"></p>
				<p>Kannst du das Verpixelte Pokemon erkennen?</p>
				<form action="games.php?game=1" method="post">
					<p>
						<input type="hidden" name="picture" value="' . $pix["id"] . '">
						<select name="antwort">';
							$abfrage = mysql_query("select * from pokedex order by id");
							while($ausgabe = mysql_fetch_array($abfrage)){
								echo'<option value="' . $ausgabe["id"] . '">' . $ausgabe["name"] . '</option>';
							}
					echo'</select><br>
						<input type="checkbox" name="beenden" value="1" />Raten und Beenden<br>
						<input type="submit" value="Raten!">
					</p>
				</form>';
		} else {
			echo'<p>Du hast zu wenig Geld um zu Spielen</p>';
		}
		echo'</p></div>';
	}
?>