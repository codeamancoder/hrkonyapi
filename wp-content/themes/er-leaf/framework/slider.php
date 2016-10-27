<?php

/**
* Register Slider Custom Post Type
*/

function er_leaf_slider() {
  $labels = array(
    'name'               => __('Slide','er_leaf'),
    'singular_name'      => __('Slide','er_leaf'),
    'add_new'            => __('Add New','er_leaf'),
    'add_new_item'       => __('Add New Slide','er_leaf'),
    'edit_item'          => __('Edit Slide','er_leaf'),
    'new_item'           => __('New Slide','er_leaf'),
    'all_items'          => __('All Slides','er_leaf'),
    'view_item'          => __('View Slide','er_leaf'),
    'search_items'       => __('Search Slide','er_leaf'),
    'not_found'          => __('No slides found','er_leaf'),
    'not_found_in_trash' => __('No slides found in Trash','er_leaf'),
    'parent_item_colon'  => __('','er_leaf'),
    'menu_name'          => __('Slider','er_leaf')
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'slide' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'thumbnail' )
  );

  register_post_type( 'slider', $args );
}
add_action( 'init', 'er_leaf_slider' );

/**
* Show Slider
*/
function er_leaf_show_slide(){ 
    $args = array(
        'post_type' => 'slider',
    );
    $query = new WP_Query( $args );
    if($query->have_posts()):
    ?>
    <section class="slide">
        <div class="flexslider content-slider">
            <ul class="slides">
                <?php while ( $query->have_posts() ):$query->the_post();?>
                <li>
                    <div class="slide-content">
                        <div class="wrap">
                            <h4><?php the_title();?></h4>
                            <div class="text">
                                <?php echo rwmb_meta('er_leaf_slide_description'); ?>
                            </div>
                        </div>          
                    </div>          
                    <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" alt="<?php the_title();?>">
                </li>
                <?php endwhile;?>
            </ul><!-- // .slides -->
        </div><!-- // .flexslider -->
    </section><!-- // .slide -->
<?php endif; }