<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

/* ------------------------------------------------------------------------ */
/* General
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "General",
					"type" => "heading");

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "General",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics Code (or other) here.",
					"id" => "textarea_trackingcode",
					"std" => "",
					"type" => "textarea"); 

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Favicons",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Favicon Upload (16x16)",
					"desc" => "Upload your Favicon (16x16px ico/png - use <a href='http://www.favicon.cc/' target='_blank'>favicon.cc</a> to make sure it's fully compatible)",
					"id" => "media_favicon",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Apple iPhone Icon Upload (57x57)",
					"desc" => "Upload your Apple Touch Icon (57x57px png)",
					"id" => "media_favicon_iphone",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Apple iPhone Retina Icon Upload (114x114)",
					"desc" => "Upload your Apple Touch Retina Icon (114x114px png)",
					"id" => "media_favicon_iphone_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Apple iPad Icon Upload (72x72)",
					"desc" => "Upload your Apple Touch Retina Icon (144x144px png)",
					"id" => "media_favicon_ipad",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Apple iPad Retina Icon Upload (144x144px)",
					"desc" => "Upload your Apple Touch Retina Icon (144x144px png)",
					"id" => "media_favicon_ipad_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");

/* ------------------------------------------------------------------------ */
/* Layout
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Layout",
					"type" => "heading");
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Layout Options",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Layout Style",
					"desc" => "Choose your Layout Style",
					"id" => "select_layoutstyle",
					"std" => "Fullwidth",
					"type" => "select",
					"options" => array('Fullwidth', 'Boxed Layout'));	

$of_options[] = array( "name" => "Enable Responsive Design",
					"desc" => "Check to enable Responsive Design",
					"id" => "check_responsive",
					"std" => 1,
					"type" => "checkbox"); 

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Boxed Layout Options (only work when Boxed Layout is enabled)",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Default Background Image",
					"desc" => "Upload default Background or paste Image URL",
					"id" => "media_bg",
					"std" => "",
					"mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select Background Repeat Option for the default Background.",
					"id" => "select_bg",
					"std" => "Stretch Image",
					"type" => "select",
					"options" => array('Stretch Image', 'repeat', 'no-repeat', 'repeat-x', 'repeat-y')
					);
					
$of_options[] = array( "name" => "Default Background Color",
					"desc" => "Select Color for default Background",
					"id" => "color_bg",
					"std" => "#1111",
					"type" => "color"); 
																
/* ------------------------------------------------------------------------ */
/* Header
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Header",
					"type" => "heading");
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Top Bar Options",
					"icon" => false,
					"type" => "info");				

$of_options[] = array( "name" => "Enable Top Widgets",
					"desc" => "Check to enable Top Widgets",
					"id" => "check_topwidgets",
					"std" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Topbar Widget 1 Width",
					"desc" => "Select width of Top Widget 1",
					"id" => "topbar_widget_1_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));	

$of_options[] = array( "name" => "Topbar Widget 2 Width",
					"desc" => "Select width of Top Widget 2",
					"id" => "topbar_widget_2_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));	

$of_options[] = array( "name" => "Topbar Widget 3 Width",
					"desc" => "Select width of Top Widget 3",
					"id" => "topbar_widget_3_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));	

$of_options[] = array( "name" => "Topbar Widget 4 Width",
					"desc" => "Select width of Top Widget 4",
					"id" => "topbar_widget_4_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));	

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Header Options",
					"icon" => false,
					"type" => "info");	

$of_options[] = array( "name" => "Main Menu Style",
					"desc" => "Choose your Main Menu Style",
					"id" => "select_main_menu",
					"std" => "Fullwidth",
					"type" => "select",
					"options" => array('Fullwidth', 'Header Left'));	

$of_options[] = array( "name" => "Company News Heading",
					"desc" => "Enter your Company News Heading",
					"id" => "text_companynews",
					"std" => "Company News",
					"type" => "text");

$of_options[] = array( "name" => "Call Us Text",
					"desc" => "Enter your Call us Text (HTML allowed)",
					"id" => "text_callus",
					"std" => "Call Us: (1)118 234 678 - Mail info@example.com",
					"type" => "textarea"); 

$of_options[] = array( "name" => "Enable Company News",
					"desc" => "Check to enable Company News",
					"id" => "check_companynews",
					"std" => 1,
					"type" => "checkbox"); 

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Logo Options",
					"icon" => false,
					"type" => "info"); 
					
$of_options[] = array( "name" => "Header Height (without px)",
					"desc" => "Header Height (Default: auto)",
					"id" => "style_headerheight",
					"std" => "auto",
					"type" => "text");
					
$of_options[] = array( "name" => "Logo Upload",
					"desc" => "Upload your Logo",
					"id" => "media_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Logo Top Margin",
					"desc" => "Enter your Top margin value for the Logo in pixels (Default: 0px)",
					"id" => "style_logotopmargin",
					"std" => "20px",
					"type" => "text");
					
$of_options[] = array( "name" => "Logo Bottom Margin",
					"desc" => "Enter your Bottom margin value for the Logo in pixels (Default: 0px)",
					"id" => "style_logobottommargin",
					"std" => "0px",
					"type" => "text"); 
										
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Optional: Retina Logo Options",
					"icon" => false,
					"type" => "info");
				
$of_options[] = array( "name" => "Logo Upload Retina",
					"desc" => "Upload your Retina Logo. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)",
					"id" => "media_logo_retina",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => "Original Logo Width",
					"desc" => "If Retina Logo uploaded, please enter the width of the Standard Logo you've uploaded (not the Retina Logo)",
					"id" => "logo_width",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Original Logo Height",
					"desc" => "If Retina Logo uploaded, please enter the height of the Standard Logo you've uploaded (not the Retina Logo)",
					"id" => "logo_height",
					"std" => "",
					"type" => "text");

/* ------------------------------------------------------------------------ */
/* Footer
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Footer",
					"type" => "heading");				

$of_options[] = array( "name" => "Enable Footer Lastest Tweet",
					"desc" => "Check to show lastest tweet in top footer",
					"id" => "check_footertweet",
					"std" => 1,
					"type" => "checkbox"); 

$of_options[] = array( "name" => "Footer Widget 1 Width",
					"desc" => "Select width of Widget 1",
					"id" => "footer_widget_1_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));	

$of_options[] = array( "name" => "Footer Widget 2 Width",
					"desc" => "Select width of Widget 2",
					"id" => "footer_widget_2_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));

$of_options[] = array( "name" => "Footer Column 3 Width",
					"desc" => "Select width of Widget 3",
					"id" => "footer_widget_3_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));

$of_options[] = array( "name" => "Footer Column 4 Width",
					"desc" => "Select width of Widget 4",
					"id" => "footer_widget_4_width",
					"std" => "col-4",
					"type" => "select",
					"options" => array('Disable','col-1','col-2','col-3','col-4','col-5','col-6','col-7','col-8','col-9','col-10','col-11','col-12'));

$of_options[] = array( "name" => "Copyright Text",
					"desc" => "Enter your Copyright Text (HTML allowed)",
					"id" => "textarea_copyright",
					"std" => "Copyright 2013 by EverisLabs. Powered By WordPress",
					"type" => "textarea"); 

/* ------------------------------------------------------------------------ */
/* Typography
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Typography",
					"type" => "heading");
									
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Body",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Body Text Font",
					"desc" => "Specify the Body font properties",
					"id" => "font_body",
					"std" => array('size' => '13px','face' => 'Open Sans','style' => 'normal','color' => '#232323'),
					"type" => "typography");
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Headlines",
					"icon" => false,
					"type" => "info");
				
$of_options[] = array( "name" => "H1 - Headline Font",
					"desc" => "Specify the H1 Headline font properties",
					"id" => "font_h1",
					"std" => array('size' => '22px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography");  

$of_options[] = array( "name" => "H2 - Headline Font",
					"desc" => "Specify the H2 Headline font properties",
					"id" => "font_h2",
					"std" => array('size' => '20px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography");  
					
$of_options[] = array( "name" => "H3 - Headline Font",
					"desc" => "Specify the H3 Headline font properties",
					"id" => "font_h3",
					"std" => array('size' => '18px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography");  

$of_options[] = array( "name" => "H4 - Headline Font",
					"desc" => "Specify the H4 Headline font properties",
					"id" => "font_h4",
					"std" => array('size' => '16px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography");  
					
$of_options[] = array( "name" => "H5 - Headline Font",
					"desc" => "Specify the H5 Headline font properties",
					"id" => "font_h5",
					"std" => array('size' => '14px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography");  

$of_options[] = array( "name" => "H6 - Headline Font",
					"desc" => "Specify the H6 Headline font properties",
					"id" => "font_h6",
					"std" => array('size' => '12px','face' => 'Open Sans','style' => 'bold','color' => '#666666'),
					"type" => "typography"); 
					
/* ------------------------------------------------------------------------ */
/* Styling
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Styling",
					"type" => "heading");
					
/* ------------------------------------------------------------------------ */
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "General",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "General Theme Color",
					"desc" => "Default: #26c4e7",
					"id" => "color_general",
					"std" => "#26c4e7",
					"type" => "color"); 

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Links",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Link Color",
					"desc" => "Default: #555555",
					"id" => "color_link",
					"std" => "#555555",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Link Hover Color",
					"desc" => "Default: #26c4e7",
					"id" => "color_hover",
					"std" => "#26c4e7",
					"type" => "color"); 

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Top Widget",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Top Widget Background Color",
					"desc" => "Default: #181818",
					"id" => "background_top_widget",
					"std" => "#181818",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Heading",
					"desc" => "Default: #797979",
					"id" => "font_top_widget_heading",
					"std" => array('size' => '16px','face' => 'Open Sans','style' => 'normal','color' => '#797979'),
					"type" => "typography");

$of_options[] = array( "name" => "Top Widget Color",
					"desc" => "Default: #333333",
					"id" => "color_top_widget",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Form Border Color",
					"desc" => "Default: #222222",
					"id" => "color_top_widget_form_border",
					"std" => "#222222",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Form Border Focus Color",
					"desc" => "Default: #333333",
					"id" => "color_focus_top_widget_form_border",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Label Color",
					"desc" => "Default: #333333",
					"id" => "color_label_top_widget",
					"std" => "#333333",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Search Input Background",
					"desc" => "Default: #222222",
					"id" => "background_top_search_input",
					"std" => "#222222",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Search Input Background Focus",
					"desc" => "Default: #212121",
					"id" => "background_focustop_search_input_focus",
					"std" => "#212121",
					"type" => "color");

$of_options[] = array( "name" => "Top Widget Search Input Color",
					"desc" => "Default: #79797979",
					"id" => "color_top_search_input",
					"std" => "#797979",
					"type" => "color");
/* ------------------------------------------------------------------------ */

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Header",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Header Border Top Color",
					"desc" => "Default: #26c4e7",
					"id" => "color_header_boder_top",
					"std" => "#26c4e7",
					"type" => "color");

$of_options[] = array( "name" => "Header Background Color",
					"desc" => "Default: #ffffff",
					"id" => "color_header_background_color",
					"std" => "#ffffff",
					"type" => "color");

$of_options[] = array( "name" => "Callus Text Font",
					"desc" => "Default: #aaaaaa",
					"id" => "font_callus",
					"std" => array('size' => '13px','face' => 'Open Sans','style' => 'normal','color' => '#aaaaaa'),
					"type" => "typography");

/* ------------------------------------------------------------------------ */
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Navigation",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Navigation Link Color",
					"desc" => "Default: #555555",
					"id" => "font_nav",
					"std" => array('size' => '13px','face' => 'Open Sans','style' => 'bold','color' => '#555555'),
					"type" => "typography"); 
					
$of_options[] = array( "name" => "Navigation Link Hover Color",
					"desc" => "Default: #26c4e7",
					"id" => "color_navlinkhover",
					"std" => "#26c4e7",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Navigation Link Active Color",
					"desc" => "Default: #26c4e7",
					"id" => "color_navlinkactive",
					"std" => "#26c4e7",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Sub-Menu Background Color",
					"desc" => "Default: #191919",
					"id" => "color_submenubg",
					"std" => "#191919",
					"type" => "color"); 

$of_options[] = array( "name" => "Sub-Menu Border-Top Color",
					"desc" => "Default: #222222",
					"id" => "color_submenuborder",
					"std" => "#222222",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Sub-Menu Link Color",
					"desc" => "Default: #dedede",
					"id" => "color_submenulink",
					"std" => "#dedede",
					"type" => "color"); 

$of_options[] = array( "name" => "Sub-Menu Link Hover Background Color",
					"desc" => "Default: #111111",
					"id" => "color_submenubghover",
					"std" => "#111111",
					"type" => "color"); 

$of_options[] = array( "name" => "Sub-Menu Link Hover Color (also Active Color)",
					"desc" => "Default: #eeeeee",
					"id" => "color_submenulinkhover",
					"std" => "#eeeeee",
					"type" => "color"); 

/* ------------------------------------------------------------------------ */

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Portfolio",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Potfolio Hover Title Background",
					"desc" => "Default: #26c4e7",
					"id" => "color_portfolio_title_background",
					"std" => "#26c4e7",
					"type" => "color");

$of_options[] = array( "name" => "Potfolio Hover Title Color",
					"desc" => "Default: #ffffff",
					"id" => "color_portfolio_title",
					"std" => "#ffffff",
					"type" => "color");

$of_options[] = array( "name" => "Potfolio Hover Category Link Color",
					"desc" => "Default: #ffffff",
					"id" => "color_portfolio_category",
					"std" => "#ffffff",
					"type" => "color");

$of_options[] = array( "name" => "Potfolio Hover Category Link Hover Color",
					"desc" => "Default: #eeeeee",
					"id" => "color_hover_portfolio_category",
					"std" => "#eeeeee",
					"type" => "color");

/* ------------------------------------------------------------------------ */

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Sidebar",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Widget Title",
					"desc" => "Default: #232323",
					"id" => "font_widget_title",
					"std" => array('size' => '14px','face' => 'Open Sans','style' => 'bold','color' => '#232323'),
					"type" => "typography");

$of_options[] = array( "name" => "Widget Title Border Top Color",
					"desc" => "Default: 1px solid #232323",
					"id" => "border_top_widget_title",
					"std" => array('width' => '1','style' => 'solid','color' => '#232323'),
					"type" => "border"); 

$of_options[] = array( "name" => "Widget Title Border Bottom Color",
					"desc" => "Default: 1px solid #f1f1f1",
					"id" => "border_bottom_widget_title",
					"std" => array('width' => '1','style' => 'solid','color' => '#f1f1f1'),
					"type" => "border");

$of_options[] = array( "name" => "Widget Color",
					"desc" => "Default: #232323",
					"id" => "font_sidebar_widget",
					"std" => array('size' => '13px','face' => 'Open Sans','style' => 'normal','color' => '#232323'),
					"type" => "typography");

$of_options[] = array( "name" => "Widget Link Color",
					"desc" => "Default: #555555",
					"id" => "color_link_sidebar_widget",
					"std" => "#555555",
					"type" => "color");

$of_options[] = array( "name" => "Widget Link Hover Color",
					"desc" => "Default: #C0392B",
					"id" => "color_link_hover_sidebar_widget",
					"std" => "#C0392B",
					"type" => "color");

/* ------------------------------------------------------------------------ */
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Twitter Bar",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Twitter Bar Background Color",
					"desc" => "Default: #26c4e7",
					"id" => "background_twitter_bar",
					"std" => "#26c4e7",
					"type" => "color");

$of_options[] = array( "name" => "Twitter Bar Color",
					"desc" => "Default: #ffffff",
					"id" => "color_twitter_bar",
					"std" => "#ffffff",
					"type" => "color"); 

$of_options[] = array( "name" => "Twitter Bar LinkColor",
					"desc" => "Default: #ffffff",
					"id" => "color_link_twitter_bar",
					"std" => "#ffffff",
					"type" => "color"); 

$of_options[] = array( "name" => "Twitter Bar Link Hover Color",
					"desc" => "Default: #ffffff",
					"id" => "color_link_hover_twitter_bar",
					"std" => "#ffffff",
					"type" => "color");

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Footer",
					"icon" => false,
					"type" => "info");

$of_options[] = array( "name" => "Footer Background Color",
					"desc" => "Default: #181818",
					"id" => "color_footerbg",
					"std" => "#181818",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Footer Text Color",
					"desc" => "Default: #797979",
					"id" => "color_footertext",
					"std" => "#797979",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Footer Headline",
					"desc" => "Default: #cccccc",
					"id" => "font_footerheadline",
					"std" => array('size' => '14px','face' => 'Open Sans','style' => 'bold','color' => '#cccccc'),
					"type" => "typography");
					
$of_options[] = array( "name" => "Footer Link Color",
					"desc" => "Default: #cccccc",
					"id" => "color_footerlink",
					"std" => "#797979",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Footer Link Hover Color",
					"desc" => "Default: #cccccc",
					"id" => "color_footerlinkhover",
					"std" => "#cccccc",
					"type" => "color"); 

/* ------------------------------------------------------------------------ */
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Copyright",
					"icon" => false,
					"type" => "info");
					
$of_options[] = array( "name" => "Copyright Background Color",
					"desc" => "Default: #060606",
					"id" => "color_copyrightbg",
					"std" => "#060606",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Copyright Text Color",
					"desc" => "Default: #393939",
					"id" => "color_copyrighttext",
					"std" => "#393939",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Copyright Link Color",
					"desc" => "Default: #393939",
					"id" => "color_copyrightlink",
					"std" => "#393939",
					"type" => "color"); 
					
$of_options[] = array( "name" => "Copyright Link Hover Color",
					"desc" => "Default: #494949",
					"id" => "color_copyrightlinkhover",
					"std" => "#494949",
					"type" => "color"); 

/* ------------------------------------------------------------------------ */
/* Blog
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Blog",
					"type" => "heading");
					
$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "general_heading",
					"std" => "Blog Options",
					"icon" => false,
					"type" => "info"); 
					
$of_options[] = array( "name" => "Blog Layout",
					"desc" => "Choose your Default Blog Layout",
					"id" => "select_bloglayout",
					"std" => "Blog Large",
					"type" => "select",
					"options" => array('Blog Large', 'Blog Medium', 'Blog Mansory'));	
					
$of_options[] = array( "name" => "Blog Sidebar Position",
					"desc" => "Blog Listing Sidebar Position",
					"id" => "select_blogsidebar",
					"std" => "sidebar-right",
					"type" => "select",
					"options" => array('sidebar-left', 'sidebar-right'));	
					
$of_options[] = array( "name" => "Enable Share-Box on Post Detail",
					"desc" => "Check to enable Share-Box",
					"id" => "check_sharebox",
					"std" => 1,
					"type" => "checkbox"); 

$of_options[] = array( "name" => "Blog Excerpt Length",
					"desc" => "Default: 30. Used for blog page, archives & search results.",
					"id" => "text_excerptlength",
					"std" => "30",
					"type" => "text"); 

$of_options[] = array( "name" => "Enable Author-Box on Post Detail",
					"desc" => "Check to enable Author-Box",
					"id" => "check_authorbox",
					"std" => 1,
					"type" => "checkbox"); 

$of_options[] = array( "name" => "Enable Relate Post on Post Detail",
					"desc" => "Check to enable Relate Post on Post Detail",
					"id" => "check_relatepost",
					"std" => 1,
					"type" => "checkbox"); 

/* ------------------------------------------------------------------------ */
/* Portfolio
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Portfolio",
					"type" => "heading");
					
$of_options[] = array( "name" => "Portfolio Slug",
					"desc" => "Enter the URL Slug for your Portfolio (Default: portfolio-item) <br /><strong>Go save your permalinks after changing this.</strong>",
					"id" => "text_portfolioslug",
					"std" => "portfolio-item",
					"type" => "text"); 

$of_options[] = array( "name" => "Custom Category Slug",
					"desc" => "Enter the Category Taxonomy Slug for your Portfolio (Default: portfolio_category) <br /><strong>Go save your permalinks after changing this.</strong>",
					"id" => "text_portfolio_category_slug",
					"std" => "portfolio_category",
					"type" => "text"); 

$of_options[] = array( "name" => "Custom Tag Slug",
					"desc" => "Enter the Tag Taxonomy Slug for your Portfolio (Default: portfolio_tag) <br /><strong>Go save your permalinks after changing this.</strong>",
					"id" => "text_portfolio_tag_slug",
					"std" => "tag_category",
					"type" => "text"); 

$of_options[] = array( "name" => "Portfolio Archive Columns",
					"desc" => "Choose number columns of Potfolio archive",
					"id" => "select_portfolio_archive",
					"std" => "4 Columns",
					"type" => "select",
					"options" => array('2 Columns', '3 Columns', '4 Columns'));	

/* ------------------------------------------------------------------------ */
/* Social
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Social Media",
					"type" => "heading");
					
$of_options[] = array( "name" => "Hello there!",
					"desc" => "",
					"id" => "introduction",
					"std" => "Enter your username / URL to show or leave blank to hide Social Media Icons",
					"icon" => true,
					"type" => "info");
					
$of_options[] = array( "name" => "Twitter Username",
					"desc" => "Enter your Twitter username",
					"id" => "social_twitter",
					"std" => "everislabs",
					"type" => "text"); 

$of_options[] = array( "name" => "Dribbble URL",
					"desc" => "Enter URL to your Dribbble Account",
					"id" => "social_dribbble",
					"std" => "",
					"type" => "text"); 
					
$of_options[] = array( "name" => "Flickr URL",
					"desc" => "Enter URL to your Flickr Account",
					"id" => "social_flickr",
					"std" => "",
					"type" => "text"); 

$of_options[] = array( "name" => "Facebook URL",
					"desc" => "Enter URL to your Facebook Account",
					"id" => "social_facebook",
					"std" => "",
					"type" => "text"); 

$of_options[] = array( "name" => "Google+ URL",
					"desc" => "Enter URL to your Google+ Account",
					"id" => "social_google",
					"std" => "",
					"type" => "text"); 
					
$of_options[] = array( "name" => "LinkedIn URL",
					"desc" => "Enter URL to your LinkedIn Account",
					"id" => "social_linkedin",
					"std" => "",
					"type" => "text"); 
					
$of_options[] = array( "name" => "YouTube URL",
					"desc" => "Enter URL to your YouTube Account",
					"id" => "social_youtube",
					"std" => "",
					"type" => "text"); 
					
$of_options[] = array( "name" => "Pinterest URL",
					"desc" => "Enter URL to your Pinterest Account",
					"id" => "social_pinterest",
					"std" => "",
					"type" => "text");  
					
					
$of_options[] = array( "name" => "Show RSS",
					"desc" => "Check to Show RSS Icon",
					"id" => "social_rss",
					"std" => 1,
					"type" => "checkbox"); 
					
/* ------------------------------------------------------------------------ */
/* Custom CSS
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Custom CSS",
					"type" => "heading");
					
$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Advanced CSS Options. Paste your CSS Code.",
					"id" => "textarea_csscode",
					"std" => "",
					"type" => "textarea"); 
					
/* ------------------------------------------------------------------------ */
/* Backup
/* ------------------------------------------------------------------------ */
$of_options[] = array( "name" => "Backup Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
