<?php
/*
    Plugin Name: %%PLUGIN_NAME%%
    Plugin URI: %%PLUGIN_URI%%
    Description: Plugin to add additional features to the website
    Version: 1.0
    Author: Hoang Nguyen
    Author URI: http://hoang.guru
    License: GPL2
*/

define( 'WME_VERSION', '1.0.0' );
define( 'WME__MINIMUM_WP_VERSION', '3.0' );
define( 'WME__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WME__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WME__NO_FOOTER', 6 );
define( 'WME__ASSET_VERSION', 1);

require_once( WME__PLUGIN_DIR . '/classes/class.Admin.php' );
require_once( WME__PLUGIN_DIR . '/classes/class.PageTemplater.php' );
require_once( WME__PLUGIN_DIR . '/classes/class.ShortCodes.php' );

register_activation_hook( __FILE__, array ('WMEAdmin', 'activate'));
register_deactivation_hook( __FILE__, array( 'WMEAdmin', 'deactivate' ));

// Register all shortcodes here
add_shortcode("wme_shortcode_1", array( "WMEShortCodes", 'shortcode_1'));
// End shortcodes

add_action( 'admin_menu', array( 'WMEAdmin', 'admin_menu' ));
add_action( 'admin_enqueue_scripts', array( 'WMEAdmin', 'admin_enqueue_assets' ));
add_action( 'wp_ajax_WME_option_update', array( 'WMEAdmin', 'option_save_ajax_callback' ) );
add_action( 'wp_loaded', array('WMEPageTemplater', 'wp_load_callback') );
add_action( 'plugins_loaded', array( 'WMEPageTemplater', 'get_instance' ) );
add_action( 'wp_enqueue_scripts', array ('WMEPageTemplater', 'site_enqueue_assets') );