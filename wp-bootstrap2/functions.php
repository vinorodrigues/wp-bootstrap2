<?php
/**
 * WP-Bootstrap2 functions and definitions
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
*/


/**
 * Define the version, in case it becomes useful down the road.
 */
define( 'BOOTSTRAP2_VERSION', '0.1' );

define( 'BOOTSTRAP2_SEPERATE_NAVBAND', true );


/**
 * Application of Theme Hook Aliance
 * See: https://github.com/zamoose/themehookalliance 
 */
require( get_template_directory() . '/inc/tha-theme-hooks.php' );

if ( ! function_exists( 'bootstrap2_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	require( get_template_directory() . '/inc/menu-walker.php' );
	require( get_template_directory() . '/inc/shortcodes.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Bootstrap2, use a find and replace
	 * to change 'bootstrap2' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bootstrap2', get_template_directory() . '/lang' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails', array( 'post' ) );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bootstrap2' ),
		'header-menu' => __( 'Header Menu', 'bootstrap2' ),
		'footer-menu' => __( 'Footer Menu', 'bootstrap2' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // bootstrap2_setup
add_action( 'after_setup_theme', 'bootstrap2_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_widgets_init() {
	$default = array(
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	);

	register_sidebar( array_merge( $default, array(
		'name' => __( 'Sidebar 1', 'bootstrap2' ),
		'id' => 'sidebar-1',
		'description' => __( 'First sidebar asside the content', 'bootstrap2' ),
	) ) );

	register_sidebar( array_merge( $default, array(
		'name' => __( 'Sidebar 2', 'bootstrap2' ),
		'id' => 'sidebar-2',
		'description' => __( 'Second sidebar asside the content', 'bootstrap2' ),
	) ) );

	register_sidebar( array_merge( $default, array(
		'name' => __( 'Headerbar', 'bootstrap2' ),
		'id' => 'sidebar-3',
		'description' => __( 'Header widget area', 'bootstrap2' ),
	) ) );

	for ($i = 1; $i <= 6; $i++) :  // 4 to 9
		register_sidebar( array_merge( $default, array(
			'name' => sprintf(__( 'Footerbar %d', 'bootstrap2' ), $i),
			'id' => 'sidebar-'.($i+3),
			'description' => sprintf(__( 'Footer area %d of %d', 'bootstrap2' ), $i, 6),
		) ) );

	endfor;

	register_sidebar( array_merge( $default, array(
		'name' => __( 'Homepage Only', 'bootstrap2' ),
		'id' => 'sidebar-10',
		'description' => __( 'Area above content on the home page only', 'bootstrap2' ),
	) ) );

	require( get_template_directory() . '/inc/navlist-widget.php' );
	register_widget( 'Bootstrap2_Navlist_Widget' );
}
add_action( 'widgets_init', 'bootstrap2_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function bootstrap2_scripts() {
	global $post;

	// ---------- CSS

	$min = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . "/css/bootstrap{$min}.css" );

	$swatch = bootstrap2_get_theme_option('swatch');
	if (! empty($swatch))
		wp_enqueue_style( 'bootstrap-swatch', get_template_directory_uri() . "/css/swatch/{$swatch}{$min}.css" );

	wp_enqueue_style( 'app-style', get_template_directory_uri() . "/css/app.css" );  // TODO : app.min.css
	wp_enqueue_style( 'style', get_stylesheet_uri(), 'app-style' );
	wp_enqueue_style( 'print-style', get_template_directory_uri() . "/css/print.css", 'app-style', false, 'print' );

	
	if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG )
		wp_enqueue_style( 'bootstrap2_debug', get_template_directory_uri() . "/css/debug.css" );

	// ---------- JS

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '2.0.4', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'bootstrap2_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Custom background
 */
require( get_template_directory() . '/inc/custom-background.php' );

// ----------------------------------------------------------------------------
// ----- Page Help -----

function get_top_sidebar() {
	$sidebars = bootstrap2_get_theme_option_sidebars();
	if (in_array($sidebars, array('sc', 'ssc', 'scs')))
		get_sidebar();
	if (in_array($sidebars, array('ssc')))
		get_sidebar('2');
}

function get_bottom_sidebar() {
	$sidebars = bootstrap2_get_theme_option_sidebars();
	if (in_array($sidebars, array('css', 'cs')))
		get_sidebar();
	if (in_array($sidebars, array('scs', 'css')))
		get_sidebar('2');
}


// ============================================================================
// ===== Helper functions =====
// ============================================================================

/**
 * wp_add_inline_style() exists since 3.3, this is the fallback
 * @param type $handle
 * @param type $data
 */
if (!function_exists('wp_add_inline_style')) {
function wp_add_inline_style( $handle, $data ) {
	echo "<!-- {$handle} -->\n<style type=\"text/css\">\n{$data}\n</style>\n";
}}


/* eof */
