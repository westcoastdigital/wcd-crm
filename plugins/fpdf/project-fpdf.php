<?php

define('WP_USE_THEMES', false); 
require_once("../../../../../wp-load.php");
?>

<head>
<?php do_action('wp_head'); ?>
</head>
<body class="printview">
<?php

$ID = (int)$_GET["ID"];
$args = array( 'post_type' => 'wcd-project', 'posts_per_page' => 1, 'p' => $ID, );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
?>

<div id="project-print" class="project-print" style="width: 800px; margin: 0 auto; background-color: #fff; padding: 10px;">

<div style="width:100%; text-align: center; text-transform: uppercase; letter-spacing: 1px; font-weight: 900; margin-top: 10px; line-height: 100px" >Project Tracking</div>

<div id="identity">
    <?php
        $yourcompany = quote_company_info();
        $yourname = quote_name_info();
        $youremail = quote_email_info();
        $yourphone = quote_phone_info();
        $youraddress = quote_address_info();
        $yourlogo = quote_logo_info();
    ?>
    
        <div id="logo" style="margin-top: 0; position: relative; top: -100px;">
                <?php
             echo "<img id='image' src='$yourlogo' alt='$yourcompany' />";
                 ?>
            </div>
            
            <div class="clear"></div>
            
        <div id="address" style="float: left;">
            Company: <?php echo $yourcompany; ?> <br />
            Sales Rep: <?php echo $yourname; ?> <br />
            Address: <?php echo $youraddress; ?> <br />
            Email: <?php echo $youremail; ?><br />
            Phone: <?php echo $yourphone; ?>
        </div>
            
            <?php
            $customer = rwmb_meta( 'wcd_client', 'type=text' );
            $custcompany = $customer[wcd_company];
            $custname = $customer['wcd_name'];
            $custaddress = $customer[wcd_address];
            $custemail = $customer[wcd_email];
            $custphone = $customer[wcd_phone];
            $yourcurrency = quote_currency_info();
            ?>
            
        <div id="cust-address" style="float: right;">
            Company: <?php echo $custcompany; ?> <br />
            Address: <?php echo $custaddress; ?> <br />
            Email: <?php echo $custemail; ?><br />
            Phone: <?php echo $custphone; ?>
        </div>    
        
            <div class="clear"></div>
    
		    <div style="font-weight: 900;">Tasks</div>
    
		    <table id="items" style="margin-top: 0;">
		    <thead>
    		  <tr>
    		      <th>Description</th>
    		      <th>Type</th>
    		      <th>Due Date</th>
    		      <th>Status</th>
    		      <th>Completed Date</th>
    		  </tr>
		    </thead>
		
		<?php
            
            $tasks = rwmb_meta( 'wcd_contact_tasks', 'type=group' );
            echo build_new_table($tasks);
            //var_dump($tasks);
        ?>
		</table>
		    
        <div style="font-weight: 900; margin-top: 20px;">Expenses</div>
    
		    <table id="items" style="margin-top: 0;">
		    <thead>
    		  <tr>
    		      <th>Description</th>
    		      <th>Qty/Hrs</th>
    		      <th>Cost</th>
    		      <th>Tax</th>
    		      <th>Total</th>
    		  </tr>
		    </thead>
		
		<?php
            
            $expenses = rwmb_meta( 'wcd_expenses', 'type=group' );
            echo build_exp_table($expenses);

        ?>   
          
        <tr style="height: 50px;">
        <td style="border: none;"></td>
        <td style="border: none;"></td>
        <td style="border: none;"></td>
        <td style="border: none; font-weight: 700; line-height: 50px;">Totals</td>
        <td style="border: none; font-weight: 700; line-height: 50px;">
        <?php echo $yourcurrency . '&nbsp;' . get_expense_total($expenses); ?>
        </td>
        
        </tr>
                
		</table>

		    
		</div>


<?php endwhile; ?>	

    <div class="button">
        <input type="button" class="QuotePrintBtn" value="Print" onClick="window.print()">
    </div>
    
</div> 
</body>