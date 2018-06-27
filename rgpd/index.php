<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


error_reporting(E_ALL);
ini_set('display_errors', '1');

$mail = $_GET['mail'];



if($mail) {
	$mails = file_get_contents('rgpd.json');
	if($mails) {
		$mails = json_decode($mails,true);

	}




	$mails[$mail] = date('d/m/Y H:i:s');

	file_put_contents('rgpd.json',json_encode($mails));
	file_put_contents('rgpd-'.date('Ymdh').'.json',json_encode($mails));
	?>
<!doctype html>
<html lang="fr">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>DeviceMed</title>
  <style>
  body {
  background:#0066b3;
  color:white;
  font-family:sans-serif;
  }
  </style>
 </head>
 <body>
 <p>&nbsp;</p>

<center>
<img src="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/logo-alpha.png">
 <p>&nbsp;</p>
 <p>&nbsp;</p>
<p><small>Votre abonnement à la newsletter devicemed est confirmé.</small></p>
<p><a href="/" style="color:white">Retour</a></p>
</center>
 </body>
</html>

	<?php
}