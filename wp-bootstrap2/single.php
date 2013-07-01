<?php
/**
 * The Template for displaying all single posts.
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

get_header();
?>
<!-- single -->
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php tha_entry_before(); ?>

			<?php /* bootstrap2_content_nav( 'nav-above' ); */ ?>

			<?php
				/** replacement code for get_template_part() */
				$_tp_slug = 'part/content';
				$_tp_name = get_post_format();
				// do_action( "get_template_part_{$_tp_slug}", $_tp_slug, $_tp_name );
				$_tp_templates = array();
				if ($_tp_name) $_tp_templates[] = "{$_tp_slug}-{$_tp_name}-single.php";
				$_tp_templates[] = "{$_tp_slug}-single.php";
				$_tp_templates[] = "{$_tp_slug}.php";
				locate_template($_tp_templates, true, false);
			?>

			<?php bootstrap2_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) {
					?><hr class="soft" /><?php
					comments_template( '/part/comments.php', true );
				}
			?>

			<?php tha_entry_after(); ?>
		<?php endwhile; // end of the loop. ?>

		<?php tha_content_bottom(); ?>
	</div>
	<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
