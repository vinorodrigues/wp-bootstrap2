<?php
/**
 * The template for displaying image attachments.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
?>
<!-- image -->
<?php tha_content_before(); ?>
<div id="content" role="main" class="image-attachment">
	<?php tha_content_top(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php tha_entry_before(); ?>

		<?php $can_comment = ( ! bootstrap2_get_theme_option('inhibit_image_comments') ) && ( comments_open() || '0' != get_comments_number() ); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header page-header">
				<?php /* <h1 class="entry-title"><?php the_title(); ?></h1> */ ?>

				<div class="entry-meta">
					<?php
						$metadata = wp_get_attachment_metadata();
						printf( __( '<span class="entry-date"><i class="icon-calendar"></i> <time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span> at <b>%4$s&times;%5$s</b> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'bootstrap2' ),
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							wp_get_attachment_url(),
							$metadata['width'],
							$metadata['height'],
							get_permalink( $post->post_parent ),
							get_the_title( $post->post_parent )
						);
					?>
				</div>

			</header>

			<?php /*
			<nav role="navigation" id="nav-above" class="image-navigation pager">
				<span class="assistive-text"><?php _e( 'Navigation', 'bootstrap2' ); ?></span>
				<span class="nav-previous previous-image"><?php previous_image_link( false, __( '<i class="icon-backward"></i> Previous', 'bootstrap2' ) ); ?></span>
				<span class="nav-space"><?php _ex( '<i class="icon-stop"></i>', 'Image separator', 'bootstrap2' ); ?></span>
				<span class="nav-next next-image"><?php next_image_link( false, __( 'Next <i class="icon-forward"></i>', 'bootstrap2' ) ); ?></span>
			</nav>
			*/ ?>

			<div class="entry-content">

				<div class="entry-attachment row-fluid">
					<figure class="attachment span12">
							<?php
							echo '<a href="' . wp_get_attachment_url() . '" rel="attachment" class="thumbnail">';
							$id = $post->ID;
							$size = apply_filters( 'bootstrap2_attachment_size', 'size-full' ); // Filterable image size.
							$sizeclass = is_array($size) ? join('x', $size) : $size;
							echo wp_get_attachment_image( $id, $size, false, array(
								'class' => "{$sizeclass} wp-image-{$id} attachment-image aligncenter",
							) );
							echo '</a>';
						?>
						<figcaption class="entry-caption">
							<?php
								if ( empty( $post->post_excerpt ) ) :
									echo esc_attr( get_the_title() );
								else:
									the_excerpt();
								endif;
							?>
						</figcaption>
					</figure>
				</div>

				<div class="attachment-description"><?php the_content(); ?></div>
				<?php bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') ); ?>
			</div>

			<footer class="entry-meta">
				<?php if ( $can_comment ) : ?>
					<a class="comment-link btn btn-mini btn-info" href="#respond" title="<?php _e( 'Post a comment', 'bootstrap2' ); ?>"><i class="icon-comment icon-white"></i> <?php _e( 'Comment', 'bootstrap2' ); ?></a>
				<?php endif; ?>
				<?php /* if ( pings_open() ) : ?>
						<a class="trackback-link btn btn-mini" href="<?php echo get_trackback_url(); ?>" title="<?php _e( 'Trackback URL', 'bootstrap2' ); ?>" rel="trackback"><i class="icon-bookmark"></i> <?php _e( 'Trackback', 'bootstrap2' ); ?></a>
					<?php endif; */ ?>
				<?php edit_post_link( __( 'Edit', 'bootstrap2' ), ' <span class="edit-link">', '</span>' ); ?>
			</footer>
		</article>

		<?php if ( $can_comment ) comments_template( '/part/comments.php', true ); ?>

		<?php tha_entry_after(); ?>

	<?php endwhile; // end of the loop. ?>

	<?php tha_content_bottom(); ?>
</div>
<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
