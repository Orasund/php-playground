<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'scripts/dbc.php';
page_protect();

$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'");

if($_POST['doUpdate'] == 'ändern')  
{

$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
//check for old password in md5 format
	if($old == md5($_POST['pwd_old']))
	{
	$newmd5 = md5(mysql_real_escape_string($_POST['pwd_new']));
	mysql_query("update users set pwd='$newmd5' where id='$_SESSION[user_id]'");
	header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

header("Location: mysettings.php?msg=Profile Sucessfully saved");
 }
echo '
<html>
<head>
<title>Herosmith</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
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
    <h2 class="title">Passwort ändern</h2>
    <div class="entry">
     <p> 
';
      if (isset($_GET['msg'])) {
	  $message = urlencode($_GET['msg']);
	  echo "<div class=\"msg\">$message</div>";
	  }
echo '
     </p>
     <p>Wenn du dein Passwort ändern willst, dann füll bitte das Formular aus.</p>
     <form name="pform" id="pform" method="post" action="">
      <p><strong>Altes Passwort </strong><input name="pwd_old" type="password" class="required password"  id="pwd_old"></p>
      <p><strong>Neues Passwort </strong><input name="pwd_new" type="password" id="pwd_new" class="required password"></p>
      <p><input name="doUpdate" type="submit" id="doUpdate" value="ändern"></p>
     </form>
    </div>
   </div>
 </div>
';
Sidebar();
Footer();
?>
