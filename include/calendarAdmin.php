<?php
function wpia_replaceCustom($str){
    return str_replace( 
        array(
            '--AMP--',
            '--DOUBLEQUOTE--',
            '--QUOTE--',
            '--LT--',
            '--GT--'
        ),
        array(
            '&',
            '"',
            "'",
            '<',
            '>'
        ),
        $str );
}

function wpia_edit_users($calendarID){
    global $wpdb;
    ob_start();
    if( current_user_can( MIN_USER_CAPABILITY ) ):
        $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->base_prefix . 'sbc_calendars WHERE calendarID=%d',$calendarID); 
        $calendar = $wpdb->get_row( $sql, ARRAY_A );
        $calendarUsers = json_decode($calendar['calendarUsers']);
        ?>
        
        <div class="wpia-calendar-users">
            <p><?php echo __('Assign users to this calendar','wpia');?></p>
            <select data-placeholder="Select users" class="wpia-chosen" name="wpbbs-calendar-users[]" multiple="multiple">
            <?php $users = get_users(); foreach($users as $user): if($user->roles[0] == 'administrator') continue; ?>
                <option<?php if( !empty($calendarUsers) && in_array($user->ID, $calendarUsers ) ):?> selected="selected"<?php endif;?> value="<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></option>
            <?php endforeach;?> 
            </select>
        </div>
        <?php
    endif;
    $output = ob_get_contents();
    ob_clean();
    return $output;
}
