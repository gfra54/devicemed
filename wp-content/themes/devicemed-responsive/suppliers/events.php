<?php get_header(); ?>

<?php 
	$session_supplier_id = $session['supplier_id'];
	$supplier_id = $supplier['ID'];
	$supplier_name = esc_attr(sanitize_title($supplier['supplier_name']));
?>
<div class="row column-content page-supplier">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="results">
		<h2 class="title"><?php echo esc_html($supplier['supplier_name']); ?></h2>
		<div class='retour_recherche_fournisseur'>
			<a href='/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
	<section class="actions">
		<a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($supplier_name)).'/'. $supplier_id); ?>">Coordonnées</a>
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>">Activités</a>
		<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation</a>
		<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>" class="menu_actif">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
	</section>
<?php if ($supplier["supplier_events"] != '' && $supplier['supplier_premium'] == 1): ?>
	<!-- section.posts -->
	<section class="posts"><?php echo $supplier["supplier_events"]; ?></section>
	<!--<section class="posts">
		<header>
			<h2 class="title">Evénements auxquels participe <?php echo $supplier['supplier_name']; ?></h2>
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/events/add'); ?>">Ajouter un événement</a>
				</div>
			<?php endif; ?>
		</header>
<?php foreach ($events as $event): ?>
		<article>
			<div class="left">
<?php if ($event['supplier_event_apercu'] != ''): ?>
				<a href='<?php echo "http://www.device-med.fr/posts/details/event/". $event['ID']; ?>'><figure style="background-image:url('<?php echo esc_attr(DM_Wordpress_Suppliers_Event::get_media_url($event['ID'], $event['supplier_event_apercu'])); ?>')">
					<img src="<?php echo esc_attr(DM_Wordpress_Suppliers_Event::get_media_url($event['ID'], $event['supplier_event_apercu'])); ?>" />
				</figure></a>
<?php else: ?>
				<figure></figure>
<?php endif; ?>
			</div>
			<div class="right">
				<header>
					<h3 class="title"><a href='<?php echo "http://www.device-med.fr/posts/details/event/". $event['ID']; ?>'><?php echo esc_html($event['supplier_event_title']); ?></a></h3>
				</header>
				<?php
					$date_debut_event = $event['supplier_event_debut'];
					$array_date_debut_event = explode('-', $date_debut_event);
					$date_debut_event = $array_date_debut_event[2] .'.'. $array_date_debut_event[1] .'.'. $array_date_debut_event[0];
					
					$date_fin_event = $event['supplier_event_fin'];
					$array_date_fin_event = explode('-', $date_fin_event);
					$date_fin_event = $array_date_fin_event[2] .'.'. $array_date_fin_event[1] .'.'. $array_date_fin_event[0];
				?>
				<p class="excerpt">Date : <?php echo $date_debut_event; ?> - <?php echo $date_fin_event; ?><br />Lieu de l'événement : <?php echo esc_attr($event['supplier_event_lieu']); ?><br /><br /><?php echo DM_Wordpress_Text::excerpt($event['supplier_event_description'], 100); ?></p>
			</div>
		</article>
<?php endforeach; ?>
	</section>-->
	<!-- /section.posts -->
<?php else: ?>
	<section class="results">
		<header>
			<!--<div class="aucun_article">Aucun événement.</div>-->
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/events/add'); ?>">Ajouter un événement</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->

<?php get_footer(); ?>
