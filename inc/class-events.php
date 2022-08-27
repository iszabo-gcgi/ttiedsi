<?php
/**
 * Customize Events Calendar content.
 */

namespace TTIBase;

class Events {
    public function __construct() {
        // Widget filters.
        add_filter( 'tribe_template_html:events/v2/widgets/widget-events-list/event/date', '__return_false' );
        add_filter( 'tribe_template_html:events/v2/widgets/widget-events-list/header', '__return_false' );
        add_action( 'tribe_template_entry_point:events/v2/widgets/widget-events-list/event:event_meta', array( $this, 'widget_wrap_meta_open' ), 13 );
        add_action( 'tribe_template_entry_point:events/v2/widgets/widget-events-list/event:event_meta', array( $this, 'widget_times_after_venue' ), 15, 4 );
        $widget_slug = 'widget-events-list';
        add_filter( "tribe_events_views_v2_view_{$widget_slug}_template_vars", array( $this, 'widget_view_more_text' ), 11, 2 );
        
        // List Page filters.
        $list_slug = 'list';
        add_filter( "tribe_events_views_v2_view_{$list_slug}_template_vars", array( $this, 'list_view_template_vars' ), 11, 2 );
        add_filter( 'tribe_events_event_schedule_details_inner', array( $this, 'format_date' ), 11, 2 );
        add_filter( 'tribe_template_html:events/v2/list/month-separator', '__return_false' );
        add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
        add_filter( 'genesis_pre_get_option_site_layout', array( $this, 'add_genesis_sidebar_layout' ) );
        add_filter( 'genesis_structural_wrap-site-inner', array( $this, 'add_event_archive_heading' ), 10, 2 );

        // Add New Event.
        add_filter( 'gform_form_args', array( $this, 'gform_form_args' ), 11, 7 );
        add_filter( 'gform_field_filters', array( $this, 'gform_field_filters' ), 11, 2 );
        // Wrap section content in containers.
        if ( ! is_admin() ) {
            add_filter( 'gform_field_container_1', array( $this, 'gform_wrap_sections' ), 10, 6 );
            add_filter( 'gform_field_content_1', array( $this, 'remove_section_descriptions' ), 10, 5 );
        }

        // Register scripts on the event form page.
        add_action( 'gform_enqueue_scripts', array( $this, 'load_scripts' ), 10, 2 );

        add_filter( 'body_class', array( $this, 'sm_gform_page_body_class' ) );

    }

    /**
     * Add class to page when the page block editor uses a GravityForm form block.
     * 
     * @param array $classes The body classes.
     * 
     * @return array
     */
    public function sm_gform_page_body_class( $classes ) {

        if ( has_block( 'gravityforms/form', get_the_ID() ) ) {
            $classes[] = 'has-gravity-form-block';
        }
        
        return $classes;
        
    }

    /**
     * Load scripts on a specific Gravity Form page.
     * 
     * @param array $form    The form attributes.
     * @param bool  $is_ajax Whether the form is being submitted via AJAX.
     * 
     * @return void
     */
    public function load_scripts( $form, $is_ajax ) {

        if ( 'Add New Event' === $form['title'] ) {
            wp_register_script( 'ttibase-event-form', get_stylesheet_directory_uri() . '/assets/js/events-form.js', false, filemtime( get_stylesheet_directory() . '/assets/js/events-form.js' ), true );
            wp_enqueue_script( 'ttibase-event-form' );
        }

    }

    /**
     * Register the Event List sidebar 
     * 
     * @return void
     */
    public static function register_sidebar() {
  
      $args = array(
        'name'           => __( 'Event List', 'ttibase' ),
        'id'             => 'event_list',
        'description'    => __( 'Event list page for The Events Calendar events', 'ttibase' ),
        'class'          => 'event-list',
        'before_title'   => '<h2 class="section-title widgettitle"><span class="section-title">',
        'after_title'    => '</span></h2>',
        'before_sidebar' => '<aside class="sidebar wp-block-column nav-column sidebar-primary">',
        'after_sidebar'  => '</aside>',
      );
  
      genesis_register_sidebar( $args );
  
    }

    public function widget_wrap_meta_open() {
        echo '<div class="tribe-common-b2 tribe-events-widget-events-list__event-meta">';
    }

    private function format_event_date( $output ) {
        preg_match_all( '/\s(am|pm)</', $output, $matches );
        if ( $matches[0][0] === $matches[0][1] ) {
            $output = preg_replace( '/' . $matches[0][0] . '/', '<', $output, 1 );
            $output = preg_replace( '/ (am|pm)\b/', '$1', $output, 1 );
        } else {
            $output = str_replace( $matches[0][0], $matches[1][0] . '<', $output );
            $output = str_replace( $matches[0][1], $matches[1][1] . '<', $output );
        }
        return $output;
    }

    /**
     * Filter the template output.
     * 
     * @param string $hook_name        For which template include this entry point belongs.
     * @param string $entry_point_name Which entry point specifically we are triggering.
     * @param self   $template         Current instance of the template class doing this entry point.
     * 
     * @return string
     */
    public function widget_times_after_venue( $hook_name, $entry_point_name, $template ) {
        remove_filter( 'tribe_template_html:events/v2/widgets/widget-events-list/event/date', '__return_false' );
        $template = $template->template( 'widgets/widget-events-list/event/date', [], false );
        $template = $this->format_event_date( $template );
        echo $template;
        echo '</div>';
        add_filter( 'tribe_template_html:events/v2/widgets/widget-events-list/event/date', '__return_false' );
    }

    /** 
     * Change the text for the widget's View Calendar button.
     * 
     * @param array          $template_vars An associative array of template variables. Variables will be extracted in the
     *                                      template hence the key will be the name of the variable available in the
     *                                      template.
     * @param View_Interface $view          The current view whose template variables are being set.
     * 
     * @return array
     */
    public function widget_view_more_text( $template_vars, $view ) {
        $template_vars['view_more_text'] = 'See All Events';
        $template_vars['widget_title'] = false;
        return $template_vars;
    }

    /** 
     * Change the text for the widget's View Calendar button.
     * 
     * @param array          $template_vars An associative array of template variables. Variables will be extracted in the
     *                                      template hence the key will be the name of the variable available in the
     *                                      template.
     * @param View_Interface $view          The current view whose template variables are being set.
     * 
     * @return array
     */
    public function list_view_template_vars( $template_vars, $view ) {
        // echo '<pre>';
        // print_r($template_vars);
        // echo '</pre>';
        $template_vars['disable_event_search'] = true;
        return $template_vars;
    }
    
    /**
     * Format the date to only show times and in a compact manner.
     * 
     * @param string $inner_html  the output HTML
     * @param int    $event_id    post ID of the event we are interested in
     * 
     * @return string
     */
    public function format_date( $inner_html, $event_id ) {
        // Condense time range.
        $inner_html = $this->format_event_date( $inner_html );

        // Remove the month from before the beginning time.
        $separator = tribe_get_datetime_separator();
        $inner_html = preg_replace( '/>[a-zA-Z]+ [0-9]+' . $separator . '/', '>', $inner_html );

        return $inner_html;
    }

    /**
     * Setup sidebar for Events Calendar specified pages.
     * 
     * @param string $layout The layout for the page.
     * 
     * @return void
     */
    public static function add_genesis_sidebar_layout( $layout ) {
  
      if ( is_post_type_archive( 'tribe_events') ) {
        $layout = __genesis_return_sidebar_content();
      }
  
      return $layout;
  
    }

    public function add_event_archive_heading( $output, $original_output ) {
        if ( 'open' === $original_output && is_post_type_archive( 'tribe_events' ) ) {
            $output = '<div class="archive-events-heading"><h1 class="has-white-color has-maroon-background-color has-text-color has-background" style="text-transform:uppercase">EVENTS</h1></div>' . $output;
        }
        return $output;
    }

    /**
     * Filter the Gravity Form arguments.
     * 
     * @param array $args {
     *     The form arguments.
     * 
     *     @key int   $form_id             The form ID.
     *     @key bool  $display_title       Whether to display the form title.
     *     @key bool  $display_description Whether to display the form description.
     *     @key bool  $force_display       Whether to force display.
     *     @key array $field_values        The field values.
     *     @key bool  $ajax                Whether to use AJAX to submit the form.
     *     @key int   $tabindex            The tabindex of the form.
     * }
     * 
     * @return array
     */
    public function gform_form_args( $args ) {
        $args['display_title']       = false;
        $args['display_description'] = false;
        return $args;
    }

    /**
     * This filter is executed before creating the field’s content, allowing users to completely
     * modify the way the field is rendered. It can also be used to create custom field types.
     * It is similar to gform_field_input, but provides more flexibility.
     * 
     * @param string   $field_container The field container markup. {FIELD_CONTENT} placeholder indicates where the markup for the field content should be located.
     * @param GF_Field $field           The Field currently being processed.
     * @param array    $form            The Form currently being processed.
     * @param string   $css_class       The CSS classes to be assigned to the container element.
     * @param string   $style           Holds the conditional logic display style. Deprecated in 1.9.4.4.
     * @param string   $field_content   The markup for the field content: label, description, inputs, etc.
     * 
     * @return string
     */
    public function gform_wrap_sections( $field_container, $field, $form, $css_class, $style, $field_content ) {

        $is_section = 'section' === $field->type ? true : false;
        $form = \GFAPI::get_form( $form['id'] );
        $fields = $form['fields'];
        $last_field = end($fields);
        reset($fields);
        $last_field_id = $last_field->id;
        $is_last_field = $field->id === $last_field_id ? true : false;

        // Return early if we don't want to change anything.
        if ( ! $is_last_field && ! $is_section ) {
            return $field_container;
        }

        // Get the first section ID.
        $first_section_id = 0;
        foreach ( $fields as $f ) {
            if ( 'section' === $f->type ) {
                $first_section_id = $f->id;
                break;
            }
        }

        if ( $is_section ) {
            // If this is not the first section field in the form.
            $pre = '<div class="gfield gsection-wrap">';
            if ( intval( $field->id ) !== intval( $first_section_id ) ) {
                $pre = '</div></div>' . $pre;
            }
            $field_container = $pre . $field_container;
            $section_tag   = preg_replace( '/[^a-z\s]*/', '', strtolower( $field->label ) );
            $section_tag   = preg_replace( '/\s+/', '-', $section_tag );
            $section_class = $section_tag . ' ';
            if ( $field->description ) {
                $section_class .= 'has-description ';
            }
            $field_container .= '<div class="gfield gsection ' . $section_class . 'gform-section-group gfield_visibility_visible">';
            if ( $field->description ) {
                $field_container .= '<div class="gfield gsection-label">' . $field->description . '</div>';
            }
        }

        if ( $is_last_field ) {
            $field_container .= '</div>';
        }

        return $field_container;
    }

    /**
     * This filter is executed before creating the field’s content, allowing users to completely
     * modify the way the field is rendered. It can also be used to create custom field types.
     * 
     * @param string  $field_content The field content to be filtered.
     * @param Field   $field         The field that this input tag applies to.
     * @param string  $value         The default/initial value that the field should be pre-populated with.
     * @param integer $entry_id      When executed from the entry detail screen, $lead_id will be populated with the Entry ID. Otherwise, it will be 0.
     * @param integer $form_id       The current Form ID.
     * 
     * @return array
     */
    public function remove_section_descriptions( $field_content, $field, $value, $entry_id, $form_id ) {
        if ( 'section' === $field->type && $field->description ) {
            $description_position = strpos( $field_content, '>' . $field->description . '</' );
            if ( $description_position !== false ) {
                $description_position += 1;
                $desc_before          = substr( $field_content, 0, $description_position );
                $desc_before          = preg_replace( '/<[^>]+>$/', '', $desc_before );
                if ( $desc_before ) {
                    $desc_after = substr( $field_content, $description_position + strlen( $field->description ) );
                    $desc_after = preg_replace( '/^<\/[^>]+>/', '', $desc_after );
                    $field_content = $desc_before . $desc_after;
                }
            }
        }
        return $field_content;
    }
}