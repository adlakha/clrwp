<?php
/*
 *Template Name: Book preview
 *  */
// /get_header();
?>
<!DOCTYPE html>
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
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

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
//get_template_part("onload","popup");
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
 * We will disable the copy feature and allow only - admin and authore role user only. 
 */
 
 $NotAllowedCopyFeature = "onmousedown='return false;' onselectstart='return false;' oncontextmenu='return false;'  ";
 
 if(is_user_logged_in()){
 	
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	//allow for author and administrator
	if(in_array($user_role,array("author","administrator"))){
   		//$NotAllowedCopyFeature = "";
	}	
 }
?>


 <body <?php body_class(); ?> <?php echo $NotAllowedCopyFeature; ?>   >
<div class="outer-container" >  			
<!--
Top header should be orange	
 -->
 <style>
 .top-nav li.menu-item-type-post_type.menu-item-34575 a{color:#fc8b01;}
 </style>
<!-- end header -->
<section id="printable" class="container-fluid middle-container" style="background: none;">
    <section class="row">
        <section class="col-sm-12 left-manageheight">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix  ">
                    <?php
                    
               $getperpage = get_post_meta(get_the_ID(),"select_the_posts_per_page_section",TRUE);
                 if(empty($getperpage)){
                 $getperpage = 9;	
                 }   
				 
				 $catIN = get_post_meta(get_the_ID(),"select_the_chapter_forpreview",TRUE);
                    //print_r($catIN);
                    
                    $argsPrev=array(
                                     'posts_per_page'=>"$getperpage",
                                      'post_type' =>'companies_act',
                                      'order'          => 'ASC',
                                      'meta_key'       => 'enter_the_section_no_ca_post',
                                      'orderby'        => 'meta_value_num menu_order',
                                      'tax_query' => array(
											array(
												'taxonomy' => 'act_chapter',
												'field'    => 'term_id',
												'terms'    => $catIN,
												'operator' => 'IN',
											),
										),
					                );
                  $qq = new WP_Query($argsPrev);  
                    if ($qq->have_posts()):
                        while ($qq->have_posts()):$qq->the_post();
                            $authorid = get_the_author_meta('ID');

                            $org_image     = eminds_get_user_image('eminds_user_organisation_image',$authorid);
                            $profile_image = eminds_get_user_image('eminds_user_profile_image',$authorid);
                           
                            if(empty($profile_image)){
                            $profile_image = get_stylesheet_directory_uri()."/images/dummy-profile-pic.jpg";   
                                  }
                                  
                            $designation   = get_user_meta($authorid,'designation',TRUE);
                            $desc          = get_user_meta($authorid,'description',TRUE);
                            $authorName    = get_the_author_meta('display_name');
                            $authorURL     = get_author_posts_url(get_the_author_meta('ID'));
                             ?>
                     <div class="single-pagination clearfix">
			                <div class="fl prev">
			                	<?php //previous_post_link('<strong>%link</strong>',"",FALSE); ?>
			               </div>
			               <div class="fr next"> 	
			                <?php //next_post_link('<strong>%link</strong>',"",FALSE); ?>  
			    	        </div>
			    	        <div class="clearfix"></div>
    	            </div>
                             
                             <?php 

                            if (!empty($org_image)) {
                                ?>
                                <section class="author-org-logo">
                                    <img src="<?php echo $org_image; ?>" alt="Profile image" /> 
                                </section>
                            <?php } ?>
                             
                    <h1 class="post-title title-small-ca2013">
                    	<a class="orange" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h1>

                            <section class="about-post">
                                <?php 
                               /*
                                *Post sharing in right direction
                                */
                              // get_template_part('post','sharing-right');
                               ?>
                                <section class="jump-to-sectionpage fr">
			                	<?php //echo do_shortcode('[emind_jumpto_form]'); ?>
			                    </section>	
                                <section class="post-nav clearfix">
                                    <ul>
                                         <li class="border-none">
                                         	<i class="orange">
                                                <?php
                                          //section notified date: Remove Effective_date feature
                                         // echo  $effective_date = get_post_meta(get_the_ID(), 'enter_the_section_notified_date_ca_post', TRUE);
                                         /*
										  *New Feature 
										  *1 : Last updated : Show the current updated post and if current updated post > 2 then show only 2 day's.
										  *2 : Add button :Emergency Hide : In theme options for hide this options. 
										  */
										  /*
										   *Admin are able to hide this option when needed. 
										   */
										   $emergency_hide = clr_of_get_option("emergency_hide_ca2013");
										   if($emergency_hide){
										    //echo eminds_lastupdated_ca2013(); 	
										   }
										  
                                       ?>
                                            </i>
                                            </li>
                                    </ul>
                                </section>
                                <?php 
                               /*
                                *Post sharing in right direction
                                */
                               //get_template_part('post','sharing-right');
                                ?>
                            </section>
                            
                                <div class="clearfix"></div>
                             <?php 
                             /*
							  *Google top advertisement code : from Theme options 
							  */
							 // get_template_part("advertisement","topsingle");
                             ?>
                            
                            <div class="single-content clearfix" id="wpsinglepostcontent" >
                            <?php 
                              the_content();
                              //search_content_highlight();
							 ?>
                            <?php 
                             /*
							  *Google top advertisement code : from Theme options 
							  */
							  //get_template_part("advertisement","bottomsingle");
                             ?>
                            <?php 
								/*
								 *Add the tags   
								 */
								// get_template_part('default','tags');
								?>  
                            </div>
                            <?php 
                            //call the follow us template 
                            // /get_template_part('sharing','bottom'); 
                            ?>
                            <?php
                        endwhile;
                    endif;
				wp_reset_query();	
                    ?>  
                </section>
                <!-- end post -->
          
               <!-- <section class="comment-column">
                    <?php comments_template(); ?> 
               </section> -->
                  <?php 
                  /*
				   * Call the sidebar of CA2013. 
				   */
				   //if(is_active_sidebar("ca2013_single_page_widget")){
				   //	dynamic_sidebar("ca2013_single_page_widget");
				  // }
                      //related article
                 //     get_template_part('related','sections');
                      ?>
            </section>
        </section>
        <?php
        //get  the sidebar
//        get_sidebar();
        ?>
    </section>
</section>
</div>
<?php wp_footer(); ?>
<body>
</html>	
<!-- start footer -->
