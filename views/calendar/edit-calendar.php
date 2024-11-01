<?php global $wpdb; ?>
<script>
    wpia(document).ready(function(){
        wpia(".wpia-calendars").css('min-height',wpia('.wpia-responsive-calendars').height());
    })
    wpia(window).bind('load resize',function(){
        wpia(".wpia-calendars").css('min-height',wpia('.wpia-responsive-calendars').height());
    })
</script>
<div class="wrap wpia-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2><?php echo __('Edit Calendar','wpia');?></h2>
    <?php if(!empty($_GET['save']) && $_GET['save'] == 'ok'):?>
    <div id="message" class="updated">
        <p><?php echo __('The calendar was updated','wpia')?></p>
    </div>
    <?php endif;?>
    <?php if(!(!empty($_GET['id']))) $_GET['id'] = 'wpia-new-calendar';?>
    <?php $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->base_prefix . 'wpia_calendars WHERE calendarID=%d',$_GET['id']); ?>
    <?php $calendar = $wpdb->get_row( $sql, ARRAY_A );?>
    <?php $calendar_users = isset($calendar['calendarUsers']) ? json_decode($calendar['calendarUsers']) : [] ?>
    <?php if(($wpdb->num_rows > 0 || $_GET['id'] == 'wpia-new-calendar') && (@in_array( get_current_user_id(), $calendar_users) || current_user_can( MIN_USER_CAPABILITY )) ):?>
        
        <?php if($_GET['id'] == 'wpia-new-calendar') { $calendar['calendarData'] = '{}';}?>
        <div class="postbox-container">
            <?php echo wpia_print_legend_css((!empty($calendar['calendarID'])) ? $calendar : false); ?>
            <form action="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=save-calendar&noheader=true');?>" method="post">
            <input type="text" name="calendarTitle" class="fullTitle" id="calendarTitle" placeholder="<?php echo __('Calendar title','wpia');?>" value="<?php echo (!empty($calendar['calendarTitle'])) ? stripslashes($calendar['calendarTitle']) : "" ;?>"/>
            <div class="wpia-action-buttons">
                <input type="submit" class="button button-primary button-h2 saveCalendar" value="<?php echo __('Save Changes','wpia');?>" /> 
                <a class="button secondary-button button-h2 button-h2-back-margin" href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=calendars');?>"><?php echo __('Back','wpia');?></a>
            </div>
            
          
            
            <div class="metabox-holder">
                <div class="postbox">
                    
                    <h3 class="hndle"><?php echo __('Availability','wpia');?></h3>
                    <div class="inside">  
                            <?php $wpiaOptions = json_decode(get_site_option('wpia-options'),true);?>
                            <?php $calendarOptions =(!empty($calendar['calendarOptions'])) ? json_decode($calendar['calendarOptions'],true) : false;?>
                            <?php if(empty($wpiaOptions['backendStartDay'])) $wpiaOptions['backendStartDay'] = 1;?>
                            <?php if(!is_array($calendarOptions['icalendar_feed'])) { $feed = $calendarOptions['icalendar_feed']; unset($calendarOptions['icalendar_feed']); $calendarOptions['icalendar_feed'][0] = $feed;} ?>
                            
                                             
                            <?php echo wpia_calendar( array( 'calendarFeed' => $calendarOptions['icalendar_feed'][0], 'calendarID' => (!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "", 'firstDayOfWeek' => $wpiaOptions['backendStartDay'], 'showDateEditor' =>  true ) );?>
                            <input type="hidden" value="<?php echo (!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "" ;?>" name="calendarID" />   
                            
                                          
                    </div>
                </div>
            </div> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    
                    <h3 class="hndle"><?php _e('Feed','wpia');?></h3>
                    <div class="inside">  
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="icalendar_feed"><?php _e('iCalendar Feed','wpia');?></label></th>
                                    <td><input name="icalendar_feed" type="text" id="icalendar_feed" value="<?php echo (!empty($calendarOptions['icalendar_feed'][0])) ? esc_url($calendarOptions['icalendar_feed'][0]) : '';?>" class="widefat" />
                                    <?php if(!empty($calendarOptions['icalendar_feed'][0])): $ical = new ICal($calendarOptions['icalendar_feed'][0]); if(isset($ical->cal) == false): ?>
                    
                                    <small style="color:red;"><?php _e('Invalid iCalendar Feed','wpia');?></small>
                                    <?php endif; endif;?>
                                    </td>
                                </tr>
                            </tbody>           
                        </table>
                                          
                    </div>
                </div>
            </div>   
            
            
            
            
            <br />
            <input type="submit" id="edit-form-save" class="button button-primary saveCalendar" value="<?php echo __('Save Changes','wpia');?>" />
            </form>
        </div>
    <?php else:?>
        <?php echo __('Invalid calendar ID.','wpia')?>
    <?php endif;?>     
</div>

