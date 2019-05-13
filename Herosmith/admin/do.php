<? 

session_start();
if(!isset($_SESSION['user_admin'])) {
header("Location: index.php");
exit();
}

$ret = $_SERVER['HTTP_REFERER'];



include '../dbc.php';
if($_GET['cmd'] == 'approve')
{
mysql_query("update users set approved='1' where id='$_GET[id]'") or die(mysql_error());
$rs_email = mysql_query("select user_email from users where id='$_GET[id]'") or die(mysql_error());
list($to_email) = mysql_fetch_row($rs_email);

$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

$message = 
"Thank you for registering with us. Your account has been activated...

*****LOGIN LINK*****\n
http://$host$path/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

/*********** DISABLE PHP MAIL FUNCTION*******
	@mail($to_email, "User Activation", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

*********************************************/

require("../class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();        
$mail->Host = $smtp_host;
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = $smtp_user;  // SMTP username
$mail->Password = $smtp_passwd; // SMTP password


$mail->From     = $smtp_from;
$mail->FromName = $smtp_from_name;
$mail->AddAddress($to_email);

$mail->Subject  = 'User Activation';
$mail->Body     = $message;
$mail->WordWrap = 50;

$mail->Send();


 echo "Active";


}

if($_GET['cmd'] == 'ban')
{
mysql_query("update users set banned='1' where id='$_GET[id]'");

//header("Location: $ret");  
echo "yes";
exit();

}

if($_GET['cmd'] == 'unban')
{
mysql_query("update users set banned='0' where id='$_GET[id]'");
echo "no";

//header("Location: $ret");  
// exit();

}


?>