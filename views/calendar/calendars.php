<?php global $wpdb;?>
<div class="wrap wpia-wrap">
    <div id="icon-themes" class="icon32"></div>
    
    <?php $sql = 'SELECT * FROM ' . $wpdb->prefix . 'wpia_calendars LIMIT 1';?>
    <?php $rows = $wpdb->get_results( $sql, ARRAY_A );?>
       
    <h2>WP iCal Availability
    <?php if( current_user_can(MIN_USER_CAPABILITY) && $wpdb->num_rows == 0):?>
    <a href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=edit-calendar');?>" class="add-new-h2"><?php echo __('Add New','wpia');?></a>
    <?php else:?>
    <a href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=full-version');?>" class="add-new-h2"><?php echo __('Add New','wpia');?></a>
    <?php endif;?>
    </h2>
    <?php if(!empty($status) && $status == 1):?>
    <div id="message" class="updated">
        <p><?php echo __('The calendar was updated','wpia')?></p>
    </div>
    <?php endif;?>


    
    <?php if($wpdb->num_rows > 0):?>
    <table class="widefat wp-list-table wpia-table wpia-table-calendars wpia-table-800">
        <thead>
            <tr>
                <th class="wpia-table-id"><?php echo __('ID','wpia')?></th>
                <th><?php echo __('Calendar Title','wpia')?></th>   
                <th><?php echo __('Date Created','wpia')?></th>
                <th><?php echo __('Date Modified','wpia')?></th>
            </tr>
        </thead>
       
        <tbody>                
            <?php $i=0; foreach($rows as $calendar): ?>
            <tr<?php if($i++%2==0):?> class="alternate"<?php endif;?>>
                <td class="wpia-table-id">#<?php echo $calendar['calendarID']; ?></td>
                <td class="post-title page-title column-title">
                    <strong><a class="row-title" href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=edit-calendar&id=' . $calendar['calendarID']);?>"><?php echo $calendar['calendarTitle']; ?></a></strong>
                    <div class="row-actions">
                        <span class="edit"><a href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=edit-calendar&id=' . $calendar['calendarID']);?>" title="<?php echo __('Edit this item','wpia');?>"><?php echo __('Edit','wpia');?></a> | </span>
                        <span class="trash"><a onclick="return confirm('<?php echo __('Are you sure you want to delete this calendar?','wpia');?>');" class="submitdelete" href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=calendar-delete&id=' . $calendar['calendarID'] . '&noheader=true');?>"><?php echo __('Delete','wpia');?></a></span>
                    </div>
                </td>
                <td><?php echo wpia_timeFormat($calendar['createdDate'])?></td>
                <td><?php echo wpia_timeFormat($calendar['modifiedDate']) ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php else:?>
        <?php echo __('No calendars found.','wpia')?> <a href="<?php echo admin_url( 'admin.php?page=wp-ical-availability&do=edit-calendar');?>"><?php echo __('Click here to create your first calendar.','wpia');?></a>        
        
    <?php endif;?>
    
    <?php include(WPIA_DIR_PATH . '/views/calendar/full-version.php');?>
</div>