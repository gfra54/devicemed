<?php 


if($mode = check('mode')) {
	if($mode == 'clicks') {
		if($data = bitly_get('link/clicks',array('link'=>check('link')))) {
			if(isset($data['data']['link_clicks'])) {
				$json['clicks']	 = $data['data']['link_clicks'];
				$json['etat']=true;
			}
		}
	}

}