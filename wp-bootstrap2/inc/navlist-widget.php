<?php
/**
 * Bootstrap .navlist style side menu
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 */


/**
 * Nav List widget class
 */
class Bootstrap2_Navlist_Widget extends WP_Widget {


	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'bootstrap2-navlist', __( 'Bootstrap2 (Theme) NavList Widget', 'bootstrap2' ), array(
			'classname'   => 'bootstrap2-navlist',
			'description' => __( 'Displays a menu as a Bootstap Nav List', 'bootstrap2' )
		) );

	}

	/**
	 * Displays the widget content
	 *
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		$title = ( !empty($instance['title']) ) ? trim($instance['title']) : '';

		wp_nav_menu( array(
			'menu' => $nav_menu,
			'container' => false,
			'items_wrap' => '<ul id="%1$s" class="nav nav-list %2$s">' . (( !empty($title) ) ? '<li class="nav-header">' . $title . '</li>' : '') . '%3$s</ul>',
			'fallback_cb' => false,
			'depth' => 1,
		) );

		echo $args['after_widget'];
	}

	/**
	 * Updates the widget settings
	 *
	 * @param	array	$new_instance
	 * @param	array	$old_instance
	 * @return	array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	/**
	 * Displays the widget's settings form
	 *
	 * @param	array	$instance
	 * @return	void
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}  // class Bootstrap2_Navlist_Widget

/* eof */
