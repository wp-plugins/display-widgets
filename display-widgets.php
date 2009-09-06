<?php
/*
Plugin Name: Display widgets
Description: Adds checkboxes to each widget to show or hide on site pages.
Author: Stephanie Wells
Version: 1.0
*/

function show_dw_widget($instance){
    $post_id = $GLOBALS['post']->ID;
    $show = $instance['page-'.$post_id]; 
    if (($instance['include'] and $show == false) or ($instance['include'] == 0 and $show))
        return false;
    else
        return true;
}

function dw_show_hide_widget_options($widget, $return, $instance){ 
    $pages = get_posts( array('post_type' => 'page', 'post_status' => 'published', 'numberposts' => 99, 'order_by' => 'post_title', 'order' => 'ASC'));
    
    $instance['include'] = $instance['include'] ? $instance['include'] : 0;
?>   
     <p>
    	<label for="<?php echo $widget->get_field_id('include'); ?>">Show/Don't Show Widget on the following pages</label>
    	<select name="<?php echo $widget->get_field_name('include'); ?>" id="<?php echo $widget->get_field_id('include'); ?>" class="widefat">
            <option value="1" <?php echo selected( $instance['include'], 1 ) ?>>Show on checked</option>
            <option value="0" <?php echo selected( $instance['include'], 0 ) ?>>Don't Show on checked</option> 
        </select>
    </p>    

<div style="height:150px; overflow:auto; border:1px solid #dfdfdf;">
    <?php foreach ($pages as $page){ 
        $instance['page-'.$page->ID] = $instance['page-'.$page->ID] ? $instance['page-'.$page->ID] : false;
            
    ?>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['page-'.$page->ID], true) ?> id="<?php echo $widget->get_field_id('page-'.$page->ID); ?>" name="<?php echo $widget->get_field_name('page-'.$page->ID); ?>" />
        <label for="<?php echo $widget->get_field_id('page-'.$page->ID); ?>"><?php _e($page->post_title) ?></label></p>
    <?php	} 
echo '</div>';        
}


add_filter('widget_display_callback', 'show_dw_widget');
add_action('in_widget_form', 'dw_show_hide_widget_options', 10, 3);
?>