				<article>
					<a href="<?php echo get_permalink($post->ID); ?>">
						<span class="left">
							<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
							<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
								<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
							</figure>
							<?php else: ?>
							<figure></figure>
							<?php endif; ?>
						</span>
						<span class="right">
							<header>
								<?php if ($categories = get_the_category()): ?>
								<span class="categories">
								<?php
									$items = array();

									// On récupére les catégories
									$arrayCategorie = array();
									$sqlCategories = "SELECT * FROM menu_site";
									$resultCategories = mysql_query($sqlCategories);

									while($rowCategories = mysql_fetch_array($resultCategories)) {
										$nomCategorie = $rowCategories['nom_menu'];

										array_push($arrayCategorie, $nomCategorie);
									}
									
									$nbCategoriesTab = sizeOf($categories);

									foreach ($categories as $category)
									{
										$nomCategorieTemp = $category->cat_name;
											
										if(!in_array($nomCategorieTemp, $arrayCategorie)) {
											/*if($nbCategoriesTab == 1) {
												$items[] = '<span class="category_principal">'.$category->cat_name.'</span>';
											}
										}else {*/
											// On récupére la catégorie parente
											$parentcat = $category->category_parent;
											$nomCatParent = get_cat_name($parentcat);

											if($nomCatParent != 'Dossiers') {
												$items[] = '<span class="category_principal">'.$nomCatParent.' &gt; </span><span class="category">'.$category->cat_name.'</span>';
											}/*else {
												$items[] = '<span class="category">'.$category->cat_name.'</span>';
											}*/
										}
									}
									echo implode(', ', $items);
								?>
								</span>
								<?php endif; ?>
								<h2 class="title"><?php the_title(); ?></h2>
							</header>
							<p class="excerpt"><?php echo devicemed_get_post_excerpt(); ?></p>
							<!--<span class="metas">
								<span class="date-wrapper">Le <span class="date"><?php echo get_the_date('l d F Y'); ?></span></span>
								<span class="author-wrapper">par <span class="author"><?php echo get_the_author(); ?></span></span>
							</span>-->
						</span>
					</a>
				</article>
