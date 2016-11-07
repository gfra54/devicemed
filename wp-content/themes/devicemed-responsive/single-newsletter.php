<?php  

if(check('source')) {
  ob_start();
}

if($newsletter = $wp_query->post){

$position_du_bloc_partenaire = get_field('position_du_bloc_partenaire',$newsletter->ID);
$afficher_le_bloc_partenaire = get_field('afficher_le_bloc_partenaire',$newsletter->ID);

if(empty($position_du_bloc_partenaire)) {
  $position_du_bloc_partenaire=1;
}
$date = datefr(get_field('date_envoi',$newsletter->ID));


$banners=array('right'=>array(),'top'=>'','dans_article'=>'','bottom'=>'');
$banners['top'] = display_pub(get_field('banniere_horizontale_en_haut',$newsletter->ID));
$banners['dans_article'] = display_pub(get_field('banniere_dans_articles',$newsletter->ID));
$banners['bottom'] = display_pub(get_field('banniere_horizontale_en_bas',$newsletter->ID));

$attr['style'].='width:125px;';


foreach(get_field('bannieres_verticales') as $tmp) {
  $banners['right'][] = display_pub($tmp['banniere_verticale']);
}
$titre_disp = get_field('titre_disp',$newsletter->ID);

$ids = array();
$args = array( 
    'post_type' => 'post',
    'tag' => get_field('mot_cle',$newsletter->ID)
);
$articles = array();

if($arts = new WP_Query($args)) {
  foreach($arts->posts as $art) {
    $content=false;
    if(substr($art->post_content, 0, 8) == '<strong>') {
      $content = trim(couper(cleantext(getHtmlVal('<strong>','</strong>',$art->post_content)),300));
    }
    if(!$content) {
      $content = couper(cleantext($art->post_content),300);
    }
    $image = wp_get_attachment_url(get_post_thumbnail_id($art->ID));
    $title = $art->post_title;

    $cats = get_the_category($art->ID);
  //    $category = !empty($data['category']) ? $data['category'] : (getHtmlVal('<span class="category">','</span>',$tmp));
    $category='';
    foreach($cats as $cat) {
      $category.= $category ? ' / ' : '';
      $category.= $cat->name;
    }
    $articles[] = array('text'=>$content,'image'=>$image,'category'=>$category,'title'=>$title,'url'=>add_utm(get_permalink($art->ID)));
    }
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
          <td></td>
          <td rowspan="3" width="10" valign="top">&nbsp;</td>

          <td rowspan="3" width="127" valign="top" style="width:127px;">

        <?php if(isset($banners['right'])) { ?>
          <?php foreach($banners['right'] as $cpt=>$ban) {if($ban) { $cpt++;?>

      <?php if($position_du_bloc_partenaire == $cpt) {
        bloc_partenaires();
      }?>     



           <?php
      $ban = str_replace('<a ','<a style="display:block" ',$ban);
      if(strstr($ban,'<img style="')!==false) {
              $ban = str_replace('<img style="','<img width="127" style="display:block;',$ban);
      }else {
              $ban = str_replace('<img ','<img style="display:block" width="127" ',$ban);
      }
            echo $ban;
            ?>
            <?php espace(8);?>
          <?php }}?>
         <?php }
     bloc_partenaires();
     ?>

    

          </td>
      </tr>
      <tr>
      <td _style="border-bottom:1px solid #454545;" bgcolor="#0066b3">&nbsp; 
      <a style="border:none" href=
                  "<?php echo site_url();?>/"><img width="290" title="logo" alt="newsletter" src=
                  "<?php echo site_url();?>/wp-content/themes/devicemed-responsive/images/devicemedbig.png" /></a>
    </td>
    </tr>

        <tr>
          <td valign="top" bgcolor=white>
        <?php if(isset($banners['top'])) { ?>
        <?php espace(10);?>
          <table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;border-bottom:1px dotted #555;" width="100%"><tbody><tr>
            <td align="center">
            <?php echo $banners['top'];?>
            <?php espace(10);?>
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
                    "font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:#0066b3;">
                    <?php echo $article['title'];?></span></a></div>

                    <div style=
                    "font-size:14px;line-height:21px;font-family:Arial;color:#333;margin-top:5px;">
                    <?php echo strip_tags($article['text']);?>&nbsp; <a style=
                    "text-decoration:none;" href=
                    "<?php echo $article['url'];?>"
                    target="_blank"><span style="color:#0066b3;">Lire la
                    suite.</span></a></div>
                  </td>
                </tr>
        <?php if($cpt ==2 && $banners['dans_article']) {;?>

<tr>
<td style="border-bottom:1px dotted #555;" colspan="2"></td>
</tr>
<tr><td colspan="2" aling="center" style="text-align:center">
<?php espace(10);?>
<?php echo $banners['dans_article'];?>
<?php espace(10);?>
</td></tr>



        <?php }?>
        <?php }?>


              </tbody>
            </table><!---->

        <?php if(isset($banners['bottom'])) { ?>
            <?php espace(10);?>
            <table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-left:10px;border-top:1px dotted #555;" width="700" id="top_news"><tbody><tr>
            <td align="center" style="padding-top:10px;"><?php echo $banners['bottom'];?>
            <?php espace(10);?>
            </td>
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

function espace($nb){
?>
<table border=0><tr><td height=<?php echo $nb;?>></td></tr></table>
<?php  
}
function marge($nb) {
?>
    <td width=<?php echo $nb;?>>&nbsp;</td>
<?php }

$GLOBALS['bloc_partenaires']=false;
function bloc_partenaires() {
  global $afficher_le_bloc_partenaire;
  if($afficher_le_bloc_partenaire && !$GLOBALS['bloc_partenaires']) {
    $sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_premium=1 AND supplier_status=1 ORDER BY supplier_name ASC";
    $resultFournisseurs = mysql_query($sqlFournisseurs);
    $nbFournisseurs = mysql_num_rows($resultFournisseurs);
      
    $fournisseurs = array();
    while($rowFournisseurs = mysql_fetch_assoc($resultFournisseurs)) {
      $nom = wp_trim_words($rowFournisseurs['supplier_name'],2,'');
      if(strstr($nom,'Heptal') !== false) continue;
      $nom = str_replace('Composites','Comp.',$nom);
      $nom = str_replace('Medical','Med.',$nom);
      $nom = str_replace('Medical','Med.',$nom);
      $nom = str_replace('Balzers','',$nom);
      $nom = str_replace('Technologies','Tech.',$nom);
      $nomFournisseur = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($rowFournisseurs['supplier_name']);
      $fournisseurs[$rowFournisseurs['ID']]=array('nom'=>$nom,'nomFournisseur'=>$nomFournisseur);
    }

    
    $GLOBALS['bloc_partenaires']=true;
    ?>
    <table width="127" bgcolor="#0066b3" cellpadding="0" cellspacing="10">
    <tr>
    <td align="center"> 
    <font face="sans-serif" color="white" style="font-size:11px;">
    <b>FOURNISSEURS PARTENAIRES</b>
    </font>
    </td>
    </tr>
    <?php $cpt=0;foreach($fournisseurs as $id=>$data) {?>
      <tr>
      <td bgcolor="white" align=center>    
        <table width="100%" cellpadding="3"><td color=white align=center>
        <a style="text-decoration:none;" href="http://www.devicemed.fr/suppliers/<?php echo $data['nomFournisseur'];?>/<?php echo $id;?>">
          <font face="sans-serif"  color="#0066b3" style="font-size:11px;text-decoration:none;">
            <b style="text-decoration:none;">
              <?php echo $data['nom'];?>
            </b>
          </font>
        </a>
        </td></table>
      </td>
      </tr>
    <?php $cpt++;}?>
    </table>
    <?php espace(8);?>

<?php }
}