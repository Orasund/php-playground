<?
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['user_name'] = $_COOKIE['user_name'];
   }

//check for cookies

if(isset($_SESSION['user_id']))
{
echo '
 <div id="header">
  <div id="menu">
   <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="logout.php">Logout </a></li>
    <li><a href="myaccount.php">Spielen</a></li>
    <li><a href="mysettings.php">Settings</a></li>
   </ul>
  </div>
<!-- end #menu -->
 </div>';
} else {
echo '
 <div id="header">
  <div id="menu">
   <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="register.php">Anmelden</a></li>
    <li><a href="forgot.php">Passwort vergessen</a></li>
   </ul>
  </div>
<!-- end #menu -->
 </div>';
}
?>

