<?php
/**
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.4.1
 */

$_class = '';
if (is_singular()) $_class .= 'item-singular ';
if (isset($wp_query)) {
	$_class .= 'item-' . ($wp_query->current_post + 1) . ' ';
	if ($wp_query->current_post == 0) $_class .= 'first ';
	if ($wp_query->post_count == ($wp_query->current_post + 1)) $_class .= 'last ';
}
$_h = (is_singular() ? 'h1' : 'h2');
?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class( rtrim($_class, ' ') ); ?>>
	<header class="entry-header">
		<<?php echo $_h; ?> class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bootstrap2' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></<?php echo $_h; ?>>

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
		'singular' => 0,
		)); /**/

	bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') );
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
