<?php

/**
 * Register a custom menu page -- for EMinds Scratch Code 26th october
 **/

function eminds_custom_coupon(){
  add_menu_page('Theme page title ', 'Eminds Coupon', 'manage_options', 'theme-options', 'eminds_custom_theme_func');
  add_submenu_page( 'theme-options', 'Settings page title', 'Scratchcard Used View', 'manage_options', 'theme-op-settings', 'eminds_copoun_custom_settings');
  add_submenu_page( 'theme-options', 'bulk expiry change', 'Bulk Expiry Change', 'manage_options', 'theme-op-bulkexpiry', 'eminds_bulk_expiry_change');
  // add_submenu_page( 'theme-options', 'FAQ page title', 'Work in Progress', 'manage_options', 'theme-op-faq', 'eminds_custom_coupon_faq');
  // add_submenu_page( 'theme-options', 'FAQ ', 'Bulk Delete', 'manage_options', 'test', 'eminds_custom_coupon_test');
}
add_action('admin_menu', 'eminds_custom_coupon');
function eminds_custom_theme_func(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>To Upload Coupon in CSV Format</h2></div>';
                  include( get_template_directory() . '/inc/admin/couponEminds/couponeminds-admin.php');
}
function eminds_copoun_custom_settings(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2></h2></div>';

                //echo get_template_directory() . '/inc/admin/couponEminds/couponeminds-admin.php';
               include( get_template_directory() . '/inc/admin/couponEminds/couponeminds-submenuitem1.php');
                  //call the newsletter setting page
      //include'newsletter-setting-new.php';   
}
function eminds_bulk_expiry_change(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>To change expiry date in bulk</h2></div>';

                //echo get_template_directory() . '/inc/admin/couponEminds/couponeminds-admin.php';
               include( get_template_directory() . '/inc/admin/couponEminds/couponeminds-bulkexpirychange.php');
                  //call the newsletter setting page
      //include'newsletter-setting-new.php';   
}
// function eminds_custom_coupon_faq(){
//                  echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
//                 <h2>To Upload Individual Scratch Card</h2></div>';
//                    include( get_template_directory() . '/inc/admin/couponEminds/couponeminds-submenuitem2.php');
//   }  function eminds_custom_coupon_test(){
//                 echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
//                 <h2>test</h2></div>';
//                   include( get_template_directory() . '/inc/admin/couponEminds/coupon-test.php');
//  }


