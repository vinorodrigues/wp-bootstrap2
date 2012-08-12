<?php
/**
 * Bootstrap2 Theme Options
 *
 * @author Vino Rodrigues
 * @package WP-Bootstrap2
 * @since WP-Bootstrap2 0.1
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
	add_settings_field( 'well_w', __( 'Widgets are wells', 'bootstrap2' ), 'bootstrap2_settings_field_well_w', 'theme_options', 'layout' );
	add_settings_field( 'well_s', __( 'Sticky\'s are wells', 'bootstrap2' ), 'bootstrap2_settings_field_well_s', 'theme_options', 'layout' );

	add_settings_field( 'logo', __( 'Logo', 'bootstrap2' ), 'bootstrap2_settings_field_logo', 'theme_options', 'branding' );

	add_settings_field( 'icon', __( 'Icon', 'bootstrap2' ), 'bootstrap2_settings_field_icon', 'theme_options', 'navbar' );
	add_settings_field( 'name', __( 'Project Name', 'bootstrap2' ), 'bootstrap2_settings_field_name', 'theme_options', 'navbar' );
	add_settings_field( 'search', __( 'Include search form', 'bootstrap2' ), 'bootstrap2_settings_field_search', 'theme_options', 'navbar' );

	add_settings_field( 'inhibit_default_menu', __( 'Inhibit default Wordpress menu', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_default_menu', 'theme_options', 'general' );
	add_settings_field( 'inhibit_default_sidebar', __( 'Inhibit default Wordpress sidebar', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_default_sidebar', 'theme_options', 'general' );
	add_settings_field( 'inhibit_image_comments', __( 'Inhibit image page comments', 'bootstrap2' ), 'bootstrap2_settings_field_inhibit_image_comments', 'theme_options', 'general' );

	// add_settings_field( 'swatch', __( 'Bootstrap Swatch', 'bootstrap2' ), 'bootstrap2_settings_field_swatch', 'theme_options', 'general' );
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
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'bootstrap2_theme_options_render_page' // Function that renders the options page
	);

	wp_enqueue_style('bootstrap2-theme-options', get_template_directory_uri() . '/css/theme-options.css');
}
add_action( 'admin_menu', 'bootstrap2_theme_options_add_page' );


/* ------------------------------------------------------------------------ */


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
/*function bootstrap2_swatch() {
	$swatch = array(
		'' => array(
			'value' => '',
			'label' => '',
		),
		// TODO : parse the css/swatch folder!
		'cerulean' => array(
			'value' => 'cerulean',
			'label' => 'Cerulean',
		),
		'slate' => array(
			'value' => 'slate',
			'label' => 'Slate',
		),

	);

	return $swatch;
}*/


/* ------------------------------------------------------------------------ */

/**
 * Returns the options array for Bootstrap2.
 */
function bootstrap2_get_theme_options() {
	$saved = (array) get_option( 'bootstrap2_theme_options' );
	$defaults = apply_filters( 'bootstrap2_default_theme_options', array(
		//'sample_textarea' => '',
		'fluid' => 0,
		'page' => 'fp',
		'sidebars' => 'cs',
		'well_w' => 1,
		'well_s' => 1,
		'logo' => '',
		'icon' => '',
		'name' => '',
		'search' => 0,
		'inhibit_default_menu' => 0,
		'inhibit_default_sidebar' => 0,
		'inhibit_image_comments' => 0,
		//'swatch' => '',
	) );

	$defaults = apply_filters( 'bootstrap2_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}


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

		$ns1 = ! is_active_sidebar( 'sidebar-1' );
		$ns2 = ! is_active_sidebar( 'sidebar-2' );

		if ($ns1 && $ns2) :  // both
			$value = bootstrap2_get_theme_option('inhibit_default_sidebar') ? 'c' : 'cs';
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


/* ------------------------------------------------------------------------ */


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
		<?php if ( ! empty($description) ) : ?><span class="description"><?php echo $description  ?></span><?php endif; ?>
	</label>
	<?php
}


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

	foreach ( bootstrap2_sidebars() as $sidebars ) {
	?>
	<div class="layout">
		<label class="image-radio-option">
			<input type="radio" name="bootstrap2_theme_options[sidebars]" value="<?php echo esc_attr( $sidebars['value'] ); ?>" <?php checked( $options['sidebars'], $sidebars['value'] ); ?> />
			<span class="image-radio-label">
				<img src="<?php echo esc_url( $sidebars['thumbnail'] ); ?>" width="68" height="61" title="<?php echo $sidebars['label']; ?>" />
				<span class="description"><?php echo $sidebars['description']; ?></span>
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
	_bootstrap2_settings_field_checkbox( 'well_w',
		__( 'Use the <code>.well</code> class for sidebars', 'bootstrap2' ) );
}


/**
 *
 */
function bootstrap2_settings_field_well_s() {
	_bootstrap2_settings_field_checkbox( 'well_s',
		__( 'Append the <code>.well</code> class for sticky posts', 'bootstrap2' ) );
}


/**
 * Helper
 */
function _bootstrap2_settings_field_image($name = 'image', $value = '', $help = '', $empty = '' ) {
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
		<input type="text" name="bootstrap2_theme_options[<?php echo $name; ?>]" id="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>" />
		<input type="button" id="upload_<?php echo $name; ?>_button" class="button" value="<?php _e( 'Upload Image', 'bootstrap2' ); ?>" />
		<input type="button" class="button" value="<?php _e( 'Clear', 'bootstrap2' ); ?>" onclick="jQuery('#<?php echo $name; ?>').val('')" />
	</label>
	<script language="JavaScript">
		var uploadID = '';
		jQuery(document).ready(function() {
			jQuery('#upload_<?php echo $name; ?>_button').click(function() {
				uploadID = jQuery('#<?php echo $name; ?>');
				formfield = uploadID.attr('name');
				tb_show('', 'media-upload.php?type=image&post_id=0&TB_iframe=true');
				return false;
			});

			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				uploadID.val(imgurl);
				tb_remove();
			}

		});
	</script>

	<?php

}


/**
 *
 */
function bootstrap2_settings_field_logo() {
	$options = bootstrap2_get_theme_options();

	$help = __( 'You can upload a custom logo image to be shown at the top of your site instead of the title text.' .
		' Suggested width is no more than <b>290 pixels</b>. Suggested height is <b>60 pixels</b>.', 'bootstrap2' );
	?>
	<div class="layout">
	<?php _bootstrap2_settings_field_image( 'logo', $options['logo'], $help, apply_filters( 'bootstrap2_get_theme_logo', '' ) ); ?>
	</div>
	<?php
}


/**
 *
 */
function bootstrap2_settings_field_icon() {
	$options = bootstrap2_get_theme_options();

	$help = __( 'You can upload a custom icon image to be shown left-most on your primary menu.' .
		' Suggested width is <b>20 pixels</b>. Suggested height is <b>20 pixels</b>.', 'bootstrap2' );
	?>
	<div class="layout">
	<?php _bootstrap2_settings_field_image( 'icon', $options['icon'], $help, apply_filters( 'bootstrap2_get_theme_icon', '' ) ); ?>
	</div>
	<?php
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
	$options = bootstrap2_get_theme_options();
	?>
	<label for="search">
		<input type="checkbox" name="bootstrap2_theme_options[search]" id="search" <?php checked( '1', $options['search'] ); ?> />
		<span class="description"><?php _e( 'Right-most search form', 'bootstrap2' );  ?></span>
	</label>
	<?php
}

function bootstrap2_settings_field_inhibit_default_menu() { _bootstrap2_settings_field_checkbox( 'inhibit_default_menu' ); }
function bootstrap2_settings_field_inhibit_default_sidebar() { _bootstrap2_settings_field_checkbox( 'inhibit_default_sidebar' ); }
function bootstrap2_settings_field_inhibit_image_comments() { _bootstrap2_settings_field_checkbox( 'inhibit_image_comments' ); }


/* ------------------------------------------------------------------------ */


/**
 * Renders the Theme Options administration screen.
 */
function bootstrap2_theme_options_render_page() {
	?>
	<div id="theme-options-wrap" class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'bootstrap2' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<p>Version <?php echo BOOTSTRAP2_VERSION; ?></p>
		<p>Theme based on <a href="http://twitter.github.com/bootstrap/" target="_blank">Bootstrap from Twitter</a>.</p>

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

	$output['well_w'] = isset( $input['well_w'] ) ? 1 : 0;
	
	$output['well_s'] = isset( $input['well_s'] ) ? 1 : 0;

	if ( isset( $input['logo'] ) )
		$output['logo'] = $input['logo'];

	if ( isset( $input['icon'] ) )
		$output['icon'] = $input['icon'];

	if ( isset( $input['name'] ) && ! empty( $input['name'] ) )
		$output['name'] = wp_filter_nohtml_kses( $input['name'] );

	if ( isset( $input['search'] ) )
		$output['search'] = 1;
	
	$output['inhibit_default_menu'] = isset( $input['inhibit_default_menu'] ) ? 1 : 0;

	$output['inhibit_default_sidebar'] = isset( $input['inhibit_default_sidebar'] ) ? 1 : 0;

	$output['inhibit_image_comments'] = isset( $input['inhibit_image_comments'] ) ? 1 : 0;

	/*if ( isset( $input['swatch'] ) && array_key_exists( $input['swatch'], bootstrap2_swatch() ) )
		$output['swatch'] = $input['swatch'];*/

	return apply_filters( 'bootstrap2_theme_options_validate', $output, $input );
}


/**
 * @see: http://wordpress.org/support/topic/howto-integrate-the-media-library-into-a-plugin
 */
function bootsrap2_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery');
}
add_action('admin_print_scripts', 'bootsrap2_admin_scripts');


function bootstrap2_admin_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_styles', 'bootstrap2_admin_styles');


/* eof */
