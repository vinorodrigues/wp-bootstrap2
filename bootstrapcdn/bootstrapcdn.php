<?php
/**
 * Plugin Name: Bootstrap CDN
 * Plugin URI: http://github.com/vinorodrigues/bootstrap2
 * Description: Load Bootstrap and jQuery from known CDN sources
 * Author: Vino Rodrigues
 * Version: 2.2.2
 * Author URI: http://vinorodrigues.com
 *
 * Based on code from:
 * http://www.eddturtle.co.uk/2011/load-jquery-from-google-cdn-in-wordpress/
 * http://digwp.com/2009/06/use-google-hosted-javascript-libraries-still-the-right-way/
 */


if ( ! defined( 'BOOTSTRAP_VERSION' ) )
	define( 'BOOTSTRAP_VERSION', '2.2.2' );
if ( ! defined( 'JQUERY_VERSION' ) )
	define( 'JQUERY_VERSION', '1' );  // wp3.4 = 1.7.2, latest = 1.8.1, edge = 1

// Don't bother if Jason Penney's plugin is installed
// see: http://jasonpenney.net/wordpress-plugins/use-google-libraries/
// or: http://wordpress.org/extend/plugins/use-google-libraries/
if ( ! defined( 'BOOTSTRAPCDN_JQUERY' ) )
	define( 'BOOTSTRAPCDN_JQUERY', (! class_exists( 'JCP_UseGoogleLibraries' )) );


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

	if ( version_compare($wp_version, "2.7", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires WordPress 2.7 or higher, and has been deactivated!" );
		}
	}
}
add_action( 'admin_init', 'bootstrapcdn_requires_wordpress_version' ); */


/**
 * wp_enqueue_scripts action
 */
function bootstrapcdn_enqueue_scripts() {
	global $wp_scripts, $_bootstrapcdn_fallback;

	if ( BOOTSTRAPCDN_JQUERY ) :

		// ----- jQuery fallback -----
		if ( ! isset($_bootstrapcdn_fallback) && is_a( $wp_scripts, 'WP_Scripts' ) ) :
			$q = $wp_scripts->query( 'jquery', 'registered' );
			if ( is_object( $q ) && isset($q->src) )
				$_bootstrapcdn_fallback = $q->src;
		endif;

		// ----- jQuery -----
		$q = wp_script_is('jquery');
		$r = wp_script_is('jquery', 'registered');
		if ($r || $q) :
			wp_deregister_script('jquery');
			$src = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://ajax.googleapis.com/ajax/libs/jquery/'.JQUERY_VERSION.'/jquery.min.js';
			wp_register_script('jquery', $src, false, JQUERY_VERSION);
			// wp_enqueue_script('jquery');

			if ($q) wp_enqueue_script('jquery');
		endif;

	endif;  // JCP_UseGoogleLibraries

	// ----- Bootstrap -----
	$q = wp_script_is('bootstrap');
	$r = wp_script_is('bootstrap', 'registered');
	if ($r || $q) :
		wp_deregister_script('bootstrap');
		$src = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://netdna.bootstrapcdn.com/twitter-bootstrap/'.BOOTSTRAP_VERSION.'/js/bootstrap.min.js';
		wp_register_script('bootstrap', $src, array('jquery'), BOOTSTRAP_VERSION);

		if ($q) wp_enqueue_script('bootstrap');
	endif;

	$q = wp_style_is('bootstrap');
	$r = wp_style_is('bootstrap', 'registered');
	if ($r || $q) :
		wp_deregister_style('bootstrap');
		$src = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://netdna.bootstrapcdn.com/twitter-bootstrap/'.BOOTSTRAP_VERSION.'/css/';
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

function bootstrapcdn_footer() {
	global $_bootstrapcdn_fallback;

	if (isset($_bootstrapcdn_fallback)) :
		?><script type="text/javascript">window.jQuery || document.write('<script src="<?php echo $_bootstrapcdn_fallback; ?>"><\/script>');</script><?php
	endif;
}


if (!is_admin()) :
	add_action('wp_enqueue_scripts', 'bootstrapcdn_enqueue_scripts', 11);
	if ( BOOTSTRAPCDN_JQUERY ) add_action('wp_footer', 'bootstrapcdn_footer', 9);
endif;

/* eof */
