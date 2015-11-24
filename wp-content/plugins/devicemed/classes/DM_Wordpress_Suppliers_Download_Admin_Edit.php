<?php

class DM_Wordpress_Suppliers_Download_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Fournisseur - Documentation PDF';
	protected $menu_title = 'Ajouter une documentation PDF';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-download-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$suppliers_download = new DM_Wordpress_Suppliers_Download_Model();
		$supplier_download_id = !empty($_GET['supplier_download_id']) ? (int) $_GET['supplier_download_id'] : 0;
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		
		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'supplier_id' => 0,
			'supplier_user_id' => 0,
			'supplier_download_title' => '',
			'supplier_download_apercu' => '',
			'supplier_download_pdf' => '',
			'supplier_download_modified' => '',
			'supplier_download_created' => '',
			'supplier_download_status' => 0,
			'supplier_download_description' => ''
			
		);
		$errors = array();

		if ($supplier_download_id)
		{
			$row = $suppliers_download->admin_edit_get_download($supplier_download_id);

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
			if (!$data['supplier_download_title'])
			{
				$errors['supplier_download_title'] = 'Titre de la documentation PDF manquant.';
			}
			if (!$errors)
			{
				if (!$supplier_download_id)
				{
					$supplier_download_id = $suppliers_download->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_download_modified'] = date('Y-m-d H:i:s');
					$suppliers_download->save($fields, $supplier_download_id);
				}

				if(!$_FILES['supplier_download_apercu']['error']) {
					$dossierApercu = '../wp-content/uploads/suppliers/downloads/apercu/'. $supplier_download_id .'/';
					
					if(!file_exists($dossierApercu)) {
						mkdir($dossierApercu, 0777, true);
					}
					
					$fichierApercu = $_FILES['supplier_download_apercu']['name'];
					$data['supplier_download_apercu'] = $fichierApercu;
					
					$resultatApercu = move_uploaded_file($_FILES['supplier_download_apercu']['tmp_name'], $dossierApercu . $fichierApercu);
				}
				
				if(!$_FILES['supplier_download_pdf']['error']) {
					$dossierPdf = '../wp-content/uploads/suppliers/downloads/pdf/'. $supplier_download_id .'/';
					
					if(!file_exists($dossierPdf)) {
						mkdir($dossierPdf, 0777, true);
					}
					
					$fichierPdf = $_FILES['supplier_download_pdf']['name'];
					$data['supplier_download_pdf'] = $fichierPdf;
					$resultatPdf = move_uploaded_file($_FILES['supplier_download_pdf']['tmp_name'], $dossierPdf . $fichierPdf);
				}

				if($_GET['supplier_download_id'] == '') {
					if($resultatPdf) {
						$saved = $suppliers_download->save($data, $supplier_download_id);
					}else {
						$errors['supplier_download_pdf'] = 'Problème lors du transfert du fichier pdf.';
					}
				}else {
					$saved = $suppliers_download->save($data, $supplier_download_id);
				}

				// if ($saved)
				// {
					// wp_redirect($this->url(array('supplier_download_id' => $supplier_download_id ? $supplier_download_id : $saved)));
				// }
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
		DM_Wordpress_Template::load('suppliers_download_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}