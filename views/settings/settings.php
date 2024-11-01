<?php global $wpdb;?>
<div class="wrap wpia-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2><?php echo __('Settings','wpia');?></h2>
    <?php if(!empty($_GET['save']) && $_GET['save'] == 'ok'):?>
    <div id="message" class="updated">
        <p><?php echo __('The settings were saved.','wpia')?></p>
    </div>
    <?php endif;?>
    
        <div class="postbox-container">
            
            <form action="<?php echo admin_url( 'admin.php?page=wp-ical-availability-settings&do=save&noheader=true');?>" method="post">
            <div class="wpia-action-buttons"><input type="submit" class="button button-primary button-h2" value="<?php echo __('Save Changes','wpia');?>" /> </div>
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle"><?php echo __('General Settings','wpia');?></h3>
                    <div class="inside">     
                        <?php $wpiaOptions = json_decode(get_site_option('wpia-options'),true);?>  
                        
                        <div class="wpia-settings-col">
                            <div class="wpia-settings-col-left">
                                <strong><?php echo __("Use split days",'wpia') ;?></strong>                                
                            </div>
                            <div class="wpia-settings-col-right">
                                <select name="date-type">
                                    <option <?php if(!empty($wpiaOptions['displayDays']) && $wpiaOptions['displayDays'] == 1):?>selected="selected"<?php endif;?> value="1"><?php _e('Yes','wpia');?></option>
                                    <option <?php if(!empty($wpiaOptions['displayDays']) && $wpiaOptions['displayDays'] == 2):?>selected="selected"<?php endif;?> value="2"><?php _e('No','wpia');?></option>
                                    
                                </select>
                            </div> 
                            <div class="wpia-clear"></div>                            
                        </div>   

                        <div class="wpia-settings-col">
                            <div class="wpia-settings-col-left">
                                <strong><?php echo __('Always enqueue scripts and styles','wpia');?></strong>                                
                            </div>
                            <div class="wpia-settings-col-right">
                                <select name="always-enqueue-scripts">
                                    <option <?php if(!empty($wpiaOptions['alwaysEnqueueScripts']) && $wpiaOptions['alwaysEnqueueScripts'] == 'no'):?>selected="selected"<?php endif;?> value="no"><?php _e('No');?></option>
                                    <option <?php if(!empty($wpiaOptions['alwaysEnqueueScripts']) && $wpiaOptions['alwaysEnqueueScripts'] == 'yes'):?>selected="selected"<?php endif;?> value="yes"><?php _e('Yes');?></option>
                                    
                                </select>
                                <br /><small><?php echo __("If you are loading the calendar with ajax then you should set this option to 'Yes'.",'wpia');?></small>
                            </div>
                            <div class="wpia-clear"></div>                            
                        </div> 
                    </div>
                </div>
            </div> 
           
            
            <div class="metabox-holder">
                <div class="postbox">
                    
                    <h3 class="hndle"><?php echo __('Languages','wpia');?></h3>
                    <div class="inside">
                        <?php $activeLanguages = json_decode(get_site_option('wpia-languages'),true);?>
                        <?php $languages = array('en' => 'English', 'bg' => 'Bulgarian','ca' => 'Catalan','hr' => 'Croatian','cz' => 'Czech','da' => 'Danish','nl' => 'Dutch','et' => 'Estonian','fi' => 'Finnish','fr' => 'French','de' => 'German','el' => 'Greek','hu' => 'Hungarian','it' => 'Italian', 'jp' => 'Japanese', 'no' => 'Norwegian','pl' => 'Polish','pt' => 'Portugese','ro' => 'Romanian','ru' => 'Russian','sk' => 'Slovak','sl' => 'Slovenian','es' => 'Spanish','sv' => 'Swedish','tr' => 'Turkish','ua' => 'Ukrainian');?>    
                        <div class="wpia-settings-col">
                            <div class="wpia-settings-col-left">
                                <strong><?php echo __('Languages','wpia');?></strong><br />
                                <small><?php echo __('What languages do you <br />want to use?','wpia');?></small>
                            </div>
                            <div class="wpia-settings-col-right">
                                <?php foreach($languages as $code => $language):?>
                                    <label><input type="checkbox" name="<?php echo $code;?>" <?php if(in_array($language,$activeLanguages)):?>checked="checked"<?php endif;?> value="<?php echo $code;?>" /> <?php echo $language;?></label>
                                <?php endforeach;?>
                            </div>
                            <div class="wpia-clear"></div>
                            
                        </div> 
                        
                    </div>
                </div>
            </div> 
            <br /><input type="submit" class="button button-primary" value="<?php echo __('Save Changes','wpia');?>" /> 
            </form>
        </div>

</div>

