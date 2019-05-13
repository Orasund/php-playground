<?php
	/*************** PHP LOGIN SCRIPT V 2.3*********************
	(c) Balakrishnan 2009. All Rights Reserved

	Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

	Limitations:
	- This script cannot be sold.
	- This script should have copyright notice intact. Dont remove it please...
	- This script may not be provided for download except from its original site.

	For further usage, please contact me.

	***********************************************************/
	include 'dbc.php';
	$user = "";
	$password = "";
	if(isset($_GET["user"]) && isset($_GET["password"])){
		$user = filter($_GET["user"]);
		$password = filter($_GET["password"]);
	}
	
	$result = mysql_query("SELECT `id`,`pwd`,`approved`,`user_level`,`island` FROM users WHERE user_name='$user' AND `banned` = '0'") or die (mysql_error()); 
	$num = mysql_num_rows($result);
	// Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
		list($id,$pwd,$approved,$user_level,$user_island) = mysql_fetch_row($result);
	
		/**************************************************************
		*****                        ACHTUNG                      *****
		***** während der Alpha kann man ohne Aktivierung spielen *****
		***************************************************************/
		/***if(!$approved) {
			//$msg = urlencode("Account not activated. Please check your email for activation code");
			$err[] = "Account not activated. Please check your email for activation code";
	
			//header("Location: login.php?msg=$msg");
			//exit();
		}***/
	 
		//check against salt
		if ($pwd === PwdHash($password,substr($pwd,0,9))) { 
			// this sets session and logs user in  
			session_start();
			session_regenerate_id (true); //prevent against session fixation attacks.

			// this sets variables in the session 
			$_SESSION['user_id']= $id;  
			$_SESSION['user_name'] = $user;
			$_SESSION['user_level'] = $user_level;
			$_SESSION['user_island'] = $user_island;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
			//update the timestamp and key for cookie
			$stamp = time();
			$ckey = GenKey();
			mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
			//set a cookie 
		
			if(isset($_POST['remember'])){
				setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("user_land", $_SESSION['user_island'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
			}
			echo 0;
		} else {echo 1;}
	} else {echo 2;}
?>