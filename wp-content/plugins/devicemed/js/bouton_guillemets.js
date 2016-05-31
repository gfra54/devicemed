(function() {
    tinymce.PluginManager.add('bouton_guillemets', function( editor, url ) {
        editor.addButton( 'bouton_guillemets', {
            text: 'Ajouter des guillemets',
            icon: 'guillemets-icon',
            onclick: function() {
            	_text = editor.selection.getContent();
            	if(_text.substr(_text.length - 1) == ' ') {
            		_rab =' ';
            	} else {
            		_rab = '';
            	}
                editor.insertContent('&laquo;&thinsp;'+_text.trim()+'&thinsp;&raquo;'+_rab);
            }
        });
    });

})();

jQuery(window).load(function(){
    jQuery('.mce-i-guillemets-icon').closest('button').html('<img src="/wp-content/plugins/devicemed/images/guillemets.png">');
});