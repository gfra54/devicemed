<?php
function addthis_buttons(){?>
	<div class="addthis_sharing_toolbox"></div>
<?php }

function addthis_head_code() {?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54fdbf9819676ed8" async="async"></script>

<?php }

add_action('wp_head', 'addthis_head_code');
