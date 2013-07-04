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


function _bootstrap2_fix_atts($atts, $defaults = false) {
	if (is_array($atts)) {
		foreach($atts as $name => $value ) {
			if (is_numeric($name)) {
				$atts[$value] = true;
				unset($atts[$name]);
				continue;
			}
		}
	} elseif (!empty($atts)) {
		$atts = array($atts => true);  // $atts was a string, change to array
	} else {
		$atts = array();
	}

	if (is_array($defaults))
		foreach ($defaults as $key => $value)
			if (!key_exists($key, $atts)) $atts[$key] = $value;

	return $atts;
}

function _bootstrap2_getclass($atts, $class = false) {
	if (!$class) $class = '';
	if (isset($atts['class'])) $class = $atts['class'] . ' ' . $class;
	return ltrim($class, ' ');
}

function _bootstrap2_do_($element, $class, $content) {
	if (is_null($content)) $content = '';
	return '<' . $element . ' class="' . $class . '">' . do_shortcode($content) . '</' . $element . '>';
}
function _bootstrap2_do_div($class, $content) {
	return _bootstrap2_do_( 'div', $class, $content );
}

function _bootstrap2_do_span($class, $content) {
	return _bootstrap2_do_( 'span', $class, $content );
}


/*
 * Bootstrap grid system
 */


function _bootstrap2_get_row($columns, $fixed_outer_atts, $rgroup = false) {
	global $_bootstrap2_row_fluid;
	if (isset($_bootstrap2_row_fluid) && $_bootstrap2_row_fluid) {
		$class = _bootstrap2_getclass($fixed_outer_atts, 'row-fluid');
		$_bootstrap2_row_fluid = false;
	} else
		$class = _bootstrap2_getclass($fixed_outer_atts, 'row');

	$content = '';
	foreach ($columns as $col) $content .= $col;

	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_row($atts, $content = null, $tag = '') {
	global $_bootstrap2_in_row, $_bootstrap2_row_array;

	if (!isset($_bootstrap2_row_array)) $_bootstrap2_row_array = array();

	$_bootstrap2_in_row = true;
	$content = do_shortcode($content);
	$_bootstrap2_in_row = false;

	$out = _bootstrap2_get_row($_bootstrap2_row_array,
		_bootstrap2_fix_atts($atts));

	$_bootstrap2_row_array = array();  // empty out the global

	return $out;
}

function _bootstrap2_column($atts, $content, $tag, $span) {
	global $_bootstrap2_in_row, $_bootstrap2_row_array, $_bootstrap2_row_fluid;

	if ( !isset($_bootstrap2_in_row) && !$_bootstrap2_in_row )
		return "[{$tag}]" . do_shortcode( $content ) . "[/{$tag}]";

	$atts = _bootstrap2_fix_atts($atts);
	$class = false;
	if ('column' === strtolower($tag)) {
		$atts = _bootstrap2_fix_atts($atts);
		$_bootstrap2_row_fluid = true;
		for ($i = 1; $i <= 12; $i++) {
			if (isset($atts['span'.$i]) && $atts['span'.$i]) {
				$class = 'span' . $i;
				break;
			}
		}
		if (!$class && isset($atts['span'])) $class = 'span' . intval($atts['span']);
		if (!$class) $class = 'span1';
	} else if ($span) {
		$class = $span;
	}
	$class = _bootstrap2_getclass($atts, $class);

	if (isset($atts['box']) && $atts['box'])
		$content = _bootstrap2_do_div('box ' . $class, $content);
	$_bootstrap2_row_array[] = _bootstrap2_do_div($class, $content);
	return '';
}

function bootstrap2_column($atts, $content = null, $tag = '') {
	return _bootstrap2_column($atts, $content, $tag, false);
}

function bootstrap2_one_half($atts, $content = null, $tag = '') {
	$span = 'span' . intval( bootstrap2_get_column_width(1) / 2);
	return _bootstrap2_column($atts, $content, $tag, $span);
}

function bootstrap2_one_third($atts, $content = null, $tag = '') {
	$span = 'span' . intval( bootstrap2_get_column_width(1) / 3);
	return _bootstrap2_column($atts, $content, $tag, $span);
}

function bootstrap2_two_thirds($atts, $content = null, $tag = '') {
	$span = 'span' . intval( bootstrap2_get_column_width(1) / 3) * 2;
	return _bootstrap2_column($atts, $content, $tag, $span);
}

function bootstrap2_one_fourth($atts, $content = null, $tag = '') {
	$span = 'span' . intval( bootstrap2_get_column_width(1) / 4);
	return _bootstrap2_column($atts, $content, $tag, $span);
}

function bootstrap2_three_fourths($atts, $content = null, $tag = '') {
	$span = 'span' . intval( bootstrap2_get_column_width(1) / 4) * 3;
	return _bootstrap2_column($atts, $content, $tag, $span);
}

add_shortcode( 'row', 'bootstrap2_row' );
add_shortcode( 'column', 'bootstrap2_column' );
add_shortcode( 'one_half', 'bootstrap2_one_half' );
add_shortcode( 'half', 'bootstrap2_one_half' );  // lazy
add_shortcode( 'one_third', 'bootstrap2_one_third' );
add_shortcode( 'third', 'bootstrap2_one_third' );  // lazy
add_shortcode( 'two_thirds', 'bootstrap2_two_thirds' );
add_shortcode( 'one_fourth', 'bootstrap2_one_fourth' );
add_shortcode( 'fourth', 'bootstrap2_one_fourth' );  // lazy
add_shortcode( 'two_fourths', 'bootstrap2_one_half' );  // unreduced
add_shortcode( 'three_fourths', 'bootstrap2_three_fourths' );


/*
 * Bootstrap responsive utility classes
 */

 
function bootstrap2_visible($atts, $content = null, $tag = '') {
	$atts = _bootstrap2_fix_atts($atts, array('on' => 'all'));
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

function bootstrap2_hidden($atts, $content = null, $tag = '') {
	$atts = _bootstrap2_fix_atts($atts, array('on' => 'none'));
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

function bootstrap2_buttons( $atts, $content = null, $tag = '' ) {
	global $_bootstrap2_in_buttons, $_bootstrap2_button_array;

	if (!isset($_bootstrap2_button_array)) $_bootstrap2_button_array = array();

	$_bootstrap2_in_buttons = true;
	do_shortcode($content);
	$_bootstrap2_in_buttons = false;

	$content = '';
	foreach ($_bootstrap2_button_array as $button)
		$content .= $button;

	$_bootstrap2_button_array = array();  // empty global

	$class = _bootstrap2_getclass(_bootstrap2_fix_atts($atts), 'btn-group');
	return _bootstrap2_do_div($class, $content);
}

function bootstrap2_button_grp( $atts, $content = null, $tag = '' ) {
	_deprecated_function( __FUNCTION__, '0.4.2', 'bootstrap2_buttons()' );
	return bootstrap2_buttons($atts, $content, $tag);
}

function bootstrap2_button( $atts, $content = null, $tag = '' ) {
	global $_bootstrap2_in_buttons, $_bootstrap2_button_array;

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

	$element = ($atts['link'] != '') ? 'a' : 'button';
	$button = '<' . $element;
	if ($atts['link'] != '') $button .= ' href="' . $atts['link'] . '"';
	if ($atts['action'] != '') $button .= ' onclick="' . $atts['action'] . '"';
	if ($atts['id'] != '') $button .= ' id="' . $atts['id'] . '"';
	$button .= ' class="' . _bootstrap2_getclass($atts, $class) . '"';
	if ($atts['title'] != '') $button .= ' title="' . $atts['title'] . '"';
	$button .= '>' . do_shortcode($content) . '</' . $element . '>';

	if (isset($_bootstrap2_in_buttons) && $_bootstrap2_in_buttons) {
		$_bootstrap2_button_array[] = $button;
		return '';
	} else
		return $button;
}

add_shortcode( 'buttons', 'bootstrap2_buttons' );
add_shortcode( 'button_group', 'bootstrap2_button_grp' );  // deprecated
add_shortcode( 'button', 'bootstrap2_button' );


/*
 * Tabbable nav
 *
 * Uses a few globals:
 *   $_bootstrap2_in_tabs
 *   $_bootstrap2_tab_array
 *   $_bootstrap2_tabs_count
 */


function _bootstrap2_get_tabs($tabs, $fixed_outer_atts = false) {

	if (count($tabs) == 0) return '';

	if (!isset($fixed_outer_atts['id']) || !$fixed_outer_atts['id']) {
		global $_bootstrap2_tabs_count;
		if (!isset($_bootstrap2_tabs_count)) $_bootstrap2_tabs_count = 0;
		$_bootstrap2_tabs_count++;
		$tab_id = 'myTab' . $_bootstrap2_tabs_count;
	} else {
		$tab_id = $fixed_outer_atts['id'];
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

	$class = 'nav nav-tabs';
	if ($fixed_outer_atts['stacked']) $class .= ' nav-stacked';
	if ($fixed_outer_atts) $class = _bootstrap2_getclass($fixed_outer_atts, $class);

	$outer_class = 'tabbable';
	$where = false;
	if (isset($fixed_outer_atts['where'])) {
		switch (strtolower($fixed_outer_atts['where'])) {
			case 2:
			case 'right': $where = 2; break;
			case 3:
			case 'below':
			case 'bottom': $where = 3; break;
			case 4:
			case 'left': $where = 4; break;
			default: $where = 1;
		}
	} else {
		if (isset($fixed_outer_atts['top']) && $fixed_outer_atts['top']) $where = 1;
		else if (isset($fixed_outer_atts['right']) && $fixed_outer_atts['right']) $where = 2;
		else if (isset($fixed_outer_atts['below']) && $fixed_outer_atts['below']) $where = 3;
		else if (isset($fixed_outer_atts['left']) && $fixed_outer_atts['left']) $where = 4;
	}
	if ($where) {
		if ($where === 2) $outer_class .= ' tabs-right';
		else if ($where === 3) $outer_class .= ' tabs-below';
		else if ($where === 4) $outer_class .= ' tabs-left';
	}

	$out = '<div class="' . $outer_class . '">';

	// render tabs
	$out_t = '<ul class="' . $class . '" id="' . $tab_id . '">';
	foreach ($tabs as $id => $tab) {
		$id++;
		$class = '';
		if ($tab['active']) $class .= ' active';
		if ($tab['disabled']) $class .= ' disabled';
		$out_t .= '<li class="' . $class . '">';
		$out_t .= '<a href="#' . $tab_id . '_' . $id . '">';
		$out_t .= ( $tab['caption'] ? $tab['caption'] : sprintf(__('Tab %d'), $id) );
		$out_t .= '</a>';
		$out_t .= '</li>';
	}
	$out_t .= '</ul>';

	// render tab content
	$out_c = '<div class="tab-content">';
	foreach ($tabs as $id => $tab) {
		$class = 'tab-pane';
		$class .= $tab['active'] ? ' active' : '';
		if ($tab['class']) $class .= ' ' . $tab['class'];

		$out_c .= '<div class="' . $class . '" id="' . $tab_id . '_' . ($id+1) . '">';
		$out_c .= '<!-- [ -->' . $tab['content'] . '<!-- ] -->';
		$out_c .= '</div>';
	}
	$out_c .= '</div>';

	if ($where === 3) $out .= $out_c . $out_t;
	else $out .= $out_t . $out_c;

	$out .= '</div>';

	// Enable via jQuery
	$src = '(function ($) {';
	$src .= "$('#" . $tab_id . " a').click(function (e) { e.preventDefault(); $(this).tab('show'); })";
	$src .= '})(jQuery);';
	ts_enqueue_script('tabs-' . $tab_id, $src, 'jQuery');

	return $out;  /* */
}

function bootstrap2_tabs( $atts, $content = null, $tag = '' ) {
	global $_bootstrap2_in_tabs, $_bootstrap2_tab_array;

	if (!isset($_bootstrap2_tab_array)) $_bootstrap2_tab_array = array();

	$_bootstrap2_in_tabs = true;
	do_shortcode( $content );  // render inner tabs et. al.
	$_bootstrap2_in_tabs = false;

	$out = _bootstrap2_get_tabs( $_bootstrap2_tab_array,
		_bootstrap2_fix_atts($atts, array(
		    'id' => false,
		    'stacked' => false,
		    )) );

	$_bootstrap2_tab_array = array();  // empty out the global

	return $out;
}

function bootstrap2_tab_grp( $atts, $content = null, $tag = '' ) {
	_deprecated_function( __FUNCTION__, '0.4.1', 'bootstrap2_tabs()' );
	return bootstrap2_tabs($atts, $content, $tag);
}

function bootstrap2_tab( $atts, $content = null, $tag = '' ) {
	global $_bootstrap2_in_tabs, $_bootstrap2_tab_array;
	if (!isset($_bootstrap2_in_tabs) && !$_bootstrap2_in_tabs)
		return "[{$tag}]" . do_shortcode ($content) . "[/{$tag}]";

	$atts = _bootstrap2_fix_atts($atts, array('caption' => false, 'active' => false));

	// legacy
	if (!$atts['caption'] && isset($atts['title']) && !empty($atts['title'])) {
		$atts['caption'] = $atts['title'];
		unset($atts['title']);
	}

	$_bootstrap2_tab_array[] = array(
		'caption' => $atts['caption'],
		'active' => $atts['active'],
		'disabled' => (isset($atts['disabled']) && $atts['disabled']),
		'content' => shortcode_unautop( do_shortcode($content) ),
		'class' => _bootstrap2_getclass($atts),
		);

	return '';
}

add_shortcode( 'tabs', 'bootstrap2_tabs' );
add_shortcode( 'tab_group', 'bootstrap2_tab_grp' );  // depricated
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


function bootstrap2_hero( $atts, $content = null, $tag = '' ) {
	return _bootstrap2_do_div(_bootstrap2_getclass(_bootstrap2_fix_atts($atts), 'hero-unit'), $content);
}

function bootstrap2_well( $atts, $content = null, $tag = '' ) {
	$atts = _bootstrap2_fix_atts($atts, array('size' => ''));
	$class = 'well';
	if (!empty($atts['size'])) $class .= ' well-' . $atts['size'];
	return _bootstrap2_do_div(_bootstrap2_getclass($atts, $class), $content);
}

add_shortcode('hero', 'bootstrap2_hero');
add_shortcode('well', 'bootstrap2_well');


/*
 * Inline labels & Badges
 */


function bootstrap2_label( $atts, $content = null, $tag = '' ) {
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

	return '<' . $atts['container'] . ' class="' . $class . '">' . do_shortcode($content) . '</' . $atts['container'] . '>';
}

function bootstrap2_badge( $atts, $content = null, $tag = '' ) {
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
 * Alert's
 */


function bootstrap2_alert( $atts, $content = null, $tag = '' ) {
	$atts = _bootstrap2_fix_atts($atts, array(
		'type' => 'warning',  // warning, error, success, info
		'dismiss' => false,  // add dismiss button
		'block' => false,  // add more top-bottom padding for longer messages
		));
	$class = 'alert';
	switch (strtolower($atts['type'])) {
		case 'error': $class .= ' alert-error'; break;
		case 'success': $class .= ' alert-success'; break;
		case 'info': $class .= ' alert-info'; break;
		default: ;  // is warining
	}
	if ($atts['dismiss']) $content = '<button type="button" class="close"' .
		' data-dismiss="alert">&times;</button>' . $content;
	if ($atts['block']) $class .= ' alert-block';

	return _bootstrap2_do_div(_bootstrap2_getclass($atts, $class), $content);
}

add_shortcode('alert', 'bootstrap2_alert');


/** Enable shortcodes in Widget */
add_filter('widget_text', 'do_shortcode');
// add_filter( 'the_excerpt', 'do_shortcode');


/* eof */
