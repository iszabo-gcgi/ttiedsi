<?php
/**
 * Template Name: News Archive
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'tti_add_post_archive' );
function tti_add_post_archive() {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$args = array(
		'post_type' => 'post',
		'category_name'=> 'featured-story,featured-research,news-releases',
		// 'posts_per_page' => '4',
		// 'paged' => $paged
	);

	$query = new WP_Query( $args );

	//set our query's pagination to $paged
	$query -> query('post_type=post&posts_per_page=5'.'&paged='.$paged);

	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		?>
		<article class="post-summary">
			<div class="featured-image">
				<?php the_post_thumbnail(); ?>
			</div><!-- end .featured-image -->
			<div class="post-body">
				<?php echo '<div class="post-date">';
				the_time( 'F j, Y' );
				echo '</div>'; ?>
				<heading class="entry-header">
					<h2 class="entry-title">
						<a href="<?php echo the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>
				</heading>

				<div class="entry-content">
					<?php 
					echo '<div class="post-excerpt"><p>';
					echo wp_strip_all_tags(get_the_excerpt());
					echo '&nbsp;&nbsp;<a href="' . get_the_permalink() . '">Read&nbsp;More</a>' . '</p></div>';
					echo '<div class="post-author">' . get_the_author() . '</div>'; ?>
					<div class="post-tags">
						<?php the_tags(' '); ?>
					</div>
				</div> 
			</div><!-- end .post-body -->

				<?php 
		
		echo '</article>';
		?>

		<?php 
	endwhile;

	//pass in the max_num_pages, which is total pages 
	?>
  <div class="pagenav">
    <div class="alignleft"><?php previous_posts_link('Newer Stories', $query->max_num_pages) ?></div>
    <div class="alignright"><?php next_posts_link('Earlier Stories', $query->max_num_pages) ?></div>
  </div>
  <?php 
	wp_reset_postdata();
	endif;

	$query = null; $query = $temp; 

	//tti_archive_loop();
}



genesis();