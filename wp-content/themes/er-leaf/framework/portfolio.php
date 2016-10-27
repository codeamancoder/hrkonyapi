<?php

/**
* Register Portfolio Custom Post Type
*/

function er_leaf_portfolio() {
  
  $portfolio_slug = get_theme_mod('text_portfolioslug') ? get_theme_mod('text_portfolioslug') : 'portfolio';

  $labels = array(
    'name'               => __('Portfolio','er_leaf'),
    'singular_name'      => __('Portfolio','er_leaf'),
    'add_new'            => __('Add New','er_leaf'),
    'add_new_item'       => __('Add New Project','er_leaf'),
    'edit_item'          => __('Edit Project','er_leaf'),
    'new_item'           => __('New Project','er_leaf'),
    'all_items'          => __('All Projects','er_leaf'),
    'view_item'          => __('View Project','er_leaf'),
    'search_items'       => __('Search Project','er_leaf'),
    'not_found'          => __('No projects found','er_leaf'),
    'not_found_in_trash' => __('No projects found in Trash','er_leaf'),
    'parent_item_colon'  => __('','er_leaf'),
    'menu_name'          => __('Portfolio','er_leaf')
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => $portfolio_slug ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'thumbnail' )
  );

  register_post_type( 'portfolio', $args );
}
add_action( 'init', 'er_leaf_portfolio' );

/**
* Register Portfolio Taxonomies
*/

function er_leaf_portfolio_taxonomies() {

  	$portfolio_cat_slug = get_theme_mod('text_portfolio_category_slug') ? get_theme_mod('text_portfolio_category_slug') : 'portfolio_categoy';
  	$portfolio_tag_slug = get_theme_mod('text_portfolio_tag_slug') ? get_theme_mod('text_portfolio_tag_slug') : 'portfolio_tag';

	// Portfolio categories taxonomy
	$labels = array(
		'name'              => __( 'Categories', 'er_leaf' ),
		'singular_name'     => __( 'Category', 'er_leaf' ),
		'search_items'      => __( 'Search Categories', 'er_leaf' ),
		'all_items'         => __( 'All Categories', 'er_leaf' ),
		'parent_item'       => __( 'Parent Category', 'er_leaf' ),
		'parent_item_colon' => __( 'Parent Category:', 'er_leaf' ),
		'edit_item'         => __( 'Edit Category', 'er_leaf' ),
		'update_item'       => __( 'Update Category' , 'er_leaf'),
		'add_new_item'      => __( 'Add New Category', 'er_leaf' ),
		'new_item_name'     => __( 'New Category Name', 'er_leaf' ),
		'menu_name'         => __( 'Category', 'er_leaf' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $portfolio_cat_slug ),
	);

	register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );

	// Portfolio tags taxonomy
	$labels = array(
		'name'              => __( 'Tags', 'er_leaf' ),
		'singular_name'     => __( 'Tag', 'er_leaf' ),
		'search_items'      => __( 'Search Tags', 'er_leaf' ),
		'all_items'         => __( 'All Tags', 'er_leaf' ),
		'parent_item'       => __( 'Parent Tag', 'er_leaf' ),
		'parent_item_colon' => __( 'Parent Tag:', 'er_leaf' ),
		'edit_item'         => __( 'Edit Tag', 'er_leaf' ),
		'update_item'       => __( 'Update Tag' , 'er_leaf'),
		'add_new_item'      => __( 'Add New Tag', 'er_leaf' ),
		'new_item_name'     => __( 'New Tag Name', 'er_leaf' ),
		'menu_name'         => __( 'Tag', 'er_leaf' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $portfolio_tag_slug ),
	);

	register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );
}

add_action( 'init', 'er_leaf_portfolio_taxonomies', 0 );