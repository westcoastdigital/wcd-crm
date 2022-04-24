<?php
//Prevent loading this file directly
defined('ABSPATH') || exit;

// echo '<pre>';
// print_r(get_post_meta(237, 'wcd_contact_contact_tasks', true));
// exit;
class WCD_Meta_Box
{
    public static function run()
    {
        if (is_admin())
        {
            add_filter('rwmb_meta_boxes', array(
                'WCD_Meta_Box',
                'register'
            ));
            add_action('admin_footer', array(
                'WCD_Meta_Box',
                'ajax'
            ));

            add_action('wp_ajax_get_customer_info', array(
                'WCD_Meta_Box',
                'get_customer_info'
            ));
            add_action('wp_ajax_get_product_info', array(
                'WCD_Meta_Box',
                'get_product_info'
            ));

            add_action('rwmb_wcd_project_info_after_save_post', array(
                'WCD_Meta_Box',
                'save_tasks'
            ));
            add_action('rwmb_wcd_project_info_before_save_post', array(
                'WCD_Meta_Box',
                'before_save_tasks'
            ));
        }
    }

    public static function before_save_tasks()
    {
        if (!empty($_POST['wcd_contact_tasks']))
        {
            foreach ($_POST['wcd_contact_tasks'] as $index => $task)
            {
                if (empty($task['wcd_contact_task_id'])) $_POST['wcd_contact_tasks'][$index]['wcd_contact_task_id'] = uniqid();
            }
        }
    }

    public static function register($meta_boxes)
    {
        $prefix = 'wcd_';

        // project content tabs
        $meta_boxes[] = array(
            'id' => $prefix . 'project_info',
            'title' => 'Project Info',
            'pages' => 'wcd-project',
            'tabs' => array(
                'contacts' => array(
                    'label' => 'Customer Info',
                    'icon' => 'dashicons-businessman',
                ) ,

                'tasks' => array(
                    'label' => 'Tasks',
                    'icon' => 'dashicons-clipboard',
                ) ,

                'documents' => array(
                    'label' => 'Documents',
                    'icon' => 'dashicons-portfolio',
                ) ,

                'images' => array(
                    'label' => 'Images',
                    'icon' => 'dashicons-format-image',
                ) ,

                'key' => array(
                    'label' => 'Key Contacts',
                    'icon' => 'dashicons-networking',
                ) ,

                'expenses' => array(
                    'label' => 'Expenses',
                    'icon' => 'dashicons-editor-ol',
                ) ,
            ) , // end tabs
            'tab_style' => 'default',

            'fields' => array(

                // Client Info
                array(
                    'name' => 'Client Info',
                    'id' => $prefix . 'client',
                    'type' => 'group',
                    'tab' => 'contacts',

                    'fields' => array(

                        array(
                            'name' => 'Name',
                            'id' => $prefix . 'name',
                            'type' => 'post',
                            'placeholder' => 'Select a Customer',
                            'post_type' => 'wcd-contact',
                            'columns' => 12
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
                            'name' => 'Address',
                            'id' => $prefix . 'address',
                            'type' => 'text',
                            'columns' => 6,
                            'hidden' => array(
                                $prefix . 'name',
                                ''
                            )
                        ) ,

                        array(
                            'name' => 'Company',
                            'id' => $prefix . 'company',
                            'type' => 'text',
                            'columns' => 6,
                            'hidden' => array(
                                $prefix . 'name',
                                ''
                            )
                        ) ,

                    ) , // end customer fields
                    
                ) , //end customer
                

                // project tasks meta box
                array(
                    'name' => 'Tasks',
                    'id' => $prefix . 'contact_tasks',
                    'type' => 'group',
                    'clone' => true,
                    'tab' => 'tasks',
                    'fields' => array(
                        array(
                            'id' => $prefix . 'contact_task_id',
                            'type' => 'hidden',
                            'value' => 'hidden'
                        ) ,
                        array(
                            'name' => 'Task Name',
                            'id' => $prefix . 'contact_task_name',
                            'type' => 'text',
                        ) ,
                        array(
                            'name' => 'Task Description',
                            'id' => $prefix . 'contact_task_description',
                            'type' => 'textarea',
                        ) ,
                        array(
                            'name' => 'Task Style',
                            'id' => $prefix . 'contact_task_style',
                            'type' => 'select',
                            'options' => wcd_task_get_style_options() ,
                            'placeholder' => 'Select a style',
                        ) ,
                        array(
                            'name' => 'Due Date',
                            'id' => $prefix . 'contact_task_due',
                            'type' => 'datetime',
                        ) ,
                        array(
                            'name' => 'Status',
                            'id' => $prefix . 'contact_task_status',
                            'type' => 'select',
                            'options' => wcd_task_get_status_options() ,
                            'placeholder' => 'Select a status',
                        ) ,
                        array(
                            'name' => 'Date Complete',
                            'id' => $prefix . 'contact_task_date_completed',
                            'type' => 'datetime',
                        ) ,
                    ) , // end task fields
                    
                ) , // end tasks
                // Document Uploads
                array(
                    'name' => 'Documents',
                    'desc' => 'Please select files to upload',
                    'id' => $prefix . 'files',
                    'type' => 'file_advanced',
                    'tab' => 'documents',
                ) , // end documents
                // Private document Uploads
                array(
                    'name' => 'Private Documents',
                    'desc' => 'Please select files to upload',
                    'id' => $prefix . 'pvt_files',
                    'type' => 'file_advanced',
                    'tab' => 'documents',
                ) , // end documents
                // image uploads
                array(
                    'name' => 'Images',
                    'desc' => 'Upload the finished images',
                    'id' => $prefix . 'images',
                    'type' => 'image_advanced',
                    'tab' => 'images',
                ) , // end images
                // Key contacts
                array(
                    'name' => 'Key Contact',
                    'id' => $prefix . 'key_contact',
                    'type' => 'group',
                    'clone' => true,
                    'tab' => 'key',
                    'fields' => array(

                        array(
                            'name' => 'Name',
                            'id' => $prefix . 'key_name',
                            'type' => 'post',
                            'post_type' => 'wcd-contact',
                            'placeholder' => 'Select a Customer',
                        ) ,
                        array(
                            'name' => 'Company',
                            'id' => $prefix . 'key_company',
                            'type' => 'text',
                            'hidden' => array(
                                $prefix . 'key_name',
                                ''
                            )
                        ) ,
                        array(
                            'name' => 'Phone',
                            'id' => $prefix . 'key_phone',
                            'type' => 'text',
                            'hidden' => array(
                                $prefix . 'key_name',
                                ''
                            )
                        ) ,
                        array(
                            'name' => 'Email',
                            'id' => $prefix . 'key_email',
                            'type' => 'text',
                            'hidden' => array(
                                $prefix . 'key_name',
                                ''
                            )
                        ) ,
                        array(
                            'name' => 'Project Role',
                            'id' => $prefix . 'key_role',
                            'type' => 'select',
                            'options' => array(
                                'model' => 'Model',
                                'caterer' => 'Caterer',
                                'car' => 'Car Hire',
                                'hire' => 'Gear Hirer',
                                'venue' => 'Venue',
                                'printer' => 'Printer',
                                'airline' => 'Airline',
                                'other' => 'Other',
                            ) ,
                            'placeholder' => 'Select a role',
                            'hidden' => array(
                                $prefix . 'key_name',
                                ''
                            )
                        ) ,
                    ) , // end key contact fields
                    
                ) , // end key contacts
                // project expenses meta box
                array(
                    'id' => $prefix . 'expenses',
                    'type' => 'group',
                    'clone' => true,
                    'tab' => 'expenses',

                    'fields' => array(
                        array(
                            'name' => 'Product',
                            'id' => $prefix . 'exp_product',
                            'type' => 'post',
                            'post_type' => 'wcd-product',
                            'placeholder' => 'Select a Product',
                            'columns' => 6
                        ) ,
                        array(
                            'name' => 'Description',
                            'id' => $prefix . 'exp_description',
                            'type' => 'textarea',
                            'columns' => 6
                        ) ,

                        array(
                            'name' => 'Qty/Hrs',
                            'id' => $prefix . 'exp_qty',
                            'type' => 'number',
                            'std' => 1,
                            'min' => 0,
                            'step' => 1,
                            'columns' => 3
                        ) ,
                        //                        array(
                        //                            'name'  => 'Price',
                        //                            'id'    => $prefix . 'exp_price',
                        //                            'type'  => 'number',
                        //                            'min'	=> 0,
                        //                            'step'	=> 'any',
                        //                            'columns' => 3
                        //                        ),
                        array(
                            'name' => 'Cost',
                            'id' => $prefix . 'exp_cost',
                            'type' => 'number',
                            'min' => 0,
                            'step' => 'any',
                            'columns' => 3
                        ) ,
                        array(
                            'name' => 'Tax (%)',
                            'id' => $prefix . 'exp_tax',
                            'type' => 'number',
                            'std' => 0,
                            'min' => 0,
                            'step' => 'any',
                            'columns' => 3
                        ) ,
                        array(
                            'name' => 'Total',
                            'id' => $prefix . 'exp_total',
                            'type' => 'number',
                            'min' => 0,
                            'step' => 'any',
                            'columns' => 3
                        ) ,

                    ) , // end expenses fields
                    
                ) , // end expenses
                
            ) , // end main fields
            
        ); // end project content
        return $meta_boxes;
    }

    public static function ajax()
    {
?>
		<script type="text/javascript" >
		jQuery(document).ready(function($) {

			$( '#wcd_name' ).on( 'change', function()
			{
				var $this	 = $(this),
					$post_id = $this.val();

				$.get( ajaxurl, {
					'action' : 'get_customer_info',
					'customer_id' : $post_id
				}, function( response ) 
				{
					$( '#wcd_address' ).val( response.address );
					$( '#wcd_phone' ).val( response.phone );
					$( '#wcd_company' ).val( response.company );
					$( '#wcd_email' ).val( response.email );
				} );
			} );

			$( '#wcd_client_wcd_name' ).on( 'change', function()
			{
				var $this	 = $(this),
					$post_id = $this.val();

				$.get( ajaxurl, {
					'action' : 'get_customer_info',
					'customer_id' : $post_id
				}, function( response ) 
				{
					$( '#wcd_client_wcd_address' ).val( response.address );
					$( '#wcd_client_wcd_phone' ).val( response.phone );
					$( '#wcd_client_wcd_company' ).val( response.company );
					$( '#wcd_client_wcd_email' ).val( response.email );
				} );
			} );

			$( '#wcd_quote_name' ).on( 'change', function()
			{
				var $this	 = $(this),
					$post_id = $this.val();

				$.get( ajaxurl, {
					'action' : 'get_customer_info',
					'customer_id' : $post_id
				}, function( response ) 
				{
					$( '#wcd_quote_address' ).val( response.address );
					$( '#wcd_quote_phone' ).val( response.phone );
					$( '#wcd_quote_company' ).val( response.company );
					$( '#wcd_quote_email' ).val( response.email );
				} );
			} );

			$( '[name*="wcd_key_name"]' ).on( 'change', function()
			{
				var $this	 = $(this),
					$scope	 = $this.parents( '.rwmb-clone' ),
					$post_id = $this.val();

				$.get( ajaxurl, {
					'action' : 'get_customer_info',
					'customer_id' : $post_id
				}, function( response ) 
				{
					$scope.find( '[name*="wcd_key_address"]' ).val( response.address );
					$scope.find( '[name*="wcd_key_phone"]' ).val( response.phone );
					$scope.find( '[name*="wcd_key_company"]' ).val( response.company );
					$scope.find( '[name*="wcd_key_email"]' ).val( response.email );
				} );
			} );

			$( '[name*="wcd_quote_product"]' ).on( 'change', function()
			{
				var $this	 = $(this),
					$scope	 = $this.parents( '.rwmb-clone' ),
					$post_id = $this.val();
				
				$.get( ajaxurl, {
					'action' : 'get_product_info',
					'product_id' : $post_id
				}, function( response ) 
				{
					$scope.find( '[name*="wcd_quote_description"]' ).val( response.description );
					// $scope.find( '[name*="wcd_quote_qty"]' ).val( response.qty );
					$scope.find( '[name*="wcd_quote_price"]' ).val( response.price );
					$scope.find( '[name*="wcd_quote_cost"]' ).val( response.cost );
				} );
			} );

			$( '[name*="wcd_exp_product"]' ).on( 'change', function()
			{
				var $this	 = $(this),
					$scope	 = $this.parents( '.rwmb-clone' ),
					$post_id = $this.val();

				$.get( ajaxurl, {
					'action' : 'get_product_info',
					'product_id' : $post_id
				}, function( response ) 
				{
					$scope.find( '[name*="wcd_exp_description"]' ).val( response.description );
					// $scope.find( '[name*="wcd_exp_qty"]' ).val( response.qty );
					$scope.find( '[name*="wcd_exp_price"]' ).val( response.price );
					$scope.find( '[name*="wcd_exp_cost"]' ).val( response.cost );
				} );
			} );

			$( '[name*="wcd_expenses"]' ).on( 'change', function()
			{
				var $this	 = $(this),
					$scope	 = $this.parents( '.rwmb-clone' );

				var $qty 	 = parseFloat( $scope.find('[name*="wcd_exp_qty"]').val() ); 
				//var $price 	 = parseFloat( $scope.find('[name*="wcd_exp_price"]').val() ); 
				var $tax 	 = parseFloat( $scope.find('[name*="wcd_exp_tax"]').val() );
				var $cost 	 = parseFloat( $scope.find('[name*="wcd_exp_cost"]').val() );
				
				$scope.find('[name*="wcd_exp_total"]').val( ( $cost + $cost * $tax / 100 ) * $qty );
			} );
		} );
		</script> <?php
    }

    public static function get_product_info()
    {
        $product_id = intval($_GET['product_id']);

        $product = get_post($product_id);

        $fields = array();

        $fields['description'] = $product->post_content;
        $fields['price'] = get_post_meta($product_id, 'wcd_product_rrp', true);
        $fields['cost'] = get_post_meta($product_id, 'wcd_product_cost', true);

        wp_send_json($fields);
    }

    public static function get_customer_info()
    {
        $customer_id = intval($_GET['customer_id']);

        $fields = array(
            'phone',
            'email',
            'address',
            'company'
        );

        foreach ($fields as $index => $field)
        {
            unset($fields[$index]);

            $fields[$field] = get_post_meta($customer_id, 'wcd_contact_' . $field, true);
        }

        wp_send_json($fields);
    }

    public static function save_tasks($post_id)
    {
        $customer = get_post_meta($post_id, 'wcd_client', true);

        if (empty($customer['wcd_name'])) return;

        $customer_id = $customer['wcd_name'];

        $tasks = get_post_meta($post_id, 'wcd_contact_tasks', true);

        if (is_array($tasks))
        {
            $customer_tasks = get_post_meta($customer_id, 'wcd_contact_contact_tasks', true);

            if (empty($customer_tasks))
            {
                $customer_tasks = $tasks;
            }
            else if (is_array($customer_tasks))
            {
                foreach ($tasks as $task)
                {
                    $exists = false;

                    foreach ($customer_tasks as $index => $customer_task)
                    {
                        if ($task['wcd_contact_task_id'] === $customer_task['wcd_contact_task_id'])
                        {
                            $customer_tasks[$index] = $task;
                            $exists = true;
                            continue;
                        }
                    }

                    if (!$exists) $customer_tasks[] = $task;
                }
            }

            // Remove Duplicate Element
            // for ( $i = 0; $i < count( $customer_tasks); $i++ )
            // {
            // 	for ( $j = 1; $j <= count( $customer_tasks ); $j++ )
            // 	{
            // 		if ( $customer_tasks[$j]['wcd_contact_task_id'] == $customer_tasks[$i]['wcd_contact_task_id'] || $customer_tasks[$i]['wcd_contact_task_id'] == '' )
            // 			unset( $customer_tasks[$j]);
            // 	}
            // }
            // echo '<pre>';
            // print_r($customer_tasks);
            // exit;
            update_post_meta($customer_id, 'wcd_contact_contact_tasks', $customer_tasks);

            // echo '<pre>';
            // print_r( get_post_meta( $customer_id, 'wcd_contact_contact_tasks', true ) );
            // exit;
            
        }
    }
}

WCD_Meta_Box::run();

