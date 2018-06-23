<?php
// BUffer string,session etc 
ob_start();

add_filter( 'wp_image_editors', 'change_graphic_lib' );

function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
/*
 *Disable the xmlrpc service
*/
//add_filter('xmlrpc_enabled', '__return_false');
/*add_filter( ‘xmlrpc_methods’, function( $methods ) {
   unset( $methods[‘pingback.ping’] );
   return $methods;
} );
*/
// BUffer string End
 /*
 *Popup will appear then we need to close it at a session that's why we need to it.
 */
add_action("wp_ajax_enable_session_close_popup","enable_session_close_popup");
add_action("wp_ajax_nopriv_enable_session_close_popup","enable_session_close_popup");
function enable_session_close_popup(){
	ob_start();
	@session_start(); 
    $_SESSION['is_close']=1;
	//print_r($_SESSION);
	echo 1;
	die(0);
}


define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';

//****************** Adding the woocmmerce : eVENT MODULE file
require_once dirname( __FILE__ ) . '/inc/eminds_woo_event_module.php';

//****************** Adding the metabox for woocommerce
//require_once dirname( __FILE__ ) . '/metabox/admin_woo_order-member_record.php';


//************************************** Woocommerced
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
} 



/*
 *get termid from post id . 
 */
function get_termid_from_postid($postid){
	
	$term_list = wp_get_post_terms($postid, 'product_cat', array("fields" => "all"));
	$termid    = $term_list[0]->term_id; 
	return $termid;
	
}


/**
 * Change the "Add to Cart" text on the single product page
 *
 * @return string
 */

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
 
function woo_archive_custom_cart_button_text() {
     global $product;
	//print_r($product);
	$product_id = $product->id;
	
	$termid    = get_termid_from_postid($product_id); 
	
	$dbeventcat= clr_of_get_option("event_category");
	
	if($termid == $dbeventcat){
		return __( 'Subscribe To The Event', 'woocommerce' );
	}else{
	return __( 'Buy Book', 'woocommerce' );	
	}
	return __( 'Buy Book', 'woocommerce' );
	 
        
 
}
   
 
function wc_custom_single_addtocart_text() {
	
	$termid    = get_termid_from_postid(get_the_ID());
	
	$dbeventcat= clr_of_get_option("event_category");
	
	
	if($termid == $dbeventcat){
		return "Subscribe To The Event";
	}else{
	return "Buy Book";	
	}
	return "Buy Book";
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'wc_custom_single_addtocart_text' );
//**************************************

// Loads options.php from child or parent theme
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );

/*
* Custom post type 
*/
require_once dirname( __FILE__ ) . '/inc/clr-custom_post_type.php';
/*
* CLR FUNCTIONS FILE.
*/
require_once dirname( __FILE__ ) . '/inc/clr-functions.php';

/*
* CLR FUNCTIONS Hooks
*/
require_once dirname( __FILE__ ) . '/inc/clr-override-hooks.php';

/*
* CLR widget file
*/
require_once dirname( __FILE__ ) . '/widget/clr-widgets.php';
/*
 * Shortcode functionality 
 */
require_once dirname( __FILE__ ) . '/shortcode/clr-shortcode.php';

/*
 * Admin Functionality
 */
require_once dirname( __FILE__ ) . '/inc/admin/admin.php';

/*
 * json api 
 */
require_once dirname( __FILE__ ) . '/inc/json/json-api.php';

//adding the constants
require_once dirname( __FILE__ ) . '/config.php';

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

function eminds_theme_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
            'primary'=> __( 'Dropdown Menu', 'eminds' ),
            'header'=> __( 'Header Menu', 'eminds' ),
            'mobile'=> __( 'Mobile Menu', 'eminds' )
                 )    
            );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'eminds_theme_setup' );
/*
 *Enable the sidebar 
 */
 
 /*
 * Default sidebar
 */		
	register_sidebar(array(
                'name' => 'Default Sidebar',
                'id'   => 'eminds_default_sidebar',
                'description'   => 'Enter the sidebar widgets.',
                'before_widget' => '<section class="right-content">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>'
        ));		

/*
 *Footer widget - 1 
 */
register_sidebar(array(
                'name' => 'Footer widget About CLR',
                'id'   => 'footer_widget_1',
                'description'   => 'This widget is used in footer.',
                'before_widget' => ' ',
                'after_widget'  => '',
                'before_title'  => '<h5 class="display-ib">',
                'after_title'   => '</h5>'
        ));		
 
 /*
 *Footer widget - 2 
 */
 register_sidebar(array(
                'name' => 'Footer widget Menu',
                'id'   => 'footer_widget_2',
                'description'   => 'This widget is used in footer.',
                'before_widget' => ' ',
                'after_widget'  => '',
                'before_title'  => '<h5>',
                'after_title'   => '</h5>'
        ));		
 
 /*
 *Footer widget - 3 
 */
 register_sidebar(array(
                'name' => 'Footer widget Follow us',
                'id'   => 'footer_widget_3',
                'description'   => 'This widget is used in footer.',
                'before_widget' => '<section class="col-sm-3">',
                'after_widget'  => '</section>',
                'before_title'  => '<h5>',
                'after_title'   => '</h5>'
        ));		
 
 /*
 *Footer widget - 4 
 */
register_sidebar(array(
                'name' => 'Footer widget Subscriber',
                'id'   => 'footer_widget_4',
                'description'   => 'This widget is used in footer.',
                'before_widget' => '<section class="col-sm-5 col-sm-offset-4"><section class="subscription">',
                'after_widget'  => '</section></section>',
                'before_title'  => '<h5>',
                'after_title'   => '</h5>'
        ));		
 
/*
 * Single sidebar widget 
 */ 
register_sidebar(array(
                'name' => 'Legal Update Single page',
                'id'   => 'single_page_widget',
                'description'   => 'This widget will display below the legal  single page.',
                'before_widget' => '<section class="related-articles"><section class="posts-content">',
                'after_widget'  => '</section></section>',
                'before_title'  => '<strong class="main-heading display-b">',
                'after_title'   => '</strong>'
        ));		
 
register_sidebar(array(
                'name' => 'CA 2013 Single page',
                'id'   => 'ca2013_single_page_widget',
                'description'   => 'This widget will display below the company act 2013 single page.',
                'before_widget' => '<section class="related-articles"><section class="posts-content">',
                'after_widget'  => '</section></section>',
                'before_title'  => '<strong class="main-heading display-b">',
                'after_title'   => '</strong>'
        ));		
		
  /*
  *Some Feature 
  */
	function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
/*
 *Get post content type 
 */
 function eminds_get_post_content_type($pid){
 	$output ="";
	$inc =1;
	$term_list = wp_get_post_terms($pid, 'legal', array("fields" => "all")); //print_r($term_list);
	if(count($term_list)>0){
		foreach($term_list as $term){
			//print_r($term);
			 $term_link = get_term_link( $term );
			$output .= '<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a>';
			$output .=($inc == count($term_list))?"":",&nbsp;";
			++$inc;
		}
	}
	
   return $output;
 }
 //**************************************** Send an email functions ******************************
 /*
  *Read the template file 
  */
 function eminds_read_emailtemplatefile($filename){
 	$output = file_get_contents(get_stylesheet_directory_uri()."/email-template/".$filename);
	return $output;
 }
 
 /*
  * Generate activationkey and set to database 
  * Flag  : 1 : set in database
  *      
  */
  function eminds_update_activation_key($user_email,$value){
  	global $wpdb;
	$sql_db = "UPDATE ".$wpdb->prefix."users SET `user_activation_key`='$value' WHERE user_email='$user_email' OR ID='$user_email'";
	$output = $wpdb->query($sql_db);
	return $output;
  }
 /*
  *Validate the activation key  
  */ 
  
  function eminds_validate_activation_key($username,$activationkey){
  	global $wpdb;
	$sql_user_validate = "SELECT * FROM ".$wpdb->prefix."users WHERE (user_login='$username' OR user_email='$username') AND `user_activation_key`='$activationkey'   ";
	$arr_user_validate = $wpdb->get_results($sql_user_validate);//print_r($arr_user_validate);exit;
	
	if(is_array($arr_user_validate) AND count($arr_user_validate)>0){
		return TRUE;
	}else{
		return FALSE;
	}
	
  }
 /*
  *Executes the tempalte file with available values. 
  */
 function eminds_search_replace_with_value($searcharr,$replacearr,$msg){
 	$output = str_replace($searcharr,$replacearr,$msg);
	return $output;
 }
 
 /*
  *Function send an email  
  */
function eminds_send_email_touser($to,$sub,$body,$admin_email='admin'){
	
	$headers = 'From: '.$admin_email.' <'.$admin_email.'>' . "\r\n";
    wp_mail( $to, $sub, $body ,$headers);

}

/*
 *Again new funciton : send an email. 
 */
 function eminds_send_emailfire($to_email,$from_email,$messge,$from_name){
 		
 	$headers = 'From: '.$from_name.' <'.$from_email.'>' . "\r\n";
	$sub     = 'User need to contact you from website : '.site_url();
    $output = wp_mail($to_email, $sub, $messge ,$headers);
	return 1;
 }

//*************************************************
/*
 * Get taxonomy link 
 */
function eminds_get_taxonomy_link($postid,$taxonomy,$defaultText=0){
	$term_list = wp_get_post_terms($postid, $taxonomy, array("fields" => "all")); //print_r($term_list);
	$output ="";
	
	$totalpost = count($term_list);
	
	if(count($term_list)>0){
		$inc =1;
		foreach($term_list as $term){
		 
		 $output .="<a href='".get_term_link($term)."' title='".$term->name."' class='termlink ".$term->slug."' >".$term->name."</a>";	
	   	 $output .=($inc == count($term_list))?"":",&nbsp;";
		++$inc;	
		}
	}
$addText = "";	
 /*
  *Special condition : Tags : if defaultText = 1 : then it will denote the tags 
  */	
  if($defaultText == 1){
  	   if($totalpost == 1){
  	   $addText = "Tag: "; 	
  	   }else if($totalpost > 1){
  	   $addText = "Tags: ";	
  	   }else{
  	   	$addText = "";
  	   }
	
	
  }
	
	return $addText . $output;
}
/*
 *New Feature 
 *1 : Last updated : Show the current updated post and if current updated post > 2 then show only 2 day's.
 *2 : Add button :Emergency Hide : In theme options for hide this options. 
 */
 function eminds_lastupdated_ca2013(){
   
   $output = "";
   $mddate      = get_the_modified_date();
   $datetoday = date("F d, Y");
   
   $start = strtotime($mddate);
   $end = strtotime($datetoday);

  $days_between = ceil(abs($end - $start) / 86400);
  
  if($days_between <= 2){
  	//show updated date
  $output = $mddate ;
  }else{
  	//show before 2 day's date.
  $output =	date("F d, Y",strtotime($datetoday.' -2 day')) ;
  }
 if(is_page_template('template-company_act.php')){
   return " ".$output;  
 }
  return "Updated Till : ".$output;	


 }
 
 /*
  * Send email to author  
  */
 add_action('wp_ajax_eminds_sendemail_toauthor','eminds_sendemail_toauthor');
 add_action('wp_ajax_nopriv_eminds_sendemail_toauthor','eminds_sendemail_toauthor');
 function eminds_sendemail_toauthor(){
 	
 	    $from_name = $_POST['sender'];
		$from_email= $_POST['email'];
		$from_msg  = $_POST['msg'];
		
		$to_email  = $_POST['authorname'];//get_option("admin_email");
    	
		//Step-1 :read the template
		$template_msg = eminds_read_emailtemplatefile("author-email.html");
		
		//Step-2 : Get actual message which is send in email.
		
		$searcharr = array('[authorname]','[name]','[email]','[message]');
		$replacearr= array($to_email,$from_name,$from_email,$from_msg);
		
	    $messge   = eminds_search_replace_with_value($searcharr,$replacearr,$template_msg);
		//Step-3 : Send email : END
		//echo 'To='.$to_email."<br/>fROM=".$from_email."<br/>MSG=".$messge."<br/>fname=".$from_name;
		$output = eminds_send_emailfire($to_email,$from_email,$messge,$from_name);
        echo '<p>Email have been send. </p>';
	die(0);
 }

//****************************************** LINKEDIN FUNCTION START **************************
/*
 * check this user is come first time or not
 * Value : 0 : it is not previously logged in
 *       : 1 : it is previously logged in .
 */
function eminds_is_previously_loggedin($email){
    global $wpdb;
    $sql_query = "SELECT * FROM ".$wpdb->prefix."users WHERE user_email='$email' ";
    $arr_value = $wpdb->get_row($sql_query);
    if($arr_value){
        return 1;
    }else{
      return 0;  
    }
}
update_user_meta(1437,'display_name',"shankaranand"); 
/*
 * Create new user in wordpress.
 */
function eminds_create_new_user($email,$pass,$linked_fname){
    //$user_id = wp_create_user( $user_name, $random_password, $user_email );
    $user_id = wp_create_user( $email, $pass, $email );
	//update the display name.
	$user_id = wp_update_user( array( 'ID' => $user_id, 'display_name' => $linked_fname ) );
	
    return $user_id;
}
/*
 *Generate the wordpress loggedin session 
 */
function eminds_wp_user_session($userlogin,$redirecturl){

    $user = get_user_by('login', $userlogin );

// Redirect URL //
if ( !is_wp_error( $user ) )
{
    wp_clear_auth_cookie();
    wp_set_current_user ( $user->ID );
    wp_set_auth_cookie  ( $user->ID );

    $redirect_to = $redirecturl;
    wp_safe_redirect( $redirect_to );
    exit();
}

}
/*
 *Get the user login name via :email
 */
function eminds_user_info_via_email($email,$column='user_login'){
    global $wpdb;
    $sql_query = "SELECT * FROM ".$wpdb->prefix."users WHERE user_email='$email' OR user_login='$email' ";
    $arr_value = $wpdb->get_row($sql_query);
    if($arr_value){
        return $arr_value->$column;
    }else{
      return 0;  
    }
}        
//************
function add_minify_location(){
	if (class_exists('WPMinify')) {?>

<!-- WP-Minify JS -->
<!-- WP-Minify CSS -->

<?php }
}
add_action('wp_head','add_minify_location',99);
//****************************************** LINKEDIN FUNCTION END *************************



//********************for concurrent user to be logged out*****************7th oct saturday
function my_pcl_whitelist_roles( $prevent, $user_id ) {

    $whitelist = array( 'administrator' ); // Provide an array of whitelisted user roles

    $user = get_user_by( 'id', absint( $user_id ) );

    $roles = ! empty( $user->roles ) ? $user->roles : array();

    return array_intersect( $roles, $whitelist ) ? false : $prevent;

}
add_filter( 'pcl_prevent_concurrent_logins', 'my_pcl_whitelist_roles', 10, 2 );



/*//add_action('personal_options_update', 'update_extra_profile_fields');
 
 function update_extra_profile_fields($user_id) {
  //echo $user_id;
  echo "<pre>";
  var_dump($Scratchcode = $_POST["fields"]['field_57fb837f19e58']);

  echo"</pre>";
   $uniquescratchdata = eminds_validate_scratchcode($Scratchcode);
      echo    $uniquescratchdata;

   if($uniquescratchdata)
   {

                    emind_custom_scratchcode_updatestatusexisting($uniquescratchdata);
                     emind_custom_data_save_config($user_id, $uniquescratchdata);
                       global $current_user;
                                $user_roles = $current_user->roles;
                                echo "<pre>";
                                var_dump($user_roles);
                                echo "</pre>";
                                $user_role = array_shift($user_roles);
                                 $userid = $current_user->ID;
                               
                                //allow for author and contributor
                                if(in_array($user_role,array("contributor","author")))
                                {

                                     $u = new WP_User($userid);
                                               // Remove role
                                               $u->remove_role( 'contributor' );

                                                // Add role
                                                $u->add_role( 'author' );
                                    echo "<p id='thankyou'> Your Account has been Updated</p>";
                                                
                                }  
   }
   else
           
                    {          
                      $_POST["fields"]['field_57fb837f19e58'] = 10;
                     echo '<p class="errormsg" >Please enter unique scratch code</p>';
                    // wp_redirect(get_permalink(get_the_ID());
                    }


  //die();
     // if ( current_user_can('edit_user',$user_id) )
     //     update_user_meta($user_id, 'my_custom_field', $_POST['your_field']);
                    $_POST["fields"]['field_57fb837f19e58'] = 10;
                      echo "<pre>";
  var_dump($Scratchcode = $_POST["fields"]['field_57fb837f19e58']);

  echo"</pre>";
  die();
 }*/
 function check_fields($errors, $update, $user) {
   /* echo "<pre>";
  var_dump($_POST);
  echo"</pre>";
  die();*/
  global $current_user;
  $userid = $current_user->ID;
  $user_roles = $current_user->roles;
  $user_role = array_shift($user_roles);
    $Scratchcode = $_POST["fields"]['field_57fb837f19e58'];
    if($Scratchcode)
    {
   $uniquescratchdata = eminds_validate_scratchcode($Scratchcode);
   if($uniquescratchdata)
   {
     // global $current_user;
     // $user_roles = $current_user->roles;
                                // echo "<pre>";
                                // var_dump($user_roles);
                                // echo "</pre>";
                                // $user_role = array_shift($user_roles);
                                //  $userid = $current_user->ID;
                            
                                 
                            

                    emind_custom_scratchcode_updatestatusexisting($uniquescratchdata);
                  
             
                     emind_custom_data_save_config($userid, $uniquescratchdata);
                     //var_dump( $user_role);
                      
                               // die();
                               
                                //allow for author , contributor and customer 
                                if(in_array($user_role,array("contributor","author","customer")))
                                {

                                     $u = new WP_User($userid);
                                               // Remove role
                                               $u->remove_role( 'contributor' );
                                                /*
                                                Remove role - customer for book user - 13th oct
                                                Functinality Updated for book user as this role is created during bokk purchasing*/
                                               $u->remove_role( 'customer' );



                                                // Add role
                                                $u->add_role( 'author' );
                                    echo "<p id='thankyou'> Your Account has been Updated</p>";
                                                
                                }  
   }
   else
   {
    
$updated = update_user_meta( $userid, 'scratch_code_validate', 0);

  $errors->add('demo_error',__("The scratchcode $Scratchcode you entered is invalid. Please Enter a Unique scratchcode to continue to profile save"));
    }
}
}
add_filter('user_profile_update_errors', 'check_fields');

// //*************Api
// //Here is an example of adding REST API support to an existing custom post type:

//   /**
//   * Add REST API support to an already registered post type.
//   */
//   add_action( 'init', 'my_custom_post_type_rest_support', 25 );
//   function my_custom_post_type_rest_support() {
//     global $wp_post_types;
  
//     //be sure to set this to the name of your post type!
//     $post_type_name = 'companies_act';
//     if( isset( $wp_post_types[ $post_type_name ] ) ) {
//       $wp_post_types[$post_type_name]->show_in_rest = true;
//       $wp_post_types[$post_type_name]->rest_base = $post_type_name;
//       $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
//     }
  
//   }

function wpa_120656_convert_paying_customer( $order_id ) {
  echo $order_id ;
  die();

    $order = new WC_Order( $order_id );

    if ( $order->user_id > 0 ) {
        update_user_meta( $order->user_id, 'paying_customer', 1 );
        $user = new WP_User( $order->user_id );

        // Remove role
        $user->remove_role( 'customer' ); 

        // Add role
        $user->add_role( 'contributor' );
    }
}
add_action( 'woocommerce_order_status_completed', 'wpa_120656_convert_paying_customer' );
?>
