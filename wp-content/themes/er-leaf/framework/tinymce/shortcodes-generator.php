<?php


add_action('init', 'add_button'); 

function add_button() {  
	if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  {  
		add_filter('mce_external_plugins', 'add_plugin');  
		add_filter('mce_buttons_3', 'register_columns');
		add_filter('mce_buttons_3', 'register_elements');
		add_filter('mce_buttons_3', 'register_helper');
	}  
}  


function register_columns($buttons) {   	
    array_push($buttons, "columns");  	
    return $buttons;  
} 

function register_elements($buttons) {   	
    array_push($buttons,"elements");  	
    return $buttons;  
}

function register_helper($buttons) {   	
    array_push($buttons,"helpers");  	
    return $buttons;  
}

function add_plugin($plugin_array) {  
    $plugin_array['shortcodes'] = get_template_directory_uri().'/framework/tinymce/shortcodes.js';  
    return $plugin_array;  
}  

if(is_admin()){
  add_action('admin_init', 'add_admin_scripts');
}

function add_admin_scripts() {
    wp_enqueue_script( 'shortcodes', get_template_directory_uri() . '/framework/tinymce/shortcodelocalization.js');
    wp_localize_script( 'shortcodes', 'objectL10n', array(
        
        'columns_title'         => __('Columns','er_leaf'),
        'elements_title'        => __('Elements','er_leaf'),
        'helpers_title'         => __('Helper','er_leaf'),

        'cols_title'            => __('Columns Wrap','er_leaf'),
        'col_1_title'           => __('Col-1','er_leaf'),
        'col_2_title'           => __('Col-2','er_leaf'),
        'col_3_title'           => __('Col-3','er_leaf'),
        'col_4_title'           => __('Col-4','er_leaf'),
        'col_5_title'           => __('Col-5','er_leaf'),
        'col_6_title'           => __('Col-6','er_leaf'),
        'col_7_title'           => __('Col-7','er_leaf'),
        'col_8_title'           => __('Col-8','er_leaf'),
        'col_9_title'           => __('Col-9','er_leaf'),
        'col_10_title'          => __('Col-10','er_leaf'),
        'col_11_title'          => __('Col-11','er_leaf'),
        'col_12_title'          => __('Col-12','er_leaf'),

        'accordion_title'       => __('Accordion','er_leaf'),
        'notification_title'    => __('Notification','er_leaf'),
        'button_title'          => __('Button','er_leaf'),
        'toggle_title'          => __('Toggle','er_leaf'),
        'skill_title'           => __('Skill','er_leaf'),
        'progress_title'        => __('Progress','er_leaf'),
        'service_title'         => __('Service','er_leaf'),
        'team_title'            => __('Team','er_leaf'),
        'infobox_title'         => __('InfoBox','er_leaf'),
        'callout_title'         => __('Callout','er_leaf'),
        'mapbox_title'          => __('Map Box','er_leaf'),
        'vmenu_title'           => __('Vertical Menu','er_leaf'),
        'googlefont_title'      => __('Google Font','er_leaf'),
        'video_title'           => __('Video','er_leaf'),
        'map_title'             => __('Map','er_leaf'),
        'icon_title'            => __('Icon','er_leaf'),
        'list_title'            => __('List','er_leaf'),
        'block_title'           => __('Block','er_leaf'),
        'blockquote_title'      => __('Blockquote','er_leaf'),
        'hl_title'              => __('High Light','er_leaf'),
        'pricing_title'         => __('Pricing','er_leaf'),
        'tab_title'             => __('Tab','er_leaf'),
        'posts_title'           => __('Posts','er_leaf'),
        'postlist_title'        => __('Posts List','er_leaf'),
        'portfolio_title'       => __('Portfolio','er_leaf'),
        'slider_title'          => __('Slider','er_leaf'),
        'imgslider_title'       => __('Images Slider','er_leaf'),
        'dropcap_title'         => __('Dropcap','er_leaf'),
        'highlight_title'       => __('Highlight','er_leaf'),
        'heading_title'         => __('Heading','er_leaf'),

        'section_title'         => __('Section','er_leaf'),
        'clear_title'           => __('Clear','er_leaf'),
        'divider_title'         => __('Divider','er_leaf'),
        'raw_title'             => __('Raw','er_leaf'),
        'br_title'              => __('Break','er_leaf')

    ));
}
?>