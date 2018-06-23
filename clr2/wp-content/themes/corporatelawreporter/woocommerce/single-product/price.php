<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<p class="price" style="float:left;padding:0 5px;"><?php echo $product->get_price_html(); ?></p>
	<?php 
   global $product;
   	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	?>
	<form enctype="multipart/form-data" method="post" class="cart">
	 	<?php if ( $product->is_in_stock() ) : ?>
	 	<div class="quantity"><input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1"></div>
	 	<input type="hidden" value="<?php echo get_the_ID(); ?>" name="add-to-cart">

	 	<button class="single_add_to_cart_button button alt" type="submit">Buy Book</button>
	 <?php endif; ?>
   <?php 
 	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
   ?>
   </form>


		 
	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
<!-- add to cart link -->

</div>

