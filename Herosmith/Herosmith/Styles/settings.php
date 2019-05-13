<?
function Layout(){
	echo '<script type="text/javascript" src="overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>';
	//Cool_Moon Herosmith 5.1
	echo '<link href="Styles/Cool_Moon/mainstyle.css" rel="stylesheet" type="text/css" media="screen" />
		</head>
		<body>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
		';
}

function Menu(){
	//get Cookies
//	if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
//    		$_SESSION['user_id'] = $_COOKIE['user_id'];
//  		$_SESSION['user_name'] = $_COOKIE['user_name'];
//	}

	if(isset($_SESSION['user_id']))
	{
		echo '
	 		<div id="header">
	  			<div id="menu">
	   				<ul>
	   	 				<li><a href="index.php">Home</a></li>
    						<li><a href="logout.php">Logout </a></li>
    						<li><a href="index.php">Spielen</a></li>
    						<li><a href="mysettings.php">Settings</a></li>
   					</ul>
  				</div>
 			</div>
		';
	} else {
		echo '
			 <div id="header">
				 <div id="menu">
   					<ul>
 v   						<li><a href="index.php">Home</a></li>
    						<li><a href="login.php">Login</a></li>
    						<li><a href="register.php">Anmelden</a></li>
    						<li><a href="forgot.php">Passwort vergessen</a></li>
   					</ul>
  				</div>
 			</div>
		';
	}
}

function NextY($wert){
 $Zaehler = 1;
 $addexp = 1;
 while ($Zaehler != $wert){
  $addexp += $Zaehler;
  $Zaehler += 1;
 }
 return $addexp;
}

function render_clothes($Typ,$clothes,$Geschlecht,$clothes_info){
	if($clothes){
        	echo '<input src="Images/clothes/' . $Geschlecht . '/' . $Typ . '/' . $clothes . '.png" name="Ausziehen" type="image" value="' . $Typ . '" alt="' . $Typ . ' ausziehen" onmouseover="' . "
			return overlib('Preis:" . $clothes_info[1] . "
			<br>Stärke:" . $clothes_info[2] . "
			<br>Schnelligkeit:" . $clothes_info[3] . "
			<br>Intelligenz:" . $clothes_info[4] . "
			<br>Mut:" . $clothes_info[5] . "
			<br>Gewicht:" . $clothes_info[6] . "', CAPTION, '" . $clothes . "')" . ';" onmouseout="return nd();"><br>
		';
	} else {
		echo '<img src="Images/clothes/' . $Geschlecht . '/Hut/Leer.png">';
	}
}

function render_char($Haare,$Geschlecht,$Hut,$Hemd,$Hose,$Schuhe){
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
	echo '<div style="padding:0px;height:80px;width:80px;overflow:hidden;">
      	<div style="background-image:url(Images/clothes/' . $Geschlecht . '/Haare/' . $Haare . '.png);">
      	<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post" name="logForm" id="logForm">
	';
	render_clothes("Hut",$Hut,$Geschlecht,$Hut_info);
	render_clothes("Hemd",$Hemd,$Geschlecht,$Hemd_info);
	render_clothes("Hose",$Hose,$Geschlecht,$Hose_info);
	render_clothes("Schuhe",$Schuhe,$Geschlecht,$Schuhe_info);
        echo'
       </form>
      </div>
     </div>
	';
}

function Sidebar(){
	echo ' <div id="sidebar">
		<ul>
	';
	if(isset($_SESSION['user_id']))
	{
		$User_id = $_SESSION['user_id'];
		$abfrage = mysql_query("select * from users where id='$User_id'");
		while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
	 		// $lastTime = $ausgabe["lastTime"];
	  		$heute = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
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
          		$Haare = $ausgabe["Haare"];
 	  		$Geschlecht = $ausgabe["Geschlecht"];
 	  		$Hut = $ausgabe["Hut"];
 	  		$Hemd = $ausgabe["Hemd"];
 	  		$Hose = $ausgabe["Hose"];
 	  		$Schuhe = $ausgabe["Schuhe"];
	  		$Geld = $ausgabe["Geld"];
	  		$Level = $ausgabe["Level"];
	  		$Exp = $ausgabe["Exp"];
	  		$Leben = $ausgabe["Leben"];
	  		$MaxLeben = $ausgabe["MaxLeben"];
			$Beruf = $ausgabe["Beruf"];
			$Staerke = $ausgabe["Staerke"];
 			$Schnellichkeit = $ausgabe["Schnellichkeit"];
 			$Intelligenz = $ausgabe["Intelligenz"];
 			$Mut = $ausgabe["Mut"];
		}
		render_char($Haare,$Geschlecht,$Hut,$Hemd,$Hose,$Schuhe,$Geld);
		$Leben_T = floor($Leben/($MaxLeben/70));
		$Exp_T = floor(($Exp/(NextY($Level)/70)));
		echo '<img src="Images/Icons/live.png"><img src="Images/Icons/Leben.png" width="' . $Leben_T . '" height="10"><br>
			<img src="Images/Icons/Levelup.png"><img src="Images/Icons/Exp.png" width="' . $Exp_T . '" height="10">
		    	<div style="position:relative;top:-100px;left: 80px;width:200px;height=100">
		     		<p>Geld =' . $Geld . ' Rubin</p>
		     		<p>Beruf = ' . $Beruf . ',Level ' . $Level . '</p>
		    	</div>
			<div style="position:relative;left: 0px;width:200px;height=128">
				<img src="Images/Icons/staerke.png"><img src="Images/Icons/staerke_bar.png" width="' . $Staerke/100 . '" height="32"><br>
				<img src="Images/Icons/energie.png"><img src="Images/Icons/engerie_bar.png" width="' . $Schnellichkeit/100 . '" height="32"><br>
				<img src="Images/Icons/iq.png"><img src="Images/Icons/iq_bar.png" width="' . $Intelligenz/100 . '" height="32"><br>
				<img src="Images/Icons/mut.png"><img src="Images/Icons/mut_bar.png" width="' . $Mut/100 . '" height="32"><br>
			</div>
		   </li>
		';	
		echo '
		   <li>
		    <h2>Menü</h2>
		    <p><a href="infomation.php">Spieler Daten</a></p>
		    <p><a href="Quest.php">Questmanager</a></p>
		    <p><a href="shop.php">**NEU**shop</a></p>
		';
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
}

function Footer(){
echo'
	<div style="clear: both;"> </div>
	</div>
	<!-- end #page -->
	<div id="footer">
	</div>
	<!-- end #footer -->
	</div>
	</body>
	</html>
';
}
?>
