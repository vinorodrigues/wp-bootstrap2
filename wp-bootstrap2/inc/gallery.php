<?php
/**
 * Gallery Shortcode
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.4.1
 * @see http://wordpress.stackexchange.com/questions/4343/how-to-customise-the-output-of-the-wp-image-gallery-shortcode-from-a-plugin
 */

/** Gallery filter */
function bootstrap2_gallery_flt( $output, $attr ) {

	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(_bootstrap2_fix_atts($attr, array(
		'order'    => 'ASC',
		'orderby'  => 'menu_order ID',
		'id'       => $post ? $post->ID : 0,
		'columns'  => 3,  // don't change this or 3 will get ignored
		'size'     => 'thumbnail',
		'include'  => '',
		'exclude'  => '',
		'wait'     => 100,  // for equal-heights
		'interval' => 10000,  // for carousel
		'singular' => false,
		)));

	if ($singular === false) $singular = is_singular();
	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	// fix columns so that minimum span = 2
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(12 / $columns) : 12;
	if ($itemwidth < 2) $itemwidth = 2;
	$columns = floor(12 / $itemwidth);

	$output .= '<div id="gallery-' . $instance .
		'" class="gallery galleryid-' . $id . ' gallery-columns-' .
		$columns . ' gallery-size-' . sanitize_html_class($size) . '">';

	if ($singular) {
		$_begin = '<div class="row-fluid row-%2$d"><ul class="thumbnails">';
		$_end = '</ul></div>';
		$_tag = 'li';
	} else {

		$output .= '<div id="gallery-carousel-' . $instance . '" class="carousel slide gallery-carousel">';
		$r = ceil(count($attachments) / $columns);
		if ($r > 1) {
			$output .= '<ol class="carousel-indicators">';
			for ($i = 0; $i < $r; $i++) {
				$output .= '<li data-target="#gallery-carousel-' .
					$instance . '" data-slide-to="' . $i . '"';
				if ($i == 0) $output .= ' class="active"';
				$output .= '></li>';
			}
			$output .= '</ol>';
		}
		$output .= '<div class="carousel-inner">';

		$_begin = '<div class="item %4$s"><div class="row-fluid row-%2$d slidethumbs">';  // not .thumbnails !

		$_end = '</div></div>';
		$_tag = 'div';
	}

	$i = 0;  // items
	$r = 1;  // rows
	$c = 1;  // cols
	foreach ( $attachments as $id => $attachment ) {

		if ($i === 0) $output .= sprintf($_begin, $instance, $r, $c, ($singular ? '' : 'active'));

		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = (( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape') . ' ';

		$output .= '<' . $_tag . ' class="span' . $itemwidth;
		if ($c == 1) $output .= ' first';
		if ($c == $columns) $output .= ' last';
		$output .= '">';
		$output .= '<div class="thumbnail ' . $orientation .
			'gal-' . $instance . '">';

		$output .= $link;

		if ($link) $output .= '</a>';

		if ( $singular && trim($attachment->post_excerpt) ) {
			$output .= '<div class="caption wp-caption-text gallery-caption">';
			$output .= wptexturize($attachment->post_excerpt);
			$output .= '</div>';
		}

		$output .= '</div></' . $_tag . '>';

		if ( ($columns > 0) && (++$i % $columns == 0) )
			if ($i < count($attachments)) {
				$output .= $_end . sprintf($_begin, $instance, $r, $c, '');
				++$r;
				$c = 0;
			}
		++$c;
	}

	$output .= $_end;

	if (!$singular) {
		$output .= '</div>';  // .carousel-inner

		if ($r > 1) {
			$output .= '<a class="left carousel-control" href="#gallery-carousel-' .
				$instance . '" data-slide="prev">‹</a>';
			$output .= '<a class="right carousel-control" href="#gallery-carousel-' .
				$instance . '" data-slide="next">›</a>';
		}

		$output .= '</div>';  // .carousel .slide
	}
	
	$output .= '</div>';  // .gallery

	if ($singular) {
		// ts_equal_heights('.gal-' . $instance, $wait);  // causes flicker
	} else if ($r > 1) {
		$scr = 'jQuery(document).ready(function(){jQuery(\'#gallery-carousel-' .
			$instance . '\').carousel({';
		if ($interval) $scr .= 'interval:' . $interval;
		$scr .= '});});';
		ts_enqueue_script('gallery-carousel-' . $instance, $scr, 'jQuery');
	}
	return $output;
}

add_filter( 'post_gallery', 'bootstrap2_gallery_flt', 10, 2 );

/** Gallery shortcode */
function bootstrap2_gallery($attr) {
	return bootstrap2_gallery_flt('', $attr);
}

if (!function_exists('shortcode_exists')) :
	function shortcode_exists( $tag ) {
		global $shortcode_tags;
		return array_key_exists( $tag, $shortcode_tags );
	}
endif;
// if (shortcode_exists( 'gallery' )) remove_shortcode( 'gallery' );  /** not needed as filter does all the work */
if (!shortcode_exists( 'gallery' )) add_shortcode( 'gallery', 'bootstrap2_gallery' );


/** Get list of images in this post */
function bootstrap2_get_gallery_images($post_id = 0) {
	$images = array();
	if ($post_id === 0) $post_id = get_the_ID();

	// issolate gallery shortcode images
	if ( function_exists( 'get_post_galleries' ) ) {  // new in WP3.6
		$galleries = get_post_galleries($post_id, false );
		for ($i = 0; $i < count($galleries); $i++)
			if ( isset( $galleries[$i]['ids'] ) )
				$images = array_merge($images,
					explode( ',', $galleries[0]['ids'] ) );
	} else {  // get only the first gallery shortcode
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		if (isset($match[3])) {
			$atts = shortcode_parse_atts( $match[3] );
			if ( isset( $atts['ids'] ) )
				$images = explode( ',', $atts['ids'] );
		}
	}

	// No gallery shortcode, so get post images
	if ( ! $images ) {
		$images = get_posts( array(
			'post_parent'    => $post_id,
			'post_type'      => 'attachment',
			'fields'         => 'ids',
			'numberposts'    => 999,
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_mime_type' => 'image',
			) );
	}

	return $images;
}

/* eof */
