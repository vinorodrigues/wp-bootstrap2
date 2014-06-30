<?php
/**
 * Plugin Name: Bootstrap CDN
 * Plugin URI: http://github.com/vinorodrigues/bootstrap2
 * Description: Load Bootstrap 2 from known CDN sources
 * Author: Vino Rodrigues
 * Version: 2.3.2
 * Author URI: http://vinorodrigues.com
 */


if ( ! defined( 'BOOTSTRAP_VERSION' ) )
	define( 'BOOTSTRAP_VERSION', '2.3.2' );


/*
// Small fix to work arround windows and virtual paths while in dev env.
if ( defined('WP_DEBUG') && WP_DEBUG )
	define( 'BOOTSTRAPCDN_PLUGIN_SLUG', basename(dirname(__FILE__)) . '/' . pathinfo(__FILE__, PATHINFO_FILENAME) . '.php' );
if ( ! defined('BOOTSTRAPCDN_PLUGIN_SLUG') )
	define( 'BOOTSTRAPCDN_PLUGIN_SLUG', plugin_basename(__FILE__) );
*/

/**
 * Check if Settings API supported
 */
/* function bootstrapcdn_requires_wordpress_version() {
	global $wp_version;
	$plugin = BOOTSTRAPCDN_PLUGIN_SLUG;
	$plugin_data = get_plugin_data( __FILE__, false );

	if ( version_compare($wp_version, "3.0", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires WordPress 3.0 or higher, and has been deactivated!" );
		}
	}
}
add_action( 'admin_init', 'bootstrapcdn_requires_wordpress_version' ); */


/**
 * wp_enqueue_scripts action
 */
function bootstrapcdn_enqueue_scripts() {
	global $wp_scripts;

	// ----- Bootstrap -----
	$q = wp_script_is('bootstrap');
	$r = wp_script_is('bootstrap', 'registered');
	if ($r || $q) :
		wp_deregister_script('bootstrap');
		$src = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://maxcdn.bootstrapcdn.com/bootstrap/'.BOOTSTRAP_VERSION.'/js/bootstrap.min.js';
		wp_register_script('bootstrap', $src, array('jquery'), BOOTSTRAP_VERSION, true);

		if ($q) wp_enqueue_script('bootstrap');
	endif;

	$q = wp_style_is('bootstrap');
	$r = wp_style_is('bootstrap', 'registered');
	if ($r || $q) :
		wp_deregister_style('bootstrap');
		$src = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://maxcdn.bootstrapcdn.com/bootstrap/'.BOOTSTRAP_VERSION.'/css/';
		if (wp_style_is('bootstrap-responsive')) :
			wp_deregister_style('bootstrap-responsive');
			$src .= 'bootstrap-combined.min.css';
		else :
			$src .= 'bootstrap.min.css';
		endif;
		wp_register_style('bootstrap', $src);

		if ($q) wp_enqueue_style('bootstrap');
	endif;
}

if (!is_admin()) :
	add_action('wp_enqueue_scripts', 'bootstrapcdn_enqueue_scripts', 11);
endif;
