<?php

class DM_Wordpress_Suppliers_Download_Admin_List extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Fournisseur - Documentation PDF';
	protected $menu_title = 'Documentation PDF';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-downloads';

	public function render()
	{
		$filters = array();
		$current_page = 1;
		$results_per_page = 20;

		$suppliers_download = new DM_Wordpress_Suppliers_Download_Model();

		if (!empty($_GET['action']) AND !empty($_GET['supplier_download']))
		{
			if ($_GET['action'] == 'publish')
			{
				$suppliers_download->admin_list_bulk_publish($_GET['supplier_download']);
			}
			elseif ($_GET['action'] == 'draft')
			{
				$suppliers_download->admin_list_bulk_draft($_GET['supplier_download']);
			}
			elseif ($_GET['action'] == 'pending')
			{
				$suppliers_download->admin_list_bulk_pending($_GET['supplier_download']);
			}
			elseif ($_GET['action'] == 'delete')
			{
				$suppliers_download->admin_list_bulk_delete($_GET['supplier_download']);
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
		if (isset($_GET['supplier_download_status']) AND $_GET['supplier_download_status'] != '-1')
		{
			$filters+= array('supplier_download_status' => (int) $_GET['supplier_download_status']);
		}
		if (!empty($_GET['paged']))
		{
			$current_page = (int) $_GET['paged'];
		}

		
		$results = $suppliers_download->admin_list($current_page, $results_per_page, $filters);
		$count_all = $suppliers_download->admin_list_count_all();
		$count_published = $suppliers_download->admin_list_count_published();
		$count_drafts = $suppliers_download->admin_list_count_drafts();
		$count_pendings = $suppliers_download->admin_list_count_pendings();

		$navigation = array(
			'first' => 1,
			'previous' => $current_page > 1 ? $current_page - 1 : 1,
			'current' => $current_page,
			'next' => $current_page < $results['pages'] ? $current_page + 1 : $current_page,
			'last' => $results['pages'],
			'count' => $results['count']
		);

		$columns = array(
			'supplier_download_title' => array(
				'id' => 'supplier-download-title',
				'title' => 'Titre',
				'sortable' => true
			),
			'supplier_name' => array(
				'id' => 'supplier-download-status',
				'title' => 'Fournisseur',
				'sortable' => true
			),
			'supplier_download_author' => array(
				'id' => 'supplier-download-author',
				'title' => 'Auteur',
				'sortable' => true
			),
			'supplier_download_status' => array(
				'id' => 'supplier-download-status',
				'title' => 'Statut',
				'sortable' => true
			),
			'supplier_download_date' => array(
				'id' => 'supplier-download-date',
				'title' => 'Date',
				'sortable' => false
			)
		);
		
		DM_Wordpress_Template::load('suppliers_download_admin_list', array(
			'page' => $this,
			'screen' => get_current_screen(),
			'count' => array(
				'all' => $count_all,
				'published' => $count_published,
				'drafts' => $count_drafts,
				'pendings' => $count_pendings
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