<?php
/**
 * Footer
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

remove_action( 'genesis_footer',        'genesis_do_footer'                     );

// Site Pre Footer
// add_action( 'genesis_before_footer', 'tti_footer_widget_areas' );
add_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

function tti_footer_widget_areas() {
	if ( is_front_page() ) : ?>
	<section id="reach-us" name="reach-us" class="flexible-widgets widget-area widget-halves">
		<div class="title-container"><h2>Reach Us</h2></div>
		<div class="wrap">

			<div class="footer-widget">
				<div class="addresses">
				<p><span class="contact-person">Bill Eisele</span> <br />
					Division Head </br />
					(979) 317-2461 <br />
					<a href="mailto:b-eisele@tti.tamu.edu">b-eisele@tti.tamu.edu</a></p>

				<h3>Physical Address</h3>
					<p>Texas A&amp;M Transportation Institute </br />
					1111 RELLIS <br />
					Bryan, Texas 77807</p>

				<h3>Mailing Address</h3>
					<p>Texas A&amp;M Transportation Institute </br />
					3135 TAMU <br />
					College Station, Texas 77843-3135 </p>
				</div>
			</div>
			<div class="footer-widget"> <?php
				gravity_form( 1, false, false, false, '', false ); ?>
			</div>
		</div>
	</section>
	<?php endif;
}


// Site Footer
add_action( 'genesis_footer', 'tti_do_footer' );

function tti_do_footer() {
	// Check for transient.
	if ( false === ( $footerObject = get_transient( 'footer_object' ) ) ) {
		// Get footer data from tti.tamu.edu api.
		$footerData = wp_remote_get( 'https://tti.tamu.edu/wp-json/wp/v2?action=footer&api=true' );

		// Decode response body json.
		$footerObject = json_decode( $footerData['body'] );

		// Put the results in a transient. Expire after 12 hours.
		set_transient( 'footer_object', $footerObject, 12 * HOUR_IN_SECONDS );
	}

	// echo html.
	?>
	<footer class="site-footer" itemscope="" itemtype="https://schema.org/WPFooter">
		<div class="wrap">
			<?php echo $footerObject->footer; ?>
		</div>
	</footer>
	<?php
}