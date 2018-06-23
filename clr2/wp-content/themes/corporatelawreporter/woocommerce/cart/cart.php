<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 *Create the session 
 */
@session_start();

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		//echo '<pre>';print_r(WC()->cart->get_cart());echo '<pre>';
				
		//$cartitemarr = WC()->cart->get_cart();		
				
				
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">


        <?php 
      //  print_r($_SESSION);
        /*
		 *Special feature :
		 * If product belong from : event module : then add feature for member record.
	     */
	     
	     $totalqty     = $cart_item['quantity'];
	     
	     $post_termid  = get_termid_from_postid($product_id);
	     $event_termid = clr_of_get_option("event_category");
		 
		 /*
		  *Check it is the event term id or post termid . 
		  */
		 $is_event_cat = 0;
		 
		 if($event_termid == $post_termid){
		    $is_event_cat = 1;	
		 }
      /*
	   * In one qty : 1 : We need the two row + 1 main row .
	   * So if qty  : 3 : then 3* 2 + 1 (main row) 
	   */
        $rowqty = $totalqty * 3 +1;
       $rowspan = ($is_event_cat)? "rowspan='".$rowqty."'":0;
		  
		     ?>
		     
					<td class="product-remove"  <?php echo $rowspan; ?> >
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>

					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
							}
						?>
					</td>

					<td class="product-name">
						<?php
							if ( ! $_product->is_visible() ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>

					<td class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			
	//********************** : Member record ********************		
		if($event_termid == $post_termid){
		
		//call the member HTML 
		//clr_event_member_records($product_id,$totalqty);
		
		//**************** member record *****
    	/*
		 *List all the members address here. 
		 */
		 if($totalqty){
		 	?>
		<!-- <tr class="member-<?php echo $product_id; ?>">
             		<th colspan="2" class="name">Deligate Name </th>
             		<th colspan="2" class="name">Designation</th>
             		<th class="name">Deligate Phone</th>
           </tr> -->
		 	<?php
			for($i=1;$i<=$totalqty;$i++){
				
		 //update the value into the session and update here.
		     $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
			
			  //other two extra field
			  //other two fields
			 $organisation  = 'organization_'.$product_id."_".$i;
			 $member_email  = 'member_email_'.$product_id."_".$i;
			    		
			$_SESSION[$memberkey]      = @empty($_POST[$memberkey]) ? $_SESSION[$memberkey]  :  $_POST[$memberkey];
			$_SESSION[$designationkey] = empty($_POST[$designationkey]) ? $_SESSION[$designationkey] : $_POST[$designationkey];
			$_SESSION[$phonekey]       = empty($_POST[$phonekey])  ? $_SESSION[$phonekey]   :  $_POST[$phonekey];	
			
			$_SESSION[$organisation]   = empty($_POST[$organisation]) ? $_SESSION[$organisation]  :  $_POST[$organisation];
			$_SESSION[$member_email]   = empty($_POST[$member_email]) ? $_SESSION[$member_email]  :  $_POST[$member_email];	
             	?>
            <tr class="member-<?php echo $product_id; ?>">
             	<td colspan="2" class="member_name"><input placeholder="Deligate Name" class="input-text form-control <?php echo $memberkey; ?> " type="text" name="<?php echo $memberkey; ?>" value="<?php echo $_SESSION[$memberkey]; ?>" /> </td>
             		<td colspan="2" class="organisation"><input placeholder="Organization" class="input-text form-control <?php echo $organisation; ?> " type="text" name="<?php echo $organisation; ?>" value="<?php echo $_SESSION[$organisation]; ?>" /> </td>
             		<td class="member-phone"><input placeholder="Phone" type="text" class="input-text form-control <?php echo $phonekey; ?> " name="<?php echo $phonekey; ?>" value="<?php echo $_SESSION[$phonekey]; ?>" /></td>
              </tr>
              <tr class="border-none member-<?php echo $product_id; ?>">
              		<td colspan="2" class="border-none designation"><input placeholder="Designation" class="input-text form-control <?php echo $designationkey; ?> " type="text" name="<?php echo $designationkey; ?>" value="<?php echo $_SESSION[$designationkey]; ?>" /></td>	
             		<td colspan="3" class="border-none member-email"><input placeholder="Email" class="input-text form-control <?php echo $member_email; ?> " type="text" name="<?php echo $member_email; ?>" value="<?php echo $_SESSION[$member_email]; ?>" /> </td>
              	</tr>
               <tr><td colspan="3" style="padding:0px;border:none;">&nbsp;</td></tr>		
             	<?php	
             	}
		 }
	//**************** member record *****
			
		 }//term id	
	//********************** : Member record ********************			
				
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>