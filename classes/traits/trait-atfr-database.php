<?php


namespace AirtableForms;

/**
 * Trait Atfr_Database
 * @package AirtableForms
 */

/**
 * TODO:
 *  [x] Create form
 *  [x] Update form
 *  [x] Delete form
 *  [] Return form
 *  [] Get all forms
 */


trait Atfr_Database
{
    private function get_table_name(){
        global $table_prefix;

        return $table_prefix . ATFR_TABLE;
    }

    protected function create_form($values = array()){
        global $wpdb;
        $table_name = $this->get_table_name();

        $wpdb->insert($table_name, $values);
        $wpdb->show_errors();
    }

    protected function edit_form($values = array(), $where = array()){
        global $wpdb;
        $table_name = $this->get_table_name();

        $wpdb->update($table_name,$values,$where);
        $wpdb->show_errors();
    }

    protected function delete_form($where = array()){
        global $wpdb;
        $table_name = $this->get_table_name();

        $wpdb->delete($table_name,$where);
    }
}