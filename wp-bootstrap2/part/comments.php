<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to bootstrap2_comment() which is
 * located in the functions.php file.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */

/**
 * Custom comment form
 */
include( '../inc/comment-form.php' );


if ( !function_exists( 'bootstrap2_comment_nav' ) ) :
function bootstrap2_comment_nav( ) {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
		<span class="assistive-text"><?php _e( 'Comment navigation', 'bootstrap2' ); ?></span>
		<ul class="pager">
			<li class="nav-previous"><?php previous_comments_link( __( '<i class="icon-hand-left"></i> Older Comments', 'bootstrap2' ) ); ?></li>
			<li class="nav-next"><?php next_comments_link( __( 'Newer Comments <i class="icon-hand-right"></i>', 'bootstrap2' ) ); ?></li>
		<ul>
	</nav>
	<?php
	endif; // check for comment navigation 
}
endif;

?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'bootstrap2' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
			<?php  post_comments_feed_link( __( 'RSS', 'bootstrap2' ) ); ?>
		</h3>

		<?php bootstrap2_comment_nav(); ?>

		<ul class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use bootstrap2_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define bootstrap2_comment() and that will be used instead.
				 * See bootstrap2_comment() in functions.php for more.
				 */
				wp_list_comments( array(
				    'callback' => 'bootstrap2_comment',
				    'style' => 'ul',
				    'avatar_size' => 14,
				) );
			?>
		</ul>

		<?php bootstrap2_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'bootstrap2' ); ?></p>
	<?php endif; ?>

	<?php bootstrap2_comment_form(); ?>

</div><!-- #comments .comments-area -->
