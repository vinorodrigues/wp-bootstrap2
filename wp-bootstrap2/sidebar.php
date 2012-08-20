<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

$sidebars = bootstrap2_get_theme_option_sidebars();

$class = '';
if ($sidebars != 'c') :  // content only
	$class = (in_array($sidebars, array('sc', 'ssc', 'scs')) ? 'left' : 'right');
$class .= ' ' . ( bootstrap2_get_theme_option('well_w', true) ? '' : 'un' ) . 'well';
?>
<div id="secondary" class="widget-area span<?php bootstrap2_column_class(false); ?> layout-<?php echo $sidebars; ?>" role="complementary">
	<?php do_action( 'before_sidebar' ); tha_sidebars_before(); ?>
	<div id="sidebar-1" class="<?php echo apply_filters('the_sidebar_class', $class); ?>">
		<?php
			tha_sidebar_top();
			if ( ! dynamic_sidebar( 'sidebar-1' ) ) :
				if ( ! bootstrap2_get_theme_option('inhibit_default_sidebar') ) :
				
					$args = array(
						'before_widget' => '<aside class="widget">',
						'after_widget' => "</aside>",
						'before_title' => '<h2 class="widget-title">',
						'after_title' => '</h2>',
					);

					the_widget( 'WP_Widget_Search', array( 'title' => __('Search', 'bootstrap2') ), $args );
					the_widget( 'WP_Widget_Archives', array( 'title' => __('Archives', 'bootstrap2') ), $args );
					the_widget( 'WP_Widget_Meta', array( 'title' => __('Meta', 'bootstrap2') ), $args );
				endif;
			endif; // end sidebar widget area
			if (in_array($sidebars, array('sc', 'cs'))) dynamic_sidebar( 'sidebar-2' );
			tha_sidebar_bottom();
		?>
	</div>
	<?php tha_sidebars_after(); do_action( 'after_sidebar' ); ?>
</div>
<?php
endif;
