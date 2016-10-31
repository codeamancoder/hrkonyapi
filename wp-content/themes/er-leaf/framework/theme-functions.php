<?php

global $smof_data;

/**
 * Register custom meta box
 *
 * @since ER-Leaf 1.0
 */
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/framework/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/framework/meta-box' ) );
require_once RWMB_DIR . 'meta-box.php';
include get_template_directory().'/framework/metabox.php';

/**
 * Add custom contact methods
 *
 * @since ER-Leaf 1.0
 */
add_filter('user_contactmethods', 'er_user_contactmethods');            
function er_user_contactmethods($user_contactmethods){  
    $user_contactmethods['twitter'] = 'Twitter';  
    $user_contactmethods['facebook'] = 'Facebook'; 
    $user_contactmethods['linkedin'] = 'LikedIn'; 
    $user_contactmethods['pinterest'] = 'Pinterest';
    $user_contactmethods['googleplus'] = 'Google Plus';
    return $user_contactmethods;  
}  

/**
 * Breadcrumb
 * @require breadcrumb.php
 *
 * @since ER-Leaf 1.0
 */
require_once 'breadcrumb.php';
function er_leaf_breadcrumb() {

	$templates = array(
		'before' => '<ul id="crumbs" class="clearfix">',
		'after' => '</ul>',
		'standard' => '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">%s</li>',
		'current' => '<li class="current">%s</li>',
		'link' => '<a href="%s" itemprop="url"><span itemprop="title">%s</span></a>'
	);
	$options = array(
		'show_htfpt' => true
	);

	$breadcrumb = new DS_WP_Breadcrumb( $templates, $options );
}

/**
 * Formatting Allowed Tags
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_formatting_allowedtags() {

	return apply_filters(
		'er_leaf_formatting_allowedtags',
		array(
			'a'          => array( 'href' => array(), 'title' => array(), ),
			'b'          => array(),
			'blockquote' => array(),
			'br'         => array(),
			'div'        => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
			'em'         => array(),
			'i'          => array(),
			'p'          => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
			'span'       => array( 'align' => array(), 'class' => array(), 'style' => array(), ),
			'strong'     => array(),
		)
	);

}

/**
 * Page Navigation
 *
 * @since ER-Leaf 1.0
 */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
 
/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */  
function er_leaf_pagenavi($before = '', $after = '') { 
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = '&#8594;';
    $pagenavi_options['prev_text'] = '&#8592;';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
     
    //If NOT a single Post is being displayed
    /*http://codex.wordpress.org/Function_Reference/is_single)*/
    if (!is_single()) {
        $request = $wp_query->request;
        //intval — Get the integer value of a variable
        /*http://php.net/manual/en/function.intval.php*/
        $posts_per_page = intval(get_query_var('posts_per_page'));
        //Retrieve variable in the WP_Query class.
        /*http://codex.wordpress.org/Function_Reference/get_query_var*/
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
         
        //empty — Determine whether a variable is empty
        /*http://php.net/manual/en/function.empty.php*/
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
         
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        //ceil — Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
         
        if($start_page <= 0) {
            $start_page = 1;
        }
         
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
         
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
         
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }  
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /*http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before.'<div class="pagenavi">'."\n";
             
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span>';
            }
            //Displays a link to the previous post which exists in chronological order from the current post.
            /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
            previous_posts_link($pagenavi_options['prev_text']);
             
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /*http://codex.wordpress.org/Data_Validation*/
                //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">1</a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }
             
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
             
            for($i = $start_page; $i  <= $end_page; $i++) {                     
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="current">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
             
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$max_page.'</a>';
            }
            next_posts_link($pagenavi_options['next_text'], $max_page);
             
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div>'.$after."\n";
        }
    }
}

/**
 * Show Google Web Fonts URL
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_google_font(){
    
    $body_font = get_theme_mod('font_body');

    $heading1 = get_theme_mod('font_h1');
    $heading2 = get_theme_mod('font_h2');
    $heading3 = get_theme_mod('font_h3');
    $heading4 = get_theme_mod('font_h4');
    $heading5 = get_theme_mod('font_h5');
    $heading6 = get_theme_mod('font_h6');

    $widget_title_font = get_theme_mod('font_widget_title');
    $widget_border = get_theme_mod('border_top_widget_title');
    $widget_content = get_theme_mod('font_sidebar_widget');
    $footer_widget = get_theme_mod('font_footerheadline');
    $font_nav = get_theme_mod('font_nav');
    $callus_font = get_theme_mod('font_callus');
    $top_widget = get_theme_mod('font_top_widget_heading');

    $custom_font = '';
    $count = 0;
    $out = '';
    $default = array(
                    'arial',
                    'verdana',
                    'trebuchet',
                    'georgia',
                    'times',
                    'tahoma',
                    'helvetica');

    $google_fonts = array(
                    $body_font['face'],
                    $heading1['face'],
                    $heading2['face'],
                    $heading3['face'],
                    $heading4['face'],
                    $heading5['face'],
                    $heading6['face'],
                    $top_widget['face'],
                    $callus_font['face'],
                    $font_nav['face'],
                    $widget_title_font['face'],
                    $widget_content['face'],
                    $footer_widget['face'],
                    );
    
    $google_fonts_unique = array_unique($google_fonts);
    
    foreach($google_fonts_unique as $get_fonts) {
        if(!in_array($get_fonts, $default)) {
                $custom_font = str_replace(' ', '+', $get_fonts). ':300,400,400italic,500,600,700,700italic|' . $custom_font;
        }
    }
    
    if($custom_font != ''){
        $out = "@import url('https://fonts.googleapis.com/css?family=" . substr_replace($custom_font ,"",-1) . "&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese');";
    }

    return $out;
}

/**
 * Get custom post type terms links
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_custom_taxonomies_terms_links($taxonomy) {
    global $post, $post_id;
    // get post by post id &get_post
    $post = get_post($post->ID);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $terms = get_the_terms( $post->ID, $taxonomy );
    if ( !empty( $terms ) ) {
        $out = array();
        foreach ( $terms as $term )
            $out[] = '<a title="'.$term->name.'" href="' .get_term_link($term->slug, $taxonomy) .'">'.$term->name.'</a>';
        $return = join( ', ', $out );
    }
    return $return;
}

/**
 * Get custom post type terms slig
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_custom_taxonomies_terms_slug($taxonomy) {
    global $post, $post_id;
    // get post by post id
    $post = get_post($post->ID);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $terms = get_the_terms( $post->ID, $taxonomy );
    if ( !empty( $terms ) ) {
        $out = array();
        foreach ( $terms as $term )
            $out[] = $term->slug;
        $return = join( ' ', $out );
    }
    return $return;
}

/**
 * Creat random string
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $str = '';
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}

/**
 * Get first image of portfolio item
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_get_firt_meta_image($key){
    global $post, $post_id;
    $count = 0;
    $images = rwmb_meta( $key, 'type=image' );
    foreach ( $images as $image )
    {
        if($count++ == 1)
        $ret = $image['full_url'];
    }
    return $ret;
}

/**
* Add icon to Menu
*
* @since ER-Leaf 1.0
*/
class er_leaf_menu_icon_walker extends Walker_Nav_Menu {  
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {  
        global $wp_query;  
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';  
  
        $class_names = $value = '';  
  
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;  
  
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );  
        $class_names = ' class="'. esc_attr( $class_names ) . '"';  
  
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';  
  
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';  
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';  
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';  
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';  
        $description  = ! empty( $item->custom ) ? '<i class="icon-'.esc_attr( $item->custom ).'"></i>' : '';  
  
        if($depth != 0) {  
            $description = $append = $prepend = "";  
        }  
  
        $item_output = $args->before;  
        $item_output .= '<a'. $attributes .'>';  
        $item_output .= $description.$args->link_before;
        $item_output .= $args->link_after .apply_filters( 'the_title', $item->title, $item->ID );    
        $item_output .= '</a>';  
        $item_output .= $args->after;  
  
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );  
    }  
}