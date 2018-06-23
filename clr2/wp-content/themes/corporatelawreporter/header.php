Report to the Central Government

See rule 13(2)(f) of the Companies (Audit and Auditors) Rules, 2014<?php 
/*
 *Header default template file
 * Related posts :http://stackoverflow.com/questions/6329116/wordpress-similar-related-posts-by-title 
 * Email server : http://www.html-form-guide.com/email-form/php-script-not-sending-email.html
 * Protect content copy : http://w3lessons.info/2013/10/28/secure-web-page-content-using-jquery/
 */
 //****************************************** LINKEDIN FUNCTION start **************************
 @session_start();
/*
 *Linkedin login  
 */
 //print_R($_SESSION);
if(isset($_SESSION['linkedin'])){
    
 //collect all the values.
    $linkedinid = $_SESSION['linkedin_id'];
    $useremail  = $_SESSION['user_email'];
    $displayname= $_SESSION['formattedName'];
    $profileimg = $_SESSION['pictureUrl'];
    $profileurl = $_SESSION['publicProfileUrl'];   
    
	    //extra field
    $linked_fname = $_SESSION['linkedin_firstname'];   
    $linked_lname = $_SESSION['linkedin_lastname'];   
    
	
    $userlogin =0;
    /*
     * 1: We will check it is a new user or not.
     * 2: If it is a new user then create a new account.
     * 3: After that we will create wp session for sign on. 
     */
    if(!eminds_is_previously_loggedin($useremail)){
       //create a new user.
             //we will take : password : linkedin id :
            $pass  = $linkedinid;
           $userid_wp = eminds_create_new_user($useremail,$pass,$linked_fname);
           $userlogin = $useremail;
    }else{
          //Get the user login name : 
         $userlogin  = eminds_user_info_via_email($useremail,$column='user_login');   
         $userid_wp  = eminds_user_info_via_email($useremail,$column='ID');   
          $pass      ="anypasswordid" ;
        }
       /*
         * Generate wordpress session : Loggedin user session.
         */
        //unset it's session.
        unset($_SESSION['linkedin']); 
        $redirecturl =LINKEDIN_REDIRECT_URI;
        
        //save/update loggedin user info : Linkedin profile image : linkedin profile public URL.
        update_user_meta($userid_wp ,"linkedin_profile_image",$profileimg);
        update_user_meta($userid_wp ,"linkedin_profile_url",$profileurl);
		
		        //extra information updated
       update_user_meta($userid_wp ,"linkedin_firstname",$linked_fname);
       update_user_meta($userid_wp ,"linkedin_lastname",$linked_lname);
       update_user_meta($userid_wp ,"linkedin_email",$useremail);
       update_user_meta($userid_wp ,"linkedin_displayname",$displayname);
        //0*************end
        eminds_wp_user_session($userlogin,$redirecturl);
      //refresh on page.
      
}
 //****************************************** LINKEDIN FUNCTION END **************************
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
		<title>
		<?php 
	     if(is_home() || is_front_page()){
	    	echo get_option('blogname').' | '.get_option('blogdescription');
	    }else{	
		  wp_title( ' | '.get_option('blogname'), true, 'right' );
		}
		
		//header meta
		header("Content-Type: text/html; charset=utf-8");
		?>
		</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-touch-icon.png">
		<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/sharethis.js"></script>
<!-- Sharethis -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript">stLight.options({publisher: "ca4055a9-d685-4dba-a117-a3455471307b", doNotHash: false, doNotCopy: true, hashAddressBar:false});</script>
<!-- send message to the author  : author.php :message icon : -->
<!-- send message to the author -->
<?php 
//call the onload poup functionality
get_template_part("onload","popup");
?>
<!-- Sharethis -->
<!-- pRINT end -->
<!--
disable copy feature: Enable the notification.	
-->
<script>
function cursorMouseDown(){
   $(this).css("background","red");
	return false;
}
</script>
<!--[if lt IE 9]>
<script src="http://html5shiv-printshiv.googlecode.com/svn/trunk/html5shiv-printshiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="http://maps.googleapis.com/maps/api/js"></script>
	</head>

<?php 
/*
 *Special Feature
 * We will disable the copy feature and allow only - admin and author role user only. 
 */
 
 $NotAllowedCopyFeature = "onmousedown='return true;' onselectstart='return false;' oncontextmenu='return false;'  ";
 
 if(is_user_logged_in()){
 	
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	//allow for author and administrator
	if(in_array($user_role,array("author","administrator"))){
   		$NotAllowedCopyFeature = "";
	}	
 }
?>
 <body <?php body_class(); ?> <?php echo $NotAllowedCopyFeature; ?>   >
	<!--	<div>-->
			<!-- start header top -->
			<nav class="header-top full-width index5 position-rel-none">
				<section class="container-fluid">
					<section class="row">
						<section class="col-sm-7">
							<section class="category-nav fl position-rel">
								<a href="javascript:void(0);" class="menu-icon menu-icon-left display-b"></a>
								
							<?php 
                                                        //dropdown menu
                                                        wp_nav_menu(array(
                                                                   'menu_id'   =>'', 
                                                                   'menu_class'=>'display-n position-abs leftdropdown', 
                                                                   'container' =>'', 
                                                                   'theme_location'=>'primary', 
                                                                    ));
                                                        ?>
								
							</section>
							<section class="fl home-icon">
								<a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home.png"/></a>
							</section>
							<section class="top-nav">
							
                                                       <?php 
                                                        wp_nav_menu(array(
                                                                   'menu_id'   =>'', 
                                                                   'menu_class'=>'margin-none desktop-view', 
                                                                   'container' =>'', 
                                                                   'theme_location'=>'header', 
                                                                    ));
														//mobile view
														?> 
											<span class="glyphicon glyphicon-search fr mobile-search-icon mobile-view" aria-hidden="true"></span>
														<?php
														  wp_nav_menu(array(
                                                                   'menu_id'   =>'', 
                                                                   'menu_class'=>'margin-none mobile-view', 
                                                                   'container' =>'', 
                                                                   'theme_location'=>'mobile', 
                                                                    ));			
                                                        ?> 
							</section>
							<section class="follow-us fl header-followus">
						 <?php 
						 //call the social values.
						 $followtxt=clr_of_get_option('follow_text');
						 $followtxt=(empty($followtxt))?"Follow Us":$followtxt;
						 $fb_link = clr_of_get_option('facebook_link');
						 $tt_link = clr_of_get_option('twitter_link');
						 $rrs_link= clr_of_get_option('rss_link');
						 $gp_link = clr_of_get_option('gplus_link');
						 $li_link = clr_of_get_option('linkedin_link');
						 ?>		
								<ul class="margin-none">
								<!--	<li class=""><a href="javascript:void(0);"><?php echo $followtxt; ?></a></li> -->
								<li class=""></li>
									<?php if(!empty($fb_link)){ ?>
									<li class="fb"><a target='_blank' href="<?php echo $fb_link; ?>"></a></li>
									<?php }if(!empty($tt_link)){ ?>
									<li class="twitter"><a target='_blank' href="<?php echo $tt_link; ?>"></a></li>
									<?php }if(!empty($rrs_link)){ ?>
								<!--	<li class="rss"><a target='_blank' href="<?php echo $rrs_link; ?>"></a></li> -->
									<?php }if(!empty($li_link)){ ?>
									<li class="linkedin"><a target='_blank' href="<?php echo $li_link; ?>"></a></li>
									
									<?php }if(!empty($gp_link)){ ?>
									<li class="google"><a target='_blank' href="<?php echo $gp_link; ?>"></a></li>
									<?php }?>
								</ul>
								
								<div class="clearfix"></div>
							</section>
						</section>
						<section class="col-sm-5 ">

						<?php
						//submit article link
	$submit_article_pid = clr_of_get_option("submit_article_page");
	// for exixting users Update account -5th october
	$update_account_pid = clr_of_get_option("update_account_page");

						if ( is_user_logged_in() ) {
	?>									
			   <!-- <a class="logout register-link fr" href="<?php echo wp_logout_url(get_permalink(get_the_ID())); ?>">Logout</a><a href="javascript:void(0);" class="logout register-link fr setting-icon display-b">&nbsp;</a> -->    	 
			<?php 
			$current_user = wp_get_current_user();
			$displayname  = $current_user->display_name;
			?>
			
			
			<div class="category-nav padding-none position-rel fr">

				<a href="javascript:void(0);" class="logout register-link fr setting-icon display-b">Hi, <?php echo $displayname; ?></a>
			<ul class="dropdown-setting-menu display-n position-abs rightdropdown">
				<li><a href="<?php echo get_permalink($submit_article_pid); ?>">My Account </a></li>
				<li><a href="<?php echo admin_url('post-new.php'); ?>">Submit Article</a></li>
				<li><a href="<?php echo admin_url('profile.php'); ?>">Edit Profile</a></li>
				<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><?php _e('Order Summary','woothemes'); ?></a></li>
				<li><a href="<?php echo wp_logout_url(get_permalink($submit_article_pid)); ?>">Logout</a></li>
			<!-- // for users Update account MEnu item-5th oct + 7th oct change removed tagret -->
				<li><a href="<?php echo get_permalink($update_account_pid); ?>" >Update ScratchCard </a></li>
				
			</ul>						
		   </div>					

	         	 
	<?php
} else {
	?>
	<a href="<?php echo get_permalink($submit_article_pid); ?>" class="submit-article register-link fr"><?php echo get_the_title($submit_article_pid); ?></a>
	<?php
}	?>
<!-- october 8th - Changes For NotLogged In user to show book Icon -->

			 <section class="fl book-icon " id="emindsbook" style="display:none">
<a id="" href="<?php echo get_template_directory_uri();?>/submit-article/?action=register" class="fr">
<img src="<?php echo get_template_directory_uri();?>/images/book_user.png">
</a>
</section>
<!-- october 8th -  Changes For NotLogged In user-->
							<section class="search fr desktop-view">
								<form method="GET" action="<?php echo get_bloginfo('url'); ?>">	
								<div class="input-group">
									<i class="mobile-view search-cross"></i>
									<input type="text" name="s" class="form-control searchbox" placeholder="Enter Keyword or Section No. of CA2013" value="<?php echo get_search_query(); ?>">
									<span class="input-group-btn">
										<button class="btn btn-default border-none wp_searchbutton" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button> 
									</span>
								</div>
		                        </form>	
							</section>
						</section>
					</section>
				</section>
			</nav>
	
<!-- outer div : it will close in footer -->
<div class="outer-container">  			
			<!-- end header top -->
			<!-- start header -->
		<header class="header">

			<section class="container-fluid">
				<section class="row">
						<section class="col-sm-3">
							<section class="logo">
							<?php 
							$logoURL = clr_of_get_option("header_logo");
							if(empty($logoURL)){
							$logoURL = get_stylesheet_directory_uri()."/images/logo.png";	
							}
							?>	
								<a href="<?php echo get_bloginfo('url'); ?>" title="Corporate Law Reporter">
									<img src="<?php echo $logoURL; ?>" width="325px" alt="Corporate Law Reporter" />
								</a>
								</section>
						</section>
						<section class="col-sm-9">
							<section class="top-advertise fr">
								<?php 
								//advertisement code for header
								echo clr_of_get_option("google_advertise_codefor_header");
								?>
								
							</section>
						</section>
						<div class="clearfix"></div>
					
				</section>
			</section>
			</header>
<!-- jquery changes on 8th Oct For NotloggedIn user -->			
<script>
jQuery(document).ready(function($){
      <?php if(!is_user_logged_in()){ ?>
       
        $("#emindsbook").show();
        <?php }?>
    
    
});
</script>