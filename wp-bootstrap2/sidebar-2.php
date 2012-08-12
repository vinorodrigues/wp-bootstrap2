<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

$sidebars = bootstrap2_get_theme_option_sidebars();
if ( ! is_active_sidebar( 'sidebar-2' ))
	return;

$class = (in_array($sidebars, array('sc', 'ssc')) ? 'left' : 'right');
$class .= ' ' . ( bootstrap2_get_theme_option('well_w', true) ? '' : 'un' ) . 'well';

?>

<div id="tertiary" class="widget-area <?php bootstrap2_column_class(false); ?> layout-<?php echo $sidebars; ?>" role="complementary">
	<?php do_action( 'before_sidebar' ); tha_sidebars_before(); ?>
	<div id="sidebar-2" class="<?php echo apply_filters('the_sidebar_class', $class); ?>">
		<?php
			tha_sidebar_top();
			dynamic_sidebar( 'sidebar-2' );
			tha_sidebar_bottom();
		?>
	</div>
	<?php tha_sidebars_after(); do_action( 'after_sidebar' ); ?>
</div>
