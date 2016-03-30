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
<?php include_external('js/bootstrap.min.js');?>
<?php include_external('js/jquery.bxslider.min.js');?>
<?php include_external('js/colorbox/jquery.colorbox-min.js');?>
<?php 
	if($GLOBALS['habillage']) { extrajs('pubs'); }
	extrajs('nl');
	
	extrajs('bottom');

?>
</body>
</html>
