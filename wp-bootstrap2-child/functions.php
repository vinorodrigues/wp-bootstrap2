<?php
/**
 * Bootstrap2 Child Theme functions
 */

 
/**
 * The `get_template_directory_uri()` function will always return the directory
 * of the template, which, in a Child Theme is the Parent Theme. If you need to
 * reference the Child Theme URI, you should instead use the
 * `get_stylesheet_directory_uri()` function. 
 */
if (!defined('CHILD_THEME_URL')) {
	define( 'CHILD_THEME_URL', get_stylesheet_directory_uri() );
}  
 

/**
 * Setup background
 */ 
function child_bootstrap2_custom_background_args($args) {
	$args['default-image'] = CHILD_THEME_URL . '/img/bg.png';
	return $args;
}
add_action( 'bootstrap2_custom_background_args', 'child_bootstrap2_custom_background_args' );


/**
 * Setup header default images
 */
function child_bootstrap2_after_child_setup() {
	register_default_headers( array(
		'1' => array(
			'url' => CHILD_THEME_URL . '/img/header/header1.png',
			'thumbnail_url' => CHILD_THEME_URL . '/img/header/header1-thumb.png',
		),
		'2' => array(
			'url' => CHILD_THEME_URL . '/img/header/header2.png',
			'thumbnail_url' => CHILD_THEME_URL . '/img/header/header2-thumb.png',
		),
	) );
}
add_action( 'after_setup_theme', 'child_bootstrap2_after_child_setup' ); 


function child_bootstrap2_get_theme_logo( $logo_url ) {
	if (empty($logo_url))
		$logo_url = CHILD_THEME_URL . '/img/yourlogo.png';
	return $logo_url;
}
add_filter( 'bootstrap2_get_theme_logo', 'child_bootstrap2_get_theme_logo' );


function child_bootstrap2_get_theme_icon( $icon_url ) {
	if (empty($icon_url))
		$icon_url = CHILD_THEME_URL . '/img/youricon.png';
	return $icon_url;
}
add_filter( 'bootstrap2_get_theme_icon', 'child_bootstrap2_get_theme_icon' );


function child_bootstrap2_site_generator( $text ) {
	$text = '<a href="http://google.com?q=Tecsmith" rel="generator">Your company</a>';
	return $text;
}
add_filter( 'bootstrap2_site_generator', 'child_bootstrap2_site_generator');


/* eof */
