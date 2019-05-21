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
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAAzCAYAAAAQPQPAAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkIxNEU1NEZEN0JDMDExRTk5OUQ0OTJDOTA1Rjc0N0YzIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkIxNEU1NEZFN0JDMDExRTk5OUQ0OTJDOTA1Rjc0N0YzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QjE0RTU0RkI3QkMwMTFFOTk5RDQ5MkM5MDVGNzQ3RjMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QjE0RTU0RkM3QkMwMTFFOTk5RDQ5MkM5MDVGNzQ3RjMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5J8m6SAAAM+ElEQVR42uxcCTiV2Rv/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"
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