<?php if ( defined('WP_DEBUG') && WP_DEBUG ) :
/**
 * Debug Stuff
 * ------------------------------------- edit below this line -----------------
 */


/** remove gravatar.com for quicker loading */
function get_gravatar_off( $avatar, $id_or_email, $size = '96' ) {
	$img = get_template_directory_uri() .'/img/gravatar.png';
	return "<img alt='image_alt' src='{$img}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}
add_filter('get_avatar', 'get_gravatar_off', 1, 3);


/**
 * ------------------------------------- edit above this line -----------------
 */
endif;  /* eof */
