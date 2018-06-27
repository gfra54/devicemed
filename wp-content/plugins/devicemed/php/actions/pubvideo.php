<?php 

function pubvideo() {
	if($_GET['pubvideo']) {
?>
<!doctype html>
<html lang="fr">
 <head>
  <meta charset="UTF-8">
	<link rel="stylesheet" href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/css/bootstrap.min.css?t=1507104991" type="text/css"/>
	<link rel="stylesheet" href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/css/default.css?t=1507104991" type="text/css"/>
	<link rel="stylesheet" href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/css/extra.css?t=1511452540" type="text/css"/>
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Video</title>
  <style>#sidebar-issues header .title {font-size:30px;} .more.archives-videos {display:none;}</style>
 </head>
<body style="background:white"><div style="padding-top:100px;font-size:150%;width:500px;margin:0 auto;"><?php afficher_pub('cadre-video');?></div>
</body>
</html>
<?php

		exit;
	}
}

add_action( 'init', 'pubvideo' );