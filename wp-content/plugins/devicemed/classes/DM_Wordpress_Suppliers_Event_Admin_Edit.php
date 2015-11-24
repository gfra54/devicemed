<?php

class DM_Wordpress_Suppliers_Event_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Evènement fournisseur';
	protected $menu_title = 'Ajouter un évènement';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-event-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$suppliers_event = new DM_Wordpress_Suppliers_Event_Model();
		$supplier_event_id = !empty($_GET['supplier_event_id']) ? (int) $_GET['supplier_event_id'] : 0;
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		
		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'supplier_id' => 0,
			'supplier_user_id' => 0,
			'supplier_event_id' => $supplier_event_id,
			'supplier_event_title' => '',
			'supplier_event_lieu' => '',
			'supplier_event_description' => '',
			'supplier_event_debut' => '',
			'supplier_event_fin' => '',
			'supplier_event_apercu' => ''
			
		);
		$errors = array();

		if ($supplier_event_id)
		{
			$row = $suppliers_event->admin_edit_get_event($supplier_event_id);
			foreach ($data as $field => $value)
			{
				if (isset($row[ $field ]))
				{
					$data[ $field ] = $row[ $field ];
				}
			}
		}
		
		if (!empty($_POST))
		{
			foreach ($data as $field => $value)
			{
				if (isset($_POST[ $field ]))
				{
					$data[ $field ] = trim(stripslashes($_POST[ $field ]));
				}
			}
			if (!$data['supplier_id'])
			{
				$errors['supplier_id'] = 'Fournisseur manquant.';
			}
			if (!$data['supplier_event_title'])
			{
				$errors['supplier_event_title'] = 'Titre de l\'évènement manquant.';
			}
			if (!$data['supplier_event_lieu'])
			{
				$errors['supplier_event_lieu'] = 'Lieu de l\'évènement manquante.';
			}
			if (!$data['supplier_event_debut'])
			{
				$errors['supplier_event_debut'] = 'Début manquant.';
			}
			if (!$data['supplier_event_fin'])
			{
				$errors['supplier_event_fin'] = 'Fin manquante.';
			}
			if (!$data['supplier_event_description'])
			{
				$errors['supplier_event_description'] = 'Description de l\'évènement manquante.';
			}
			if (!$errors)
			{
				if (!$supplier_event_id)
				{
					$supplier_event_id = $suppliers_event->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_event_modified'] = date('Y-m-d H:i:s');
					$suppliers_event->save($fields, $supplier_event_id);
				}
				
				if($_FILES['supplier_event_apercu']) {
					$dossierApercu = '../wp-content/uploads/suppliers/events/'. $supplier_event_id .'/';
					$fichierApercu = $_FILES['supplier_event_apercu']['name'];
					$data['supplier_event_apercu'] = $fichierApercu;
					$resultatApercu = move_uploaded_file($_FILES['supplier_event_apercu']['tmp_name'], $dossierApercu . $fichierApercu);
				}

				$saved = $suppliers_event->save($data, $supplier_event_id);

				if ($saved)
				{
					wp_redirect($this->url(array('supplier_event_id' => $supplier_event_id ? $supplier_event_id : $saved)));
				}
			}
		}

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors,
			'suppliers' => $suppliers
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('suppliers_event_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}