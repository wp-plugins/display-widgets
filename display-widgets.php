<?php
/*
Plugin Name: Display widgets
Plugin URI: http://blog.strategy11.com/display-widgets/
Description: Adds checkboxes to each widget to show or hide on site pages.
Author: Stephanie Wells
Author URI: http://blog.strategy11.com
Version: 1.5
*/

function show_dw_widget($instance){
    $post_id = $GLOBALS['post']->ID;
    if (is_home())
        $show = $instance['page-home'];
    else if (is_archive())
        $show = $instance['page-archive'];
    else if (is_single())    
        $show = $instance['page-single'];
    else if (is_404()) 
        $show = $instance['page-404'];
    else
        $show = $instance['page-'.$post_id]; 
    
    if (($instance['include'] and $show == false) or ($instance['include'] == 0 and $show))
        return false;
    else
        return $instance;
}

function dw_show_hide_widget_options($widget, $return, $instance){ 
    $pages = get_posts( array('post_type' => 'page', 'post_status' => 'published', 'numberposts' => 99, 'order_by' => 'post_title', 'order' => 'ASC'));
    
    $instance['include'] = $instance['include'] ? $instance['include'] : 0;
?>   
     <p>
    	<label for="<?php echo $widget->get_field_id('include'); ?>">Show/Hide Widget</label>
    	<select name="<?php echo $widget->get_field_name('include'); ?>" id="<?php echo $widget->get_field_id('include'); ?>" class="widefat">
            <option value="0" <?php echo selected( $instance['include'], 0 ) ?>>Hide on checked</option> 
            <option value="1" <?php echo selected( $instance['include'], 1 ) ?>>Show on checked</option>
        </select>
    </p>    

<div style="height:150px; overflow:auto; border:1px solid #dfdfdf;">
    <?php 
    $instance['page-home'] = $instance['page-home'] ? $instance['page-home'] : false;
    $instance['page-archive'] = $instance['page-archive'] ? $instance['page-archive'] : false;
    $instance['page-single'] = $instance['page-single'] ? $instance['page-single'] : false;
    $instance['page-404'] = $instance['page-404'] ? $instance['page-404'] : false;  

    foreach ($pages as $page){ 
        $instance['page-'.$page->ID] = $instance['page-'.$page->ID] ? $instance['page-'.$page->ID] : false;   
    ?>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['page-'.$page->ID], true) ?> id="<?php echo $widget->get_field_id('page-'.$page->ID); ?>" name="<?php echo $widget->get_field_name('page-'.$page->ID); ?>" />
        <label for="<?php echo $widget->get_field_id('page-'.$page->ID); ?>"><?php _e($page->post_title) ?></label></p>
    <?php	}  ?>
    <p><input class="checkbox" type="checkbox" <?php checked($instance['page-home'], true) ?> id="<?php echo $widget->get_field_id('page-home'); ?>" name="<?php echo $widget->get_field_name('page-home'); ?>" />
    <label for="<?php echo $widget->get_field_id('page-home'); ?>"><?php _e('Blog Page') ?></label></p>
    
    <p><input class="checkbox" type="checkbox" <?php checked($instance['page-archive'], true) ?> id="<?php echo $widget->get_field_id('page-archive'); ?>" name="<?php echo $widget->get_field_name('page-archive'); ?>" />
    <label for="<?php echo $widget->get_field_id('page-archive'); ?>"><?php _e('Archives Page') ?></label></p>

    <p><input class="checkbox" type="checkbox" <?php checked($instance['page-single'], true) ?> id="<?php echo $widget->get_field_id('page-single'); ?>" name="<?php echo $widget->get_field_name('page-single'); ?>" />
    <label for="<?php echo $widget->get_field_id('page-single'); ?>"><?php _e('Single Post Page') ?></label></p>
        
    <p><input class="checkbox" type="checkbox" <?php checked($instance['page-404'], true) ?> id="<?php echo $widget->get_field_id('page-404'); ?>" name="<?php echo $widget->get_field_name('page-404'); ?>" />
    <label for="<?php echo $widget->get_field_id('page-404'); ?>"><?php _e('404 Page') ?></label></p>
<?php
echo '</div>';        
}

function dw_update_widget_options($instance, $new_instance, $old_instance){
    $pages = get_posts( array('post_type' => 'page', 'post_status' => 'published', 'numberposts' => 99, 'order_by' => 'post_title', 'order' => 'ASC'));
    foreach ($pages as $page)
        $instance['page-'.$page->ID] = $new_instance['page-'.$page->ID] ? true : false;
    $instance['include'] = $new_instance['include'];
    $instance['page-home'] = $new_instance['page-home'];
    $instance['page-archive'] = $new_instance['page-archive'];
    $instance['page-single'] = $new_instance['page-single'];
    $instance['page-404'] = $new_instance['page-404'];
    return $instance;
}


add_filter('widget_display_callback', 'show_dw_widget');
add_action('in_widget_form', 'dw_show_hide_widget_options', 10, 3);
add_filter('widget_update_callback', 'dw_update_widget_options', 10, 3)
?>