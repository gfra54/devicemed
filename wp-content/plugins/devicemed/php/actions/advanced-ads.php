<?php


add_filter( 'advanced-ads-group-output-array', function($output, $adgroup ) {
    if($previewAd = getPreviewAd($adgroup)) {
        return [$previewAd->output()];
    } else {
        return $output;
    }
}, 10, 3);


add_filter('advanced-ads-ad-select-override-by-group', function ($nope, $adgroup, $ordered_ad_ids) {

    $ads = $adgroup->get_all_ads();

    if($previewAd = getPreviewAd($adgroup)) {
        return $previewAd->output();
    }


    $final = array();

    $prioritaire = false;

    if (is_array($ordered_ad_ids)) {

        foreach ($ordered_ad_ids as $id) {

            $ad = $ads[$id];

            if ($condition = advanced_ads_ok_page($ad->ID)) {

                if (!$prioritaire && get_field('pub_prioritaire', $ad->ID)) {

                    $prioritaire = $id;

                }

                $final[] = $id;

            }

        }

    }

    if ($prioritaire) {

        $final = array($prioritaire);

    }
    return $adgroup->output($final);
    

}, 10, 3);

function advanced_ads_ok_page($id)
{

    $condition = false;

    if ($pages = get_field('pages', $id)) {

        if ($pages == 'urls') {

            if ($ciblage = get_field('urls_cibles', $id)) {

                if (count($ciblage)) {

                    if (is_array($ciblage)) {

                        $ok = false;

                        foreach ($ciblage as $cible) {

                            if (!$ok && $cible['url']) {

                                if ($cible['condition'] == 'contient') {

                                    if ($cible['url'] == 'home') {

                                        $ok = $_SERVER['REQUEST_URI'] == '/';

                                    } else {

                                        $ok = strstr($_SERVER['REQUEST_URI'], $cible['url']) !== false;

                                    }

                                } else {

                                    if ($cible['url'] == 'home') {

                                        $ok = $_SERVER['REQUEST_URI'] != '/';

                                    } else {

                                        $ok = strstr($_SERVER['REQUEST_URI'], $cible['url']) === false;

                                    }

                                }

                                if (!$condition && $ok) {

                                    $condition = print_r($cible, true);

                                }

                            }

                        }

                        if (!$ok) {

                            return false;

                        }

                    }

                }

            }

        } else if ($pages == 'all') {

            $condition = 'all';

        } else if ($pages == 'home') {

            if (is_home() || $GLOBALS['ADVANCED_ADS_PAGE'] == 'home' || $GLOBALS['ADVANCED_ADS_PAGE'] == 'all') {

                $condition = 'is_home';

            } else {

                return false;

            }

        }

    }

    return $condition;

}

add_filter('advanced-ads-output-final', function ($output, $ad, $output_options) {

    $options = $ad->options();

    if ($condition = advanced_ads_ok_page($ad->id)) {
        if ($options['group_info']['id'] == HABILLAGES) {
            //Habillages
            $url = $ad->url;

            $url = site_url().'/linkout/'.$ad->id;

            $image   = get_field('illustration_habillage', $ad->id);
            $hauteur = get_field('hauteur_arche', $ad->id);
            $couleur = get_field('couleur_habillage', $ad->id);

            ?>
            <style>
                @media (min-width:768px){
                   body {
                      background: <?php echo $couleur; ?> url(<?php echo $image; ?>) no-repeat top center !important;
                      cursor: pointer;
                  }
                  body > * {
                      cursor: default;
                  }
                  body > .container {
                      margin-top: 0;
                      background: white;
                      box-shadow: 0 -10px 0px white, -10px -10px 0px white, 10px -10px 0px white;
                  }
                  body:before {
                      content:'';
                      display: block;
                      height: <?php echo $hauteur; ?>px;
                  }
              }
          </style>
          <script>
            $(document).on('click',function(e) {
               let mq = window.matchMedia( '( min-width: 768px )' );
               if(mq.matches) {
                  if(e.target == document.body) {
                     window.open('<?php echo $url; ?>','_blank');
                 }
             }
         })
     </script>
     <?php
 } else if (get_field('afficher_en_text_ad', $ad->id)) {

    $url = getHtmlVal('href="', '"', $output);

    $image = getHtmlVal('src=\'', '\'', $output);

    $params = [

        'image' => $image,

        'title' => get_field('titre_de_la_text_ad', $ad->id),

        'text'  => nl2br(get_field('texte_de_la_pub', $ad->id)),

        'lien'  => get_field('libelle_du_lien', $ad->id),

        'url'   => $url,

    ];

    $output = render_textad($params, 'site', false);

} else if (get_field('pub_video', $ad->id)) {
    $embed_video = get_field('embed_video', $ad->id);
    if (!$embed_video) {
        $tmp         = explode('v=', $ad->url);
        $code        = current(explode('&', $tmp[1]));
        $embed_video = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $code . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }
    $titre_video = get_field('titre_video', $ad->id);
    $output      = '
    <section id="sidebar-tag">
    <header>
    <div class="right-side">
    <h1 class="title">' . $titre_video . '</h1>
    </div>
    </header>
    <article>


    <div class="cadre-video">

    ' . $embed_video . '

    </div>
    <br>
    </article>
    </section>
    <br>
    <style>
    .cadre-video  {
        position:relative;
        width:100%;
        height:0;
        padding-bottom:60%;
    }
    .cadre-video  > * {
        position:absolute;
        width:100%;
        height:100%;
        top:0;
        left:0;
    }
    </style>';

}

$comment = 'Ad ID ' . $ad->id;

if ($condition) {

    $comment .= PHP_EOL . $condition;

}

$output = '<!-- ' . PHP_EOL . $comment . PHP_EOL . ' -->' . $output;

return $output;

}

}, 10, 3);




$GLOBALS['getPreviewAd']=null;
function getPreviewAd($adgroup)
{
    if (isset($_GET['preview-ad'])) {
        $id = $_GET['preview-ad'];
        if(is_null($GLOBALS['getPreviewAd'])) {
            $GLOBALS['getPreviewAd'] = new Advanced_Ads_Ad($id);

/*            $args = [
                'p' => $id,
                'post_status' => 'any',
                'post_type' => 'advanced_ads'
            ];

            $query = new WP_Query();
            if($posts = $query->query( $args )) {
                $GLOBALS['getPreviewAd'] = current($posts);
                $GLOBALS['getPreviewAd']->preview=true;
            }*/
        }
        if($GLOBALS['getPreviewAd']) {
            if(has_term($adgroup->id,'advanced_ads_groups',$id)) {
                return $GLOBALS['getPreviewAd'];
            }
        }
    }
}