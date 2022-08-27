<?php
/**
 * Taxonomy Archive
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

//  Archive header for tax term

function tti_tax_term_archive_title_bar() {
  if ( is_tax() ) :
    $term = get_queried_object();
    $tax = get_taxonomy( $term->taxonomy ); ?>

    <div class="taxonomy-title-bar">
      <div class="tax-and-term-title archive-title">
        <div class="tax-title"><?php echo $tax->label; ?></div>
        <div class="term-title"><?php echo $term->name; ?></div>
    </div>
  </div>
  <?php endif;
}
add_action( 'genesis_before_content', 'tti_tax_term_archive_title_bar', 8 );

function tti_taxonomy_title_description_markup_before() {
  echo '<div class="tax-archive-header">';
}
add_action( 'genesis_before_content', 'tti_taxonomy_title_description_markup_before', 9 );
add_action( 'genesis_before_content', 'genesis_do_taxonomy_title_description' );

function tti_taxonomy_title_description_markup_after() {
  echo '</div>';
}
add_action( 'genesis_before_content', 'tti_taxonomy_title_description_markup_after', 11 );

// Build the page using the archive template
require get_stylesheet_directory() . '/archive.php';
