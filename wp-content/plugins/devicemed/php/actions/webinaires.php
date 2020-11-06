<?php

add_action( 'init', function() {

	if(isset($_POST['inscription-webinaire'])) {
		$message=false;
		$webinaire = $_POST['webinaire'];
		$participant = $webinaire['participant'];
		$participant['optin']=$participant['optin']=='true';

		if($webinairePost = get_post($webinaire['post_id'])) {
			$participants = get_field('participants',$webinairePost->ID);
			if(dejaParticipant($participants, $participant['email'])) {
				$message='dejaParticipant';
			} else {
				$message='inscriptionOk';
				add_row('participants', $participant, $webinairePost->ID);
			}

			wp_redirect( esc_url( add_query_arg( 'message', $message, get_permalink($post) ) ) );
			exit;

		}


	}

});

function webinairePlaces($post) {
	return $post->places_disponibles - webinaireParticipants($post);

}
function webinaireParticipants($post) {
	$participants = get_field('participants',$post->ID);
	return count($participants);

}

function dejaParticipant($participants, $email) {
	foreach($participants as $participant) {
		if($participant['email'] == $email) {
			return $participant;
		}
	}
}

function mea_webinaire() {

	$args = array( 
		'posts_per_page'=>1,
		'order'=>'DESC',
		'orderby'=>'date',
		'post_type'=> 'webinaire',
		'meta_key'		=> 'mise_en_avant',
		'meta_value'	=> 1

	);
	if($posts = new WP_Query($args)) {
		foreach($posts->posts as $post) {
			$cover = get_the_post_thumbnail_url($post->ID,'full'); 
			$url = get_permalink($post->ID);

			$code = '<section class="home-last-posts" id="mea-webinaire">';
			if($cover) {
				$code.= '<div class="magazine-cover"><a href="'.$url.'"><img style="object-fit:cover" src="'.$cover.'"></a></div>';
			}
			$code.= '<div class="magazine-details">';
			
			$code.='<div class="magazine-surtitre">Webinaire</div>';
			$code.='<div class="magazine-titre"><a href="'.$url.'">'.$post->post_title.'</a></div>';
			$code.='<div class="magazine-texte">'.$post->description.'</div>';
			$code.='<div class="magazine-boutons">';
			$code.='<a href="'.$url.'" class="">En savoir plus</a>';
			$code.='<a href="'.$url.'#formulaire" class="bouton-abo">S\'inscrire au webinaire</a>';
			$code.= '</div>';
			$code.= '</section>';
			echo $code;


		}
	}
}