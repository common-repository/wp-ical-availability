<?php
/**
 * This function prepares the calendar
 */
function wpia_calendar($options = array()){
    
    $default_options = array('ajaxCall' => false, 'calendarFeed' => null, 'monthToShow' => null, 'yearToShow' => null, 'currentCalendar' => 1, 'calendarLanguage' => 'en', 'calendarData' => null, 'currentTimestamp' => mktime(0, 0, 0, date('n') , 15, date('Y')),'calendarLegend' => false, 'calendarID' => false, 'showDateEditor' => false, 'showLegend' => false);
   
    
    foreach($default_options as $key => $value){
        if(empty($$key))
            $$key = $value;
    }
    
    extract($options);
    
    $output = '';
    
    if($calendarFeed !== null){
        $ical   = new ICal($calendarFeed);
        $events = $ical->events();
        
        if($events) foreach($events as $event){
            //print_r($event);
            $start = strtotime(wpia_fixDate($event['DTSTART']));
            $end = strtotime(wpia_fixDate($event['DTEND'])) - 60;
            for($i = $start; $i<= $end; $i = $i + 60*60*24){
                $calendarData[date('Y',$i)][date('n',$i)][date('j',$i)] = 'booked';
                
            }
            
        }
        
        $calendarData = json_encode($calendarData);
    }
    
    
    $wpiaOptions = json_decode(get_site_option('wpia-options'),true);
    if(empty($wpiaOptions['displayDays']) || $wpiaOptions['displayDays'] == 1){
        $calendarData = json_decode($calendarData,true);
        if(!empty($calendarData)) foreach($calendarData as $y => $months){
            foreach($months as $m => $days){
                foreach($days as $d => $status){
                    if (strpos($d,'description') === false) {
                        
                        //previous day if first day of the month
                        if($d == 1){
                            $pY = date('Y',mktime(0,0,0,$m-1,15,$y));
                            $pM = date('n',mktime(0,0,0,$m-1,15,$y));
                            $pD = date('t',mktime(0,0,0,$m-1,15,$y));
                        } else {
                            $pY = $y;
                            $pM = $m;
                            $pD = $d-1;
                        }
                        
                        //next day if last day of the month
                        if($d == date('t',mktime(0,0,0,$m,15,$y))){
                            $nY = date('Y',mktime(0,0,0,$m+1,15,$y));
                            $nM = date('n',mktime(0,0,0,$m+1,15,$y));
                            $nD = 1;
                        } else {
                            $nY = $y;
                            $nM = $m;
                            $nD = $d+1;
                        }
                            
        
                        
                        if($calendarData[$y][$m][$d] == 'booked' && (!isset($calendarData[$pY][$pM][$pD]))){
                            $calendarData[$y][$m][$d] = 'changeover-start';    
                            if((!isset($calendarData[$nY][$nM][$nD]))){
                                $calendarData[$nY][$nM][$nD] = 'changeover-end';    
                            }
                        }
                        
                        if($calendarData[$y][$m][$d] == 'booked' && (!isset($calendarData[$nY][$nM][$nD]))){
                            $calendarData[$nY][$nM][$nD] = 'changeover-end';    
                        }
                        
                    }
                }
            }
        }
        $calendarData = json_encode($calendarData);
    }
    
    if($ajaxCall == false):    
        $output .= '<div class="wpia-container wpia-calendar-'.$calendarID.'">';
        $output .= '<div class="wpia-calendars">';
    endif;
    
    
        $output .= '<div class="wpia-responsive-calendars">';
        
 
  
          

        $calendarTimestamp = mktime(0, 0, 0, date('n',$currentTimestamp), 1, date('Y',$currentTimestamp));    
        $displayMonth = date('n', $calendarTimestamp);
        $displayYear = date('Y', $calendarTimestamp);
        $output .= wpia_showCalendar(array('monthToShow' => $displayMonth, 'yearToShow' => $displayYear, 'currentCalendar' => 1, 'calendarLanguage' => ($showDateEditor) ? substr(get_locale(),0,2) : $calendarLanguage, 'calendarData' => $calendarData, 'calendarID' => $calendarID));

    
    
    
      
    
    
        $output .= '</div>';
        
     
    
    $output .= "<div class='wpia-clear'></div>";

    
    
    $output .= '<div class="wpia-calendar-options">';
    $output .= '<div class="wpia-show-legend" data-show-legend="'.$showLegend.'">';
    $output .= '</div><div class="wpia-current-timestamp" data-current-timestamp="'.$currentTimestamp.'">';

    $output .= "</div><div class='wpia-calendar-data' data-calendar-data='" . html_entity_decode(esc_html(($calendarData))) . "'>";
    $output .= "</div><div class='wpia-calendar-legend' data-calendar-legend='" . html_entity_decode(esc_html($calendarLegend)) . "'>";
    $output .= '</div><div class="wpia-calendar-language" data-calendar-language="'.$calendarLanguage.'">'; 

    $output .= '</div><div class="wpia-calendar-ID" data-calendar-ID="'.$calendarID.'">';
    $output .= '</div>';
    $output .= '</div>';
    
     
    
    
    if($ajaxCall == false): 
        
        $output .= '</div>';
        
        $output .= '</div><div class="wpia-clear"></div>';
        
    endif;
    
    return $output;
}
/**
 * This function is displays the calendar with the parameters given from the previous function
 */
function wpia_showCalendar($options = array())
{   

    
    foreach($options as $key => $value){
            $$key = $value;
    }
    
    $calendarData = json_decode($calendarData,true);
    if (($monthToShow === null) or ($yearToShow === null)) {
        $today = getdate();
        $monthToShow = $today['mon'];
        $yearToShow = $today['year'];
    } else {
        $today = getdate(mktime(0, 0, 0, $monthToShow, 1, $yearToShow));
    }

    // get first and last days of the month
    $firstDay = getdate(mktime(0, 0, 0, $monthToShow, 1, $yearToShow));
    $lastDay = getdate(mktime(0, 0, 0, $monthToShow + 1, 0, $yearToShow)); //trick! day = 0

    // Create a table with the necessary header information
    $output = '<div class="wpia-calendar';
   
    
    $output .= '">';
    $output .= '<div class="wpia-heading">';

    $output .= '<a href="#" class="wpia-prev" title="'.__('Previous Month').'"></a>';
    
        $output .= '<div class="wpia-select-container"><select class="wpia-dropdown">';
            for($d=0;$d<12;$d++){
                $output .= '<option value="' . mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow) . '">' . wpiaMonth(date('F',mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow)), $calendarLanguage) . " " . date('Y',mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow)) . '</option>';
            }
        $output .= '</select></div>';
        
    
    

        $output .= '<a href="#" class="wpia-next" title="'.__('Next Month').'"></a>';
    $output .= "</div>";

    $output .= '<ul class="wpia-weekdays">';
    
    
    $actday = 0; // used to count and represent each day

    $dayText = wpiaDoW($calendarLanguage);
    for ($i = 0; $i < 7; $i++) { 
        $output .= '<li>' . $dayText[1 + $i] . '</li>';
    }
    $output .= '</ul>';
    
    $output .= '<ul>';
  
    
    
    // Display the first calendar row with correct start of week
    if (1 <= $firstDay['wday']) {
        $blanks = $firstDay['wday'] - 1;
    } else {
        $blanks = $firstDay['wday'] - 1 + 7;
    }
    for ($i = 1; $i <= $blanks; $i++) {
        $output .= '<li class="wpia-pad"><!-- --></li>';
    }
    
    // Note: loop below starts using the residual value of $i from loop above
    for ( /* use value of $i resulting from last loop*/; $i <= 7; $i++) {
        
        $output .= wpia_showDay($actday++,$yearToShow,$monthToShow,$calendarData); 
    
        
        
    }
    $output .= '</ul>';

    // Get how many complete weeks are in the actual month
    $fullWeeks = floor(($lastDay['mday'] - $actday) / 7);
    for ($i = 0; $i < $fullWeeks; $i++) {
        $output .= '<ul>';
        
        
        for ($j = 0; $j < 7; $j++) {
            $output .= wpia_showDay($actday++,$yearToShow,$monthToShow,$calendarData);
        }
        $output .= '</ul>';
    }

    //Now display the partial last week of the month (if there is one)
    if ($actday < $lastDay['mday']) {
        $output .= '<ul>';
        
       
        
        for ($i = 0; $i < 7; $i++) {
            if ($actday < $lastDay['mday']) {
                $output .= wpia_showDay($actday++,$yearToShow,$monthToShow,$calendarData);
            } else {
                $output .= '<li class="wpia-pad"><!-- --></li>';
            }
        }
        $output .= '</ul>';
    }
    $output .= '<div class="wpia-loading"><img alt="Loading" src="'.WPIA_PATH.'/images/ajax-loader.gif" /></div></div>';
    return $output;
}

function wpia_showDay($actday,$yearToShow,$monthToShow, $calendarData){
    
    if(!empty($calendarData[$yearToShow][$monthToShow][++$actday])){
       $status = $calendarData[$yearToShow][$monthToShow][$actday];
    } else {
        $status = 'available';
    }    
    
        
        $output = '<li class="wpia-day wpia-day-'.$actday.' status-' . $status .  ' ">';
            $output .= '<span class="wpia-day-split-top wpia-day-split-top-'.$status.'"></span>';
            $output .= '<span class="wpia-day-split-bottom wpia-day-split-bottom-'.$status.'"></span>';    
            $output .= '<span class="wpia-day-split-day">'.$actday.'</span>';    
        $output .= '</li>';
        
    return $output;
}