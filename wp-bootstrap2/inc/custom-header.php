<?php
/**
 * Sample implementation of the Custom Header feature
 * @see: http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses bootstrap2_header_style()
 * @uses bootstrap2_admin_header_style()
 * @uses bootstrap2_admin_header_image()
 */
function bootstrap2_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'random-default'         => true,
		'width'                  => 1170,
		'height'                 => 250,
		'flex-height'            => true,
		//'flex-width'             => false,
		'default-text-color'     => '000000',
		'header-text'            => true,
		//'uploads'                => true,
		'wp-head-callback'       => 'bootstrap2_header_style',
		'admin-head-callback'    => 'bootstrap2_admin_header_style',
		'admin-preview-callback' => 'bootstrap2_admin_header_image',
	);

	$args = apply_filters( 'bootstrap2_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );  // deprecated
	}
}
add_action( 'after_setup_theme', 'bootstrap2_custom_header_setup' );


if ( ! function_exists( 'get_custom_header' ) ) :
/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Bootstrap2
 * @since Bootstrap2 1.1
 */
function get_custom_header() {
	return (object) array(
		'url'           => get_header_image(),
		'thumbnail_url' => get_header_image(),
		'width'         => HEADER_IMAGE_WIDTH,
		'height'        => HEADER_IMAGE_HEIGHT,
	);
}
endif;

if ( ! function_exists( 'bootstrap2_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see bootstrap2_custom_header_setup().
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_header_style() {
	?>
	<style type="text/css">
	<?php
		// If no custom options for text are set
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
		if ( HEADER_TEXTCOLOR == get_header_textcolor() ) :
	?>
		/*.site-title a {
			color: inherit !important;
		}*/
		.site-title a:hover,
		.site-title a:focus {
			text-decoration: none;
		}
	<?php
		// If we get this far, we have custom styles. Let's do this.

		// Has the text been hidden?
		elseif ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			visibility: hidden; display: none;
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
		.site-title a:hover,
		.site-title a:focus {
			text-decoration: none;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // bootstrap2_header_style


if ( ! function_exists( 'bootstrap2_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see bootstrap2_custom_header_setup().
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
	}
	#headimg h1 {
	}
	#headimg h1 a {
	}
	#desc {
	}
	#headimg img {
	}
	</style>
<?php
}
endif; // bootstrap2_admin_header_style


if ( ! function_exists( 'bootstrap2_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see bootstrap2_custom_header_setup().
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_admin_header_image() {
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) : ?>
		<div id="headimg" class="site-brand site-image">
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		</div>
	<?php
	endif;
}
endif; // bootstrap2_admin_header_image

/* eof */
