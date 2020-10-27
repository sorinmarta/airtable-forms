<?php
/**
 * Plugin Name:       Airtable Forms
 * Plugin URI:        https://sorinmarta.com/plugins/airtable-forms
 * Description:       A plugin that gives you the possibility to embed a for in your WordPress site that will send the data into an Airtable base and table
 * Version:           1.0.0
 * Requires at least: 5.5.1
 * Requires PHP:      7.3
 * Author:            Sorin Marta
 * Author URI:        https://sorinmarta.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       airtable-forms
 * Code Prefix:       atfr
 */

/**
 * TODO:
 *  [x] Create the init class
 *  [x] Add a function that will execute when the plugin is installed
 *  [x] In the init class create a function that will add an option in the database for forms ids and add it to the installation function
 *  [x] Create a table in the database that will store the value using a function and add it to the installation function
 *  [x] Create a dashboard page
 *  [x] Add the credentials submenu item
 *  [x] Add fields to enter the Airtable required data for the API
 *  [] Figure out a way to create forms
 *  [] Create a trait for the forms db functionality
 *  [] Create the Forms class
 *  [] Create a shortcode for dynamic forms
 */

// Constants
define('ATFR_FOLDER','airtable-forms');
define('ATFR_PLUGIN', WP_PLUGIN_DIR.'/'.ATFR_FOLDER.'/');
define('ATFR_CLASSES', ATFR_PLUGIN . 'classes/');
define('ATFR_ASSETS', ATFR_PLUGIN . 'assets/');
define('ATFR_VERSION', '1.0.0');
define('ATFR_DOMAIN', 'airtable-forms');
define('ATFR_CREDS_PAGE', admin_url('admin.php') . '?page=airtable-credentials');


class Atfr
{
    static $table_name = 'atfr_forms';

    public function __construct()
    {
        $this->loader();
        add_action('admin_enqueue_scripts',array($this, 'enqueue'));
        register_activation_hook(ATFR_PLUGIN,array($this,'activate'));
    }

    private function loader()
    {
        require_once(ATFR_PLUGIN . '/classes/class-atfr-settings.php');
    }

    public function enqueue()
    {
        // Styles
        wp_enqueue_style('atfr-main-style','/wp-content/plugins/airtable-forms/assets/css/main.css',array(),null);

        //Scripts
        wp_register_script('atfr-main-script', '/wp-content/plugins/airtable-forms/assets/js/atfr-main-settings.js', array(), null, true);
        wp_localize_script('atfr-main-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

        wp_enqueue_script('jquery');
        wp_enqueue_script('atfr-main-script');
    }

    static function check_active_settings()
    {
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . self::$table_name;

        // Check if the airtable option is enabled
        if (!get_option('atfr-database-version')) {
            add_option('atfr-database-version');
        }

        // Check if the airtable API Key option is enabled
        if (!get_option('atfr-api-key')) {
            add_option('atfr-api-key');
        }

        // Check if the forms table is create
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql =
                "CREATE TABLE $table_name (
                      id mediumint(9) NOT NULL AUTO_INCREMENT,
                      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                      name text NOT NULL,
                      description text NOT NULL,
                      fields text NOT NULL,
                      table text NOT NULL,
                      base text NOT NULL,
                      PRIMARY KEY  (id)
                    ) $charset_collate";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    static function activate()
    {
        self::check_active_settings();
    }
}

// Launch the plugin
new Atfr();