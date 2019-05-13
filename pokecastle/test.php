<?php
	if($_POST[go_go]) {
		echo 'es geht:' . $_POST[go];
	}
	/*define ("DB_HOST", "localhost");
	define ("DB_USER", "*****************");
	define ("DB_PASS", "*****************");
	define ("DB_NAME", "*****************");

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
	//Dies ist ein Teil eines scripts, dass sehr komplex ist, aber ich bin mir sicher, dass es nicht an diesem script liegt.
	global $db;
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	
	//Ab hier ist das Script von mir.
	$user = mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[user_id]'"));
	
	if($_POST[go]) {
		mysql_query("update users set map='$_POST[go]' where id='$_SESSION[user_id]'") or die(mysql_error());
	}*/
?>

<html>
	<head>
		<title>Die Testseite</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
		<link href="styles.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div id="page">
			<div id="content">
				<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" name="form" id="form">
					<input src="arrow.png" name="go" type="image" value="2" alt="go">
				</form>
			</div>
		</div>
	</body>
</html>