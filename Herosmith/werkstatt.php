<?
function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	$data = mysql_real_escape_string($data);
	
	return $data;
}

$abfrage = mysql_query("select * from users where id='$User_id'");
while ($ausgabe = mysql_fetch_array($abfrage,MYSQL_ASSOC)) {
$Rang = $ausgabe["Rang"];
$Geld = $ausgabe["Geld"];
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Herosmith</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
function CheckZahl (Wert) {
  if (isNaN(Wert)) {
    alert(Wert + " ist keine Zahl!");
  }
}
</script>
<link href="Designs/
<?
include 'design.php';
?>
" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
<?
include 'menu.php';
?>
<!-- end #header -->
 <div id="logo"></div>
<!-- end #logo -->
<!-- end #header-wrapper -->
 <div id="page">
  <div id="content">
   <div class="post">
    <h2 class="title">
<?
 if($_POST['Typ_wahl']=='Annehmen') {
  foreach($_POST as $key => $value) {
   $data[$key] = filter($value);
  }
  if($data['TypSelect'] == 'Kleidung'){
   echo '
                      Kleidung Herstellen</h2>
    <p>Kleidung verbessert die Werte</p>
    <p>Bitte wähle, was für eine Art von Kleidungsstück du herstellen willst.</p>
    <p>
    <form action="Werkstatt.php" method="post" name="logForm" id="logForm" >
     <select name="TypSelect" size="5">
      <option selected="selected">Hut</option>
     </select>
    </p>
    <p><input name="Art_wahl" type="submit" value="Weiter"></p>
   ';
  }
 } else {
  if($_POST['Art_wahl']=='Annehmen') {
   foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
   }
    echo '
                      Kleidung Herstellen</h2>
      <p>Damit du eine Kleidung entwerfen kannst brauchst musst du folgendes angeben:</p>
      <form action="Werkstatt.php" method="post" name="logForm" id="logForm" >
      <p>Name:<input type="text" name="Name"></p>
       <input type="hidden" name="Typ" value="' . $data['TypSelect'] . '">
       <p>Pro Punkt steigen die Materialkosten um 20 Rubin!</p>
       <p>Punkte anzahl:<input type="text" name="Punkte"></p>
       <p><input name="Punkte_wahl" type="submit" value="Weiter" onclick="CheckZahl(this.form.Punkte.value)"></p>
    ';
  } else {
   if($_POST['Punkte_wahl']=='Weiter'){
   foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
   }
   $Punkte = $data['Punkte'];
   while($Punkte*20 > $Geld){
    $Punkte -= 1;
   }
   echo '
                      Kleidung Herstellen</h2>
    <p>Bevor du die Werte einstellen kannst, musst du die Kleidung erst einmal Zeichnen. Dafür musst du einfach das Bild folgende Bild runterladen und bearbeiten.</p>
    <p><form enctype="multipart/form-data" action="Werkstatt.php" method="post">
    <input type="hidden" name="Typ" value="' . $data['Typ'] . '">
    <input type="hidden" name="Punkte" value="' . $Punkte . '">
    <input type="hidden" name="Name" value="' . $data['Name'] . '">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    <p>Bild für mänliche Charackter hochladen:<input name="userfileM" accept="image/png" type="file"></p>
    <p>Bild für weibliche Charackter hochladen:<input name="userfileW" accept="image/png" type="file"></p>
    <p><input name="Bild_wahl" type="submit" value="Hochladen"></p>
    ';
   } else {
    if($_POST['Bild_wahl']=='Hochladen') {
     $uploadDirM = '/Kleider/M/' . $_POST['Typ'] . '/';
     $uploadDirW = '/Kleider/F/' . $_POST['Typ'] . '/';
     $uploadFileM = $uploadDirM . $_POST['Name'] . '_1_1';
     $uploadFileW = $uploadDirW . $_POST['Name'] . '_1_1';
     if (move_uploaded_file($_FILES['userfileM']['tmp_name'], $uploadFileM && move_uploaded_file($_FILES['userfileW']['tmp_name'], $uploadFileW ))
      echo '
                      Kleidung Herstellen</h2>
    <p>Du besitzt</p>
       
      ';
     }
    } else {
     echo '
                      Werkstatt</h2>
    <p>Hier in der Werkstatt kann man Objekte herstellen, die man danach verkaufen kann.</p>
    <p>Um anzufangen, wähle bitte was du herstellen willst.</p>
    <p>
    <form action="Werkstatt.php" method="post" name="logForm" id="logForm" >
     <select name="TypSelect" size="5">
      <option selected="selected">Kleidung</option>
     </select>
    </p>
    <p><input name="Typ_wahl" type="submit" value="Herstellen"></p>
     ';
    }
   }
  }
 }
?>
   </div>
  </form>
 </div>
<?
include 'sidebar.php';
include 'footer.php';
?>
