<?php

//Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/***************************
* create project cpt
***************************/
function wcd_project_post_type() {
    register_post_type( 'wcd-project',
        array(
			'labels' => array(
                'name' => _x('Project', 'post type general name'),
                'singular_name' => _x('Project', 'post type singular name'),
                'add_new' => _x('Add New', 'project'),
                'add_new_item' => __('Add New Project'),
                'edit_item' => __('Edit Project'),
                'new_item' => __('New Project'),
                'all_items' => __('Projects'),
                'view_item' => __('View Projects'),
                'search_items' => __('Search Projects'),
                'not_found' =>  __('Project wasn\'t found'),
                'not_found_in_trash' => __('Project wasn\'t found in Trash'), 
                'parent_item_colon' => '',
                'menu_name' => 'wcd Projects'				
			),
			'public' => true,
            'publicly_queryable' => false,
            'show_in_menu' => 'wcd_crm',
            'query_var' => true,
			'supports' => array( 'title' ),
			'capability_type' => 'post',
			'rewrite' => true,
			'menu_position' => 5,
            'hierarchical' => false,
			'menu_icon' => 'dashicons-portfolio',
		)
	);
}
add_action( 'init', 'wcd_project_post_type' );

/***************************
* create project mimes
***************************/
function wcd_upload_mimes($existing_mimes = array()) {

    if( ! isset($existing_mimes['eps']) ){ $existing_mimes['eps'] = 'application/eps';} 
    if( ! isset($existing_mimes['ai']) ){$existing_mimes['ai'] = 'application/postscript';} 
    if( ! isset($existing_mimes['psd']) ){$existing_mimes['psd'] = 'image/vnd.adobe.photoshop';}
    if( ! isset($existing_mimes['svgz']) ){$existing_mimes['svgz'] = 'image/svg+xml';}
    if( ! isset($existing_mimes['svg']) ){$existing_mimes['svg'] = 'image/svg+xml';}
    if( ! isset($existing_mimes['shtml']) ){$existing_mimes['shtml'] = 'application/xhtml+xml';}
    if( ! isset($existing_mimes['xhtml']) ){$existing_mimes['xhtml'] = 'application/xhtml+xml';}
    if( ! isset($existing_mimes['xml']) ){$existing_mimes['xml'] = 'application/xml';} 
    if( ! isset($existing_mimes['eps']) ){$existing_mimes['eps'] = 'text/html';}
    if( ! isset($existing_mimes['htm']) ){$existing_mimes['htm'] = 'text/html';} 
    if( ! isset($existing_mimes['htmls']) ){$existing_mimes['htmls'] = 'text/html';}
    if( ! isset($existing_mimes['tiff']) ){$existing_mimes['tiff'] = 'image/tiff';}
    if( ! isset($existing_mimes['tif']) ){$existing_mimes['tif'] = 'image/tiff';}
    if( ! isset($existing_mimes['css']) ){$existing_mimes['css'] = 'text/css';}
    if( ! isset($existing_mimes['php']) ){$existing_mimes['php'] = 'text/php';}
    if( ! isset($existing_mimes['zip']) ){$existing_mimes['zip'] = 'application/zip';}
    if( ! isset($existing_mimes['doc']) ){$existing_mimes['doc'] = 'application/msword';}
    if( ! isset($existing_mimes['pdf']) ){$existing_mimes['pdf'] = 'application/pdf';}
    if( ! isset($existing_mimes['pot|pps|ppt']) ){$existing_mimes['pot|pps|ppt'] ='application/vnd.ms-powerpoint';}
    if( ! isset($existing_mimes['xla|xls|xlt|xlw']) ){$existing_mimes['xla|xls|xlt|xlw'] = 'application/vnd.ms-excel';}
    if( ! isset($existing_mimes['docx']) ){$existing_mimes['docx'] ='application/vnd.openxmlformats-officedocument.wordprocessingml.document';}
    if( ! isset($existing_mimes['xlsx']) ){$existing_mimes['docm'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';}
    if( ! isset($existing_mimes['ppsx']) ){$existing_mimes['ppsx'] = 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';}
    if( ! isset($existing_mimes['onetoc|onetoc2|onetmp|onepkg']) ){$existing_mimes['onetoc|onetoc2|onetmp|onepkg'] = 'application/onenote';}

    return $existing_mimes;
}

add_filter('upload_mimes', 'wcd_upload_mimes');


/***************************
* create project metaboxes
***************************/

function wcd_register_project_meta_boxes( $meta_boxes ) {
    $prefix = 'wcd_';
    
    $meta_boxes[] = array(
        'id'       => 'project_description',
        'title'    => 'Project Description',
        'pages'    => array('wcd-project'),
        'context'  => 'normal',
        'priority' => 'low',
        

        'fields' => array(            
        
            array(
                'name'  => 'Description',
                'id'    => $prefix . 'proj_descriptions',
                'type'  => 'wysiwyg',
                'admin_columns' => array(
                    'position'  => 'after title',
                ),
            ),
            
                        
        ), // end description fields
    ); // end description
    
    // project status meta box
    $meta_boxes[] = array(
        'id'       => 'project_status',
        'title'    => 'Project Status',
        'pages'    => array('wcd-project'),
        'context'  => 'side',
        'priority' => 'high',
        

        'fields' => array(            
        
            array(
                'name'  => 'Commence Date',
                'desc'  => 'Date commenced',
                'id'    => $prefix . 'commence',
                'type'  => 'date',
                'admin_columns' => array(
                    'position'  => 'replace date',
                    'sort'      => true,
                ),
            ),
            
            array(
                $settings = get_option( 'wcd_crm_settings' ),
                $project_status = $settings['project_status'],
                'name'  => 'Project Status',
                'id'    => $prefix . 'status',
                'type'  => 'select',
                'options' => wcd_project_get_status_options(),
                'placeholder' => 'Select a status',
                'admin_columns' => array(
                    'position'  => 'after wcd_proj_descriptions',
                ),
            ),
            
            array(
                'name'  => 'Closed Date',
                'desc'  => 'Date completed',
                'id'    => $prefix . 'closed',
                'type'  => 'date',
            ),
            
                        
        ), // end status fields
    ); // status


    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'wcd_register_project_meta_boxes' );

function add_project_meta_box(){
    $status = get_post_status();
    if($status != "auto-draft") {
        add_meta_box('project-btn', 'Print Project', 'print_project_pdf', 'wcd-project', 'side', 'high');
    }
}

add_action('add_meta_boxes', 'add_project_meta_box'); 

function print_project_pdf(){
    echo '<a href="../wp-content/plugins/wcd-crm/plugins/fpdf/project-fpdf.php?ID='.$_GET["post"].'" target="_blank" class="button button-primary button-large">Print Preview</a>';  
}

function build_new_table($tasks){
    // data rows
    foreach( $tasks as $key=>$value){
        
        $html .= '<tr class="item-row">';

            $html .= '<td>' . $value['wcd_contact_task_description'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_style'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_due'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_status'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_date_completed'] . '</td>';

        $html .= '</tr>';
        

    }

    return $html;
}

function build_exp_table($expenses){
    $yourcurrency = quote_currency_info();
    // data rows
    foreach( $expenses as $key=>$value){
        
        $html .= '<tr class="item-row">';

            $html .= '<td>' . $value['wcd_exp_description'] . '</td>';
            $html .= '<td>' . $value['wcd_exp_qty'] . '</td>';
            $html .= '<td>' . $yourcurrency . '&nbsp;' . $value['wcd_exp_cost'] . '</td>';
            $html .= '<td>' . $value['wcd_exp_tax'] . '%</td>';
            $html .= '<td>' . $yourcurrency . '&nbsp;' . $value['wcd_exp_total'] . '</td>';

        $html .= '</tr>';
        

    }

    return $html;
}

function get_expense_total($expenses){
    
    $total=0;
    foreach( $expenses as $key=>$value){
        $total+=$value['wcd_exp_total'];
    }
    return $total;

}
