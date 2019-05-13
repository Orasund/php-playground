<? 
/*************** PHP LOGIN SCRIPT V2.0*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me at http://www.php-login-script.com

***********************************************************/
include '../dbc.php';

if($_POST['adminLogin'] == 'Login') {
$admin = mysql_real_escape_string($_POST['admin_user']);
$pass =  mysql_real_escape_string($_POST['admin_pass']);

if(($admin_user == $admin) && ($admin_pass == $pass) ) {
session_start(); 
	   // this sets variables in the session 
$_SESSION['user_admin']= $admin;  
header("Location: admin_main.php");
}

}

?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p>&nbsp;</p>
  <form action="index.php" method="post" name="adminForm" id="adminForm" >
<table width="40%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#d5e8f9" class="loginform">
  <tr> 
    <td colspan="2"><div align="center">
          <h2><strong>Admin Control Panel</strong></h2>
        </div></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"></div></td>
  </tr>
  <tr> 
      <td width="31%"><div align="center">Admin user</div></td>
    <td width="69%"><input name="admin_user" type="text" class="required email" id="txtbox" size="25"></td>
  </tr>
  <tr> 
    <td><div align="center">Password</div></td>
    <td><input name="admin_pass" type="password" class="required password" id="txtbox" size="25"></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"></div></td>
  </tr>
  <tr> 
    <td colspan="2"> <div align="center"> 
          <p> 
            <input name="adminLogin" type="submit" id="doLogin3" value="Login">
          </p>
         <p><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP 
                  Login Script v2.0</a></span></p>
      </div></td>
  </tr>
</table>
</form>
</body>
</html>
