<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

function wcd_crm_settings_pages($settings_pages)
{
    $settings_pages[] = array(
        'id' => 'wcd_crm-settings',
        'option_name' => 'wcd_crm_settings',
        'menu_title' => __('Settings', 'wcd_crm') ,
        'parent' => 'wcd_crm', // Note this
        
    );
    return $settings_pages;
}
add_filter('mb_settings_pages', 'wcd_crm_settings_pages');

function wcd_crm_settings_meta_boxes($meta_boxes)
{
    $meta_boxes[] = array(
        'id' => 'settings',
        'title' => __('WCD CRM Settings', 'wcd_crm') ,
        'settings_pages' => 'wcd_crm-settings',
        'tabs' => array(
            'quote_settings' => array(
                'label' => __('Quote Settings', 'wcd_crm') ,
                'icon' => 'dashicons-info',
            ) ,
            'contact_settings' => array(
                'label' => __('Contact Settings', 'wcd_crm') ,
                'icon' => 'dashicons-admin-users',
            ) ,
            'product_settings' => array(
                'label' => __('Product Settings', 'wcd_crm') ,
                'icon' => 'dashicons-cart',
            ) ,
            'project_settings' => array(
                'label' => __('Project Settings', 'wcd_crm') ,
                'icon' => 'dashicons-admin-network',
            ) ,
            'task_settings' => array(
                'label' => __('Task Settings', 'wcd_crm') ,
                'icon' => 'dashicons-admin-links',
            ) ,
        ) ,
        'tab_style' => 'left',
        'tab_wrapper' => true,
        'fields' => array(
            array(
                'name' => __('Logo', 'wcd_crm') ,
                'id' => 'quote_logo',
                'type' => 'file_input',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Your Name', 'wcd_crm') ,
                'id' => 'quote_name',
                'type' => 'text',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Your Company', 'wcd_crm') ,
                'id' => 'quote_company',
                'type' => 'text',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Email', 'wcd_crm') ,
                'id' => 'quote_email',
                'type' => 'email',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Phone Number', 'wcd_crm') ,
                'id' => 'quote_phone',
                'type' => 'text',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Currency', 'wcd_crm') ,
                'id' => 'quote_currency',
                'type' => 'select',
                'options' => array(
                    '$' => '$',
                    '£' => '£',
                    '€' => '€',
                    '¥' => '¥',
                ) ,
                'placeholder' => __('Select a currency', 'wcd_crm') ,
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Address', 'wcd_crm') ,
                'id' => 'quote_address',
                'type' => 'text',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Location', 'wcd_crm') ,
                'id' => 'quote_map',
                'type' => 'map',
                'address_field' => 'quote_address',
                'api_key' => 'AIzaSyDxWwN8CMi83yvBdQ98rDbLkNNlR-zgNxA',
                'tab' => 'quote_settings',
            ) ,
            array(
                'name' => __('Relationship Status', 'wcd_crm') ,
                'id' => 'contact_relationship',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'contact_settings',
            ) ,
            array(
                'name' => __('Product Unit', 'wcd_crm') ,
                'id' => 'product_unit',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'product_settings',
            ) ,
            array(
                'name' => __('Product Type', 'wcd_crm') ,
                'id' => 'product_type',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'product_settings',
            ) ,
            array(
                'name' => __('Project Status', 'wcd_crm') ,
                'id' => 'project_status',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'project_settings',
            ) ,
            array(
                'name' => __('Task Style', 'wcd_crm') ,
                'id' => 'task_style',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'task_settings',
            ) ,
            array(
                'name' => __('Task Status', 'wcd_crm') ,
                'id' => 'task_status',
                'type' => 'text',
                'clone' => true,
                'sort_clone' => true,
                'tab' => 'task_settings',
            ) ,
        ) ,
    );
    return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'wcd_crm_settings_meta_boxes');

