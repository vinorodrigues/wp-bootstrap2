<?php
/**
 * The template used for displaying page content in page.php
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */
?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'item-singular item-1 first last' ); ?>>
	<?php
		// should we show the title?
		$_title = get_the_title();
		$_show_t = (!empty($_title));
		if ($_show_t && is_front_page() && bootstrap2_get_theme_option('inhibit_static_home_title')) $_show_t = false;
		if ( $_show_t ) :
	?>
	<header class="entry-header page-header">
		<h1 class="entry-title"><?php echo $_title; ?></h1>
	</header>
	<?php
		endif;
	?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') ); ?>
 		<?php edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
</article>
