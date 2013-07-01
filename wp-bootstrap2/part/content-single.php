<?php
/**
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */

global $multipage, $numpages, $page;

?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'item-singular item-1 first last' ); ?>>
	<?php if (!has_post_format( 'aside' )) { ?>
	<header class="entry-header page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php bootstrap2_posted_on(); ?>
			<?php if ($multipage) printf( __('<span class="meta-pages"><i class="icon-file"></i> Page %d of %d</span>', 'bootstrap2'), $page, $numpages ); ?>
		</div>
	</header>
	<?php } ?>

	<div class="entry-content">
		<?php the_content( __( '(more&hellip;)' ) ); ?>
		<?php bootstrap2_link_pages( array('before' => '<div class="pagination pagination-centered"><ul>') ); ?>
	</div>

	<footer class="entry-meta">
		<?php
			// TODO : Fixthis!

			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ' ', 'bootstrap2' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ' ' );

			$meta_text = '';
			if ( bootstrap2_categorized_blog() ) $meta_text .= '%1$s ';
			if ( '' != $tag_list ) $meta_text .= '%2$s ';
			$meta_text .= __( '<a class="btn btn-mini" href="%3$s" title="Permalink to %4$s" rel="bookmark"><i class="icon-bookmark"></i> Permalink</a>', 'bootstrap2' );

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
