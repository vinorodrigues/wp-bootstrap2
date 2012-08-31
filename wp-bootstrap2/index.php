<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
get_top_sidebar();
?>
<!-- index -->
<div id="primary" class="site-content span<?php bootstrap2_column_class(); ?>">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>

		<?php if ( have_posts() ) : ?>

			<?php /*bootstrap2_content_nav( 'nav-above' );*/ ?>

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
			<?php endwhile; ?>

			<?php bootstrap2_content_nav( 'nav-below' ); ?>

		<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

			<?php get_template_part( 'part/no-results', 'index' ); ?>

		<?php endif; ?>

		<?php tha_content_bottom(); ?>
	</div><?php /*<!-- #content -->*/ ?>
	<?php tha_content_after(); ?>
</div><?php /*<!-- #primary .site-content -->*/ ?>

<?php
get_bottom_sidebar();
get_footer();
