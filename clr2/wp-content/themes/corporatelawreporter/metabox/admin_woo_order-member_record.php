<?php
/*
 *This file have the member record of every media partner 
 * Woocommerce -> orders -> Every order of the media partner event . 
 */
 
 /*
  * Metabox for member record :Woocommerce -> orders  
  */
function woocommerce_member_record_add_meta_box() {

	$screens = array('shop_order' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'woocommerce_member_record11',
			__( 'Subscriber Member Record', 'clr' ),
			'woocommerce_member_record_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'woocommerce_member_record_add_meta_box' );

/**
 * Prints the box content.
 * 
 * Metabox for member record :Woocommerce -> orders
 */
function woocommerce_member_record_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'memberrecord_save_meta_box_data', 'memberrecord_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	 $orderid = $post->ID;
	 $order = new WC_Order( $orderid );
     $items = $order->get_items();
	?>
	 <div class="wc-order-data-row wc-order-totals-items wc-order-items-editable" style="background:#f8f8f8;">
	<?php 
	 /*
	  *We will check the product id and display the subscriber member record. 
	  */	 
	  if($items){
	
	  	foreach($items as $itm){
	  	
		 $productid = $itm['product_id'];
	     $qty       = $itm['qty'];
		
		/*
		 * Check this product id belong to the event module or not. 
		 */ 
		 $post_termid  = get_termid_from_postid($product_id);
	     $event_termid = clr_of_get_option("event_category");
		 if($post_termid == $event_termid){
		 
		 /*
		  * get order item id . 
		  */
		 global $wpdb;
		 $sql_orderitem = "SELECT * FROM  `".$wpdb->prefix."woocommerce_order_items` WHERE `order_id`='$orderid' ";
		 $arr_orderitem = $wpdb->get_row($sql_orderitem);
		 
		 //print_r($arr_orderitem);
		 ?>
		   <table class="wc-order-totals">
		   	 <caption><center>Subscriber member record for : <?php echo get_the_title($productid); ?></center></caption>
		   			<tr>
						<th class="label">Member Name</th>
						<th class="total">Designation</th>
						<th width="1%">Phone</th>
					</tr>

				<tbody>
		<?php	
		 /*
		  *Check this product id belong to the event module or not. 
		  */
		for($i=1;$i<=$qty;$i++){  	
			  	
		     $memberkey     = 'member_name_'.$productid."_".$i;
			 $designationkey= 'designation_'.$productid."_".$i;
			 $phonekey      = 'phone_'.$productid."_".$i;
			 
			 $member        = get_post_meta($orderid,$memberkey,TRUE);
			 $designation   = get_post_meta($orderid,$designationkey,TRUE);
			 $phone         = get_post_meta($orderid,$phonekey,TRUE);
			 ?>
    		<tr>
		    	<td class="label"><?php echo $member; ?></td>
			    <td class="total"><?php echo $designation; ?></td>
			    <td width="1%"><?php echo $phone; ?></td>
	    	</tr>
			 <?php
			 
			 
		}//inner for loop   
	  	 	?>
			 	</tbody>
		</table>
			 <?php
			 }//condition to check the : product id belong to event module or not.
	 	} //foreach loop
		
	 }//if conditions.
	  
    ?>

	
	<div class="clear"></div>
</div>
    
    <?php


}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function member_record_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['memberrecord_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['memberrecord_meta_box_nonce'], 'memberrecord_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['myplugin_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
//	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// Update the meta field in the database.
//	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'member_record_save_meta_box_data' );
 ?>