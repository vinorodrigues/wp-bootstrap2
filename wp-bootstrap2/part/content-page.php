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
		$title = get_the_title();
		if (!empty($title)) :
	?>
	<header class="entry-header page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') ); ?>
 		<?php edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
</article>
