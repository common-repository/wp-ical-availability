<?php
add_action('media_buttons', 'wpia_add_form_button', 20);
function wpia_add_form_button(){
    $is_post_edit_page = in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'));
    if(!$is_post_edit_page)
        return;

    // do a version check for the new 3.5 UI
    $version = get_bloginfo('version');

    if ($version < 3.5) {
        // show button for v 3.4 and below
        $image_btn =  WPIA_PATH.'/images/date-button.gif';
        echo '<a href="#TB_inline?width=480&inlineId=wpia_add_calendar" class="thickbox" id="add_wpia" title=""><img src="'.$image_btn.'" alt="' . __("Add Calendar", 'wpia') . '" /></a>';
    } else {
        // display button matching new UI
        echo '<style>.wpia_media_icon{
                background:url('.WPIA_PATH.'/images/date-button.gif) no-repeat top left;
                display: inline-block;
                height: 16px;
                margin: 0 2px 0 0;
                vertical-align: text-top;
                width: 16px;
                }
                .wp-core-ui a.wpia_media_link{
                 padding-left: 0.4em;
                }
                
             </style>
              <a href="#TB_inline?width=640&height=650&inlineId=wpia_add_calendar" class="thickbox button wpia_media_link" id="add_wpia" title="' . __("Add Calendar", 'wpia') . '"><span class="wpia_media_icon "></span> ' . __("Add Calendar", "wpia") . '</a>';
    }
}

add_action('admin_footer',  'wpia_add_mce_popup');    
function wpia_add_mce_popup(){
    global $wpdb;
    ?>
    <script>
        function wpia_insert_shortcode(){
            var calendar_id = jQuery("#wpia_calendar_id").val();
            if(calendar_id == ""){
                alert("<?php _e("Please select a form", "wpia") ?>");
                return;
            }

            var wpia_calendar_title = jQuery("#wpia_calendar_title").val();
            
          
            var wpia_calendar_language = jQuery("#wpia_calendar_language").val();
           

            
            

            window.send_to_editor('[wpia id="' + calendar_id + '" title="' + wpia_calendar_title + '" language="' + wpia_calendar_language + '"]');
        }
    </script>

    <div id="wpia_add_calendar" style="display:none;">
        <div class="wrap wpia-shortcode-button-wrap">
            <div>
                <div style="padding:15px 15px 0 15px;">
                    <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert A Calendar", "wpia"); ?></h3>
                    <span>
                        <?php _e("Select a calendar below to add it to your post or page.", "wpia"); ?>
                    </span>
                </div>
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong><?php _e("Calendar", "wpia"); ?></strong><br />
                    <select id="wpia_calendar_id" style="width: 160px;">                
                        <?php $sql = 'SELECT * FROM ' . $wpdb->base_prefix . 'wpia_calendars';?>
                        <?php $rows = $wpdb->get_results( $sql, ARRAY_A );?>                         
                        <?php foreach($rows as $calendar):?>
                            <option value="<?php echo absint($calendar['calendarID']) ?>"><?php echo esc_html($calendar['calendarTitle']) ?></option>
                        <?php endforeach; ?>
                    </select> <br/>
                    
                </div>
                
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong><?php _e("Display title?", "wpia"); ?></strong><br />
                    <select id="wpia_calendar_title" style="width: 160px;">
                        <option value="yes"><?php _e("Yes", "wpia"); ?></option>
                        <option value="no"><?php _e("No", "wpia"); ?></option>                        
                    </select> <br/>                    
                </div>
                
            
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong><?php _e("Language", "wpia"); ?></strong><br />
                    <select id="wpia_calendar_language" style="width: 160px;">
                        <?php $activeLanguages = json_decode(get_site_option('wpia-languages'),true);?>
                            <option value="auto">Auto (let WP choose)</option>
                        <?php foreach($activeLanguages as $code => $language):?>
                            <option value="<?php echo $code;?>"><?php echo $language;?></option>
                        <?php endforeach;?>                   
                    </select> <br/>                    
                </div>
             
               
                <div style="clear:left; padding:15px;">
                    <input type="button" class="button-primary" value="<?php _e("Insert Calendar", "wpia"); ?>" onclick="wpia_insert_shortcode();"/>&nbsp;&nbsp;&nbsp;
                <a class="button"  href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "wpia"); ?></a>
                </div>
            </div>
        </div>
    </div>

    <?php
}