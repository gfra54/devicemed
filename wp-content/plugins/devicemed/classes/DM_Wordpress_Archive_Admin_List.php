<?php

class DM_Wordpress_Archive_Admin_List extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-archives';
	protected $page_title = 'Archives';
	protected $menu_title = 'Toutes les archives';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-archives';

	public function render()
	{
		$filters = array();
		$current_page = 1;
		$results_per_page = 20;

		$archive = new DM_Wordpress_Archive_Model();

		if (!empty($_GET['action']) AND !empty($_GET['archive']))
		{
			if ($_GET['action'] == 'enable')
			{
				$archive->admin_list_bulk_enable($_GET['archive']);
			}
			elseif ($_GET['action'] == 'disable')
			{
				$archive->admin_list_bulk_disable($_GET['archive']);
			}
			elseif ($_GET['action'] == 'delete')
			{
				$archive->admin_list_bulk_delete($_GET['archive']);
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
		
		if (isset($_GET['supplier_status']) AND $_GET['supplier_status'] != '-1')
		{
			$filters+= array('supplier_status' => (int) $_GET['supplier_status']);
		}
		if (!empty($_GET['paged']))
		{
			$current_page = (int) $_GET['paged'];
		}

		
		$results = $archive->admin_list($current_page, $results_per_page, $filters);
		$count_all = $archive->admin_list_count_all();
		$count_active = $archive->admin_list_count_active();
		$count_inactive = $archive->admin_list_count_inactive();

		$navigation = array(
			'first' => 1,
			'previous' => $current_page > 1 ? $current_page - 1 : 1,
			'current' => $current_page,
			'next' => $current_page < $results['pages'] ? $current_page + 1 : $current_page,
			'last' => $results['pages'],
			'count' => $results['count']
		);

		$columns = array(
			'titre_archive' => array(
				'id' => 'archive-name',
				'title' => 'Titre du catalogue',
				'sortable' => true
			),
			'date_publication' => array(
				'id' => 'archive-date',
				'title' => 'Date',
				'sortable' => true
			)
		);
		
		DM_Wordpress_Template::load('archive_admin_list', array(
			'page' => $this,
			'screen' => get_current_screen(),
			'count' => array(
				'all' => $count_all,
				'active' => $count_active,
				'inactive' => $count_inactive
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