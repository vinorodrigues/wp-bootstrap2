<?php
/**
 * Sortcodes for Bootstrap Scaffolding and Components
 * @see: http://twitter.github.com/bootstrap/scaffolding.html
 * @see: http://twitter.github.com/bootstrap/components.html
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */


/*
 * Helper functions
 */


function _bootstrap2_fix_atts($atts, $defaults = NULL) {
	if (is_array($atts)) {
		foreach($atts as $name => $value ) {
			if (is_numeric($name)) {
				$atts[$value] = true;
				unset($atts[$name]);
				continue;
			}
		}
		$atts = array_change_key_case($atts, CASE_LOWER);
	} elseif (!empty($atts)) {
		$atts = array($atts => true);  // $atts was a string, change to array
	} else {
		$atts = array();
	}

	if (!is_null($defaults)) {
		return shortcode_atts( $defaults, array_change_key_case($atts, CASE_LOWER) );
	} else {
		return $atts;
	}
}

function _bootstrap2_getclass($atts, $class = '') {
	if (isset($atts['class'])) $class .= ' ' . $atts['class'];
	return ltrim($class, ' ');
}

function _bootstrap2_do_($tag, $class, $content) {
	if (is_null($content)) $content = '';
	return '<' . $tag . ' class="' . $class . '">' . do_shortcode($content) . '</' . $tag . '>';
}
function _bootstrap2_do_div($class, $content) {
	return _bootstrap2_do_( 'div', $class, $content );
}

function _bootstrap2_do_span($class, $content) {
	return _bootstrap2_do_( 'span', $class, $content );
}


/*
 * Bootstrap fluid grid system
 */


function bootstrap2_row($atts, $content = null) {
	global $_bootstrap2_in_row;

	$_bootstrap2_in_row = true;
	$content = do_shortcode($content);
	$_bootstrap2_in_row = false;

	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'row');

	return '<div class="' . $class . '">' . $content . '</div>';
}

function bootstrap2_one_half($atts, $content = null) {
	global $_bootstrap2_in_row;
	if (( ! isset($_bootstrap2_in_row) ) || ( ! $_bootstrap2_in_row )) return;

	$s = intval( bootstrap2_column_class(true, false) / 2);
	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'span' . $s);
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_one_third($atts, $content = null) {
	global $_bootstrap2_in_row;
	if (( ! isset($_bootstrap2_in_row) ) || ( ! $_bootstrap2_in_row )) return;

	$s = intval( bootstrap2_column_class(true, false) / 3);
	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'span' . $s);
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_two_thirds($atts, $content = null) {
	global $_bootstrap2_in_row;
	if (( ! isset($_bootstrap2_in_row) ) || ( ! $_bootstrap2_in_row )) return;

	$s = intval( bootstrap2_column_class(true, false) / 3) * 2;
	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'span' . $s);
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_one_fourth($atts, $content = null) {
	global $_bootstrap2_in_row;
	if (( ! isset($_bootstrap2_in_row) ) || ( ! $_bootstrap2_in_row )) return;

	$s = intval( bootstrap2_column_class(true, false) / 4);
	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'span' . $s);
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_three_fourths($atts, $content = null) {
	global $_bootstrap2_in_row;
	if (( ! isset($_bootstrap2_in_row) ) || ( ! $_bootstrap2_in_row )) return;

	$s = intval( bootstrap2_column_class(true, false) / 4) * 3;
	$atts = _bootstrap2_fix_atts($atts);
	$class = _bootstrap2_getclass($atts, 'span' . $s);
	return _bootstrap2_do_div($class, $content);
}

add_shortcode( 'row', 'bootstrap2_row' );
add_shortcode( 'one_half', 'bootstrap2_one_half' );
add_shortcode( 'half', 'bootstrap2_one_half' );  // lazy
add_shortcode( 'one_third', 'bootstrap2_one_third' );
add_shortcode( 'third', 'bootstrap2_one_third' );  // lazy
add_shortcode( 'two_thirds', 'bootstrap2_two_thirds' );
add_shortcode( 'one_fourth', 'bootstrap2_one_fourth' );
add_shortcode( 'fourth', 'bootstrap2_one_fourth' );  // lazy
add_shortcode( 'three_fourths', 'bootstrap2_three_fourths' );


/*
 * Bootstrap responsive utility classes
 */

 
function bootstrap2_visible($atts, $content = null) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'on' => 'all',
		));
	switch (strtolower($atts['on'])) {
		case 'phone': $class = 'visible-phone'; break;
		case 'tablet': $class = 'visible-tablet'; break;
		case 'desktop': $class = 'visible-desktop'; break;
		case 'all': $class = ''; break;
		case 'none': $class = 'hidden'; break;
		default: $class = '';
	}
	$class = _bootstrap2_getclass($atts, $class);
	return _bootstrap2_do_span($class, $content);
}

function bootstrap2_hidden($atts, $content = null) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'on' => 'none',
		));
	switch (strtolower($atts['on'])) {
		case 'phone': $class = 'hidden-phone'; break;
		case 'tablet': $class = 'hidden-tablet'; break;
		case 'desktop': $class = 'hidden-desktop'; break;
		case 'all': $class = 'hidden'; break;
		case 'none': $class = ''; break;
		default: $class = 'hidden';
	}
	$class = _bootstrap2_getclass($atts, $class);
	return _bootstrap2_do_span($class, $content);
}

add_shortcode( 'visible', 'bootstrap2_visible');
add_shortcode( 'hidden', 'bootstrap2_hidden' );


/*
 * Buttons
 */


function bootstrap2_button_grp( $atts, $content = null ) {
	$class = _bootstrap2_getclass(_bootstrap2_fix_atts($atts), 'btn-group');
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_button( $atts, $content = null ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'link' => '',  // create a->href
		'action' => '',  // create onclick event
		'size' => '',  // mini, small or large
		'type' => '',  // primary, danger, warning, success, info or inverse
   		'id' => '',
   		'title' => '',
		));
	$class = 'btn';

	switch (strtolower($atts['size'])) {
		case 'mini': $class .= ' btn-mini'; break;
		case 'small': $class .= ' btn-samll'; break;
		case 'large': $class .= ' btn-large'; break;
		default: ;
	}
	switch (strtolower($atts['type'])) {
		case 'primary': $class .= ' btn-primary'; break;
		case 'danger': $class .= ' btn-danger'; break;
		case 'warning': $class .= ' btn-warning'; break;
		case 'success': $class .= ' btn-success'; break;
		case 'info': $class .= ' btn-info'; break;
		case 'inverse': $class .= ' btn-inverse'; break;
		default: ;
	}

	$tag = ($atts['link'] != '') ? 'a' : 'button';
	$button = '<' . $tag;
	if ($atts['link'] != '') $button .= ' href="' . $atts['link'] . '"';
	if ($atts['action'] != '') $button .= ' onclick="' . $atts['action'] . '"';
	if ($atts['id'] != '') $button .= ' id="' . $atts['id'] . '"';
	$button .= ' class="' . _bootstrap2_getclass($atts, $class) . '"';
	if ($atts['title'] != '') $button .= ' title="' . $atts['title'] . '"';
	$button .= '>' . do_shortcode($content) . '</' . $tag . '>';
	return $button;
}

add_shortcode( 'button_group', 'bootstrap2_button_grp' );
add_shortcode( 'button', 'bootstrap2_button' );


/*
 * Tabbable nav
 *
 * Uses a few globals:
 *   bootstrap2_tabs
 *   bootstrap2_tabs_init
*/


// TODO : extend code to allow tabbable tabs-below, tabs-right & tabs-below
// TODO : extend code to allow custom id and append class

function bootstrap2_print_tabs_script() {
	global $bootstrap2_tabs_list;
	if (isset($bootstrap2_tabs_list)) {
		echo '<script type="text/javascript">' . PHP_EOL . '/* <![CDATA[ */' . PHP_EOL;
		foreach ($bootstrap2_tabs_list as $tgroup) {
			$src = '(function ($) {' . PHP_EOL;
			$src .= "$('#" . $tgroup . " a').click(function (e) { e.preventDefault(); $(this).tab('show'); })";
			$src .= PHP_EOL . '})(jQuery);';
			echo $src;
		}
		echo PHP_EOL . '/* ]]> */' . PHP_EOL . '</script>' . PHP_EOL;
	}
}

function _do_tab_grp($tabs, $atts = NULL, $tgroup = NULL) {
	if (is_null($tgroup)) {
		global $bootstrap2_tabs_count;
		if (!isset($bootstrap2_tabs_count)) $bootstrap2_tabs_count = 0;
		$bootstrap2_tabs_count++;
		$tgroup = 'tabs' . $bootstrap2_tabs_count;
	}

	// find active tab
	$fndactive = false;
	foreach ($tabs as $tab) {
		if ($tab['active']) {
			$fndactive = true;
			break;
		}
	}
	if (!$fndactive) $tabs[0]['active'] = true;

	// render un-orderd list
	$out = '<ul class="nav nav-tabs" id="' . $tgroup . '">';
	foreach ($tabs as $tab) {
		$class = $tab['active'] ? 'active' : '';

		$out .= '<li' . (($class != '') ? ' class="' . $class . '"' : '') . '>';
		$out .= '<a href="#' . $tab['id'] . '" data-toggle="">';
		$out .= $tab['caption'];
		$out .= '</a>';
		$out .= '</li>';
	}
	$out .= '</ul>';

	// render tab content
	$out .= '<div class="tab-content">';
	foreach ($tabs as $tab) {
		$class = 'tab-pane';
		$class .= $tab['active'] ? ' active' : '';

		$out .= '<div class="' . $class . '" id="' . $tab['id'] . '">';
		$out .= do_shortcode($tab['content']);
		$out .= '</div>';
	}
	$out .= '</div>';

	// Enable via jQuery
	global $bootstrap2_tabs_list;
	if (!isset($bootstrap2_tabs_init)) {
		$bootstrap2_tabs_init = array();
		add_action('wp_footer', 'bootstrap2_print_tabs_script');
	}
	$bootstrap2_tabs_list[] = $tgroup;

	return $out;
}

function bootstrap2_tab_grp( $atts, $content ) {
	global $bootstrap2_tabs;
	if (!isset($bootstrap2_tabs)) $bootstrap2_tabs = array();

	do_shortcode( $content );  // render inner tabs et. al.

	$out = _do_tab_grp($bootstrap2_tabs);

	unset($bootstrap2_tabs);  // kill the global
	return $out;
}

function bootstrap2_tab( $atts, $content ) {
	global $bootstrap2_tabs;

	if (isset($bootstrap2_tabs)) {
		$bootstrap2_tabs[] = array(
			'caption' => $atts['title'],
			'content' => $content,
			'id' => '_' . count($bootstrap2_tabs),
			'active' => false,
			);
	}
	return '';
}

add_shortcode( 'tab_group', 'bootstrap2_tab_grp' );
add_shortcode( 'tab', 'bootstrap2_tab' );


/*
 * Breaks
 */


function bootstrap2_break( $atts, $content = null ) {
	return '<div class="clear"><br /></div>';
}

add_shortcode('break', 'bootstrap2_break');


/*
 * Hero unit & well
 */

 
function bootstrap2_hero( $atts, $content = null ) {
	return _bootstrap2_do_div(_bootstrap2_getclass(_bootstrap2_fix_atts($atts), 'hero-unit'), $content);
}

function bootstrap2_well( $atts, $content = null ) {
	return _bootstrap2_do_div(_bootstrap2_getclass(_bootstrap2_fix_atts($atts), 'well'), $content);
}

add_shortcode('hero', 'bootstrap2_hero');
add_shortcode('well', 'bootstrap2_well');


/*
 * Inline labels & Badges
 */


function bootstrap2_label( $atts, $content = null ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'container' => 'span',
		'type' => '',  // success, warning, info, important or inverse
		));
	$class = 'label';
	switch (strtolower($atts['type'])) {
		case 'success': $class .= ' label-success'; break;
		case 'warning': $class .= ' label-warning'; break;
		case 'info': $class .= ' label-info'; break;
		case 'important': $class .= ' label-important'; break;
		case 'inverse': $class .= ' label-inverse'; break;
		default: ;
	}

	/*switch ($atts['container']) :
		case 'span' :
			return _bootstrap2_do_span(_bootstrap2_getclass($atts, $class), $content); break;
		case 'div' :
			return _bootstrap2_do_div(_bootstrap2_getclass($atts, $class), $content); break;
		default :*/
			return '<' . $atts['container'] . ' class="' . $class . '">' . do_shortcode($content) . '</' . $atts['container'] . '>'; /* break;
	endswitch; */
}

function bootstrap2_badge( $atts, $content = null ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'type' => '',  // success, warning, important, info or inverse
		));
	$class = 'badge';
	switch (strtolower($atts['type'])) {
		case 'success': $class .= ' badge-success'; break;
		case 'warning': $class .= ' badge-warning'; break;
		case 'important': $class .= ' badge-important'; break;
		case 'info': $class .= ' badge-info'; break;
		case 'inverse': $class .= ' badge-inverse'; break;
		default: ;
	}

	return _bootstrap2_do_div(_bootstrap2_getclass($atts, $class), $content);
}

add_shortcode('label', 'bootstrap2_label');
add_shortcode('badge', 'bootstrap2_badge');


/*
 * Equal Heights JS
 */

function bootstrap2_equalheights( $atts, $content = null ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'class' => '',
		'id' => '',
	));
	if (!empty($atts['id'])) {
		$what = '#' . $atts['id'];
	} elseif (!empty($atts['class'])) {
		$what = explode(' ', trim($atts['class']));
		$what = '.' . $what[0];  // only the first class
	} else {
		$what = false;
	}

	ts_equal_heights($what);
	return '';
}

add_shortcode('equalheights', 'bootstrap2_equalheights');

/* eof */
