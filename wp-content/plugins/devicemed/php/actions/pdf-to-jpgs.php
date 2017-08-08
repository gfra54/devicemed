<?php

if(isset($_GET['pdf-to-jpgs'])) {

	add_action( 'init', 'pdfToJpgs' );
	function pdfToJpgs() {
		$files = array();
		$args = array( 
			'order'=>'DESC',
			'orderby'=>'date',
			'category_name'=> 'magazine'
		);
		if($posts = new WP_Query($args)) {

			foreach($posts->posts as $post) {
				if(!get_field('pdf-to-jpgs',$post->ID)) {
					$pdf = urlToPath(get_field('fichier_pdf',$post->ID));
					if(file_exists($pdf)) {
						$name = basename($pdf);
						$dir = dirname($pdf);
						if(strstr($dir, '\\')) {
							$slash='\\';
						} else {
							$slash='/';
						}
						$dir.=$slash.$name.'.jpgs';
						mkdir($dir,0775,true);
						$commands_dir = wp_upload_dir()['basedir'].$slash.'commands';
						if(!is_dir($commands_dir)) {
							mkdir($commands_dir,0775,true);
							file_put_contents($commands_dir.'index.php', '<?php'.PHP_EOL.'// Silence is golden.'.PHP_EOL);
						}
						$file = $commands_dir.$slash.$name.'.command';
						if(file_put_contents($file,'convert '.$pdf.' '.$dir.$slash.$name.'.%04d.jpg')) {
							update_post_meta($post->ID,'pdf-to-jpgs','yes');
							$files[]=$file;
						}
					}
				}
			}
		}
		echo json_encode($files);
		exit;
	}
}