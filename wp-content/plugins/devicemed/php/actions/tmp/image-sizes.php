<?php 
add_filter( 'jpeg_quality', create_function( '', 'return 85;' ) );

add_image_size( 'home-image', 850, 850, false );
add_image_size( 'home-image-cropped', 850, 850, true );

add_image_size( 'article-image', 850, 600, false );
add_image_size( 'article-image-cropped', 850, 600, true );

add_image_size( 'couv-small', 250, 325, false );
add_image_size( 'couv-medium', 600, 782, false );
add_image_size( 'couv-large', 766, 1000, false );

add_image_size( 'image-sommaire', 1000, 650, false );


