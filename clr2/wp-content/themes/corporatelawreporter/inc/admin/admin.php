<?php
/*
 *Admin functionality of this theme. 
 */
 
 /*
  *File attached tinyMCE functionality 
  * All the shortcode are added in wordpress editor
  * Shortcode here: 
  */
 require_once dirname( __FILE__ ) . '/tinyMCE/tinyMCE.php';
  /*
  * File describe the custom Newsletter functionality 
  */
 require_once dirname( __FILE__ ) . '/newsletter/newsletter.php';

/*
 *Download the member record in excel file : Woocommerce event module. 
 */ 
 require_once dirname( __FILE__ ) . '/member_Excel-download/memberExcel.php';
/*
 *For Custom Csv Bulk uploading coupons. -- 27 september
 */ 
 require_once dirname( __FILE__ ) . '/couponEminds/couponeminds.php';