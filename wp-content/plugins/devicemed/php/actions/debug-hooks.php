<?php
/**
 * Inspect/list functions called on hooks containing specific term
 *
 * @param array Array of terms that the hook should contain
 * @return array
 */
function inspect_hooks( $terms = [ 'wp_' ] ) {
	global $wp_filter;
	$related_hooks = [];
	$total         = 0;

	if ( ! is_array( $terms ) ) {
		$terms = [ $terms ];
	}

	foreach ( $wp_filter as $key => $val ) {
		if ( string_contains_all_words( $key, $terms ) ) {
			foreach ( $val->callbacks as $priority ) {
				foreach ( $priority as $callback ) {
					foreach ( $callback as $function => $function_data ) {
						if ( $function !== 'function' ) {
							continue;
						}

						if ( is_array( $function_data ) ) {
							$method = $function_data[1];

							if ( is_string( $function_data[0] ) ) {
								$classname = $function_data[0];
							} else {
								$classname = get_class( $function_data[0] );
							}

							if ( method_exists( $function_data[0], $method ) ) {
								$reflection    = new \ReflectionMethod( $classname, $method );
								$function_name = $classname . '->' . $method;
								$related_hooks[ $key ][] = sprintf( '<strong>%1$s</strong> in <em>%2$s</em> <small>L%3$d</small>', $function_name, str_replace( ABSPATH, '', $reflection->getFileName() ), $reflection->getStartLine() );
							} else {
								$function_name = $classname . '->' . $method;
								$related_hooks[ $key ][] = sprintf( '<strong>%1$s</strong> (method not found)', $function_name );
							}
						} else {
							$reflection = new \ReflectionFunction( $function_data );

							if ( $function_data instanceof \Closure ) {
								$related_hooks[ $key ][] = sprintf( 'closure in <em>%1$s</em> <small>L%2$d</small>', str_replace( ABSPATH, '', $reflection->getFileName() ), $reflection->getStartLine() );
							} else {
								$related_hooks[ $key ][] = sprintf( '<strong>%3$s</strong> in <em>%1$s</em> <small>L%2$d</small>', str_replace( ABSPATH, '', $reflection->getFileName() ), $reflection->getStartLine(), $function_data );
							}
						}

						$total++;
					}
				}
			}
		}
	}

	$related_hooks['total'] = $total;

	return $related_hooks;
}

/**
 * Check if a string contains ALL words from an array
 *
 * @param array $array Array of strings
 * @return boolean
 */
function string_contains_all_words( $string, $array ) {
	$missed = false;

	foreach ( $array as $word ) {
		if ( strpos( $string, $word ) !== false ) {
			continue;
		} else {
			$missed = true;
			break;
		}
	}

	return ! $missed;
}


//add_action( 'init', 'debug_hooks' );
function debug_hooks() {

	me(inspect_hooks( [ 'wp_scheduled_auto_draft_delete' ] ));
}