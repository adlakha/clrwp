<?php 
/*
 * Functionality : Generate excel file of the order i.e group of order.
 * Excel : http://www.sitepoint.com/generate-excel-files-charts-phpexcel/
 */
 
  //$order = new WC_Order( 31156 );
  //$items = $order->get_items();
  //echo '<pre>';print_r($items);echo '</pre>';
 
 add_action('admin_menu', 'register_excelgeneration_submenu_page');

function register_excelgeneration_submenu_page() {
	add_submenu_page( 'woocommerce', 'Generate Excel', 'Generate Excel', 'manage_options', 'woo-orderRecord-inexcel', 'excelgeneration__submenu_page_wooorder_callback' );
}

function excelgeneration__submenu_page_wooorder_callback() {
	
	global $wpdb;
	@session_start();
	
	include 'memberExcel-processing.php';
	

}
 ?>