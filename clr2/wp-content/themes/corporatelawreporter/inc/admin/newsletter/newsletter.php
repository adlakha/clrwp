<?php 
/*
 *Functionality for describing the custom newsletter.
 * Design Ref: http://johnny.github.io/jquery-sortable/
 * Ref: http://altafphp.blogspot.in/2013/12/move-list-box-items-from-one-box-to.html 
 */
 
 /*
  *Add dragable script in admin section. 
  */
  function eminds_newsletter_admin_scripts() {
        wp_register_style( 'newsletter.css', get_template_directory_uri() . '/inc/admin/newsletter/newsletter.css', false, '1.0.0' );
        wp_enqueue_style( 'newsletter.css' );
	
 }
  
  
add_action( 'admin_enqueue_scripts', 'eminds_newsletter_admin_scripts' );
 add_action( 'admin_menu', 'eminds_custom_newsletter' );

function eminds_custom_newsletter() {

	add_menu_page( 'Eminds Newsletter', 'Eminds Newsletter', 'manage_options', 'emindsNewsletter', 'eminds_newsletter', "", 6 );

}

/*
 * Describe  the custom newsletter  
 */
 function eminds_newsletter(){
 	?>
 	<div class="container-drap-drop">
<?php
 	echo '<h2>Welcome to newsletter.</h2>';
   //call the step -1
   if(isset($_REQUEST['action'])){
   	
	if($_REQUEST['action']=="step-2"){
          	include 'newsletter-step-2.php';
	}else if($_REQUEST['action']=="preview"){
          	include 'newsletter-preview.php';
	}else{
    include 'newsletter-step-1.php';		
	}
   	
   }else{
   	include 'newsletter-step-1.php';
   }


 }
 
 //****************************************************** Submenu
 /*
  * Add submenu page
  */
add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	add_submenu_page( 'emindsNewsletter', 'Setting', 'Setting', 'manage_options', 'newsletter_settings', 'newsletter_settings_callback' );
}

function newsletter_settings_callback() {
	//call the newsletter setting page
	   	include dirname( __FILE__ ) .'/newsletter-setting-new.php';
}
  ?>