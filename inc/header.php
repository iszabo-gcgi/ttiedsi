<?php
/**
 * Header
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

remove_action( 'genesis_header',        'genesis_header_markup_open',         5 );
remove_action( 'genesis_header',        'genesis_do_header'                     );
remove_action( 'genesis_header',        'genesis_header_markup_close',       15 );

// Site Pre Header + Markup Open
function tti_header_markup_open () { ?>
	<div class="topbar">
		<div class="site-search">
			<?php include(locate_template('searchform.php')); ?>
		</div>
		<?php echo wp_nav_menu( array( 'menu' => 'menu-utility', 'theme_location' => 'utility-bar', 'menu_class' => 'topnav utility' ) ); ?>
	</div>

	<header class="site-header">
		<div class="wrap">
			<div class="title-area">

<?php
}
add_action( 'genesis_header', 'tti_header_markup_open');

/**
 *	Logo (SVG) as Site Image
 *
 *	Display inline logo.svg
**/
function tti_site_image() {
	$site_image = '/wp-content/themes/ttibase/assets/images/ttilogo.svg';
	printf( '<div class="site-logo"><a class="logo-link" href="https://tti.tamu.edu"><img class="logo" src="%s" alt="TTI Logo" /></a></div>', $site_image );
}
add_action( 'genesis_header', 'tti_site_image' );

// Site Header
function tti_do_header() {
	$titlewrap = is_front_page() ? '<h1>' . get_bloginfo('name') . '</h1>' : '<p>' . get_bloginfo('name') . '</p>'; ?>

	    <div class="site-title">
	    	<a href="<?php print get_bloginfo( 'url' ); ?>"><?= $titlewrap ?></a>
	    </div>
<?php
}
add_action( 'genesis_header', 'tti_do_header');


// Site Header Markup Close
function tti_header_markup_close () { ?>
			</div>
		</div>
	</header>
<?php
}
add_action( 'genesis_header', 'tti_header_markup_close');

