(function($) {
	$(document).ready(function(){

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
			$('<div id="message" class="updated below-h2"><p>\
				<span class="pub-metrics-clicks"></span>\
				<span class="pub-metrics-display"></span>\
				'+_links.join(' // ')+'\
			</p></div>').insertAfter('#titlediv');

			if($('#set-post-thumbnail IMG').length) {
				// $('<a href="'+$('#acf-field-url_cible').val()+'+" target="_blank">Voir les stats de click</a>').insertAfter('label[for=acf-field-url_cible]')
			}
		}


	});


	function _get(_w,_params,_callback) {
		$.get('/wp-content/plugins/devicemed/php/ajax.php?w='+_w+'&'+$.param(_params),_callback);
	}

})( jQuery );
