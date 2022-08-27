<?php
/**
 * TTI Main child theme - API Functionality
 *
 * @package      TTI_main_child
 * @since        3.0.0
 * @copyright    Copyright (c) 2013, Jared Atchison
 * @license      GPL-2.0+
 */

/*------------------------------------------------------------------------------
	This file contains API functions
------------------------------------------------------------------------------*/

/**
 * Returns JSON for the API
 *
 * @since 3.0.0
 */
function tti_api_wrapper() {

	if ( isset( $_GET['api'] ) ) {
		$is_api = sanitize_text_field( $_GET['api'] );
	} else {
		$is_api = false;
	}
	if ( isset( $_GET['action']) ) {
		$action = sanitize_text_field( $_GET['action'] );
	} else {
		$action = false;
	}

	// Only run if we trigger the API parameters
	if ( ! $is_api || $is_api != 'true' )
		return;

	// json header
	header('content-type: application/json; charset=utf-8');
	$json = '';


	// Site footer -----------------------------------------------------------*/

	if ( $action && $action == 'footer' ) :
		$output  = '<div class="links">';

		$output .= wp_nav_menu( array( 'theme_location' => 'menu-footer', 'container' => false, 'depth' => 1, 'echo' => false ) );
		$output .= '</div>';
		$output .= '<div class="bottom">';

		$footer  = get_option( 'options_tti_site_footer' );
		if ( false !== strpos($footer, '[year]') ) {
			$year = Date('Y');
			$footer = str_replace( '[year]', $year, $footer );
			$output .= $footer;
		} else {
			$output .= get_option( 'options_tti_site_footer' );
		}

		$output .= '</div>';
		$json = array( 'footer' => $output );
		$json = json_encode( $json );
	endif;


	// Groups, right sidebar images -------------------------------------------*/

	if ( $action  && $action == 'researcher-overview' ) :
		$researcher = get_option( 'options_tti_researcher_image' );
		$overview   = get_option( 'options_tti_overview_image'   );

		if ( $researcher ) {
			$url = wp_get_attachment_image_src( $researcher, 'full' );
			$researcher = $url[0];
		}
		if ( $overview ) {
			$url = wp_get_attachment_image_src( $overview, 'full' );
			$overview = $url[0];
		}
		$output = array(
			'researcher' => $researcher,
			'overview'   => $overview,
		);
		$json = json_encode( $output );
	endif;

	// Featured Projects -----------------------------------------------------*/

	if ( $action && $action == 'featured-projects' ) :

		$limit    = ( ! empty( $_GET['limit'] ) ? intval( $_GET['limit'] ) : '-1' );
		$sort = sanitize_text_field( $_GET['sort'] );
		$term = sanitize_text_field( $_GET['term'] );

		$projects = array();

		if ( isset( $sort ) && isset( $_GET['term'] ) ) {
			if ( $sort  == 'program' ) { $tax = 'program-codes'; }
			if ( $sort  == 'sponsor' ) { $tax = 'sponsors'; }
			if ( $sort  == 'category' ) { $tax = 'project-categories'; }

			$featured_projects_args = array (
				'posts_per_page' => $limit,
				'post_type'      => 'enhanced-project',
				'tax_query' => array(
					array(
						'taxonomy' => $tax,
						'field'    => 'slug',
						'terms'    => $term,
					)
				),
			);
		} else {
			$featured_projects_args = array (
			 	'posts_per_page' => $limit,
			 	'post_type'      => 'enhanced-project',
			 );
		}

		$featured_projects = new WP_Query( $featured_projects_args );
		while( $featured_projects->have_posts() ) : $featured_projects->the_post();

			$featured_image_id = get_post_thumbnail_id( get_the_ID() );
			$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'thumbnail' );
			$featured_image_url = $featured_image_url[0];

			$details = array(
				'title'      			=> get_the_title(),
				'url'        			=> get_permalink(),
				'excerpt'    			=> get_the_excerpt(),
				'full_title' 			=> get_post_meta( get_the_ID(), 'full_title',     true ),
				'number'     			=> get_post_meta( get_the_ID(), 'project_number', true ),
				'sponsors'				=> get_the_terms( get_the_ID(), 'sponsors' ),
				'program-codes' 		=> get_the_terms( get_the_ID(), 'program-codes' ),
				'project-categories'	=> get_the_terms( get_the_ID(), 'project-categories' ),
				'featuredimageurl' 	=> $featured_image_url
			);
			$projects[] = $details;

		endwhile;
		wp_reset_query();
		$json = json_encode( $projects );
	endif;


	// Posts (for embedding in group sites) -----------------------------------------------------*/

	if ( $action && $action == 'program-posts' ) :

		$limit = ( ! empty( $_GET['limit'] ) ? intval( $_GET['limit'] ) : '-1' );
		$program = sanitize_text_field( $_GET['program'] );
		$category = sanitize_text_field( $_GET['category'] );
		$tag = sanitize_text_field( $_GET['tag'] );

		$program_posts = array();

		if ( isset( $program ) || isset( $category ) || isset( $tag ) ) {

			if ( $program ) {
				$tax = 'program-codes';
				$term = esc_html( $program );
			}

			if ( $category ) {
				$tax = 'category';
				$term = esc_html( $category );
			}

			if ( $tag ) {
				$tax = 'post_tag';
				$term = esc_html( $tag );

				if ( strpos( $term, ',' ) != false ) {
					$term = explode( ',', $term );
				}
			}


			$posts_args = array (
				'posts_per_page' => $limit,
				'post_type'      => 'post',
				'tax_query' => array(
					array(
						'taxonomy' => $tax,
						'field'    => 'slug',
						'terms'    => $term,
					)
				),
			);
		} else {
			$posts_args = array (
			 	'posts_per_page' => $limit,
			 	'post_type'      => 'post',
			 );
		}

		$posts_for_embed = new WP_Query( $posts_args );
		while( $posts_for_embed->have_posts() ) : $posts_for_embed->the_post();

			$featured_image_id = get_post_thumbnail_id( get_the_ID() );
			$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'thumbnail' );
			$featured_image_url = $featured_image_url[0];

			$details = array(
				'title'      			=> get_the_title(),
				'url'        			=> get_permalink(),
				'excerpt'    			=> get_the_excerpt(),
				'content'				=> apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) ),
				'program-codes' 		=> get_the_terms( get_the_ID(), 'program-codes' ),
				'categories'			=> get_the_terms( get_the_ID(), 'category' ),
				'tags'					=> get_the_terms( get_the_ID(), 'post_tag' ),
				'featuredimageurl' 		=> $featured_image_url,
				'timestamp'	=> strtotime(get_the_date('Y-m-d H:i:s.u'))
			);
			$program_posts[] = $details;

		endwhile;
		wp_reset_query();
		$json = json_encode( $program_posts );
	endif;








	// Facilities (for embedding in group sites) -----------------------------------------------------*/

	if ( $action && $action == 'facilities' ) :

		$limit  = ( ! empty( $_GET['limit'] ) ? intval( $_GET['limit'] ) : '-1' );
		$program = sanitize_text_field( $_GET['program'] );
		$category = sanitize_text_field( $_GET['category'] );
		$tag = sanitize_text_field( $_GET['tag'] );
		$location = sanitize_text_field( $_GET['location'] );
		$researchareas = sanitize_text_field( $_GET['research-areas'] );

		$facilities_posts = array();

		if ( $program ||  $category || $tag || $location || $researchareas ) {

			if ( $location ) {
				$tax = 'location';
				$term = esc_html( $location );
			}

			if ( $researchareas ) {
				$tax = 'research-areas';
				$term = esc_html( $researchareas );
			}

			if ( $program ) {
				$tax = 'codes';
				$term = esc_html( $program );
			}

			if ( $category ) {
				$tax = 'category';
				$term = esc_html( $category );
			}

			if ( $tag ) {
				$tax = 'post_tag';
				$term = esc_html( $tag );
			}

			if ( strpos( $term, ',' ) !== false ) {
				$term = explode( ',', $term );
			}

			$facilities_args = array (
				'posts_per_page' => $limit,
				'post_type'      => 'tti-facility',
				'tax_query' => array(
					array(
						'taxonomy' => $tax,
						'field'    => 'slug',
						'terms'    => $term,
					)
				),
			);
		} else {
			$facilities_args = array (
			 	'posts_per_page' => $limit,
			 	'post_type'      => 'tti-facility',
			 );
		}

		$facilities_for_embed = new WP_Query( $facilities_args );
		while( $facilities_for_embed->have_posts() ) : $facilities_for_embed->the_post();

			$featured_image_id = get_post_thumbnail_id( get_the_ID() );
			$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'thumbnail' );
			$featured_image_url = $featured_image_url[0];

			$location_list = get_the_terms( get_the_ID(), 'location' );
			if ( is_array($location_list) ) {
				$location_name = $location_list[0]->name;
			} else {
				$location_name = '';
			}

			$research_areas_list = get_the_terms( get_the_ID(), 'research-areas' );
			$research_areas_names = '';
			if ( is_array($research_areas_list) ) {
				foreach($research_areas_list as $research_area) {
					$research_areas_names .= $research_area->name . ', ';
				}
				$research_areas_names = rtrim($research_areas_names, ', ');
			}

			$program_code_list = get_the_terms( get_the_ID(), 'codes' );
			$program_code_names = '';
			if ( is_array($program_code_list) ) {
				foreach($program_code_list as $program_code) {
					$program_code_names .= $program_code->name . ', ';
				}
				$program_code_names = rtrim($program_code_names, ', ');
			}

			$details = array(
				'title'      			=> get_the_title(),
				'url'        			=> get_permalink(),
				'excerpt'    			=> get_the_excerpt(),
				'content'				=> apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) ),
				'program-codes'		=> $program_code_names,
				'location'				=> $location_name,
				'research-area'	=> $research_areas_names,
				'featuredimageurl' => $featured_image_url,
			);
			$facilities_posts[] = $details;

		endwhile;
		wp_reset_query();
		$json = json_encode( $facilities_posts );
	endif;


	// Return and die
	echo $json;
	die();
}
add_action( 'init', 'tti_api_wrapper' );



/* Main non-Oracle-connected API for TTI  */

function get_auth_header( $args = array() ) {
	$args['headers']['Authorization'] = 'Basic ' . base64_encode( TTI_API_USER . ':' . TTI_API_PASS );
	return $args;
}

function ttiAPI2( $service ) {
	$rest_site = 'https://api.tti.tamu.edu';
	//$rest_site = 'https://api-stage.tti.tamu.edu/';
	$args = get_auth_header( array() );

	$timeout = get_option('tti_api_timeout_seconds');
	if (empty($timeout)) {
		$timeout = 30;
	}

	$args['timeout'] = $timeout;

	$api_response = wp_remote_get( $rest_site . $service, $args );
	if ( isset($api_response) && ! is_wp_error($api_response) ) {
		return $api_response['body'];
	} else {
		return NULL;
	}
}