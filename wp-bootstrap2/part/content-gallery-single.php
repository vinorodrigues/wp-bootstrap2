<?php
/**
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.4.1
 */
?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'item-singular item-1 first last' ); ?>>
	<header class="entry-header page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php bootstrap2_posted_on(); ?>
		</div>
	</header>

	<div class="entry-content">
	<?php
	$images = bootstrap2_get_gallery_images();
	$cols = floor(bootstrap2_get_column_width(1) / 2);

	echo bootstrap2_gallery(array(
		'ids'      => implode(',', $images),
		'columns'  => $cols,
		'size'     => 'thumbnail',
		'singular' => 1,
		)); /**/
	?>
	</div>

	<footer class="entry-meta">
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link(
			'<i class="icon-comment icon-white"></i> ' . __( 'Leave a comment', 'bootstrap2' ),
			'<i class="icon-comment icon-white"></i> ' . __( '1 Comment', 'bootstrap2' ),
			'<i class="icon-comment icon-white"></i> ' . __( '% Comments', 'bootstrap2' ),
			'btn btn-mini btn-info' ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
