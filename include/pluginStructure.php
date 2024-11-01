<?php



/**
 * Calendars
 */
function wpia_calendars(){
    $do = (!empty($_GET['do'])) ? $_GET['do'] : 'calendars';
    switch($do){
        /** Views */
        case 'calendars': 
            include WPIA_DIR_PATH . '/views/calendar/calendars.php';
            break;
        case 'edit-calendar': 
            include WPIA_DIR_PATH . '/views/calendar/edit-calendar.php';
            break;
        case 'full-version':
            include WPIA_DIR_PATH . '/views/calendar/full-version.php';
            break;
       
            
        /** Controllers */    
        case 'save-calendar':
            include WPIA_DIR_PATH . '/controllers/calendar/calendar-save.php';
            break;
        case 'save-legend':
            include WPIA_DIR_PATH . '/controllers/calendar/legend-save.php';
            break;
        case 'calendar-delete':
            include WPIA_DIR_PATH . '/controllers/calendar/calendar-delete.php';
            break;
         
        default:
            include WPIA_DIR_PATH . '/views/calendar/calendars.php';
    }
}

/**
 * Settings
 */
function wpia_settings(){ 
    $do = (!empty($_GET['do'])) ? $_GET['do'] : 'settings';
    switch($do){
        /** Views */
        case 'settings': 
            include WPIA_DIR_PATH . '/views/settings/settings.php';
            break;
        case 'save': 
            include WPIA_DIR_PATH . '/controllers/settings/save-settings.php';
            break;
        default:
            include WPIA_DIR_PATH . '/views/settings/settings.php';
        }
}

