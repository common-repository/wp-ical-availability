<?php
function wpia_shortcode( $atts ) {
    $wpiaOptions = json_decode(get_site_option('wpia-options'),true);  
    if(empty($wpiaOptions['alwaysEnqueueScripts']) || $wpiaOptions['alwaysEnqueueScripts'] == 'no'){
        wp_enqueue_style( 'wpia-calendar', WPIA_PATH . '/css/wpia-calendar.css' );
        wp_enqueue_script('wpia', WPIA_PATH . '/js/wpia.js', array('jquery'));
        wp_enqueue_script('custom-select', WPIA_PATH . '/js/custom-select.js', array('jquery'));
    }
    
	extract( shortcode_atts( array(
		'id'        => null,
		'title'     => 'no',
        'legend'    => 'no',
        'dropdown'  => 'yes',
        'language'  => 'en'
	), $atts, 'wpia' ) );
    
    
    
  
    if($id == null) return "WP Simple Booking Calendar: ID parameter missing.";
    if(!in_array($title,array('yes','no'))) $title = 'no';

    if(!in_array($dropdown,array('yes','no'))) $dropdown = 'yes';
    $dropdown = str_replace(array('yes','no'),array(true,false),$dropdown);

        
    
    
    global $wpdb;
    
    
    if($language == 'auto'){
        $language = wpia_get_locale();
    } else {
        $activeLanguages = json_decode(get_site_option('wpia-languages'),true); if(!array_key_exists($language,$activeLanguages)) $language = 'en';    
    }

    $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->base_prefix . 'wpia_calendars WHERE calendarID=%d',$id);
    $calendar = $wpdb->get_row( $sql, ARRAY_A );
    if($wpdb->num_rows > 0):
        
        $calendarOutput = wpia_print_legend_css($calendar);
        if($title == 'yes') $calendarOutput .= '<h2>' . $calendar['calendarTitle'] . "</h2>";
        $calendarOptions =(!empty($calendar['calendarOptions'])) ? json_decode($calendar['calendarOptions'],true) : false;
        
        $calendarOutput .= wpia_calendar(array('ajaxCall' => false, 'calendarID' => $calendar['calendarID'], 'calendarFeed' => $calendarOptions['icalendar_feed'][0], 'showDateEditor' => false, 'calendarLanguage' => $language ));
        

        return $calendarOutput;
    else:
        return __('WP Simple Booking Calendar: Invalid calendar ID.');
    endif;
	
}
add_shortcode( 'wpia', 'wpia_shortcode' );