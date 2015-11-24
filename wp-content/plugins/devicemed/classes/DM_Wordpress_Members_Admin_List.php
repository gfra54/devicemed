<?php

class DM_Wordpress_Members_Admin_List extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-members';
	protected $page_title = 'Membres';
	protected $menu_title = 'Tous les membres';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-members';

	public function render()
	{
		$filters = array();
		$current_page = 1;
		$results_per_page = 20;

		$members = new DM_Wordpress_Members_Model();

		if (!empty($_GET['action']) AND !empty($_GET['member']))
		{
			if ($_GET['action'] == 'enable')
			{
				$members->admin_list_bulk_enable($_GET['member']);
			}
			elseif ($_GET['action'] == 'disable')
			{
				$members->admin_list_bulk_disable($_GET['member']);
			}
			elseif ($_GET['action'] == 'delete')
			{
				$members->admin_list_bulk_delete($_GET['member']);
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
		if (isset($_GET['user_status']) AND $_GET['user_status'] != '-1')
		{
			$filters+= array('user_status' => (int) $_GET['user_status']);
		}
		if (!empty($_GET['paged']))
		{
			$current_page = (int) $_GET['paged'];
		}

		
		$results = $members->admin_list($current_page, $results_per_page, $filters);
		$count_all = $members->admin_list_count_all();
		$count_active = $members->admin_list_count_active();
		$count_inactive = $members->admin_list_count_inactive();

		$navigation = array(
			'first' => 1,
			'previous' => $current_page > 1 ? $current_page - 1 : 1,
			'current' => $current_page,
			'next' => $current_page < $results['pages'] ? $current_page + 1 : $current_page,
			'last' => $results['pages'],
			'count' => $results['count']
		);

		$columns = array(
			'user_login' => array(
				'id' => 'user-login',
				'title' => 'Identifiant',
				'sortable' => true
			),
			'user_lastname' => array(
				'id' => 'user-lastname',
				'title' => 'Nom',
				'sortable' => true
			),
			'user_firstname' => array(
				'id' => 'user-firstname',
				'title' => 'Prénom',
				'sortable' => false
			),
			'user_email' => array(
				'id' => 'user-email',
				'title' => 'E-Mail',
				'sortable' => false
			),
			'user_status' => array(
				'id' => 'user-status',
				'title' => 'Statut',
				'sortable' => true
			),
			'user_date' => array(
				'id' => 'user-date',
				'title' => 'Date',
				'sortable' => false
			)
		);
		
		DM_Wordpress_Template::load('members_admin_list', array(
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