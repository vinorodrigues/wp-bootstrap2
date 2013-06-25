<?php
/**
 * RSS Feed styling
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.3.6
 * @see http://codex.wordpress.org/Customizing_Feeds
 */

function bootstrap2_do_feed_rss2( $for_comments ) {
	if ( $for_comments )
		load_template( get_template_directory() . '/feed-rss2-comments.php' );
	else
		load_template( get_template_directory() . '/feed-rss2.php' );
}

remove_filter('do_feed_rss2', 'do_feed_rss2');
add_filter('do_feed_rss2', 'bootstrap2_do_feed_rss2', 10, 1);

?>
