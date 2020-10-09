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

// Dependencies
use AirtableForms\Atfr;

// Constants
define('ATFR_FOLDER','airtable-forms');
define('ATFR_PLUGIN', WP_PLUGIN_DIR.'/'.ATFR_FOLDER.'/');
define('ATFR_CLASSES', ATFR_PLUGIN . 'classes/');
define('ATFR_ASSETS', ATFR_PLUGIN . 'assets/');
define('ATFR_VERSION', '1.0.0');
define('ATFR_DOMAIN', 'airtable-forms');
define('ATFR_CREDS_PAGE', admin_url('admin.php') . '?page=airtable-credentials');

// Plugin Files
require_once(ATFR_CLASSES . 'class-atfr.php');

// Plugin Activation
register_activation_hook(ATFR_PLUGIN,array('Atfr','activate'));

// Launch the plugin
new Atfr();

/**
 * TODO:
 *  [x] Create the init class
 *  [x] Add a function that will execute when the plugin is installed
 *  [x] In the init class create a function that will add an option in the database for forms ids and add it to the installation function
 *  [x] Create a table in the database that will store the value using a function and add it to the installation function
 *  [x] Create a dashboard page
 *  [x] Add the credentials submenu item
 *  [x] Add fields to enter the Airtable required data for the API
 *  [] Retrieve all the fields of the table and return them
 *  [] Output the fields with checkboxes
 *  [] Create a shortcode for dynamic forms
 */