<?php 


get_header(); 
extracss('search');
extrajs('utils');
?>


<div class="row column-content page-search">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="results">
			<h2 class="title">Résultats pour : <?php echo get_search_query(); ?></h2>
            
<script>
  (function() {
    var cx = '012805594588283116678:z1fggin6flc';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>

	</div><!-- .column-main -->
<?php get_footer(); ?>

<script>
$(window).load(function(){
   // $('.gsc-search-button INPUT').remove();
   // $('<input type="button" value="Rechercher" onclick="$(\'FORM.gsc-search-box\').submit()">').appendTo('.gsc-search-button');
    if(_s = qs('s')){
        $('.gsc-input INPUT[type=text]').val(_s);
        $('.gsc-search-button INPUT[type=image]').trigger('click');
    }
})
</script>