<?php 
fournisseur_redir($supplier['ID']);

get_header(); ?>

<?php 
		// On ajoute un clic au profil payant
		if(isset($_GET['premiere_visite']) && $_GET['premiere_visite'] == 1) {
			// On récupére l'adresse IP
			$adresseIP = $_SERVER["REMOTE_ADDR"];
			$supplier_id = $supplier['ID']; 
			
			// On vérifie que l'adresse IP n'as pas déjà visité cette page
			$sqlAdresseIP = "SELECT * FROM wordpress_dm_supplier_premium_clic WHERE supplier_premium_id=$supplier_id AND adresse_ip='$adresseIP'";
			$resultAdresseIP = mysql_query($sqlAdresseIP);
			$nbAdresseIP = mysql_num_rows($resultAdresseIP);
			$nosAdressesIP = array('82.228.227.218', '217.128.7.96', '86.219.76.20');
			
			if($nbAdresseIP == 0 && !in_array($adresseIP, $nosAdressesIP)) {
				$sqlClicProfilPayant = "INSERT INTO wordpress_dm_supplier_premium_clic(supplier_premium_id, adresse_ip) VALUES($supplier_id, '$adresseIP')";
				$resultClicProfilPayant = mysql_query($sqlClicProfilPayant);
			}
		}
?>
<?php 
	$supplier_id = $supplier['ID']; 
	$supplier_category_id = $supplier['supplier_category_id'];
	$supplier_name = esc_html($supplier['supplier_name']);
?>
<div class="row column-content page-supplier">
	<div class="col-md-9 col-sm-8 column-main">
<?php if (!$supplier): ?>
	<section class="results">
		<h2 class="title">Fournisseur introuvable</h2>
		<div class='retour_recherche_fournisseur'>
			<a href='/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
<?php else: ?>
	<section class="results">
		<h2 class="title"><?php echo esc_html($supplier['supplier_name']); ?></h2>
		<div class='retour_recherche_fournisseur'>
			<a href='/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
	<section class="actions">
		<a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($supplier_name)).'/'. $supplier_id); ?>" class="menu_actif">Coordonnées</a>
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>">Activités</a>
		<?php if($supplier['supplier_premium'] == 1) { ?>
			<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation</a>
			<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
			<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
			<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
			<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
		<?php }else { ?>
			<span class='details_supplier_disabled'>Présentation et photos</span>
			<span class='details_supplier_disabled'>Articles</span>
			<span class='details_supplier_disabled'>Vidéos</span>
			<span class='details_supplier_disabled'>Evénements</span>
			<span class='details_supplier_disabled'>Documentation PDF</span>
		<?php } ?>
	</section>
	<section class="supplier">
		<div class='info_supplier'>
			<?php if($supplier['supplier_logo'] != '') { ?>
				<div class='logo_supplier'>
					<img src='<?php echo "../../../wp-content/uploads/logo_suppliers/". $supplier['supplier_logo']; ?>' />
				</div>
			<?php } ?>
			<div class="address">
				<b><?php echo esc_html($supplier['supplier_name']); ?></b><br />
				<?php echo esc_html($supplier['supplier_address']); ?>
			</div>
			<div>
				<span class="postalcode"><?php echo esc_html($supplier['supplier_postalcode']); ?></span>
				<span class="city"><?php echo esc_html($supplier['supplier_city']); ?></span><br />
				<span class="country"><?php echo esc_html($supplier['supplier_country']); ?></span>
			</div><br />
			<?php if(stripos($supplier['supplier_website'], 'http://')) { ?>
				<div><a href="<?php echo esc_attr($supplier['supplier_website']); ?>" target='_blank'><?php echo esc_html($supplier['supplier_website']); ?></a></div><br />
			<?php }else { ?>
				<?php $supplierWebsite = str_replace('http://','', $supplier['supplier_website']); ?>
				<div><a href="http://<?php echo esc_attr($supplierWebsite); ?>" target='_blank'><?php echo esc_html($supplier['supplier_website']); ?></a></div><br />
			<?php } ?>
			<p class="about">
				<?php if(isset($supplier['supplier_social_blog']) && $supplier['supplier_social_blog'] != '') { ?><a href='<?php echo $supplier['supplier_social_blog']; ?>'><?php echo $supplier['supplier_social_blog']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_facebook']) && $supplier['supplier_social_facebook'] != '') { ?><a href='<?php echo $supplier['supplier_social_facebook']; ?>'><?php echo $supplier['supplier_social_facebook']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_linkedin']) && $supplier['supplier_social_linkedin'] != '') { ?><a href='<?php echo $supplier['supplier_social_linkedin']; ?>'><?php echo $supplier['supplier_social_linkedin']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_google_plus']) && $supplier['supplier_social_google_plus'] != '') { ?><a href='<?php echo $supplier['supplier_social_google_plus']; ?>'><?php echo $supplier['supplier_social_google_plus']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_twitter']) && $supplier['supplier_social_twitter'] != '') { ?><a href='<?php echo $supplier['supplier_social_twitter']; ?>'><?php echo $supplier['supplier_social_twitter']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_youtube']) && $supplier['supplier_social_youtube'] != '') { ?><a href='<?php echo $supplier['supplier_social_youtube']; ?>'><?php echo $supplier['supplier_social_youtube']; ?></a><br /><?php } ?>
			</p>
			<?php  
				if((isset($supplier['supplier_contact_nom']) && $supplier['supplier_contact_nom'] != '') || (isset($supplier['supplier_contact_tel']) && $supplier['supplier_contact_tel'] != '') || (isset($supplier['supplier_contact_mail']) && $supplier['supplier_contact_mail'] != '')) {
					echo "<b>Contact :</b><br />";
				}
				
				if(isset($supplier['supplier_contact_nom']) && $supplier['supplier_contact_nom'] != '') {
					echo $supplier['supplier_contact_nom'] ."<br />";
				} 

				if(isset($supplier['supplier_contact_tel']) && $supplier['supplier_contact_tel'] != '') {
					echo $supplier['supplier_contact_tel'] ."<br />";
				}

				if(isset($supplier['supplier_contact_mail']) && $supplier['supplier_contact_mail'] != '') {
					$supplierMail = $supplier['supplier_contact_mail'];
					echo "<a href='mailto:$supplierMail'>". $supplier['supplier_contact_mail'] ."</a>";
				}
			?>
		</div>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
