<?php

function bootstrap2_carousel_init() {
	$labels = array(
		'name' => _x('Items', 'post type general name', 'bootstrap2'),
		'singular_name' => _x('Item', 'post type singular name', 'bootstrap2'),
		'add_new' => _x('Add New', 'book', 'bootstrap2'),
		'add_new_item' => __('Add New Item', 'bootstrap2'),
		'edit_item' => __('Edit Item', 'bootstrap2'),
		'new_item' => __('New Item', 'bootstrap2'),
		'all_items' => __('All Items', 'bootstrap2'),
		'view_item' => __('View Item', 'bootstrap2'),
		'search_items' => __('Search Items', 'bootstrap2'),
		'not_found' =>  __('No items found', 'bootstrap2'),
		'not_found_in_trash' => __('No items found in Trash', 'bootstrap2'),
		'parent_item_colon' => '',
		'menu_name' => __('Carousel', 'bootstrap2'),
	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => _x( 'item', 'URL slug', 'bootstrap2' ) ),
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'menu_icon' => get_template_directory_uri() . '/img/adminmenu-carousel.png',
		'supports' => array(),
	);
	register_post_type( 'carousel', $args );
}

add_action( 'init', 'bootstrap2_carousel_init' );
