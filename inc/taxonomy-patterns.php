<?php
/**
 * Taxonomy block patterns
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/


add_action( 'init', 'tti_cts_taxonomy_block_patterns' );
/**
 * Add Work Zone Data block pattern
 *
 * @since 1.0
 */
function tti_cts_taxonomy_block_patterns() {

    register_block_pattern(
        'taxonomy-header/header-hero-cover',
        array(
            'title'       => __( 'Taxonomy Header Cover', 'taxonomy-header' ),

            'description' => _x( 'A full width cover image with text', '', 'taxonomy-header' ),

            'content'     => "<!-- wp:cover {\"customOverlayColor\":\"#ffffff\",\"contentPosition\":\"center center\",\"isDark\":false,\"align\":\"full\"} -->\n<div class=\"wp-block-cover alignfull is-light\"><span aria-hidden=\"true\" class=\"has-background-dim-100 wp-block-cover__gradient-background has-background-dim\" style=\"background-color:#ffffff\"></span><div class=\"wp-block-cover__inner-container\"><!-- wp:media-text {\"mediaPosition\":\"right\",\"mediaLink\":\"https://s.w.org/images/core/5.8/soil.jpg\",\"mediaType\":\"image\",\"mediaWidth\":56,\"verticalAlignment\":\"center\",\"imageFill\":true,\"focalPoint\":{\"x\":0.5,\"y\":\"0.50\"}} -->\n<div class=\"wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile is-vertically-aligned-center is-image-fill\" style=\"grid-template-columns:auto 56%\"><figure class=\"wp-block-media-text__media\" style=\"background-image:url(https://s.w.org/images/core/5.8/soil.jpg);background-position:50% 50%\"><img src=\"https://s.w.org/images/core/5.8/soil.jpg\" alt=\"Close-up of dried, cracked earth.\"/></figure><div class=\"wp-block-media-text__content\"><!-- wp:heading {\"level\":1,\"style\":{\"typography\":{\"fontSize\":\"32px\"},\"color\":{\"text\":\"#000000\"}}} -->\n<h1 class=\"has-text-color\" style=\"color:#000000;font-size:32px\"><strong>Analyze and Advance</strong></h1>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"17px\"},\"color\":{\"text\":\"#000000\"}}} -->\n<p class=\"has-text-color\" style=\"color:#000000;font-size:17px\">We analyze data and information using a broad spectrum of methodologies and innovative approaches. Outputs serve to advance safety science and knowledge to improve the safety and well-being of transportation system users.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"backgroundColor\":\"lightgrey\",\"textColor\":\"maroon\",\"className\":\"is-style-fill\"} -->\n<div class=\"wp-block-button is-style-fill\"><a class=\"wp-block-button__link has-maroon-color has-lightgrey-background-color has-text-color has-background\">See Projects</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div></div>\n<!-- /wp:media-text --></div></div>\n<!-- /wp:cover -->",

            'categories'  => array( 'featured', 'cts-patterns' ),
        )
    );
}

// add_action( 'init', 'tti_cts_home_section_block_patterns' );
/**
 * Register New Work Zone Pattern Category
 *
 * @since 1.0
 */
/*function tti_cts_home_section_block_patterns() {
    register_block_pattern_category(
        'cts-patterns',
        array(
            'label'     => __( 'CTS Patterns', 'genesis-sample' ),
        )
    );
}*/

// add_action( 'init', 'tti_unregister_my_pattern_categories' );
/**
 * Unregister Unused Pattern Categories.
 *
 * @since 1.0
 */
/*function tti_unregister_my_pattern_categories() {
    unregister_block_pattern_category( 'buttons' );
    unregister_block_pattern_category( 'columns' );
    unregister_block_pattern_category( 'gallery' );
    unregister_block_pattern_category( 'header' );
    unregister_block_pattern_category( 'query' );
    unregister_block_pattern_category( 'text' );
}*/
