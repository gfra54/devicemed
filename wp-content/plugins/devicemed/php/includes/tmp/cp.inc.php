<?php

$GLOBALS['mailings_dir'] = SOCIETY_SITEURL.'/mailings/';

function the_cp_content() {
	global $post;
	$image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
	
	$content = $post->post_content;

	$content = str_replace('<h2','<br><h2 style="font-family:Montserrat, sans-serif;display:inline-block;background:#ffc735;padding:2px;margin:0"',$content);
	$content = str_replace('</h2>','</h2><br>',$content);

	echo '<a href="'.$image.'" target="_blank"><img width="200" src="'.$image.'" align="left" style="margin:0 10px 5px 0"></a>';
	echo nl2br($content);

	$attachments = new Attachments( 'attachments_cp', $post->ID); 
	if( $attachments->exist() ) {
		$cpt=0;
		$titles = array();
	?>
	<p></p>

	<center>
	<table>
	<tr>
		<?php while( $attachments->get() ){ 
			$cpt++;
			$titles[$attachments->url()]=$attachments->field( 'title' );?>
		<?php if($cpt!=1) {?>
			<td>
			&nbsp;
			</td>
			
		<?php }?>
		<td width="80">
		<a href="<?php echo $attachments->url(); ?>"><center><img height="64" src="<?php  echo $GLOBALS['mailings_dir'];?>pdf.png"></center></a>
		</td>
		<?php } $cpt=0;?>
	</tr>
	<tr>
		<?php foreach($titles as $url=>$title){ $cpt++;?>
		<?php if($cpt!=1) {?>
			<td>
			&nbsp;
			</td>
		<?php }?>
		<td>
		<small><a href="<?php echo $url; ?>"><center><?php echo $title; ?></center></a></small>
		</td>
		<?php }?>
		</tr>
		</table>
		</center>
	<?php }

}