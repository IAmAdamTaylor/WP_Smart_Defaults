<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/includes
 * @author     Adam Taylor <sayhi@iamadamtaylor.com>
 */
class WP_Smart_Defaults {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Smart_Defaults_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-smart-defaults';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Smart_Defaults_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Smart_Defaults_i18n. Defines internationalization functionality.
	 * - WP_Smart_Defaults_Admin. Defines all hooks for the admin area.
	 * - WP_Smart_Defaults_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-smart-defaults-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-smart-defaults-i18n.php';

		/**
		 * The class responsible for defining all options and settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/template-options/class-options.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-smart-defaults-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-smart-defaults-public.php';

		$this->loader = new WP_Smart_Defaults_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Smart_Defaults_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Smart_Defaults_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	public function get_enabled_extensions() {
		$enabled_extensions = new StdClass();

		$enabled_extensions->custom_login_logo = apply_filters( 'wpsmartdefaults_enable_custom_login_logo', true );
		$enabled_extensions->custom_admin_favicon = apply_filters( 'wpsmartdefaults_enable_custom_admin_favicon', true );
		
		$enabled_extensions->admin_post_title = apply_filters( 'wpsmartdefaults_enable_admin_post_title', true );
		
		$enabled_extensions->yoast_seo_extensions = apply_filters( 'wpsmartdefaults_enable_yoast_seo_extensions', true );
		
		$enabled_extensions->admin_custom_columns = apply_filters( 'wpsmartdefaults_enable_admin_custom_columns', true );
		$enabled_extensions->pages_custom_columns = apply_filters( 'wpsmartdefaults_enable_pages_custom_columns', true );
		$enabled_extensions->posts_custom_columns = apply_filters( 'wpsmartdefaults_enable_posts_custom_columns', true );
		$enabled_extensions->media_custom_columns = apply_filters( 'wpsmartdefaults_enable_media_custom_columns', true );

		$enabled_extensions->login_link_url = apply_filters( 'wpsmartdefaults_enable_login_link_url', true );
		$enabled_extensions->login_link_title = apply_filters( 'wpsmartdefaults_enable_login_link_title', true );
		
		$enabled_extensions->remove_script_version = apply_filters( 'wpsmartdefaults_enable_remove_script_version', true );

		return $enabled_extensions;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WP_Smart_Defaults_Admin( $this->get_plugin_name(), $this->get_version(), $this );
		$enabled_extensions = $this->get_enabled_extensions();

		/**
		 * Load assets
		 */
		if ( 
			$enabled_extensions->custom_login_logo ||
			$enabled_extensions->custom_admin_favicon
		) {
			
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		}

		/**
		 * Add the Branding Options settings.
		 */
		if ( 
			$enabled_extensions->custom_login_logo ||
			$enabled_extensions->custom_admin_favicon
		) {

			$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_theme_page' );
			$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

		}

		/**
		 * Show a favicon on WordPress admin pages.
		 */
		if ( 
			$enabled_extensions->custom_admin_favicon
		) {
			
			$this->loader->add_action( 'admin_head', $plugin_admin, 'show_admin_favicon' );

		}

		/**
		 * Show the post title when editing a page or post.
		 */
		if ( 
			$enabled_extensions->admin_post_title
		) {

			$this->loader->add_filter( 'admin_title', $plugin_admin, 'show_post_title_when_editing' );

		}

		/**
		 * Change the priority of the Yoast SEO metabox.
		 */
		if ( 
			$enabled_extensions->yoast_seo_extensions
		) {

			$this->loader->add_filter( 'wpseo_metabox_prio', $plugin_admin, 'yoast_seo_metabox_priority' );

		}

		/**
		 * Register the custom columns for pages.
		 */
		if ( 
			$enabled_extensions->admin_custom_columns &&
			$enabled_extensions->pages_custom_columns
		) {
			
			$this->loader->add_filter( 'manage_edit-page_columns', $plugin_admin, 'add_page_columns' );
			$this->loader->add_action( 'manage_pages_custom_column', $plugin_admin, 'add_page_columns_data', 20, 2 );

		}
		
		/**
		 * Register the custom columns for posts.
		 */
		if ( 
			$enabled_extensions->admin_custom_columns &&
			$enabled_extensions->posts_custom_columns
		) {

			$this->loader->add_filter( 'manage_edit-post_columns', $plugin_admin, 'add_post_columns' );
			$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'add_post_columns_data', 20, 2 );

		}

		if ( 
			$enabled_extensions->admin_custom_columns &&
			$enabled_extensions->media_custom_columns 
		) {
			$this->loader->add_filter( 'manage_media_columns', $plugin_admin, 'add_media_columns' );
			$this->loader->add_action( 'manage_media_custom_column', $plugin_admin, 'add_media_columns_data', 20, 2 );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Smart_Defaults_Public( $this->get_plugin_name(), $this->get_version(), $this );
		$enabled_extensions = $this->get_enabled_extensions();

		/**
		 * Currently no need to load assets
		 */
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		/**
		 * Style the login page
		 */
		if ( 
			$enabled_extensions->custom_login_logo
		) {
			
			$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'change_login_logo' );

		}

		if ( 
			$enabled_extensions->login_link_url
		) {
			
			$this->loader->add_filter( 'login_headerurl', $plugin_public, 'use_siteurl_on_login_page' );

		}

		if ( 
			$enabled_extensions->login_link_title
		) {
			
			$this->loader->add_filter( 'login_headertitle', $plugin_public, 'use_sitename_on_login_page' );

		}

		/**
		 * Remove the query string from assets.
		 */
		if ( 
			$enabled_extensions->remove_script_version
		) {
			
			$this->loader->add_filter( 'script_loader_src', $plugin_public, 'remove_script_version' );
			$this->loader->add_filter( 'style_loader_src', $plugin_public, 'remove_script_version' );

		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WP_Smart_Defaults_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
