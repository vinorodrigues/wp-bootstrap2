<?php
/**
 * Usage of the jquery.equalheights.js
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.2
 */

if ( !function_exists( 'ts_equal_heights' ) ) :
function ts_equal_heights( $what = false ) {
	global $_ts_equalheights_count;

	if ($what) {
		if ( ! isset($_ts_equalheights_count) )
			$_ts_equalheights_count = 0;
		$_ts_equalheights_count++;
		$f = 'equalHeights_' . $_ts_equalheights_count;
		$t = 'resizeTimer_' . $_ts_equalheights_count;
		$h = str_replace( array('.', '#'), array('dot-', 'hash-'), $what );
		if ( ! wp_script_is( 'equalheights', 'registered' ) )
			_doing_it_wrong(__FUNCTION__,
				'You need to <code>wp_register_script( "equalheights", "jquery.equalheights.js")</code> first',
				'0.2');
		wp_enqueue_script( 'equalheights' );
		ts_enqueue_script( 'equalheights-' . $h,
			'(function($) {' . "\n" .
			'  function ' . $f . '() {' . "\n" .
			'    $("' . $what . '").equalHeights();' . "\n" .
			'  }' . "\n" .
			'  var ' . $t . ' = null;' . "\n" .
			'  function ' . $f . '_timed() {' . "\n" .
			'    if (' . $t . ') clearTimeout(' . $t . ');' . "\n" .
			'    ' . $t . ' = setTimeout(' . $f . ', 100);' . "\n" .
			'  }' . "\n" .
			'  $(document).ready(' . $f . '_timed);' . "\n" .
			'  $(window).bind("resize", ' . $f . '_timed);' . "\n" .
			'})(jQuery);' );
	}
}
endif;

/* eof */
