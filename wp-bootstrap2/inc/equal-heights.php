<?php
/**
 * Usage of equalheights.js
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.2
 */

if ( !function_exists( 'ts_equal_heights' ) ) :
function ts_equal_heights( $what = false, $interval = 100 ) {
	static $_ts_equalheights_count = 0;  // was global

	if ($what) {
		/* if ( ! isset($_ts_equalheights_count) ) $_ts_equalheights_count = 0; // now using static */
		$_ts_equalheights_count++;
		$f = 'equalHeights_' . $_ts_equalheights_count;
		$t = 'resizeTimer_' . $_ts_equalheights_count;
		$h = str_replace( array('.', '#'), array('dot-', 'hash-'), $what );
		if ( ! wp_script_is( 'equalheights', 'registered' ) )
			_doing_it_wrong(__FUNCTION__,
				'You need to <code>wp_register_script( "equalheights", "equalheights.js")</code> first',
				'0.2');

		if ($_ts_equalheights_count <= 1)
			wp_enqueue_script( 'equalheights' );
		ts_enqueue_script( 'equalheights-' . $h,
			'(function($) {' . "\n" .
			'  function ' . $f . '() { $("' . $what . '").equalHeights(); }' . "\n" .
			'  var ' . $t . ' = null;' . "\n" .
			'  function ' . $f . '_timed() {' .
				' if (' . $t . ') clearTimeout(' . $t . ');' .
				' ' . $t . ' = setTimeout(' . $f . ', ' . intval($interval) . ');' .
				' }' . "\n" .
			'  $(document).ready(' . $f . '_timed);' . "\n" .
			'  $(window).bind("resize", ' . $f . '_timed);' . "\n" .
			'})(jQuery);', 'equalheights' );
	}
}
endif;


/*
 * Equal Heights shortcode
 */

function bootstrap2_equalheights( $atts, $content = null, $tag = '' ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'class' => '',
		'id' => '',
		'wait' => '100',
	));

	if (!empty($atts['id'])) {
		$what = '#' . $atts['id'];
	} elseif (!empty($atts['class'])) {
		$what = explode(' ', trim($atts['class']));
		$what = '.' . $what[0];  // only the first class
	} else
		return '';

	ts_equal_heights($what, $atts['wait']);
	return '';
}

add_shortcode('equalheights', 'bootstrap2_equalheights');



/* eof */
