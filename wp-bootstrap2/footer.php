<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */

if (!isset($build)) $build = bootstrap2_get_theme_option('page', 'fp');
if (!isset($fluid)) $fluid = bootstrap2_get_theme_option('fluid', false) ? '-fluid' : '';
if (!isset($sidebars)) $sidebars = bootstrap2_get_theme_option_sidebars();

$has_f_menu = has_nav_menu( 'footer-menu' );

$copyright = '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' );
$copyright = apply_filters( 'bootstrap2_site_info', $copyright );

$generator = '<a href="' . esc_url( __( 'http://wordpress.org/', 'bootstrap2' ) ) .
	'" title="' . esc_attr( 'Semantic Personal Publishing Platform', 'bootstrap2' ) .
	'" rel="generator" class="wordpress">' . sprintf( __( 'Proudly powered by %s', 'bootstrap2' ), 'WordPress' ) .
	'</a>';
$generator .= ' ' . __( 'and', 'bootstrap2' ) . ' ';
$generator .= '<a href="' . esc_url( __( 'http://twitter.github.com/bootstrap/', 'bootstrap2' ) ) .
	'" rel="generator" class="bootstrap">Bootstrap</a>';
$generator = apply_filters( 'bootstrap2_site_generator', $generator );

?>
</div><?php /*<!-- .row -->*/ ?>

<?php if ($build != 'p') echo '</div>'; /* .container */ ?>
</div><?php /*<!--- #main --->*/ ?>

<div id="footer<?php if ($build != 'p') echo '-band'; ?>" role="region">
<?php if ($build != 'p') echo '<div id="footer-wrap" class="container' . $fluid . '">'; ?>
<?php tha_footer_before(); ?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php tha_footer_top(); ?>
	<?php
		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with three columns of widgets.
		 */
		if ( ! is_404() ) get_sidebar( 'footer' );
	?>
	<div id="citation" class="row<?php echo $fluid; ?>">
		<div class="site-info <?php if (empty($generator)) echo 'span12 centered'; else echo ($has_f_menu ? 'span8' : 'span6'); ?>">
			<?php
				echo '<span class="copyright">' . 
					$copyright .
					'</span> <a class="to-top" href="#" title="' . __( 'Top of Page', 'bootstrap2' ) . '">&uarr;</a>';

				if ($has_f_menu) :
					wp_nav_menu( array(
						'container' => 'nav',
						'container_class' => 'subnav' . (empty($generator) ? ' centered' : ''),
						'theme_location' => 'footer-menu',
						'menu_class' => 'nav-footer',  // not .nav !
						'depth' => 1,
						'fallback_cb' => false,
						'walker' => new Bootstrap2_Nav_Walker,
						// 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					) );

				endif;
			?>
		</div>
		<?php if ( ! empty($generator) ) : ?><div id="site-generator" class="<?php echo $has_f_menu ? 'span4' : 'span6'; ?>">
			<span class="pull-right">
				<?php do_action( 'bootstrap2_credits' ); ?>
				<span class="generator"><?php echo $generator; ?></span>
			</span>
		</div><?php endif; ?>
	</div>
	<?php tha_footer_bottom(); ?>
</footer><?php /*<!--- #colophon --->*/ ?>
<?php tha_footer_after(); ?>
<?php if ($build != 'p') echo '</div>'; /* .container */ ?>
</div><?php /*<!--- #footer --->*/ ?>

<?php if ($build == 'p') echo '</div>'; ?>

<?php wp_footer(); ?>

</body>
</html>
