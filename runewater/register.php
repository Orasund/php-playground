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


include 'xmlhttp/dbc.php';

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

	/********************* RECAPTCHA CHECK *******************************
	This code checks and validates recaptcha
	****************************************************************/
	/*require_once('recaptchalib.php');
		 
		  $resp = recaptcha_check_answer ($privatekey,
										  $_SERVER["REMOTE_ADDR"],
										  $_POST["recaptcha_challenge_field"],
										  $_POST["recaptcha_response_field"]);

		  if (!$resp->is_valid) {
			die ("<h3>Image Verification failed!. Go back and try again.</h3>" .
				 "(reCAPTCHA said: " . $resp->error . ")");			
		  }*/
	/************************ SERVER SIDE VALIDATION **************************************/
	/********** This validation is useful if javascript is disabled in the browswer ***/

	// Validate User Name
	if (!isUserID($data['user_name'])) {
		$err[] = "ERROR - Invalid user name. It can contain alphabet, number and underscore.";
	}

	// Validate Email
	if(!isEmail($data['usr_email'])) {
		$err[] = "ERROR - Invalid email address.";
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

	/************ JOB CHECK ***********************/
	switch($data["job"]){
		case 0: //Kämpfer
			$atklevel = 2;
			$minelevel = 1;
			$craftlevel = 0;
			break;
		case 1: //Helfer
			$atklevel = 0;
			$minelevel = 2;
			$craftlevel = 1;
			break;
		case 2: //Erfinder
			$atklevel = 1;
			$minelevel = 0;
			$craftlevel = 2;
			break;
		default:
			switch(rand(0,2)){
				case 0:
					$atklevel = 2;
					if(rand(0,1) == 0){
						$minelevel = 1;
						$craftlevel = 0;
					} else {
						$minelevel = 0;
						$craftlevel = 1;
					}
					break;
				case 1:
					$minelevel = 2;
					if(rand(0,1) == 0){
						$atklevel = 1;
						$craftlevel = 0;
					} else {
						$atklevel = 0;
						$craftlevel = 1;
					}
					break;
				case 2:
					$craftlevel = 2;
					if(rand(0,1) == 0){
						$atklevel = 1;
						$minelevel = 0;
					} else {
						$atklevel = 0;
						$minelevel = 1;
					}
			}
	}
	
	/**************************************************************************/
	
	$usr_email = $data['usr_email'];
	$user_name = $data['user_name'];
	$island = rand(0,3);

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

		$sql_insert = "INSERT into `users`
				(`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`,`job`,`atklevel`,`minelevel`,`craftlevel`,`island`)
				VALUES
				('$usr_email','$sha1pass',now(),'$user_ip','$activ_code','$user_name','$data[job]','$atklevel','$minelevel','$craftlevel','$island')";
				
	mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
	$user_id = mysql_insert_id($link);  
	$md5_id = md5($user_id);
	mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
	mysql_query("INSERT INTO items (`typ`,`level`,`user`) VALUES ('6','2','$user_id')") or die(mysql_error());

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

	  header("Location: index.php");  
	  exit();
		 
	} 
 }					 

?>
<html>
	<head>
		<title>Runewater ver:A1</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="codepage.js"></script>
		
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
		<header>
			<a href="index.php"><img src="http://icons.iconarchive.com/icons/gakuseisean/radium/128/Key-icon.png"></a>
			<a href="register.php"><img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/96/Actions-document-sign-icon.png"></a>
			<b>Rune</b><b>Water</b>
		</header>
		<article>
		<aside id="error">
		<?php 
			if (isset($_GET['done'])) {
				echo'<h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>';
				exit();
			}
		?>
		<?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?> 
		</aside>
		<section id="register">
			<form action="register.php" method="post" name="regForm" id="regForm" >
				<table>
					<tr class="header">
						<td colspan="3">Neuen Spieler Anmelden</td>
					</tr>
					<tr>
						<td>Spielername: <input name="user_name" type="text" id="full_name" size="20" class="required"></td>
						<td><input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			    <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> </td>
						<td>E-mail: <input name="usr_email" type="text" id="usr_email3" class="required email"></td>
					</tr>
					<tr>
						<td>Passwort:</td>
						<td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> </td>
						<td>Wiederholen: <input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
					</tr>
					<tr>
						<td colspan="2">
							<b>Bitte wähle dein Beruf</b><br>
							<i>Der Beruf wird im Laufe des Spieles immer wieder und wieder gewechselt.</i>
						</td>
						<td>
							<select name="job" id="job" class="required">
								<option>*** Berufwählen ***</option>
								<option id="0">Kämpfer</option>
								<option id="1">Helfer</option>
								<option id="2">Erfinder</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Kämpfer</b><br>
							Der Kämpfer ist auf das Kämpfen am Schlachtfeld spezialisiert. Durch seine Fähigkeiten seine eigene Waffen zu reparieren und zu verbessern ist er sehr wenig auf andere Spieler angewiesen.<br>
							<i>Kampfstartlevel: 3<br>
							Abbaustartlevel: 2<br>
							Schmiedestartlevel: 1</i>
						</td>
						<td>
							<b>Helfer</b><br>
							Der Helfer ist auf das soziale spezialisiert. Er kann Waffen reparieren und Runen aufladen. Er ist deswegen ein wichtiger Teil der Community.<br>
							<i>Kampfstartlevel: 1<br>
							Abbaustartlevel: 3<br>
							Schmiedestartlevel: 2</i>
						</td>
						<td>
							<b>Erfinder</b><br>
							Der Erfinder ist auf kaufen und Verkaufen spezialisiert. Er kann anderen Mitspielern, ob Freund oder Feind, seine geschmiedenen Waffen verkaufen. Er kann sowohl mit der Community als auch alleine Spielen.<br>
							<i>Kampfstartlevel: 2<br>
							Abbaustartlevel: 1<br>
							Schmiedestartlevel: 3</i>
						</td>
					</tr>
					<tr><td colspan="3"><input name="doRegister" type="submit" id="doRegister" value="Register"></td></tr>
					<!--<tr> 
            <td width="22%"><strong>Image Verification </strong></td>
            <td width="78%"> 
              <?php 
			/*require_once('recaptchalib.php');
			
				echo recaptcha_get_html($publickey);*/
			?>
            </td>
          </tr>-->
					
				</table>
			</form>
		</section>
		</article>
		<footer>Copyright by Orasund</footer>
		<script type="text/javascript">
			var ids =["register"];
			changemenu(0);
		</script>
	</body>
</html>