<?php
/*
 *Explains the overrides functionality via hooks. 
 */

/*
 * Hide the any field in admin : user page.
 */
add_action('admin_head','hide_personal_options');
function hide_personal_options() { ?>
   <style>
   body.user-edit-php .acf-image-uploader,body.profile-php .acf-image-uploader{
    width:25%;
   }
   </style>
    <script type="text/javascript">
    jQuery(document).ready(function($) { 
       $("body.profile-php #your-profile tr.user-googleplus-wrap").hide();
       $("body.profile-php #your-profile #facebook-info").hide();
      //hide the facebook title :
     $("body.profile-php #your-profile h3").each(function(){
      var h3_title =  $(this).text();
      //console.log("h3_title=",h3_title);
      if(h3_title == "Facebook Account"){
        $(this).css("display","none");
      }
     });

 


    });
    </script>
<?php
}

/*
 * Define the restricted roles i.e user roles
 * 
 * Define: define ("EMINDS_RESTRICTED_ROLES", serialize (array ("author","contributor")));
 * Use   : $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);  
 */ 
 define ("EMINDS_RESTRICTED_ROLES", serialize (array ("author","contributor")));
 
/*
 * We will block some products for non administrator users.
 */
//add_action('init','eminds_block_products');
//eminds_block_products();
function eminds_block_products(){
 
  $product_ids = array(35569);

  if(in_array(get_the_ID(),$product_ids))
  {  
 //condition -1 
  if(is_user_logged_in()){    
    
       global $current_user;
      get_currentuserinfo();      
     $roleuser = $current_user->roles[0];
     
   if($roleuser == "administrator"){
      
     }else{
 ?>
   <script>
  console.log("else part");
   location.href="<?php echo get_permalink(34729); ?>";
  </script>
 <?php
     
//    wp_redirect( get_permalink(34729),301 );
 //    exit;
  //  return;
   }
  //condition -2   
   }else{
    
 ?>
   <script>
  console.log("else part");
   location.href="<?php echo get_permalink(34729); ?>";
  </script>
 <?php
   //  wp_redirect( get_permalink(34729),301 );
    // exit;
   // return;

  } 
 }

}
//******************************** 
 /*
 *Disable admin bar for author and contributor roles 
 */ 
 function eminds_disable_adminbar(){
     
 //It works when user logged in
 if(is_user_logged_in()){    
     global $current_user;
    get_currentuserinfo(); 
	
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
    $roleuser = $current_user->roles[0];
   if($roleuser){
    if(in_array($roleuser,$eminds_rest_role)){
        show_admin_bar( false );
    }
   }
   
 }//is user loggedin condition
   
     
 }
 add_filter('show_admin_bar', 'eminds_disable_adminbar');
/*
 * Security to hide the posts as well as attachement for not administrator user. 
 */

function hide_posts_media_by_other($query) {
	global $pagenow;

	if( ( 'edit.php' != $pagenow && 'upload.php' != $pagenow   ) || !$query->is_admin ){
		return $query;
	}

	if( !current_user_can( 'manage_options' ) ) {
		global $user_ID;
		$query->set('author', $user_ID );
         //    $query->set('contributor',$user_ID);
	}
	return $query;
}
add_filter('pre_get_posts', 'hide_posts_media_by_other');



add_filter( 'posts_where', 'hide_attachments_wpquery_where' );
function hide_attachments_wpquery_where( $where ){
	global $current_user;
	if( !current_user_can( 'manage_options' ) ) {
		if( is_user_logged_in() ){
			if( isset( $_POST['action'] ) ){
				// library query
				if( $_POST['action'] == 'query-attachments' ){
					$where .= ' AND post_author='.$current_user->data->ID;
				}
			}
		}
	}

	return $where;
}


/*
 * Allow how many roles to visit it. 
 */
function clr_remove_menus()
{
    global $menu;
    global $current_user;
    get_currentuserinfo();

 //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
	
 if(is_user_logged_in()){    //loggedin condition
 
    if(in_array($current_user->roles[0],$eminds_rest_role))
	{
	
        $restricted = array(__('chapter_form'),__('companies_act'),
                        //    __('Media'),
                            __('wpcf7'),
                            __('Links'),
                            __('Pages'),
                            __('Comments'),
                            __('Appearance'),
                            __('Plugins'),
                            __('Users'),
                            __('Tools'),
                            __('Settings')
        );
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }// end while

    }// end if
    
}//loggedin condition  
}
add_action('admin_menu', 'clr_remove_menus');
/*
 * creating an column in the admin menu : corporate act :
 */
add_filter('manage_companies_act_posts_columns', 'clr_menu_corporateact_columns_head');
add_action('manage_companies_act_posts_custom_column', 'clr_menu_corporateact_columns_content', 10, 2);

// ADD NEW COLUMN
function clr_menu_corporateact_columns_head($defaults) {
	
	$defaults['section_number'] = 'Section Number';

	return $defaults;
}
//******************** CPT- sorting
add_filter( 'parse_query', 'fb_custom_post_sort' );
function fb_custom_post_sort($query) {
  	
   if ( ! is_admin() )
         return $query;
/*
 * This code hide the custom field so I will added it on listing page only. 
 */
if(curPageURL1() == admin_url("edit.php?post_type=companies_act")){
  
    global $current_screen;
    if ( isset( $current_screen ) && 'companies_act' === $current_screen->post_type ) {
        $query->query_vars['orderby']  = 'meta_value_num';
        $query->query_vars['meta_key'] = 'enter_the_section_no_ca_post';
        $query->query_vars['order']    = 'ASC';
        }
   }
    //for the chapter_form 
    if(curPageURL1() == admin_url("edit.php?post_type=chapter_form")){
    if ( isset( $current_screen ) && 'chapter_form' === $current_screen->post_type ) {
        $query->query_vars['meta_key'] = 'form_number_caform';	
        $query->query_vars['orderby']  = 'meta_value';
        $query->query_vars['order']    = 'ASC';
        }
	}
//***********	
}

//******************** CPT- sorting



// SHOW THE FEATURED IMAGE
function clr_menu_corporateact_columns_content($column_name, $post_ID) {
	if ($column_name == 'section_number') {
		echo get_post_meta($post_ID, 'enter_the_section_no_ca_post', true);
	}
}

//************************** column content ******************************
//*********** Companies act form ****************************
add_filter('manage_chapter_form_posts_columns', 'clr_menu_companiesform_columns_head');
add_action('manage_chapter_form_posts_custom_column', 'clr_menu_companiesform_columns_content', 10, 2);
// ADD NEW COLUMN
function clr_menu_companiesform_columns_head($defaults) {
	$defaults['form_number'] = "<a href='".admin_url('edit.php?post_type=chapter_form&meta_key=form_number_caform&orderby=meta_value&order=ASC')."'>Form Number</a>";
	return $defaults;
}
function clr_menu_companiesform_columns_content($column_name, $post_ID){
	if ($column_name == 'form_number') {
		echo get_post_meta($post_ID, 'form_number_caform', true);
	}
}
//*********** Companies act form ********************************
/*
 * Manage own media only 
 */
 //Manage Your Media Only
// Code originally by @t31os
add_action('pre_get_posts','users_own_attachments');

function users_own_attachments( $wp_query_obj ) 
{
    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( 'upload.php' != $pagenow && 'media-upload.php' != $pagenow)
        return;

    if( !current_user_can('delete_pages') )
      ;//  $wp_query_obj->set('contributor', $current_user->id );

    return;
}
/*
 *Remove the comment count for contributor roles only. 
 */
 add_action('wp_before_admin_bar_render', function() {
 	
	    global $current_user;
    get_currentuserinfo();
     //print_r($current_user);
     //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
     
    if(in_array($current_user->roles[0],$eminds_rest_role))
	{
	   global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');	
	}
    
});

/*
 *Remove the post information i.e subsubsub information. 
 */
function eminds_remove_sub_sub_posts_filter() {
		    global $current_user;
    get_currentuserinfo();
     //print_r($current_user);
 //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
     
    if(in_array($current_user->roles[0],$eminds_rest_role)){
echo '<style type="text/css">
/*admin all-posts screen*/
/*#posts-filter,*/
ul.subsubsub .all,
ul.subsubsub .publish,
ul.subsubsub .sticky,
ul.subsubsub .trash,
ul.subsubsub .draft,
ul.subsubsub .pending,
.view-switch,
.toplevel_page_wpcf7,
.as3cf-notice,
.tablenav ,
.row-actions .editinline,
.check-column
* {display:none;}
</style>';
  }
}
add_action('admin_head', 'eminds_remove_sub_sub_posts_filter');

/*
 *Remove the wordpress dashboard widgets.  
 */
 /*
	Disable Default Dashboard Widgets
	@ https://digwp.com/2014/02/disable-default-dashboard-widgets/
*/
function eminds_dashboard_widgets() {
	global $current_user;
    get_currentuserinfo();
     //print_r($current_user);
 //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
     
    if(in_array($current_user->roles[0],$eminds_rest_role)){
 	
	global $wp_meta_boxes;
	// wp..
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	// bbpress
	unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
	// yoast seo
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
	// gravity forms
	unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
	}//for specific user role only.
}
add_action('wp_dashboard_setup', 'eminds_dashboard_widgets', 999);
/*
 * Remove the 'Post_formate ' for the user only 
 */
 add_action( 'after_setup_theme', 'eminds_remove_post_format', 11 ); 

function eminds_remove_post_format() {
	if(is_user_logged_in()){    //loggedin user only
	global $current_user;
    get_currentuserinfo();
     //print_r($current_user);
 //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
     
    if(in_array($current_user->roles[0],$eminds_rest_role)){
 	  // This will remove support for post thumbnails on ALL Post Types
    remove_theme_support('post-formats');
 }
 }//loggedin condition 
}

/*
 * Remove the seo column and other in post menu for the user : contributor and author 
 */
 function eminds_remove_columns( $columns ) {
global $current_user;
    get_currentuserinfo();
     //print_r($current_user);
 //call the list of restricted roles.
    $eminds_rest_role = unserialize (EMINDS_RESTRICTED_ROLES);
     
    if(in_array($current_user->roles[0],$eminds_rest_role)){
	// remove the All in one SEO columns
	unset( $columns['seotitle'] );
	unset( $columns['seodesc'] );
	unset( $columns['seokeywords'] );
	unset( $columns['comments'] );
	}
	return $columns;

}
add_filter ( 'manage_edit-post_columns', 'eminds_remove_columns' );

/*
 * Adding the CLR dashboard widget. 
 * 
 */

// Add Dashboard Widgets

function example_dashboard_widget_function() {

echo "<p>Welcome to <a href='".home_url()."' >".home_url()."</a> Content Management System (CMS):</p>\n"; 

echo "<p><strong><a href='".admin_url('post-new.php')."'>Guidelines for Submitting Article</a></strong></p>\n"; 

echo "<ol>\n"; 

echo "  <li> To submit your article, go to the &ldquo;Posts  tab&rdquo; on the bar above and click \"Add New\".</li>\n"; 

echo "  <li> The Article should be original and relevant</li>\n"; 

echo "  <li> If the content is typed offline in Microsoft  Word etc., then   first   copy-paste the same in Notepad and then paste the article  in CMS for better formatting. You can use the Bold, Underline and other formatting features appearing in the CMS only.</li>\n"; 

echo "  <li> Try not to use tables in your articles.</li>\n"; 

echo "  <li>Please avoid giving your phone numbers, address or other contact   info in the articles. Instead, use the bio-graphical info in your profile which will be displayed below all your posts.</li>\n"; 

echo "</ol>\n"; 

echo "<p><a href='".admin_url('profile.php')."' > <strong>Updating  your Profile</strong></a></p>\n"; 

echo "<p>Please update your profile along with  photograph so that the same     is accurately displayed to the readers along with  your posts.</p>\n"; 

echo "\n";	

} 

function example_add_dashboard_widgets() {

	wp_add_dashboard_widget('example_dashboard_widget', 'Welcome To Corporate Law Reporter', 'example_dashboard_widget_function');	

} 

add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );
/*
 *How to remove the personal options in admin i.e user section. 
 */
 // removes the `profile.php` admin color scheme options
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

if ( ! function_exists( 'cor_remove_personal_options' ) ) {
  /**
   * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
   */
  function cor_remove_personal_options( $subject ) {
    $subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
    return $subject;
  }

  function cor_profile_subject_start() {
    ob_start( 'cor_remove_personal_options' );
  }

  function cor_profile_subject_end() {
    ob_end_flush();
  }
}
add_action( 'admin_head-profile.php', 'cor_profile_subject_start' );
add_action( 'admin_footer-profile.php', 'cor_profile_subject_end' );

/*
 *Remove other things in User options i.e yim,aim,jabber 
 */
 function remove_contactmethods($contactmethods ) {
  // Remove AIM, Yahoo IM, Google Talk/Jabber
  unset($contactmethods['aim']);
  unset($contactmethods['yim']);
  unset($contactmethods['jabber']);
  // make it go!
  return $contactmethods;
}
add_filter( 'user_contactmethods', 'remove_contactmethods' );
/*
 *Woocommerce sale flash. 
 */
add_filter('woocommerce_sale_flash', 'my_custom_sale_flash', 10, 3);
function my_custom_sale_flash($text, $post, $_product) {
  return '<span class="onsale"> Special Offer </span>';  
}

/*
 * Customize the : Top admin bar : 
 */
/**
 * Customize WordPress Toolbar
 *
 * @param obj $wp_admin_bar An instance of the global object WP_Admin_Bar
 */
function myplugin_customize_toolbar( $wp_admin_bar ){
  $user = wp_get_current_user();
  if ( ! ( $user instanceof WP_User ) ){
    return;
  }
  // $my_account = $wp_admin_bar->get_node( 'my-account' );
  // if( ! empty( $user->user_url ) && $my_account ){
 
  $myAccountPageid = clr_of_get_option('submit_article_page');
  

    $wp_admin_bar->add_node( array(
      'parent'    => 'user-actions',
      'id'    => 'user-url',
      'title'   => '<span class="user-url">' . __( 'My Profile' ) . '</span>',
      'href'    => esc_url( get_permalink($myAccountPageid) )
    ) );
  //}
}
add_action( 'admin_bar_menu', 'myplugin_customize_toolbar', 999 );
// * Customize the : Top admin bar : 
?>
