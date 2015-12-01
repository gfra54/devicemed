<?php

$GLOBALS['SOCIALS'] = array(
			"Twitter" => array(
				'url'	=>	SOCIETY_TWITTER,
				'icon'	=>	'twitter',
				'button' => '<a href="https://twitter.com/SocietyOfficiel" class="twitter-follow-button" data-show-count="false" data-lang="fr" data-show-screen-name="false">Suivre @SocietyOfficiel</a>'
			),
			"Facebook" => array(
				'url'	=>	SOCIETY_FACEBOOK,
				'icon'	=>	'facebook',
				'button' => '<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FSocietyOfficiel&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=132232413468908" scrolling="no" frameborder="0" style="margin:0;border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>'
			),
			"GooglePlus" => array(
				'url'	=>	SOCIETY_GOOGLEPLUS,
				'icon'	=>	'googleplus',
				'button'=> '<div class="g-follow" data-annotation="bubble" data-height="15" data-href="//plus.google.com/u/0/104201558281081650143" data-rel="publisher"></div>'
			),
		);

function social_buttons() {?>
		<div class="social-buttons">
			<div class="social-mini-icons">
				<div class="social-cell"><?php svg('twitter');?></div>
				<div class="social-cell"><?php svg('facebook');?></div>
				<div class="social-cell"><?php svg('googleplus');?></div>
			</div>
			<div class="social-mini-buttons">
				<div class="social-cell">
					<?php social_button('twitter');?>
				</div>
				<div class="social-cell">
					<?php social_button('facebook');?>
				</div>
				<div class="social-cell">
					<?php social_button('googleplus');?>
				</div>
			</div>
		</div>
<?php }
function social_button($w,$url=false){
	if(!$url){
		$url = get_the_permalink();
	}
	?>
	<div class="social-cell-wrap">
	<div class="social-cell-in">
	<?php
	if((SOCIETY_ENV != 'DEV')) {
		if($w== 'facebook') {
			?><iframe src="//www.facebook.com/plugins/share_button.php?href=<?php echo urlencode($url);?>&amp;layout=button_count&amp;appId=132232413468908" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe><?php
		} else if($w =='twitter'){
			?>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url;?>" data-via="societyofficiel">Tweet</a>
			<?php
			if(!isset($GLOBALS['twitter_script'])) {
				add_action( 'wp_footer', 'twitter_script' );
			}
		} else if($w == 'googleplus'){
			?><div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $url;?>"></div><?php
			if(!isset($GLOBALS['googleplus_script'])) {
				add_action( 'wp_footer', 'googleplus_script' );
			}

		}
	}
	?>
	</div>
	</div>
	<?php
	$GLOBALS[$w.'script']=true;

}

function twitter_script(){
	?>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<?php
}

function googleplus_script(){
	?>
	<script src="https://apis.google.com/js/platform.js" async defer>
	  {lang: 'fr'}
	</script>
	<?php
}