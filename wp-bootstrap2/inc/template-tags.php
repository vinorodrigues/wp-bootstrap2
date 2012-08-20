<?php
/**
 * Custom template tags for this theme.
 *
 * These are mostly filters that modify the default behavior of the theme and
 * are required for the theme to function correctly.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

 
if ( ! function_exists( 'bootstrap2_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation pager ';
	if ( is_single() ) {
		$nav_class .= 'post-navigation';
	} else {
		$nav_class .= 'paging-navigation';
	}

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<span class="assistive-text"><?php _e( 'Navigation', 'bootstrap2' ); ?></span>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="icon-chevron-left"></i>', 'Previous post link', 'bootstrap2' ) . ' %title' ); ?>
		<?php next_post_link( '<span class="nav-next">%link</span>', '%title ' . _x( '<i class="icon-chevron-right"></i>', 'Next post link', 'bootstrap2' ) ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<i class="icon-chevron-left"></i> Older posts', 'bootstrap2' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <i class="icon-chevron-right"></i>', 'bootstrap2' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // bootstrap2_content_nav


/* NOT WORKING
if ( ! function_exists( 'get_x_comment_link' ) ) :
/**
 *
 */
/* function get_x_comment_link( $action, $comment_id = 0 ) {
	$comment = &get_comment( $comment_id );

	if ( !current_user_can( 'edit_comment', $comment->comment_ID ) )
		return;

	$location = admin_url('comment.php?action='.$action.'comment&amp;c=') . $comment->comment_ID;
	return apply_filters( 'get_edit_comment_link', $location );
}
endif; */


/* NOT WORKING
if ( ! function_exists( 'bootstrap2_delete_comment_link' ) ) :
/**
 *
 */
/* function bootstrap2_delete_and_spam_comment_link( $del_link = null, $spam_link = null, $before = '', $after = '' ) {
	global $comment;

	if ( !current_user_can( 'edit_comment', $comment->comment_ID ) )
		return;

	if ( null === $del_link )
		$del_link = __('Delete This', 'bootstrap2');
	if ( null === $spam_link )
		$del_link = __('Mark as Spam', 'bootstrap2');

	$del_link = '<a class="comment-edit-link" href="' . get_x_comment_link( 'trash', $comment->comment_ID ) . '" title="' . esc_attr__( 'Delete comment' ) . '">' . $del_link . '</a>';
	$spam_link = '<a class="comment-edit-link" href="' . get_x_comment_link( 'spam', $comment->comment_ID ) . '" title="' . esc_attr__( 'Mark comment as spam' ) . '">' . $spam_link . '</a>';

	echo $before . apply_filters( 'delete_comment_link', $del_link, $comment->comment_ID ) . $after;
	echo $before . apply_filters( 'spam_comment_link', $spam_link, $comment->comment_ID ) . $after;
}
endif; */


if ( ! function_exists( 'bootstrap2_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'bootstrap2' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'bootstrap2' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'bootstrap2' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="label label-warning"><?php _e( 'Your comment is awaiting moderation.', 'bootstrap2' ); ?></span>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><i class="icon-calendar"></i> <time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'bootstrap2' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
				</div>
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
					'reply_text' => __( '<i class="icon-comment icon-white"></i> Reply', 'bootstrap2'),
				) ) ); ?>
				<?php
					edit_comment_link( __( 'Edit', 'bootstrap2' ), ' ' );
					/* bootstrap2_delete_and_spam_comment_link( __( 'Trash', 'bootstrap2' ),  __( 'Spam', 'bootstrap2' ), ' ' ); */
				?>
			</div>
		</article>

	<?php
			break;
	endswitch;
}
endif; // ends check for bootstrap2_comment()


if ( ! function_exists( 'bootstrap2_posted_on' ) ) :
function bootstrap2_get_avatar( $avatar ) {
	return str_replace("class='", "class='icon--avatar ", $avatar);
}
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_posted_on() {
	global $authordata;

	if ( get_option('show_avatars') && is_object($authordata) ) {
		add_filter( 'get_avatar', 'bootstrap2_get_avatar' );
		$avatar = get_avatar( $authordata->ID, 14 );
		remove_filter( 'get_avatar', 'bootstrap2_get_avatar' );
	} else
		$avatar = '<i class="icon-user"></i>';
	printf( __( '<i class="icon-calendar"></i> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> %8$s <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'bootstrap2' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'bootstrap2' ), get_the_author() ) ),
		esc_html( get_the_author() ),
		$avatar
	);
}
endif;


if ( ! function_exists('bootstrap2_link_pages') ) :
/**
 * The formatted output of a list of pages.
 *
 * Displays page links for paginated posts (i.e. includes the <!--nextpage-->
 * quicktag one or more times).
 *
 * @see  wp_link_pages()

*/
function bootstrap2_link_pages($args = '') {
	$defaults = array(
		'before' => '<div class="pagination"><ul>',
		'after' => '</ul></div>',
		'item_before' => '<li class="%">',
		'item_after' => '</li>',
		'item_class' => '',
		'item_class_active' => 'active',
		'link_before' => '',
		'link_after' => '',
		'next_or_number' => 'number',
		'nextpagelink' => __('Next page'),
		'previouspagelink' => __('Previous page'),
		'pagelink' => '%',
		'echo' => 1,
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
				$j = str_replace('%', $i, $pagelink);
				$output .= str_replace('%', ( ($i == $page) ? $item_class_active : $item_class ), $item_before);
				if ( $i != $page ) {
					$output .= _wp_link_page($i);
				} else {
					$output .= '<a href="#">';
				}
				$output .= $link_before . $j . $link_after;
				$output .= '</a>';
				$output .= $item_after;
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= str_replace('%', $item_class, $item_before) . _wp_link_page($i);
					$output .= $link_before. $previouspagelink . $link_after . '</a>' . $item_after;
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= str_replace('%', $item_class, $item_before) . _wp_link_page($i);
					$output .= $link_before. $nextpagelink . $link_after . '</a>' . $item_after;
				}
				$output .= $after;
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}
endif;


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so bootstrap2_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so bootstrap2_categorized_blog should return false
		return false;
	}
}


/**
 * Flush out the transients used in bootstrap2_categorized_blog
 *
 * @since Bootstrap2 1.0
 */
function bootstrap2_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'bootstrap2_category_transient_flusher' );
add_action( 'save_post', 'bootstrap2_category_transient_flusher' );


if (! function_exists('bootstrap2_column_class')) :
/**
 * Gets the class name for the content or sidebar
 * @param boolean $content
 * @param boolean $echo
 */
function bootstrap2_column_class($content = true, $echo = true) {
	$sidebars = bootstrap2_get_theme_option_sidebars();
	if ($sidebars == 'c') {
		// content only
		$output = 12;
	} else {
		$wide = in_array($sidebars, array('sc','cs'));

		if ($content) {
			if ($wide) {
				$output = 9;
			} else {
				$output = 6;
			}
		} else {
			if ($wide) {
				$output = 3;
			} else {
				$output = 3;
			}
		}
	}

	if ($echo) { echo $output; } else { return $output; }
}
endif;


if ( ! function_exists( 'bootstrap2_navbar_searchform' ) ) :
/**
 *
 * @param bool $echo
 * @return string
 */
function bootstrap2_navbar_searchform( $echo = true ) {
	$output = '<div class="nav-collapse"><form id="searchform" class="navbar-search form-search pull-right" method="get" action="' . esc_url( home_url( '/' ) ) . '">
	<label for="s"><span class="add-on assistive-text hidden">' . __( 'Search', 'the-bootstrap' ) . '</span><input type="search" results="5" class="search-query input-medium" name="s" id="s" placeholder="' . esc_attr( 'Search &hellip;', 'bootstrap2' ) . '" /></label>
</form></div>';

	if ( $echo ) { echo $output; } else { return $output; }
}
endif;

/* eof */
