<?php

class DM_Wordpress_Banniere_Admin_List extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-bannieres';
	protected $page_title = 'Banniéres';
	protected $menu_title = 'Toutes les Banniéres';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-bannieres';

	public function render()
	{
		$filters = array();
		$current_page = 1;
		$results_per_page = 20;

		$banniere = new DM_Wordpress_Banniere_Model();

		if (!empty($_GET['action']) AND !empty($_GET['banniere_id']))
		{
			if ($_GET['action'] == 'delete')
			{
				$banniere->admin_list_bulk_delete($_GET['banniere_id']);
			}
		}
		
		if (!empty($_GET['orderby']) AND !empty($_GET['order']))
		{
			$filters+= array(
				'orderby' => (string) $_GET['orderby'],
				'order' => (string) $_GET['order']
			);
		}
		if (!empty($_GET['search']) AND trim($_GET['search']))
		{
			// WordPress magic_quotes hell...
			$_GET['search'] = stripslashes($_GET['search']);
			$filters+= array('search' => (string) $_GET['search']);
		}
		
		if (!empty($_GET['paged']))
		{
			$current_page = (int) $_GET['paged'];
		}

		
		$results = $banniere->admin_list($current_page, $results_per_page, $filters);
		$count_all = $banniere->admin_list_count_all();

		$navigation = array(
			'first' => 1,
			'previous' => $current_page > 1 ? $current_page - 1 : 1,
			'current' => $current_page,
			'next' => $current_page < $results['pages'] ? $current_page + 1 : $current_page,
			'last' => $results['pages'],
			'count' => $results['count']
		);

		$columns = array(
			'nom_banniere' => array(
				'id' => 'archive-lien',
				'title' => 'Nom',
				'sortable' => true
			),
			'date_fin' => array(
				'id' => 'archive-date-fin',
				'title' => 'Date Fin',
				'sortable' => true
			),
			'frequence' => array(
				'id' => 'archive-frequence',
				'title' => 'Frequence',
				'sortable' => true
			),
			'affichage' => array(
				'id' => 'archive-affichage',
				'title' => 'Type d\'affichage',
				'sortable' => true
			),
			'nombre_clic' => array(
				'id' => 'archive-nb-clic',
				'title' => 'Nombre de clic',
				'sortable' => true
			)
		);
		
		DM_Wordpress_Template::load('banniere_admin_list', array(
			'page' => $this,
			'screen' => get_current_screen(),
			'count' => array(
				'all' => $count_all
			),
			'results' => $results['results'],
			'navigation' => $navigation,
			'filters' => $filters,
			'columns' => $columns
		));
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