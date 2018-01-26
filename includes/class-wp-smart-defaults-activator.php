<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/includes
 * @author     Adam Taylor <sayhi@iamadamtaylor.com>
 */
class WP_Smart_Defaults_Activator {

	/**
	 * Add the default options to the database.
	 * 
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/template-options/class-options.php';

		$options = new WP_Smart_Defaults_Options();
		$values = $options->load();

		// If values are not saved in the database already, add the defaults
		if ( !$values ) {
			$options->load_defaults();
			$options->save();
		}
		
	}

}
