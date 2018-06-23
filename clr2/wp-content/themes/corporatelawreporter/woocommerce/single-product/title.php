<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<h1 itemprop="name" class="product_title entry-title post-title title-small-ca2013">
                    	<a  style="color:#fc8b01;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h1>
<?php 
	/*
		 *Check event have expired or not.
		 * Specially for event category 
		 */
//      $post_termid  = get_termid_from_postid(get_the_ID());
//	  $event_termid = clr_of_get_option("event_category");
      // echo eminds_is_event_expire(get_the_ID());
      echo clr_event_expire_key(get_the_ID());
?>