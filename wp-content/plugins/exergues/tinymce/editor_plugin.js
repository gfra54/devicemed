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
               _txt = 'Contenu de l\'encadré.';
                _txt = '<div class="exergue-texte"><h2>Titre de l\'encadré</h2><p>'+_txt+'</p></div>';
                if(_txt) {
                    _taille = prompt('Quelle largeur définir pour cet encadré.\nVous pouvez entrer une valeur en pourcentage de la largeur du contenu (50%, 20%, 100%), ou bien en pixels (50px, 150px, etc.).\nPréférez les pourcentages. ','40%');
                    if(!_taille) {
                        return;
                    }
                    _alignement_droite=false;
                    if(_taille != '100%'){
                      _alignement_droite = confirm('Voulez-vous aligner le bloc à droite ?');
                    }
                    ed.execCommand('mceInsertContent', false, '<div class="entry-exergue '+(!_alignement_droite?'' : 'exergue-droite')+' '+(_taille == '100%' ? 'exergue-full' : '')+'" style="width:'+_taille+'">'+ _txt +'</div>');
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

    function exergue_edit(_obj){
            _exergue = jQuery(_obj,jQuery('#content_ifr'));
            _taille = prompt('Quelle largeur définir pour cet encadré.\nVous pouvez entrer une valeur en pourcentage de la largeur du contenu (50%, 20%, 100%), ou bien en pixels (50px, 150px, etc.).\nPréférez les pourcentages. ',_exergue.attr('style').replace('width:','').replace(';','').replace(/ /g,''));
            if(!_taille) {
                return;
            }
            if(_taille.indexOf('%')==-1){
                _taille+='%';
            }
            _exergue.attr('style','width:'+_taille);
            _exergue.attr('data-mce-style','width:'+_taille);
            
            if(_taille != '100%'){
                _exergue.removeClass('exergue-full');
            } else {
                _exergue.addClass('exergue-full');
            }
    }

function exergue_align(_obj) {
        _alignement_droite=false;
        _exergue = jQuery(_obj,jQuery('#content_ifr'));
        _taille = _exergue.attr('style').replace('width:','').replace(';','').replace(/ /g,'');
        if(_taille != '100%'){
            _exergue.toggleClass('exergue-droite');
        }
}
