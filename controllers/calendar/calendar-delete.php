<?php 
require_once( ABSPATH . 'wp-load.php' );
global $wpdb;

$calendarId = $_GET['id'];

$sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->base_prefix . 'wpia_calendars WHERE calendarID=%d',$calendarId);
$calendar = $wpdb->get_row( $sql, ARRAY_A );
if($wpdb->num_rows > 0):
    $wpdb->delete( $wpdb->base_prefix . 'wpia_calendars', array('calendarID' => $calendarId));
    
endif;

wp_redirect(admin_url('admin.php?page=wp-ical-availability'));
die();
?>     