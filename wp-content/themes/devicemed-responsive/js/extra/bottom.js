var _st=false;
var _menu_top=false;
var _menu_bottom=false;
var _wpadminbar = 0;
$(document).ready(function() {

	$('#formnl').submit(function() {
		openNl('about:blank');
	});
	$('.btn-nl').on('click',function(){
	    openNl('http://devicemed.us15.list-manage1.com/subscribe?u=3e97c5daff9192e3f43c22080&id=8b91d09d5c');
	})

	$('#mailjet-widget-email-field-6901').on('focus keyup keydown',function() {
		document.location.href = '/newsletter/inscription';
	})


	$('.menu-fournisseurs .button').each(function(){
		_id = '#'+$(this).data('id');
		if(!$(_id).length) {
			$(this).addClass('details_supplier_disabled');
		}
	});
	$(document).on('click','.souscat.opened .cat-name',function(){
		_cc = $(this).closest('.souscat').find('.cat-content');
		_cc.animate({'height':0},'slow',function(){
			$(this).closest('.souscat').addClass('closed');
			$(this).closest('.souscat').removeClass('opened');
		});
	});

	$(document).on('click','.souscat.closed',function(){
		$('.souscat.opened .cat-name').trigger('click');
		_cc = $(this).find('.cat-content').first();
		_h = _cc.find('.cat-content-in').first().height();
		_cc.animate({'height':_h},'slow',function(){
			$(this).closest('.souscat').addClass('opened');
			$(this).closest('.souscat').removeClass('closed');
			$(this).height('');
		});
	});
	if($('#wpadminbar').length) {
		_wpadminbar = $('#wpadminbar').height();
	}
	if($('.menu-fournisseurs').length) {
		_menu_top = $('.menu-fournisseurs').offset().top;
		_menu_bottom = _menu_top + $('.menu-fournisseurs').height();
	}
	try {
		$('.image_clicable a').colorbox();
	} catch(e) {}

	if(!$('[name=page]').val()) {
		$('.read-more').each(function(){
			if($(this).height()>500) {
				$(this).addClass('read-more-closed');
				$('<button class="cta">Afficher la suite</button>').appendTo(this);
				$(this).html('<div class="read-more-content">'+$(this).html()+'</div>');
			}
		});
		$(document).on('click','.read-more-closed .cta',function(){
			_read_more = $(this).closest('.read-more');
			_h=_read_more.height()
			_read_more.removeClass('read-more-closed');
			_read_more.height(_h);
			_read_more.animate({'height':_read_more.find('.read-more-content').height()},'slow',function(){
				_read_more.height('');
			});

		});
	}

	$('.article-image a, .gallerie-photo, .lien-photo, .content a[href*="uploads/"]').fancybox();

	  $('.menu-fournisseurs .menu-item').click(function(e) {
	  	if(!$(this).hasClass('details_supplier_disabled')) {
		      var target = $('#'+$(this).data('id'));
		      if(target.length) {
		      	e.preventDefault();
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if($('.menu-fournisseurs').length) {
				    _delta = $('.menu-fournisseurs').outerHeight() + 45;
				  } else {
					_delta=0;
				  }
			      if (target.length) {
			        $('html, body').animate({
			          scrollTop: target.offset().top - _delta
			        }, 1000);
			        return false;
			      }
			  }
			} else {
		      	e.preventDefault();
			}
	  });	
});

$(window).scroll(function(){
	_st = $(window).scrollTop()
	if(_menu_top) {
		if(_st) {
			if(_menu_bottom < _st + _wpadminbar) {
				if(!$('.menu-fournisseurs').hasClass('menu-floating')) {
					$('.cadre-menu-fournisseurs').height($('.menu-fournisseurs').outerHeight());
					$('.menu-fournisseurs').addClass('menu-floating').width($('.cadre-menu-fournisseurs').width()-50);
					if(_wpadminbar) {
						$('.menu-fournisseurs').css('top',_wpadminbar);
					}
				}
			} else if(_menu_bottom > _st + _wpadminbar) {
				$('.cadre-menu-fournisseurs').height('');
				$('.menu-fournisseurs').removeClass('menu-floating').width('').css('top','');
			}
		}
	}

	$($('.menu-fournisseurs A').get().reverse()).each(function(){
		_id = '#'+$(this).data('id');
		if($(_id).length) {
			if($(_id).offset().top - 200 < _st) {
				$('.menu_actif').removeClass('menu_actif');
				$(this).addClass('menu_actif');
				return false;
			}
		}
	})
});


function read_cookie(key){
    var result;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? (result[1]) : null;
}

function openNl(_url) {
	_w=500;
	_h=550;
	_x = $(window).width()/2 - _w/2;
	_y = $(window).height()/2 - _h/2;
    window.open(_url,'formnl','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width='+_w+',height='+_h+',left='+_x+',top='+_y);
}