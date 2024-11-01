<?php
global $wpia_db_version;
$wpia_db_version = "1.0";
function wpia_install(){
    global $wpdb;
    global $wpia_db_version;
    
    $wpia_current_db_version = get_site_option( "wpia_db_version" );
    if( $wpia_current_db_version != $wpia_db_version ):   
        $sql = "CREATE TABLE `".$wpdb->base_prefix."wpia_calendars` (
              `calendarID` int(10) NOT NULL AUTO_INCREMENT,
              `calendarTitle` text,
              `createdDate` int(11) DEFAULT NULL,
              `modifiedDate` int(11) DEFAULT NULL,
              `calendarOptions` text,
            KEY (`calendarID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='WP iCal Availability';";            
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_site_option( "wpia_db_version", $wpia_db_version );
        add_site_option( "wpia-languages", '{"en":"English"}', '' );        
        
    endif;
}


function wpia_update_db_check() {
    global $wpia_db_version;
    if (get_site_option( 'wpia_db_version' ) != $wpia_db_version) {
        wpia_install();
        update_site_option( "wpia_db_version", $wpia_db_version );
    }
}
add_action( 'plugins_loaded', 'wpia_update_db_check' );