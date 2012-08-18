<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

if (!isset($fluid)) $fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';

get_header();
?>

<div id="primary" class="site-content span12">
	<?php tha_content_before(); ?>
	<div id="content" role="main" class="page404 well">
		<?php tha_content_top(); ?>

		<article id="post-0" class="post error404 not-found">
			<header class="entry-header page-header">
				<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'bootstrap2' ); ?></h1>
			</header>

			<div class="row<?php echo $fluid; ?>"><div class="span3">&nbsp</div><div class="span6">
				<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'bootstrap2' ); ?></p>

					<?php get_search_form(); ?>
				</div>
			</div><div class="span3"></div></div>

		</article>

		<?php tha_content_bottom(); ?>
	</div>
	<?php tha_content_after(); ?>
</div>

</div><?php /*<!-- .row -->*/ ?><div class="row<?php echo $fluid; ?>">

<div id="secondary" class="site-content span12">
	<?php do_action('tha_banner_before');  ?>
	<div id="banner" class="row<?php echo $fluid; ?> clearfix" role="banner">
		<?php do_action( 'tha_banner_top' ); ?>

		<?php
			$args = array(
				'before_widget' => '<aside class="widget">',
				'after_widget' => "</aside>",
				'before_title' => '<h2 class="widget-title">',
				'after_title' => '</h2>',
			);
		?>

		<div id="banner-1" class="widget-area span4" role="complementary">
			<div id="sidebar-4" class="banner first">

				<?php the_widget( 'WP_Widget_Recent_Posts', array(), $args ); ?>

			</div>
		</div>
		<div id="banner-2" class="widget-area span4" role="complementary">
			<div id="sidebar-5" class="banner second">

				<?php echo $args['before_widget']; ?>
					<?php echo $args['before_title']; ?><?php _e( 'Most Used Categories', 'bootstrap2' ); ?><?php echo $args['after_title']; ?>
					<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '' ) ); ?>
					</ul>
				<?php echo $args['after_widget']; ?>

			</div>
		</div>
		<div id="banner-3" class="widget-area span4" role="complementary">
			<div id="sidebar-6" class="banner third last">

				<?php the_widget( 'WP_Widget_Tag_Cloud', array(), $args ); ?>

			</div>
		</div>

		<?php do_action( 'tha_banner_bottom' ); ?>
	</div>
	<?php do_action('tha_banner_after');  ?>
</div>

<?php
get_footer();
