<?php 
include 'Styles/settings.php';
/*************** PHP LOGIN SCRIPT V2.0*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
include 'scripts/dbc.php';


if ($_POST['doLogin']=='Login')
{
$user_email = mysql_real_escape_string($_POST['usr_email']);
$md5pass = md5(mysql_real_escape_string($_POST['pwd']));


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}


$sql = "SELECT `id`,`user_name`,`approved`,`User_rang` FROM users WHERE 
           $user_cond
			AND `pwd` = '$md5pass' AND `banned` = '0'
			"; 

			
$result = mysql_query($sql) or die (mysql_error()); 
$num = mysql_num_rows($result);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$full_name,$approved,$rang) = mysql_fetch_row($result);
	
	if(!$approved) {
	$msg = "Account not activated. Please check your email for activation code";
	header("Location: login.php?msg=$msg");
	 exit();
	 }
 
     // this sets session and logs user in  
       
	   session_start(); 
	   // this sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_rang'] = $rang;
		
		//set a cookie witout expiry until 60 days
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*60, "/");
				  setcookie("user_name", $_SESSION['user_name'], time()+60*60*24*60, "/");
				  setcookie("user_rang", $_SESSION['user_rang'], time()+60*60*24*60, "/");
				   }
		
			
		header("Location: index.php");
		}
		else
		{
		$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		header("Location: login.php?msg=$msg");
		}
		
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
    $("#logForm").validate();
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
   <h2 class="title">Login User</h2>
   <div class="entry">
    <p>
';
//Error Message
 if (isset($_GET['msg'])) {
  $msg = mysql_real_escape_string($_GET['msg']);
  echo "<div class=\"msg\">$msg</div>";
 }  
echo '
    </p>
    <form action="login.php" method="post" name="logForm" id="logForm" >
     <p><strong>Username</strong> <input name="usr_email" type="text" class="required" id="txtbox" size="25" /></p>
     <p><strong>Passwort</strong> <input name="pwd" type="password" class="required password" id="txtbox" size="25" /></p>
     <p><input name="remember" type="checkbox" id="remember" value="1">Remember me</p>
     <p><input name="doLogin" type="submit" id="doLogin3" value="Login" /></p>
     <p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP Login Script v2.0</a></span></p>
    </form>
   </div>
  </div>
 </div>
';
Sidebar();
Footer();
?>
