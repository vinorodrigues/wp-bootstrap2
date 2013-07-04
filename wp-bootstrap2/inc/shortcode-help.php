<?php

function bootstrap2_add_meta_boxes_callback() {
	?>
	<table><tbody>
	<tr>
		<td><a href="<?php echo get_template_directory_uri(); ?>/readme.php?f=readme.shortcodes.md&TB_iframe=true" class="thickbox button button-large">Shortcodes</a></td>
		<td class="howto">Read the theme core shortcodes documentation</td>
	</tr>
	</tbody></table>
	<?php

	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
}

function bootstrap2_add_meta_boxes() {
	add_meta_box('bootstrap2_post_meta_box',
		__('WP-Bootstrap2 Theme Help', 'bootstrap2' ),
		'bootstrap2_add_meta_boxes_callback',
		'post',
		'side',
		'low' );
	add_meta_box('bootstrap2_page_meta_box',
		__('WP-Bootstrap2 Theme Help', 'bootstrap2' ),
		'bootstrap2_add_meta_boxes_callback',
		'page',
		'side',
		'low' );
}

add_action('add_meta_boxes', 'bootstrap2_add_meta_boxes', 70);

?>
