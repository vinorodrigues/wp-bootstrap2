<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * The theme should work with or without these tweaks
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

 
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function bootstrap2_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bootstrap2_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 */
function bootstrap2_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'bootstrap2_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function bootstrap2_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'bootstrap2_enhanced_image_navigation', 10, 2 );


/**
 *
 * @param type $link
 * @param type $icon
 * @param string $btn
 * @return type
 */
function bootstrap2_x_x_link( $link, $icon, $btn = '' ) {
	if (!empty($btn)) $btn .= ' ';
	return str_replace(array('<a class="', '">'), array('<a class="btn btn-mini '. $btn, '"><i class="' . $icon . '"></i> '), $link);
}


/**
 *
 * @param type $link
 * @return type
 */
function bootstrap2_edit_x_link( $link ) {
	return bootstrap2_x_x_link( $link, 'icon-edit icon-white', 'btn-warning' );
}
add_filter( 'edit_comment_link', 'bootstrap2_edit_x_link' );
add_filter( 'edit_post_link', 'bootstrap2_edit_x_link' );


/**
 *
 * @param type $link
 * @return type
 */
function bootstrap2_delete_comment_link( $link ) {
	return bootstrap2_x_x_link( $link, 'icon-trash icon-white', 'btn-danger' );
}
add_filter( 'delete_comment_link', 'bootstrap2_delete_comment_link' );

/**
 *
 * @param type $link
 * @return type
 */
function bootstrap2_spam_comment_link( $link ) {
	return bootstrap2_x_x_link( $link, 'icon-bell icon-white', 'btn-danger' );
}
add_filter( 'spam_comment_link', 'bootstrap2_spam_comment_link' );



/**
 *
 */
function bootstrap2_post_comments_feed_link_html( $html ) {
	return str_replace(
		array("<a href='", "'>"),
		array("<a title='" . __('Subscribe to Comments via RSS', 'bootstrap2') . "' class='btn btn-mini btn-info' href='", "'><i class='icon-rss-white'></i> "),
		$html);
}
add_filter( 'post_comments_feed_link_html', 'bootstrap2_post_comments_feed_link_html' );



/**
 *
 * @param type $link
 * @return type
 */
function bootstrap2_comment_reply_link( $link ) {
	return str_replace(
		array("a class='", 'a class="' ),
		array("a class='btn btn-mini btn-info ", 'a class="btn btn-mini btn-info '),
		$link);
}
add_filter( 'comment_reply_link', 'bootstrap2_comment_reply_link' );


/**
 *
 */
function bootstrap2_check_comment_flood() {
	if ( ! wp_get_referer() ) {
		wp_die( __('You cannot post comment at this time, may be you need to enable referrers in your browser.'), 'bootstrap2' );
	}
}
add_action('check_comment_flood', 'bootstrap2_check_comment_flood');

function bootstrap2_the_tags( $output ) {
	return str_replace(array('<a href="', '">'), array('<a class="btn btn-mini btn-inverse" href="', '"><i class="icon-tag icon-white"></i> '), $output);;
}
add_filter( 'the_tags', 'bootstrap2_the_tags' );


/**
 *
 * @param type $output
 * @return type
 */
function bootstrap2_the_category( $output ) {
	return str_replace(array('<a href="', '">'), array('<a class="btn btn-mini btn-success" href="', '"><i class="icon-filter icon-white"></i> '), $output);
}
add_filter( 'the_category', 'bootstrap2_the_category' );


/**
 *
 */
function bootstrap2_the_content_more_link( $output ) {
	return str_replace(array('<a href="', '...</a>'), array('<a class="btn btn-mini" href="', ' <i class="icon-play-circle"></i></a>'), $output);
}
add_filter( 'the_content_more_link', 'bootstrap2_the_content_more_link' );


/* eof */
