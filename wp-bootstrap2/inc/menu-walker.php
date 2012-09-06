<?php
/**
 * Derived from code at: http://goldenapplesdesign.com/2010/10/05/dropdown-menus-walker_nav_menu/
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */


/*
 * Walker_Nav_Menu class
 */
class Bootstrap2_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 */
	function start_lvl( &$output, $depth ) {
		$output .= '<ul class="dropdown-menu">';
	}

	function end_lvl( &$output, $depth ) {
		$output .= '</ul>';
	}

	/**
	 * @see Walker_Nav_Menu::start_el()
	 */
	function start_el( &$output, $item, $depth, $args ) {
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( $args->has_children ) $classes[] = 'dropdown';

		$classes[] = 'ord-' . $item->menu_order;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= '<li' . $id . $value . $class_names . '>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		
		$attributes .= $args->has_children ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .=	$args->link_before;
		$item_output .=	apply_filters( 'the_title', $item->title, $item->ID );
		// $item_output .= ! empty( $item->description ) ? '<span>' . $item->description . '</span>' : '';
		$item_output .=	$args->link_after;
		$item_output .=	( $args->has_children ) ? ' <b class="caret"></b>' : '';
		$item_output .=	'</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	private function _prepare_first_and_last( &$elements ) {
		$cnt = 0;
		foreach ( $elements as $e ) $cnt++;
		$i = 0;
		foreach ( $elements as $e ) {
			$i++;
			if ($i == 1) $e->classes[] = 'first';
			if ($i == $cnt) $e->classes[] = 'last';
			if (1 == $cnt) $e->classes[] = 'only';
		}
	}

	/**
	 * @see Walker::display_element()
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );
		elseif ( is_object(  $args[0] ) )
			$args[0]->has_children = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'start_el' ), $cb_args );

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 OR $max_depth > $depth+1 ) AND isset( $children_elements[$id] ) ) {

			$this->_prepare_first_and_last( $children_elements[ $id ] );
			foreach ( $children_elements[ $id ] as $child ) {

				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset( $newlevel ) AND $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
		}

		//end this element
		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'end_el' ), $cb_args );
	}

	/**
	 * @see Walker::walk()
	 */
	function walk( $elements, $max_depth ) {

		$args = array_slice(func_get_args(), 2);
		$output = '';

		if ($max_depth < -1) //invalid parameter
			return $output;

		if (empty($elements)) //nothing to walk
			return $output;

		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( -1 == $max_depth ) {
			$empty_array = array();
			$this->_prepare_first_and_last($elements);
			foreach ( $elements as $e )
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			return $output;
		}

		// need to display in hierarchical order
		// separate elements into two buckets: top level and children elements
		// children_elements is two dimensional array, eg.
		// children_elements[10][] contains all sub-elements whose parent is 10.
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e) {
			if ( 0 == $e->$parent_field )
				$top_level_elements[] = $e;
			else
				$children_elements[ $e->$parent_field ][] = $e;
		}

		// when none of the elements is top level
		// assume the first one must be root of the sub elements
		if ( empty($top_level_elements) ) {

			$first = array_slice( $elements, 0, 1 );
			$root = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( $root->$parent_field == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		$this->_prepare_first_and_last( $top_level_elements );
		foreach ( $top_level_elements as $e )
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );

		// if we are displaying all levels, and remaining children_elements is not empty,
		// then we got orphans, which should be displayed regardless
		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans ) {
				$this->_prepare_first_and_last( $orphans );
				foreach( $orphans as $op )
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
			}
		 }

		 return $output;
	}
}


function bootstrap2_fallback_page_menu( $args = array() ) {
	global $wp_query;

	$defaults = array(
		'sort_column'     => 'menu_order, post_title',
		'container'       => 'div',
		'container_class' => false,  // if false will generate 'menu--container'
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'link_before'     => '',
		'link_after'      => '',
		'before'          => '',
		'after'           => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	);
	$args = apply_filters( 'wp_page_menu_args', wp_parse_args( $args, $defaults ) );

	$list = array();

	// Include Home first
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __('Home', 'bootstrap2');
		else
			$text = $args['show_home'];
		$cur = is_front_page() && !is_paged();
		$id = 0;
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $args['exclude'] ) ) {
				$args['exclude'] .= ',';
			} else {
				$args['exclude'] = '';
			}
			$id = get_option('page_on_front');
			$args['exclude'] .= $id;
		}
		$list[] = array(
			'ID' => $id,
			'current' => $cur,
			'url' => home_url( '/' ),
			'title' => esc_attr($text),
		);
	}

	// get pages
	$args['parent'] = 0;  // force topmost only
	$output = get_pages( $args );
	// build 1st level pages
	$id = (isset($wp_query->post) && is_object($wp_query->post)) ? $wp_query->post->ID : -1;
	foreach ($output as $o)
		$list[] = array(
			'ID' => $o->ID,
			'current' => ($o->ID == $id),
			'url' => $o->guid,
			'title' => $o->post_title,
		);

	// okay, ready to build html
	$output = '';

	// container
	$has_container = false;
	if ( $args['container'] ) {
		$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		if ( in_array( $args['container'], $allowed_tags ) ) {
			$has_container = true;
			$id = $args['container_id'] ? ' id="' . esc_attr( $args['container_id'] ) . '"' : '';
			$class = $args['container_class'] ? ' class="' . esc_attr( $args['container_class'] ) . '"' : ' class="menu--container"';
			$output .= '<'. $args['container'] . $id . $class . '>';
		}
	}

	// WALK THE LIST
	//
	// simulate wp_nav_menu()
	$items = '';
	foreach ($list as $item) {
		$item = (object) $item;  // cast as object
		// simulate Walker_Nav_Menu->start_el
		$classes = array();
		$classes[] = 'menu-item-' . $item->ID;
		if ( $item->current ) $classes[] = 'current-menu-item';
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = 'menu-item-' . $item->ID;
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$items .= '<li' . $id . $class_names .'>';
		
		$attributes = ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args['before'];
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args['link_before'] . apply_filters( 'the_title', $item->title, $item->ID ) . $args['link_after'];
		$item_output .= '</a>';
		$item_output .= $args['after'];
		$items .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, 1, $args );
	
		// simulate Walker_Nav_Menu->end_el
		$items .= "</li>\n";
	}
	unset($list);

	$wrap_class = $args['menu_class'] ? $args['menu_class'] : '';

	// Allow plugins to hook into the menu to add their own <li>'s
	$items = apply_filters( 'wp_nav_menu_items', $items, $args );
	$items = apply_filters( "wp_nav_menu__items", $items, $args );

	$output .= sprintf( $args['items_wrap'], esc_attr( $args['menu_id'] ), esc_attr( $wrap_class ), $items );

	if ( $has_container ) $output .= '</' . $args['container'] . '>';

	$output = apply_filters( 'wp_page_menu', $output, $args );
	if ( $args['echo'] )
		echo $output;
	else
		return $output;
}


/**
 * Adds the active CSS class
 */
function bootstrap2_nav_menu_css_class( $classes ) {
	if ( in_array('current-menu-item', $classes ) OR in_array( 'current-menu-ancestor', $classes ) )
		$classes[] = 'active';
	return $classes;
}
add_filter( 'nav_menu_css_class', 'bootstrap2_nav_menu_css_class' );

/* eof */
