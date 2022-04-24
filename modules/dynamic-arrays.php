<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

function wcd_task_get_status_options($task_status_options = array())
{
    $task_status_options = array(
        'task_not-started' => 'Not Started',
        'task_in_progress' => 'In Progess',
        'task_waiting_customer' => 'Waiting Customer',
        'task_completed' => 'Completed',
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['task_status']))
    {
        foreach ($settings['task_status'] as $value => $label)
        {
            $task_status_options[$value] = $label;
        }
    }
    return apply_filters('wcd_task_status_options', $task_status_options);
}

function wcd_task_get_style_options($task_style_options = array())
{
    $task_style_options = array(
        'task_email' => 'Email',
        'task_phone' => 'Phone',
        'task_meeting' => 'Meeting',
        'task_skype' => 'Skype',
        'task_mockup' => 'Mockup',
        'task_wireframe' => 'Wireframe',
        'task_design' => 'Design',
        'task_photography' => 'Photography',
        'task_production' => 'Production',
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['task_style']))
    {
        foreach ($settings['task_style'] as $value => $label)
        {
            $task_style_options[$value] = $label;
        }
    }
    return apply_filters('wcd_task_style_options', $task_style_options);
}

function wcd_project_get_status_options($status_options = array())
{
    $status_options = array(
        'contact' => 'Initial Contact',
        'quote' => 'Quoted',
        'won' => 'Won',
        'started' => 'Started',
        'lost' => 'Lost',
        'completed' => 'Completed',
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['project_status']))
    {
        foreach ($settings['project_status'] as $value => $label)
        {
            $status_options[$value] = $label;
        }
    }
    return apply_filters('wcd_project_status_options', $status_options);
}

function wcd_contact_get_relationship_options($relationship_options = array())
{
    $relationship_options = array(
        'prospect' => 'Prospect',
        'lead' => 'Lead',
        'client' => 'Client',
        'agency' => 'Agency',
        'assitant' => 'Assistant',
        'supplier' => 'Supplier'
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['contact_relationship']))
    {
        foreach ($settings['contact_relationship'] as $value => $label)
        {
            $relationship_options[$value] = $label;
        }
    }
    return apply_filters('wcd_contact_relationship_options', $relationship_options);
}

function wcd_product_get_unit_options($unit_options = array())
{
    $unit_options = array(
        'ea' => 'Each',
        'hr' => 'Hourly',
        'day' => 'Daily',
        'wk' => 'Weekly',
        'mth' => 'Month',
        'yr' => 'Yearly'
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['product_unit']))
    {
        foreach ($settings['product_unit'] as $value => $label)
        {
            $unit_options[$value] = $label;
        }
    }
    return apply_filters('wcd_product_unit_options', $unit_options);
}

function wcd_product_get_type_options($type_options = array())
{
    $type_options = array(
        'product' => 'Product',
        'service' => 'Service',
        'subscription' => 'Subscription',
        'support' => 'Support',
        'license' => 'License',
    );
    $settings = get_option('wcd_crm_settings');
    if (!empty($settings['product_type']))
    {
        foreach ($settings['product_type'] as $value => $label)
        {
            $type_options[$value] = $label;
        }
    }
    return apply_filters('wcd_product_type_options', $type_options);
}

