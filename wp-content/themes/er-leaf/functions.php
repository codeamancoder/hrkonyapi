<?php

/**
 * Add Administrator Options Page
 *
 * @since ER-Leaf 1.0
 *
 */
	require_once('framework/admin/index.php'); 

/**
 * Load Theme Library & Framework
 *
 * @since ER-Leaf 1.0
 *
 */
	require_once('framework/theme-functions.php');
	require_once('framework/portfolio.php');
	require_once('framework/slider.php');
	require_once('framework/posts.php');
	require_once('framework/shortcodes.php');
	require_once('framework/menu-icon.php');
	require_once('framework/custom-css.php');
	require_once('framework/post-format/cf-post-formats.php');
	require_once('framework/widgets.php');
	require_once('framework/plugin-activation.php');
	require_once('framework/tinymce/shortcodes-generator.php');

/**
 * Sets up the content width value based on the theme's design.
 */
if ( ! isset( $content_width ) )
	$content_width = 720;

/**
* Basic Theme Setup
*
* @since ER-Leaf 1.0
*
*/
function er_leaf_setup() {

	// Text domain translation
	load_theme_textdomain( 'er_leaf', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add HTML5 support
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// Add post format
	add_theme_support( 'post-formats', array(
		'audio','gallery', 'image', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'header', __( 'Navigation Menu', 'er_leaf' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'er_leaf' ) );

	//Add theme support & image size
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'post', 770, 230, true );
	add_image_size( 'portfolio', 450, 535, true );
	add_image_size( 'relates-post', 170, 105, true );
	add_image_size( 'recent-post', 85, 85, true );

	// Use theme gallery style
	add_filter( 'use_default_gallery_style', '__return_false' );
	
}
add_action( 'after_setup_theme', 'er_leaf_setup' );

/**
 * Enqueues scripts and styles for front end.
 *
 * @since ER-Leaf 1.1.2
 *
 */
function er_leaf_scripts_styles() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'eris-grid', get_template_directory_uri() . '/css/erisgrd.css', array(), '1.0' );
	wp_enqueue_style( 'eris-plugin', get_template_directory_uri() . '/css/plugin.css', array(), '1.0' );
	wp_enqueue_style( 'er-leaf-style', get_stylesheet_uri(), array(), '1.0' );

	if(get_theme_mod('check_responsive'))
	wp_enqueue_style( 'eris-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1.0' );
	
	wp_enqueue_style( 'eris-custom', esc_url( home_url( '/' ) ).'?load=custom.css', array(), '1.0' );

	// Loads javascript & custom functions
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'wp-mediaelement' );
	wp_enqueue_script( 'jquery.modernizr', get_template_directory_uri(). '/js/modernizr.custom.js', array(), false, false );
	wp_enqueue_script( 'jquery.easing', get_template_directory_uri(). '/js/jquery.easing.1.3.js', array(), false, true );
	wp_enqueue_script( 'jquery.hoverIntent', get_template_directory_uri(). '/js/hoverIntent.js', array(), false, true );
	wp_enqueue_script( 'jquery.superfish.js', get_template_directory_uri(). '/js/superfish.js', array(), false, true );
	wp_enqueue_script( 'jquery.isotope', get_template_directory_uri(). '/js/jquery.isotope.js', array(), false, true );
	wp_enqueue_script( 'jquery.flexslider', get_template_directory_uri(). '/js/jquery.flexslider.js', array(), false, true );
	wp_enqueue_script( 'jquery.fitvids', get_template_directory_uri(). '/js/jquery.fitvids.js', array(), false, true );
	wp_enqueue_script( 'jquery.carouFredSel', get_template_directory_uri(). '/js/jquery.carouFredSel-6.2.1.js', array(), false, true );
	wp_enqueue_script( 'jquery.magnific-popup', get_template_directory_uri(). '/js/jquery.magnific-popup.js', array(), false, true );
	wp_enqueue_script( 'jquery.easypiechart', get_template_directory_uri(). '/js/jquery.easypiechart.min.js', array(), false, true );
	wp_enqueue_script( 'jquery.masonry', get_template_directory_uri(). '/js/masonry.pkgd.min.js', array(), false, true );
	wp_enqueue_script( 'jquery.tweet', get_template_directory_uri(). '/js/twitter/jquery.tweet.min.js', array(), false, true );
	wp_enqueue_script( 'jquery.functions', get_template_directory_uri(). '/js/functions.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'er_leaf_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since ER-Leaf 1.0
 *
 */
function er_leaf_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Sayfa %s', 'er_leaf' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'er_leaf_wp_title', 10, 2 );

/**
 * Registers widget areas.
 *
 * @since ER-Leaf 1.0
 *
 */
function er_leaf_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Default Sidebar Widget Area', 'er_leaf' ),
		'id'            => 'default-sidebar',
		'description'   => __( 'Appears in sidebar area.', 'er_leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Bar 1', 'er_leaf' ),
		'id'            => 'topbar-1',
		'description'   => __( 'Appears in top header area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Bar 2', 'er_leaf' ),
		'id'            => 'topbar-2',
		'description'   => __( 'Appears in top header area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Bar 3', 'er_leaf' ),
		'id'            => 'topbar-3',
		'description'   => __( 'Appears in top header area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Bar 4', 'er_leaf' ),
		'id'            => 'topbar-4',
		'description'   => __( 'Appears in top header area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'er_leaf' ),
		'id'            => 'footer-1',
		'description'   => __( 'Appears in footer area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4><div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'er_leaf' ),
		'id'            => 'footer-2',
		'description'   => __( 'Appears in footer area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4><div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'er_leaf' ),
		'id'            => 'footer-3',
		'description'   => __( 'Appears in footer area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4><div class="widget-content">',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'er_leaf' ),
		'id'            => 'footer-4',
		'description'   => __( 'Appears in footer area.', 'er_leaf' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4><div class="widget-content">',
	) );
}
add_action( 'widgets_init', 'er_leaf_widgets_init' );

/**
 * Install Plugin after activated themes
 *
 * @since ER-Leaf 1.0
 *
 */
function er_leaf_register_required_plugins() {

	$plugins = array(


		array(
			'name'     				=> 'Revolution Slider', 
			'slug'     				=> 'revslider', 
			'source'   				=> get_stylesheet_directory() . '/framework/plugins/revslider.zip', 
			'required' 				=> true, 
			'version' 				=> '', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false, 
			'external_url' 			=> '',
		),

		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'WordPress SEO by Yoast',
			'slug' 		=> 'wordpress-seo',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'WP Super Cache',
			'slug' 		=> 'wp-super-cache',
			'required' 	=> false,
		),

	);

	$theme_text_domain = 'er_leaf';

	tgmpa( $plugins );

}
add_action( 'tgmpa_register', 'er_leaf_register_required_plugins' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since ER-Leaf 1.0
 *
 */
function er_leaf_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'er_leaf_customize_register' );
?>