<?php
/**
 * Widget: Events List Event Venue
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/widgets/widget-events-list/event/venue.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.2.1
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

use Tribe__Date_Utils as Dates;

/*
 * If the request date is after the event start date, show the request date to avoid users from seeing dates "in the
 * past" in relation to the date they requested (or today's date).
 */
$display_date = empty( $is_past ) && ! empty( $request_date )
	? max( $event->dates->start_display, $request_date )
	: $event->dates->start_display;

$event_month     = $display_date->format_i18n( 'M' );
$event_day_num   = $display_date->format_i18n( 'j' );
$event_day_year  = $display_date->format_i18n( 'Y' );
$event_date_attr = $display_date->format( Dates::DBDATEFORMAT );

// Get the event category.
$event_categories = tribe_get_event_categories(
    $event->ID,
    [
        'before'       => '',
        'sep'          => ', ',
        'after'        => '',
        'label'        => '', // An appropriate plural/singular label will be provided
        'label_before' => '',
        'label_after'  => '',
        'wrap_before'  => '',
        'wrap_after'   => '',
    ]
);
$event_categories = preg_replace('/:/', '', $event_categories, 1);
$event_categories = preg_replace('/,.*$/', '', $event_categories, 1);
?>
<div class="tribe-events-widget-events-list__event-date-tag tribe-common-g-col">
	<time class="tribe-events-widget-events-list__event-date-tag-datetime" datetime="<?php echo esc_attr( $event_date_attr ); ?>">
		<span class="tribe-events-widget-events-list__event-date-tag-datetime-wrap">
            <span class="tribe-events-widget-events-list__event-date-tag-daynum tribe-common-h2 tribe-common-h4--min-medium">
                <?php echo esc_html( $event_day_num ); ?>
            </span>
            <span class="tribe-events-widget-events-list__event-date-tag-month tribe-common-h2 tribe-common-h4--min-medium">
                <?php echo esc_html( $event_month ); ?>
            </span>
        </span>
		<span class="tribe-events-widget-events-list__event-date-tag-year tribe-common-h2 tribe-common-h5--min-medium">
			<?php echo esc_html( $event_day_year ); ?>
		</span>
	</time>
    <div class="tribe-events-widget-events-list__event-date-tag-categories"><?php echo $event_categories; ?></div>
</div>
