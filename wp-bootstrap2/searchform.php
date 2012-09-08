<?php
/**
 * The template for displaying search forms in Bootstrap2
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="form-search">
	<label for="s" class="control-label assistive-text"><?php _e( 'Search', 'bootstrap2' ); ?></label>
	<input type="search" class="field input-medium search-query" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'bootstrap2' ); ?>" results="5" />
	<button type="submit" class="submit btn" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'bootstrap2' ); ?>" /><i class="icon-search"></i></button>
</form>
