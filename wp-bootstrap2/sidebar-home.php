<?php
/**
 * Home widget area
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

if ( ! is_active_sidebar( 'sidebar-10' ) )
	return;

$build = bootstrap2_get_theme_option('page', 'fp');
$fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';
$class = bootstrap2_get_theme_option('well_w');
?>

<div id="home<?php if ($build != 'p') echo '-band'; ?>" role="region">
<?php if ($build != 'p') echo '<div id="home-wrap" class="container' . $fluid . '">'; ?>

	<div id="banner banner-home" class="row<?php echo $fluid; ?> clearfix" role="banner">
		<div class="span12">
		<?php do_action( 'before_sidebar' ); tha_sidebars_before(); ?>
		<div id="sidebar-10" class="<?php echo apply_filters('the_sidebar_class', $class); ?>">
			<?php
				tha_sidebar_top();
				dynamic_sidebar( 'sidebar-10' );
				tha_sidebar_bottom();
			?>
		</div>
		<?php tha_sidebars_after(); do_action( 'after_sidebar' ); ?>
		</div>
	</div>

<?php if ($build != 'p') echo '</div>'; ?>
</div>
