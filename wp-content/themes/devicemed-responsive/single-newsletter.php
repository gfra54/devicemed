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
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAAcCAYAAADmx7QjAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjBFRjBFRTU5N0JDMzExRTk4Mzk2ODQ2M0YxREQzN0Q4IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjBFRjBFRTVBN0JDMzExRTk4Mzk2ODQ2M0YxREQzN0Q4Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MEVGMEVFNTc3QkMzMTFFOTgzOTY4NDYzRjFERDM3RDgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MEVGMEVFNTg3QkMzMTFFOTgzOTY4NDYzRjFERDM3RDgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4Dw2XBAAAKsklEQVR42uyb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"
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