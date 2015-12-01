<?php
add_action('wp_after_admin_bar_render','top_bar_and_admin_bar');
function top_bar_and_admin_bar() {
		?>
		<script>
		    jQuery(document).ready( function($) {
				_h = $('#wpadminbar').css('height');
				$('.site-barre').css('margin-top',_h);
			});
		</script>
		<?php
}

if(SOCIETY_ENV != 'PRD') {
	add_action('wp_head','display_css_debug');
	function display_css_debug(){
		tag('style','.site-info:before{
			font-size:20px;
			display: block !important;
			position: fixed;
			bottom:0;
			right:0;
			background: pink;
			padding: 5px;
			z-index: 999999999999999999999;
		}');
	}
}