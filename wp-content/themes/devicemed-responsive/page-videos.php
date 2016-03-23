<?php
/*
Template Name: videos
*/
?>
<?php get_header(); ?>

<?php foreach(get_pubs('cadre-video') as $video) {?>

<?php m($video);?>

<?php }?>

<?php get_footer(); ?>

