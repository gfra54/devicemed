<?php

$blocs = get_field('blocs', 'option');

if(count($blocs))  {
	?>

	<div id="sidebar" class="column col-md-3 col-sm-4 column-sidebar">
		<?php
		foreach($blocs as $bloc) {
			if($bloc['bloc_actif'] && $bloc['contenu_du_bloc']) {	
				eval('?'.'>'.$bloc['contenu_du_bloc']);
			}
		}
		?>
	</div>

<?php }