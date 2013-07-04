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


/** Change the company tag line in the footer */
function child_bootstrap2_site_generator( $text ) {
	$text = '<a href="http://duckduckgo.com?q=Tecsmith" rel="generator">Your company</a>';
	return $text;
}
add_filter( 'bootstrap2_site_generator', 'child_bootstrap2_site_generator' );


/** Change the Widget heading html tag */
function child_bootstrap2_widget_tag( $tag ) {
	return 'h4';
}
add_filter( 'bootstrap2_widget_tag', 'child_bootstrap2_widget_tag' );


/** Change not found and 404 behaviour */
function child_bootstrap2_no_results_class($class) { return 'alert alert-error'; }
add_filter( 'bootstrap2_no_results_class', 'child_bootstrap2_no_results_class');
function child_bootstrap2_no_results_heading($text) { return '<strong>BUGGER!</strong>'; }
add_filter( 'bootstrap2_no_results_heading', 'child_bootstrap2_no_results_heading' );
function child_bootstrap2_no_results_text($text) { return 'This is not the page you\'re looking for.'; }
add_filter( 'bootstrap2_no_results_text', 'child_bootstrap2_no_results_text' );
function child_bootstrap2_404_heading($text) { return '%$#@! - ' . $text; }
add_filter( 'bootstrap2_404_heading', 'child_bootstrap2_404_heading' );
function child_bootstrap2_404_text($text) { return 'Someone here has ended up where they\'re not meant to be.'; }
add_filter( 'bootstrap2_404_text' ,'child_bootstrap2_404_text' );


/** and if you're using the TS-Contact-Form plugin */
function my_contact_form_send_text( $text ) {
	return '<i class="icon-envelope icon-white"></i> ' . $text;
}
add_filter('ts_contact_form_send_text', 'my_contact_form_send_text');


/* eof */
