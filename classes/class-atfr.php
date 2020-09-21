<?php


namespace AirtableForms;

if (!defined('ABSPATH')) {
    die('You are not allowed to call this page directly.');
}

class Atfr{
    static $table_name = 'atfr_forms';

    public function __construct()
    {
        // Add the admin pages
        add_action('admin_menu',array($this,'create_admin_pages'));
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

    static function activate()
    {
        self::check_active_settings();
    }

    public function create_admin_pages(){
        // Main Forms Page
        add_menu_page(__('Airtable Forms',ATFR_DOMAIN),'Airtable Forms','manage_options','airtable-forms',array($this,'credentials_page_contents'),'dashicons-media-document');

        // Settings sub-menu item
        add_submenu_page('airtable-forms','Airtable Credentials','Credentials','manage_options','airtable-credentials',array($this,'forms_page_contents'));
    }

    public function forms_page_contents(){
        ?>
            <h1><?php esc_html_e('Airtable Credentials', ATFR_DOMAIN); ?></h1>
        <?php
    }

    public function credentials_page_contents(){
        ?>
            <h1><?php esc_html_e('Airtable Forms', ATFR_DOMAIN); ?></h1>
        <?php

        if(empty(get_option('atfr-api-key'))){
            ?>
                <div class="atfr-credentials-notification">
                    <h3>Please enter your Airtable API credentials <a href="/wp-admin/admin.php?page=airtable-credentials">here</a></h3>
                </div>
            <?php
        }
    }
}