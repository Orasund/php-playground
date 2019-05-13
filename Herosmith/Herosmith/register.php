<?php 
include 'Styles/settings.php';
/*************** PHP LOGIN SCRIPT V 2.0*********************
***************** Auto Approve Version**********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects.

Limitations:
- This script cannot be sold.
- This script may not be provided for download except on its original site.

For further usage, please contact me.

***********************************************************/


include 'dbc.php';
					 
if($_POST['doRegister'] == 'Register') 
{ 
/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}

/********************* RECAPTCHA CHECK *******************************
This code checks and validates recaptcha
****************************************************************/
 require_once('scripts/recaptchalib.php');
     
      $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);

      if (!$resp->is_valid) {
        die ("<h3>Image Verification failed!. Go back and try again.</h3>" .
             "(reCAPTCHA said: " . $resp->error . ")");			
      }
/************************ SERVER SIDE VALIDATION **************************************/
/********** This validation is useful if javascript is disabled in the browswer ***/

// Validate User Name
if (!isUserID($data['user_name'])) {
$err = urlencode("ERROR: Invalid user name. It can contain alphabet, number and underscore.");
header("Location: register.php?msg=$err");
exit();
}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err = urlencode("ERROR: Invalid email.");
header("Location: register.php?msg=$err");
exit();
}
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err = urlencode("ERROR: Invalid Password or mismatch. Enter 3 chars or more");
header("Location: register.php?msg=$err");
exit();
}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores md5 of password
$md5pass = md5($data['pwd']);
// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

// Generates activation code simple 4 digit number
$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];
$user_name = $data['user_name'];

/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It 
queries the database and if it has any existing email it throws user email already exists
*******************************************************************/

$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err = urlencode("ERROR: The username/email already exists. Please try again with different username and email.");
header("Location: register.php?msg=$err");
exit();
}
/***************************************************************************/

$sql_insert = "INSERT into `users`
  			(`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`,`Geschlecht`)
		    VALUES
		    ('$usr_email','$md5pass',now(),'$user_ip','$activ_code','$user_name','$data[Geschlecht]')";

mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
//	echo "<h3>Thank You</h3> We received your submission.";

$message = 
"Thank you for registering with us. Here are your login details...\n

User ID: $user_name
Email: $usr_email \n 
Passwd: $data[pwd] \n
Activation code: $activ_code \n

*****ACTIVATION LINK*****\n
http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";
/*
	mail($usr_email, "Login Details", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());
*/

/********************* SMTP EMAIL WITH PHPMAILER LIBRARY *********************
i have heard lots of complaints that users not able to receive email using mail() function
so i am using alternate SMTP emailing which is quite fast and reliable. Before you use this you should
create POP/SMTP email in your hosting account 

This script needs class.phpmailer.php and class.smtp.php files from PHPMailer library.
Download here: http://phpmailer.sourceforge.net
********************************************************************************/
require("scripts/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();        
$mail->Host = $smtp_host;
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = $smtp_user;  // SMTP username
$mail->Password = $smtp_passwd; // SMTP password


$mail->From     = $smtp_from;
$mail->FromName = $smtp_from_name;
$mail->AddAddress($usr_email);

$mail->Subject  = 'Login Details';
$mail->Body     = $message;
$mail->WordWrap = 50;

$mail->Send();

  header("Location: thankyou.php");  
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
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
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
    <h2 class="title">Anmeldung</h2>
    <div class="entry">
     <p>Bitte füll die Felder aus und drück dann auf <strong>Anmelden</strong></p>
      <p>
';	
 if (isset($_GET['msg'])) {
  $msg = mysql_real_escape_string($_GET['msg']);
   echo "<div class=\"msg\">$msg</div>";
 }
 if (isset($_GET['done'])) {
  echo "<div><h2>Thank you</h2> Your registration is now complete and you can <a href=\"login.php\">login here</a></div>";
  exit();
 }
echo '
     </p>
     <form action="register.php" method="post" name="regForm" id="regForm" >
      <p><strong>Username</strong> <input name="user_name" type="text" id="user_name" class="required username" minlength="5" ></p>
      <p><strong>Geschlecht</strong><select name="Geschlecht" class="required" id="select8">
             <option value="" selected></option>
             <option value="M">Männlich</option>
             <option value="W">Weiblich</option>
            </select></p>
      <p><strong>E-mail</strong> <input name="usr_email" type="text" id="usr_email3" class="required email" value="gültige Emailadresse"></p>
      <p><strong>Passwort</strong> <input name="pwd" type="password" class="required password" minlength="5" id="pwd"></p>
      <p><strong>Passwort wiederholen</strong> <input name="pwd2" id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></p>
      <p>
';
 require_once('scripts/recaptchalib.php');
 echo recaptcha_get_html($publickey);
echo '
      </p>
      <p><input name="doRegister" type="submit" id="doRegister" value="Register"></p>
      <p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.0</a></span></p>
     </form>
    </div>
   </div>
  </div>
';
Sidebar();
Footer();
?>
