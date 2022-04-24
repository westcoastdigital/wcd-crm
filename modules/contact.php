<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

/***************************
 * create contact cpt
 ***************************/
function wcd_contact_post_type()
{
    register_post_type('wcd-contact', array(
        'labels' => array(
            'name' => _x('Contact', 'post type general name') ,
            'singular_name' => _x('Contact', 'post type singular name') ,
            'add_new' => _x('Add New', 'Contact') ,
            'add_new_item' => __('Add New Contact') ,
            'edit_item' => __('Edit Contact') ,
            'new_item' => __('New Contact') ,
            'all_items' => __('Contacts') ,
            'view_item' => __('View Contacts') ,
            'search_items' => __('Search Contacts') ,
            'not_found' => __('Contact wasn\'t found') ,
            'not_found_in_trash' => __('Contact wasn\'t found in Trash') ,
            'parent_item_colon' => '',
            'menu_name' => 'wcd Contacts'
        ) ,
        'public' => true,
        'publicly_queryable' => false,
        'show_in_menu' => 'wcd_crm',
        'query_var' => true,
        'supports' => array(
            'title',
            'thumbnail'
        ) ,
        'capability_type' => 'post',
        'rewrite' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-admin-users',
    ));
}
add_action('init', 'wcd_contact_post_type');

/***************************
 * create contact metaboxes
 ***************************/

function wcd_contact_before_meta_boxes($meta_boxes)
{
    $prefix = 'wcd_contact_';

    // contact info meta box
    $meta_boxes[] = array(
        'id' => $prefix . 'contact',
        'title' => 'Contact Info',
        'pages' => array(
            'wcd-contact'
        ) ,
        'context' => 'normal',
        'priority' => 'high',

        'fields' => array(

            array(
                'name' => 'Company',
                'id' => $prefix . 'company',
                'type' => 'text',
                'columns' => 6
            ) ,
            array(
                'name' => 'Relationship',
                'id' => $prefix . 'relationship',
                'type' => 'select',
                'options' => wcd_contact_get_relationship_options() ,
                'placeholder' => 'Choose your relationship',
                'columns' => 6
            ) ,

            array(
                'name' => 'Phone',
                'id' => $prefix . 'phone',
                'type' => 'text',
                'columns' => 6,
                'admin_columns' => array(
                    'position' => 'after title',
                ) ,
            ) ,

            array(
                'name' => 'Email',
                'id' => $prefix . 'email',
                'type' => 'text',
                'columns' => 6,
                'admin_columns' => array(
                    'position' => 'after wcd_contact_phone',
                ) ,
            ) ,

            array(
                'name' => 'Address',
                'id' => $prefix . 'address',
                'type' => 'textarea',
                'columns' => 6,
                'admin_columns' => array(
                    'position' => 'replace date',
                ) ,
            ) ,

            array(
                'name' => 'Postal Address',
                'id' => $prefix . 'postal',
                'type' => 'textarea',
                'columns' => 6
            ) ,

        )
    );

    // contact tasks meta box
    $meta_boxes[] = array(
        'id' => $prefix . 'tasks',
        'title' => 'Tasks',
        'pages' => array(
            'wcd-contact'
        ) ,
        'context' => 'normal',
        'priority' => 'high',

        'fields' => array(

            array(
                'id' => $prefix . 'contact_tasks',
                'type' => 'group',
                'clone' => true,

                'fields' => array(
                    array(
                        'id' => $prefix . 'task_id',
                        'type' => 'hidden',
                        'value' => 'hidden'
                    ) ,
                    array(
                        'name' => 'Task Name',
                        'id' => $prefix . 'task_name',
                        'type' => 'text',
                        'columns' => 6
                    ) ,

                    array(
                        'name' => 'Task Style',
                        'id' => $prefix . 'task_style',
                        'type' => 'select',
                        'options' => array(
                            'task_email' => 'Email',
                            'task_phone' => 'Phone',
                            'task_meeting' => 'Meeting',
                            'task_skype' => 'Skype',
                            'task_mockup' => 'Mockup',
                            'task_wireframe' => 'Wireframe',
                            'task_design' => 'Design',
                            'task_photography' => 'Photography',
                            'task_production' => 'Production',
                        ) ,
                        'placeholder' => 'Select a style',
                        'columns' => 6
                    ) ,

                    array(
                        'name' => 'Due Date',
                        'id' => $prefix . 'task_due',
                        'type' => 'datetime',
                        'columns' => 4
                    ) ,

                    array(
                        'name' => 'Status',
                        'id' => $prefix . 'task_status',
                        'type' => 'select',
                        'options' => array(
                            'task_not-started' => 'Not Started',
                            'task_in_progress' => 'In Progess',
                            'task_waiting_customer' => 'Waiting Customer',
                            'task_completed' => 'Completed',
                        ) ,
                        'placeholder' => 'Select a status',
                        'columns' => 4
                    ) ,

                    array(
                        'name' => 'Date Complete',
                        'id' => $prefix . 'task_date_completed',
                        'type' => 'datetime',
                        'columns' => 4
                    ) ,

                    array(
                        'name' => 'Task Description',
                        'id' => $prefix . 'task_description',
                        'type' => 'textarea',
                        'columns' => 12
                    ) ,
                ) , // end task fields
                
            ) ,
        ) ,
    ); // end tasks
    

    // contact social meta box
    $meta_boxes[] = array(
        'id' => $prefix . 'social',
        'title' => 'Social Links',
        'pages' => array(
            'wcd-contact'
        ) ,
        'context' => 'side',

        'fields' => array(

            array(
                'id' => $prefix . 'contact_social',
                'type' => 'group',
                'clone' => true,

                'fields' => array(

                    array(
                        'name' => 'Social Media',
                        'id' => $prefix . 'social_type',
                        'type' => 'select',
                        'options' => array(
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'google' => 'Google+',
                            'pinterest' => 'Pinterest',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'website' => 'Website',
                            '500px' => '500px',
                            'behance' => 'Behance',
                        ) ,
                        'placeholder' => 'Select the Social Media type',
                    ) ,

                    array(
                        'name' => 'Link',
                        'id' => $prefix . 'social_link',
                        'type' => 'text',
                        'placeholder' => 'Enter the URL',
                    ) ,

                ) , // end task fields
                
            ) ,
        ) ,
    ); // end tasks
    

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'wcd_contact_before_meta_boxes');

