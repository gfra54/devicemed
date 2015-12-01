<?php

function site_barre(){
	$topics = get_trending_topics();
	?>
		<div class="site-barre">
			<div class="site-barre-in">
			<div class="barre-cell barre-logo">
				<a href="<?php echo SOCIETY_SITEURL;?>"><?php svg('logo-big');?></a>
			</div>
			<div class="barre-cell barre-topics">
				<?php foreach($topics as $url => $topic){?>
					<a href="<?php echo $url;?>"><?php echo $topic;?></a>
				<?php }?>
			</div>
			<div class="barre-cell barre-icons">
				<?php foreach ($GLOBALS['SOCIALS'] as $key => $val) {?>
					<a target="<?php echo $key;?>" href="<?php echo $val['url'];?>">
						<?php svg($val['icon']);?>
					</a>
				<?php }?>
			</div>
			</div>
		</div>
	<?php
}