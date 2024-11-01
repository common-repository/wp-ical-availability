<?php
class wpia_widget extends WP_Widget {
    public function __construct() {
        parent::__construct(false, $name = 'WP iCalendar Feed', array(
            'description' => 'WP iCalendar Feed Widget'
        ));
    }
    function widget($args, $instance) {
        global $post;
        extract( $args );        
        
        echo $args['before_widget'];
        
        echo '<div class="wpia-widget">';       
        echo do_shortcode('[wpia id="'.$instance['wpia_select_calendar'].'" title="'.$instance['wpia_show_title'].'"  language="'.$instance['wpia_calendar_language'].'"]'); 
        echo '</div>';
        
        
        
        echo $args['after_widget'];

    }
    function update($new_instance, $old_instance) {
        return $new_instance;
    }
    function form($instance) {
        global $wpdb;
        
        
        $calendarId = 0; if(!empty($instance['wpia_select_calendar'])) 
            $calendarId = $instance['wpia_select_calendar'];
        
        $showTitle = 'yes'; if(!empty($instance['wpia_show_title'])) 
            $showTitle = $instance['wpia_show_title'];
            
      
      
  
        
        $calendarLanguage = 'en'; if(!empty($instance['wpia_calendar_language'])) 
            $calendarLanguage = $instance['wpia_calendar_language'];
        
     
      
    
            

            
        $sql = 'SELECT * FROM ' . $wpdb->base_prefix . 'wpia_calendars';
        $rows = $wpdb->get_results( $sql, ARRAY_A );
        
        
        ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('wpia_select_calendar'); ?>"><?php _e('Calendar', "wpia");?></label>
            <select name="<?php echo $this->get_field_name('wpia_select_calendar'); ?>" id="<?php echo $this->get_field_id('wpia_select_calendar'); ?>" class="widefat">
            <?php foreach($rows as $calendar):?>
                <option<?php if($calendar['calendarID']==$calendarId) echo ' selected="selected"';?> value="<?php echo $calendar['calendarID'];?>"><?php echo $calendar['calendarTitle'];?></option>
            <?php endforeach;?>   
            </select>
         </p>   
         <p>
            <label for="<?php echo $this->get_field_id('wpia_show_title'); ?>"><?php _e('Display title?', "wpia");?></label>
            <select name="<?php echo $this->get_field_name('wpia_show_title'); ?>" id="<?php echo $this->get_field_id('wpia_show_title'); ?>" class="widefat">
                <option value="yes"><?php _e('Yes', "wpia");?></option>
                <option value="no"<?php if($showTitle=='no'):?> selected="selected"<?php endif;?>><?php _e('No', "wpia");?></option>
            </select>
         </p>   
       
      
        <p>    
            <label for="<?php echo $this->get_field_id('wpia_calendar_language'); ?>"><?php _e('Language', "wpia");?></label>
            <select name="<?php echo $this->get_field_name('wpia_calendar_language'); ?>" id="<?php echo $this->get_field_id('wpia_calendar_language'); ?>" class="widefat">
                <?php $activeLanguages = json_decode(get_site_option('wpia-languages'),true);?>
                <option value="auto"><?php _e('Auto (let WP choose)', "wpia");?></option>
                <?php foreach($activeLanguages as $code => $language):?>
                    <option value="<?php echo $code;?>"<?php if($calendarLanguage == $code):?> selected="selected"<?php endif;?>><?php echo $language;?></option>
                <?php endforeach;?>   
            </select>
        </p>
     
        <?php
    }
}
function wpia_register_widget() {
	register_widget( 'wpia_widget' );
}
add_action( 'widgets_init', 'wpia_register_widget' );