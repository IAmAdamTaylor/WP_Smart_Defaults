<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Smart_Defaults
 * @subpackage WP_Smart_Defaults/admin/partials
 */
?>

<div class="wrap">
 
  <h2><?php _e( 'Branding Options', 'et-ext' ); ?></h2>

  <form id="form-wpsmartdefaults-options" action="options.php" method="post" enctype="multipart/form-data">

    <?php
      settings_fields('theme_wpsmartdefaults_options');
      do_settings_sections('wpsmartdefaults');
    ?>

    <p class="submit">
      <input name="theme_wpsmartdefaults_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wpsmartdefaults'); ?>" />
    </p>

  </form>

</div>
