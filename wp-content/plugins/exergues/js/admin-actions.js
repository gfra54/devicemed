(function( $ ) {
	$(window).load(function(){
		setInterval(function(){
			gestion_exergues();
		},500);
	});

	function gestion_exergues(){
		$("#content_ifr").contents().find('.entry-exergue').mouseover(function(){
			if($(this).find('.exergue-delete').length == 0) {
				$('<span class="exergue-delete" onclick="this.parentNode.parentElement.removeChild(this.parentNode)"></span>').appendTo(this);
				$('<span class="exergue-edit" onclick="parent.exergue_edit(this.parentNode)"></span>').appendTo(this);
				$('<span class="exergue-align" onclick="parent.exergue_align(this.parentNode)"></span>').appendTo(this);
			}
		});
	}


})(jQuery);
