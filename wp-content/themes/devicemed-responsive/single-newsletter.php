<?php  

if(check('source')) {
	ob_start();
}

if($newsletter = $wp_query->post){


$time = strtotime(get_field('date_envoi',$newsletter->ID));
$date = strftime("%e %B %Y",$time);
if(!$date) {
	$date = strftime("%#d %B %Y",$time);
}
$date = utf8_encode($date);


$banners=array('right'=>array(),'top'=>'','bottom'=>'');
$banners['top'] = display_pub(get_field('banniere_horizontale_en_haut',$newsletter->ID));
$banners['bottom'] = display_pub(get_field('banniere_horizontale_en_bas',$newsletter->ID));

$attr['style'].='width:125px;';


foreach(get_field('bannieres_verticales') as $tmp) {
	$banners['right'][] = display_pub($tmp['banniere_verticale']);
}
$titre_disp = get_field('titre_disp',$newsletter->ID);

$urls = array();
$args = array( 
    'post_type' => 'post',
    'tag' => get_field('mot_cle',$newsletter->ID)
);
if($posts = new WP_Query($args)) {
	foreach($posts->posts as $post) {
		$urls[]=get_permalink($post->ID);
	}
}
$articles = array();
foreach($urls as $url) {
	if(is_array($url)) {
		$data = $url;
		$url = $data['url'];
	} else {
		$data=false;
	}
	$tmp = file_get_contents(str_replace('.local','.fr',$url));
	$content = getHtmlVal('<div class="content">','</article>',$tmp);
	$text = !empty($data['text']) ? $data['text'] : (cleantext(getHtmlVal('<p><strong>','</strong></p>',$content)));
	$image = (getHtmlVal('<div class=\'image_clicable\'><a href="','"',$tmp));
	$title = (getHtmlVal('<h1 class="title">','</h1>',$tmp));
	$category = !empty($data['category']) ? $data['category'] : (getHtmlVal('<span class="category">','</span>',$tmp));
	$articles[] = array('text'=>$text,'image'=>$image,'category'=>$category,'title'=>$title,'url'=>add_utm($url));
}


?><!DOCTYPE html>
<html lang="fr">


<head>

	<meta charset="UTF-8">
	<title><?php echo $newsletter->post_title;?></title>
</head>
<body>
<center><a href="[[PERMALINK]]" style="font-family:sans-serif;font-size:10px;">Si vous ne visualisez pas bien cet email, cliquez ici pour voir la version en ligne.</a></center>
<p></p>

  <table border="0" cellspacing="0" width="100%">
    <tr>
        <td></td>
        <td width="850" valign=top>

    <table cellspacing="0" cellpadding="0" width="100%" border="0" align="center" style=
    "border:0;"
    id="wrapper">
      <tbody>
		  <tr>
		  <td style="height:35px; background-color:#454545;font-size:2px">&nbsp;</td>
          <td rowspan="3" width="10" valign="top">&nbsp;</td>

          <td rowspan="3" width="127" valign="top" style="width:127px;">

				<?php if(isset($banners['right'])) { ?>
					<?php foreach($banners['right'] as $ban) { ?>
						<?php echo $ban;?>
					<?php }?>
				<div>&nbsp;</div>
				<?php }?>


          </td>
		  </tr>
		  <tr>
		  <td style="border-bottom:1px solid #454545;">
		  <a style="border:none" href=
                  "http://www.devicemed.fr/"><img width="290" title="logo" alt="newsletter" src=
                  "http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/devicemedbig.png" /></a>
		</td>
		</tr>

        <tr>
          <td valign="top" bgcolor=white>
				<?php if(isset($banners['top'])) { ?>
					<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-top:10px;border-bottom:1px dotted #555;" width="100%"><tbody><tr>
						<td align="center" style="padding-bottom:10px;">
						<?php echo $banners['top'];?>
						</td>
					</tr></tbody></table>
					
				<?php }?>
            <table 
            width="100%" id="top_news">
              <tbody>
                <tr>
                  <td align="left">
<center><h2 style="font-size:14px;color:#333;font-family:Arial;"><?php if(!empty($titre_disp)) { echo $titre_disp; } else {?>Newsletter du <?php echo $date;?><?php }?></h2>
                  	</center>                  </td>
                </tr>
              </tbody>
            </table>
				
            <table width="100%" style=
            "border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:0px;"
            id="content">
              <tbody>
				<?php $cpt=0;foreach($articles as $article) {$cpt++;?>
                <tr>
                  <td style="border-bottom:1px dotted #555;font-size:0.1px" colspan="2"></td>
				 </tr>
                <tr>
                  <td width="128" valign="top" style=
                  "width:128px;padding-bottom:15px;padding-top:20px;">
                  <a href=
                  "<?php echo $article['url'];?>"
                  target="_blank"><img style="border:solid 1px #FFFFFF;" width="120"
                  height="auto" align="left" alt="img6" src=
                  "<?php echo $article['image'];?>" /></a></td>

                  <td style=
                  "padding-bottom:15px;padding-top:20px;"
                   valign="top">
                    <div>
                    <a style="margin:0px;text-decoration:none;" href=
                    "<?php echo $article['url'];?>"
                    target="_blank"><span style=
                    "font-size:12px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:#333333;">
                    <?php echo $article['category'];?></span></a></div>

                    <div><a style="margin:0px;text-decoration:none;"
                    href=
                    "<?php echo $article['url'];?>"
                    target="_blank"><span style=
                    "font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:#005ea8;">
                    <?php echo $article['title'];?></span></a></div>

                    <div style=
                    "font-size:14px;line-height:21px;font-family:Arial;color:#333;margin-top:5px;">
                    <?php echo strip_tags($article['text']);?>&nbsp; <a style=
                    "text-decoration:none;" href=
                    "<?php echo $article['url'];?>"
                    target="_blank"><span style="color:#005ea8;">Lire la
                    suite...</span></a></div>
                  </td>
                </tr>
				<?php if(isset($ads[$cpt])) { $ad = $ads[$cpt];?>

<tr>
<td style="border-bottom:1px dotted #555;" colspan="2"></td>
</tr>
<tr><td colspan="2">

  <table border="0" cellspacing="0" width="100%">
    <tr>
        <td></td>
        <td width="500" valign=top>

			<div style="padding:10px">
			<span style="font-size:12px;font-family:Helvetica,Arial,sans-serif;color:#999;">Annonce</span>
			<div style="border:1px solid #333;padding:10px">
			<?php if(!empty($ad['image'])) {?>
				<a <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?> target="_blank"><img style="border:solid 1px #FFFFFF;padding-right:10px;" width="100" height="auto" align="left" alt="img6" src="<?php echo $ad['image'];?>"></a>
				<p style="margin:0px;padding-left:140px;">
			<?php } else {?>
				<p style="margin:0px;">
			<?php }?>
				<a style="margin:0px;text-decoration:none;" <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?> target="_blank"><span style="font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:black;"><?php echo $ad['title'];?></span></a></p>

			<?php if(!empty($ad['image'])) {?>
				<p style="padding-left:140px;font-size:12px;line-height:21px;font-family:Arial;color:#333;margin:0px;">
			<?php } else {?>
				<p style="font-size:12px;line-height:21px;font-family:Arial;color:#333;margin:0px">
			<?php }?>

			<?php echo $ad['text'];?>
			&nbsp;<a target="_blank" style="text-decoration:none;" <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?>><span style="color:#005ea8;"><?php echo !empty($ad['lien']) ? $ad['lien'] : 'Lire la suite';?></span></a>
			</p></div></div>
		</td>
		<td></td>
	</tr>
	</table>

</td></tr>



				<?php }?>
				<?php }?>


              </tbody>
            </table><!---->

				<?php if(isset($banners['bottom'])) { ?>
					<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-left:10px;margin-top:10px;border-top:1px dotted #555;" width="700" id="top_news"><tbody><tr>
						<td align="center" style="padding-top:10px;padding-bottom:10px;"><?php echo $banners['bottom'];?></td>
					</tr></tbody></table>
					
				<?php }?>

            <table width="100%" style=
            "border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:0px"
            id="footer">
              <tbody>
                <tr>
                  <td style="font-family:Arial; font-size:12px">
                    <table cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <td style=
                          "padding-bottom:10px;padding-top:20px;padding-left:10px;padding-right:10px;background-color:#c7c7c7">
                          <table width="100%">
                              <tbody>
                                <tr>
                                  <td align="left"><a href=
                                  "http://news.vogel.de/inxmail2/d?q00wueoq0eqfngbii000000000000000ietwqbri3277">
                                  <img src=
                                  "http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/newsletter/nl20/vogel_logo.gif"
                                  alt="Vogel Logo" /></a></td>

                                  <td align="right"></td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr><!---->

                        <tr>
                          <td align="center" style=
                          "font-size:11px;font-family:Arial,Helvetica,sans-serif;padding:10px;background-color:#d2d2d2;text-align:center;">
                          <a style="text-decoration:none;" href=
                          "http://www.devicemed.fr/nous-contacter"><span style=
                          "font-size:12px;color:#b30f1d;text-align:center;">Contact</span></a></td>
                        </tr><!---->

                        <tr>
                          <td style=
                          "PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #616161">
                          <p style=
                          "FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #ffffff; LINE-HEIGHT: 18px">
                            &copy; The French language edition of DeviceMed is a
                            publication of Evelyne Gisselbrecht, licensed by Vogel
                            Business Media GmbH &amp; Co. KG, 97082
                            Wuerzburg/Germany.<br />
                            &copy; Copyright of the trademark &laquo; DeviceMed &raquo;
                            by Vogel Business Media GmbH &amp; Co. KG, 97082
                            Wuerzburg/Germany.<br />
                            Responsable du contenu r&eacute;dactionnel sur <a style=
                            "text-decoration:none;color:#fff;" href=
                            "http://www.devicemed.fr/">www.devicemed.fr</a> : Evelyne
                            Gisselbrecht, &eacute;ditrice de DeviceMed, 33 rue du
                            Puy-de-D&ocirc;me, 63370 Lempdes France</p>
                          </td>
                        </tr>
                      </tbody>
                    </table><!---->
                  </td>
                </tr>

                <tr>
                  <td style="text-align:center;font-family:Arial;font-size:11px">
    <p style="text-align: center">Cet email a été envoyé à <a href="mailto:[[EMAIL_TO]]">[[EMAIL_TO]]</a>, <a href="[[UNSUB_LINK_FR]]">cliquez ici pour vous désabonner</a>.</p>
				  </td>
                </tr>
              </tbody>
            </table>
          </td>

        </tr>
      </tbody>
    </table>
<center><a href="[[PERMALINK]]" style="font-family:sans-serif;font-size:10px;">Si vous ne visualisez pas bien cet email, cliquez ici pour voir la version en ligne.</a></center>

  </td>
  <td></td>
  </tr>
  </table>
</body>
</html>
<?php }
if(check('source')) {
	$page = ob_get_contents();
	ob_end_clean();
	$page = sanitize_output($page);
	?>

<!DOCTYPE html>
<html lang="fr">


<head>

	<meta charset="UTF-8">
	<title>Source de <?php echo $newsletter->post_title;?></title>
	<style type="text/css">
	body {
		text-align: center;
		font-family:sans-serif;
	}
	textarea {
		display: block;
		margin: 10px auto;
		width: 90%;
		height: 300px;
	}
	</style>
</head>
<body>
<h1>Code source de &laquo; <?php echo $newsletter->post_title;?> &raquo;</h1>
<textarea readonly="true" class="js-copytextarea" onfocus="this.select()"><?php echo str_replace('>','&gt;',$page);?></textarea>
<p>Clic droit sur la zone de texte, puis "Copier"</p>
</body>
</html>
<?php
}
?>
