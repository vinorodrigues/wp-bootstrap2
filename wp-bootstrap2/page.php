<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
get_top_sidebar();
?>
<!-- page -->
<div id="primary" class="site-content span<?php bootstrap2_column_class(); ?>">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php tha_entry_before(); ?>

			<?php get_template_part( 'part/content', 'page' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '/part/comments.php', true );
			?>

			<?php tha_entry_after(); ?>
		<?php endwhile; // end of the loop. ?>

		<?php tha_content_bottom(); ?>
	</div>
	<?php tha_content_after(); ?>
</div>

<?php
get_bottom_sidebar();
get_footer(); ?>
