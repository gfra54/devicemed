var _st=false;
var _menu_top=false;
var _menu_bottom=false;
var _wpadminbar = 0;
$(document).ready(function() {

	if($('#wpadminbar').length) {
		_wpadminbar = $('#wpadminbar').height();
	}
	_menu_top = $('.menu-fournisseurs').offset().top;
	_menu_bottom = _menu_top + $('.menu-fournisseurs').height();
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

	$('.gallerie-photo').fancybox();

	  $('.menu-fournisseurs .menu-item').click(function(e) {
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
	  });	
});

$(window).scroll(function(){
	_st = $(window).scrollTop()
	if(_menu_top) {
		if(_st) {
			if(_menu_top < _st + _wpadminbar) {
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

