<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

require_once dirname(__FILE__) . '/quote_print.php';

function wcd_quote_post_type()
{

    register_post_type('wcd-quote',

    array(

        'labels' => array(

            'name' => _x('Quote', 'post type general name') ,

            'singular_name' => _x('Quote', 'post type singular name') ,

            'add_new' => _x('Add New', 'quote') ,

            'add_new_item' => __('Add New Quote') ,

            'edit_item' => __('Edit Quote') ,

            'new_item' => __('New Quote') ,

            'all_items' => __('Quotes') ,

            'view_item' => __('View Quote') ,

            'search_items' => __('Search Quotes') ,

            'not_found' => __('Quote wasn\'t found') ,

            'not_found_in_trash' => __('Quote wasn\'t found in Trash') ,

            'parent_item_colon' => '',

            'menu_name' => 'wcd Quotes'

        ) ,

        'public' => true,

        'publicly_queryable' => false,

        'show_in_menu' => 'wcd_crm',

        'query_var' => true,

        'supports' => array(
            'title'
        ) ,

        'capability_type' => 'post',

        'rewrite' => true,

        'menu_position' => 5,

        'hierarchical' => false,

        'menu_icon' => 'dashicons-admin-links',

    )
);

}

add_action('init', 'wcd_quote_post_type');

/***************************

* create contact metaboxes

***************************/

function wcd_register_quote_contact_meta_boxes($meta_boxes)
{

    $prefix = 'wcd_quote_';

    // start customer
    $meta_boxes[] = array(

        'id' => $prefix . 'customer',

        'title' => 'Customer Info',

        'pages' => 'wcd-quote',

        'context' => 'normal',

        'priority' => 'low',

        'fields' => array(

            array(

                'name' => 'Name',

                'id' => $prefix . 'name',

                'type' => 'post',

                'post_type' => 'wcd-contact',

                'placeholder' => 'Select a Customer',

                'columns' => 12,
                'admin_columns' => array(
                    'position' => 'after title',
                    'title' => 'Customer Name',
                    'sort' => true,
                ) ,

            ) ,

            array(

                'name' => 'Company',

                'id' => $prefix . 'company',

                'type' => 'text',

                'columns' => 6,

                'hidden' => array(
                    $prefix . 'name',
                    ''
                ) ,
                'admin_columns' => array(
                    'position' => 'after wcd_quote_name',
                    'title' => 'Company Name',
                    'sort' => true,
                ) ,

            ) ,

            array(

                'name' => 'Email',

                'id' => $prefix . 'email',

                'type' => 'text',

                'columns' => 6,

                'hidden' => array(
                    $prefix . 'name',
                    ''
                )

            ) ,

            array(

                'name' => 'Phone',

                'id' => $prefix . 'phone',

                'type' => 'text',

                'columns' => 6,

                'hidden' => array(
                    $prefix . 'name',
                    ''
                )

            ) ,

            array(

                'name' => 'Address',

                'id' => $prefix . 'address',

                'type' => 'text',

                'columns' => 6,

                'hidden' => array(
                    $prefix . 'name',
                    ''
                )

            )

        ) // end customer fields
        
    ); // end customer
    

    // start products
    $meta_boxes[] = array(

        'id' => $prefix . 'products',

        'title' => 'Product Info',

        'pages' => 'wcd-quote',

        'context' => 'normal',

        'priority' => 'low',

        'fields' => array(

            array(

                'id' => 'quote-products',

                //'name' => 'Products',
                'type' => 'Group',

                'clone' => true,

                'fields' => array(

                    array(

                        'name' => 'Product',

                        'id' => $prefix . 'product',

                        'type' => 'post',

                        'post_type' => 'wcd-product',

                        'placeholder' => 'Select a Product',

                        'columns' => 4

                    ) ,

                    array(

                        'name' => 'Description',

                        'id' => $prefix . 'description',

                        'type' => 'textarea',

                        'columns' => 4,

                    ) ,

                    array(

                        'name' => 'Qty',

                        'id' => $prefix . 'qty',

                        'type' => 'number',

                        'std' => 1,

                        'step' => 1,

                        'columns' => 2,

                    ) ,

                    array(

                        'name' => 'Price',

                        'id' => $prefix . 'price',

                        'type' => 'text',

                        'columns' => 2,

                    ) ,

                    array(

                        'name' => 'Cost',

                        'id' => $prefix . 'cost',

                        'type' => 'hidden',

                        'columns' => 12,

                    )

                ) // end product fields
                

                
            ) // end group fieds
            

            
        ) // end all fields
        

        
    ); // end products
    

    // start notes
    $meta_boxes[] = array(

        'id' => $prefix . 'quote_notes',

        'title' => 'Notes',

        'pages' => 'wcd-quote',

        'context' => 'side',

        'priority' => 'low',

        'fields' => array(

            array(

                'name' => 'Notes',

                'id' => $prefix . 'notes',

                'std' => 'Quote valid for 30 days from date of issue',

                'type' => 'textarea'

            )

        ) , // end note fields
        
    ); // end notes
    

    // start status
    $meta_boxes[] = array(

        'id' => $prefix . 'quote_status',

        'title' => 'Status',

        'pages' => 'wcd-quote',

        'context' => 'side',

        'priority' => 'high',

        'fields' => array(

            array(

                'name' => 'Quote Status',

                'id' => $prefix . 'status',

                'type' => 'select',

                'options' => array(

                    'quote' => 'Quoted',

                    'won' => 'Won',

                    'lost' => 'Lost',

                ) ,

                'placeholder' => 'Select a status',
                'admin_columns' => array(
                    'position' => 'after wcd_quote_company',
                    'title' => 'Quote Status',
                    'sort' => true,
                ) ,

            ) ,

        ) , // end note fields
        
    ); // end notes
    

    return $meta_boxes;

}

add_filter('rwmb_meta_boxes', 'wcd_register_quote_contact_meta_boxes');

function build_table($products)
{

    $settings = get_option('wcd_crm_settings');
    $yourcurrency = $yourcurrency = $settings['quote_currency'];
    $html = '';
    // data rows
    foreach ($products as $key => $value)
    {

        $product = get_post($value['wcd_quote_product']);
        // var_dump($product);
        $html .= '<tr class="item-row">';

        if ($product->post_title):
            $html .= '<td>' . $product->post_title . '</td>';
        else:
            $html .= '<td></td>';
        endif;

        if ($product->post_content):
            $html .= '<td>' . $product->post_content . '</td>';
        else:
            $html .= '<td></td>';
        endif;

        if ($value['wcd_quote_qty']):
            $html .= '<td>' . $value['wcd_quote_qty'] . '</td>';
        else:
            $html .= '<td></td>';
        endif;

        if ($value['wcd_quote_price']):
            $html .= '<td>' . $yourcurrency . '&nbsp;' . $value['wcd_quote_price'] . '</td>';
        else:
            $html .= '<td></td>';
        endif;

        if ($value['wcd_quote_qty'] && $value['wcd_quote_price']):
            $html .= '<td>' . $yourcurrency . '&nbsp;' . $value['wcd_quote_qty'] * $value['wcd_quote_price'] . '</td>';
        else:
            $html .= '<td></td>';
        endif;

        $html .= '</tr>';

    }

    return $html;

}

function get_price_total($products)
{

    $total = 0;

    foreach ($products as $key => $value)
    {

        $total += $value['wcd_quote_qty'] * $value['wcd_quote_price'];

    }

    return $total;

}

function add_your_meta_box()
{
    $status = get_post_status();
    if ($status != "auto-draft")
    {
        add_meta_box('quote-btn', 'Issue Quote', 'print_pdf', 'wcd-quote', 'side', 'high');
    }
}

add_action('add_meta_boxes', 'add_your_meta_box');

function print_pdf()
{
    echo '<a href="../wp-content/plugins/wcd-crm/plugins/fpdf/quote-fpdf.php?ID=' . $_GET["post"] . '" target="_blank" class="button button-primary button-large">Print Preview</a>';
}

