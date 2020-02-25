<?php 

function notices_admin_custo(){
    global $pagenow;
    if ( $pagenow == 'post.php' && ($_GET['post'] == 14187 || $_GET['post'] == 22159) && $_GET['action'] == 'edit') {
         echo '<div class="notice notice-warning">
             <p><big>Cette pub est spéciale, son url cible et son image mise en avant son renseignées automatiquement par le site.<br><b><big>IL NE FAUT PAS LA MODIFIER</big></b></big></p>
         </div>';
    }
}
add_action('admin_notices', 'notices_admin_custo');


