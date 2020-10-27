<?php


namespace AirtableForms;


class Atfr_Settings
{
    private $key;
    private $base;
    private $table;

    public function __construct(){
        // Add the admin pages
        add_action('admin_menu',array($this,'create_admin_pages'));

        // AJAX handler
        add_action('wp_ajax_atfr_creds_response', array($this, 'creds_form_handler_two'));
    }

    public function create_admin_pages(){
        // Main Forms Page
        add_menu_page(__('Airtable Forms',ATFR_DOMAIN),'Airtable Forms','manage_options','airtable-forms',array($this,'credentials_page_contents'),'dashicons-media-document');

        // Settings sub-menu item
        add_submenu_page('airtable-forms','Airtable Credentials','Credentials','manage_options','airtable-credentials',array($this,'forms_page_contents'));
    }

    public function forms_page_contents(){
        include_once(ATFR_PLUGIN . 'views/atfr-credentials-page.php');
    }

    public function credentials_page_contents(){
        ?>
        <h1 class="atfr-heading"><?php esc_html_e('Airtable Forms', ATFR_DOMAIN); ?></h1>
        <?php

        if(empty(get_option('atfr-api-key'))){
            ?>
            <div class="atfr-credentials-notification">
                <h3 class="atfr-heading">Please enter your Airtable API credentials <a href="/wp-admin/admin.php?page=airtable-credentials">here</a></h3>
            </div>
            <?php
        }
    }

    public function creds_form_handler_two(){
        $this->creds_form_validation_two($_REQUEST);

        if( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'atfr_add_creds_nonce') ) {

            $this->key      = $_REQUEST['atfr_key'];

            update_option('atfr-api-key', $this->key);

            $result['type'] = 'success';
            $result['message'] = __('Settings Saved Successfully!', ATFR_DOMAIN);
        }else{
           $result['type'] = 'error';
           $result['message'] = __('Wrong something must be, young grasshopper.', ATFR_DOMAIN);
        }

        $result = json_encode($result);
        echo $result;
        die();
    }

    private function creds_form_validation_two($request){
        if (empty($_REQUEST['atfr_key'])){
            $result['type'] = 'error';
            $result['field'] = 'ATKey';
            $result['message'] = __('Please fill the Key field', ATFR_DOMAIN);

            $result = json_encode($result);
            echo $result;
            die();
        }
    }

}

new Atfr_Settings();