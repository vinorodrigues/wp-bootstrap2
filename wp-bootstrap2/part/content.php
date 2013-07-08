<?php
/**
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */

$_class = '';
if ( is_sticky() ) {
	$_uw = bootstrap2_get_theme_option('well_s', $_class);
	if ('no-well' == $_uw) $_class .= $_uw . ' ';
}
if (is_singular()) $_class .= 'item-singular ';
if (isset($wp_query)) {
	$_class .= 'item-' . ($wp_query->current_post + 1) . ' ';
	if ($wp_query->current_post == 0) $_class .= 'first ';
	if ($wp_query->post_count == ($wp_query->current_post + 1)) $_class .= 'last ';
}
$_h = (is_singular() ? 'h1' : 'h2');
if ( has_post_format( 'aside' )) $_h = 'b';
?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class( rtrim($_class, ' ') ); ?>>
	<header class="entry-header">
		<<?php echo $_h; ?> class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bootstrap2' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></<?php echo $_h; ?>>

		<?php if ( 'post' == get_post_type() && !has_post_format( 'aside' ) ) : ?>
		<div class="entry-meta">
			<?php bootstrap2_posted_on(); ?>
		</div>
		<?php endif; ?>
	</header>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
	<?php if (has_post_thumbnail()) : ?>
		<div class="media"><a class="post-thumbnail pull-right" href="<?php the_permalink(); ?>"><?php
		the_post_thumbnail( 'post-thumbnail', array(
			'class' => 'media-object',
			) ); ?>
		</a><div class="media-body">
	<?php endif; ?>
	<?php the_content( __( '(more&hellip;)' ) ); ?>
	<?php if (has_post_thumbnail()) : ?>
	</div></div>
	<?php endif; ?>
	<?php bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') ); ?>
	</div>
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( ' ' );
				if ( $categories_list && bootstrap2_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php echo $categories_list; ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', ' ', ' ' );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php echo $tags_list; ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link(
			'<i class="icon-comment icon-white"></i> ' . __( 'Leave a comment', 'bootstrap2' ),
			'<i class="icon-comment icon-white"></i> ' . __( '1 Comment', 'bootstrap2' ),
			'<i class="icon-comment icon-white"></i> ' . __( '% Comments', 'bootstrap2' ),
			'btn btn-mini btn-info' ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
