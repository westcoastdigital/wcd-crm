<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

/***************************
 * create product cpt
 ***************************/
function wcd_product_post_type()
{
    register_post_type('wcd-product', array(
        'labels' => array(
            'name' => _x('Product', 'post type general name') ,
            'singular_name' => _x('Product', 'post type singular name') ,
            'add_new' => _x('Add New', 'Product') ,
            'add_new_item' => __('Add New Product') ,
            'edit_item' => __('Edit Product') ,
            'new_item' => __('New Product') ,
            'all_items' => __('Products') ,
            'view_item' => __('View Products') ,
            'search_items' => __('Search Products') ,
            'not_found' => __('Product wasn\'t found') ,
            'not_found_in_trash' => __('Product wasn\'t found in Trash') ,
            'parent_item_colon' => '',
            'menu_name' => 'wcd Products'
        ) ,
        'public' => true,
        'publicly_queryable' => false,
        'show_in_menu' => 'wcd_crm',
        'query_var' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ) ,
        'capability_type' => 'post',
        'rewrite' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-cart',
    ));
}
add_action('init', 'wcd_product_post_type');

/***************************
 * create product metaboxes
 ***************************/

function wcd_register_product_meta_boxes($meta_boxes)
{
    $prefix = 'wcd_product_';
    $settings = get_option('wcd_crm_settings');

    // b&a meta box
    $meta_boxes[] = array(
        'id' => 'product_info',
        'title' => 'Product Info',
        'pages' => array(
            'wcd-product'
        ) ,
        'context' => 'side',

        'fields' => array(

            array(
                'name' => 'Cost',
                'id' => $prefix . 'cost',
                'type' => 'text',
                'admin_columns' => array(
                    'position' => 'after title',
                    'title' => 'Cost',
                    'before' => $settings['quote_currency'],
                ) ,
            ) ,

            array(
                'name' => 'RRP',
                'id' => $prefix . 'rrp',
                'type' => 'text',
                'admin_columns' => array(
                    'position' => 'replace date',
                    'title' => 'RRP',
                    'before' => $settings['quote_currency'],
                ) ,
            ) ,

            array(
                'name' => 'Unit',
                'id' => $prefix . 'unit',
                'type' => 'select',
                'options' => wcd_product_get_unit_options() ,
                'placeholder' => 'Select your unit of sale',
                'admin_columns' => array(
                    'position' => 'after title',
                    'title' => 'Unit of Sale',
                ) ,
            ) ,

            array(
                'name' => 'Type',
                'id' => $prefix . 'type',
                'type' => 'select',
                'options' => wcd_product_get_type_options() ,
                'placeholder' => 'Select your product type',
                'admin_columns' => array(
                    'position' => 'after title',
                    'title' => 'Product Type',
                    'sort' => true,
                ) ,
            ) ,
        ) ,
    );

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'wcd_register_product_meta_boxes');

