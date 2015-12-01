<?php
function enqueue_bunch_of_files($tab){
   foreach($tab as $file){
		if(strstr($file, '*')!==false){
			enqueue_bunch_of_files(glob(ABSPATH.'/'.$file));
		} else {
			$url = site_url().'/'.str_replace(ABSPATH.'/','',$file);
			if(strstr($file, '.css')!==false){
				wp_enqueue_style( basename($file), $url);
			} else {
				$script = basename($file);
				wp_register_script($script, $url,false,false,true);
				
				if($script == 'functions'){
					wp_localize_script( $script, 'screenReaderText', array(
						'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
						'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
					) );
				}

				wp_enqueue_script($script);
			}
		}
    }	
}
function modify_css_js_loading() {
	if (!is_admin()) {
		list(,$css)=each(glob(ABSPATH.'build/global.*.css'));
		if(!$css && constant('SOCIETY_ENV') == 'DEV') {
			wp_register_script('jquery', site_url().'/wp-content/themes/society-magazine/js/dev/00.jquery.min.js', false, '1.11.1');
			wp_enqueue_script('jquery');
            enqueue_bunch_of_files(array(
            	'build/css/*.css',
            	'build/js/*.js'
            ));
		} else {
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.11.1');
			wp_enqueue_script('jquery');

			wp_enqueue_style('global', str_replace(ABSPATH,site_url().'/',$css));

			list(,$js)=each(glob(ABSPATH.'build/global.*.js'));
			wp_register_script('global', str_replace(ABSPATH,site_url().'/',$js),array('jquery'),false,true);
			wp_enqueue_script('global');
			$jsfile = 'global';

			wp_localize_script( $jsfile, 'screenReaderText', array(
				'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
				'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
			) );

			wp_enqueue_style( 'society-fonts', twentyfifteen_fonts_url());
		}

	}
}
add_action('init', 'modify_css_js_loading');

function remove_jquery_migrate( &$scripts) {
    if(!is_admin()) {
        $scripts->remove( 'jquery');
    }
}
add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

