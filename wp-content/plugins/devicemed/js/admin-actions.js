(function($) {
	$(document).ready(function(){

		if($('#acf-field-code').length) {
		
		}
		if($('#acf-field-articles').length){
			$('#acf-field-articles').prop('disabled',true);
		}
		if($('#acf-url_tracking_clicks').length) {
			$('#acf-url_tracking_clicks').hide();
		}
		if($('#acf-url_tracking_display').length) {
			$('#acf-url_tracking_display').hide();
		}
		if($('#acf-field-url_cible').length) {
			_url_tracking_clicks = $('#acf-field-url_tracking_clicks').val();
			_url_tracking_display = $('#acf-field-url_tracking_display').val();
			_links = []
			if(_url_tracking_clicks) {
				_links.push('<a href="'+_url_tracking_clicks+'+" target="_blank">Voir les stats de click</a>');
				_get('bitly',{'mode':'clicks','link':_url_tracking_clicks},function(_data){
					if(_data.etat) {
						$('.pub-metrics-clicks').html('Clicks : '+_data.clicks+' // ');
					}
				})
			}
			if(_url_tracking_display) {
				_links.push('<a href="'+_url_tracking_display+'+" target="_blank">Voir les stats de display</a>')
				_get('bitly',{'mode':'clicks','link':_url_tracking_display},function(_data){
					if(_data.etat) {
						$('.pub-metrics-display').html('Display : '+_data.clicks+' // ');
					}
				})
			}

			if($('#acf-couleur_de_fond').length == 0) {
				_links.push('<a href="#pub-preview">Prévisualiser</a>')
				$('<div id="pub-preview"></div>').insertAfter('#acf-code');
				setInterval(function(){
					if($('#set-post-thumbnail IMG').length) {
						if(!$('#featured-image-url').length) {
							_get('featured-image',{id:$('#post_ID').val()},function(_data){
								$('<input type=hidden id="featured-image-url" value="'+_data.url+'">').appendTo('body');
							});
						}
					} else {
						$('#featured-image-url').remove();
						$('#acf-field-url_tracking_display').val("")
					}
					if($('#acf-field-url_cible').val() && $('#featured-image-url').val()) {
						_html='<a href="'+$('#acf-field-url_cible').val()+'" target="_blank">';
						_html+='<img src="'+$('#featured-image-url').val()+'">';
						_html+='</a>';
					} else {
						_html = $('#acf-field-code').val();
					}
					if($('#pub-preview').html() != _html) {
						$('#pub-preview').html(_html);
					}
				},1000);
			}
			if(_links.length) {
				$('<div id="message-pub" class="updated below-h2"><p>\
					<span class="pub-metrics-clicks"></span>\
					<span class="pub-metrics-display"></span>\
					'+_links.join(' // ')+'\
				</p></div>').insertAfter('#titlediv');
			}
			$('#acf-field-url_cible').on('change',function(){
				$('#acf-field-url_tracking_clicks').val("");
			});
		}


	});


	function _get(_w,_params,_callback) {
		$.get('/wp-content/plugins/devicemed/php/ajax.php?w='+_w+'&'+$.param(_params),_callback);
	}

})( jQuery );
