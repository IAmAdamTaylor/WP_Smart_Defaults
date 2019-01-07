<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/public
 * @author     Adam Taylor <sayhi@iamadamtaylor.com>
 */
class WP_Smart_Defaults_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * An instance of the main plugin class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      WP_Smart_Defaults $plugin An instance of the main plugin class.
	 */
	private $plugin_instance;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    								$plugin_name  		The name of this plugin.
	 * @param    string    								$version    			The version of this plugin.
	 * @param    WP_Smart_Defaults $plugin_instance 	An instance of the main plugin class.
	 */
	public function __construct( $plugin_name, $version, WP_Smart_Defaults $plugin_instance ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_instance = $plugin_instance;

	}

	public function remove_script_version( $src ) {
		if ( !is_admin() ) {
			$src = remove_query_arg( 'ver', $src );
		}
		
		return $src;
	}

	public function change_login_logo() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( !$options ) {
			return;
		}

		$logo = wp_get_attachment_image_src( $options->logo_id, 'full' );

		if ( !$logo ) {
			return;
		}

		$src = $logo[0];

		// Constrain height of image to a 320px width
		$width = $logo[1];
		$height = $logo[2];

		if ( $width > $options->logo_width ) {
			$height = $options->logo_width * ( $height / $width );
		}

		?><style type="text/css">
			body.login div#login h1 a {
        width: 100%;
        height: <?php echo $height; ?>px;
        background-image: url(<?php echo $src; ?>);
        background-position: center center;
        background-repeat: no-repeat;
        background-size: contain;
	    }
		</style><?php
	}

	public function use_siteurl_on_login_page( $site_url ) {
		$site_url = home_url();

		return $site_url;
	}

	public function use_sitename_on_login_page( $site_title ) {
		$site_title = get_bloginfo( 'name' );

		return $site_title;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Smart_Defaults_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Smart_Defaults_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-smart-defaults-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Smart_Defaults_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Smart_Defaults_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-smart-defaults-public.js', array( 'jquery' ), $this->version, false );

	}

}
