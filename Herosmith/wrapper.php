<?php 
include 'dbc.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="mainstyle.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
 <div id="header">
<? 
if (isset($_SESSION['user_id'])) {?>
  <div id="menu">
   <ul>
    <li><a href="logout.php">Logout </a></li>
    <li><a href="myaccount.php">My Account</a></li>
    <li><a href="mysettings.php">Settings</a></li>
   </ul>
  </div>
<? } else {?>
  <div id="menu">
   <ul>
    <li><a href="login.php">Login</a></li>
    <li><a href="register.php">Anmelden</a></li>
    <li><a href="forgot.php">Passwort vergessen</a></li>
    <li><a href="activate.php">Activate Account</a></li>
   </ul>
  </div>
<? } ?>
<!-- end #menu -->
 </div>
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->

 <div id="page">
