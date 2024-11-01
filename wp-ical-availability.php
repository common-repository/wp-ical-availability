<?php
/**
 * Plugin Name: WP iCal Availability Free
 * Plugin URI:  http://www.wpicalavailability.com
 * Description: WP iCal Availability
 * Version:     1.0.3
 * Author:      WP iCal Availability
 * Author URI:  http://www.wpicalavailability.com
 *
 * Copyright (c) 2016 WP iCal Availability
 */



include 'include/createTables.php';
register_activation_hook( __FILE__, 'wpia_install' );

define("MIN_USER_CAPABILITY", "manage_options");
define("WPIA_PATH",plugins_url('',__FILE__));
define("WPIA_DIR_PATH",dirname(__FILE__));

add_action( 'plugins_loaded', 'wpia_load_textdomain' );
function wpia_load_textdomain() {
    load_plugin_textdomain( 'wpia', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}


include 'include/calendarLanguages.php';
include 'include/calendarFunctions.php';
include 'include/calendarAdmin.php';
include 'include/calendarCore.php';
include 'include/calendarAjax.php';
include 'include/class.iCalReader.php';

include 'include/pluginStructure.php';
include 'include/pluginShortcodeButton.php';
include 'include/pluginShortcode.php';
include 'include/pluginWidget.php';




if (is_admin()) {
    add_action('admin_head','wpia_prevent_iphone_format');
    function wpia_prevent_iphone_format(){
        echo '<meta name="format-detection" content="telephone=no" />';
    }
    
	add_action('admin_menu', 'wpia_menu');   
    function wpia_admin_enqueue_files() {
        wp_enqueue_style( 'wpia-calendar', WPIA_PATH . '/css/wpia-calendar.css' );
        wp_enqueue_style( 'wpia-admin', WPIA_PATH . '/css/wpia-admin.css' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'chosen', WPIA_PATH . '/css/chosen.min.css' );
         
        
        wp_enqueue_script('wpia-admin', WPIA_PATH . '/js/wpia-admin.js', array('jquery'));
        wp_enqueue_script('wpia-colorpicker', WPIA_PATH . '/js/colorpicker.js', array( 'jquery', 'wp-color-picker' ));
        wp_enqueue_script('custom-select', WPIA_PATH . '/js/custom-select.js', array('jquery'));
        wp_enqueue_script('chosen', WPIA_PATH . '/js/chosen.jquery.min.js', array('jquery'));
        


    }
    add_action( 'admin_init', 'wpia_admin_enqueue_files' );       
} else {
    
    function wpia_enqueue_files() {
        wp_enqueue_style( 'wpia-calendar', WPIA_PATH . '/css/wpia-calendar.css' );
        wp_enqueue_script('wpia', WPIA_PATH . '/js/wpia.js', array('jquery'));
        wp_enqueue_script('custom-select', WPIA_PATH . '/js/custom-select.js', array('jquery'));    
    }
    $wpiaOptions = json_decode(get_site_option('wpia-options'),true);  
    if(!empty($wpiaOptions['alwaysEnqueueScripts']) && $wpiaOptions['alwaysEnqueueScripts'] == 'yes'){
        add_action( 'wp_enqueue_scripts', 'wpia_enqueue_files' );    
    }
    
    add_action('wp_head','wpia_ajaxurl');
}

//Admin Menu
function wpia_menu(){
    add_menu_page( 'WP iCal Availability', 'WP iCal <br />Availability', 'read', 'wp-ical-availability', 'wpia_calendars', WPIA_PATH . '/images/date-button.gif' , 108 );
    add_submenu_page( 'wp-ical-availability', __('Calendars','wpia'), __('Calendars','wpia'), 'read', 'wp-ical-availability', 'wpia_calendars' );  
    add_submenu_page( 'wp-ical-availability', __('Settings','wpia'), __('Settings','wpia'), 'read', 'wp-ical-availability-settings', 'wpia_settings' );  
}
add_action('wp_ajax_changeDayAdmin', 'wpia_changeDayAdmin_callback');
add_action('wp_ajax_changeDay', 'wpia_changeDay_callback');
add_action('wp_ajax_nopriv_changeDay', 'wpia_changeDay_callback');
function wpia_ajaxurl() {
    ?>
    <script type="text/javascript">var wpia_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
    <?php
}

