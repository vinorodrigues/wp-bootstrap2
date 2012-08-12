<?php
/**
 * Implementation of Custom Backgrounds
 * @see: http://codex.wordpress.org/Custom_Backgrounds
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */


/**
 *
 */
function bootstrap2_custom_background_setup() {
	$args = array(
		'default-color' => 'FFFFFF',
		// 'default-image' => '',
		// 'wp-head-callback' => '',
		// 'admin-head-callback' => '',
		// 'admin-preview-callback' => '',
	);

	$args = apply_filters( 'bootstrap2_custom_background_args', $args );

	add_theme_support( 'custom-background', $args );
}
add_action( 'after_setup_theme', 'bootstrap2_custom_background_setup' );


/* eof */
