<?php
/**
 * Template Name: Landing
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default Genesis elements
remove_action( 'genesis_header',        'genesis_header_markup_open',         5 );
remove_action( 'genesis_header',        'genesis_do_header'                     );
remove_action( 'genesis_header',        'genesis_header_markup_close',       15 );
remove_action( 'genesis_after_header',  'genesis_do_nav'                        );
remove_action( 'genesis_after_header',  'genesis_do_subnav'                     );
remove_action( 'genesis_before_loop',   'genesis_do_breadcrumbs'                );
remove_action( 'genesis_entry_header',  'genesis_do_post_title'                 );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_open',  5  );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas'           );
remove_action( 'genesis_before_footer', 'tti_footer_widget_areas' );
remove_action( 'genesis_footer',        'genesis_footer_markup_open',         5 );
remove_action( 'genesis_footer',        'genesis_do_footer'                     );
remove_action( 'genesis_footer',        'genesis_footer_markup_close',       15 );

genesis();
