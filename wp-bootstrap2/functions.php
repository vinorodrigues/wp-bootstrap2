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
if ( ! defined( 'BOOTSTRAP_VERSION' ) )
	define( 'BOOTSTRAP_VERSION', '2.3.2' );

define( 'BOOTSTRAP2_SEPERATE_NAVBAND', true );

if ( ! defined( 'WP35UP' ) ) :
	global $wp_version;
	define( 'WP35UP', !version_compare($wp_version, "3.5", "<" ) );
endif;


if ( ! isset( $content_width ) ) $content_width = 940;


/**
 * Application of Theme Hook Aliance
 * @see https://github.com/zamoose/themehookalliance
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
 * @since Bootstrap2 0.1
 */
function bootstrap2_setup() {

	/** @see http://core.trac.wordpress.org/changeset/24417 */
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );

	/** Custom template tags for this theme. */
	require( get_template_directory() . '/inc/template-tags.php' );

	/** Custom functions that act independently of the theme templates */
	require( get_template_directory() . '/inc/tweaks.php' );

	/** Custom Theme Options */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/** WordPress.com-specific functions and definitions */
	//require( get_template_directory() . '/inc/wpcom.php' );

	require( get_template_directory() . '/inc/menu-walker.php' );
	require( get_template_directory() . '/inc/shortcodes.php' );
	require( get_template_directory() . '/inc/gallery.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Bootstrap2, use a find and replace
	 * to change 'bootstrap2' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bootstrap2', get_template_directory() . '/lang' );

	/** Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );

	/** Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails', array( 'post' ) );
	add_image_size( 'post-thumbnail', 140, 140 );

	/** This theme uses wp_nav_menu() in one location. */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bootstrap2' ),
		'header-menu' => __( 'Header Menu', 'bootstrap2' ),
		'footer-menu' => __( 'Footer Menu', 'bootstrap2' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 * @see http://codex.wordpress.org/Post_Formats
	 * @see http://wp.tutsplus.com/articles/news/what-theme-authors-need-to-know-about-post-formats-in-wordpress-3-6/
	 */
	add_theme_support( 'post-formats', array( 'gallery', 'aside' ) );
	// add_theme_support( 'structured-post-formats', array( 'video' ) );

}
endif; // bootstrap2_setup
add_action( 'after_setup_theme', 'bootstrap2_setup' );


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Bootstrap2 0.1
 */
function bootstrap2_widgets_init() {
	$wtag = apply_filters('bootstrap2_widget_tag', 'h3');
	$default = array(
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<' . $wtag . ' class="widget-title">',
		'after_title' => '</' . $wtag . '>',
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

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . "/css/bootstrap{$min}.css", array(), BOOTSTRAP_VERSION );
	wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri() . "/css/bootstrap-responsive{$min}.css", array('bootstrap'), BOOTSTRAP_VERSION );

	$sidebars = bootstrap2_get_theme_option_sidebars();
	if (in_array($sidebars, array('sc', 'ssc', 'scs')))
		wp_enqueue_style( 'bootstrap-inset', get_template_directory_uri() . "/css/bootstrap-inset{$min}.css", array('bootstrap'), BOOTSTRAP_VERSION );

	if ( ! is_child_theme() ) {
		$swatch = bootstrap2_get_theme_option('swatch_css');
		if ( ! empty($swatch) )
			wp_enqueue_style( 'bootstrap-swatch', $swatch, array('bootstrap'), false, 'screen' );
	}

	wp_enqueue_style( 'app-style', get_template_directory_uri() . "/css/app{$min}.css" );
	wp_enqueue_style( 'style', get_stylesheet_uri(), 'app-style' );
	wp_enqueue_style( 'print-style', get_template_directory_uri() . "/css/print{$min}.css", 'app-style', false, 'print' );

	/** Add CSS that will aid in *all* debug */
	if ( defined('WP_DEBUG') && WP_DEBUG )
		wp_enqueue_style( 'bootstrap2_debug', get_template_directory_uri() . "/css/debug.css" );

	// ---------- JS

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . "/js/bootstrap{$min}.js", array( 'jquery' ), BOOTSTRAP_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && isset($post->ID) && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . "/js/keyboard-image-navigationremysharp.com/html5-enabling-script{$min}.js", array( 'jquery' ), '20120202' );
	}

	wp_enqueue_script( 'app-js', get_template_directory_uri() . '/js/app.js', array( 'jquery', 'bootstrap' ), false, true );

	wp_register_script( 'equalheights', get_template_directory_uri() . "/js/equalheights{$min}.js", array( 'jquery' ), false, true );

	if ( ! is_child_theme() ) {
		$swatch = bootstrap2_get_theme_option('swatch_js');
		if ( ! empty($swatch) )
			wp_enqueue_script( 'bootstrap-swatch', $swatch, array('bootstrap'), false );
	}
	
	// ---------- editor style
	add_editor_style('editor-style.css');
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


/**
 * Custom excerpt ellipses
 * @see http://dylanized.com/the-ultimate-guide-to-wordpress-post-excerpts/
 */
/* function bootstrap2_excerpt_more($more) {
	return __('more...', 'bootstrap2');
}
add_filter('excerpt_more', 'bootstrap2_excerpt_more'); */



// ============================================================================
// ===== Addons =====
// ============================================================================


require( get_template_directory() . '/inc/raw-scripts.php' );
require( get_template_directory() . '/inc/equal-heights.php' );
require( get_template_directory() . '/inc/carousel.php' );
require( get_template_directory() . '/inc/feeds.php' );

if ( defined('WP_DEBUG') && WP_DEBUG )
	@include( get_template_directory() . '/inc/debug.php' );


// ============================================================================
// ===== Helper functions =====
// ============================================================================


/**
 * wp_add_inline_style() exists since 3.3, this is the fallback
 * @param type $handle
 * @param type $data
 */
if (!function_exists('wp_add_inline_style')) :
function wp_add_inline_style( $handle, $data ) {
	echo "<!-- {$handle} -->\n<style type=\"text/css\">\n{$data}\n</style>\n";
}
endif;


/**
 * See: http://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
 */
if (!function_exists('copyright_date')) :
function copyright_date() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("SELECT " .
		" YEAR(min(post_date_gmt)) AS firstdate," .
		" YEAR(max(post_date_gmt)) AS lastdate" .
		" FROM" .
		" $wpdb->posts" .
		" WHERE" .
		" post_status = 'publish'");
	$output = '';
	if ($copyright_dates) {
		$output .= $copyright_dates[0]->firstdate;
		if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
			$output .= '-' . $copyright_dates[0]->lastdate;
		}
	}
	return $output;
}
endif;


/**
 * Add feed icons
 * @see http://www.feedicons.com/
 */
function bootstrap2_feed_icons() {
	echo '<span class="feeds">';
	echo '<a type="application/rss+xml" class="rss-feed" href="' . 
		get_bloginfo('rss2_url') . '" title="' .
		sprintf(__('RSS feed for %s', 'bootstrap2'), get_bloginfo('name')) .
		'" >' . __('RSS', 'bootstrap2') . '</a>';
	echo '</span>';
}
add_action('bootstrap2_feed_icons', 'bootstrap2_feed_icons', 10);


/** Default gravatar */
function bootstrap2_avatar_defaults($avatars) {
	$gravatar = get_template_directory_uri() . '/img/gravatar.png';
	$avatars[$gravatar] = __('Theme Default', 'bootstrap2');
	return $avatars;
}
add_filter( 'avatar_defaults', 'bootstrap2_avatar_defaults' );


/**
 * More relevant contact methods
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/user_contactmethods
 */
function bootstrap2_user_contactmethods( $user_contact ) {
	/* Add user contact methods */
	$user_contact['facebook'] = __('Facebook page', 'bootstrap2');
	$user_contact['gplus'] = __('Google+ page', 'bootstrap2');
	$user_contact['twitter'] = __('Twitter username', 'bootstrap2');
	$user_contact['linkedin'] = __('LinkedIn username', 'bootstrap2');

	unset($user_contact['yim']);
	unset($user_contact['aim']);
	unset($user_contact['jabber']);

	return $user_contact;
}

add_filter('user_contactmethods', 'bootstrap2_user_contactmethods');

/* eof */
