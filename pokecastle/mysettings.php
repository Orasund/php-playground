<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'dbc.php';
page_protect();

$err = array();
$msg = array();

if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }
 
$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'"); 
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
  });
  </script>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td width="800">
<?php header(); ?>
	</td>
  </tr>
  <tr> 
    <td width="200" valign="top">
<?php menu(); ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="800" valign="top">
<h3 class="titlehdr">Profil</h3>
      <p> 
        <?php	
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";	
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
      </p>
      <p>Here you can make changes to your profile. Please note that you will 
        not be able to change your email which has been already registered.</p>
	  <?php while ($row_settings = mysql_fetch_array($rs_settings)) {?>
	<div class="forms">
		<p><strong>Pokemon</strong></p>
		<?php
		$abfrage = mysql_query("select * from pokemons where userid='$_SESSION[user_id]'") or die(mysql_error());
		while($poke_id=mysql_fetch_array($abfrage)){
			$abfrage2 =mysql_query("select * from pokedex where id='$poke_id[dexid]'") or die(mysql_error());
			while($poke=mysql_fetch_array($abfrage2)){
				echo '<p><p<img src="http://www.pokemonelite2000.com/sprites/dpiconani/dpiconani' . $poke[id] . '.gif">' . $poke[name] . ' lvl.' . $poke_id[level] . '</p>';
			}
		}
		?>
	</div>
	<p><br></p>
      <form action="mysettings.php" method="post" name="myform" id="myform">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td colspan="2"> Your Name / Company Name<br> <input name="name" type="text" id="name"  class="required" value="<? echo $row_settings['full_name']; ?>" size="50"> 
              <span class="example">Your name or company name</span></td>
          </tr>
          <tr> 
            <td colspan="2">Address <span class="example">(full address with ZIP)</span><br> 
              <textarea name="address" cols="40" rows="4" class="required" id="address"><? echo $row_settings['address']; ?></textarea> 
            </td>
          </tr>
          <tr> 
            <td>Country</td>
            <td><input name="country" type="text" id="country" value="<? echo $row_settings['country']; ?>" ></td>
          </tr>
          <tr> 
            <td width="27%">Phone</td>
            <td width="73%"><input name="tel" type="text" id="tel" class="required" value="<? echo $row_settings['tel']; ?>"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input name="fax" type="text" id="fax" value="<? echo $row_settings['fax']; ?>"></td>
          </tr>
          <tr> 
            <td>Website</td>
            <td><input name="web" type="text" id="web" class="optional defaultInvalid url" value="<? echo $row_settings['website']; ?>"> 
              <span class="example">Example: http://www.domain.com</span></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>User Name</td>
            <td><input name="user_name" type="text" id="web2" value="<? echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr> 
            <td>Email</td>
            <td><input name="user_email" type="text" id="web3"  value="<? echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
	  <?php } ?>
      <h3 class="titlehdr">Change Password</h3>
      <p>If you want to change your password, please input your old and new password 
        to make changes.</p>
      <form name="pform" id="pform" method="post" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
	   
      <p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
