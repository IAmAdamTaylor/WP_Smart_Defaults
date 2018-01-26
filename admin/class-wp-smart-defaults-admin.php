<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/admin
 * @author     Adam Taylor <sayhi@iamadamtaylor.com>
 */
class WP_Smart_Defaults_Admin {

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

	/**
	 * Register a theme page for our options.
	 */
	public function add_theme_page() {
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		add_submenu_page( 'options-general.php', 'Branding Options', 'Branding Options', 'edit_theme_options', 'wpsmartdefaults-settings', array( $this, 'render_options_page' ) );
	}

	/**
	 * Display the options page.
	 */
	public function render_options_page() {
		include_once 'partials/wp-smart-defaults-admin-display.php';
	}

	/**
	 * Register the settings and sections required.
	 */
	public function register_settings() {
		$enabled_extensions = $this->plugin_instance->get_enabled_extensions();

		register_setting( 'theme_wpsmartdefaults_options', 'theme_wpsmartdefaults_options', array( $this, 'validate_settings' ) );

		if ( 
			$enabled_extensions->custom_login_logo 
		) {
			
	    // Add a form section for the Logo
	    add_settings_section('wpsmartdefaults_settings_logo_section', __( 'Logo for Login Page', 'wpsmartdefaults' ), array( $this, 'render_logo_section_header_text' ), 'wpsmartdefaults');
	 
	    // Add Logo uploader
	    add_settings_field('wpsmartdefaults_setting_logo',  __( 'Logo', 'wpsmartdefaults' ), array( $this, 'render_logo_setting' ), 'wpsmartdefaults', 'wpsmartdefaults_settings_logo_section');
	    
	    // Add Logo width field
	    add_settings_field('wpsmartdefaults_setting_logo_width',  __( 'Logo Max Width (px)', 'wpsmartdefaults' ), array( $this, 'render_logo_width_setting' ), 'wpsmartdefaults', 'wpsmartdefaults_settings_logo_section');

	    // Add logo preview
	    add_settings_field('wpsmartdefaults_setting_logo_preview',  __( 'Current Logo', 'wpsmartdefaults' ), array( $this, 'render_logo_preview_setting' ), 'wpsmartdefaults', 'wpsmartdefaults_settings_logo_section');

		}
 
		if ( 
			$enabled_extensions->custom_admin_favicon 
		) {

	    // Add a form section for the favicon
	    add_settings_section('wpsmartdefaults_settings_favicon_section', __( 'Favicon for WordPress admin tabs', 'wpsmartdefaults' ), array( $this, 'render_favicon_section_header_text' ), 'wpsmartdefaults');

	    // Add Favicon uploader
	    add_settings_field('wpsmartdefaults_setting_favicon',  __( 'Favicon', 'wpsmartdefaults' ), array( $this, 'render_favicon_setting' ), 'wpsmartdefaults', 'wpsmartdefaults_settings_favicon_section');
	    
	    // Add favicon preview
	    add_settings_field('wpsmartdefaults_setting_favicon_preview',  __( 'Current Favicon', 'wpsmartdefaults' ), array( $this, 'render_favicon_preview_setting' ), 'wpsmartdefaults', 'wpsmartdefaults_settings_favicon_section');

		}

	}

	/**
	 * Render the description area for the logo section.
	 */
	public function render_logo_section_header_text() {
		
	}

	/**
	 * Render the file upload for the logo.
	 */
	public function render_logo_setting() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( 0 === $options->logo_id ) {
			$logo_id = '';
		} else {
			$logo_id = $options->logo_id;
		}

		?>

		<input type="hidden" id="wpsmartdefaults_logo_id" name="theme_wpsmartdefaults_options[logo_id]" value="<?php echo esc_attr( $logo_id ); ?>" />
    <input id="wpsmartdefaults_upload_logo_button" type="button" class="button js-wpsmartdefaults-open-upload-frame" value="<?php _e( 'Choose Image', 'wpsmartdefaults' ); ?>" />

		<?php
	}

	/**
	 * Render the input for the logo width.
	 */
	public function render_logo_width_setting() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( !$options->logo_width ) {
			$defaults = $options->get_defaults();
			$logo_width = $defaults['logo_width'];
		} else {
			$logo_width = $options->logo_width;
		}

		?>

		<input type="number" min="1" max="320" step="1" id="wpsmartdefaults_logo_width" name="theme_wpsmartdefaults_options[logo_width]" value="<?php echo esc_attr( $logo_width ); ?>" />
    <p class="description"><?php _e('The maximum width the login page can support is 320px.', 'wpsmartdefaults' ); ?></p>


		<?php
	}

	/**
	 * Render the logo preview.
	 */
	public function render_logo_preview_setting() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( !$options->logo_id ) {
			$logo_object = null;
		} else {
			$logo_object = wp_get_attachment_image_src( $options->logo_id, 'full' );
		}

		if ( !$options->logo_width ) {
			$defaults = $options->get_defaults();
			$logo_width = $defaults['logo_width'];
		} else {
			$logo_width = $options->logo_width;
		}

		?>

		<img class="" id="wpsmartdefaults_upload_logo_preview" src="<?php echo $logo_object[0]; ?>" alt="Current Logo" width="<?php echo $logo_object[1]; ?>" height="<?php echo $logo_object[2]; ?>" style="<?php echo ( !$logo_object ? 'display:none;' : '' ); ?> width:<?php echo esc_attr( $logo_width ); ?>px">
		<p class="description" <?php echo ( $logo_object ? 'style="display:none;"' : '' ); ?>>-</p>

		<?php
	}

	/**
	 * Render the description area for the favicon section.
	 */
	public function render_favicon_section_header_text() {
		?><p>
			We recommended that you use a recolored version of the main website favicon (e.g. with a red color overlay) to make it easy to differentiate between front end and admin tabs.
		</p>
		<p>
			If a favicon is not added here, a default favicon will be used.
		</p><?php
	}

	/**
	 * Render the file upload for the favicon.
	 */
	public function render_favicon_setting() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( 0 === $options->favicon_id ) {
			$favicon_id = '';
		} else {
			$favicon_id = $options->favicon_id;
		}

		?>

		<input type="hidden" id="wpsmartdefaults_favicon_id" name="theme_wpsmartdefaults_options[favicon_id]" value="<?php echo esc_attr( $favicon_id ); ?>" />
    <input id="wpsmartdefaults_upload_favicon_button" type="button" class="button js-wpsmartdefaults-open-upload-frame" value="<?php _e( 'Choose Image', 'wpsmartdefaults' ); ?>" data-mime-type="image/x-icon" />
    <p class="description">Upload a .ico file instead of a .jpg or .png</p>

		<?php
	}

	/**
	 * Render the favicon preview.
	 */
	public function render_favicon_preview_setting() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( !$options->favicon_id ) {
			$favicon_src = $this->_get_default_favicon_uri();
		} else {
			$favicon_object = wp_get_attachment_image_src( $options->favicon_id, 'full' );

			if ( $favicon_object ) {
				$favicon_src = $favicon_object[0];
			} else {
				$favicon_src = $this->_get_default_favicon_uri();
			}
		}

		?>

		<img class="" id="wpsmartdefaults_upload_favicon_preview" src="<?php echo $favicon_src; ?>" alt="Current Favicon" width="16" height="16">
		<p class="description">Preview is only possible for browsers that support the .ico extension for images.</p>

		<?php
	}

	/**
	 * Validate the settings before they are stored in the database.
	 * Reject any that do not match and display an error.
	 * @param  array $input The submitted fields.
	 * @return array        The filtered data containing only passing values.
	 */
	public function validate_settings( $input ) {
		$options = new WP_Smart_Defaults_Options();
		$valid_input = $options->load();

		// Load the current values into valid input by default
		// If a value isn't set, load it's default
		$valid_input = array_merge( $options->get_defaults(), $valid_input );

		$was_submitted = !empty($input['submit']) ? true : false;

		// Check for a submitted form
		if ( $was_submitted ) {

			/**
			 * Validate the logo upload field.
			 */
			$_logoid = $input['logo_id'];

			if ( $_logoid ) {
				
				// Attempt to get image object
				$_logo = wp_get_attachment_image_src( $_logoid, 'full' );

				// Validate: Numeric ID and image object exists
				if ( is_numeric( $_logoid ) && $_logo ) {
					
					$valid_input['logo_id'] = $input['logo_id'];

				} else {
					
					add_settings_error( 'theme_wpsmartdefaults_options', 'logo-not-exists', "Could not find an image with ID '$_logoid'", 'error' );

				}

			}


			/**
			 * Validate the logo width field.
			 */
			$width = $input['logo_width'];

			if ( $width ) {
				
				if ( !is_numeric( $width ) ) {
					
					add_settings_error( 'theme_wpsmartdefaults_options', 'width-not-numeric', "The logo width must be numeric", 'error' );
				
				} elseif ( $width < 1 || $width > 320 ) {
					
					add_settings_error( 'theme_wpsmartdefaults_options', 'width-out-bounds', "The logo width must be between 1px and 320px", 'error' );
				
				} else {
					
					$valid_input['logo_width'] = $input['logo_width'];
				
				}

			}


			/**
			 * Validate the favicon upload field.
			 */
			$_faviconid = $input['favicon_id'];

			if ( $_faviconid ) {
				
				// Attempt to get image object
				$_favicon = wp_get_attachment_image_src( $_faviconid, 'full' );

				// Validate: Numeric ID and image object exists
				if ( is_numeric( $_faviconid ) && $_favicon ) {
					
					$valid_input['favicon_id'] = $input['favicon_id'];

				} else {
					
					add_settings_error( 'theme_wpsmartdefaults_options', 'favicon-not-exists', "Could not find an image with ID '$_faviconid'", 'error' );

				}

			}


		}

		return $valid_input;
	}

	public function show_admin_favicon() {
		$options = new WP_Smart_Defaults_Options();
		$options->load();

		if ( !$options ) {
			return;
		}

		if ( $options->favicon_id ) {
			$favicon = wp_get_attachment_image_src( $options->favicon_id, 'full' );

			if ( $favicon ) {
				$favicon_src = $favicon[0];
			} else {
				$favicon_src = $this->_get_default_favicon_uri();
			}

		} else {
			$favicon_src = $this->_get_default_favicon_uri();
		}

  	?><link rel="shortcut icon" href="<?php echo esc_attr( $favicon_src ); ?>" /><?php
	}

	/**
	 * Get the default admin favicon.
	 * @return string 
	 */
	private function _get_default_favicon_uri() {
		return trailingslashit( plugin_dir_url( __FILE__ ) ) . 'images/favicon.ico';
	}

	/**
	 * Show the post title when editing a page or post.
	 * @param  string $admin_title The current title.
	 * @return string
	 */
	public function show_post_title_when_editing( $admin_title ) {
		global $pagenow;
	  global $post;

	  // Make sure we are in the admin view
	  // And check we are on edit post/page
	  if ( is_admin() && in_array( $pagenow, array( 'post.php' ) ) ) {

      $admin_title = 'Edit '.$post->post_title.' &lsaquo; '.get_bloginfo( 'name' );

	  }

	  return $admin_title;
	}

	/**
	 * Make the Yoast SEO metabox low priority, if it exists.
	 * This will force it to load lower down the page than other metaboxes.
	 * @return string
	 */
	function yoast_seo_metabox_priority() {
	  return 'low';
	}

	function add_page_columns( $columns ) {
	  $new_columns = array();

	  foreach ($columns as $key => $value) {
	    $new_columns[ $key ] = $value;
	    if ( $key == 'title' ) {
	      $new_columns['page_template'] = "Page Template";
	      $new_columns['menu_order'] = "Order";
	    }
	  }

	  return $new_columns;
	}

	function add_page_columns_data( $column_name, $post_id ) {
	  global $post;

	  if ( 'page' == $post->post_type ) {

	    switch($column_name) {
	      case 'page_template':
	        $template_name = get_page_template_slug( $post->ID );

	        if( 0 == strlen( trim( $template_name ) ) || !file_exists( get_stylesheet_directory() . '/' . $template_name ) ) {

	          $template_name = 'Default';

	        } else {

	          $template_contents = file_get_contents( get_stylesheet_directory() . '/' . $template_name );

	          $pattern = '/Template ';
	          $pattern .= 'Name:(.*)\n/';
	          preg_match($pattern, $template_contents, $template_name);

	          if ( count($template_name) > 0 ) {
	          $template_name = trim($template_name[1]);
	          } else {
	            $template_name = false;
	          }

	          if ( !$template_name ) {
	            $template_name = 'Default';
	          }

	        }

	        $template_name = str_replace('Page Template', '', $template_name);
	        echo $template_name;

	        break;

	      case 'menu_order':
	        $menu_order = $post->menu_order;

	        $post_ancestors = get_post_ancestors( $post );
	        foreach ($post_ancestors as $key => $value) {
	          $ancestor = get_post( $value );

	          $menu_order = $ancestor->menu_order . '.' . $menu_order;
	        }

	        echo $menu_order;
	        break;

	      default:
	        break;
	    }
	      
	  }

	}

	function add_post_columns( $columns ) {
	  $new_columns = array();

	  foreach ($columns as $key => $value) {
	    if ( $key == 'title' ) {
	      $new_columns['post_thumbnail'] = "Thumbnail";
	    }
	    $new_columns[ $key ] = $value;

	  }

	  return $new_columns;
	}

	/**
	 * Get an image attachment from the media library.
	 *
	 * @param integer $image_id The image attachment to get.
	 * @param string $size Optional, The size of the image attachment to get, e.g. 'full', 'thumbnail'. 'full' is used by default.
	 *
	 * @return array An array containing the image src, width & height and the alt text.
	 */
	function get_image( $image_id, $size = 'full' ) {
	  if ( $image = wp_get_attachment_image_src( $image_id, $size ) ) {
	    return array(
	      'src' => $image[0],
	      'width' => $image[1],
	      'height' => $image[2],
	      'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
	    );
	  }
	} 

	/**
	 * Get the attributes for an image attachment from the media library.
	 *
	 * @param integer $image_id The image attachment to get.
	 * @param string $size Optional, The size of the image attachment to get, e.g. 'full', 'thumbnail'. 'full' is used by default.
	 *
	 * @return string The attributes needed to output the image.
	 */
	function get_image_attributes( $image_id, $size = 'full' ) {
	  $image = $this->get_image( $image_id, $size );

	  if ( !$image ) {
	    return false;
	  }

	  return sprintf(
	    'src="%s" alt="%s" width="%s" height="%s"',
	    $image['src'],
	    $image['alt'],
	    $image['width'],
	    $image['height']
	  );
	}

	function add_post_columns_data( $column_name, $post_id ) {
	  global $post;

	  if ( 'post' == $post->post_type ) {

	    switch($column_name) {
	      case 'post_thumbnail':
	        if ( has_post_thumbnail() ) {
	          
	          $thumbnail_id = get_post_thumbnail_id();
	          ?>
	          
	          <a href="<?php echo get_the_permalink( $post_id ); ?>">
	            <img <?php echo $this->get_image_attributes( $thumbnail_id, 'thumbnail' ); ?> style="display:block; max-width:100%; width:75px; height:auto;" >
	          </a>

	          <?php
	          
	        } else {
	          ?>

	          <span aria-hidden="true">—</span>
	          <span class="screen-reader-text">No thumbnail</span>

	          <?php
	        }

	        break;

	       // case "short_description":
	       // 	$meta = get_post_meta( $post_id, $column_name, true );
	       // 	if ( $meta ) {
		      //  	echo $meta;
	       // 	}
	       // 	break;

	      default:
	        break;
	    }
	      
	  }

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-smart-defaults-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		$options = new WP_Smart_Defaults_Options();
		$options->load();

		wp_register_script( 'wpsmartdefaults-upload', plugin_dir_url( __FILE__ ) . 'js/wp-smart-defaults-admin.js', array('jquery', 'media-upload', 'thickbox'), $this->version, true );

		$current_screen = get_current_screen();

		if ( 'settings_page_wpsmartdefaults-settings' == $current_screen->id ) {
			wp_enqueue_media();
			wp_enqueue_script('wpsmartdefaults-upload');
    }

	}

}
