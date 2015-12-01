<?php 
function the_comparison_content() {
  global $post;
  $content = $post->post_content;
  $content = str_replace("\r","",str_replace('&nbsp;', ' ',$content));

  $comparison = explode('<!--more-->',$content);
  $final = array();

// récupérer les données
  foreach($comparison as $part){
    $data = array();
    // Récupération du titre
    $data['title'] = getHtmlVal('<h1>','</h1>',$part);

      // enleve toutes les img après le h1
    $data['text'] = strip_tags_empty(strip_tags_specific(getHtmlVal('</h1>','',$part),array('caption','img')));
    $data['text'] = trim($data['text']);

    $data['image1'] = getHtmlVal('src="','"',getHtmlVal('wp-image-','/>',$part));
    $data['image2'] = getHtmlVal('src="','"',getHtmlVal('wp-image-','/>',$part,2));
    
    $data['extra']='';
    $final[]=$data;
  }

  // display la page

  $cpt=0;
  foreach($final as $data){
    $cpt++;

    tag('h2',$data['title']);

    // Image avant
    tag('div.comparison-box,comparison-avant',
      tag('div.comparison-wrapper',
        tag('img[src='.$data['image1'].']','',true).
        tag('span.label,label-avant','Avant',true),true));

    // Image après
    tag('div.comparison-box,comparison-apres',
      tag('img[src='.$data['image2'].']','',true).
      tag('span.label,label-apres','Après',true));

    // Texte descriptif
    tag('p.comparison-txt', $data['text']);
    tag('hr');

    if($cpt == 1){

    }
  }

}
