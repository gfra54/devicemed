<?php

function get_meta_from_page(){
  if((isset($_POST['action']) && $_POST['action'] == 'get-meta-from-page' )){

    if($url = $_POST['url']) {
      $content=array('url'=>$url);
      $html = file_get_contents($content['url']);
      $content['title'] = str_replace('  –  DeviceMed.fr','',getHtmlVal('<title>','</title>',$html));
    } else {
      $content['title']='Titre du lien';
    }

      header('Content-Type: application/json');
      echo json_encode($content);
      exit;

  }

}
add_action( 'init', 'get_meta_from_page' );
