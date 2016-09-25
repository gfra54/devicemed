(function(){
    // Load plugin specific language pack
    tinymce.PluginManager.requireLangPack('spq');
    
    tinymce.create('tinymce.plugins.SPQPlugin', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function(ed, url){


            // Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
            ed.addCommand('mceSPQ', function(){
               _txt = 'Donec rutrum congue leo eget malesuada. Donec rutrum congue leo eget malesuada. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Proin eget tortor risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum porta. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh.';
                _txt = '<div class="exergue-texte"><h2>Titre de l\'encadré</h2><p>'+_txt+'</p></div>';
                if(_txt) {
                    ed.execCommand('mceInsertContent', false, '<div class="entry-exergue ">'+ _txt +'</div>');
                    ed.execCommand('mceRepaint');
                }
            });
            // Register button
            ed.addButton('spq', {
                title: 'Ajouter un encadré',
                cmd: 'mceSPQ',
                image: url + '/img/encadre.png'
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
        createControl: function(n, cm){
            return null;
        },
        
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo: function(){
            return {
                longname: 'Exergues',
                author: '',
                authorurl: '',
                infourl: '',
                version: "1.0"
            };
        }
    });
    
    // Register plugin
    tinymce.PluginManager.add('spq', tinymce.plugins.SPQPlugin);
})();
