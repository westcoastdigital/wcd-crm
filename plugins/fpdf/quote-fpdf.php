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

?>
<div id="quote-print" class="quote-print">

		<div id="header">QUOTE</div>
		<?php
        $args = array( 'post_type' => 'wcd-quote', 'posts_per_page' => 1, 'p' => $ID, );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        ?>
		<div id="identity">
            <?php
            $settings = get_option( 'wcd_crm_settings' );
            $yourcompany = $settings['quote_company'];
            $yourname = $settings['quote_name'];
            $youremail = $settings['quote_email'];
            $yourphone = $settings['quote_phone'];
            $youraddress = $settings['quote_company'];
            $yourlogo = $settings['quote_logo'];
            $yourcurrency = $settings['quote_currency'];
            ?>
            <div id="address">
                <?php echo $yourcompany; ?> <br />
                <?php echo $yourname; ?> <br />
                <?php echo $youraddress; ?> <br />
                Email: <?php echo $youremail; ?><br />
                Phone: <?php echo $yourphone; ?>
            </div>
            
            <div id="logo">
                <?php
             echo "<img id='image' src='$yourlogo' alt='$yourcompany' />";
                 ?>
            </div>
		
		</div>
		
		<div style="clear:both"></div>
    
		<?php if($ID != 0) { ?>
    
		<div id="customer">
            <?php 
            $custcompany = rwmb_meta( 'wcd_quote_company', 'type=text' );
            $custname = rwmb_meta( 'wcd_quote_name', 'type=text' );
            $custaddress = rwmb_meta( 'wcd_quote_address', 'type=text' );
            $total = rwmb_meta( 'wcd_quote_total', 'type=text' );
            ?>
            <div id="customer-title">
                <?php echo $custcompany; ?> <br />
                <?php echo get_the_title( $custname ); ?> <br />
                <?php echo $custaddress; ?> <br />
            </div>

            <table id="meta">
                <tr>
                    <td class="meta-head">Quote #</td>
                    <td><?php the_ID(); ?></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><div id="date"><?php the_date( 'F j, Y' ); ?></div></td>
                </tr>
                <tr>
                    <td class="meta-head">Quote Total</td>
                    <td><div class="due"><?php 
                        $products = rwmb_meta( 'quote-products', 'type=group' );
                        echo $yourcurrency . '&nbsp;' . get_price_total($products); 
                    ?></div></td>
                </tr>

            </table>
		
		</div>
		    <table id="items">
		    <thead>
    		  <tr>
    		      <th>Product</th>
    		      <th>Description</th>
    		      <th>Qty</th>
    		      <th>Price</th>
    		      <th>Total</th>
    		  </tr>
		    </thead>
		
		<?php
            
            $products = rwmb_meta( 'quote-products', 'type=group' );
            echo build_table($products);
            
        ?>
		</table>
    <?php } ?>
		<div id="terms">
		  <h5>Notes</h5>
		  <?php
		   $notes = rwmb_meta( 'wcd_quote_notes', 'type=text' );
		   echo $notes;
		   ?>
		</div>
	<?php endwhile; ?>
    
    <div class="button">
        <input type="button" class="QuotePrintBtn" value="Print" onClick="window.print()">
    </div>
    
	</div>
</body>