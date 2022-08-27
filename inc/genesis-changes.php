<?php
/**
 * Genesis Changes
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Theme Supports
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'header', 'menu-primary', 'menu-secondary', 'site-inner', 'footer-widgets', 'footer' ) );
add_theme_support( 'genesis-menus', array( 'primary' => 'Primary Navigation Menu', 'utility-bar' => 'Utility Bar Menu' ) );
add_theme_support( 'genesis-footer-widgets', 3 );

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
		'screen-reader-text',
	)
);

// h1 on home
add_filter( 'genesis_site_title_wrap', function( $wrap ) { return is_front_page() ? 'h1' : $wrap; } );

// Remove admin bar styling
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove Genesis Favicon (use site icon instead)
remove_action( 'wp_head', 'genesis_load_favicon' );

// Remove Header Description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Remove unused sidebars
unregister_sidebar( 'header-right' );
// unregister_sidebar( 'sidebar' );
// unregister_sidebar( 'sidebar-alt' );

// Remove layout metabox
// remove_theme_support( 'genesis-inpost-layouts' );
// remove_theme_support( 'genesis-archive-layouts' );

// Remove layouts
// genesis_unregister_layout( 'content-sidebar-sidebar' );
// genesis_unregister_layout( 'sidebar-content-sidebar' );
// genesis_unregister_layout( 'sidebar-sidebar-content' );
// genesis_unregister_layout( 'sidebar-content' );
// genesis_unregister_layout( 'content-sidebar' );


// Add New Sidebars
// genesis_register_widget_area( array( 'id' => 'blog-sidebar', 'name' => 'Blog Sidebar' ) );

/**
 * Remove Genesis Templates
 *
 */
function tti_remove_genesis_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'tti_remove_genesis_templates' );

/**
 * Custom search form
 *
 */
function tti_search_form() {
	ob_start();
	get_template_part( 'searchform' );
	return ob_get_clean();
}
add_filter( 'genesis_search_form', 'tti_search_form' );


//* Modify breadcrumb arguments
add_filter( 'genesis_breadcrumb_args', 'tti_breadcrumb_args' );

function tti_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	// $args['labels']['prefix'] = '<span class="bc"></span>';
	$args['labels']['author'] = '';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['search'] = 'Search for ';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'Nothing to show '; // Genesis 1.5 and later
return $args;
}
