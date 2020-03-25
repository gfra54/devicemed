<?php

class DM_Wordpress_Newsletter_Extraire_Admin extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-newsletter';
	protected $page_title = 'Extraire la bdd';
	protected $menu_title = 'Extraire la bdd';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-extraire-bdd';

	public function load()
	{
		$newsletter = new DM_Wordpress_Newsletter_Model();
		$newsletter->extractBdd();
	}

	public function scripts()
	{
		echo '<script type="text/javascript">
		(function($) {
			var actions = $("select[name^=action]");
			actions.on("change", function() {
				actions.val($(this).val());
			});
			$("#list-form").on("submit", function(event) {
				if ($("select[name=action]").val() == "delete") {
					var message = "'.esc_js("Vous êtes sur le point de supprimer DÉFINITIVEMENT les éléments sélectionnés. Cette action est irreversible.").'";
					if (!confirm(message)) {
						event.preventDefault();
					}
				}
			});
		})(jQuery);
		</script>';
	}
}