<?php  
  ob_start();

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
    $articles_sorted=array();
    $ordre_articles = explode("\n",strip_tags(get_field('ordre_articles',$newsletter->ID)));
    foreach($ordre_articles as $idart) {
      $idart = trim($idart);
      if($idart) {
        $articles_sorted[$idart]=true;
      }
    }
    foreach($arts->posts as $art) {
      $articles_sorted[$art->ID]=$art;
    }
    foreach($articles_sorted as $art) {
      $content=false;
      if(substr($art->post_content, 0, 8) == '<strong>') {
        $content = trim(couper(cleantext(getHtmlVal('<strong>','</strong>',$art->post_content)),300));
      }
      if(!$content) {
        $content = couper(cleantext($art->post_content),300);
      }

  //    $image = wp_get_attachment_url(get_post_thumbnail_id($art->ID));
    $tmp = wp_get_attachment_image_src(get_post_thumbnail_id($art->ID));
    $image = $tmp[0];
    $title = $art->post_title;

      $cats = get_the_category($art->ID);
    //    $category = !empty($data['category']) ? $data['category'] : (getHtmlVal('<span class="category">','</span>',$tmp));
      $category='';
      foreach($cats as $cat) {
        $category.= $category ? ' / ' : '';
        $category.= $cat->name;
      }
      $articles[] = array('id'=>$art->ID,'text'=>$content,'image'=>$image,'category'=>$category,'title'=>$title,'url'=>add_utm(get_permalink($art->ID)));
      }
  }



if(!empty($_GET['brut'])) {
  include 'single-newsletter-brut.php';
} else {


  ?><!DOCTYPE html>
  <html lang="fr">


  <head>

    <meta charset="UTF-8">
    <title><?php echo $newsletter->post_title;?></title>
  </head>
  <body>
  <center><a href="*|ARCHIVE|*" style="font-family:sans-serif;font-size:10px;">Si vous ne visualisez pas bien cet email, cliquez ici pour voir la version en ligne.</a></center>
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
        <td _style="border-bottom:1px solid #454545;">
        <table width="100%"><tr><td bgcolor="#0066b3">&nbsp; 
        <a style="border:none" href="<?php echo site_url();?>/"><img width="290" title="logo" alt="newsletter" src="<?php echo site_url();?>/wp-content/themes/devicemed-responsive/images/devicemedbig.png" /></a>
        </td>
        <td>&nbsp;</td>
        <td bgcolor="#0066b3" valing="middle" align=center width=340><a href="<?php echo site_url();?>/magazine/abonnement"><img src="<?php echo site_url();?>/wp-content/themes/devicemed-responsive/images/newsletter/nl-abonnement-magazine.png" border=0></a></td></tr></table>
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
                    height="auto" align="left" alt="img6" src="<?php echo $article['image'];?>" /></a></td>

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
                                    <img src="data:image/png;base64,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"
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
                              publication of Tipise SAS, licensed by Vogel Communications Group GmbH & Co. KG, 97082
                              Wuerzburg/Germany.<br />
                              &copy; Copyright of the trademark &laquo; DeviceMed &raquo;
                              by Vogel Communications Group GmbH & Co. KG, 97082
                              Wuerzburg/Germany.<br />
                              Responsable du contenu r&eacute;dactionnel sur <a style=
                              "text-decoration:none;color:#fff;" href=
                              "http://www.devicemed.fr/">www.devicemed.fr</a> : TIPISE SAS, Evelyne
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
      <p style="text-align: center">Cet email a été envoyé par DeviceMed à *|EMAIL|*, <a href="*|UNSUB|*">cliquez ici pour vous désabonner</a>.</p>
            </td>
                  </tr>
                </tbody>
              </table>
            </td>

          </tr>
        </tbody>
      </table>
    
  <center><a href="*|ARCHIVE|*" style="font-family:sans-serif;font-size:10px;">Si vous ne visualisez pas bien cet email, cliquez ici pour voir la version en ligne.</a></center>

    </td>
    <td></td>
    </tr>
    </table>
  </body>
  </html>
  <?php }
}
  $page = ob_get_contents();
  ob_end_clean();
  /*
  $cpt=1;
  $replace=array();
  while($url = getHtmlVal('src="','"',$page,$cpt)) {
    if(strstr($url,'http://www.devicemed.fr/')!==false) {
      $ext = strtolower(getExtension($url));
      if(in_array($ext,array('png','jpg','jpeg','gif'))!==false) {
        if(file_exists($file)) {
          $file = urlToPath($url);
          $imagedata = base64_encode(file_get_contents($file));
          $data = 'data: '.mime_content_type($file).';base64,'.$imagedata;
          $replace[$url] = $data;
        }
      }
    }
    $cpt++;
  }
  foreach($replace as $url=>$data) {
    $page = str_replace($url,$data,$page);
  }*/

  $page = str_replace('src="http://www.devicemed.fr/','src="https://www.devicemed.fr/',$page);
  if(!check('source')) {
    echo $page;
  } else {
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
      $fournisseurs = get_fournisseurs(array('premium'=>true));
      foreach($fournisseurs as $fournisseur) {
        $nom = wp_trim_words($fournisseur['post_title'],2,'');
        $nom = str_replace('Composites','Comp.',$nom);
        $nom = str_replace('Medical','Med.',$nom);
        $nom = str_replace('Medical','Med.',$nom);
        $nom = str_replace('Balzers','',$nom);
        $nom = str_replace('Technologies','Tech.',$nom);
        $data_fournisseurs[$fournisseur['ID']]=array('nom'=>$nom,'url'=>$fournisseur['permalink']);
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
      <?php $cpt=0;foreach($data_fournisseurs as $id=>$data) {?>
        <tr>
        <td bgcolor="white" align=center>    
          <table width="100%" cellpadding="3"><tr><td color=white align=center>
          <a style="text-decoration:none;" href="<?php echo $data['url'];?>">
            <font face="sans-serif"  color="#0066b3" style="font-size:11px;text-decoration:none;">
              <b style="text-decoration:none;">
                <?php echo $data['nom'];?>
              </b>
            </font>
          </a>
          </td></tr></table>
        </td>
        </tr>
      <?php $cpt++;}?>
      </table>
      <?php espace(8);?>

  <?php }
}