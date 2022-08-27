<?php
/**
 * Archive
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_before_loop',   'genesis_do_breadcrumbs'                );
// add_action( 'genesis_after_header',   'genesis_do_breadcrumbs', 15                );

/**
 * Fires at end of doing taxonomy archive title and description.
 *
 * Allows you to reorganize output of the archive headings.
 *
 * @since 2.5.0
 *
 * @param string $heading    Archive heading.
 * @param string $intro_text Archive intro text.
 * @param string $context    Context.
 *
 *	EXAMPLE:
 *	do_action( 'genesis_archive_title_descriptions', $heading, $intro_text,
 *	'taxonomy-archive-description' );
 */

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description' );
remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );

if ( !is_post_type_archive('project') ) :
  // add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description' );
  add_action( 'genesis_after_header', 'genesis_do_cpt_archive_title_description' );
  add_action( 'genesis_after_header', 'genesis_do_author_title_description' );
  add_action( 'genesis_after_header', 'genesis_do_date_archive_title' );
  // add_action( 'genesis_after_header', 'genesis_do_blog_template_heading' );
  add_action( 'genesis_after_header', 'genesis_do_posts_page_heading' );
endif;



/**
 * Blog Archive Body Class
 *
 */
function tti_blog_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'tti_blog_archive_body_class' );

// // Add custom headline and / or description on category / tag / taxonomy archive pages
add_action( 'genesis_after_header', 'tti_do_project_archive_title' );

function tti_do_project_archive_title() {
  if ( is_post_type_archive('project') ):
  	do_action( 'genesis_archive_title_descriptions', 'Projects', false, 'cpt-archive-description' );
  endif;
}

/**
 * Default Descriptions for Term Archives
 *
 * @author Bill Erickson
 * @see http://www.billerickson.net/default-category-and-tag-titles
 *
 * @param string $value
 * @param int $term_id
 * @param string $meta_key
 * @param bool $single
 * @return string $vlaue
 */
function ea_default_term_description( $value, $term_id, $meta_key, $single ) {

  if( ( is_category() || is_tag() || is_tax() ) && 'intro_text' == $meta_key && ! is_admin() ) {

    // Grab the current value, be sure to remove and re-add the hook to avoid infinite loops
    remove_action( 'get_term_metadata', 'ea_default_term_description', 10 );
    $value = get_term_meta( $term_id, 'intro_text', true );
    add_action( 'get_term_metadata', 'ea_default_term_description', 10, 4 );

    // Use term description if empty
    if( empty( $value ) ) {
      $term = get_queried_object();
      $value = $term->description;
    }

  }

  return $value;
}
add_filter( 'get_term_metadata', 'ea_default_term_description', 10, 4 );


/**
 * Default Titles for Term Archives
 *
 * @author Bill Erickson
 * @see http://www.billerickson.net/default-category-and-tag-titles
 *
 * @param string $value
 * @param int $term_id
 * @param string $meta_key
 * @param bool $single
 * @return string $vlaue
 */
/*function ea_default_term_title( $value, $term_id, $meta_key, $single ) {

  if( ( is_category() || is_tag() || is_tax() ) && 'headline' == $meta_key && ! is_admin() ) {

    // Grab the current value, be sure to remove and re-add the hook to avoid infinite loops
    remove_action( 'get_term_metadata', 'ea_default_term_title', 10 );
    $value = get_term_meta( $term_id, 'headline', true );
    add_action( 'get_term_metadata', 'ea_default_term_title', 10, 4 );

    // Use term name if empty
    if( empty( $value ) ) {
      $term = get_queried_object();
      $value = $term->name;
    }

  }

  return $value;
}
add_filter( 'get_term_metadata', 'ea_default_term_title', 10, 4 );*/


genesis();
