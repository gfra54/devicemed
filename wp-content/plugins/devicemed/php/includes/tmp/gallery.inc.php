<?php
function the_gallery_content() {
	global $post;

	$content = $post->post_content;
	$images = explode('<!--more-->',$content);
	$final = array();
	$tmp=false;
	foreach($images as $image){
		if($tmp===false) {
			$tmp = array();
		}
		if(strstr($image, 'wp-image')!==false){
			$tmp['image']=trim($image);
		} else {
			$tmp['text']=trim($image);
		}
		if(isset($tmp['text']) && isset($tmp['image'])) {
			$final[] = $tmp;
			$tmp=false;
		}
	}
	foreach($final as $cpt => $data) {
		if($data['src'] = getHtmlVal('src="','"',$data['image'])) {
			$data['caption'] = getHtmlVal('</a>','[/caption]',$data['image']);
			$data['href'] = getHtmlVal('href="','"',$data['image']);
			$data['title'] = getHtmlval('<h1>','</h1>',$data['text']);
			if($data['title']) {
				list(,$data['text']) = explode('</h1>',$data['text']);
			}
		}
		$final[$cpt]=$data;
	}
	?>
	<div class="gallery-frame" data-current="1">
	<div class="gallery-inside">
		<span data-sens="-1" class="gallery-nav gallery-next"><?php svg('prev');?></span>
		<span data-sens="1" class="gallery-nav gallery-prev"><?php svg('next');?></span>
		<div class="gallery-rack" style="width:<?php echo count($final)*100;?>%">
		<?php foreach($final as $cpt => $data) {
			if($data['src']) {

				?>
				<div class="gallery-slide" style="width:<?php echo 100/count($final);?>%">
					<a class="gallery-slide-image" _href="<?php echo $data['href'];?>" title="<?php echo $data['title'];?>">
						<img src="<?php echo $data['src'];?>" alt="<?php echo $data['title'];?>">
						<?php if($data['caption']) {?>
						<div class="gallery-slide-legende"><?php echo $data['caption'];?></div>
						<?php }?>
					</a>
					<span class="gallery-slide-pagination">
						<?php if(!isset($final[$cpt+1])){?>
							<span class="pagination-prev">
								<a href="#gallery-1">Retour au début</a>
							</span>
						<?php }?>
						<span class="pagination-current">
							<?php echo $cpt+1?> / <?php echo count($final);?>
						</span>
						<?php if(isset($final[$cpt+1])){?>
							<span class="pagination-next">
								<a href="#gallery-<?php echo $cpt+2;?>"><?php echo $final[$cpt+1]['title'];?></a>
							</span>
						<?php }?>
					</span>
					<h2 class="gallery-slide-title"><?php echo $data['title']?></h2>
					<div class="gallery-slide-text"><?php echo $data['text'];?></div>
				</div>
			<?php } ?>
		<?php } ?>
		</div>
	<div>
	<div>
<?php
}