<?php

/**
* Register meta boxed
*/

$prefix = 'er_leaf_';
global $meta_boxes;
$meta_boxes = array();

// Get Revolution Slider
$revolutionslider = array();
$revolutionslider[0] = 'No Slider';
$revolutionslider[1] = 'Flex Slider';

if(class_exists('RevSlider')){
    $slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	foreach($arrSliders as $revSlider) { 
		$revolutionslider[$revSlider->getAlias()] = $revSlider->getTitle();
	}
}

// Custom Heading
$meta_boxes[] = array(

	'id' => 'custom_heading',
	'title' => __( 'Custom Heading', 'er_leaf' ),
	'pages' => array( 'post', 'page' ),
	'context' => 'normal',
	'priority' => 'high',
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		array(
			'name' => __( 'Heading Background Image', 'er_leaf' ),
			'id'   => "{$prefix}heading_bg",
			'type'             => 'image_advanced',
			'max_file_uploads' => 1,
		),
		array(
			'name' => __( 'Custom Heading Title', 'er_leaf' ),
			'id'   => "{$prefix}heading_title",
			'type'             => 'textarea',
		),
		array(
			'name' => __( 'Custom Heading HTML Code', 'er_leaf' ),
			'id'   => "{$prefix}heading_custom_code",
			'type'             => 'textarea',
		),
		array(
			'name'		=> 'Slider',
			'id'		=> $prefix . "revolutionslider",
			'type'		=> 'select',
			'options'	=> $revolutionslider,
			'multiple'	=> false,
		),
	)
);

// Slider Infomations
$meta_boxes[] = array(

	'id' => 'slider_info',
	'title' => __( 'Slider Infomations', 'er_leaf' ),
	'pages' => array( 'slider'),
	'context' => 'normal',
	'priority' => 'high',
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		array(
			'name' => __( 'Slide Description', 'er_leaf' ),
			'id'   => "{$prefix}slide_description",
			'type' => 'wysiwyg',
			'raw'  => false,
			'std'  => __( 'Edit slide description here ...', 'er_leaf' ),
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
		array(
			'name'  => __( 'Slide URL', 'er_leaf' ),
			'id'    => "{$prefix}slide_link",
			'desc'  => __( 'URL of current slide', 'er_leaf' ),
			'type'  => 'url',
			'std'   => 'http://',
		),
	)
);

// Custom Page Templates
$meta_boxes[] = array(

	'id' => 'custom_page_settings',
	'title' => __( 'Custom Page Settings', 'er_leaf' ),
	'pages' => array( 'page' ),
	'context' => 'side',
	'priority' => 'low',
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		array(
			'name' => __( 'Choose page with & sidebar', 'er_leaf' ),
			'id'   => "{$prefix}page_sidebar",
			'type'             => 'select',
			'options'  => array(
				'content-sidebar' => __( 'Right sidebar', 'er_leaf' ),
				'sidebar-content' => __( 'Left Sidebar', 'er_leaf' ),
				'fullwidth' => __( 'Full Width', 'er_leaf' ),
			),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'content-sidebar',
		),

		array(
			'name' => __( 'Show Page Heading', 'er_leaf' ),
			'id'   => "{$prefix}page_heading",
			'type' => 'checkbox',
			'std'  => 1,
		),

		array(
			'name' => __( 'Show Page Title', 'er_leaf' ),
			'id'   => "{$prefix}page_title",
			'type' => 'checkbox',
			'std'  => 1,
		),

		array(
			'name' => __( 'Show Page Share', 'er_leaf' ),
			'id'   => "{$prefix}page_share",
			'type' => 'checkbox',
			'std'  => 1,
		),
	)
);

// Custom Page Templates
$meta_boxes[] = array(

	'id' => 'portfolio_page_option',
	'title' => __( 'Portfolio Page Option (Only apply when select Portfolio Filter Page Templates)', 'er_leaf' ),
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'low',
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		array(
			'name' => __( 'Choose portfolio column item', 'er_leaf' ),
			'id'   => "{$prefix}portfolio_columns",
			'type'             => 'select',
			'options'  => array(
				'col-3' => __( '4 Columns', 'er_leaf' ),
				'col-4' => __( '3 Columns', 'er_leaf' ),
				'col-6' => __( '2 Columns', 'er_leaf' ),
			),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'col-3',
		),

		array(
			'name' => __( 'Items per page', 'er_leaf' ),
			'id'   => "{$prefix}portfolio_item_per_page",
			'type'             => 'text',
			'std'         => '12',
		),

		array(
			'name' => __( 'Enable Filter', 'er_leaf' ),
			'id'   => "{$prefix}portfolio_enable_filter",
			'type' => 'checkbox',
			'std'         => 1,
		),
	)
);

// Custom Portfolio Infomations
$meta_boxes[] = array(

	'id' => 'portfolio_infomations',
	'title' => __( 'Portfolio Infomations', 'er_leaf' ),
	'pages' => array( 'portfolio' ),
	'context' => 'normal',
	'priority' => 'high',
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		array(
			'type' => 'heading',
			'name' => __( 'Project Detail', 'er_leaf' ),
			'id'   => 'heading_1', 
		),
		array(
			'name' => __( 'Content', 'er_leaf' ),
			'id'   => "{$prefix}project_detail",
			'type' => 'wysiwyg',
			'raw'  => false,
			'std'  => __( 'Edit project detail here ...', 'er_leaf' ),
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
		array(
			'type' => 'heading',
			'name' => __( 'Project Infomations', 'er_leaf' ),
			'id'   => 'heading_2', 
		),
		array(
			'name'  => __( 'Author', 'er_leaf' ),
			'id'    => "{$prefix}project_author",
			'desc'  => __( 'Author of project', 'er_leaf' ),
			'type'  => 'text',
			'std'   => __( '', 'er_leaf' ),
			'clone' => false,
		),
		array(
			'name'  => __( 'Partner', 'er_leaf' ),
			'id'    => "{$prefix}project_parner",
			'desc'  => __( 'Your Partner', 'er_leaf' ),
			'type'  => 'text',
			'std'   => __( '', 'er_leaf' ),
			'clone' => false,
		),
		array(
			'name'  => __( 'Customer', 'er_leaf' ),
			'id'    => "{$prefix}project_customer",
			'desc'  => __( 'Your Customer', 'er_leaf' ),
			'type'  => 'text',
			'std'   => __( '', 'er_leaf' ),
			'clone' => false,
		),
		array(
			'name'  => __( 'Release Date', 'er_leaf' ),
			'id'    => "{$prefix}project_release_date",
			'desc'  => __( 'Project Release Date', 'er_leaf' ),
			'type'  => 'text',
			'std'   => __( '', 'er_leaf' ),
			'clone' => false,
		),
		array(
			'name'  => __( 'Project Link', 'er_leaf' ),
			'id'    => "{$prefix}project_link",
			'desc'  => __( 'URL of your project', 'er_leaf' ),
			'type'  => 'url',
			'std'   => 'http://',
		),
		array(
			'name'  => __( 'Cusom Field', 'er_leaf' ),
			'id'    => "{$prefix}project_custom_field",
			'desc'  => __( 'Add your custom field', 'er_leaf' ),
			'type'  => 'textarea',
			'std'   => '[field title="Country"]Canada[/field]',
		),
		array(
			'type' => 'heading',
			'name' => __( 'Project Images', 'er_leaf' ),
			'id'   => 'heading_3', 
		),
		array(
			'name'             => __( 'Upload your project images', 'er_leaf' ),
			'id'               => "{$prefix}project_images",
			'type'             => 'image_advanced',
			'max_file_uploads' => 4,
		),
	)
);

function er_leaf_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
add_action( 'admin_init', 'er_leaf_register_meta_boxes' );