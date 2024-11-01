<?php
global $wpdb;

if(isset($_POST['icalendar_feed'])) $calendarOptions['icalendar_feed'][0] = esc_url( $_POST['icalendar_feed']);
$calendarTitle = sanitize_text_field($_POST['calendarTitle']);



if(!empty($_POST['calendarID'])){
    $wpdb->update( $wpdb->base_prefix.'wpia_calendars', array('calendarTitle' => stripslashes($calendarTitle), 'calendarOptions' => json_encode($calendarOptions), 'modifiedDate' => time()), array('calendarID' => $_POST['calendarID']) );  
    
    
    
    
    wp_redirect(admin_url('admin.php?page=wp-ical-availability&do=edit-calendar&id='.$_POST['calendarID'].'&save=ok'));
} else {
    //default languages
    $wpdb->insert( $wpdb->base_prefix.'wpia_calendars', array('calendarTitle' => stripslashes($calendarTitle), 'calendarOptions' => json_encode($calendarOptions), 'modifiedDate' => time(), 'createdDate' => time() ));
    

    
    wp_redirect(admin_url('admin.php?page=wp-ical-availability&do=edit-calendar&id='.$wpdb->insert_id.'&save=ok'));     
}
die();


?>