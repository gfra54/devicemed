<?php
function the_magazine_content() {
	global $post;
		$content = $post->post_content;
		$content = str_replace("\r","",str_replace('&nbsp;', ' ',$content));

		$sommaire = explode('<!--more-->',$content);
		$final = array();
		foreach($sommaire as $part){
			$data = array();
			$data['title'] = getHtmlVal('<h1>','</h1>',$part);
			$data['text'] = strip_tags_empty(strip_tags_specific(getHtmlVal('</h1>','',$part),array('img')));
			$tmp = strip_tags_empty(strip_tags_specific($part,array('img')));
			$tmp = trim($tmp);
			$data['text_all'] = str_replace("\n\n","<br>",$tmp);
			if(count($final) == 0){
//				couv-medium
				list($data['image']) = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'couv-medium');
				$data['mode'] = 'cover';
				$data['extra']=	tag('div.sommaire-enkiosque',get_post_custom_value('en_kiosque'),true).
								tag('div.sommaire-titre',get_the_title(),true);
			} else {
				$id_image = getHtmlVal('wp-image-','"',$part);
//				$data['image'] = getHtmlVal('src="','"',getHtmlVal('wp-image-','/>',$part));
				list($data['image']) = wp_get_attachment_image_src($id_image,'image-sommaire');
				if(strstr($part, 'alignleft')!==false) {
					$data['mode'] =  'left';
				} else {
					$data['mode'] =  'right';
				}
				$data['extra']='';
			}

			$final[]=$data;
		}

	tag('style','
		body .content-sommaire .sommaire-text{
			background:'.get_post_custom_value('default_bg').';
			color:'.get_post_custom_value('default_color').';
		}
		body .content-sommaire .sommaire-abonner, body .content-sommaire .sommaire-mode-cover .sommaire-text{
			background:'.get_post_custom_value('cover_bg').';
			color:'.get_post_custom_value('cover_color').';
		}
		body .content-sommaire .sommaire-appli-message{
			color:'.get_post_custom_value('cover_bg').';
		}
		body .content-sommaire .sommaire-abonner:hover{
			color:'.get_post_custom_value('cover_bg').';
			background:'.get_post_custom_value('cover_color').';
		}
		body .content-sommaire .sommaire-text-in{
			border-color:'.get_post_custom_value('default_color').' !important;
		}
		body .content-sommaire .sommaire-mode-cover .sommaire-text-in{
			border-color:'.get_post_custom_value('cover_color').' !important;
		}
	');
	tag_open('div.content-sommaire');
	tag('a.sommaire-abonner[href='.SOCIETY_SITEURL.'/abonnements-a-society/]','Abonnez-vous à Society ! - Un an (24 numéros) à partir de 65 € !');
	tag('div.sommaire-applis',
		tag('div.sommaire-appli a[href=https://itunes.apple.com/fr/app/society-mag./id969456269?mt=8;target=_blank] img[src='.SOCIETY_SITEURL.'/wp-content/themes/society-magazine/images/app_store_badge.png]','',true).
		tag('div.sommaire-appli-message','Lisez Society sur iPhone, iPad et Android',true).
		tag('div.sommaire-appli a[href=https://play.google.com/store/apps/details?id=com.forecomm.society;target=_blank] img[height=130;src='.SOCIETY_SITEURL.'/wp-content/themes/society-magazine/images/android_badge.png]','',true)
	);
	$cpt=0;
	foreach($final as $data){$cpt++;
			tag('div.sommaire-mode-'.$data['mode'].',sommaire-part',
				tag('div.sommaire-image[style=background-image:url('.$data['image'].')] img[src='.$data['image'].']',$data['titre'],true).
				tag('div.sommaire-text',
					tag('div.sommaire-extra',$data['extra'],true).
						tag('div.sommaire-text-in',
//							tag('h2',$data['title'],true).
							tag('div.sommaire-chapo',$data['text_all'],true),
							true),
						true)
				);
			if($cpt == 1){

			}
	}
	tag('a.sommaire-abonner[href='.SOCIETY_SITEURL.'/abonnements-a-society/]','Abonnez-vous à Society ! - Un an (24 numéros) à partir de 65 € !');
	tag_close('div');
}