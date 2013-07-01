<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
?>
<!-- archive -->

<?php tha_content_before(); ?>
<div id="content" role="main">
	<?php tha_content_top(); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
					if ( is_category() ) {
						printf( __( '<span class="category-archive">%s</span>', 'bootstrap2' ), single_cat_title( '', false ) );

					} elseif ( is_tag() ) {
						printf( __( '<span class="tag-archive">%s</span>', 'bootstrap2' ), single_tag_title( '', false ) );

					} elseif ( is_author() ) {
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						*/
						the_post();
						printf( __( '<span class="vcard author-archive">%s</span>', 'bootstrap2' ), '<a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>' );
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();

					} elseif ( is_day() ) {
						printf( __( '<span class="daily-archive date-archive">%s</span>', 'bootstrap2' ), get_the_date() );

					} elseif ( is_month() ) {
						printf( __( '<span class="monthly-archive date-archive">%s</span>', 'bootstrap2' ), get_the_date( 'F Y' ) );

					} elseif ( is_year() ) {
						printf( __( '<span class="yearly-archive date-archive">%s</span>', 'bootstrap2' ), get_the_date( 'Y' ) );

					} else {
						_e( 'Archives', 'bootstrap2' );

					}
				?>
			</h1>
			<?php
				if ( is_category() ) {
					// show an optional category description
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

				} elseif ( is_tag() ) {
					// show an optional tag description
					$tag_description = tag_description();
					if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
				}
			?>
		</header>

		<?php /* rewind_posts(); */ ?>

		<?php bootstrap2_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php tha_entry_before(); ?>

			<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to overload this in a child theme then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'part/content', get_post_format() );
			?>

			<?php tha_entry_after(); ?>
			<?php
				if ($wp_query->post_count !== ($wp_query->current_post + 1))
					echo '<hr class="soft" />';
			?>
		<?php endwhile; ?>

		<?php bootstrap2_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<?php get_template_part( 'part/no-results', 'archive' ); ?>

	<?php endif; ?>

	<?php tha_content_bottom(); ?>
</div>
<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
