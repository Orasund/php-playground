<?php
    include 'dbc.php';
    page_protect();
    include 'menu.php';

    //Alle Daten zum User werden geholt und in $user gespeichert
    $user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));

    //Spieler können angezeigt werden
    $rs_active = mysql_query("select count(*) as total_active from users where approved='1'") or die(mysql_error());
    $rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");
    list($total_pending) = mysql_fetch_row($rs_total_pending);
    list($active) = mysql_fetch_row($rs_active);
?>

<html>
    <head>
        <title><?php echo SITE_NAME; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="styles.css" rel="stylesheet" type="text/css">
		<script language="JavaScript" type="text/javascript" src="overlib/overlib.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    </head>
    <body>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
        <div id="header"></div>
        <div id="page">
            <div id="chat">
            <!-- BEGIN Shoutbox.de CODE -->
                <iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>
            <!-- END Shoutbox.de CODE-->
            </div>
            <div id="content">
                <p>
                    <div class="forms">
                        <p><strong><?php echo $active;?> Mitspieler
                            <?php
                                if (checkAdmin()) {
                                    echo ' (' . $total_pending . ' Unaktivierte)';
                                }
                            ?>
                        </strong></p>
						<?php
							$abfrage = mysql_query("select * from users where approved='1'") or die(mysql_error());
							while($users = mysql_fetch_array($abfrage)){
								echo '<p><table>';
								echo'<tr>';
									
									echo'<td rowspan="3"><img src="maps/sprites/' . $users["profil"] . '.png"></td>';
									echo'<td width="64">
											<b>' . $users["user_name"] .  '</b><br>
											Geld:' . $users["money"] . '<br>
											Energie:' . $users["energie"] . '<br>
										</td>';
									if (checkAdmin()) {
										echo'<td width="96">Spieler Sperren</td>';
									}
								echo'</tr><tr>';
									echo'<td colspan="3">';
											
											//Pokemon werden angezeigt
											$abfrage2 = mysql_query("select * from pokemons where userid='$users[id]'") or die(mysql_error());
											while($poke = mysql_fetch_array($abfrage2)){
												
												if (checkAdmin()) {
													//Infomationen anzeigen	
													echo '<img src="maps/oworld/' . $poke["dexid"] . '.png" ';
													echo'onmouseover="return overlib(' . "'";
														echo'Level ' . $poke["level"] . '<br>';
														echo'Liebe ' . $poke["love"] . '<br>';
														echo'Erfahrung ' . $poke["exp"] . '<br>';
														echo'<i>Intelligenz ' . $poke["intelligence"] . '</i><br>';
														echo'<i>Stärke ' . $poke["strength"] . '</i><br>';
														echo'<i>Schnelligkeit ' . $poke["beauty"] . '</i><br>';
														echo'<i>Ausdauer ' . $poke["endurance"] . '</i><br>';
													
													echo"'" . ');" ';
													echo'onmouseout="return nd();">';
												} else {
													//Infomationen anzeigen	
													echo '<img src="maps/oworld/' . $poke["dexid"] . '.png">';
												}
											}
									echo'</td>';
								echo '</tr>';
								echo'</table></p>';
							}
						?>
						<p></p>
                    </div>
                <p>
            </div>
            <div id="sidebar"><?php cgear(); ?></div>
        </div>
        <div id="footer"></div>
    </body>
</html>
