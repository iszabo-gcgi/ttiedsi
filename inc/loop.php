<?php
/**
 * Loop
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Use Archive Loop
 *
 */
function tti_use_archive_loop() {

	if( ! is_singular() && ! is_404() ) {
		add_action( 'genesis_loop', 'tti_archive_loop' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}
add_action( 'template_redirect', 'tti_use_archive_loop', 20 );

/**
 * Archive Loop
 * Uses template partials
 */
function tti_archive_loop() {

	if ( have_posts() ) {

		do_action( 'genesis_before_while' );

		while ( have_posts() ) {

			the_post();
			do_action( 'genesis_before_entry' );

			// Template part
			$partial = apply_filters( 'tti_loop_partial', 'archive' );
			$context = apply_filters( 'tti_loop_partial_context', is_search() ? 'search' : get_post_type() );
			get_template_part( 'partials/' . $partial, $context );

			do_action( 'genesis_after_entry' );

		}

		do_action( 'genesis_after_endwhile' );

	} else {

		do_action( 'genesis_loop_else' );

	}
}
