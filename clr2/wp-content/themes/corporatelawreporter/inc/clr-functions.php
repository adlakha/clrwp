<?php
ob_start();

//hide user billing and shipping from user page in admin.
add_filter( 'woocommerce_customer_meta_fields', '__return_empty_array' );

/*
 * category slug by category id
 */
function clr_get_cat_slug($cat_id) {
	$cat_id = (int) $cat_id;
	$category = &get_category($cat_id);
	return $category->slug;
}
//********************************  woocommerce work **************************************
//Store the custom field
  // Add item data to the cart
 // Load cart data per page load
 /*
  *Adding the data into the cart 
  */
 add_filter( 'woocommerce_get_cart_item_from_session', 'woocommerce_get_cart_item_from_session_custom', 20, 2 );
 function woocommerce_get_cart_item_from_session_custom( $cart_item ) {
      @session_start();
    //  $new_values = array("custom_value1"=>"value1","custom_value2"=>"value2","custom_value3"=>"value3");
	  $new_values   = array();
	  //store how many members :
	 // echo '<pre>';print_r($cart_item);echo '</pre>';
	  
	  $totalqty = $cart_item['quantity'];
	 $product_id= $cart_item['product_id'];
	  
	  if($cart_item){
	  	
		for($i=1;$i<=$totalqty;$i++){
		     	
		     $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
            //other two fields
			 $organisation  = 'organization_'.$product_id."_".$i;
			 $member_email  = 'member_email_'.$product_id."_".$i;
			 			 
			 //storing into the array.
			 $new_values[$memberkey]     = $_SESSION[$memberkey]; 
			 $new_values[$designationkey]= $_SESSION[$designationkey];	
			 $new_values[$phonekey]      = $_SESSION[$phonekey];
			 //other two filed.	
			$new_values[$organisation]   = $_SESSION[$organisation];
			$new_values[$member_email]   = $_SESSION[$member_email];
			 
		}
		
	  }
	  
	  //merge into the array .
	  $cart_item = array_merge($cart_item,$new_values);
	  
        return $cart_item;

    }
 
 /*
  * Get cart item from cart 
  */
   //  get cart from session
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
		


	  $totalqty = $values['quantity'];
	 $product_id= $values['product_id'];

/*
 * Special case : As per requirement : 28 sep 2015 *****************************************
 * we need to sort the order via category basis and show the ordered product of only selected category.so I will implement one meta key in every order.
 * postmeta table : when order will done then it will also enteries of the category id.
 * 
 * Meta key  : product_category_{termid} : {termid} : (Meta value)
 */
$term_list = wp_get_post_terms($product_id,'product_cat', array("fields" => "all"));
$termid    = $term_list[0]->term_id;
//get order id
$orderid   = clr_get_orderid_from_itemid($item_id);

$newkey    = "product_category_".$termid;
//save in postmeta table
update_post_meta($orderid,$newkey,$termid);
//********************************************** End special case  : 


 if($values){
	  	
		for($i=1;$i<=$totalqty;$i++){
		     	
		     $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
		    //other two fields
			 $organisation  = 'organization_'.$product_id."_".$i;
			 $member_email  = 'member_email_'.$product_id."_".$i;
		
			 
			 //storing into the array.
			 $memberkey_value     = $values[$memberkey]; 
			 $designationkey_value= $values[$designationkey];	
			 $phonekey_value      = $values[$phonekey];
			 //other two filed.	
			 $organisation_value  = $values[$organisation];
			 $member_email_value  = $values[$member_email];
			 
			 //new key which is used to save into the database.
			 $key_member     = 'Deligate_name_'."_".$i;
			 $key_design     = 'Designation_'."_".$i;
			 $key_phone      = 'Deligate_phone_'."_".$i;
			 //other two key more
			 $key_organisation = 'Organisation'."_".$i;
			 $key_member_email = 'Deligate_email'."_".$i;
			 
			 if(!empty($memberkey_value)){wc_add_order_item_meta($item_id,$key_member,$memberkey_value);}
			 if(!empty($organisation_value)){wc_add_order_item_meta($item_id,$key_organisation,$organisation_value);}
			 if(!empty($designationkey_value)){wc_add_order_item_meta($item_id,$key_design,$designationkey_value);}
			 if(!empty($phonekey_value)){wc_add_order_item_meta($item_id,$key_phone,$phonekey_value);}
		     if(!empty($member_email_value)){wc_add_order_item_meta($item_id,$key_member_email,$member_email_value);}
			 
		}
		
	  }
		
		$user_custom_values = $values['custom_value1'];
        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'custom_value1',$user_custom_values);  
        }


  }
}
/*
 *Get order id from item id 
 */
function clr_get_orderid_from_itemid($itemid){
	
	global $wpdb;
	$sql_itemid = "SELECT * FROM `".$wpdb->prefix."woocommerce_order_items` WHERE order_item_id=$itemid ";
	$arr_itemid = $wpdb->get_row($sql_itemid);
	$orderid    = $arr_itemid->order_id;
	return $orderid;
}
 
//*********************************** woocommece work ***********************************

add_filter( 'wp_mail_content_type', 'set_html_content_type' );
function set_html_content_type() {
	return 'text/html';
}

/*
 * option framework theme function.
 */
function clr_of_get_option($id) {
	return of_get_option($id);
}

/*
 * Allow user to login  
 */
 function eminds_user_login_session($user,$pass,$rememberme=0){
 	                    $creds = array();
						$creds['user_login'] = $user;
						$creds['user_password'] = $pass;
				      //if checked for rememberme.
					   if($rememberme == 1){		
						$creds['remember'] = true;
					   }

						$user = wp_signon( $creds, false );
						if ( is_wp_error($user) ){
							echo $user->get_error_message();
							return false;
						}
						else{

							return true;
						//	wp_redirect(get_permalink(get_the_ID()));
						}
	 }
         
/*
 *User profile image
 */         
 function eminds_get_user_image($key,$userid){
    //$URL = wp_get_attachment_url($attid); 
    $URL ="";
    if(function_exists('get_field'))
	$URL = get_field($key, 'user_'.$userid);
     return $URL;
 }
 
/*
 * Send an email to the client.
 * Process :
 * 1:Get email id from username or emailid which is eneter by user.
 * 2:Get email template from file.
 */ 
 function eminds_send_email($euserlogin){
    $email = eminds_get_email($euserlogin);
    $emailbody = "";
    if($email){
     $emailbody_encrepted = file_get_contents(get_stylesheet_directory_uri()."/email-template/reset-password.html");
     $emailbody           = eminds_get_emailbody($emailbody_encrepted);
    }
    //send an email :
    $admin_email = get_option('admin_email');
  
 }
 /*
  * Generate random key
  */
function eminds_useractivationkey($length = 15)
{
    return substr(sha1(rand()), 0, $length);
}
/*
 * udpate activation key to user record
 */
function eminds_udpate_useractivationkey($email,$random_string){
    global $wpdb;
    $sql_update = "UPDATE ".$wpdb->prefix."users SET `user_activation_key`='$random_string' WHERE user_email='$email' ";
    $output     = $wpdb->query($sql_update);
    return $output;
}
 /*
  * Function : eminds_get_emailbody
  * Reason   : We need to replace the sign with value : [username] ,[link]
  */
 function eminds_get_emailbody($msg,$usr){
     
     $submit_article_pid = clr_of_get_option("submit_article_page");
     //generate the link
     $random_string = eminds_useractivationkey();
     /*
      * updae this random string to user record.
      */
      $flag =  eminds_udpate_useractivationkey($usr,$random_string);
      $link ="";
      if($flag){
         $link  = get_permalink($submit_article_pid)."?key1=$usr&key2=$random_string";  
      }     
    //key code for replacing.
     
     $str_find = array('[username]','[link]');
     $str_repl = array("$usr","$link");
     $msgbody = str_replace($str_find,$str_repl, $msg);
     return $msgbody;
 }
 /*
  * Get email id from username or email id
  */
 function eminds_get_email($usr){
     global $wpdb;
     
     $sql_user_validate = "SELECT * FROM ".$wpdb->prefix."users WHERE user_login='$usr' OR user_email='$usr' ";
     $arr_user_validate = $wpdb->get_results($sql_user_validate);//print_r($arr_user_validate);exit;
    
     if(is_array($arr_user_validate) AND count($arr_user_validate)>0){
        $email = $arr_user_validate[0]->user_email;
        return $email;
	}
  }
 
  /*
  * Get user id from username or email id
  */
 function eminds_get_userid($usr){
     global $wpdb;
     
     $sql_user_validate = "SELECT * FROM ".$wpdb->prefix."users WHERE user_login='$usr' OR user_email='$usr' ";
     $arr_user_validate = $wpdb->get_results($sql_user_validate);//print_r($arr_user_validate);exit;
    
     if(is_array($arr_user_validate) AND count($arr_user_validate)>0){
        $userid = $arr_user_validate[0]->ID;
        return $userid;
	}
  }
 
/*
 * Validate the username and email id  
 */
 function eminds_validate_username_emailid($usr){
 	global $wpdb;
	 $sql_user_validate = "SELECT * FROM ".$wpdb->prefix."users WHERE user_login='$usr' OR user_email='$usr' ";
	$arr_user_validate = $wpdb->get_results($sql_user_validate);//print_r($arr_user_validate);exit;
	
	if(is_array($arr_user_validate) AND count($arr_user_validate)>0){
		return TRUE;
	}else{
		return FALSE;
	}
	
 }
 
 /*
 * Validate the scratch code------   28 september
 */
 function eminds_validate_scratchcode($scratchcode){
 	global $wpdb;
	 $sql_scratchcode_validate = "SELECT * FROM wp_eminds_unique_scratchcode WHERE scratchCode='$scratchcode' AND status=0";
	$arr_scratchcode_validate = $wpdb->get_results($sql_scratchcode_validate);
	//echo "<pre>"; print_r($arr_scratchcode_validate);
	//echo"</pre>";
	//echo "<pre>"; var_dump($arr_scratchcode_validate[0]->sno); echo "</pre>"; 
	 //$scratchcodeID = $arr_scratchcode_validate[0]->sno;
     $scratchcode = $arr_scratchcode_validate[0]->scratchCode;
	

	
	if(is_array($arr_scratchcode_validate) AND count($arr_scratchcode_validate)>0){
	//	print_r($arr_scratchcode_validate);
	//	die();
		return 	 $scratchcode;
	}else{
		return FALSE;
	}
	
 } 
 /*
 * For updating status of coupun id -- 0 unused and 1 used  -- 28september
 */
function emind_custom_scratchcode_updatestatus($scratchcode){
 	global $wpdb;
	// $sql_scratchcode_validate = "SELECT * FROM wp_eminds_unique_scratchcode WHERE scratchCode='$scratchcode' AND status=0 AND";

	$sql_scratchcode_validate =	"SELECT * 
FROM wp_eminds_unique_scratchcode
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.scratchCode= '".$scratchcode."'";




	$arr_scratchcode_validate = $wpdb->get_results($sql_scratchcode_validate);
	//print_r($arr_scratchcode_validate);
	//die();
     $scratchcode = $arr_scratchcode_validate[0]->scratchCode;
     print_r($scratchcode);
     $now = current_time('mysql', false);
     $dataValue =	$wpdb->update( 
	'wp_eminds_unique_scratchcode', 
	array( 
		'status' => 1,	// integer (number) 
		//'updated_at' => 	'2016-10-01 07:10:00'
		'updated_at' => 	 $now
	), 
	array( 'scratchCode' =>  $scratchcode ), 
	array( 
		'%s',	// value2
		//'%s'
	), 
	array( '%s' ) 
);
     print_r($dataValue);
 $wpdb->print_error(); 


 }
 /*
 * Saving data in two tables at the same time------   28 september
 */
 function emind_custom_data_save_config($user_id,$matchedscratchID)
 {
 
 	global $wpdb;
	 // for insertion in config table
          $tablenameconfig="wp_eminds_scratchcode_config";
                  $wpdb->insert($tablenameconfig, array(               
							               'userID' =>$user_id ,
							               'scratchcodeID' =>$matchedscratchID
											           ));
                  $wpdb->print_error(); 
                 
												
 }
    
 /*
 * Get the username by the username or email id  
 */
 function eminds_get_username_by_username_or_emailid($usr){
 	global $wpdb;
	 $sql_user_validate = "SELECT * FROM ".$wpdb->prefix."users WHERE user_login='$usr' OR user_email='$usr' ";
	$arr_user_validate = $wpdb->get_row($sql_user_validate);
	//print_r($arr_user_validate);exit;
	
	if(count($arr_user_validate)>0){
		return $arr_user_validate->user_login;
	}else{
		return 0;
	}
	
 }


//********************** Send email to user ***********************
/*
 *Send email to user
 *Parameter :1: -  useremail 
 *           2:-   Filename
 */ 

/*
 * Call the ACF functions: get_field()
 */
function clr_get_field($key) {
	$output = "";
	if (function_exists('get_field')) {
		$output = get_field($key);
	}
	return $output;
}

/*
 *Call the ACF function for the category
 */
function clr_get_field_for_category($key, $catid) {
	$output = "";
	if (function_exists('get_field')) {
		$output = get_field($key, "act_chapter_" . $catid);
	}
	return $output;
}

/*
 *Update the user record 
 */
 function eminds_update_user_record($uid,$post){
 	
 	update_user_meta($uid,'first_name',$post['fname']);
	update_user_meta($uid,'last_name',$post['lname']);
	update_user_meta($uid,'qualification',$post['qualification']);
	update_user_meta($uid,'designation',$post['designation']);
	update_user_meta($uid,'organization',$post['org']);
	update_user_meta($uid,'phone',$post['contactno']);
	update_user_meta($uid,'address',$post['address']);
	update_user_meta($uid,'city',$post['city']);
	update_user_meta($uid,'state',$post['state']);
	
 }
/*
 *Update user image 
 */
 function eminds_update_user_image($uid,$post){
 	$profileimg = $post['profileimage'];
	update_user_meta($uid,'eminds_user_profile_image',$profileimg);
	
	$orgimg = $post['orgimage'];
	update_user_meta($uid,'eminds_user_organisation_image',$orgimg);
	
 }

/*
 * Generate thumbnail with wordpress custom size options
 * How to use :
 * echo digital_get_thumbnail_html_with_customsize($postid,'thumbnail',"thumbnailimage");
 * echo digital_get_thumbnail_html_with_customsize($postid,array(300,300),"thumbnailimage");
 */

function eminds_get_thumbnail_html_with_customsize($postid, $sizearr='thumbnail', $class = "thumbnailimage") {

    $imgHTML = "";
    //Check this post have the thumbnail image or not.
    if (has_post_thumbnail($postid)) {
        //generate thumbnail id of this post.
        $thumbnailid = get_post_thumbnail_id($postid);

        $default_attr = array(
            'class' => "thumbnail-image $class",
            'alt' => trim(strip_tags(get_the_title($postid))),
            'title' => trim(strip_tags(get_the_title($postid))),
        );
        $imgHTML = wp_get_attachment_image($thumbnailid, $sizearr, "", $default_attr);
    }
    return $imgHTML;
}
/*
 * Display the date in specific formate : Hours > Yesterday > Date 
 */
 function eminds_date_feature($postdate_second){
 	
	         $output = "";
			 $prefix_txt = "| ";
		//*************** WP DATE functionality
		$currTime_second = current_time( 'timestamp' );
		$seconds_diff = $currTime_second - $postdate_second;
		$hours_diff   = $seconds_diff/3600;
		/*
		 *Decision 
		 * : Hours and minutes we will take : floor
		 * : Seconds we will take: ceil 
		 */
			/*
			 * Show in number hours : time < 24  : Show the minutes and hours.
			 * show in Yesterday    : time > 24 and time < 48 
			 * show in actual date  : not satisfied above both condition. 
			 */
            if($hours_diff < 24 ){
		             /*
					  * Condition in hours and minutes.
					  */
					$minutes_diff = ceil($seconds_diff/60);
					  
					  if($minutes_diff < 60){
					    $output= $minutes_diff ." minutes ago";	
					  }else{
					  	$output= floor($hours_diff) . " hours ago";
					  }
			  	
            }else if($hours_diff >= 24 AND $hours_diff <= 48 ){
            	$output=" Yesterday";	
            }else{
            	$prefix_txt = "On ";
            	$output=get_the_time('M j,Y');
            }
			return $prefix_txt . $output;
 }
/*
 * Enqueue scripts 
 */
 function eminds_scripts_styles(){
 	
 wp_enqueue_style( 'bootstrap',get_stylesheet_directory_uri() . '/css/bootstrap.css' );
 wp_enqueue_style( 'wpdefaultcss',get_stylesheet_directory_uri() . '/css/wp-default.css' );
 wp_enqueue_style( 'common.css',get_stylesheet_directory_uri() . '/css/common.css' );
 wp_enqueue_style( 'innerstyle.css',get_stylesheet_directory_uri() . '/css/style.css' );
 
 wp_enqueue_style( 'maincss',get_stylesheet_uri());
 wp_enqueue_style( 'media.css',get_stylesheet_directory_uri() . '/css/media.css' );
 	
 wp_enqueue_script( 'bootstrip.min', get_stylesheet_directory_uri(). '/js/bootstrap.min.js', array("jquery"), '', true );
 wp_enqueue_script( 'script.js', get_stylesheet_directory_uri(). '/js/script.js', array("jquery"), '', true );
 // Localize the script with new data
$default_val = array('theme_path' => get_stylesheet_directory_uri(),'ajaxURL' =>admin_url('admin-ajax.php') );
wp_localize_script( 'script.js', 'obj', $default_val );





 wp_enqueue_script('jQueryCookies', get_stylesheet_directory_uri(). '/js/jquery.cookie.js', array("jquery"), '', true );
// wp_enqueue_script('sharthisjs', get_stylesheet_directory_uri(). '/js/sharethis.js', array("jquery"), '', true );
 	
 }
 add_action( 'wp_enqueue_scripts', 'eminds_scripts_styles' );
 
 /*
  * Admin scripts 
  */
  function eminds_admin_scripts_styles(){
   wp_enqueue_script('jquery-ui-datepicker');
   wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css'); 	
  }
 add_action( 'admin_enqueue_scripts', 'eminds_admin_scripts_styles' );
 
 /*
  *Pickup excerpt content 
  */
  function eminds_excerpt_content($pid,$countchar=399){
  	$output ="";
  	$output = do_shortcode(get_post_field('post_excerpt',$pid));
	if(empty($output)){
	$output = do_shortcode(get_post_field('post_content',$pid));
	 		
	}
	$trimmed = wp_trim_words( $output, $num_words = 55, $more =null );
	$trimmed .=" <a class='short-content' href='".get_permalink($pid)."'>Read More</a>"; 
	return wpautop($trimmed);
  }
  
/*
 * Social sharing class
 * Follow Facebook share count : Ref : http://ctrlq.org/code/19633-facebook-like-api-php
 *
 * Ref: http://99webtools.com/blog/php-script-to-get-social-share-count/ : changed
 * NewRef : http://www.aljtmedia.com/blog/getting-your-social-share-counts-with-php/
 */

function eminds_flq_facebook_count($url){
 
    // Query in FQL
    $fql  = "SELECT share_count, like_count, comment_count ";
    $fql .= " FROM link_stat WHERE url = '$url'";
 
    $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
 
    // Facebook Response is in JSON
    $response = json_decode(file_get_contents($fqlURL));
    //print_r($response);
    // facebook share count
   $sharecount=$response[0]->share_count;
   $sharecount= ($sharecount==0||$sharecount=="")?0:$sharecount;	 
	
 return $sharecount;
}


//Twitter share count
function eminds_twitter_count($url){
    
    $shareHTML ="https://cdn.api.twitter.com/1/urls/count.json?url=$url";
    $outputjson= eminds_file_get_content($shareHTML);
    $outputArr =json_decode($outputjson);
    $sharecount= $outputArr->count;
    return $sharecount;
}
//linedin share count 
function eminds_linkedin_count($url){
    
    $shareHTML ="https://www.linkedin.com/countserv/count/share?url=$url&format=json";
    $outputjson= eminds_file_get_content($shareHTML);
    $outputArr =json_decode($outputjson);
    $sharecount= $outputArr->count;
    return $sharecount;
}
//facebook share count.
function eminds_facebook_count($url){
  $sharecount =0;  
  $shareURL = "http://graph.facebook.com/?id=$url";  
  $outputjson= eminds_file_get_content($shareURL);
  $outputArr =json_decode($outputjson);
  if(count($outputArr)>0){
  $sharecount= @$outputArr->count;
  }
  return $sharecount;
  
}

//call the content via URL
function eminds_file_get_content($url){
    return @file_get_contents($url,TRUE);
}

/*
 * Author name on priority basis.
 * 1: Organisation image  > author image > author name. 
 */
function eminds_author_name($authorid){
$output="";	

   //organisation image
	$organisation_img ="";//eminds_get_user_image('upload_organisation_image',$authorid);
	
	//user website URL
	$website_url     = get_the_author_meta('user_url',$authorid);
	$authorName    = get_the_author_meta('display_name',$authorid);
	$target          ="target='_blank'";	
	if(empty($website_url)){
	$website_url     ="javascript:void(0)";
	$target          ="";		
	}
	//author  image
   $author_img ="";//eminds_get_user_image('upload_profile_image',$authorid);	
		
	if(!empty($organisation_img)){
		
	$output ="<img class='orgimg-post' width='100' height='100' src='$organisation_img' alt='author'  >";	
	$output_updated ='<a '.$target.' href="'.$website_url.'" title="'.$authorName.'" class="padding-none author-name fr">'.$output.'</a>';
	}else if(!empty($author_img)){
		
 	$output ="<img class='orgimg-post' width='100' height='100' src='$author_img' alt='author' >"; //get_author_posts_url( $authorid )
	$output_updated ='<a '.$target.' href="'.$website_url.'" title="'.$authorName.'" class="padding-none author-name fr">'.$output.'</a>';	
	}else{
		//author name
		$author_name = get_the_author_meta("display_name",$authorid);	
		if($author_name){
		$output = $author_name;	
		$output_updated ='<a href="'.get_author_posts_url( $authorid ).'" class="author-name fr">'.$output.'</a>';	
		}		
	}	
	
 return $output_updated;	
}
/*
 *Functionality modify : we need the author name only . 
 */
function eminds_author_name_modifydesign($authorid) {
	$output_updated="";
	$author_name = get_the_author_meta("display_name", $authorid);
	if ($author_name) {
		$output = $author_name;
	    $output_updated = '<span>Posted by</span> <a href="' . get_author_posts_url($authorid) . '" >' . $output . '</a>';
	}
 return $output_updated;
}
/*
 * In cart and checkout page, we will save the member information . 
 * AJAX calling  
 */
add_action("wp_ajax_event_member_info","event_member_info");
add_action("wp_ajax_nopriv_event_member_info","event_member_info");

function event_member_info(){
	@session_start();	
	$temp ="";
	$qty = $_POST['qty'];
	$product_id = $_POST['pid'];
	//echo $qty . "=" . $product_id;
	for($i=1;$i<=$qty;$i++){
	          $memberkey     = 'member_name_'.$product_id."_".$i;
			 $designationkey= 'designation_'.$product_id."_".$i;
			 $phonekey      = 'phone_'.$product_id."_".$i;
			 //other two fields
			 $organisation  = 'organization_'.$product_id."_".$i;
			 $member_email  = 'member_email_'.$product_id."_".$i;
			 
			//initialize with previously entered value.     		
			$_SESSION[$memberkey]      = empty($_POST[$memberkey]) ? $_SESSION[$memberkey]  :  stripslashes($_POST[$memberkey]);
			$_SESSION[$designationkey] = empty($_POST[$designationkey]) ? $_SESSION[$designationkey] : stripslashes($_POST[$designationkey]);
			$_SESSION[$phonekey]       = empty($_POST[$phonekey])  ? $_SESSION[$phonekey]   : stripslashes($_POST[$phonekey]);	
			//other two filed.	
			$_SESSION[$organisation]   = empty($_POST[$organisation]) ? $_SESSION[$organisation]  : stripslashes($_POST[$organisation]);
			$_SESSION[$member_email]   = empty($_POST[$member_email]) ? $_SESSION[$member_email]  : stripslashes($_POST[$member_email]);
	}//loop of for end 
	
	echo $temp;
	global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
	//wp_redirect( $checkout_url ); exit;
	echo $checkout_url;
	die(0);
} 
/*
 *To show the event expire functionality  
 *Posts as well as products. 
 */ 
 function clr_event_expire_key($pid){
 	
	global $woocommerce;
	
	$event_msg ="";
	
	/*
	 *When we are in post type : post then no issues but when we are in post type :product : then I need to the post id  
	 */
	$postType = get_post_type();
	
	if($postType == "post"){
	        $pid = $pid;	
	}else{
		global $wpdb;
		$sql_postid = "SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key='link_event_postid' AND post_id='$pid' ";
		$arr_postid = $wpdb->get_row($sql_postid);
		$pid        =$arr_postid->meta_value;
	}
	
	$enddate   = get_post_meta($pid,"event_expire_date",TRUE);
	
	
    $currdate  = date('Ymd');
	
	/*
	 * Special condition : if event end date is not set then  : Event will never expire
	 */
	
	if(!empty($enddate)){
	if(strtotime($enddate) >= strtotime($currdate) ){
	  	 ;
	 /*
	  * When use in single.php file then show a message for registration i.e subscribe here.: Subscribe To The Event
	  */	
		 if(is_single() || is_category()){
		 	
		$productid  = 0;
	if($postType == "post"){		 			
		 $wooproduct = get_post_meta($pid,"link_woocommerce_product",TRUE); //print_r($wooproduct);
		 $productid  = $wooproduct;
	}else{
	     $productid  = $pid;	
	}		
	/*
	 * This message will not show for product single page 
	 */ 
	
	  if($postType != "product"){		 		
		 $event_msg ="      
		   <div class='media-partner event-registeration'><i class='register-symbol icon'>&nbsp;</i>
	                     <a class='btn btn-primary subscribe-event-link' href='".get_permalink($productid)."'> Subscribe To The Event</a>
	                        </div>
	                        "; 	
		   }	
		 }
	 
	 }else{
	  $event_msg ="<style>.product-summary-".get_the_ID()." form.cart, li.post-".get_the_ID()." li a.add_to_cart_button{display:none;}</style>
	                        <div class='media-partner event-expired'><i class='expired-symbol icon'>&nbsp;</i>
	                        Event has expired.
	                        </div>
	                        ";
	  }
	}
	return $event_msg;
	
 }

/*
 *When update any event posts then we will create an woocommerce product automatically and linked with this event
 * we will also update it's price from here . 
 * 
 * Two key : link_woocommerce_product   : setting in post meta for post  :it have product id.
 *         : link_event_postid          : setting in post meta for product: it have post id .
 * 
 */
function clr_on_post_publish( $ID, $post ) {
	
// it will return true or false
/*
 * True : for event category posts.
 * False: for other category posts
 */
  $output = clr_is_postid_from_eventpost($ID);

  if($output){
  		
  	//need to create an woocommerce product for this category posts.	
  	/*
	 * Step -1 : Check is previously product have created or not. 
	 * $ID   : post id of event.
	 */
	 $is_product = clr_is_woocommerce_product_created($ID);
  	
	//getting values
	    $posttitle = $post->post_title;
	  	$content   = $post->post_content;
	  	$poststatus= $post->post_status;
	  	//meta value
	  	$rprice   = get_post_meta($ID,"event_regular_price_woocommerce",TRUE);
	  	$sprice   = get_post_meta($ID,"event_sale_price_woocommerce",TRUE);
		
	 /*
	  * Step - 2
	  * if product not created then create woocommerce product 
	  * otherwise update the woocommerce product. 
	  */
	  if(!$is_product){
	  	//create woocommerce product.
	  	
	  	$wooproduct_id = clr_create_woocommerce_product($ID,$posttitle,$content,$rprice,$sprice);
        //entry in db for : woocommerce product have been created.
         		
	  }else{
	  	//update the woocommerce product.
	  	//Before updating,we collect woocommerce product id : which is created by this post.
	  	$productid = get_post_meta($ID,"link_woocommerce_product",TRUE);
	  	clr_update_woocommerce_product($ID,$productid,$posttitle,$content,$rprice,$sprice,$poststatus='publish');
		
	  }
	  
		
  }else{
  	;//exclude i.e no change for other category posts.
  }
   

}
add_action('save_post',  'clr_on_post_publish', 10, 2 ); 

/*
 * It is verify that this post belong from :post event : category or not.
 * $pid  = post id 
 * $taxonomy= specify of taxonomy , default = 'legal'
 * $field= Specify for which field you need , Default = 'term_id'
 * $flag= By default :false : then we will return only true or false but
 *                   : true : we will return the taxonomy id .
 */
 
function clr_is_postid_from_eventpost($pid,$taxonomy='legal',$field='term_id',$flag=FALSE){
	
	$term_list = wp_get_post_terms($pid, $taxonomy, array("fields" => "all"));
	
	$output_arr = array();
	
	if($term_list){
		foreach($term_list as $termid){
		 $output_arr[] = $termid->$field;	
		}
	}
    //get event category term id from theme options
	$eventpost_termid = clr_of_get_option("event_category_content_type");
	
	/*
	 *Matching the term id 
	 */
	 if(in_array($eventpost_termid,$output_arr)){
	 	
		if(!$flag){
			return TRUE;
		}else{
			//get the term taxonomy id of this matching term id .
			$term_taxonomyid = clr_get_termtaxonomyid_from_eventcat($eventpost_termid);
			return $term_taxonomyid;
		}
		
	 }else{
	 	return FALSE;
	 }
	return FALSE;
}
/*
 *Get event category term taxonomy id  
 */
function clr_get_termtaxonomyid_from_eventcat($eventpost_termid){
 global $wpdb;
	
	$sql_termid     = "SELECT * FROM `".$wpdb->prefix."term_taxonomy` WHERE `term_id` =$eventpost_termid ";
	$arr_termid     = $wpdb->get_row($sql_termid);
	
	if($arr_termid){
		return $arr_termid->term_taxonomy_id;
	} 
	return 0;
}
/*
 * Verify : woocommerce product have created for this posts or not .
 * $pid         = Post id 
 */
 function clr_is_woocommerce_product_created($pid){
 	//it is an post id of event : $pid
	$productid = get_post_meta($pid,"woocommerce_product_for_eventpost",TRUE);
	
	if($productid){
		return TRUE;
	}else{
	 	return FALSE;
	}
	
 }
/*
 * Create woocommerce product . 
 * $postid    = post id of event i.e not product id
 * $posttitle = product title
 * $content   = content of product
 * $author    = author id : loggedin user
 * meta value------
 * $rprice    = regular price
 * $sprice    = sale price
 * 
 */ 
 function clr_create_woocommerce_product($postid,$posttitle,$content,$rprice=0,$sprice=0){
 		
 	$user_ID = get_current_user_id();
	
	// Create post object
		$my_post = array(
		  'post_title'    => $posttitle,
		  'post_content'  => $content,
		  'post_type'     => 'product',
		  'post_status'   => 'publish',
		  'post_author'   => $user_ID
		);
			// Insert the post into the database
		$product_id = wp_insert_post( $my_post );
			//update the meta
			clr_woocommerce_price_meta($product_id,$postid,$rprice,$sprice);
 }
 /*
 * Update woocommerce product .
  * $productid = post id of product
  * $post_id   = post id of event 
 * $posttitle = product title
 * $content   = content of product
 * $author    = author id : loggedin user
 * meta value------
 * $rprice    = regular price
 * $sprice    = sale price
 * $post_status= Status of the product
 */ 
 function clr_update_woocommerce_product($post_id,$productid,$posttitle,$content,$rprice=0,$sprice=0,$post_status='publish'){
 		
 	$user_ID = get_current_user_id();
	
	// Create post object
		$my_post = array(
		   'ID'           => $productid,
		  'post_title'    => $posttitle,
		  'post_content'  => $content,
		  'post_type'     => 'product',
		  'post_status'   => $post_status
		);
			// Insert the post into the database
         wp_update_post( $my_post );
			//update the meta
			clr_woocommerce_price_meta($productid,$post_id,$rprice,$sprice);
 }
 
 /*
  * add/update woocommerce price meta and other necessary  
  */
 function clr_woocommerce_price_meta($product_id,$postid,$rprice,$sprice){
 	
	update_post_meta($product_id,"_regular_price",$rprice);
		update_post_meta($product_id,"_sale_price",$sprice);
		$price =0;
		if($sprice == 0){
		   $price =$rprice;	
		}else{
		   $price =$sprice;	
		}
	update_post_meta($product_id,"_price",$price);
	//update for product have created
	 update_post_meta($postid,"woocommerce_product_for_eventpost",1);
	 //other two links for verify one each other.
	 /*
      * Two key : link_woocommerce_product   : setting in post meta for post  :it have product id.
      *         : link_event_postid          : setting in post meta for product: it have post id .	 
	 */
	update_post_meta($postid,"link_woocommerce_product",$product_id);
	update_post_meta($product_id,"link_event_postid",$postid);
	/*
	 * update product id in category : actually create and update both function all it.
	 */
	 $termid = clr_of_get_option("event_category");
	clr_assign_product_incategory($product_id,$termid,'product_cat');
	
 }
 /*
  * assign/update : product in category 
  */
function clr_assign_product_incategory($postid,$termid,$taxonomy='product_cat'){
	//wp_set_post_terms( $post_id, $terms, $taxonomy, $append );
	wp_set_post_terms( $postid,array($termid), $taxonomy);
}  
//*When update any event posts then we will create an woocommerce product automatically and linked with this event **********************************

function curPageURL1() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
/*
 * Modify search variable ********************************************** 
 */
 function search_excerpt_highlight() {
    $excerpt = get_the_excerpt();
    $keys = implode('|', explode(' ', get_search_query()));
    $excerpt = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);

    echo '<p>' . $excerpt . '</p>';
}

function search_title_highlight() {
    $title = get_the_title();
    $keys = implode('|', explode(' ', get_search_query()));
    $title = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $title);

    echo $title;
}
function search_content_highlight() {
        $content = do_shortcode(get_the_content());
        $keys = implode('|', explode(' ', get_search_query()));
        $content = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $content);

        echo '<p>' . $content . '</p>';
    }
 //***************** End search variable *******************************
 /*
  * Admin Edit link 
  */
  function admin_edit_link($pid){
  
  $output = "";
  	 if(is_user_logged_in()){
 	
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	//allow for author and administrator
	if(in_array($user_role,array("administrator"))){
		$adminLink = admin_url()."post.php?post=$pid&action=edit"; 
   		$output    = "<a title='Edit post' target='_blank' style='font-size:17px;' href='".$adminLink."'>";
		$output    .= "<img src='".get_stylesheet_directory_uri()."/images/edit-icon.png' alt='image'>";
		$output    .="</a>";
	  }
	return $output;	
   }
return $output;	
  }
 /*
  * User profile section : Remove woocommerce billing and shipping address 
  */ 
    
   /*
  * Update Account for existing user contributor to author : using scratchcard
  */ 
   // changes on - 5th october
   function emind_custom_scratchcode_updatestatusexisting($scratchcodeValue){
 	global $wpdb;
	
	$sql_scratchcode_validate =	"SELECT * 
FROM wp_eminds_unique_scratchcode
WHERE scratchCode = '".$scratchcodeValue."'";




	$arr_scratchcode_validate_result = $wpdb->get_results($sql_scratchcode_validate);
	//print_r($arr_scratchcode_validate);
	
     $scratchcodeMatched = $arr_scratchcode_validate_result[0]->scratchCode;
     //print_r($scratchcodeMatched);
   
$nowtime = current_time('mysql', false);
     $dataValue =	$wpdb->update( 
	'wp_eminds_unique_scratchcode', 
	array( 
		'status' => 1,	// integer (number) 
		//'updated_at' => 	'2016-10-01 07:10:00'
		'updated_at' => 	 $nowtime
	), 
	array( 'scratchCode' =>  $scratchcodeMatched ), 
	array( 
		'%s',	// value2
		//'%s'
	), 
	array( '%s' ) 
);
    // print_r($dataValue);
 $wpdb->print_error(); 


 }

 // 7th Oct-- Login time - cross check book user expiry date to change its role back to contributor if expiry dates matches
 function eminds_coupons_expiry_date_match($current_eminds_userid)
 {
 	global $wpdb;
 	$sql_get_result_match_expirydate="SELECT user_email, user_login, scratchcodeID, 
STATUS , created_at, updated_at, ExpiryDate
FROM wp_users
INNER JOIN wp_eminds_scratchcode_config ON wp_eminds_scratchcode_config.userID = wp_users.ID
INNER JOIN wp_eminds_unique_scratchcode ON wp_eminds_unique_scratchcode.scratchCode = wp_eminds_scratchcode_config.scratchcodeID
WHERE wp_eminds_unique_scratchcode.status =1
AND wp_eminds_scratchcode_config.userID ='".$current_eminds_userid."'";

	$arr_matchedcouponexpiry_date = $wpdb->get_results($sql_get_result_match_expirydate);
//var_dump($arr_matchedcouponexpiry_date);

	 $scratchcodeID = $arr_matchedcouponexpiry_date[0]->scratchcodeID;
	 $expiryDate = $arr_matchedcouponexpiry_date[0]->ExpiryDate;
	// echo $scratchcodeID;

   //$scratchcodeMatched = $arr_scratchcode_validate_result[0]->scratchCode;

	if(is_array($arr_matchedcouponexpiry_date) AND count($arr_matchedcouponexpiry_date)>0){
		
//12th oct
		 return array($scratchcodeID,$expiryDate);
		//return 	 $expiryDate;
	}else{
		return FALSE;
	}


 }
 // 10th oct -- for different message for book user
 function eminds_custom_book_user_welcome_message($authorid)
 {
 	global $wpdb;
 	$sql_scratchcard_matched_result="SELECT * 
 	FROM  `wp_eminds_scratchcode_config` 
 	WHERE userID = $authorid";

 	$arr_scratchcard_result= $wpdb->get_results($sql_scratchcard_matched_result);
 	//var_dump($arr_scratchcard_result);
 	$matchedScratchcardvalue = $arr_scratchcard_result[0]->scratchcodeID;
 	if(is_array($arr_scratchcard_result) AND count($arr_scratchcard_result)>0){
	
		return 	 $matchedScratchcardvalue;
	}else{
		return FALSE;
	}

 	
 }
 

?>
