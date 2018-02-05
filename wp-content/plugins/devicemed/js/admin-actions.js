(function($) {
	$(document).ready(function(){
		// $('<link rel="stylesheet" href="/wp-content/plugins/devicemed/css/admin.css" type="text/css" media="all" />').appendTo('head');
		
/*		setInterval(function(){
			if(document.getElementById('wp-link-wrap').style.display == 'block') {
				if(!$('#wp-link-wrap').data('ok')) {

					$('<div class="link-connexe">\
						<label><span>&nbsp;</span><input type="checkbox" id="link-connexe-checkbox"> Lien connexe (affichage différent)</label>\
					</div>').insertAfter('#wp-link-wrap .link-target');

					$('<input id="tmp-url-field" type="text">').insertAfter('#wp-link-wrap #url-field');
					$('#url-field').css('display','none');
					$('#tmp-url-field').val($('#url-field').val().replace('#lien-connexe',''));
					$('#tmp-url-field').on('blur keyup',function(){
						update_url_field();
					});
					$('#tmp-url-field').on('change',function(){
						_url = update_url_field();
						$.post('/wp-admin/',{
							'action'	: 'get-meta-from-page',
							'url'		: $(this).val()
						},function(_data){
							if('title' in _data) {
								$('#link-title-field').val(_data.title);
							}
						})
					});
					$('#link-connexe-checkbox').on('change',function(){
						update_url_field();
					});
					if($('#url-field').val().indexOf('#lien-connexe')!=-1) {
						$('#link-connexe-checkbox').prop('checked',true);
					}
					$('#wp-link-wrap').data('ok',true);
				}
			} else if(document.getElementById('tmp-url-field')){
				$('#url-field').css('display','block');
				$('.link-connexe, #tmp-url-field').remove();
			}
		},100);	*/

		if($('#wp-admin-bar-view .ab-item').length) {
			if($('#wp-admin-bar-view .ab-item').html().indexOf('Newsletter')>0) {
				// $('<li><a href="/fournisseurs_partenaires?ban&TB_iframe=false&width=300&height=300" title="Voir le bloc fournisseurs" class="thickbox ab-item">Bloc fournisseurs</a></li>').insertAfter('#wp-admin-bar-view');
				var _view = $('#wp-admin-bar-view .ab-item').attr('href')+'?TB_iframe=false';
				$('<li><a class="ab-item" href="'+_view+'&brut=true" target="_blank">Voir en texte brut</a></li><li><a href="'+$('#wp-admin-bar-view .ab-item').attr('href').replace('http:','https:')+'?source=true&TB_iframe=false&width=900&height=958" title="Code source" class="thickbox ab-item">Code source de la newsletter</a></li>').insertAfter('#wp-admin-bar-view');
				$('#wp-admin-bar-view .ab-item').attr('href',_view);


				$('#wp-admin-bar-view .ab-item').addClass("thickbox");
			}
		}
		if(_post_type = getParameterByName('post_type')) {
			if(_post_type != 'post') {
				$('.row-actions span.inline').remove();
			}
			if(_post_type != 'post' && _post_type != 'newsletter') {
				$('.row-actions span.view').remove();
			}
		}

		if($('#acf-field_565f064efd6c2').length){
			$('#acf-field_565f064efd6c2').prop('disabled',true);
		}
/*		if($('#acf-url_tracking_clicks').length) {
			$('#acf-url_tracking_clicks').hide();
		}
		if($('#acf-url_tracking_display').length) {
			$('#acf-url_tracking_display').hide();
		}*/
		if($('[data-name=url_cible] INPUT').length) {
			_url_tracking_clicks = $('[data-name=url_tracking_clicks] INPUT').val();
			_url_tracking_display = $('[data-name=url_tracking_display] INPUT').val();
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

/*			if($('#acf-couleur_de_fond').length == 0) {
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
						_html+='<img style="max-width:100%" src="'+$('#featured-image-url').val()+'">';
						_html+='</a>';
					} else {
						_html = $('#acf-field-code').val();
					}
					if($('#pub-preview').html() != _html) {
						$('#pub-preview').html(_html);
					}
				},1000);
			}*/
			if(_links.length) {
				$('<div id="message-pub" class="updated below-h2"><p>\
					<span class="pub-metrics-clicks"></span>\
					<span class="pub-metrics-display"></span>\
					'+_links.join(' // ')+'\
				</p></div>').insertAfter('#titlediv');
			}
			$('[data-name=url_cible] INPUT').on('change',function(){
				$('[data-name=url_tracking_clicks] INPUT').val("");
			});
		}


	});


	function _get(_w,_params,_callback) {
		$.get('/wp-content/plugins/devicemed/php/ajax.php?w='+_w+'&'+$.param(_params),_callback);
	}

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function addUrlParam(_url,_param,_value) {
		if(_url.indexOf('?')==-1) {
			_c = '?';
		} else {
			_c='&';
		}
		if(_url.indexOf('&'+_param)== -1 && _url.indexOf('?'+_param)== -1) {
			_url += _c+_param+(typeof _value !='undefined' ? '='+_value : '');
		}
		return _url;
	}
	function addHash(_url,_hash) {
		if(_url.indexOf('#'+_hash)== -1) {
			_url += '#'+_hash;
		}
		return _url;
	}
	function update_url_field() {
		_url = $('#tmp-url-field').val();
		if($('#link-connexe-checkbox').prop('checked')) {
			_url = addHash(_url,'lien-connexe');
		}	
		$('#url-field').val(_url);
	}


})( jQuery );


