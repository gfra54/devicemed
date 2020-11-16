<?php

add_filter('post_row_actions', function ($actions, $post) {
    //check for your post type
	if ($post->post_type == "webinaire") {
		$actions['webinaire_calendrier'] = '<a href="?telecharger_calendrier=' . $post->ID . '">Télécharger évènement pour calendrier</a>';
		$actions['webinaire_participants'] = '<a href="?telecharger_participants=' . $post->ID . '">Télécharger la liste des participants</a>';
	}
	return $actions;
}, 10, 2);

add_action('init', function () {

	if (isset($_GET['telecharger_participants'])) {
		$id = $_GET['telecharger_participants'];
		if($post = get_post($id)) {
			$data=[];
			$participants = get_field('participants', $post->ID);
			foreach($participants as $participant) {
				if(!count($data)) {
					$data[] = array_keys($participant);
				}
				$data[] = $participant;
			}

			$out='';
			foreach($data as $ligne) {
				$out.=implode(';',$ligne).PHP_EOL;
			}


			$file = 'webinaire-participants-'.sanitize_title($post->post_title);
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-Disposition: attachment; filename=".$file."-".date('Y-m-d-h-i-s').'.csv');
			echo utf8_decode(trim($out));	
			exit;
		}
	}


	if (isset($_GET['telecharger_calendrier'])) {
		$id = $_GET['telecharger_calendrier'];

		if($post = get_post($id)) {
			require_once plugin_dir_path( __FILE__ ).'../ics.php';
			$fin = date('Y-m-d H:i:s',strtotime($post->date)+($post->duree*3600));
			$url = get_the_permalink($post);
			$ics = new ICS(array(
				'location'    => $post->visio,
				'description' => 'Pour assister au webinaire, ouvrez la page '.$post->visio.' dans votre navigateur web le '. date('d/m/Y', strtotime($post->date)).' à '.date('H:i', strtotime($post->date)).'. Plus d\'information sur notre site '.$url.'. '.$post->description,
				'dtstart'     => $post->date,
				'dtend'       => $fin,
				'summary'     => $post->post_title.' / DeviceMed',
				'url'         => $url,
			));

			$nom = sanitize_title('webinaire '.$post->post_title.' devicemed');

			header('Content-Type: text/calendar; charset=utf-8');
			header('Content-Disposition: attachment; filename='.$nom.'.ics');
			echo $ics->to_string();
			exit;
		}

	}
});

add_action('init', function () {

	if (isset($_POST['inscription-webinaire'])) {
		$message              = false;
		$webinaire            = $_POST['webinaire'];
		$participant          = $webinaire['participant'];
		$participant['optin'] = $participant['optin'] == 'true';

		if ($webinairePost = get_post($webinaire['post_id'])) {
			$participants = get_field('participants', $webinairePost->ID);
			if (dejaParticipant($participants, $participant['email'])) {
				$message = 'dejaParticipant';
			} else {
				$message = 'inscriptionOk';
				add_row('participants', $participant, $webinairePost->ID);
			}

			wp_redirect(esc_url(add_query_arg('message', $message, get_permalink($post))));
			exit;

		}

	}

});

function webinairePlaces($post)
{
	return $post->places_disponibles - webinaireParticipants($post);

}
function webinaireParticipants($post)
{
	$participants = get_field('participants', $post->ID);
	return count($participants);

}

function dejaParticipant($participants, $email)
{
	foreach ($participants as $participant) {
		if ($participant['email'] == $email) {
			return $participant;
		}
	}
}

function mea_webinaire()
{

	$args = array(
		'posts_per_page' => 1,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_type'      => 'webinaire',
		'meta_key'       => 'mise_en_avant',
		'meta_value'     => 1,

	);
	if ($posts = new WP_Query($args)) {
		foreach ($posts->posts as $post) {
			$cover = get_the_post_thumbnail_url($post->ID, 'full');
			$url   = get_permalink($post->ID);

			$code = '<section class="home-last-posts" id="mea-webinaire">';
			if ($cover) {
				$code .= '<div class="magazine-cover"><a href="' . $url . '"><img style="object-fit:cover" src="' . $cover . '"></a></div>';
			}
			$code .= '<div class="magazine-details">';

			$code .= '<div class="magazine-surtitre">Webinaire</div>';
			$code .= '<div class="magazine-titre"><a href="' . $url . '">' . $post->post_title . '</a></div>';
			$code .= '<div class="magazine-texte">' . $post->description . '</div>';
			$code .= '<div class="magazine-boutons">';
			$code .= '<a href="' . $url . '" class="">En savoir plus</a>';
			$code .= '<a href="' . $url . '#formulaire" class="bouton-abo">S\'inscrire au webinaire</a>';
			$code .= '</div>';
			$code .= '</section>';
			echo $code;

		}
	}
}
