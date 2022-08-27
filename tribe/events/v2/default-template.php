<?php
/**
 * View: Default Template for Events
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/default-template.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 */

use Tribe\Events\Views\V2\Template_Bootstrap;

get_header();

genesis_markup(
  [
    'open'    => '<div %s>',
    'context' => 'content-sidebar-wrap',
  ]
);

// tribe_get_template_part( 'modules/bar' );
?><div class="archive-events-top-bar">
    <a class="submit-an-event" href="<?php echo get_bloginfo( 'url' ); ?>/submit-event/">Submit An Event</a>
  </div><?php
genesis_markup(
  [
    'open'    => '<main %s>',
    'context' => 'content',
  ]
);

echo tribe( Template_Bootstrap::class )->get_view_html();

genesis_markup(
  [
    'close'   => '</main>',
    'context' => 'content',
  ]
);

if ( ! isset( $tti_sidebars_registered_widgets ) ) {
  $tti_sidebars_registered_widgets = wp_get_sidebars_widgets();
  if ( ! $tti_sidebars_registered_widgets['event_list'] ) {
    global $wp_registered_sidebars;
    $tti_default_events_widget_class = new Tribe\Events\Pro\Views\V2\Widgets\Widget_Month();
    $tti_default_events_widget_arguments = $tti_default_events_widget_class->get_default_arguments();
    // Output standard sidebar content with the default events calendar widget.
    do_action( 'dynamic_sidebar_before', 1, true );
    echo $wp_registered_sidebars['event_list']['before_sidebar'];
    the_widget( 'Tribe\Events\Pro\Views\V2\Widgets\Widget_Month', $tti_default_events_widget_arguments, $tti_default_events_widget_arguments );
    echo $wp_registered_sidebars['event_list']['after_sidebar'];
    do_action( 'dynamic_sidebar_after', 1, true );
    unset( $tti_default_events_widget_class );
    unset( $tti_default_events_widget_arguments );
  }
  unset( $tti_sidebars_registered_widgets );
}
dynamic_sidebar( 'event_list' );

genesis_markup(
  [
    'close'   => '</div>',
    'context' => 'content-sidebar-wrap',
  ]
);

get_footer();
