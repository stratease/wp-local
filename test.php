<?php

phpinfo();
exit;

// -------------------------------------------------------
// Globals
// -------------------------------------------------------
$cnv_this_unique_php_file = basename( __FILE__ );

// -------------------------------------------------------
// Run on page load
// -------------------------------------------------------

// --- Libraries ---
//cnv_add_files( array( 'TEST', 'jquery-confirm', 'select2', 'dropzone', 'cryptojs-aes-php', 'sweetalert2' ), $slug );

// --- Actions ---

// --- Filters ---

// --- Shortcodes ---
//add_shortcode('my_orders', 'shortcode_my_orders');

// -------------------------------------------------------
// Action & filter functions
// -------------------------------------------------------

// -------------------------------------------------------
// Shortcodes
// -------------------------------------------------------
//function shortcode_my_orders( $atts ) {
//	$args        = shortcode_atts(
//		array(
//			'order_count' => - 1
//		),
//		$atts
//	);
//	$order_count = esc_attr( $args['order_count'] );
//
//	ob_start();
//	wc_get_template( 'myaccount/my-orders.php', array(
//		'current_user' => get_user_by( 'id', get_current_user_id() ),
//		'order_count'  => $order_count
//	) );
//
//	return ob_get_clean();
//}

// -------------------------------------------------------
// Utility functions
// -------------------------------------------------------

// -------------------------------------------------------
// Test & delete
// -------------------------------------------------------


//add_action( 'pre_get_posts', 'tribe_post_date_ordering', 51 );
//function tribe_post_date_ordering( $query ) {
//	if ( ! empty( $query->tribe_is_multi_posttype ) ) {
//		remove_filter( 'posts_fields', array( 'Tribe__Events__Query', 'multi_type_posts_fields' ) );
//		$query->set( 'order', 'DESC' );
//	}
//}

add_shortcode( 'cnv_test_shortcode', 'cnv_test_shortcode' );  // Return an event selected in site options.
function cnv_test_shortcode() : string {
	$args = array(  // Base query args to use.
		'post_type'                    => 'tribe_events',
		'posts_per_page'               => - 1,
		'tribe_suppress_query_filters' => true,
		//		'meta_key' => '_EventEndDate',
		//		'meta_value' => '',
	);
	$arg_options = array(  // "orderby" query args to test.
		'menu_order',              // Success.
		'ID',                      // Success.
		'post_title',              // Success.
		'',                        // Success.
		'post_name',               // Success.
		'title',                   // Fail.
		'menu_order title',        // Fail.
		'ID guid',                 // Fail.
		'ID guid post_name',       // Fail.
		array(                     // Fail.
			'title' => 'DESC'
		),
	);
	$try = count( $arg_options );  // How many things to try?
	$output = '';
	$previous_posts_count = 1;
	$post_types = get_post_types();  // Get all the post types.
	foreach ( $post_types as $post_type ) {  // Loop for each post type;
		$args['post_type'] = $post_type;  // Set post type to test.
		$output .= '<p>Results for post type = <span style="font-weight:500">' .
		           $post_type . '</span></p>';
		for ( $i = 0; $i < $try; $i ++ ) { // Try each option.
			$args_try = $args; // Reset the base args to try.
			if ( 'array' === gettype( $arg_options[ $i ] ) ) {  // Add option to base args.
				$args_try = array_merge( $args, array( 'orderby' => $arg_options[9] ) ); // Array.
			} else {
				$args_try['orderby'] = $arg_options[ $i ];  // String.
			}
			$posts = get_posts( $args_try );  // Get the posts
			$color = '';
			if ( ( $i > 0 ) && ( $previous_posts_count !== count( $posts ) ) ) {
				$color = 'color:red;';
			} else {
				$previous_posts_count = count( $posts );
			}
			if ( 'array' === gettype( $arg_options[ $i ] ) ) {  // Add option to base args.
				ob_start();  // Turn on output buffering.
				print_r( $arg_options[ $i ] );
				$arg_option = ob_get_clean();  // Get current buffer contents and delete current.
			} else {
				$arg_option = $arg_options[ $i ];  // String.
			}
			$output .= '<p style="' . $color . 'margin-left: 2rem;"> ' . count( $posts ) .
			           ' posts were found using $args["orderby"] = "' . $arg_option . '"</p>';  // Display results.
		}
	}
	return $output;
}
