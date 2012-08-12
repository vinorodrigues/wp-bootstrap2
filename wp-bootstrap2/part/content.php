<?php
/**
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( (is_sticky() && bootstrap2_get_theme_option('well_s', true)) ? 'well' : '' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bootstrap2' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
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
		<?php the_content( __( 'more...', 'bootstrap2' ) ); ?>
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
