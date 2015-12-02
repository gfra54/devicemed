$('.body-habillage').on('click',function(_evt){
	if($(_evt.target).hasClass('body-habillage')) {
		window.open($('body').data('url'),'_blank');
	}
});
$('.body-habillage').on('mouseover',function(_evt){
	if($(_evt.target).hasClass('body-habillage')) {
		$('body').css('cursor','pointer');
	} else {
		$('body').css('cursor','default');
	}
});