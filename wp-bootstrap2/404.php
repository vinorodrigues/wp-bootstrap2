<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

bootstrap2_set_theme_option_sidebars('c');
if (!isset($fluid)) $fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';

get_header();
?>
<!-- 404 -->
<?php tha_content_before(); ?>
<div id="content" role="main" class="page404">
	<?php tha_content_top(); ?>
	<article id="post-0" class="post error404 not-found well">
		<header class="entry-header page-header">
			<h1 class="entry-title"><?php echo apply_filters('bootstrap2_404_heading',
				__( 'Page not Found.', 'bootstrap2' ) ); ?></h1>
		</header>
		<div class="entry-content">
			<p><?php echo apply_filters('bootstrap2_404_text',
				__( 'Sorry, but the page you are looking for has not been found.', 'bootstrap2' ) ); ?></p>
			<p><?php _e( 'Other things to try:', 'bootstrap2' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</article>
	<?php tha_content_bottom(); ?>
</div>
<?php tha_content_after(); ?>

<br class="clearfix" />

<?php do_action('tha_banner_before');  ?>
<div id="banner" class="row<?php echo $fluid; ?> clearfix" role="banner">
	<?php do_action( 'tha_banner_top' ); ?>
	<?php
		$wtag = apply_filters('bootstrap2_widget_tag', 'h3');
		$args = array(
			'before_widget' => '<aside class="widget">',
			'after_widget' => "</aside>",
			'before_title' => '<' . $wtag . ' class="widget-title">',
			'after_title' => '</' . $wtag . '>',
		);
	?>
	<div id="banner-1" class="widget-area span4" role="complementary">
		<div id="sidebar-4" class="banner first">
			<?php the_widget( 'WP_Widget_Recent_Posts', array('title' => __('Recent Posts', 'bootstrap2'), 'number' => 5), $args ); ?>
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

<?php
get_footer();
