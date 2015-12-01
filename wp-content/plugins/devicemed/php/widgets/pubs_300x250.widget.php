<?php
// Creating the widget 
class pubs_300x250 extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'pubs_300x250', 

		// Widget name will appear in UI
		__('300x250', 'pubs_300x250_domain'), 

		// Widget description
		array( 'description' => __( 'Widget de diffusion de bannières pubs 300x250', 'pubs_300x250_domain' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		afficher_pub('300x250');


		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( '', 'pubs_300x250_domain' );
		}
/*		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php */
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class ends here

// Register and load the widget
function pubs_300x250_load_widget() {
	register_widget( 'pubs_300x250' );
}
add_action( 'widgets_init', 'pubs_300x250_load_widget' );