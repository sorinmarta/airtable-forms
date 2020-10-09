<?php


namespace AirtableForms;

if (!defined('ABSPATH')) {
    die('You are not allowed to call this page directly.');
}

class Atfr
{
    static $table_name = 'atfr_forms';

    public function __construct()
    {
        $this->loader();
        add_action('admin_enqueue_scripts',array($this, 'enqueue'));
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
        wp_register_script('atfr-main-script', '/wp-content/plugins/airtable-forms/assets/js/atfr-main-settings.js', array());
        wp_localize_script('atfr-main-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

        wp_enqueue_script('jquery');
        wp_enqueue_script('atfr-main-script');
    }

    static function check_active_settings()
    {
        global $wpdb, $table_prefix;
        $table_name = $table_prefix . self::$table_name;

        // Check if the active-forms option is enabled
        if (!get_option('atfr-active-forms')) {
            add_option('atfr-active-forms');
        }

        // Check if the airtable option is enabled
        if (!get_option('atfr-database-version')) {
            add_option('atfr-database-version');
        }

        // Check if the airtable API Key option is enabled
        if (!get_option('atfr-api-key')) {
            add_option('atfr-api-key');
        }

        // Check if the airtable base option is enabled
        if (!get_option('atfr-base')) {
            add_option('atfr-base');
        }

        // Check if the airtable table option is enabled
        if (!get_option('atfr-table')) {
            add_option('atfr-table');
        }

        // Check if the forms table is create
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql =
                "CREATE TABLE $table_name (
                      id mediumint(9) NOT NULL AUTO_INCREMENT,
                      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                      name tinytext NOT NULL,
                      description text NOT NULL,
                      fields text NOT NULL,
                      PRIMARY KEY  (id)
                    ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    static function set_notice_data($message, $type)
    {
        $_SESSION['atfr-message'] = $message;
        $_SESSION['atfr-type'] = $type;
    }

    static function determinate_notice_type($type)
    {
        # TODO: To add all the error types
        switch ($type){
            case 'success':
                $class = 'notice-success';
                break;
            default:
                $class = '';
        }
    }

    static function activate()
    {
        self::check_active_settings();
    }
}