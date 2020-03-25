<?php
// Creating the widget 
class pubs_300x600 extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'pubs_300x600', 

		// Widget name will appear in UI
		__('300x600', 'pubs_300x600_domain'), 

		// Widget description
		array( 'description' => __( 'Widget de diffusion de bannières pubs 300x600', 'pubs_300x600_domain' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		afficher_pub('300x600');


		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( '', 'pubs_300x600_domain' );
		}
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class ends here

// Register and load the widget
function pubs_300x600_load_widget() {
	register_widget( 'pubs_300x600' );
}
add_action( 'widgets_init', 'pubs_300x600_load_widget' );