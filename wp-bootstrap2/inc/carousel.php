<?php
/**
 * Sortcodes for Bootstrap Carousel
 * @see: http://twitter.github.io/bootstrap/javascript.html#carousel
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.4
 */


function _bootstrap2_get_carousel($carousel, $captions, $fixed_atts = false, $cgroup = false) {
	if ((count($carousel) == 0)) return '';
	if (!$cgroup) {
		global $_bootstrap2_carousel_count;
		if (!isset($_bootstrap2_carousel_count)) $_bootstrap2_carousel_count = 0;
		$_bootstrap2_carousel_count++;
		$cgroup = 'carousel' . $_bootstrap2_carousel_count;
	}

	// find active tab
	$fndactive = false;
	foreach ($carousel as $item) {
		if ($item['active']) {
			$fndactive = true;
			break;
		}
	}
	if (!$fndactive) {
		// set first one as active
		reset($carousel);
		$carousel[key($carousel)]['active'] = true;
	}

	$class = 'carousel slide';
	if ($fixed_atts) $class = _bootstrap2_getclass($fixed_atts, $class);

	$out = '<div id="' . $cgroup . '" class="' . $class;
	// if ($fixed_atts['interval']) $out .= '" data-interval="' . $fixed_atts['interval'];  // ??? not working
	$out .= '">';

	// Carousel indicators (dots)
	$out .= '<ol class="carousel-indicators">';
	$key = 0;
	foreach ($carousel as $item) {
		$out .= '<li data-target="#' . $cgroup . '" data-slide-to="' .
			$key . '"' . ($item['active'] ? ' class="active"' : '') . '></li>';
		$key++;
	}
	$out .= '</ol>';
	
	// Carousel items
	$out .= '<div class="carousel-inner">';
	foreach ($carousel as $key => $item) {
		$out .= '<div class="item';
		if ($item['active']) $out .= ' active';
		if (!empty($item['class'])) $out .= ' ' . $item['class'];
		if (isset($item['id'])) $out .= '" id="' . $item['id'];
		$out .= '">';
		if (isset($captions[$key])) {
			$out .= '<div class="carousel-caption"';
			if (!empty($captions[$key]['class']))
				$out .= ' class="' . $captions[$key]['class'] . '"';
			$out .= '">';
			$out .= $captions[$key]['content'];
			$out .= '</div>';
		}
		$out .= $item['content'];
		$out .= '</div>';
	}
	$out .= '</div>';

	// Carousel nav
	$out .= '<a class="carousel-control left" href="#' . $cgroup . '" data-slide="prev">&lsaquo;</a>';
	$out .= '<a class="carousel-control right" href="#' . $cgroup . '" data-slide="next">&rsaquo;</a>';

	$out .= '</div>';

	// fix for carousel not starting
	$scr = 'jQuery(document).ready(function(){jQuery(\'#' .
		$cgroup . '\').carousel({';
	if ($fixed_atts['interval']) $scr .= 'interval:' . $fixed_atts['interval'];
	$scr .= '});});';
	ts_enqueue_script('carousel-' . $cgroup, $scr, 'jQuery');

	return $out;
}

function bootstrap2_carousel( $atts, $content = NULL, $tag = '' ) {
	global $_bootstrap2_in_carousel, $_bootstrap2_carousel_items, $_bootstrap2_carousel_caps;
	if (!isset($_bootstrap2_carousel_items)) $_bootstrap2_carousel_items = array();
	if (!isset($_bootstrap2_carousel_caps)) $_bootstrap2_carousel_caps = array();

	$_bootstrap2_in_carousel = true;
	do_shortcode( $content );  // render inner carousel et. al.
	$_bootstrap2_in_carousel = false;

	$atts = _bootstrap2_fix_atts($atts, array(
	    'id' => false,
	    'interval' => false,
	    ));
	$out = _bootstrap2_get_carousel(
		$_bootstrap2_carousel_items,
		$_bootstrap2_carousel_caps,
		$atts, $atts['id']);

	$_bootstrap2_carousel_items = array();
	$_bootstrap2_carousel_caps = array();
	return $out;
}

function bootstrap2_carousel_item( $atts, $content = NULL, $tag = '' ) {
	global $_bootstrap2_in_carousel, $_bootstrap2_carousel_items;
	if (!isset($_bootstrap2_in_carousel) || !$_bootstrap2_in_carousel)
		return "[{$tag}]" . do_shortcode( $content ) . "[/{$tag}]";

	$atts = _bootstrap2_fix_atts($atts, array('active' => false, 'id' => false));

	$item = array(
		'active' => $atts['active'],
		'content' => $content,
		'class' => _bootstrap2_getclass($atts),
		);
	if (isset($atts['id']) && ($atts['id'] !== false)) {
		$item['id'] = $atts['id'];
		$_bootstrap2_carousel_items[$atts['id']] = $item;
	} else
		$_bootstrap2_carousel_items[] = $item;

	return '';
}

function bootstrap2_carousel_caption( $atts, $content = NULL, $tag = '' ) {
	global $_bootstrap2_in_carousel, $_bootstrap2_carousel_caps;

	// if not in a carousel then call WP's caption shortcode
	if (!isset($_bootstrap2_in_carousel) || !$_bootstrap2_in_carousel) {
		/* if (function_exists('img_caption_shortcode'))
			return img_caption_shortcode($atts, $content);
		else  */ // redundant code
			return "[{$tag}]" . do_shortcode( $content ) . "[/{$tag}]";
	}

	$atts = _bootstrap2_fix_atts($atts);

	$item = array(
		'content' => $content,
		'class' => _bootstrap2_getclass($atts),
		);
	if (isset($atts['id'])) {
		$item['id'] = $atts['id'];
		$_bootstrap2_carousel_caps[$atts['id']] = $item;
	} else
		$_bootstrap2_carousel_caps[] = $item;

	return '';
}

/** @see http://joostkiens.com/improving-wp-caption-shortcode/ */
function bootstrap2_img_caption_shortcode( $output, $atts, $content = '' ) {
	global $_bootstrap2_in_carousel;
	if (isset($_bootstrap2_in_carousel) && $_bootstrap2_in_carousel)
		return bootstrap2_carousel_caption( $atts, $content, 'caption' );

	 extract( _bootstrap2_fix_atts($atts, array(
		'id' => '',
		'align' => 'aligncenter',
		'width' => '100%',
		'caption' => '',
		'class' => false,
		) ) );

	// No caption, no go, but why do you have a width?
	if ( 1 > (int) $width || empty($caption) )
		return $output;

	if ( $id ) $id = esc_attr( $id );
	if (!empty($class)) $class .= ' ';
	$class .= $align;
	$class = _bootstrap2_getclass($atts, $class);

	$output = '<figure id="' . $id . '" class="wp-caption ' . $class . '" style="width: ' . (0 + (int) $width) . 'px">';
	$output .= do_shortcode( $content );
	$output .= '<figcaption class="wp-caption-text" itemprop="description">' . $caption . '</figcaption>';
	$output .= '</figure>';

	return $output;
}

add_shortcode( 'carousel', 'bootstrap2_carousel' );
add_shortcode( 'item', 'bootstrap2_carousel_item' );
if (function_exists('img_caption_shortcode'))
	add_filter( 'img_caption_shortcode', 'bootstrap2_img_caption_shortcode', 10, 3 );
else add_shortcode( 'caption', 'bootstrap2_carousel_caption' );

/* eof */
