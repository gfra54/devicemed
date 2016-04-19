<?php
function notice_fournisseur() {
	if(get_current_screen()->post_type == 'fournisseur' && $_GET['post_status'] == 'draft') {
		$query = new WP_Query(array(
			'post_type'		=> 'fournisseur',
            'post_status' => 'draft'
		   )
		);

		if($query->have_posts()) {
			set_transient('draft-count',$query->post_count);
		} else {
			delete_transient('draft-count');
		}
	} else {
		if($count = get_transient('draft-count')) {
		    ?>
		    <div class="update-nag">
		        <p><?php _e( 'il y a '.$count.' nouveau(x) fournisseur(s) en attente de traitement. <a href="/wp-admin/edit.php?post_status=draft&post_type=fournisseur">Voir la liste</a>', 'sample-text-domain' ); ?></p>
		    </div>
		    <?php
		}
	}
}
add_action( 'admin_notices', 'notice_fournisseur' );

function save_post_fournisseur($post_id) {
	if(is_admin()) {
		if(get_current_screen()->post_type == 'fournisseur') {
			foreach(get_transients('liste-fournisseurs') as $transient) {
				delete_transient($transient);
			}
		}
	}

}
add_action( 'save_post', 'save_post_fournisseur' );



add_action('admin_menu','wphidenag');
function wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}
