<?php
function template_build_navigation($page, $navigation, $sendback = array())
{
	static $paging_input = TRUE;

	echo '<div class="tablenav-pages">';
	echo '	<span class="displaying-num">'.$navigation['count'].' élément'.($navigation['count'] > 1 ? 's' : '').'</span>';
	echo '	<span class="pagination-links">';
	echo '	<a class="first-page'.($navigation['current'] == 1 ? ' disabled' : '').'" title="Aller à la première page" href="'.esc_attr($page->url($sendback)).'">&laquo;</a>';
	echo '	<a class="prev-page'.($navigation['current'] == 1 ? ' disabled' : '').'" title="Aller à la page précédente" href="'.esc_attr($page->url(array_merge($sendback, array('paged' => $navigation['previous'])))).'">&lsaquo;</a>';
	echo '	<span class="paging-input">';
	if ($paging_input)
	{
		echo '<input class="current-page" title="Page actuelle" type="text" name="paged" value="'.$navigation['current'].'" size="2" />';
		$paging_input = FALSE;
	}
	else
	{
		echo $navigation['current'];
	}
	echo ' sur <span class="total-pages">'.$navigation['last'].'</span></span>';
	echo '	<a class="next-page'.($navigation['current'] == $navigation['last'] ? ' disabled' : '').'" title="Aller à la page suivante" href="'.esc_attr($page->url(array_merge($sendback, array('paged' => $navigation['next'])))).'">&rsaquo;</a>';
	echo '	<a class="last-page'.($navigation['current'] == $navigation['last'] ? ' disabled' : '').'" title="Aller à la dernière page" href="'.esc_attr($page->url(array_merge($sendback, array('paged' => $navigation['last'])))).'">&raquo;</a></span>';
	echo '</div><!-- .tablenav-pages -->';
}

function template_build_table_thead($page, $columns, $sendback = array())
{
	echo '<th scope="col" id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label><input id="cb-select-all-1" type="checkbox" /></th>';
	foreach ($columns as $field => $column)
	{
		$classes = array('manage-column', 'column-'.$column['id']);
		$order = $link_order = 'asc';
		if ($column['sortable'])
		{
			if (!empty($sendback['orderby']) AND !empty($sendback['order']) AND $sendback['orderby'] == $field)
			{
				$classes[] = 'sorted';
				$order = $sendback['order'];
				$link_order = $sendback['order'] == 'desc' ? 'asc' : 'desc';
			}
			else
			{
				$classes[] = 'sortable';
			}
			$classes[] = $order;
		}
		echo '<th scope="col" id="'.$column['id'].'" class="'.implode(' ', $classes).'"><a href="'.esc_attr($page->url(array_merge($sendback, array('orderby' => $field, 'order' => $link_order)))).'"><span>'.$column['title'].'</span>'.($column['sortable'] ? '<span class="sorting-indicator"></span>' : '').'</a></th>';
	}
}

function template_build_bulkactions($name, $actions = array())
{
	echo '<select name="'.esc_attr($name).'">';
	foreach ($actions as $value => $label)
	{
		echo '<option value="'.esc_attr($value).'">'.esc_html($label).'</option>';
	}
	echo '</select>';
}

function template_build_sendback_url($sendback = array(), $defaults = array())
{
	$parameters = array();
	foreach ($sendback as $query_var)
	{
		if (isset($_GET[ $query_var ]))
		{
			$parameters[ $query_var ] = $_GET[ $query_var ];
		}
		elseif (isset($defaults[ $query_var ]))
		{
			$parameters[ $query_var ] = $defaults[ $query_var ];
		}
	}
	return $parameters;
}

function template_build_sendback_form($sendback = array())
{
	foreach ($sendback as $query_var)
	{
		if (isset($_GET[ $query_var ]))
		{
			echo '<input type="hidden" name="'.esc_attr($query_var).'" value="'.esc_attr($_GET[ $query_var ]).'" />';
		}
	}
}

$bulkactions = array(
	'-1' => 'Actions groupées',
	'publish' => 'Publier les articles',
	'draft' => 'Brouillons',
	'pending' => 'En attente de relecture'
);

$sendback_url = template_build_sendback_url(
	array('search', 'orderby', 'order', 'supplier_post_status', 'paged'),
	$filters
);

$sendback_form = array('page', 'orderby', 'order');

?>
<div class="wrap">

<h2>
	<?php echo esc_html($page->page_title()); ?>
	<a href="<?php echo esc_attr(DM_Wordpress_Suppliers_Event_Admin_Edit::instance()->url()); ?>" class="add-new-h2">Ajouter</a>
	<?php if (!empty($_GET['search'])): ?><span class="subtitle">Résultats de recherche pour &laquo; <?php echo esc_html($_GET['search']); ?> &raquo;</span><?php endif; ?>
</h2>

<ul class="subsubsub">
	<li class="all"><a href="<?php echo esc_attr($page->url()); ?>"<?php echo (!isset($_GET['supplier_post_status']) OR $_GET['supplier_post_status'] == -1) ? ' class="current"' : ''; ?>>Tous <span class="count">(<?php echo $count['all']; ?>)</span></a> |</li>
	<li class="drafts"><a href="<?php echo esc_attr($page->url(array('supplier_post_status' => 0))); ?>"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == 0) ? ' class="current"' : ''; ?>>Brouillons <span class="count">(<?php echo $count['drafts']; ?>)</span></a> |</li>
	<li class="pendings"><a href="<?php echo esc_attr($page->url(array('supplier_post_status' => 2))); ?>"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == 2) ? ' class="current"' : ''; ?>>En attente de relecture <span class="count">(<?php echo $count['pendings']; ?>)</span></a> |</li>
	<li class="published"><a href="<?php echo esc_attr($page->url(array('supplier_post_status' => 1))); ?>"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == 1) ? ' class="current"' : ''; ?>>Publiés <span class="count">(<?php echo $count['published']; ?>)</span></a></li>
</ul>

<form id="list-form" action="<?php echo esc_attr($page->url()); ?>" method="get">

<?php template_build_sendback_form($sendback_form); ?>

<p class="search-box">
	<label class="screen-reader-text" for="user-search-input">Chercher dans les articles :</label>
	<input type="search" id="user-search-input" name="search" value="<?php echo esc_attr($_GET['search']); ?>" />
	<input type="submit" name="" id="search-submit" class="button" value="Chercher dans les articles"  />
</p><!-- .search-box -->

<?php  //wp_nonce_field( 'some-action-nonce' ); ?>

<div class="tablenav top">

<div class="alignleft actions bulkactions">
	<?php template_build_bulkactions('action', $bulkactions); ?>
	<input type="submit" name="" class="button action" value="Appliquer"  />
</div><!-- .actions -->

<div class="alignleft actions">
	<select name="user_status">
		<option value="-1"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == '-1') ? ' selected="selected"' : ''; ?>>Tous les statuts</option>
		<option value="0"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == '0') ? ' selected="selected"' : ''; ?>>Brouillons</option>
		<option value="2"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == '2') ? ' selected="selected"' : ''; ?>>En attente de relecture</option>
		<option value="1"<?php echo (isset($_GET['supplier_post_status']) AND $_GET['supplier_post_status'] == '1') ? ' selected="selected"' : ''; ?>>Publiés</option>
	</select>
	<input type="submit" name="" class="button" value="Filtrer"  />
</div>

<?php if ($results) { template_build_navigation($page, $navigation, $sendback_url); } ?>
</div><!-- .tablenav.top -->

<table class="wp-list-table widefat fixed">
	<thead><tr><?php template_build_table_thead($page, $columns, $sendback_url); ?></tr></thead>
	<tfoot><tr><?php template_build_table_thead($page, $columns, $sendback_url); ?></tr></tfoot>
	<tbody id="the-list">
<?php
if (!$results)
{
	echo '<tr><td colspan="'.count($columns).'">';
	echo 'Aucun article trouvé.';
	echo '</td></tr>';
}
else
{
	foreach ($results as $row => $result)
	{
		echo '<tr id="result-'.$row.'" class="'.($row % 2 ? '' : 'alternate').'">';
		echo '<th scope="row" class="check-column">';
		echo '<label class="screen-reader-text" for="cb-select-'.$result->ID.'">Sélectionner</label>';
		echo '<input id="cb-select-'.$result->ID.'" type="checkbox" name="supplier_event[]" value="'.$result->ID.'" />';
		echo '</th>';
		
		foreach ($columns as $field => $column)
		{
			echo '<td class="column-'.$column['id'].'">';
			switch($field)
			{
				case 'supplier_event_title':
					echo '<strong><a class="row-title" href="'.esc_attr(DM_Wordpress_Suppliers_Event_Admin_Edit::instance()->url(array('supplier_event_id' => $result->ID))).'" title="Modifier cet élément">'.esc_html($result->supplier_event_title).'</a></strong>';
					echo '<div class="row-actions">';
					echo '<span class="edit"><a href="'.esc_attr(DM_Wordpress_Suppliers_Event_Admin_Edit::instance()->url(array('supplier_event_id' => $result->ID))).'" title="Modifier cet élément">Modifier</a></span>';
					echo '</div>';
				break;
				case 'supplier_event_lieu':
					echo esc_html($result->supplier_event_lieu);
				break;
				case 'supplier_name':
					echo esc_html($result->supplier_name);
				break;
				case 'supplier_post_author':
					echo esc_html($result->supplier_user_nicename);
				break;
				case 'supplier_event_status':
					switch ($result->supplier_event_status)
					{
						case 0:
							echo 'Brouillon';
						break;
						case 2:
							echo 'En attente de relecture';
						break;
						case 1:
							echo 'Publié';
						break;
					}
				break;
				case 'supplier_event_date':
					echo '<div>Créé le '.date('d/m/Y', strtotime($result->supplier_event_created)).'</div>';
					echo '<div>Modifié le '.date('d/m/Y', strtotime($result->supplier_event_modified)).'</div>';
				break;
			}
			echo '</td>';
		}
		echo '</tr>';
	}
}
?>
	</tbody>
</table>

<div class="tablenav bottom">
	<div class="alignleft actions bulkactions">
		<?php template_build_bulkactions('action2', $bulkactions); ?>
		<input type="submit" name="" class="button action" value="Appliquer"  />
	</div><!-- .actions -->

<?php if ($results) { template_build_navigation($page, $navigation, $sendback_url); } ?>
</div><!-- .tablenav.bottom -->

</form>

</div><!-- .wrap -->