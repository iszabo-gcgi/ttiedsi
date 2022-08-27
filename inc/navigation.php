<?php
/**
 * Navigation
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/*remove_action( 'genesis_after_header',  'genesis_do_subnav' );
add_action( 'genesis_before_header',  'tti_do_subnav' );
function tti_do_subnav() { ?>
	<div class="topbar">
		<div class="site-search">
			<?php include(locate_template('searchform.php')); ?>
		</div>
		<?php echo wp_nav_menu( array( 'theme_location' => 'utility', 'container_class' => 'topnav' ) ); ?>
	</div>
	<?php
}*/

remove_action( 'genesis_after_header',  'genesis_do_nav' );
//	Primary Nav in Header
function tti_do_nav() {
    echo '<nav class="nav-primary" aria-label="Main" itemscope itemtype="https://schema.org/SiteNavigationElemnt" id="genesis-nav-primary">';
        echo wp_nav_menu( array( 'menu' => 'primary') );
        echo tti_mobile_menu_close();
    echo '</nav>';
}
add_action( 'genesis_header', 'tti_do_nav', 12 );

//	Mobile Menu
function tti_mobile_menu() {
	echo '<div class="topbar-mobile">';
	echo '<nav class="nav-mobile">';
		echo '<button class="mobile-menu-toggle">';
			echo tti_icon( array( 'icon' => 'menu', 'size' => 14, 'class' => 'menu-open' ) );
			echo '<span class="screen-reader-text">Menu</span>';
		echo '</button>';
	echo '</nav>';
	echo '</div>';
}
add_action( 'genesis_before_header', 'tti_mobile_menu', 11 );

function tti_mobile_menu_close() {
		echo '<button class="mobile-menu-toggle">';
			echo tti_icon( array( 'icon' => 'close', 'size' => 14, 'class' => 'menu-close' ) );
			echo '<span class="screen-reader-text">Close</span>';
		echo '</button>';
}

/**
 * Automatically adds `<nav-menu-item-label>` class to nav menu items.
 *
 * @param array  $classes Nav menu item classes.
 * @param object $item Nav menu item data object.
 * @param array  $args Nav menu arguments.
 */
function custom_add_item_label_as_class( $classes, $item, $args ) {
	$classes[] = sanitize_title_with_dashes( $item->title );

	return $classes;
}
add_filter( 'nav_menu_css_class', 'custom_add_item_label_as_class', 10, 3 );

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function tti_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = tti_icon( array( 'icon' => 'navigate-down', 'size' => 16 ) );

		$output .= sprintf(
			'<span class="submenu-expand" tabindex="-1">%s</span>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'tti_nav_add_dropdown_icons', 10, 4 );
