<?php
/*
Plugin Name:  WordPress TV Sessions Connector
Plugin URI:
Description:  WordPress Plugin to connect Sessions and Video Hardware
Version:      1.0.10
Author:       WordPress TV German Team
Author URI:
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wptv-sessions
Domain Path:  /lang
GitHub Plugin URI: https://github.com/wptv-tools/wptv-sessions-connector.git
GitHub Branch:     master
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Require for use of the function is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Define plugin url
$plugin_url = plugin_dir_url(__FILE__);
if ( ! defined('WPTV_SESSION_CONNECTOR_PLUGIN_URL') ) {
    define( 'WPTV_SESSION_CONNECTOR_PLUGIN_URL', $plugin_url );
}

$plugin_path = plugin_dir_path(__FILE__);
if ( ! defined('WPTV_SESSION_CONNECTOR_PLUGIN_PATH') ) {
    define( 'WPTV_SESSION_CONNECTOR_PLUGIN_PATH', $plugin_path );
}


// Load plugin translations
add_action('plugins_loaded', function()
{
    load_plugin_textdomain('wptv-sessions', false, basename(dirname(__FILE__)) . '/lang');
});

// Include WP REST API Routes to will use with the APP
add_action('plugins_loaded', function()
{
    foreach (glob(__DIR__ . "/inc/routes/*.php") as $filename)
        include $filename;
});

// Include the callbacks function for the Custom WP REST API Routes
add_action('plugins_loaded', function()
{
    foreach (glob(__DIR__ . "/inc/callbacks/*.php") as $filename)
        include $filename;
});

// Include the helpers functions
add_action('plugins_loaded', function()
{
    foreach (glob(__DIR__ . "/inc/helpers/*.php") as $filename)
        include $filename;
});