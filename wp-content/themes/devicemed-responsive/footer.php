<?php get_sidebar(); ?>
	</div><!-- .column-content -->

<footer id="footer">
	<div class="copyright">DeviceMed.fr est une marque de Vogel Business Media. <a href='http://www.devicemed.de/' target='_blank'>Cliquer ici pour découvrir le site de DeviceMed Allemagne</a>.</div>
	<div class="pages"><?php devicemed_footer_menu('Bas de page - Première ligne'); ?></div>
	<div class="credits"><?php devicemed_footer_menu('Bas de page - Deuxième ligne'); ?></div>
</footer>

</div><!-- .container -->
<?php wp_footer(); ?>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/colorbox/jquery.colorbox-min.js"></script>
<?php if($GLOBALS['habillage']) { extrajs('pubs'); }?>
</body>
</html>

<script>
<?php if($_SERVER['REQUEST_URI'] == '/suppliers/videos/6') {
	$legendes = array(
		'Clapets anti-retour',
		'Raccords Luers cannelés',
		'Pinces clamps',
		'Valves hémostatiques',
		'Qosina',
		'Crans d\'arrêt',
		'Seringues',
		'Adaptateurs Tuohy Borst'
	);
	foreach($legendes as $k=>$legende) {
		if($legende) {
			echo '$(".content .legend:eq('.$k.')").html(\''.addslashes($legende).'\');';
		}
	}
}?>
</script>