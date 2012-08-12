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

<section id="primary" class="site-content <?php bootstrap2_column_class(); ?>">
	<div id="content" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'bootstrap2' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header>

		<?php bootstrap2_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'part/content', 'search' ); ?>

		<?php endwhile; ?>

		<?php bootstrap2_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<?php get_template_part( 'part/no-results', 'search' ); ?>

	<?php endif; ?>

	</div>
</section>

<?php
get_bottom_sidebar();
get_footer();
