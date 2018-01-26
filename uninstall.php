<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$plugin_basename = 'wp-smart-defaults/wp-smart-defaults.php';

// Check that this plugin is the one being uninstalled
if ( $plugin_basename !== WP_UNINSTALL_PLUGIN || $plugin_basename !== $_REQUEST['plugin'] ) {
	exit;
}

// Check capabilities
if ( !current_user_can( 'activate_plugins' ) ) {
	exit;
}

// Passed all checks

// Delete plugin options
require_once plugin_dir_path( __FILE__ ) . 'includes/template-options/class-options.php';

$options = new WP_Smart_Defaults_Options();
$options->delete();
