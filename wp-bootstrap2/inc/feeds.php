<?php

/* function bootstrap2_the_content_feed($content) {
  global $post;
  if ( has_post_thumbnail( $post->ID ) ) {
    $content = '<span class="post-thumbnail">' . get_the_post_thumbnail( $post->ID, 'post-thumbnail' ) . '</span>' . $content;
  }
  return $content;
}

add_filter('the_excerpt_rss', 'bootstrap2_the_content_feed');
add_filter('the_content_feed', 'bootstrap2_the_content_feed');  /*  */

// TODO : Feed image, see http://snook.ca/archives/rss/add_logo_to_feed/
// or use: http://terriswallow.com/weblog/2007/feed-image-wordpress-plugin/

function bootstrap2_do_feed_rss2( $for_comments ) {
  // Based on code at http://codex.wordpress.org/Customizing_Feeds
	if ( $for_comments )
		load_template( get_template_directory() . '/feed-rss2-comments.php' );
	else
		load_template( get_template_directory() . '/feed-rss2.php' );
}

remove_filter('do_feed_rss2', 'do_feed_rss2');
add_filter('do_feed_rss2', 'bootstrap2_do_feed_rss2', 10, 1);

?>
