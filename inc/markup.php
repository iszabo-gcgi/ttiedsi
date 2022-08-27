<?php
/**
 * Markup
 *
 * @package      Mobility (TTIStarter)
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Add '.nav-menu' class to nav menus
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function tti_nav_menu_class( $open, $args ) {
	$open = str_replace( $args['context'], $args['context'] . ' nav-menu', $open );
	return $open;
}
add_filter( 'genesis_markup_nav-primary_open', 'tti_nav_menu_class', 10, 2 );
add_filter( 'genesis_markup_nav-secondary_open', 'tti_nav_menu_class', 10, 2 );

/**
 * Change '.content-sidebar-wrap' to '.content-area'
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function tti_change_content_sidebar_wrap( $attributes ) {
	$attributes['class'] = 'content-area';
	return $attributes;
}
add_filter( 'genesis_attr_content-sidebar-wrap', 'tti_change_content_sidebar_wrap' );

/**
 * Change '.content' to '.site-main'
 *
 * @param string $open, opening markup
 * @param array $args, markup args
 * @return string
 */
function tti_change_content( $attributes ) {
	$attributes['class'] = 'site-main';
	return $attributes;
}
add_filter( 'genesis_attr_content', 'tti_change_content' );

/**
 * Add #main-content to .site-inner
 *
 */
function tti_site_inner_id( $attributes ) {
	$attributes['id'] = 'main-content';
	return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'tti_site_inner_id' );

/**
 * Remove padding from .site-inner
 *
 */
function tti_site_inner_no_padding( $attributes ) {
	$attributes['class'] .= ' full';
	return $attributes;
}
//add_filter( 'genesis_attr_site-inner', 'tti_site_inner_no_padding' );

/**
 * Change skip link to #main-content
 *
 */
function tti_main_content_skip_link( $skip_links ) {

	$old = $skip_links;
	$skip_links = array();

	foreach( $old as $id => $label ) {
		if( 'genesis-content' == $id )
			$id = 'main-content';
		$skip_links[ $id ] = $label;
	}

	return $skip_links;
}
add_filter( 'genesis_skip_links_output', 'tti_main_content_skip_link' );

/**
 * Archive Description markup
 *
 */
function tti_archive_description_markup( $markup ) {
	return str_replace( array( '<div', '</div' ), array( '<header', '</header' ), $markup );
}
add_filter( 'genesis_markup_posts-page-description_open', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_posts-page-description_close', 'tti_archive_description_markup' );
// add_filter( 'genesis_markup_taxonomy-archive-description_open', 'tti_archive_description_markup' );
// add_filter( 'genesis_markup_taxonomy-archive-description_close', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_author-archive-description_open', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_author-archive-description_close', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_cpt-archive-description_open', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_cpt-archive-description_close', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_date-archive-description_open', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_date-archive-description_close', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_search-description_open', 'tti_archive_description_markup' );
add_filter( 'genesis_markup_search-description_close', 'tti_archive_description_markup' );

/**
 * Archive Pagination markup
 *
 */
function tti_archive_pagination_markup( $markup ) {
	return str_replace( array( '<div', '</div' ), array( '<nav', '</nav' ), $markup );
}
add_filter( 'genesis_markup_archive-pagination_open', 'tti_archive_pagination_markup' );
add_filter( 'genesis_markup_archive-pagination_close', 'tti_archive_pagination_markup' );

/**
 * Archive Header Classes
 *
 */
function tti_archive_header_classes( $attributes ) {
	$attributes['class'] = 'page-title-container archive-description';
	return $attributes;
}
add_filter( 'genesis_attr_posts-page-description', 'tti_archive_header_classes' );
add_filter( 'genesis_attr_author-archive-description', 'tti_archive_header_classes' );
add_filter( 'genesis_attr_cpt-archive-description', 'tti_archive_header_classes' );
add_filter( 'genesis_attr_date-archive-description', 'tti_archive_header_classes' );

/**
 * Taxonomy Header Classes
 *
 */
function tti_taxonomy_header_classes( $attributes ) {
  $attributes['class'] = 'page-title-container taxonomy-description';
  return $attributes;
}
add_filter( 'genesis_attr_taxonomy-archive-description', 'tti_taxonomy_header_classes' );

/**
 * Search Header Classes
 *
 */
function tti_search_header_classes( $attributes ) {
	$attributes['class'] = 'page-title-container archive-description search-description';
	return $attributes;
}
add_filter( 'genesis_attr_search-description', 'tti_search_header_classes' );
