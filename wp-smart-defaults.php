<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           WP_Smart_Defaults
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Smart Defaults
 * Description:       Extension plugin providing additional functionality and settings for WordPress and the admin interface.
 * Version:           1.0.0
 * Author:            Adam Taylor
 * Author URI:        https://www.iamadamtaylor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpsmartdefaults
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-smart-defaults-activator.php
 */
function activate_wp_smart_defaults() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-smart-defaults-activator.php';
	WP_Smart_Defaults_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-smart-defaults-deactivator.php
 */
function deactivate_wp_smart_defaults() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-smart-defaults-deactivator.php';
	WP_Smart_Defaults_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_smart_defaults' );
register_deactivation_hook( __FILE__, 'deactivate_wp_smart_defaults' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-smart-defaults.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_smart_defaults() {

	$plugin = new WP_Smart_Defaults();
	$plugin->run();

}

add_action( 'init', 'run_wp_smart_defaults' );
// run_wp_smart_defaults();
