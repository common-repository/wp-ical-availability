<?php

/** Save Languages **/
$languages = array('en' => 'English', 'bg' => 'Bulgarian','ca' => 'Catalan','hr' => 'Croatian','cz' => 'Czech','da' => 'Danish','nl' => 'Dutch','et' => 'Estonian','fi' => 'Finnish','fr' => 'French','de' => 'German','el' => 'Greek','hu' => 'Hungarian','it' => 'Italian', 'jp' => 'Japanese', 'no' => 'Norwegian','pl' => 'Polish','pt' => 'Portugese','ro' => 'Romanian','ru' => 'Russian','sk' => 'Slovak','sl' => 'Slovenian','es' => 'Spanish','sv' => 'Swedish','tr' => 'Turkish','ua' => 'Ukrainian');

foreach($languages as $code => $language):
    if(!empty($_POST[$code]))
        $activeLanguages[$code] = $language;
endforeach;
if(empty($activeLanguages)) $activeLanguages['en'] = 'English';

update_site_option('wpia-languages',json_encode($activeLanguages));


$wpiaOptions['displayDays'] = sanitize_text_field($_POST['date-type']);
$wpiaOptions['alwaysEnqueueScripts'] = sanitize_text_field($_POST['always-enqueue-scripts']);




update_site_option('wpia-options',json_encode($wpiaOptions));

wp_redirect(admin_url('admin.php?page=wp-ical-availability-settings&save=ok'));
die();