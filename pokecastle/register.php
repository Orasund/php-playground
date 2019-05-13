<?php 
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
include 'menu.php';
$err = array();
					 
if(isset($_POST['doRegister']) && $_POST['doRegister'] == 'Register') 
{ 
	/******************* Filtering/Sanitizing Input *****************************
	This code filters harmful script code and escapes data of all POST data
	from the user submitted form.
	*****************************************************************/
	foreach($_POST as $key => $value) {
		$data[$key] = filter($value);
	}
	
	if(isset($data)){
		/********************* RECAPTCHA CHECK *******************************
		This code checks and validates recaptcha
		****************************************************************/
		 if(isset($_POST["recaptcha_challenge_field"]) && isset( $_POST["recaptcha_response_field"])){
		 require_once('recaptchalib.php');
			 
			  $resp = recaptcha_check_answer ($privatekey,
											  $_SERVER["REMOTE_ADDR"],
											  $_POST["recaptcha_challenge_field"],
											  $_POST["recaptcha_response_field"]);
		
			  if (!$resp->is_valid) {
				die ("<h3>Image Verification failed!. Go back and try again.</h3>" .
					 "(reCAPTCHA said: " . $resp->error . ")");			
			  }
		 }
		/************************ SERVER SIDE VALIDATION **************************************/
		/********** This validation is useful if javascript is disabled in the browswer ***/
		
		// Validate Profil
		if (!(isset($data['profil']))) {
		$err[] = "ERROR - Ein Profilbild muss gewählt werden.";
		//header("Location: register.php?msg=$err");
		//exit();
		}
		
		// Validate Starter
		if (!(isset($data['starter']))) {
		$err[] = "ERROR - Du musst ein starterpokemon";
		//header("Location: register.php?msg=$err");
		//exit();
		}
		
		// Validate User Name
		if (!isUserID($data['user_name'])) {
		$err[] = "ERROR - Invalid user name. It can contain alphabet, number and underscore.";
		//header("Location: register.php?msg=$err");
		//exit();
		}
		
		// Validate Email
		if(!isEmail($data['usr_email'])) {
		$err[] = "ERROR - Invalid email address.";
		//header("Location: register.php?msg=$err");
		//exit();
		}
		// Check User Passwords
		if (!checkPwd($data['pwd'],$data['pwd2'])) {
		$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";
		//header("Location: register.php?msg=$err");
		//exit();
		}
			  
		$user_ip = $_SERVER['REMOTE_ADDR'];
		
		// stores sha1 of password
		$sha1pass = PwdHash($data['pwd']);
		
		// Automatically collects the hostname or domain  like example.com) 
		$host  = $_SERVER['HTTP_HOST'];
		$host_upper = strtoupper($host);
		$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		
		// Generates activation code simple 4 digit number
		$activ_code = rand(1000,9999);
		
		$usr_email = $data['usr_email'];
		$user_name = $data['user_name'];
		$user_profil = $data['profil'];
		$user_starter = $data['starter'];
		
		/************ USER EMAIL CHECK ************************************
		This code does a second check on the server side if the email already exists. It 
		queries the database and if it has any existing email it throws user email already exists
		*******************************************************************/
		
		$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
		list($total) = mysql_fetch_row($rs_duplicate);
		
		if ($total > 0)
		{
		$err[] = "ERROR - The username/email already exists. Please try again with different username and email.";
		//header("Location: register.php?msg=$err");
		//exit();
		}
		/***************************************************************************/
		
		if(empty($err)) {
			$time = date('Y-m-d H:i:s');
			$sql_insert = "INSERT into `users`
						(`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`, `profil`)
						VALUES
						('$usr_email','$sha1pass','$time','$user_ip','$activ_code','$user_name', '$user_profil')
						";
						
			mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
			$user_id = mysql_insert_id($link);  
			$md5_id = md5($user_id);
			mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
			
			//Pokemon einfügen
			$your = mysql_fetch_array(mysql_query("select id from users where user_name='$user_name'"));
			// Seine Daten werden aus der Datenbank geholt
			$abfrage = mysql_query("select * from pokedex where id='$user_starter'") or die(mysql_error());
			while($ausgabe=mysql_fetch_array($abfrage)){
				$his_pokemon["dexid"] = $ausgabe["id"];
				$his_pokemon["name"] = $ausgabe["name"];
				$his_pokemon["typ"] = $ausgabe["typ"];
				$his_pokemon["intelligence_plus"] = $ausgabe["intelligence"];
				$his_pokemon["strength_plus"] = $ausgabe["strength"];
				$his_pokemon["beauty_plus"] = $ausgabe["beauty"];
				$his_pokemon["endurance_plus"] = $ausgabe["endurance"];
				$his_pokemon["level"] = 5;
			}
			
			// Das Pokemon wird gesteigert, so wie einer Reifekammer Uahahahahah.
			$his_pokemon["strength"] = $his_pokemon["strength_plus"] * $his_pokemon["level"];
			$his_pokemon["intelligence"] = $his_pokemon["intelligence_plus"] * $his_pokemon["level"];
			$his_pokemon["beauty"] = $his_pokemon["beauty_plus"] * $his_pokemon["level"];
			$his_pokemon["endurance"] = $his_pokemon["endurance_plus"] * $his_pokemon["level"];
			
			mysql_query("insert into pokemons
				(userid,dexid, level, intelligence, strength, beauty, endurance, love)
				VALUES
('$your[id]','$his_pokemon[dexid]','$his_pokemon[level]','$his_pokemon[intelligence]','$his_pokemon[strength]','$his_pokemon[beauty]','$his_pokemon[endurance]', '10')") or die(mysql_error());
			//	echo "<h3>Thank You</h3> We received your submission.";
			
			if($user_registration)  {
				$a_link = "
				*****ACTIVATION LINK*****\n
				http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code
				"; 
			} else {
				$a_link = 
				"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
				";
			}
		
			$message = 
			"Hello \n
			Thank you for registering with us. Here are your login details...\n
			
			User ID: $user_name
			Email: $usr_email \n 
			Passwd: $data[pwd] \n
			
			$a_link
			
			Thank You
			
			Administrator
			$host_upper
			______________________________________________________
			THIS IS AN AUTOMATED RESPONSE. 
			***DO NOT RESPOND TO THIS EMAIL****
			";
			
				mail($usr_email, "Login Details", $message,
				"From: \"Member Registration\" <auto-reply@$host>\r\n" .
				 "X-Mailer: PHP/" . phpversion());
			
			  header("Location: thankyou.php");  
			  exit();
			 
		}
	} 
 }					 

?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header"></div>
	<div id="page">
		<div id="chat">
	<!-- BEGIN Shoutbox.de CODE -->
		<iframe src="http://230595.shoutbox.de/" width="200" height="500" frameborder="0" allowTransparency="true"></iframe>
	<!-- END Shoutbox.de CODE-->
		</div>
		<div id="content">
        <p><div class="forms">
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <h2>Danke</h2>Deine Registation ist nun abgeschlossen, du kannst dich gleich einloggen.</a>";
	 <?php exit();
	  }
	?></p>
      <p><b>Registration</b></p>
      <p>Bitte gib alle Felder ein, die mit <span class="required">*</span> 
        markiert sind.</p>
	 <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?>
        <table>
        <form action="register.php" method="post" name="regForm" id="regForm" >
          <tr> 
            <td width="20%">Name<span class="required"><font color="#CC0000">*</font></span></td>
            <td width="80%"><input name="user_name" type="text" id="user_name" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			    <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> 
            </td>
          </tr>
          <tr> 
            <td>Email<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="usr_email3" class="required email"> 
              <span class="example">** Bitte eine richtige mailadresse eingeben...</span></td>
          </tr>
          <tr> 
            <td>Passwort<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 Zeichen mindestens...</span></td>
          </tr>
          <tr> 
            <td>Passwort erneut eingeben<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          </table>
          <table>
          <tr>
          	<td width="25%">Profilbild<span class="required"><font color="#CC0000">*</font></span></td>
        	<td width="25%"><img src="maps/sprites/20.png"></td>
            <td width="25%"><img src="maps/sprites/22.png"></td>
            <td width="25%"><img src="maps/sprites/24.png"></td>
    	</tr><tr>
        	<td width="25%"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="20"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="22"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="24"></td>
        </tr><tr>
        	<td width="25%"></td>
        	<td width="25%"><img src="maps/sprites/21.png"></td>
            <td width="25%"><img src="maps/sprites/23.png"></td>
            <td width="25%"><img src="maps/sprites/25.png"></td>
     	</tr><tr>
        	<td width="25%"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="21"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="23"></td>
            <td width="25%" align="middle"><input type="radio" name="profil" value="25"></td>
       	</tr><tr> 
    		<td colspan="3">&nbsp;</td>
  		</tr><tr>
          	<td width="25%" align="middle">Starterpokemon<span class="required"><font color="#CC0000">*</font></span></td>
        	<td width="25%" align="middle"><img src="maps/dex/1.gif"></td>
            <td width="25%" align="middle"><img src="maps/dex/4.gif"></td>
            <td width="25%" align="middle"><img src="maps/dex/7.gif"></td>
    	</tr><tr>
        	<td width="25%"></td>
            <td width="25%" align="middle"><input type="radio" name="starter" value="1"></td>
            <td width="25%" align="middle"><input type="radio" name="starter" value="4"></td>
            <td width="25%" align="middle"><input type="radio" name="starter" value="7"></td>
        </tr>
          </table>
          <table>
          <tr> 
            <td width="20%"><strong>Bild Gestätigung</strong><span class="required"><font color="#CC0000">*</font></span> </td>
            <td width="80%"> 
              <?php 
			require_once('recaptchalib.php');
			
				echo recaptcha_get_html($publickey);
			?>
            </td>
          </tr>
        </table>
        <p align="center">
          <input name="doRegister" type="submit" id="doRegister" value="Register">
        </p>
      </form>
      <p align="right"><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP 
                  Login Script v2.0</a></span></p>
	   
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
			</div></p>
		</div>
		<div id="sidebar"><?php cgear(); ?></div>
	</div>
	<div id="footer"></div>
</body>
</html>
