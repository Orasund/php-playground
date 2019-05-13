<?php 
include 'dbc.php';
/* $_SESSIONs werden gesetzt */
session_start();
include 'menu.php';
global $db; 

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

/* Secure against Session Hijacking by checking user agent */
if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
    {
        logout();
        exit;
    }
}

// before we allow sessions, we need to check authentication key - ckey and ctime stored in database

/* If session not set, check for cookies set by Remember me */
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) 
{
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])){
	/* we double check cookie expiry time against stored in database */
	
	$cookie_user_id  = filter($_COOKIE['user_id']);
	$rs_ctime = mysql_query("select `ckey`,`ctime` from `users` where `id` ='$cookie_user_id'") or die(mysql_error());
	list($ckey,$ctime) = mysql_fetch_row($rs_ctime);
	// coookie expiry
	if( (time() - $ctime) > 60*60*24*COOKIE_TIME_OUT) {

		logout();
		}
/* Security check with untrusted cookies - dont trust value stored in cookie. 		
/* We also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/

	 if( !empty($ckey) && is_numeric($_COOKIE['user_id']) && isUserID($_COOKIE['user_name']) && $_COOKIE['user_key'] == sha1($ckey)  ) {
	 	  session_regenerate_id(); //against session fixation attacks.
	
		  $_SESSION['user_id'] = $_COOKIE['user_id'];
		  $_SESSION['user_name'] = $_COOKIE['user_name'];
		/* query user level from database instead of storing in cookies */	
		  list($user_level) = mysql_fetch_row(mysql_query("select user_level from users where id='$_SESSION[user_id]'"));

		  $_SESSION['user_level'] = $user_level;
		  $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		  
	   } else {
	   logout();
	   }

  }
}
function bbcode ($text) {
	// doppelenter wird zu <p>
	$text = preg_replace('/\n\n/','</p><p>',$text);
	//enter wird zu <br>
	$text = preg_replace('/\n/','<br>',$text);
	$text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text); 
	$text = preg_replace('/\[i\](.*?)\[\/i\]/', '<i>$1</i>', $text); 
	$text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>',$text);
	$text = preg_replace('/\[img\](.*?)\[\/img\]/','<img src="$1">',$text);
	$text = preg_replace('/\[url\](.*?)\[\/url\]/', '<a href="$1">$1</a>', $text); 
	$text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="$1">$2</a>', $text);
	// Sortierte Aufzählung
	$text = preg_replace('/\[ol\](.*?)\[\/ol\]/', '<ol type="1">$1</ol>', $text);
	// Unsortierte Aufzählung
	$text = preg_replace('/\[ul\](.*?)\[\/ul\]/', '<ul>$1</ul>', $text);
	// Aufzählungseinträge
	$text = preg_replace('/\[li\](.*?)\[\/li\]/', '<li>$1</li>', $text); 
	return $text;
} 
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript" type="text/javascript" src="overlib/overlib.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	<div id="header"></div>
	<div id="page">
		<div id="chat">
		<!--<iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>-->
		</div>
		<div id="content">
<?php
	if(!(isset($_GET["forum_typ"])) && !(isset($_GET["theme"]))){
		echo'<p><div class="forms">
			<p><strong>Willkommen in Pokemon-Castle</strong></p>
			<p>Dies ist ein Kostenloses Browser-Spiel.</p>
			<p>Die Idee dahinter ist ein unkompliziertes Spiel zu entwickeln, alle Werte oder Funktionen die in der Pokemonwelt unwichtig oder schwachsinnig waren, wurden entfernt oder verändert.</p>';
		//echo'<p>In ferner Zukunft wird noch geplant, diese Seite als Download-Pack für andere zu verfügung zu stellen, damit auch andere Schnell unkomplizierte Pokemon-spiele spielen wollen, allerdings wird das Pack beschrenkt und man wird sich dafür bei mir Melden müssen.</p>';
		echo'</div></p>';
		$_GET["forum_typ"] = 1;
	}
		if(isset($_GET["forum_typ"])){
			if(isset($_GET["edit"])){
				if(isset($_POST["edit_text"])){
					//Neuer Eintrag einfügen
					mysql_query("update themes set text='$_POST[edit_text]' where id='$_GET[edit]'") or die(mysql_error());
				} else {
					//Eintrag ändern
					$post_edit = mysql_fetch_array(mysql_query("select * from themes where id='$_GET[edit]'"));
					echo '<div class="forms"><form action="index.php?forum_typ=' . $_GET["forum_typ"] . '&edit=' . $_GET["edit"] . '" method="post">
						<p><strong>Neuer Beitrag</strong></p>
						<p><textarea name="edit_text" cols="59" rows="10">' . $post_edit["text"] . '</textarea></p>
						<p><input type="submit" value="Ändern"></p>
					</form></div>';
				}
			}
			//Eintrag löschen
			if(isset($_GET["del"])){
				mysql_query("DELETE FROM themes WHERE id='$_GET[del]'") or die(mysql_error());
			}
			
			$typ = $_GET["forum_typ"];
			
			//Neuer Eintrag
			if(isset($post["title"]) && isset($post["text"])){
				$date = date('Y-m-d H:i:s');
				mysql_query("insert into themes (title,text,typ,date,user) VALUES ('$post[title]','$post[text]','$typ','$date','$_SESSION[user_id]')") or die(mysql_error());
			}
		
			$abfrage = mysql_query("select * from themes where typ='$typ' order by pens");
			while($ausgabe = mysql_fetch_array($abfrage)){
				$message = bbcode($ausgabe["text"]);
				$message = substr($message, 0, 200);
				$user = mysql_fetch_array(mysql_query("select * from users where id='$ausgabe[user]'"));
				echo '<table class="myaccount" width="448">
						<tr><td width="416" align="center"><h1>' . $ausgabe["title"] . '</h1></td>';
					echo'<td width="32">
							<a href="index.php?theme=' . $ausgabe["id"] . '">';
								echo'<img src="maps/icons/newspaper_go.png">';
							//echo'<br>Mehr...';
						echo'</a>
						</td>';
					echo'</tr>
						<tr>
							<td class="forms" colspan="2">
								<p>' . $message . '...</p>
								<p>' . $ausgabe["pens"] . ' Beobachter |' . $ausgabe["date"] . '</p>
							</td>
						</tr>
					</table>';
			}
			
			if(isset($_SESSION["user_id"])){
				//if(($typ == 2) OR) 
				
				if((checkAdmin() == 1) OR ($typ == 4 OR 5)){
					//neuer Post
					echo '<p><div class="forms"><form action="' . $_SERVER['SCRIPT_NAME'] . '?forum_typ=' . $typ . '" method="post">
						<p><strong>Neuer Beitrag</strong></p>
						<p><input name="title" type="text" size="55"></p>
						<p><textarea name="text" cols="59" rows="10"></textarea></p>
						<p><input type="submit" value="Schreiben"></p>
					</form></div></p>';
				}
			}
		}
		
		if(isset($_GET["theme"])){
			if(isset($_GET["edit"])){
				if(isset($_POST["edit_text"])){
					//Neuer Eintrag einfügen
					mysql_query("update messages set message='$_POST[edit_text]' where id='$_GET[edit]'") or die(mysql_error());
				} else {
					//Eintrag ändern
					$post_edit = mysql_fetch_array(mysql_query("select * from messages where id='$_GET[edit]'"));
					echo '<p><div class="forms"><form action="index.php?theme=' . $_GET["theme"] . '&edit=' . $_GET["edit"] . '" method="post">
						<p><strong>Neuer Beitrag</strong></p>
						<p><textarea name="edit_text" cols="59" rows="10">' . $post_edit["message"] . '</textarea></p>
						<p><input type="submit" value="Ändern"></p>
					</form></div></p>';
				}
			}
		
			//Neuer Eintrag
			if(isset($_POST["text"])){
					$date = date('Y-m-d H:i:s');
					mysql_query("insert into messages (theme, date, user, message) VALUES ('$_GET[theme]','$date','$_SESSION[user_id]','$_POST[text]')") or die(mysql_error());
			}
			
			//Eintrag löschen
			if(isset($_GET["del"])){
				mysql_query("DELETE FROM messages WHERE id='$_GET[del]'") or die(mysql_error());
			}
			
			//Erster Post
			$abfrage = mysql_query("select * from themes where id='$_GET[theme]'");
			while($ausgabe = mysql_fetch_array($abfrage)){
				$message = bbcode($ausgabe["text"]);
				$user = mysql_fetch_array(mysql_query("select * from users where id='$ausgabe[user]'"));
				echo '
					<table class="title" width="448">
						<tr>
							<td width="64">
								<a href="index.php"><img src="maps/icons/resultset_first.png"></a><a href="index.php?forum_typ=' . $ausgabe["typ"] . '"><img src="maps/icons/resultset_previous.png"></a>
							</td>
							<td align="center">
								<h1>' . $ausgabe["title"] . '</h1>
							</td>
						</tr>
					</table>
					<table class="myaccount" width="448">
						<tr>
							<td align="center" width="100">
								<b>' . $user["user_name"] . '</b><br>
								<img src="maps/sprites/' . $user["profil"] . '.png"><br>
								' . $ausgabe["date"] . '
							</td>
							<td class="forms">
								<p>' . $message . '...</p>';
								//echo $ausgabe["pens"] . ' Beobachter | <a href="index.php?pen=' . $_GET["theme"] . '">Beobachten</a></p>';
								if ($ausgabe["user"] == $_SESSION["user_id"]){
									echo '<p><a href="index.php?del=' . $ausgabe["id"] . '&forum_typ=' . $ausgabe["typ"] . '">Löschen</a> | <a href="index.php?edit=' . $ausgabe["id"] . '&forum_typ=' . $ausgabe["typ"] . '">Ändern</a></p>';
								}
				echo'		</td>
						</tr>
					</table>';
			}
			
			//weitere Post
			$abfrage = mysql_query("select * from messages where theme='$_GET[theme]' order by date");
			while($ausgabe = mysql_fetch_array($abfrage)){
				$message = bbcode($ausgabe["message"]);
				$user = mysql_fetch_array(mysql_query("select * from users where id='$ausgabe[user]'"));
				echo '<table class="myaccount" width="448">
						<tr>
							<td align="center" width="100">
								<b>' . $user["user_name"] . '</b><br>
								<img src="maps/sprites/' . $user["profil"] . '.png"><br>
								' . $ausgabe["date"] . '
							</td>
							<td class="forms">
							<p>' . $message . '</p>';
							if ($ausgabe["user"] == $_SESSION["user_id"]){
								echo '<p><a href="index.php?del=' . $ausgabe["id"] . '&theme=' . $_GET["theme"] . '">Löschen</a> | <a href="index.php?edit=' . $ausgabe["id"] . '&theme=' . $_GET["theme"] . '">Ändern</a></p>';
							}	
				echo '		</td>
						</tr>
					</table>';
			}
			
			if(!(isset($_GET["edit"]))){
				if(isset($_SESSION["user_id"])){
					//neuer Post
					echo '<p><div class="forms"><form action="index.php?theme=' . $_GET["theme"] . '" method="post">
						<p><strong>Neuer Beitrag</strong></p>
						<p><textarea name="text" cols="59" rows="10"></textarea></p>
						<p><input type="submit" value="Schreiben"></p>
					</form></div></p>';
				}
			}
		}
?>
		</div>
		<div id="sidebar"><?php cgear(); ?></div>
	</div>
	<div id="footer" style="text-align:center;"><p><span style="font: normal 9px verdana;"><a href="impressum.php">Impressum</a><br>Pokémon&copy ist eine eingetragene Marke von Nintendo / Game Freak Inc.<br>ich verdiene kein Geld mit dieser Seite, PokeCastle soll lediglich als Freizeitbeschäftigung & Werbung für die genannten Marken stehen.</span><p></div>
</body>
</html>
