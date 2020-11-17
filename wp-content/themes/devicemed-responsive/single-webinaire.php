<?php

$messages = [
	'inscriptionOk' => 'Votre inscription à ce webinaire a été enregistrée. Vous receverez prochainement des informations détaillées par e-mail.',
	'dejaParticipanrt' => 'Vous êtes déjà inscrit à ce webinaire. En cas de questions, contactez <a href="mailto:info@devicemed.fr">info@devicemed.fr</a>.'
];

$champs   = [
	[
		'slug' => 'email',
		'lib'  => 'Adresse mail',
	],
	[
		'slug' => 'nom',
		'lib'  => 'Nom',
	],
	[
		'slug' => 'prenom',
		'lib'  => 'Prénom',
	],
	[
		'slug' => 'societe',
		'lib'  => 'Société',
	],
];

$places_disponibles = webinairePlaces($post);
$participants = webinaireParticipants($post);

get_header();?>


<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="article">
			<?php while (have_posts()): the_post();
				?>
				<article>

					<div class="categories">
						<span class="category_principal">Webinaire</span>
						<br>		
					</div>
					<h1 class="title"><?php echo $post->post_title; ?></h1>

					<p>
						<?php if ($post->date) {?>
							<b>Webinaire planifié le <?php echo date('d/m/Y', strtotime($post->date)); ?> à <?php echo date('H:i', strtotime($post->date)); ?></b>
						<?php }?>
						<?php if ($post->duree) {?>
							/ Durée : <?php echo hoursandmins($post->duree)?>
						<?php }?>

						<?php if ($post->places_disponibles) {?>
							<br>
							<?php if ($places_disponibles) {?>
								<?php echo $places_disponibles; ?> place(s) disponible(s). <a href="#formulaire"><u>Inscrivez-vous</u></a>
							<?php } else {?>
								<b>Ce webinaire est complet</b>.
							<?php }?>
						<?php } else if($participants){?>
							<br><?php echo $participants; ?> inscrit(s) jusqu'à présent. <a href="#formulaire"><u>Inscrivez-vous</u></a>
						<?php }?>


						<?php if ($post->intervenants) {?>
							<br>Webinaire animé par <?php echo $post->intervenants; ?>
						<?php }?>
					</p>
					<?php if ($image = devicemed_get_post_featured_thumbnail($post->ID)) {?>
						<img style="max-width:100%;display:block" src="<?php echo $image->url; ?>">
					<?php }?>

					<div class="content">
						<?php the_content();?>

					</div>
				</article>
			</section>

			<a name="formulaire"></a>
			<section>

				<?php if (!$post->places_disponibles || $places_disponibles) {?>

					<h3 class="title42">Inscription au webinaire</h3>
					<p>Entrez vos informations dans le formulaire ci-dessous pour participer au webinaire.</p>
					<?php if ($message = $_GET['message']) {?>
						<p style="color:red"><?php echo $messages[$message]; ?></p>
					<?php }?>
					<form method="post" action="<?php echo get_permalink($post); ?>#formulaire">
						<input type="hidden" name="webinaire[post_id]" value="<?php echo $post->ID; ?>">
						<input type="hidden" name="inscription-webinaire">
						<div class="form-fieldset">
							<?php foreach ($champs as $champ) {?>
								<div class="form-row">
									<div class="form-field"><input  type="text" required="true" name="webinaire[participant][<?php echo $champ['slug'] ?>]" value="" placeholder="<?php echo $champ['lib'] ?>" /></div>
								</div>
							<?php }?>


							<?php if ($success['general'] == '') {?>
								<div class="form-row">
									<div class="form-submit input_sabonner_magazine"><input type="submit" value="S'inscrire au webinaire" /></div>
								</div>
							<?php }?>

							<?php if ($post->societe) {?>
								<br>
								<div class="form-field">
									<label>
										<input type="checkbox" name="webinaire[participant][optin]" value="true"/> J'autorise DeviceMed à partager mes informations avec la société <?php echo $post->societe;?>.
									</label>
								</div>
							<?php }?>
						</div>
					</form>
				<?php } else {?>
					<p>
						<b>Ce webinaire est complet</b>. Pour être tenu au courant de nos webinaires <a href="/newsletter/inscription">abonnez-vous à notre newsletter</a>.
					</p>
				<?php }?>

			</section>

			<section>
				Partagez sur les réseaux sociaux ou par email :
				<div style="margin-top: 30px">
					<div class="sharethis-inline-share-buttons"></div>
				</div>
			</section>

			<?php if (strstr($_SERVER['REQUEST_URI'], 3671) === false) {?>


				<section class="social">
					Suivez l'actualité de DeviceMed sur les réseaux sociaux :
					<div class="social-boutons">
						<a href="https://twitter.com/DeviceMedFr"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-couleur.png"> Twitter</a>
						<a href="https://fr.linkedin.com/company/devicemed-france"><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin-couleur.png"> LinkedIn</a>
					</div>
				</section>

			<?php }?>
		<?php endwhile;?>
	</div><!-- .column-main -->
	<?php get_footer();?>