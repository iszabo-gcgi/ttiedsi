<?php
/**
 * Search Results
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Search header
 *
 */
function tti_search_header() {
	do_action( 'genesis_archive_title_descriptions', 'Search Results', get_search_form( false ), 'search-description' );
}
add_action( 'genesis_after_header', 'tti_search_header' );

// Add custom headline and / or description on category / tag / taxonomy archive pages
// add_action( 'genesis_after_header', 'tti_genesis_archive_title_descriptions_opening_wrap' );
// add_action( 'genesis_after_header', 'tti_search_header' );
// add_action( 'genesis_after_header', 'tti_genesis_archive_title_descriptions_closing_wrap' );

// function tti_genesis_archive_title_descriptions_opening_wrap() {
// 	echo '<div class="page-title-container">';
// }

// function tti_genesis_archive_title_descriptions_closing_wrap() {
// 	echo '</div>';
// }

// Build the page using the archive template
require get_stylesheet_directory() . '/archive.php';
