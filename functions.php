<?php
/**
 * Functions
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Set up the content width value based on the theme's design.
 *
 */
if ( ! isset( $content_width ) )
    $content_width = 1140;

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function tti_global_enqueues() {

	// javascript
	wp_enqueue_script( 'tti-global', get_stylesheet_directory_uri() . '/assets/js/global.min.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/global.min.js' ), true, true );
	wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/af04160a85.js', array(), false, false );
	wp_enqueue_script( 'tableau', 'https://tableau.tamu.edu/javascripts/api/viz_v1.js', array(), false, false );

	// css
	wp_dequeue_style( 'child-theme' );
	// wp_enqueue_style( 'tti-fonts', '//use.typekit.net/ctq0ben.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'tti-fonts', '//use.typekit.net/lrd3sso.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'tti-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), CHILD_THEME_VERSION );

	// Move jQuery to footer
	if( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, $in_footer = false );
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'tti_global_enqueues' );

/**
 * Gutenberg scripts and styles
 *
 */
function tti_gutenberg_scripts() {
	// wp_enqueue_style( 'tti-fonts', tti_theme_fonts_url() );
	wp_enqueue_style( 'tti-fonts', '//use.typekit.net/lrd3sso.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'tti-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'tti_gutenberg_scripts' );

/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function tti_child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

	// Includes
	include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );
	include_once( get_stylesheet_directory() . '/inc/markup.php' );
	include_once( get_stylesheet_directory() . '/inc/login-logo.php' );
	include_once( get_stylesheet_directory() . '/inc/custom-logo.php' );
	include_once( get_stylesheet_directory() . '/inc/tinymce.php' );
	include_once( get_stylesheet_directory() . '/inc/disable-editor.php' );
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );
	include_once( get_stylesheet_directory() . '/inc/api.php' );
	include_once( get_stylesheet_directory() . '/inc/group-api-shortcodes.php' );
	include_once( get_stylesheet_directory() . '/inc/header.php' );
	include_once( get_stylesheet_directory() . '/inc/navigation.php' );
	include_once( get_stylesheet_directory() . '/inc/patterns.php' );
	include_once( get_stylesheet_directory() . '/inc/footer.php' );
	include_once( get_stylesheet_directory() . '/inc/loop.php' );
	include_once( get_stylesheet_directory() . '/inc/amp.php' );
	include_once( get_stylesheet_directory() . '/inc/display-posts.php' );
	include_once( get_stylesheet_directory() . '/inc/wpforms.php' );

	// Events Calendar Pro customizations.
	include_once( get_stylesheet_directory() . '/inc/class-events.php' );
	new TTIBase\Events();

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Image Sizes
	add_image_size( 'tti_featured', 400, 100, true );

	// Gutenberg

	// -- Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Disable custom font sizes
	// add_theme_support( 'disable-custom-font-sizes' );

	// -- Editor Font Styles
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'small', 'tti_genesis_child' ),
			'shortName' => __( 'S', 'tti_genesis_child' ),
			'size'      => 12,
			'slug'      => 'small'
		),
		array(
			'name'      => __( 'regular', 'tti_genesis_child' ),
			'shortName' => __( 'M', 'tti_genesis_child' ),
			'size'      => 16,
			'slug'      => 'regular'
		),
		array(
			'name'      => __( 'large', 'tti_genesis_child' ),
			'shortName' => __( 'L', 'tti_genesis_child' ),
			'size'      => 20,
			'slug'      => 'large'
		),
	) );

	// -- Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );

	// -- Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Maroon', 'tti_genesis_child' ),
			'slug'  => 'maroon',
			'color'	=> '#500000',
		),
		array(
			'name'  => __( 'White', 'tti_genesis_child' ),
			'slug'  => 'white',
			'color'	=> '#fff',
		),
		array(
			'name'  => __( 'Blue', 'tti_genesis_child' ),
			'slug'  => 'blue',
			'color'	=> '#003C71',
		),
		array(
			'name'  => __( 'Green', 'tti_genesis_child' ),
			'slug'  => 'green',
			'color' => '#5B6236',
		),
		array(
			'name'	=> __( 'Teal', 'tti_genesis_child' ),
			'slug'	=> 'teal',
			'color'	=> '#4c8992',
		),
		array(
			'name'  => __( 'Brown', 'tti_genesis_child' ),
			'slug'  => 'brown',
			'color' => '#744F28',
		),
		array(
			'name'	=> __( 'Tan', 'tti_genesis_child' ),
			'slug'	=> 'tan',
			'color'	=> '#998542',
		),
		array(
			'name'	=> __( 'Black', 'tti_genesis_child' ),
			'slug'	=> 'black',
			'color'	=> '#000',
		),
		array(
			'name'	=> __( 'Dark Grey', 'tti_genesis_child' ),
			'slug'	=> 'darkgrey',
			'color'	=> '#332C2C',
		),
		array(
			'name'	=> __( 'Grey', 'tti_genesis_child' ),
			'slug'	=> 'grey',
			'color'	=> '#707373',
		),
		array(
			'name'	=> __( 'Light Grey for Background', 'tti_genesis_child' ),
			'slug'	=> 'lightgrey',
			'color'	=> '#ededed',
		),
		array(
			'name'	=> __( 'Yellow', 'tti_genesis_child' ),
			'slug'	=> 'yellow',
			'color'	=> '#e1af21',
		),
	) );

}
add_action( 'genesis_setup', 'tti_child_theme_setup', 15 );

/**
 * Change the comment area text
 *
 * @since  1.0.0
 * @param  array $args
 * @return array
 */
function tti_comment_text( $args ) {
	$args['title_reply']          = __( 'Leave A Reply', 'tti_genesis_child' );
	$args['label_submit']         = __( 'Post Comment',  'tti_genesis_child' );
	$args['comment_notes_before'] = '';
	$args['comment_notes_after']  = '';
	return $args;
}
add_filter( 'comment_form_defaults', 'tti_comment_text' );

/**
 * Filter Force Login to allow exceptions for specific URLs.
 *
 * @param array $whitelist An array of URLs. Must be absolute.
 * @return array
 */
function tti_forcelogin_whitelist( $whitelist ) {
  $whitelist[] = home_url( '/ems/' );
  return $whitelist;
}
// Don't think this applies to this site
// add_filter( 'v_forcelogin_whitelist', 'tti_forcelogin_whitelist' );

//*	Uses Theme colors in acf color picker fields
function tti_acf_input_admin_footer() { ?>
<script type="text/javascript">
    (function($) {

        acf.add_filter('color_picker_args', function( args, $field ){

        // add hexidecimal values for TTI brand colors
        args.palettes = ['#500000', '#e1af21', '#003C71', '#5B6236', '#4c8992', '#939598', '#fff', '#000'];

        // return
        return args;
        });
    })(jQuery);
</script> <?php
}
add_action('acf/input/admin_footer','tti_acf_input_admin_footer');

//*	Load value options for Program/Group Code field from TTI API
add_filter( 'acf/load_field/name=group_code', 'tti_acf_load_program_codes_values' );

function tti_acf_load_program_codes_values( $field ) {

	$field['choices'] = array();
	if (false === $programs = get_transient('programs')) {
		$json = ttiAPI2( "/v2/Organizations/Programs" );
		$programs = json_decode($json);
		set_transient('programs', $programs);
	}

	if ($programs):

		foreach($programs as $program) {
			$code = $program->ORG_CODE;
			$name = $program->ORG_NAME;
			$field['choices'][$code] = $name;
		}
		return $field;
		sort($field['choices']);

	endif;
}

//* Label acfs when collapsed for easier editor screen navigation
//	see https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/
/*add_filter('acf/fields/flexible_content/layout_title/name=my_flex_field', 'my_acf_fields_flexible_content_layout_title', 10, 4);
function my_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {

    // Remove layout name from title.
    $title = '';

    // Display thumbnail image.
    if( $image = get_sub_field('image') ) {
        $title .= '<div class="thumbnail"><img src="' . esc_url($image['sizes']['thumbnail']) . '" height="36px" /></div>';
    }

    // load text sub field
    if( $text = get_sub_field('text') ) {
        $title .= '<b>' . esc_html($text) . '</b>';
    }
    return $title;
}*/


function tti_pre_get_posts( $query ) {

	// do not modify queries in the admin
	if( is_admin() ) {
		return $query;
	}

	// only modify queries for 'projects' post type
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'project' ) {

		$query->set('orderby', 'meta_value');
		$query->set('meta_key', 'short');
		$query->set('order', 'ASC');
	}

	// return
	return $query;

}

// Saves acf fields
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {

    $path = get_stylesheet_directory() . '/assets/acf';

    return $path;

}

// Loads acf fields from `/assets/acf`
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {

    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/assets/acf';

    return $paths;

}

function tti_register_my_menus() {
  register_nav_menus(
    array(
      'main' => __( 'Main Navigation Menu' ),
      'utility' => __( 'Topbar Utility Navigation' )
     )
   );
 }
 // add_action( 'init', 'tti_register_my_menus' );
