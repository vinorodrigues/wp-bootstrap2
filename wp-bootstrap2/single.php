<?php
/**
 * The Template for displaying all single posts.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
get_top_sidebar();
?>

<div id="primary" class="site-content <?php bootstrap2_column_class(); ?>">
	<div id="content" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php /* bootstrap2_content_nav( 'nav-above' ); */ ?>

		<?php get_template_part( 'part/content', 'single' ); ?>

		<?php bootstrap2_content_nav( 'nav-below' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template( '/part/comments.php', true );
		?>

	<?php endwhile; // end of the loop. ?>

	</div>
</div>

<?php
get_bottom_sidebar();
get_footer();
