<?php

function get_post_on() {
    $args = array(
        'posts_per_page' => 1,
        'order'          => 'DESC',
        'orderby'        => 'date',
        'tag'            => 'organismes-notifies',
    );
    if ($posts = new WP_Query($args)) {
        return current($posts->posts);
    }

}
function afficher_bloc_on()
{
	if($post = get_post_on()) {
        ?>
<section class="quels-on">
		<header>
			<div class="right-side" style="text-align:center">
				<h1 class="title"><a href="<?php echo get_permalink($post); ?>">QUELS ORGANISMES NOTIFIES POUR LA NOUVELLE REGLEMENTATION ?</a></h1>
			</div>
		</header>

</section>
		<?php

    }

}