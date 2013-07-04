<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1 
 */

$_class = 'alert';
if (is_search()) $_class .= ' alert-info';

?>
<!-- <?= basename(__FILE__, '.php') ?> -->
<article id="post-0" class="post no-results not-found <?php echo apply_filters('bootstrap2_no_results_class', $_class); ?>">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<header class="entry-header page-header">
		<h1 class="entry-title"><?php echo apply_filters('bootstrap2_no_results_heading',
			__( 'Content not Found.', 'bootstrap2' ) ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( is_home() ) {

			if ( current_user_can( 'edit_posts' ) ) {

				?>
				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'bootstrap2' ), admin_url( 'post-new.php' ) ); ?></p>
				<?php

			} else {

				?>
				<p><?php echo apply_filters('bootstrap2_no_results_text',
					__( 'Sorry, but the content you are looking for has not been found.', 'bootstrap2' ) ); ?></p>
				<?php


			}

		} else if ( is_search() ) {

			?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bootstrap2' ); ?></p>
			<?php

			get_search_form();

		} else {

			?>
			<p><?php _e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'bootstrap2' ); ?></p>
			<?php

			get_search_form();

		}
		?>
	</div>
</article>
