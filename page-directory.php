<?php
/**
 * Template Name: Directory page
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default page header
remove_action( 'genesis_entry_header',  'genesis_do_post_title'                 );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_open',  5  );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_close', 15 );

// Add page header for theme
add_action( 'genesis_after_header', 'tti_do_title_header' );
function tti_do_title_header() { ?>
	<div class="page-title-container">
		<h1><?php the_title(); ?></h1>
	</div>
<?php
}

genesis();
