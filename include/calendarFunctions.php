<?php
function wpia_default_legend($language){
    $languageDefaults['available_translation_en'] = 'Available';
    $languageDefaults['booked_translation_en'] = 'Booked';
    $languageDefaults['available_translation_hr'] = 'Slobodno';
    $languageDefaults['booked_translation_hr'] = 'Zauzeto';
    $languageDefaults['available_translation_da'] = 'Ledigt';
    $languageDefaults['booked_translation_da'] = 'Booket';
    $languageDefaults['available_translation_nl'] = 'Vrij';
    $languageDefaults['booked_translation_nl'] = 'Bezet';
    $languageDefaults['available_translation_fr'] = 'Libre';
    $languageDefaults['booked_translation_fr'] = 'Occupé';
    $languageDefaults['available_translation_de'] = 'Frei';
    $languageDefaults['booked_translation_de'] = 'Belegt';
    $languageDefaults['available_translation_hu'] = 'Szabad';
    $languageDefaults['booked_translation_hu'] = 'Foglalt';
    $languageDefaults['available_translation_it'] = 'Libero';
    $languageDefaults['booked_translation_it'] = 'Prenotato';
    $languageDefaults['available_translation_no'] = 'Ledig';
    $languageDefaults['booked_translation_no'] = 'Reservert';
    $languageDefaults['available_translation_pt'] = 'Disponível';
    $languageDefaults['booked_translation_pt'] = 'Reservado';
    $languageDefaults['available_translation_ro'] = 'Disponibil';
    $languageDefaults['booked_translation_ro'] = 'Rezervat';
    $languageDefaults['available_translation_ru'] = 'Вільно';
    $languageDefaults['booked_translation_ru'] = 'Заброньовано';
    $languageDefaults['available_translation_sk'] = 'Voľný';
    $languageDefaults['booked_translation_sk'] = 'Obsadený';
    $languageDefaults['available_translation_es'] = 'Libre';
    $languageDefaults['booked_translation_es'] = 'Reservado';
    $languageDefaults['available_translation_sv'] = 'Ledigt';
    $languageDefaults['booked_translation_sv'] = 'Bokat';
    $languageDefaults['available_translation_ua'] = 'Bільно';
    $languageDefaults['booked_translation_ua'] = 'Зайнято';
    
    if(isset($languageDefaults[$language]))
        return $languageDefaults[$language];
    return false;
}

function wpia_print_legend_css($calendar = null){
    $output = "<style>";
        $calendarID = (!empty($calendar)) ? $calendar['calendarID'] : false;
        
        if($calendarID) $calendarOptions = json_decode($calendar['calendarOptions'],true);
        
        $availableColor = (!empty($calendarOptions['available_color'])) ? $calendarOptions['available_color'] : '#DDFFCC';
        $output .= ".wpia-calendar-".$calendarID." .status-available {background-color: ".$availableColor." ;}";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-top-available {display:none ;} ";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-bottom-available {display:none ;} ";
        
        $bookedColor = (!empty($calendarOptions['booked_color'])) ? $calendarOptions['booked_color'] : '#FFC0BD';
        $output .= ".wpia-calendar-".$calendarID." .status-booked {background-color: ".$bookedColor." ;}";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-top-booked {display:none ;} ";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-bottom-booked {display:none ;} ";
        
        $output .= ".wpia-calendar-".$calendarID." .status-grey {background-color: #ececec;}";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-top-grey {display:none ;} ";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-bottom-grey {display:none ;} ";
        
        
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-top-changeover-end {border-color: ".$bookedColor." transparent transparent transparent ; _border-color: ".$bookedColor." #000000 #000000 #000000 ;}";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-bottom-changeover-end {border-color: transparent transparent " . $availableColor ." transparent ; _border-color:  #000000 #000000 " . $availableColor ." #000000 ;}";
        
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-top-changeover-start {border-color: ".$availableColor." transparent transparent transparent ; _border-color: ".$availableColor." #000000 #000000 #000000 ;}";
        $output .= ".wpia-calendar-".$calendarID." .wpia-day-split-bottom-changeover-start {border-color: transparent transparent " . $bookedColor ." transparent ; _border-color:  #000000 #000000 " . $bookedColor ." #000000 ;}";
    
    
    $output .= "</style>";
    
    return $output;
}

function wpia_timeFormat($timestamp){
    //$wpiaOptions = json_decode(get_site_option('wpia-options'),true);
    
    //if(!isset($wpiaOptions['dateFormat'])) $wpiaOptions['dateFormat'] = 'd-m-Y';
    
    $date = date('d-m-Y', $timestamp);
    
    $month = date('F', $timestamp);
    $date = str_replace($month, __($month), $date);

    return $date;
    
}

function wpia_fixDate($date){
    $date = str_replace('TZ','T000000Z',$date);
    return $date;
}


function wpia_get_language(){
    $activeLanguages = json_decode(get_site_option('wpia-languages'),true);
    if(array_key_exists(substr(get_bloginfo('language'),0,2),$activeLanguages)){
        return substr(get_bloginfo('language'),0,2);    
    }
    return 'en';
}

function wpia_get_locale(){
    return substr(get_locale(),0,2);
}
function wpia_tz_offset_to_name($offset){
    $offset *= 3600;
    $abbrarray = timezone_abbreviations_list();
    foreach ($abbrarray as $abbr){
        foreach ($abbr as $city){
            if ($city['offset'] == $offset){
                    return $city['timezone_id'];
            }
        }
    }
    
    return false;
}