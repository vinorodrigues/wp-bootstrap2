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
	define( 'BOOTSTRAP_VERSION', '2.1.0' );

define( 'BOOTSTRAP2_SEPERATE_NAVBAND', true );


if ( ! isset( $content_width ) ) $content_width = 940;


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
	// add_theme_support( 'post-thumbnails', array( 'post' ) );  // TODO : Use the_post_thumbnail()

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
	// add_theme_support( 'post-formats', array( 'aside', ) );  // TODO : see http://codex.wordpress.org/Post_Formats
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

	if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG )
		wp_enqueue_style( 'bootstrap2_debug', get_template_directory_uri() . "/css/debug.css" );

	// ---------- JS

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), BOOTSTRAP_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && isset($post->ID) && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	wp_enqueue_script( 'app-js', get_template_directory_uri() . '/js/app.js', array( 'jquery', 'bootstrap' ), false, true );

	wp_register_script( 'equalheights', get_template_directory_uri() . '/js/jquery.equalheights.js', array( 'jquery' ), false, true );

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
 * Warn about old IE
 */
function bootstrap2_warn_ie() {
	// Warn about non-HTML5 browser IE
?>
<!--[if lt IE 8]>
	<br />
	<p class="alert alert-error"><?php _e('You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> to better experience this site.', 'bootstrap2'); ?></p>
<![endif]-->
<?php
}
add_action( 'tha_header_before', 'bootstrap2_warn_ie' );


/**
 * Custom excerpt ellipses
 */
function bootstrap2_excerpt_more($more) {
	return __('more…', 'bootstrap2');
}
add_filter('excerpt_more', 'bootstrap2_excerpt_more');



// ============================================================================
// ===== Helper functions =====
// ============================================================================


require( get_template_directory() . '/inc/raw-scripts.php' );
require( get_template_directory() . '/inc/equal-heights.php' );


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


/* eof */
