<?php
/**
 * Search result partial
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

echo '<article class="search-result">';

	echo '<header class="entry-header">';
		echo '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
		echo '<a class="url" href="' . get_permalink() . '">' . get_permalink() . '</a>';
	echo '</header>';

	echo '<div class="entry-content">';
		the_post_thumbnail();
		$excerpt = get_the_excerpt();
		if( empty( $excerpt ) )
			$excerpt = get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true );
		if( !empty( $excerpt ) )
			echo apply_filters( 'the_excerpt', $excerpt );
	echo '</div>';

echo '</article>';
