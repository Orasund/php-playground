<? 
include 'scripts/dbc.php';


/******************* ACTIVATION BY FORM**************************/
if ($_POST['doReset']=='Reset')
{
$user_email = mysql_real_escape_string($_POST['user_email']);

//check if activ code and user is valid as precaution
$rs_check = mysql_query("select id from users where user_email='$user_email'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$msg = urlencode("Error - Sorry no such account exists or registered.");
	header("Location: forgot.php?msg=$msg");
	exit();
	}
//generate 4 digit random number
$new = rand(1000,9999);
$md5_new = md5($new);	
//set update md5 of new password
$rs_activ = mysql_query("update users set pwd='$md5_new' WHERE 
						 user_email='$user_email'") or die(mysql_error());
						 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);						 
						 
//send email

$message = 
"Here are your new password details ...\n
User Email: $user_email \n
Passwd: $new \n

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	mail($user_email, "Reset Password", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());						 
						 
						 
						 
$msg = urlencode("Your account password has been reset and a new password has been sent to your email address.");
header("Location: forgot.php?msg=$msg");						 
exit();
}

echo '
<html xmlns="http://www.w3.org/1999/xhtml">
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
 <div id="content">
  <div class="post">
   <h2 class="title">Passwort vergessen</h2>
   <div class="entry">
    <p>Gib deine E-mail an. Das Passwort wird dann an die angegebene Adresse gesendet.</p>
    <p>
';
//Error Message
 if (isset($_GET['msg'])) {echo "<div class=\"msg\">$_GET[msg]</div>";}
echo '
    </p>
    <form action="forgot.php" method="post" name="actForm" id="actForm" >
     <p><strong>E-Mail</strong> <input name="user_email" type="text" class="required email" id="txtboxn" size="25"></p>
     <p><input name="doReset" type="submit" id="doLogin3" value="Reset"></p>
     <p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.0</a></span></p>
    </form>
   </div>
  </div>
 </div>
';
Sidebar();
Footer();
?>
