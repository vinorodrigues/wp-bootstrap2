<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

// layout
$build = bootstrap2_get_theme_option('page', 'fp');
$fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';
// branding
$logo = apply_filters( 'bootstrap2_get_theme_logo', bootstrap2_get_theme_option('logo', '') );
// navbar
$icon = apply_filters( 'bootstrap2_get_theme_icon', bootstrap2_get_theme_option('icon', false) );
$name = apply_filters( 'bootstrap2_get_theme_project_name', bootstrap2_get_theme_option('name', false) );
$search = bootstrap2_get_theme_option('search', false);

$has_r_head = is_active_sidebar( 'sidebar-3' ) || has_nav_menu( 'header-menu' );
$has_l_head = ('blank' != get_header_textcolor()) || (! empty($logo));
$has_nav_bar = has_nav_menu( 'primary' ) ||
	( ! bootstrap2_get_theme_option( 'inhibit_default_menu', false ) ) ||
	$search || $icon || $name;
$bodyclass = 'navbar-normal';
$sidebars = bootstrap2_get_theme_option_sidebars();

?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6 lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<?php tha_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'bootstrap2' ), max( $paged, $page ) );

	?></title>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo apply_filters( 'apple_mobile_web_app_status_bar_style', 'black' ) ?>" />
<meta name="viewport" content="initial-scale= 1.0, width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php tha_head_bottom(); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class( $bodyclass ); ?>>

<?php /*
 * Following structure as at:
 * http://themeshaper.com/2009/06/24/creating-wordpress-theme-html-structure-tutorial/
 * https://github.com/zamoose/themehookalliance/blob/master/tha-example-index.php
 *
 * Ideas from example layouts at:
 * http://www1.sherzod.me/bootstrap/
 */ ?>

<?php if ($build == 'p') echo '<div id="wrapper' . $fluid . '" class="page container' . $fluid . '" role="region">'; ?>

<div id="header<?php if ($build != 'p') echo '-band'; ?>" role="region">
<?php if ($build != 'p') echo '<div id="header-wrap" class="container' . $fluid . '">'; ?>
<?php tha_header_before(); ?>
<header id="masthead" class="site-header" role="banner">
	<?php tha_header_top(); ?>
	<div id="leader" class="row<?php echo $fluid; ?>">
	<hgroup id="branding" class="site-brand <?php echo $has_r_head ? 'span6' : 'span12'; ?>" <?php if (!$has_l_head && !$has_r_head) echo 'style="display:none;visibility:hidden"' ?>>
		<?php if (empty($logo)) { ?>
		<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<h3 class="site-description"><?php bloginfo( 'description', 'display' ); ?></h3>
		<?php } else { ?>
		<h1 class="site-logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) . ' -- ' . get_bloginfo( 'description', 'display' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></h1>
		<?php } ?>
	</hgroup>
	<?php if ($has_r_head) : ?>
	<div id="top-nav" class="site-nav span6" role="complementary">
		<?php if (has_nav_menu( 'header-menu' )) :

			wp_nav_menu( array(
				'container' => 'nav',
				'container_class' => 'subnav clearfix',
				'theme_location' => 'header-menu',
				'menu_class' => 'nav nav-pills pull-right',
				'depth' => 2,
				'fallback_cb' => false,
				'walker' => new Bootstrap2_Nav_Walker,
			) );

		endif; ?>
		<?php if (is_active_sidebar( 'sidebar-3' )) : ?>
		<div id="sidebar-3" class="widget-area pull-right">
			<?php
				do_action( 'tha_headerbar_top' );
				dynamic_sidebar( 'sidebar-3' );
				do_action( 'tha_headerbar_bottom' );
			?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	</div>
	<?php if (function_exists('bootstrap2_admin_header_image')) bootstrap2_admin_header_image(); ?>
	<?php tha_header_bottom(); ?>
	<?php 
		if ( BOOTSTRAP2_SEPERATE_NAVBAND && ($build != 'p') ) :
			echo '</header></div></div>';
			echo '<div id="navbar-band" role="region"><div id="navbar-wrap" class="container' . $fluid . '"><header>';
		endif;
	?>
	<?php if ( $has_nav_bar ) : ?>
	<nav role="navigation" class="site-navigation main-navigation" id="access">
		<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'bootstrap2' ); ?>"><?php _e( 'Skip to content', 'bootstrap2' ); ?></a></div>
		<div class="navbar<?php echo bootstrap2_get_theme_option('darkbar', false) ? ' navbar-inverse' : ''; ?>"><div class="navbar-inner"><div class="container">
		<?php /*<!-- .btn-navbar is used as the toggle for collapsed navbar content -->*/ ?>
		<?php if ($icon || $name) { ?>
		<a class="brand" href="<?php echo home_url( '/' ); ?>"><?php if ($icon) echo '<img src="' . $icon . '" />'; ?><?php if ($icon && $name) echo '<span class="space"></span>'; ?><?php if ($name) echo $name; ?></a>
		<?php } ?>
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
		<?php

			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class' => 'nav',
				'container' => 'div',
				'container_class' => 'nav-collapse',
				'depth' => 2,
				'fallback_cb' => bootstrap2_get_theme_option( 'inhibit_default_menu', false ) ? false : 'bootstrap2_fallback_page_menu',
				'walker' => new Bootstrap2_Nav_Walker,
			) );

		?>
		<?php if ($search) { 
			bootstrap2_navbar_searchform();
		} ?>
		</div></div></div>
	</nav>
	<?php endif; // $has_nav_bar ?>
</header>
<?php tha_header_after(); ?>
<?php if ($build != 'p') echo '</div>'; ?>
</div>

<?php if ( is_home() ) get_sidebar('home'); ?>

<div id="main<?php if ($build != 'p') echo '-band'; ?>" class="content hfeed" role="main">
<?php if ($build != 'p') echo '<div id="main-wrap" class="container' . $fluid . '">'; ?>
<div class="row<?php echo $fluid; ?>">
<div id="primary" class="site-content <?php bootstrap2_column_class(1); ?> layout-<?php echo $sidebars; ?>">
