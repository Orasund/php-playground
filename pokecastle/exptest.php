<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbenanntes Dokument</title>
</head>
<?php

	$varIp = 1;
	while ($varIp != 6) {
		echo "<b>Intelligenz_Plus ist " . $varIp . ":</b><br>";
		$varL = 1;
		$varI = $varIp;
		$varTOTAL = 0;
		while ($varL != 16) {
			$erf_exp = floor($varL * (7 - ($varI / $varL)));
			//$erf_exp = floor((5 / ($varI / $varL) * $varL));
			echo 'Level: ' . $varL . ' | Intelligenz: ' . $varI . ' | Exp für nächsten Level:' . $erf_exp . '<br>';
			$varI += $varIp;
			$varL += 1;
			$varTOTAL += $erf_exp;
		}
		echo "Total: " . $varTOTAL . "<br><br>";
		$varIp += 1;
	}
?>
<body>
</body>
</html>