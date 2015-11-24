<?php get_header(); ?>
<div class="row column-content page-category">
	<div class="col-md-9 col-sm-8 column-main">
        <section class="home-gallery2 results">
             <h2 class="title">Galerie</h2>
            <div class="section-gallery-wrapper">
                <ul>
                    <?php
					// $nbArticles = $wp_query->max_num_pages;
					global $wpdb;
					
					if(isset($_GET['limit']) && $_GET['limit'] != '') {
						$limit = $_GET['limit'];
					}else {
						$limit = 0;
					}
					
					$pageDebut = ($limit/30)+1;
					$pageDebut = $pageDebut-2;
					
					if($pageDebut <= 0) {
						$pageDebut = 1;
					}
					
                    $query = $wpdb->get_results("SELECT * FROM wordpress_posts WHERE post_type='attachment' AND post_parent <> 0 ORDER BY ID DESC LIMIT $limit,30"); 

                    foreach ($query as $post) {
                        list($image_url, $image_width, $image_height) = wp_get_attachment_image_src($post->ID, 'medium');
						if(get_permalink($post->post_parent) != 'http://www.devicemed.fr/nos-partenaires') {
							echo '<li><a href="'.get_permalink($post->post_parent).'" style="background-image:url('.$image_url.');"><img src="'.$image_url.'" width="'.$image_width.'" /></a></li>';
						}
                    }
                    ?>
                </ul>
            </div>
			<div class="paginationGalerie">
				<?php
					$sqlAttachement = "SELECT * FROM wordpress_posts WHERE post_type='attachment' AND post_parent <> 0 ORDER BY ID DESC";
					$resultAttachement = mysql_query($sqlAttachement);
					$nbAttachement = mysql_num_rows($resultAttachement);
					$nbPage = ceil($nbAttachement/30);
					
					if(($pageDebut+8) >= $nbPage) {
						$pageDebut = ($nbPage-8);
					}
					
					if(isset($_GET['limit']) && $_GET['limit'] != '') {
						$limit = $_GET['limit'];
					}else {
						$limit = 0;
					}
					
					$limitPrec = $limit-30;
					$limitSuiv = $limit+30;
					
					if($limit == 0) {
						$pageActive = 1;
					}else {
						$pageActive = ($limit/30) + 1;
					}
					
					if($limit != 0) {
						echo "<div class='page'><a href='?limit=$limitPrec'>&lsaquo;</a></div>";
					}
					echo "<div class='page page_active'>$pageActive</div>";
					if($limit < ($nbAttachement-30)) {
						echo "<div class='page'><a href='?limit=$limitSuiv'>&rsaquo;</a></div>";
					}
					
					// for($i = $pageDebut;$i <= $nbPage; $i++) {
						// $limitTemp = ($i*30)-30;
					
						// if(isset($_GET['limit']) && $_GET['limit'] != '') {
							// $limit = $_GET['limit'];
						// }else {
							// $limit = 0;
						// }
						
						// if($limit == 0) {
							// $pageActive = 1;
						// }else {
							// $pageActive = ($limit/30) + 1;
						// }
							
						// if($pageActive == $i) {
							// echo "<div class='page page_active'><a href='?limit=$limitTemp'>$i</a></div>";
						// }else {
							// echo "<div class='page'><a href='?limit=$limitTemp'>$i</a></div>";
						// }
						
						// if($i == ($pageDebut+4) && ($pageDebut+8) < $nbPage) {
							// echo "<div class='page'>...</div>";
							// $i = $nbPage-4;
						// }
					// }
				?>
			</div>
        </section>
	</div><!-- .column-main -->
<?php get_footer(); ?>