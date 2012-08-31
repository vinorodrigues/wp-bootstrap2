<?php
/**
 * The template for displaying Search Results pages.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
get_top_sidebar();
?>
<!-- search -->
<section id="primary" class="site-content span<?php bootstrap2_column_class(); ?>">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'bootstrap2' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php bootstrap2_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php tha_entry_before(); ?>

				<?php get_template_part( 'part/content', 'search' ); ?>

				<?php tha_entry_after(); ?>
			<?php endwhile; ?>

			<?php bootstrap2_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'part/no-results', 'search' ); ?>

		<?php endif; ?>

		<?php tha_content_bottom(); ?>
	</div>
	<?php tha_content_after(); ?>
</section>

<?php
get_bottom_sidebar();
get_footer();
