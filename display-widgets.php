<?php
/*
Plugin Name: Display widgets
Plugin URI: http://blog.strategy11.com/display-widgets/
Description: Adds checkboxes to each widget to show or hide on site pages.
Author: Stephanie Wells
Author URI: http://blog.strategy11.com
Version: 1.9
*/
//TODO: Add text field for comma separated list of post ids

function show_dw_widget($instance){
    if (is_home())
        $show = isset($instance['page-home']) ? ($instance['page-home']) : false;
    else if (is_front_page())
        $show = isset($instance['page-front']) ? ($instance['page-front']) : false;
    else if (is_category())
        $show = $instance['cat-'.get_query_var('cat')];
    else if (is_archive())
        $show = $instance['page-archive'];
    else if (is_single()){
        $show = $instance['page-single'];
        if (!$show){
            foreach(get_the_category() as $cat){ 
                if ($show) continue;
                if (isset($instance['cat-'.$cat->cat_ID]))
                    $show = $instance['cat-'.$cat->cat_ID];
            } 
        }
    }else if (is_404()) 
        $show = $instance['page-404'];
    else if (is_search())
        $show = $instance['page-search'];
    else{
        $post_id = $GLOBALS['post']->ID;
        $show = $instance['page-'.$post_id]; 
    }
    if (isset($instance['include']) && (($instance['include'] and $show == false) or ($instance['include'] == 0 and $show)))
        return false;
    else
        return $instance;
}

function dw_show_hide_widget_options($widget, $return, $instance){ 
    $pages = get_posts( array('post_type' => 'page', 'post_status' => 'published', 'numberposts' => 99, 'order_by' => 'post_title', 'order' => 'ASC'));
    $wp_page_types = array('front' => 'Front', 'home' => 'Blog','archive' => 'Archives','single' => 'Single Post','404' => '404', 'search' => 'Search');
    
    $instance['include'] = isset($instance['include']) ? $instance['include'] : 0;
?>   
     <p>
    	<label for="<?php echo $widget->get_field_id('include'); ?>">Show/Hide Widget</label>
    	<select name="<?php echo $widget->get_field_name('include'); ?>" id="<?php echo $widget->get_field_id('include'); ?>" class="widefat">
            <option value="0" <?php echo selected( $instance['include'], 0 ) ?>>Hide on checked</option> 
            <option value="1" <?php echo selected( $instance['include'], 1 ) ?>>Show on checked</option>
        </select>
    </p>    

<div style="height:150px; overflow:auto; border:1px solid #dfdfdf;">
    <p><b>Pages</b></p>
    <?php foreach ($pages as $page){ 
        $instance['page-'.$page->ID] = isset($instance['page-'.$page->ID]) ? $instance['page-'.$page->ID] : false;   
    ?>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['page-'.$page->ID], true) ?> id="<?php echo $widget->get_field_id('page-'.$page->ID); ?>" name="<?php echo $widget->get_field_name('page-'.$page->ID); ?>" />
        <label for="<?php echo $widget->get_field_id('page-'.$page->ID); ?>"><?php _e($page->post_title) ?></label></p>
    <?php	}  ?>
    <p><b>Categories</b></p>
    <?php foreach (get_categories() as $cat){ 
        $instance['cat-'.$cat->cat_ID] = isset($instance['cat-'.$cat->cat_ID]) ? $instance['cat-'.$cat->cat_ID] : false;   
    ?>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['cat-'.$cat->cat_ID], true) ?> id="<?php echo $widget->get_field_id('cat-'.$cat->cat_ID); ?>" name="<?php echo $widget->get_field_name('cat-'.$cat->cat_ID); ?>" />
        <label for="<?php echo $widget->get_field_id('cat-'.$cat->cat_ID); ?>"><?php _e($cat->cat_name) ?></label></p>
    <?php } ?>
    
    <p><b>Miscellaneous</b></p>
    <?php foreach ($wp_page_types as $key => $label){ 
        $instance['page-'. $key] = isset($instance['page-'. $key]) ? $instance['page-'. $key] : false;
    ?>
        <p><input class="checkbox" type="checkbox" <?php checked($instance['page-'. $key], true) ?> id="<?php echo $widget->get_field_id('page-'. $key); ?>" name="<?php echo $widget->get_field_name('page-'. $key); ?>" />
        <label for="<?php echo $widget->get_field_id('page-'. $key); ?>"><?php _e($label .' Page') ?></label></p>
    <?php } ?>
    </div>
<?php        
}

function dw_update_widget_options($instance, $new_instance, $old_instance){
    $pages = get_posts( array('post_type' => 'page', 'post_status' => 'published', 'numberposts' => 99, 'order_by' => 'post_title', 'order' => 'ASC'));
    foreach ($pages as $page)
        $instance['page-'.$page->ID] = $new_instance['page-'.$page->ID] ? 1 : 0;
    foreach (get_categories() as $cat)
        $instance['cat-'.$cat->cat_ID] = $new_instance['cat-'.$cat->cat_ID] ? 1 : 0;
    $instance['include'] = $new_instance['include'] ? 1 : 0;
    $instance['page-front'] = $new_instance['page-front'] ? 1 : 0;
    $instance['page-home'] = $new_instance['page-home'] ? 1 : 0;
    $instance['page-archive'] = $new_instance['page-archive'] ? 1 : 0;
    $instance['page-single'] = $new_instance['page-single'] ? 1 : 0;
    $instance['page-404'] = $new_instance['page-404'] ? 1 : 0;
    $instance['page-search'] = $new_instance['page-search'] ? 1 : 0;
    return $instance;
}


add_filter('widget_display_callback', 'show_dw_widget');
add_action('in_widget_form', 'dw_show_hide_widget_options', 10, 3);
add_filter('widget_update_callback', 'dw_update_widget_options', 10, 3);
?>