<?php

/*add_filter( 'wp_terms_checklist_args', 'keep_hierarchy_category', 1, 2 );
function keep_hierarchy_category( $args, $post_id ) {

	if(get_post_type() == 'fournisseur') {
		$args[ 'checked_ontop' ] = false;
	}

   return $args;

}

function change_cat_meta_postbox_css(){
	if(get_post_type() == 'fournisseur') {
   ?>
   <style type="text/css">
   #categorie-all {
       max-height: 500px;
       font-size: 70%;
   }

	#categorie-all [name="tax_input[categorie][]"] {
		width: 10px;
	    height: 10px;
	    min-width: 10px;   
	}

	#categorie-all [name="tax_input[categorie][]"]:checked:before {
		margin:-5px 0 0 -8px
	}

   </style><?php
	}
}
add_action('admin_head', 'change_cat_meta_postbox_css');

function change_cat_meta_postbox_js(){
	if(get_post_type() == 'fournisseur') {?>
	<script>
		var _cats='';
		jQuery('#categoriechecklist label').each(function(){
			if(jQuery(this).find('INPUT').prop('checked')) {
				jQuery(this).css({
				    background: 'tomato',
				    color: 'white'
				});
				_cats+= _cats ? ', ' : '';
				_cats+= '<a href="#'+jQuery(this).closest('li').attr('id')+'" class="jump-to-cat">'+jQuery(this).html().replace('<input','<!--').replace('">','-->')+'</a>';
			}
		});
		jQuery('<small><b>Catégories sélectionnées</b>: '+_cats+'</small>').prependTo('#categoriediv .inside');
		jQuery(document).on('click','.jump-to-cat',function(){
			setTimeout('jQuery(window).scrollTop(jQuery("#categoriediv").offset().top);',1);
		});
	</script>
	<?php }	
}
add_action('in_admin_footer', 'change_cat_meta_postbox_js');
*/