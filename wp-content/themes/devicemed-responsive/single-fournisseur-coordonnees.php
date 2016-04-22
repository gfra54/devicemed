	<section class="supplier">
		<div class='info_supplier'>
			<?php if($fournisseur['logo']) { ?>
				<div class='logo_supplier'>
					<img src='<?php echo $fournisseur['logo']; ?>' />
				</div>
			<?php } ?>
			<div class="address">
				<b><?php echo esc_html($fournisseur['nom']); ?></b><br />
				<?php echo esc_html($fournisseur['adresse']); ?>
			</div>
			<div>
				<span class="postalcode"><?php echo esc_html($fournisseur['code_postal']); ?></span>
				<span class="city"><?php echo esc_html($fournisseur['ville']); ?></span><br />
				<span class="country"><?php echo esc_html($fournisseur['pays']); ?></span>
			</div><br />
			<?php link_cond($fournisseur['url'],false,'<div>','</div><br >');?>
			<p class="about">
			<?php 
			foreach(array('blog','facebook','twitter','youtube','googleplus','linkedin') as $site) {
				link_cond($fournisseur[$site],false,'','<br >');
			}?>
			</p>
			<?php  
				if((!empty($fournisseur['nom_contact'])) || (!empty($fournisseur['telephone_contact'])) || (!empty($fournisseur['email_contact']) )) {
					echo "<b>Contact :</b><br />";
				}
				
				if(!empty($fournisseur['nom_contact'])) {
					echo $fournisseur['nom_contact'] ."<br />";
				} 

				if(!empty($fournisseur['telephone_contact'])) {
					echo $fournisseur['telephone_contact'] ."<br />";
				}

				if(!empty($fournisseur['email_contact']) ) {
					$fournisseurMail = $fournisseur['email_contact'];
					echo '<a href="mailto:'.$fournisseur['email_contact'].'">'. $fournisseur['email_contact'] ."</a>";
				}
			?>
		</div>
	</section>
