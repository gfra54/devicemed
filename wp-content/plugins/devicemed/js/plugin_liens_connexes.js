(function() {
    tinymce.create('tinymce.plugins.LiensConnexes', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
        	var _current_ed = ed;
			ed.addButton('liens_connexes', {
			    title : 'Liens connexes',
			    cmd : 'liens_connexes',
			    image : url + '/../images/liens_connexes.png'
			});

            ed.addCommand('liens_connexes', function() {
            	if(_url = prompt('URL du lien connexe')) {
	                var selected_text = ed.selection.getContent();
	                var return_text = '';
					jQuery.post('/wp-admin/',{
						'action'	: 'get-meta-from-page',
						'url'		: _url
					},function(_data){
		                if(!selected_text) {
							if('title' in _data) {
								selected_text = (_data.title+'&#8211;').split('&#8211;')[0];
							}
						}
		                return_text = '<a href="'+_url+'#lien-connexe">' + selected_text + '</a>';
		                _current_ed.execCommand('mceInsertContent', 0, return_text);
					})	                
	            }
            }); 
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'liens_connexes',
                author : 'GF',
                authorurl : '',
                infourl : '',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'liens_connexes', tinymce.plugins.LiensConnexes );
})();