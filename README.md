=== WordPress Smart Defaults ===  
Contributors: IAmAdamTaylor  
Tags: login, admin, extensions, options  
Requires at least: 4.8.1  
Tested up to: 4.9.2  
Stable tag: 4.8.1  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extension plugin providing additional functionality and settings for WordPress and the admin interface.

== Description ==

This plugin adds custom functionality to make WordPress easier to use and look better. This includes:

* Adds the ability and an interface to upload a custom logo for the WordPress login page.
* Adds the ability and an interface to upload a custom favicon for the WordPress admin pages. Useful when editing content and viewing the front end at the same time as it allows you to differentiate between tabs quickly.
* Changes the title and URL of the link placed around the logo on the login page to reference the current website. By default these point to WordPress.org.
* Changes the titles of WordPress admin pages to better reflect what they are. 'Edit Post' -> 'Edit Hello world!'
* Adds commonly used custom columns to the Posts and Pages post types.
* Removes query strings from front end scripts. Cache busting can be better achieved by changing the filename as some caches will ignore the query string. Opinionated.
* Makes Yoast SEO metaboxes load as low priority, placing them at the end of the edit page after any other custom fields. Opinionated.

Each of these discrete sets of functionality has an associated filter hook which you can use to disable it if required.

To disable a specific set of functionality add a filter to a custom plugin or your theme's functions.php file like this:  
`add_filter( 'wpsmartdefaults_enable_custom_login_logo', '__return_false' );`

The `__return_false` function is included as part of WordPress allowing you to quickly return a false value, which will disable the extension targeted. 

You can also write more advanced filters, for example to disable an extension if a specific user is logged in. If you are doing this any falsey value, such as 0, '' or a blank array, returned from the filter will disable the extension.

The filters available are:

Change logo on login page.   
`'wpsmartdefaults_enable_custom_login_logo'`

Change WordPress admin favicon.  
`'wpsmartdefaults_enable_custom_admin_favicon'`

Change the link URL placed around the logo on the login page to the website URL.  
`'wpsmartdefaults_enable_login_link_url'`

Change the link title placed around the logo on the login page to the website title.  
`'wpsmartdefaults_enable_login_link_title'`

Change WordPress admin edit titles.  
`'wpsmartdefaults_enable_admin_post_title'`

Show custom columns on pages and posts.  
This filter allows you to turn off all custom columns in one go. There are separate filters available for each post type.  
`'wpsmartdefaults_enable_admin_custom_columns'`

Show custom columns on pages only. Show custom columns on pages and posts must be activated for this to work.  
`'wpsmartdefaults_enable_pages_custom_columns'`

Show custom columns on posts only. Show custom columns on pages and posts must be activated for this to work.  
`'wpsmartdefaults_enable_posts_custom_columns'`

Remove version query args from enqueued assets.  
`'wpsmartdefaults_enable_remove_script_version'`

Reduce the priority of Yoast SEO metaboxes.  
`'wpsmartdefaults_enable_yoast_seo_extensions'`

== Installation ==

This section describes how to install the plugin and get it working.

To install it manually:

1. [Download the plugin](https://github.com/IAmAdamTaylor/EDGETemplateExtensions/archive/master.zip) as a .zip file from [GitHub](https://github.com/IAmAdamTaylor/EDGETemplateExtensions/)
2. Login to your WordPress dashboard and go to Plugins > Add New > Upload Plugin
3. Choose the .zip file downloaded in step 1 and click 'Install Now'
4. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where can I change the logo shown on the login page? =

Login to your WordPress Dashboard and go to Settings > Branding Options. You can upload an image and change the width of your logo here.

= Why can't I choose a width greater than 320px for my logo? =

The default WordPress login page can only support a logo of 320px or less. For this reason, the plugin limits the width allowed to 320px.

= Where can I change the favicon shown for WordPress admin pages? =

Login to your WordPress Dashboard and go to Settings > Branding Options. You can upload a .ico file for your favicon here.

= Can I deactivate certain parts of this plugin's functionality, while still running the others? =

You can, by using the filters supplied with the plugin. These are documented in the Description tab.

== Changelog ==

= 1.0 =
* Initial Version
