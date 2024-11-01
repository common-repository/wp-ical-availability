<?php
function wpia_changeDayAdmin_callback() {
    global $showDateEditor;
    $showDateEditor = true;
    wpia_changeDay_callback();
    
    die();
}
function wpia_changeDay_callback() {
    global $showDateEditor;
    if(in_array($_POST['showLegend'],array(0,1))) $showLegend = $_POST['showLegend']; else $showLegend = 1;
 
    

    
    if(!empty($_POST['currentTimestamp'])) $currentTimestamp = $_POST['currentTimestamp'];
    $calendarData = (!empty($_POST['calendarData'])) ? $calendarData = $_POST['calendarData'] : false;
    if(!empty($_POST['calendarLegend'])) $calendarLegend = $_POST['calendarLegend'];    
    if(!empty($_POST['calendarID'])) $calendarID = $_POST['calendarID']; else $calendarID = 0;    
    if(!empty($_POST['calendarLanguage'])) $calendarLanguage = $_POST['calendarLanguage'];


    
    
    $currentTimestamp = intval($currentTimestamp);    
    //hack $currentTimestamp to be the middle of the month.
    $currentTimestamp = strtotime("15 " . date(' F Y',$currentTimestamp));
    
    if(!empty($_POST['calendarDirection']) && $_POST['calendarDirection'] == 'next'){
        $currentTimestamp = strtotime(date('j F Y',$currentTimestamp) . " + 1 month");
    } elseif(!empty($_POST['calendarDirection']) && $_POST['calendarDirection'] == 'prev'){
        $currentTimestamp = strtotime(date('j F Y',$currentTimestamp) . " - 1 month");
    }


    echo wpia_calendar(array('ajaxCall' => true, 'calendarLanguage' => $calendarLanguage, 'showDateEditor' => $showDateEditor, 'calendarID' => $calendarID, 'calendarData' => stripslashes($calendarData), 'currentTimestamp' => $currentTimestamp, 'showLegend' => $showLegend));
    
	die(); 
}
