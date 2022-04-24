<?php
/*
Plugin Name: WCD CRM
Plugin URI: https://beaverlodgehq.com/
Description: A CRM tool including Project Management, Quote Tool, Products and Task management.
Version: 2.0.0
Author: West Coast Digital
Author URI: https://westcoastdigital.com.au
*/


//Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/***************************
* install required plugins
***************************/

$settings = get_option( 'wcd_crm_settings' );
$project_status = $settings['project_status'] ?? false;
$quote_currency = $settings['quote_currency'] ?? false;
require_once dirname( __FILE__ ) . '/modules/settings.php';
require_once dirname( __FILE__ ) . '/modules/dynamic-arrays.php';

if( $project_status && $quote_currency) {
$enable = true;
} else {
$enable = false;
}

if ( $enable ) :

require_once dirname( __FILE__ ) . '/modules/quote.php';
require_once dirname( __FILE__ ) . '/modules/contact.php';
require_once dirname( __FILE__ ) . '/modules/product.php';
require_once dirname( __FILE__ ) . '/modules/project.php';

endif;

/***************************
* enqueues stylesheet
***************************/
function add_wcd_stylesheets() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'quote_print.js', plugins_url( '/js/quote_print.js', __FILE__ ) );
    //wp_enqueue_script( 'main.js', plugins_url( '/js/main.js', __FILE__ ) );
    wp_enqueue_script( 'print.js', plugins_url( '/js/print.js', __FILE__ ) );
    
    wp_enqueue_style( 'main.css', plugins_url( '/css/main.css', __FILE__ ) );
    wp_enqueue_style( 'quote.css', plugins_url( '/css/quote_print.css', __FILE__ ) );
    wp_enqueue_style( 'quote_print.css', plugins_url( '/css/quote_print.css', __FILE__ ), null, null, 'print') ;
}

add_action( 'wp_enqueue_scripts', 'add_wcd_stylesheets' );


/***************************
* register metabox
***************************/
if( !class_exists( 'RW_Meta_Box' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/meta-box/meta-box.php');
}
if( !class_exists( 'RWMB_Columns' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/meta-box-columns/meta-box-columns.php');
}
if (!class_exists( 'RWMB_Group' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/meta-box-group/meta-box-group.php');
}
if (!class_exists( 'RWMB_Tabs' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/meta-box-tabs/meta-box-tabs.php');
}
if( !class_exists( 'MB_Conditional_Logic' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/meta-box-conditional-logic/meta-box-conditional-logic.php');
}
if( !class_exists( 'WCD_Meta_Box' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/wcd-ajax-meta-box/wcd-customer-meta-box.php');
}
if( !class_exists( 'MB_Settings_Page' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/mb-settings-page/mb-settings-page.php');
}
if( !class_exists( 'MB_Admin_Columns' ) ) {
include( plugin_dir_path( __FILE__ ) . '/plugins/mb-admin-columns/mb-admin-columns.php');
}

/***************************
* settings page
***************************/

function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('admin-script', plugins_url( 'admin-script.js', __FILE__ ) );
wp_enqueue_script('admin-script');
}
 
function my_admin_styles() {
wp_enqueue_style('thickbox');
}
 
if (isset($_GET['page']) && $_GET['page'] == 'wcd') {
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');
}

function wcd_add_admin_menu(  ) { 
    add_menu_page( 'WCD CRM', 'CRM', 'manage_options', 'wcd_crm', 'wcd_crm_page', 'dashicons-admin-network', 25);
    
    add_submenu_page( 'wcd_crm', 'WCD Help', 'Help', 'manage_options', 'wcd', 'project_wcd_shortcode_page' );

}
add_action( 'admin_menu', 'wcd_add_admin_menu' );


function project_wcd_shortcode_page(  ) { 

	?>
    <div class="shortcodes">
        <h2>WCD CRM</h2>
        <h3>Help videos coming soon</h3>
        <!-- <p><strong><em>This video was created for version 1! I will try to get new processes updated very soon for Version 2</em></strong></p>
        <iframe width="80%" height="500px" src="https://www.youtube.com/embed/MpntL8uPRKY?list=PLRF24_mmv_1hsw6oPtDmG1lGotGiZFquM" frameborder="0" allowfullscreen></iframe> -->
        <?php echo display_contact_form(); ?>
        <p><strong>If you still need help, please reach out to us over at <a href="https://westcoastdigital.com.a">westcoastdigital.com.au</a></strong></p>
    </div>
	<?php

}

if ( is_admin() ) {
function wcd_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'wcd_dashboard_task_widget',
                 'WCD Pending Tasks',
                 'wcd_dashboard_task_widget_function'
        );	
    
	wp_add_dashboard_widget(
                 'wcd_dashboard_quote_widget',
                 'WCD Pending Quotes',
                 'wcd_dashboard_quote_widget_function'
        );	
    
	wp_add_dashboard_widget(
                 'wcd_dashboard_contact_widget',
                 'WCD Oldest 10 Customers/Leads/Prospects',
                 'wcd_dashboard_contact_widget_function'
        );	
    
	wp_add_dashboard_widget(
                 'wcd_dashboard_project_widget',
                 'WCD Current Projects',
                 'wcd_dashboard_project_widget_function'
        );	
    
}
add_action( 'wp_dashboard_setup', 'wcd_add_dashboard_widgets' );
}

function wcd_dashboard_task_widget_function() {
    
    
    $args = array( 'post_type' => 'wcd-contact' );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    
    $wcd_tasks = rwmb_meta( 'wcd_contact_contact_tasks', 'type=group' );
    $id = get_the_ID();

    
    if (!empty ($wcd_tasks[0]['wcd_contact_task_name']) ) {
        if ( $wcd_tasks[0]['wcd_contact_task_status'] != 'task_completed' ) {
            ?>
<strong>Client: </strong><a href="../wp-admin/post.php?post=<?php echo $id; ?>&action=edit"><?php echo the_title(); ?></a><br />
    
    <table width="100%" style="margin-bottom: 10px;">
        <tr width="100%">
            <th width="40%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Task</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Status</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Due Date</th>
        </tr>
            
            <?php
            echo build_task_table($wcd_tasks);            
            ?>
    </table>
        
   <?php
        } 
    }else 
    if (!empty ($wcd_tasks[1]['wcd_contact_task_name']) ) {
        if ( $wcd_tasks[1]['wcd_contact_task_status'] != 'task_completed' ) {
    ?> 
    <strong>Client: </strong><a href="../wp-admin/post.php?post=<?php echo $id; ?>&action=edit"><?php echo the_title(); ?></a><br />
    
    <table width="100%" style="margin-bottom: 10px;">
        <tr width="100%">
            <th width="40%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Task</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Status</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Due Date</th>
        </tr>
            
            <?php
            echo build_task_table($wcd_tasks);            
            ?>
    </table>
        
   <?php
    }
    }
    endwhile;
    
}

function wcd_dashboard_quote_widget_function() {
    ?>
        
        <table width="100%" style="margin-bottom: 10px;">
        <tr width="100%">
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Quote #</th>
            <th width="40%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Customer</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Date</th>
            <th width="20%" align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Amount</th>
        </tr>
    
    <?php
    
    $args = array( 'post_type' => 'wcd-quote', 'post_status' => 'publish' );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    
    $quote_status = rwmb_meta( 'wcd_quote_status', 'type=text' );
    $quote_customer = rwmb_meta( 'wcd_quote_name', 'type=post' );
    $quote_products = rwmb_meta( 'quote-products', 'type=group' );
    $settings = get_option( 'wcd_crm_settings' );
    $yourcurrency = $settings['quote_currency'];
    if ($quote_status != 'won') {
        if ($quote_status != 'lost') {
    ?>
        
        <tr>
            <td><a href="../wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit"><?php echo get_the_ID(); ?></a></td>
            <td><a href="../wp-admin/post.php?post=<?php echo $quote_customer; ?>&action=edit"><?php echo get_the_title( $quote_customer ); ?></a></td>
            <td><?php echo the_date( 'M j, Y' ); ?></td>            
            <td align="right"><?php echo $yourcurrency . '&nbsp;' . get_quote_price_total($quote_products); ?></td>
        </tr>

            <?php 
        }
    }
    endwhile; ?>
            
    </table>
        
   <?php
    
}


function wcd_dashboard_contact_widget_function() {
    ?>
    <table width="100%" style="margin-bottom: 10px;">
            <tr width="100%">
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Client</th>
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Relationship</th>
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Reviewed Date</th>
            </tr>
    <?php
    $args = array( 'post_type' => 'wcd-contact', 'posts_per_page' => 10, 'orderby' => 'modified', 'order' => 'asc' );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    
    $relationship = rwmb_meta( 'wcd_contact_relationship', 'type=text' );
    
    if ( $relationship != 'model' ) {
        if ( $relationship != 'assitant' ) {
            if ( $relationship != 'supplier' ) {
        
    ?>
            <tr>
                <td><a href="../wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit"><?php echo the_title(); ?></a></td>
                <td><?php echo $relationship; ?></td>
                <td align="right"><?php echo the_modified_date( 'M j, Y' ); ?></td>
            </tr>
    
    <?php
            }
        }
    }
    endwhile;
    ?> </table> <?php
}

function wcd_dashboard_project_widget_function() {
    ?>
    <table width="100%" style="margin-bottom: 10px;">
            <tr width="100%">
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Project</th>
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Client</th>
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Status</th>
                <th align="left" style="background-color: #ccc; color: #fff; padding: 5px;">Date</th>
            </tr>
    <?php
    $args = array( 'post_type' => 'wcd-project', 'orderby' => 'date', 'order' => 'asc' );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    
        $client = rwmb_meta( 'wcd_client', 'type=text' );
        $status = rwmb_meta( 'wcd_status', 'type=text' );
        //var_dump($status);
        
    if ($status != 'won') {
        if ($status != 'lost') {
            if ($status != 'completed') {
        
    ?>
            <tr>
                <td><a href="../wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit"><?php echo the_title(); ?></a></td>
                <td><a href="../wp-admin/post.php?post=<?php echo $client[wcd_name]; ?>&action=edit"><?php echo get_the_title($client[wcd_name]); ?></a></td>
                <td><?php echo $status; ?></td>
                <td align="right"><?php echo the_date( 'M j, Y' ); ?></td>
            </tr>
    
    <?php
            }
        }
    }
    endwhile;
    
    ?> </table> <?php
    
}

function build_task_table($wcd_tasks){
    // data rows
    foreach( $wcd_tasks as $key=>$value){
        if ( $value['wcd_contact_task_status'] != 'task_completed' ) {
        $html .= '<tr class="item-row">';

            $html .= '<td>' . $value['wcd_contact_task_name'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_status'] . '</td>';
            $html .= '<td>' . $value['wcd_contact_task_due'] . '</td>';

        $html .= '</tr>';
        
        }
    }

    return $html;
}

function get_quote_price_total($quote_products){

    $quotetotal=0;
    foreach( $quote_products as $key=>$value){
        $quotetotal+=$value['wcd_quote_qty'] * $value['wcd_quote_price'];
    }
    return $quotetotal;

}


function fix_contact_css() {
    wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . '/css/contact.admin.css' );
    wp_enqueue_style( 'custom_wp_admin_css' );
    
}
add_action('admin_enqueue_scripts', 'fix_contact_css');


if ( !$enable ) :

    function general_admin_notice(){
        echo '<div class="notice notice-warning is-dismissible">
                 <p><strong>CRM:</strong> to use this plugin, please configure your settings. <a href="' . get_admin_url() . 'admin.php?page=wcd_crm-settings">Set them here.</a></p>
             </div>';
    }
    add_action('admin_notices', 'general_admin_notice');

endif;

function display_contact_form() {

	$validation_messages = [];
	$success_message = '';

	if ( isset( $_POST['contact_form'] ) ) {

		//Sanitize the data
		$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
		$email     = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

		//Validate the data
		if ( strlen( $full_name ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid name.', 'wcd' );
		}

		if ( strlen( $email ) === 0 or
		     ! is_email( $email ) ) {
			$validation_messages[] = esc_html__( 'Please enter a valid email address.', 'wcd' );
		}

		if ( strlen( $message ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid message.', 'wcd' );
		}

		//Send an email to the WordPress administrator if there are no validation errors
		if ( empty( $validation_messages ) ) {

			$mail    = 'accounts@westcoastdigital.com.au';
			$subject = 'New message from ' . $full_name;
			$message = $message . ' - The email address of the customer is: ' . $mail;

			wp_mail( $mail, $subject, $message );

			$success_message = esc_html__( 'Your message has been successfully sent.', 'wcd' );

		}

	}

	//Display the validation errors
	if ( ! empty( $validation_messages ) ) {
		foreach ( $validation_messages as $validation_message ) {
			echo '<div class="validation-message">' . esc_html( $validation_message ) . '</div>';
		}
	}

	//Display the success message
	if ( strlen( $success_message ) > 0 ) {
		echo '<div class="success-message">' . esc_html( $success_message ) . '</div>';
	}

	?>

    <!-- Echo a container used that will be used for the JavaScript validation -->
    <div id="validation-messages-container"></div>

    <form id="contact-form" action="<?php echo esc_url( get_permalink() ); ?>"
          method="post">

        <input type="hidden" name="contact_form">

        <div class="form-section">
            <label for="full-name"><?php echo esc_html( 'Full Name', 'wcd' ); ?></label>
            <input type="text" id="full-name" name="full_name">
        </div>

        <div class="form-section">
            <label for="email"><?php echo esc_html( 'Email', 'wcd' ); ?></label>
            <input type="text" id="email" name="email">
        </div>

        <div class="form-section">
            <label for="message"><?php echo esc_html( 'Message', 'wcd' ); ?></label>
            <textarea id="message" name="message" rows="5"></textarea>
        </div>

        <input class="rwmb-button button-primary" type="submit" id="contact-form-submit" value="<?php echo esc_attr( 'Submit', 'wcd' ); ?>">

    </form>

	<?php

}