var _st=false;
var _menu_top=false;
var _menu_bottom=false;
var _wpadminbar = 0;
$(document).ready(function() {
/*	if(read_cookie('wpadmin')) {
		$('body').addClass('voir-adminbar');
		if($('#wp-admin-bar').length==0) {

			$('<script type="text/javascript" src="/wp-includes/js/admin-bar.min.js?ver=4.1.8"></script>\
				<link rel="stylesheet" id="dashicons-css"  href="/wp-includes/css/dashicons.min.css?ver=4.1.8" type="text/css" media="all" />\
				<link rel="stylesheet" href="/wp-includes/css/admin-bar.min.css?ver=4.1.8" type="text/css"/>\
				<div id="wpadminbar" class="" role="navigation">\
				<a class="screen-reader-shortcut" href="#wp-toolbar" tabindex="1">Aller à la barre d’outils</a>\
				<div class="quicklinks" id="wp-toolbar" role="navigation" aria-label="Barre de navigation supérieure." tabindex="0">\
				<ul id="wp-admin-bar-root-default" class="ab-top-menu">\
				<li id="wp-admin-bar-wp-logo" class="menupop"><a class="ab-item" aria-haspopup="true" href="/wp-admin/about.php" title="À propos de WordPress"><span class="ab-icon"></span></a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-wp-logo-default" class="ab-submenu">\
				<li id="wp-admin-bar-about"><a class="ab-item" href="/wp-admin/about.php">À propos de WordPress</a>		</li></ul><ul id="wp-admin-bar-wp-logo-external" class="ab-sub-secondary ab-submenu">\
				<li id="wp-admin-bar-wporg"><a class="ab-item" href="http://www.wordpress-fr.net/">Site de WordPress-FR</a>		</li>\
				<li id="wp-admin-bar-documentation"><a class="ab-item" href="http://codex.wordpress.org/">Documentation</a>		</li>\
				<li id="wp-admin-bar-support-forums"><a class="ab-item" href="http://www.wordpress-fr.net/support">Forums d’entraide</a>		</li>\
				<li id="wp-admin-bar-feedback"><a class="ab-item" href="https://wordpress.org/support/forum/requests-and-feedback">Remarque</a>		</li></ul></div>		</li>\
				<li id="wp-admin-bar-site-name" class="menupop"><a class="ab-item" aria-haspopup="true" href="/wp-admin/">DeviceMed.fr</a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-site-name-default" class="ab-submenu">\
				<li id="wp-admin-bar-dashboard"><a class="ab-item" href="/wp-admin/">Tableau de bord</a>		</li></ul><ul id="wp-admin-bar-appearance" class="ab-submenu">\
				<li id="wp-admin-bar-themes"><a class="ab-item" href="/wp-admin/themes.php">Thèmes</a>		</li>\
				<li id="wp-admin-bar-customize" class="hide-if-no-customize"><a class="ab-item" href="/wp-admin/customize.php?url=http%3A%2F%2Fwww.devicemed.local%2F%3Fs%3Dqosina">Personnaliser</a>		</li>\
				<li id="wp-admin-bar-menus"><a class="ab-item" href="/wp-admin/nav-menus.php">Menus</a>		</li></ul></div>		</li>\
				<li id="wp-admin-bar-new-content" class="menupop"><a class="ab-item" aria-haspopup="true" href="/wp-admin/post-new.php" title="Créer"><span class="ab-icon"></span><span class="ab-label">Créer</span></a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-new-content-default" class="ab-submenu">\
				<li id="wp-admin-bar-new-post"><a class="ab-item" href="/wp-admin/post-new.php">Article</a>		</li>\
				<li id="wp-admin-bar-new-media"><a class="ab-item" href="/wp-admin/media-new.php">Fichier média</a>		</li>\
				<li id="wp-admin-bar-new-page"><a class="ab-item" href="/wp-admin/post-new.php?post_type=page">Page</a>		</li>\
				<li id="wp-admin-bar-new-salons"><a class="ab-item" href="/wp-admin/post-new.php?post_type=salons">Salon</a>		</li>\
				<li id="wp-admin-bar-new-newsletter"><a class="ab-item" href="/wp-admin/post-new.php?post_type=newsletter">Newsletter</a>		</li>\
				<li id="wp-admin-bar-new-pubs"><a class="ab-item" href="/wp-admin/post-new.php?post_type=pubs">Publicité</a>		</li>\
				<li id="wp-admin-bar-new-fournisseur"><a class="ab-item" href="/wp-admin/post-new.php?post_type=fournisseur">Fournisseur</a>		</li>\
				<li id="wp-admin-bar-new-user"><a class="ab-item" href="/wp-admin/user-new.php">Utilisateur</a>		</li></ul></div>		</li></ul><ul id="wp-admin-bar-top-secondary" class="ab-top-secondary ab-top-menu">\
				<li id="wp-admin-bar-search" class="admin-bar-search"><div class="ab-item ab-empty-item" tabindex="-1"><form action="/" method="get" id="adminbarsearch"><input class="adminbar-input" name="s" id="adminbar-search" type="text" value="" maxlength="150"><input type="submit" class="adminbar-button" value="Recherche"></form></div>		</li>\
				</ul></div>\
				<a class="screen-reader-shortcut" href="/wp-login.php?action=logout&amp;_wpnonce=9bb29c6436">Se déconnecter</a>\
				</div>').appendTo('body');
			$('body').css('padding-top',32);
		} else {
			$('#wp-admin-bar-my-account, #wp-admin-bar-updates, #wp-admin-bar-comments').remove();
			$('body').css('padding-top',1);
		}

	}*/
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

	$('.gallerie-photo, .lien-photo').fancybox();

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