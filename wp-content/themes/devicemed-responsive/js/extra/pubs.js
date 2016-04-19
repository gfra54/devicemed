$(document).ready(function(){
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
});

function randomPub(_pubs) {

	if(_pub = _pubs[Math.floor(Math.random()*_pubs.length)]) {

		_style='';

		if(_pub.bordure) {
			_style+='border:1px solid #ccc;';
			_pub.largeur_maximale-=2;
		}
		if(_pub.largeur_maximale>0) {
			_style+='max-width:'+_pub.largeur_maximale+'px;';
		}
		if(_style){
			_style = 'style="'+_style+'"';
		}
		console.log(_pub);

		document.write('<a href="'+addURLParameter(_pub.url_tracking_clicks,'t',_pub.time)+'" target="_blank"><img '+_style+' src="'+addURLParameter(_pub.url_tracking_display,'t',_pub.time)+'"></a>');
	}

}


function addURLParameter(url, param, value) {
   var a = document.createElement('a'), regex = /(?:\?|&amp;|&)+([^=]+)(?:=([^&]*))*/gi;
   var params = {}, match, str = []; a.href = url;
   while (match = regex.exec(a.search))
       if (encodeURIComponent(param) != match[1]) 
           str.push(match[1] + (match[2] ? "=" + match[2] : ""));
   str.push(encodeURIComponent(param) + (value ? "=" + encodeURIComponent(value) : ""));
   a.search = str.join("&");
   return a.href;
}