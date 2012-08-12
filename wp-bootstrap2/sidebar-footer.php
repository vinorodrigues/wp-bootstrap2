<?php
/**
 * The Footer widget areas.
 *
 * Based on code from TwentyEleven (default WP 3 Theme)
 * Also read "Nesting" in: http://twitter.github.com/bootstrap/scaffolding.html
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 */
$footerbars = array();
for ( $i = 4; $i <= 9; $i++)
	if (is_active_sidebar( 'sidebar-'.$i )) {
		$footerbars[] = 'sidebar-'.$i;
	}

/* If none of the sidebars have widgets, then let's bail early.
 */
if ( count($footerbars) == 0 ) {
	unset( $footerbars );
	return;
}

/*if (!isset($sidebars)) $sidebars = bootstrap2_get_theme_option_sidebars();*/

// Now set the classes and then do it

$class_list = array('first', 'second', 'third', 'fourth', 'fifth', 'sixth');
switch (count( $footerbars )) {
	case 1: $span_classes = array('span12'); break;
	case 2: $span_classes = explode(',', 'span6,span6'); break;
	case 3: $span_classes = explode(',', 'span4,span4,span4'); break;
	case 4: $span_classes = explode(',', 'span3,span3,span3,span3'); break;
	case 5: $span_classes = explode(',', 'span3,span2,span2,span2,span3'); break;
	case 6: $span_classes = explode(',', 'span2,span2,span2,span2,span2,span2'); break;
}

if (!isset($fluid)) $fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';

$well_w = bootstrap2_get_theme_option('well_w', true);

?>

<?php do_action('tha_banner_before');  ?>
<div id="banner banner-footer" class="row<?php echo $fluid; ?> clearfix" role="banner">
	<?php
		$j = count($footerbars);
		for ($i = 0; $i < $j; $i++) :
			$class = 'banner ' . $class_list[$i];
			if ( $i == ($j-1) ) $class .= ' last';
			$class .= ' ' . ( $well_w ? '' : 'un' ) . 'well';
			$class = apply_filters('the_banner_class', $class, $i, $j);
			do_action( 'tha_banner_top' );
	?>
	<div id="banner-<?php echo $i+1; ?>" class="widget-area <?php echo $span_classes[$i]; ?>" role="complementary">
		<div id="<?php echo $footerbars[$i]; ?>" class="<?php echo $class; ?>">
			<?php dynamic_sidebar( $footerbars[$i] ); ?>
		</div>
	</div>
	<?php
			do_action( 'tha_banner_bottom' );
		endfor;
	?>
</div>
<?php do_action('tha_banner_after');  ?>
