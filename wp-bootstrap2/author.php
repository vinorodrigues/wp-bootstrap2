<?php
/**
 * Author template
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.4.1
 * @see http://codex.wordpress.org/Author_Templates
 * @see http://interactiveblend.com/blog/online/about-the-author/
 */

get_header();
?>
<!-- archive -->

<?php tha_content_before(); ?>
<div id="content" role="main">
	<?php tha_content_top(); ?>

	<?php if ( have_posts() ) : ?>

		<?php
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		 */
		the_post();
		?>

		<header class="page-header vcard">
			<div class="media author-info">
				<div class="author-avatar pull-left">
					<?php
					add_filter( 'get_avatar', 'bootstrap2_get_avatar_comment' );
					$avatar = get_avatar(
						get_the_author_meta( 'user_email' ),
							apply_filters( 'bootstrap2_author_bio_avatar_size', 96 ) );
					remove_filter( 'get_avatar', 'bootstrap2_get_avatar_comment' );
					echo $avatar;
					?>
				</div>
				<div class="media-body author-description">
					<h3 class="media-heading author-title"><?php printf( __( 'About %s', 'bootstrap2' ), get_the_author() ); ?></h3>
					<?php
					$desc = get_the_author_meta('description');
					if (!empty($desc)) echo '<p>' . $desc . '</p>';

					$url = trim(get_the_author_meta('user_url'));
					$faceb = trim(get_the_author_meta('facebook'));
					$gplus = trim(get_the_author_meta('gplus'));
					$twitr = trim(get_the_author_meta('twitter'));
					$linkd = trim(get_the_author_meta('linkedin'));
					if ($url || $faceb || $gplus || $twitr || $linkd ) {
						$out = '<p>';
						$tpl = '<a href="%1$s" class="author-link"><img src="%2$s" />%3$s</a>';
						$spc = _x('<span class="space"> | </span>', 'author-bio', 'bootstrap2');
						if ($url) {
							if (!preg_match('/^http(s)?:\/\//', $url)) $url = 'http://' . $url;
							$n = parse_url($url, PHP_URL_HOST);
							$i = sprintf(__('http://www.google.com/s2/favicons?domain=%s', 'bootstrap2'), $n);
							$out .= sprintf(__($tpl, 'bootstrap2'), $url, $i, $n);
							if ($faceb || $gplus || $twitr || $linkd ) $out .= _x('<br/>', 'author-bio', 'bootstrap2');
						}
						if ($faceb) {
							$i = get_template_directory_uri() . '/img/facebook-16x16.png';
							$u = 'http://facebook.com/' . $faceb;
							$out .= sprintf(__($tpl, 'bootstrap2'), $u, $i, $faceb);
							if ($gplus || $twitr || $linkd ) $out .= $spc;
						}
						if ($gplus) {
							$i = get_template_directory_uri() . '/img/gplus-16x16.png';
							$u = 'http://plus.google.com/' . $gplus;
							$out .= sprintf(__($tpl, 'bootstrap2'), $u, $i, $gplus);
							if ($twitr || $linkd ) $out .= $spc;
						}
						if ($twitr) {
							$i = get_template_directory_uri() . '/img/twitter-16x16.png';
							$twitr = ltrim($twitr, '@#');
							$u = 'http://twitter.com/' . $twitr;
							$n = '@' . $twitr;
							$out .= sprintf(__($tpl, 'bootstrap2'), $u, $i, $n);
							if ($linkd ) $out .= $spc;
						}
						if ($linkd) {
							$i = get_template_directory_uri() . '/img/linkedin-16x16.png';
							$u = 'http://linkedin.com/in/' . $linkd . '/';
							$out .= sprintf(__($tpl, 'bootstrap2'), $u, $i, $linkd);
						}
						$out .= '</p>';
						echo apply_filters('bootstrap2_author_links', $out);
					}
					?>
				</div>
			</div>
			<hr class="soft" />
			<h3 class="page-title author-archive">
				<?php printf( __( 'Posts by %s', 'bootstrap2' ), get_the_author() ); ?>
			</h3>
		</header>

		<?php
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();
		?>

		<?php bootstrap2_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php tha_entry_before(); ?>

			<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to overload this in a child theme then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'part/content', get_post_format() );
			?>

			<?php tha_entry_after(); ?>
			<?php
				if ($wp_query->post_count !== ($wp_query->current_post + 1))
					echo '<hr class="soft" />';
			?>
		<?php endwhile; ?>

		<?php bootstrap2_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<?php get_template_part( 'part/no-results', 'archive' ); ?>

	<?php endif; ?>

	<?php tha_content_bottom(); ?>
</div>
<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
