<? 
include 'scripts/dbc.php';
include 'Styles/settings.php';

/******** EMAIL ACTIVATION LINK**********************/
if(isset($_GET['user']) && !empty($_GET['activ_code']) && !empty($_GET['user']) ) {
$user = mysql_real_escape_string($_GET['user']);
$activ = mysql_real_escape_string($_GET['activ_code']);
//check if activ code and user is valid
$rs_check = mysql_query("select id from users where md5_id='$user' and activation_code='$activ'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$msg = urlencode("Sorry no such account exists or activation code invalid.");
	header("Location: activate.php?msg=$msg");
	exit();
	}

// set the approved field to 1 to activate the account
$rs_activ = mysql_query("update users set approved='1' WHERE 
						 md5_id='$user' AND activation_code = '$activ' ") or die(mysql_error());
$msg = urlencode("Thank you. Your account has been activated.");
header("Location: activate.php?done=1&msg=$msg");						 
exit();
}
/******************* ACTIVATION BY FORM**************************/
if ($_POST['doActivate']=='Activate')
{
$user_email = mysql_real_escape_string($_POST['user_email']);
$activ = mysql_real_escape_string($_POST['activ_code']);
//check if activ code and user is valid as precaution
$rs_check = mysql_query("select id from users where user_email='$user_email' and activation_code='$activ'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$msg = urlencode("Sorry no such account exists or activation code invalid.");
	header("Location: activate.php?msg=$msg");
	exit();
	}
//set approved field to 1 to activate the user
$rs_activ = mysql_query("update users set approved='1' WHERE 
						 user_email='$user_email' AND activation_code = '$activ' ") or die(mysql_error());
$msg = urlencode("Thank you. Your account has been activated.");
header("Location: activate.php?msg=$msg");						 
exit();
}

echo '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#actForm").validate();
  });
  </script>
';
Layout(); 
echo '
</head>
<body>
<div id="wrapper">
';
Menu();
echo '
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->

 <div id="page">
<!-- Hauptteil-->
 <div id="content">
  <div class="post">
   <h2 class="title">Anmeldung Aktivieren</h2>
   <div class="entry">
    <p>bitte gib deine E-mail-Adressen und den Aktivierungs Code ein um dich <a href="login.php">hier</a> einloggen zu können.</p>
    <p>
';
//Error Message
 if (isset($_GET['msg'])) {
  $msg = mysql_real_escape_string($_GET['msg']);
  echo "<div class=\"msg\">$msg</div>";
 }  
echo '
    </p>
    <form action="activate.php" method="post" name="actForm" id="actForm" >
     <p><strong>E-Mail</strong> <input name="user_email" type="text" class="required email" id="txtboxn" size="25"></p>
     <p><strong>Aktivierungs Code</strong> <input name="activ_code" type="password" class="required" id="txtboxn" size="25"></p>
     <p><input name="doActivate" type="submit" id="doLogin3" value="Aktivieren"></p>
     <p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.0</a></span></p>
    </form>
   </div>
  </div>
 </div>
';
Sidebar();
Footer();
?>
