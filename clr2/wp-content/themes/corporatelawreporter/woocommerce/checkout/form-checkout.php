<?php
/**
 *https://wisdmlabs.com/blog/add-custom-data-woocommerce-order/ 
 * 
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

@session_start();

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
?>

<?php
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
   <?php 
 
   /*
    * Specially for the Event category : For adding the record of the member
    */
    global $woocommerce;
  
  $product_id=0;
  $quantity  = 0;
  
  if(WC()->cart->get_cart()){
  	
  		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
  	 
	   $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$quantity    = $cart_item['quantity'];	
	   	
		//cart functionality here.
		$totalqty     = 0;
	     
	     $post_termid  = get_termid_from_postid($product_id);
	     $event_termid = clr_of_get_option("event_category");
	//********************** : Member record ********************		
		if($event_termid == $post_termid){
		
		//total quantity
		$totalqty     = $quantity;
		
		//call the member HTML 
		//clr_event_member_records($product_id,$totalqty);
		//echo '<pre>';print_r($_REQUEST);echo '</pre>';
		//**************** member record *****
    	/*
		 *List all the members address here. 
		 */
		 //echo '<pre>';print_R($_SESSION);echo '</pre>';
		 if($totalqty){
		 	?>
		<table class="member-details-table" style="width:100%;"> 	
			<caption><center>Member Description Here :<?php echo get_the_title($product_id); ?></center></caption>
		 <!-- <tr class="member-<?php echo $product_id; ?>">
             		<th  class="member_name">Deligate Name </th>
             		<th  class="organisation">Organization </th>
             		<th  class="designation">Designation</th>
         </tr>
         <tr>
         	<th class="member-phone">Deligate Phone</th>
            <th class="member-email">Deligate Email</th>
         </tr> -->	
         
		 	<?php
			for($i=1;$i<=$totalqty;$i++){
				
		 //update the value into the session and update here.
		     $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
			 //other two fields
			 $organisation  = 'organization_'.$product_id."_".$i;
			 $member_email  = 'member_email_'.$product_id."_".$i;
			 
			//initialize with previously entered value.     		
			$_SESSION[$memberkey]      = empty($_POST[$memberkey]) ? $_SESSION[$memberkey]  :  $_POST[$memberkey];
			$_SESSION[$designationkey] = empty($_POST[$designationkey]) ? $_SESSION[$designationkey] : $_POST[$designationkey];
			$_SESSION[$phonekey]       = empty($_POST[$phonekey])  ? $_SESSION[$phonekey]   :  $_POST[$phonekey];	
			//other two filed.	
			$_SESSION[$organisation]   = empty($_POST[$organisation]) ? $_SESSION[$organisation]  :  $_POST[$organisation];
			$_SESSION[$member_email]   = empty($_POST[$member_email]) ? $_SESSION[$member_email]  :  $_POST[$member_email];
             	?>
             	<tr class="member-<?php echo $product_id; ?>">
             		<td colspan="3" class="member_name"><input placeholder="Deligate Name" class="input-text form-control <?php echo $memberkey; ?> " type="text" name="<?php echo $memberkey; ?>" value="<?php echo $_SESSION[$memberkey]; ?>" /> </td>
             		<td colspan="3" class="organisation"><input placeholder="Organization" class="input-text form-control <?php echo $organisation; ?> " type="text" name="<?php echo $organisation; ?>" value="<?php echo $_SESSION[$organisation]; ?>" /> </td>
             		<td colspan="2" class="member-phone"><input placeholder="Phone" type="text" class="input-text form-control <?php echo $phonekey; ?> " name="<?php echo $phonekey; ?>" value="<?php echo $_SESSION[$phonekey]; ?>" /></td>
              </tr>
              <tr class="member-<?php echo $product_id; ?>">
              		<td colspan="3" class="designation"><input placeholder="Designation" class="input-text form-control <?php echo $designationkey; ?> " type="text" name="<?php echo $designationkey; ?>" value="<?php echo $_SESSION[$designationkey]; ?>" /></td>	
             		<td colspan="5" class="member-email"><input placeholder="Email" class="input-text form-control <?php echo $member_email; ?> " type="text" name="<?php echo $member_email; ?>" value="<?php echo $_SESSION[$member_email]; ?>" /> </td>
              	</tr>
              <tr><td colspan="8" style="padding:0px;"><hr/></td></tr>		
             	<?php	
             	}
            ?>
            </table>
            <?php 
            $cart_url = $woocommerce->cart->get_cart_url();
            ?>
            <a class="button alt ajax-update-member" href="javascript:void(0);" data-productid="<?php echo $product_id; ?>" data-qty="<?php echo $totalqty; ?>" >Update Member</a>
             
            <?php
		 }
	//**************** member record *****
			
		 }//term id	
	//********************** : Member record ********************
  }//foreach condition
		
  }//if condition 		
 
   ?>
		<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>