<?php
/**
 * Bootstrap2 Theme Options
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
 *
 * Kudos to David Gwyer, http://www.presscoders.com/2010/05/wordpress-settings-api-explained/
 */


/**
 * Register the form setting for our bootstrap2_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, bootstrap2_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 */
function bootstrap2_theme_options_init() {
	register_setting(
		'bootstrap2_options',  // Options group, see settings_fields() call in bootstrap2_theme_options_render_page()
		'bootstrap2_theme_options',  // Database option, see bootstrap2_get_theme_options()
		'bootstrap2_theme_options_validate'  // The sanitization callback, see bootstrap2_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section( 'layout', __( 'Layout', 'bootstrap2' ), '__return_false', 'theme_options' );
	add_settings_section( 'branding', __( 'Branding', 'bootstrap2' ), '__return_false', 'theme_options' );
	add_settings_section( 'navbar', __( 'Navigation Bar', 'bootstrap2' ), '__return_false', 'theme_options' );
	add_settings_section( 'general', __( 'General', 'bootstrap2' ), '__return_false', 'theme_options' );

	// Register our individual settings fields
	add_settings_field( 'fluid', __( 'Fluid layout', 'bootstrap2' ), 'bootstrap2_settings_field_fluid', 'theme_options', 'layout' );
	add_settings_field( 'page', __( 'Page construction', 'bootstrap2' ), 'bootstrap2_settings_field_page', 'theme_options', 'layout' );
	add_settings_field( 'sidebars', __( 'Content and sidebar positions', 'bootstrap2' ), 'bootstrap2_settings_field_sidebars', 'theme_options', 'layout' );
	add_settings_field( 'well_w', __( 'Widget areas', 'bootstrap2' ), 'bootstrap2_settings_field_well_w', 'theme_options', 'layout' );
	add_settings_field( 'well_s', __( 'Sticky posts', 'bootstrap2' ), 'bootstrap2_settings_field_well_s', 'theme_options', 'layout' );

	add_settings_field( 'logo', __( 'Logo', 'bootstrap2' ), 'bootstrap2_settings_field_logo', 'theme_options', 'branding' );

	add_settings_field( 'darkbar', __( 'Dark Navbar', 'bootstrap2' ), 'bootstrap2_settings_field_darkbar', 'theme_options', 'navbar' );
	add_settings_field( 'icon', __( 'Icon', 'bootstrap2' ), 'bootstrap2_settings_field_icon', 'theme_options', 'navbar' );
	add_settings_field( 'name', __( 'Project Name', 'bootstrap2' ), 'bootstrap2_settings_field_name', 'theme_options', 'navbar' );
	add_settings_field( 'search', __( 'Include search form', 'bootstrap2' ), 'bootstrap2_settings_field_search', 'theme_options', 'navbar' );

	add_settings_field( 'inhibit_default_menu', __( 'Inhibit default Wordpress menu', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_default_menu', 'theme_options', 'general' );
	add_settings_field( 'inhibit_default_sidebar', __( 'Inhibit default Wordpress sidebar', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_default_sidebar', 'theme_options', 'general' );
	add_settings_field( 'inhibit_image_comments', __( 'Inhibit image page comments', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_image_comments', 'theme_options', 'general' );
	add_settings_field( 'inhibit_static_home_title', __( 'Inhibit static front page title', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_static_home_title', 'theme_options', 'general' );


	if (!is_child_theme()) {
		add_settings_section( 'swatch', __( 'Swatch', 'bootstrap2' ), '__return_false', 'theme_options' );

		add_settings_field( 'swatch', __( 'Swatch', 'bootstrap2' ), 'bootstrap2_settings_field_swatch', 'theme_options', 'swatch' );
		add_settings_field( 'swatch_css', __( 'Bootstrap CSS', 'bootstrap2' ), 'bootstrap2_settings_field_swatch_css', 'theme_options', 'swatch' );
		add_settings_field( 'swatch_js', __( 'Bootstrap JS', 'bootstrap2' ), 'bootstrap2_settings_field_swatch_js', 'theme_options', 'swatch' );
	};
}
add_action( 'admin_init', 'bootstrap2_theme_options_init' );


/**
 * Change the capability required to save the 'bootstrap2_options' options group.
 *
 * @see bootstrap2_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see bootstrap2_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function bootstrap2_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_bootstrap2_options', 'bootstrap2_option_page_capability' );


/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 */
function bootstrap2_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'bootstrap2' ),   // Name of page
		__( 'Theme Options', 'bootstrap2' ),   // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'bootstrap2_theme_options_render_page' // Function that renders the options page
	);

	wp_enqueue_style('bootstrap2-theme-options', get_template_directory_uri() . '/css/theme-options.css');
}
add_action( 'admin_menu', 'bootstrap2_theme_options_add_page' );


/* ----- SELECTS ---------------------------------------------------------- */


/**
 *
 */
function bootstrap2_page() {
	$thumb_uri = get_template_directory_uri() . '/img/theme-options';

	$page = array(
		'p' => array(
			'value' => 'p',
			'label' => __( 'Page', 'bootstrap2' ),
			'description' => __( 'Looks like a single sheet of paper, all content wrapped by a single width-defining element.', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/page-layout.png",
		),
		'fp' => array(
			'value' => 'fp',
			'label' => __( 'Full-Page', 'bootstrap2' ),
			'description' => __( 'Subdivided into several vertical aligned sections covering the full width, content seperated.', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/full-page-layout.png",
		),
	);

	return $page;
}


/**
 *
 */
function bootstrap2_sidebars() {
	$thumb_uri = get_template_directory_uri() . '/img/theme-options';

	$sidebars = array(
		'sc' => array(
			'value' => 'sc',
			'label' => __( 'Sidebar-Content', 'bootstrap2' ),
			'description' => __( 'Content on right, stacked sidebars', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/sidebar-content.png",
		),
		'ssc' => array(
			'value' => 'ssc',
			'label' => __( 'Sidebar-Sidebar-Content', 'bootstrap2' ),
			'description' => __( 'Content on right, sidebars side-by-side', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/sidebar-sidebar-content.png",
		),
		'scs' => array(
			'value' => 'scs',
			'label' => __( 'Sidebar-Content-Sidebar', 'bootstrap2' ),
			'description' => __( 'Content in center, sidebars either side', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/sidebar-content-sidebar.png",
		),
		'css' => array(
			'value' => 'css',
			'label' => __( 'Content-Sidebar-Sidebar', 'bootstrap2' ),
			'description' => __( 'Content on left, sidebars side-by-side', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/content-sidebar-sidebar.png",
		),
		'cs' => array(
			'value' => 'cs',
			'label' => __( 'Content-Sidebar', 'bootstrap2' ),
			'description' => __( 'Content on left, stacked sidebars', 'bootstrap2' ),
			'thumbnail' => "{$thumb_uri}/content-sidebar.png",
		),
	);

	return $sidebars;
}

/**
 *
 */
function bootstrap2_well_x() {
	$well = array(
		'unwell' => array(
			'value' => 'unwell',
			'label' => __( '(No well)', 'bootstrap2' ),
		),
		'well' => array(
			'value' => 'well',
			'label' => __( 'Well', 'bootstrap2' ),
		),
		'well well-large' => array(
			'value' => 'well well-large',
			'label' => __( 'Large well', 'bootstrap2' ),
		),
		'well well-small' => array(
			'value' => 'well well-small',
			'label' => __( 'Small well', 'bootstrap2' ),
		),
	);

	return $well;
}


/* ----- OPTION GETS ------------------------------------------------------ */


/**
 * Defaults
 * @return array
 */
function bootstrap2_default_theme_options() {
	return apply_filters( 'bootstrap2_default_theme_options', array(
		'fluid' => 0,
		'page' => 'fp',
		'sidebars' => 'cs',
		'well_w' => 'unwell',
		'well_s' => 'unwell',
		'darkbar' => 1,
		'logo' => '',
		'icon' => '',
		'name' => '',
		'search' => 0,
		'inhibit_default_menu' => 0,
		'inhibit_default_sidebar' => 0,
		'inhibit_image_comments' => 0,
		'inhibit_static_home_title' => 1,
		'swatch_css' => '',
		'swatch_js' => '',
		) );
}


/**
 * Returns the options array for Bootstrap2.
 */
function bootstrap2_get_theme_options() {
	$saved = (array) get_option( 'bootstrap2_theme_options' );
	$defaults = bootstrap2_default_theme_options();
	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );
	return $options;
}


/**
 * Load defaults / Init Options in DB
 */
function bootstrap2_after_setup_theme() {
	$options = get_option( 'bootstrap2_theme_options' );

	// Are our options saved in the DB?
	if ( false === $options ) {
		// If not, we'll save our default options
		$options = bootstrap2_default_theme_options();
		add_option( 'bootstrap2_theme_options', $options );
	}

	// In other case we don't need to update the DB
}
add_action( 'after_setup_theme', 'bootstrap2_after_setup_theme' );


/**
 *
 */
function bootstrap2_get_theme_option($name = NULL, $default = NULL) {
	global $__bootstrap2_get_theme_options;  // singleton
	if (!isset($__bootstrap2_get_theme_options))
		$__bootstrap2_get_theme_options = bootstrap2_get_theme_options();
	if (is_null($name)) {
		return $__bootstrap2_get_theme_options;  // return full array
	} else {
		if (isset($__bootstrap2_get_theme_options[$name])) {
			return $__bootstrap2_get_theme_options[$name];
		} else {
			return $default;
		}
	}
}


/**
 *
 */
function bootstrap2_set_theme_option_sidebars($value, $default = 'cs') {
	global $__bootstrap2_get_theme_option_sidebars;  // singleton
	if ( ! isset($__bootstrap2_get_theme_option_sidebars) )
		$__bootstrap2_get_theme_option_sidebars = $default;

	if ( in_array( $value, array('sc', 'ssc', 'scs', 'css', 'cs', 'c') ) ) {
		if ( $value != 'c' ) {
			$ns1 = (! is_active_sidebar( 'sidebar-1' )) && bootstrap2_get_theme_option('inhibit_default_sidebar');
			$ns2 = ! is_active_sidebar( 'sidebar-2' );

			if ($ns1 && $ns2 ) :  // neither
				$value = 'c';
			elseif ($ns1 || $ns2) :  // only one
				switch ($value) :
					case 'ssc' :
					case 'scs' :
						$value = 'sc';
						break;
					case 'css' :
						$value = 'cs';
						break;
				endswitch;
			endif;
		}
		$__bootstrap2_get_theme_option_sidebars = $value;
	}
	return $__bootstrap2_get_theme_option_sidebars;
}


/**
 *
 */
function bootstrap2_get_theme_option_sidebars($default = 'cs') {
	global $__bootstrap2_get_theme_option_sidebars;  // singleton
	if (isset($__bootstrap2_get_theme_option_sidebars))
		return $__bootstrap2_get_theme_option_sidebars;

	return bootstrap2_set_theme_option_sidebars(
		bootstrap2_get_theme_option( 'sidebars', $default ),
		$default);
}


/* ----- FIELD HELPERS ---------------------------------------------------- */


/**
 * Generic Checkbox fields
 * @param type $name
 * @param type $description
 */
function _bootstrap2_settings_field_checkbox($name, $description='') {
	$options = bootstrap2_get_theme_options();
	?>
	<label for="<?php echo $name; ?>">
		<input type="checkbox" name="bootstrap2_theme_options[<?php echo $name; ?>]" id="<?php echo $name; ?>" <?php checked( '1', $options[$name] ); ?> />
		<?php if ( ! empty($description) ) : ?> &nbsp; <span class="description"><?php echo $description  ?></span><?php endif; ?>
	</label>
	<?php
}

function _bootstrap2_settings_field_well_x($name, $description='') {
	$options = bootstrap2_get_theme_options();
	$items = bootstrap2_well_x();
	echo "<select id=\"{$name}\" name=\"bootstrap2_theme_options[{$name}]\">";
	foreach ($items as $item) {
		$selected = ($options[$name] == $item['value']) ? ' selected="selected" ' : '';
		echo "<option value=\"" . $item['value'] . "\"" . $selected . ">" . $item['label'] . "</option>";
	}
	echo "</select>";
	if ( ! empty($description) ) : ?> &nbsp; <span class="description"><?php echo $description  ?></span><?php endif;
}


/**
 * Helper
 */
function _bootstrap2_settings_field_image($name, $help = '', $empty = '' ) {
	$options = bootstrap2_get_theme_options();
	$value = $options[$name];

	?><div class="layout"><?php
	if (!empty($help))
		echo '<p>' . $help . '</p>';

	?>
	<label for="<?php echo $name; ?>">
	<?php

	$_show = empty($value) ? $empty : $value;
	if (empty($_show)) {
		?><span class="image-not-found"><?php _e( 'No image set', 'bootstrap2' ); ?></span><?php
	} else {
		?><img class="image-preview imgprev-<?php echo $name; ?>" src="<?php echo $_show ?>" /><?php
	}
	?><br />

		<span class="description"><?php _e( 'Enter an URL or upload an image', 'bootstrap2' ); ?></span><br />
		<input type="url" name="bootstrap2_theme_options[<?php echo $name; ?>]" id="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>"
		       size="50" />

		<input class="ts-open-media button" type="button" value="<?php echo _e('Upload Image');?>" style="display:none" />

		<input type="button" class="button" value="<?php _e( 'Clear', 'bootstrap2' ); ?>" onclick="jQuery('#<?php echo $name; ?>').val('')" />
	</label>
	</div><?php
}

/**
 * Helper
 * @see http://wp.tutsplus.com/tutorials/creative-coding/how-to-integrate-the-wordpress-media-uploader-in-theme-and-plugin-options/
 * @see http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
 */
function _bootstrap2_settings_field_file($name) {
	$options = bootstrap2_get_theme_options();
	$value = $options[$name];

	?><div class="layout">
	<label for="<?php echo $name; ?>">
		<span class="description"><?php _e( 'Enter an URL or upload an file', 'bootstrap2' ); ?></span><br />
		<input id="<?php echo $name; ?>" name="bootstrap2_theme_options[<?php echo $name; ?>]" type="url" value="<?php echo $value; ?>"
		       size="50" />

		<input class="ts-open-media button" type="button" value="<?php echo _e('Upload File');?>" style="display:none" />

		<input type="button" class="button" value="<?php _e( 'Clear', 'bootstrap2' ); ?>" onclick="jQuery('#<?php echo $name; ?>').val('')" />
	</label>
	</div><?php
}


/* ----- FIELDS ----------------------------------------------------------- */

/**
 *
 */
function bootstrap2_settings_field_fluid() {
	_bootstrap2_settings_field_checkbox( 'fluid',
		__( 'Fluid, whole page layout vs. centered column container', 'bootstrap2' ) );
}


/**
 *
 */
function bootstrap2_settings_field_page() {
	$options = bootstrap2_get_theme_options();

	foreach ( bootstrap2_page() as $page ) {
	?>
	<div class="layout">
		<label class="image-radio-option">
			<input type="radio" name="bootstrap2_theme_options[page]" value="<?php echo esc_attr( $page['value'] ); ?>" <?php checked( $options['page'], $page['value'] ); ?> />
			<span class="image-radio-label">
				<img src="<?php echo esc_url( $page['thumbnail'] ); ?>" width="136" height="122" title="<?php echo $page['label']; ?>" />
				<span class="description"><?php echo $page['description']; ?></span>
			</span>
		</label>
	</div>
	<?php
	}
}


/**
 *
 */
function bootstrap2_settings_field_sidebars() {
	$options = bootstrap2_get_theme_options();
	$sidebars = bootstrap2_sidebars();
	foreach ( $sidebars as $sidebar ) {
	?>
	<div class="layout">
		<label class="image-radio-option">
			<input type="radio" name="bootstrap2_theme_options[sidebars]" value="<?php echo esc_attr( $sidebar['value'] ); ?>" <?php checked( $options['sidebars'], $sidebar['value'] ); ?> />
			<span class="image-radio-label">
				<img src="<?php echo esc_url( $sidebar['thumbnail'] ); ?>" width="68" height="61" title="<?php echo $sidebar['label']; ?>" />
				<span class="description"><?php echo $sidebar['description']; ?></span>
			</span>
		</label>
	</div>
	<?php
	}
}


/**
 *
 */
function bootstrap2_settings_field_well_w() {
	_bootstrap2_settings_field_well_x( 'well_w',
		__( 'Use the <code>.well</code> class for sidebars', 'bootstrap2' ) );
}


/**
 *
 */
function bootstrap2_settings_field_well_s() {
	_bootstrap2_settings_field_well_x( 'well_s',
		__( 'Append the <code>.well</code> class for sticky posts', 'bootstrap2' ) );
}


/**
 *
 */
function bootstrap2_settings_field_darkbar() {
	_bootstrap2_settings_field_checkbox( 'darkbar',
		__( 'Use the dark navbar', 'bootstrap2' ) );
}


/**
 *
 */
function bootstrap2_settings_field_logo() {
	$help = __( 'You can upload a custom logo image to be shown at the top of your site instead of the title text.' .
		' Suggested width is no more than <b>290 pixels</b>. Suggested height is <b>60 pixels</b>.', 'bootstrap2' );

	_bootstrap2_settings_field_image( 'logo', $help, apply_filters( 'bootstrap2_get_theme_logo', '' ) );
}


/**
 *
 */
function bootstrap2_settings_field_icon() {
	$help = __( 'You can upload a custom icon image to be shown left-most on your primary menu.' .
		' Suggested width is <b>20 pixels</b>. Suggested height is <b>20 pixels</b>.', 'bootstrap2' );

	_bootstrap2_settings_field_image( 'icon', $help, apply_filters( 'bootstrap2_get_theme_icon', '' ) );
}


/**
 *
 */
function bootstrap2_settings_field_name() {
	$options = bootstrap2_get_theme_options();
	?>
	<input type="text" name="bootstrap2_theme_options[name]" id="sample-text-input" value="<?php echo esc_attr( $options['name'] ); ?>" />
	<label class="description" for="sample-text-input"><?php _e( 'Leave blank to disable', 'bootstrap2' ); ?></label>
	<?php
}


/**
 *
 */
function bootstrap2_settings_field_search() {
	_bootstrap2_settings_field_checkbox( 'search',
		__( 'Search form on the right of the navbar', 'bootstrap2' ) );
}


function bootstrap2_settings_field_inhibit_default_menu() { _bootstrap2_settings_field_checkbox( 'inhibit_default_menu' ); }
function bootstrap2_settings_field_inhibit_default_sidebar() { _bootstrap2_settings_field_checkbox( 'inhibit_default_sidebar' ); }
function bootstrap2_settings_field_inhibit_image_comments() { _bootstrap2_settings_field_checkbox( 'inhibit_image_comments' ); }
function bootstrap2_settings_field_inhibit_static_home_title() { _bootstrap2_settings_field_checkbox( 'inhibit_static_home_title' ); }


/**
 *
 */
function bootstrap2_settings_field_swatch() {
	echo '<p>' . _e('
A <b>swatch</b> is an alternative Bootstrap CSS that changes the visual elements of the default Bootstrap CSS.
</p><p>
You can use one of the many ready made swathes.  Good starting place\'s are:
<ul>
	<li><a href="http://bootswatch.com" target="_blank">Bootswatch</a> (CDN at <a href="http://www.bootstrapcdn.com" target="_blank">BootstrapCDN</a>)</li>
	<li><a href="http://code52.org/metro.css" target="_blank">metro.css</a> <i>(remember to JS file too)</i></li>
</ul>
</p><p>
... or make your own:
<ul>
	<li><a href="http://bootswatchr.com" target="_blank">Bootswatchr</a></li>
	<li><a href="http://stylebootstrap.info" target="_blank">StyleBootstrap.info</a></li>
	<li><a href="http://www.boottheme.com" target="_blank">BootTheme</a></li>
</ul>
	', 'bootstrap2') . '</p>';
}

/**
 *
 */
function bootstrap2_settings_field_swatch_css() {
	_bootstrap2_settings_field_file('swatch_css');
}


/**
 *
 */
function bootstrap2_settings_field_swatch_js() {
	_bootstrap2_settings_field_file('swatch_js');
}


/* ----- RENDER FORM ------------------------------------------------------ */


/**
 * Renders the Theme Options administration screen.
 */
function bootstrap2_theme_options_render_page() {
	?>
	<div id="theme-options-wrap" class="wrap">
		<?php screen_icon(); ?>
		<h2><?php
			$t = (function_exists('wp_get_theme') ? wp_get_theme() : 'Bootstrap2');
			printf( __( '%s Theme Options', 'bootstrap2' ), $t );
		?></h2>
		<?php settings_errors(); ?>

		<?php
			$v = get_stylesheet_directory() . '/style.css';
			$v = get_file_data( $v, array('Version' => 'Version'), 'theme' );
			if (isset($v['Version'])) $v = $v['Version']; else $v = __('Unknown', 'bootstrap2');
			echo '<p><b>' . sprintf( __('Version %s', 'bootstrap2'), $v) . '</b>';
			if (is_child_theme()) {
				$v = get_template_directory() . '/style.css';
				$v = get_file_data( $v, array('Version' => 'Version'), 'theme' );
				if (isset($v['Version'])) $v = $v['Version']; else $v = __('Unknown', 'bootstrap2');
				echo '<br />' . sprintf( __('Child of <b>WP-Bootstrap2</b> Version %s', 'bootstrap2'), $v) . '</p>';
			}
			echo '</p>';
		?>

		<?php if (!is_child_theme()) { ?><p>
		<b>Theme based on <a href="http://getbootstrap.com" target="_blank">Bootstrap from Twitter</a></b> <small>(Version <?php echo BOOTSTRAP_VERSION; ?>).</small><br />
		Designed and built with all the love in the world <a href="http://twitter.com/twitter" target="_blank">@twitter</a> by <a href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a href="http://twitter.com/fat" target="_blank">@fat</a>.<br />
		Code licensed under the <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>. Documentation licensed under <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">CC BY 3.0</a>.<br />
		Icons from <a href="http://glyphicons.com" target="_blank">Glyphicons Free</a>, licensed under <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">CC BY 3.0</a>.
		</p><?php } ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'bootstrap2_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see bootstrap2_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 */
function bootstrap2_theme_options_validate( $input ) {
	$output = array();

	$output['fluid'] = isset( $input['fluid'] ) ? 1 : 0;

	if ( isset( $input['page'] ) && array_key_exists( $input['page'], bootstrap2_page() ) )
		$output['page'] = $input['page'];

	if ( isset( $input['sidebars'] ) && array_key_exists( $input['sidebars'], bootstrap2_sidebars() ) )
		$output['sidebars'] = $input['sidebars'];

	if ( isset( $input['well_w'] ) && array_key_exists( $input['well_w'], bootstrap2_well_x() ) )
		$output['well_w'] = $input['well_w'];
	
	if ( isset( $input['well_s'] ) && array_key_exists( $input['well_s'], bootstrap2_well_x() ) )
		$output['well_s'] = $input['well_s'];

	$output['darkbar'] = isset( $input['darkbar'] ) ? 1 : 0;

	if ( isset( $input['logo'] ) )
		$output['logo'] = $input['logo'];

	if ( isset( $input['icon'] ) )
		$output['icon'] = $input['icon'];

	if ( isset( $input['name'] ) && ! empty( $input['name'] ) )
		$output['name'] = wp_filter_nohtml_kses( $input['name'] );

	$output['search'] = isset( $input['search'] ) ? 1 : 0;
	
	$output['inhibit_default_menu'] = isset( $input['inhibit_default_menu'] ) ? 1 : 0;

	$output['inhibit_default_sidebar'] = isset( $input['inhibit_default_sidebar'] ) ? 1 : 0;

	$output['inhibit_image_comments'] = isset( $input['inhibit_image_comments'] ) ? 1 : 0;

	$output['inhibit_static_home_title'] = isset( $input['inhibit_static_home_title'] ) ? 1 : 0;
	
	if (!is_child_theme()) {

		if ( isset( $input['swatch_css'] ) )
			$output['swatch_css'] = $input['swatch_css'];

		if ( isset( $input['swatch_js'] ) )
			$output['swatch_js'] = $input['swatch_js'];
	}

	return apply_filters( 'bootstrap2_theme_options_validate', $output, $input );
}


/**
 * @see http://wordpress.org/support/topic/howto-integrate-the-media-library-into-a-plugin
 */
function bootstrap2_admin_enqueue_scripts() {
	wp_enqueue_script('jquery');  // just in case

	if (WP35UP) {
		wp_enqueue_media();  // *new in WP3.5+

		wp_register_script( 'ts-nmp-media', get_template_directory_uri() . '/js/ts-media' .
			((defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min') .
			'.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'ts-nmp-media', 'ts_nmp_media', array(
			'title' => __( 'Upload File or Select from Media Library', 'bootstrap2' ),  // This will be used as the default title
			'button' => __( 'Insert', 'bootstrap2' ),  // This will be used as the default button text
			) );
		wp_enqueue_script( 'ts-nmp-media' );
	} else {
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');

		wp_register_script( 'ts-upload', get_template_directory_uri() . '/js/ts-upload' .
			((defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min') .
			'.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'ts-upload', 'ts_upload', array(
			'title' => __( 'Upload File or Select from Media Library', 'bootstrap2' ),  // This will be used as the default title
			'referer' => 'bootstrap2',
			) );
		wp_enqueue_script( 'ts-upload' );

		wp_enqueue_style('thickbox');
	}
}
add_action( 'admin_enqueue_scripts', 'bootstrap2_admin_enqueue_scripts' );


/* eof */
