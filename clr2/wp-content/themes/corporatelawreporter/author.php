<?php
/*
 *Author default template file 
 */
get_header();
?>
<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row">
        <section class="posts-content author-detail">
             
        <section class="col-sm-3">
<section class="about-author">
    <?php
    $authorid="";
   
   $authorarr = get_user_by( 'slug', get_query_var( 'author_name' ) );
   $authorid  = $authorarr->ID; //print_r($authorarr);
		
	$uemail   = $authorarr->user_email;//get_the_author_meta('user_email');
    $displayName= $authorarr->display_name;//get_the_author_meta('display_name');

    /*
	 *Special feature
	 * Profile image pickup from linkedin : So at least one time,you need to login via linkedin profile 
	 */
	// $profile_image = eminds_get_user_image('linkedin_profile_image',$authorid);
	// $linkedin_link = eminds_get_user_image('linkedin_profile_url',$authorid);
 //  $flag_profile  = get_user_meta($authorid, 'exclude_linkedin_image', TRUE);
    

  $org_image = eminds_get_user_image('upload_organisation_image',$authorid);
	//check the flag :Need linkedin profile or uploaded profile.
	// if($flag_profile){
	// $profile_image = eminds_get_user_image('upload_profile_image',$authorid);	
	// }
 
   /*
    * Condition Changed :we will show only :uploaded profile pic : not linkedin or anything. 
    //******** so override this variable
    : $profile_image :
    */
    $profile_image = eminds_get_user_image('upload_profile_image',$authorid);



    if (empty($profile_image)) {
        $profile_image = get_stylesheet_directory_uri() . "/images/dummy-profile-pic.jpg";
    }

    $designation = get_user_meta($authorid, 'designation', TRUE);
	  $organization= get_user_meta($authorid, 'organization', TRUE);
	  $qualification= get_user_meta($authorid, 'qualification', TRUE);
    $desc = get_user_meta($authorid, 'description', TRUE);
    $authorName = $displayName;
    $authorURL = get_author_posts_url($authorid);

    /*
    * Functionality : 22nd Sep 2016 
    if user check to private then don't show this information publically.
    */
    $mob      = "";
    $tel      = "";
    $address  = "";

   if(!get_user_meta($authorid,'check_for_mobile_number_private',true))
    $mob = get_user_meta($authorid, 'phone', TRUE);
   
    if(!get_user_meta($authorid,'check_for_telephone_number_private',true))
    $tel = get_user_meta($authorid, 'enter_the_telephone_number', TRUE);

    if(!get_user_meta($authorid,'check_for_address_private',true))
    $address = get_user_meta($authorid, 'address', TRUE);

    $city = get_user_meta($authorid, 'city', TRUE);
    $state = get_user_meta($authorid, 'state', TRUE);
    $country = get_user_meta($authorid, 'country', TRUE);
    //implement the profile pic
    if (!empty($profile_image)) {
        ?> 
                
        <section class="imgb author-epoints">
   
		  <img class="author-profile-pic" src="<?php echo $profile_image; ?>" width="180" alt="profile image" />
		
            <div class="clearfix"></div>
            <span class="author-point-text">ePoints : <strong class="author-point"><?php echo count_user_posts($authorid);?></strong></span>
            <?php if(is_user_logged_in() ){
            	    global $current_user;
                      get_currentuserinfo();
                      $loginid = $current_user->ID;
					if($authorid ==  $loginid){  
				 ?>
            <span class="author-point-text"> | <a href="<?php echo admin_url('profile.php'); ?>" class="author-point">Edit Profile</a></span>
            <span class="author-point-text"> | <a href="<?php echo admin_url('post-new.php'); ?>" class="author-post">Submit Article</a></span>
            <?php }
            }
		 ?>
        </section>
    <?php } ?>
    <br/>
    <section class="txtb padding-none">
        <h4>
            <a href="<?php echo $authorURL; ?>"><?php echo $authorName; ?> <span class="display-b"><?php echo $designation; ?></span> </a>
            <a href="javascript:void(0)"><?php echo $organization; ?></a>
        </h4>
        <?php
        //description
        echo wpautop($desc);
   //display the qualification
		if($qualification){
        ?>
       <p><strong class="display-b">Qualification : </strong><?php echo $qualification; ?></p>
       <?php } ?>
        
        <p>
          <?php if($tel || $mob){ ?>	
        	<strong class="display-b"> Contact Details <a href="<?php echo admin_url('profile.php'); ?>" class="author-point" style="font-weight:normal;">Edit Contact</a> </strong>
            <?php if (!empty($tel)) { ?>
                 <strong class="display-inline">T:</strong> <?php echo $tel; ?> 
            <?php } if (!empty($mob)) { ?><br/>
                <strong class="display-inline">M:</strong> <?php echo $mob; ?>
            <?php
             }
             }//both condition.
             ?>
            <br>
           <?php if($address){ ?> 
            <strong class="display-inline">A:</strong><?php echo $address; ?>
            <?php } ?>
            <?php
            if (!empty($city)) {
                echo $city . ', ';
            }
            if (!empty($state)) {
                echo $state . ', ';
            }
            if (!empty($country)) {
                echo $country;
            }
            ?>
        </p>
<?php
//follow author information.
get_template_part('follow', 'author');
?>
    </section>
    <div class="clearfix"></div>

</section>
</section>
<section class="col-sm-5 left-manageheight ">

    <?php
  global $wp_query;
  //$totalposts = $wp_query->found_posts;	
		if(have_posts()){
	     ?>
     <strong class="main-heading display-b"> Articles by <?php echo $displayName; ?></strong>
         <?php		
        while (have_posts()): the_post();

            $authorName = get_the_author_meta('display_name');
            $authorURL = get_author_posts_url(get_the_author_meta('ID'));
            ?>

            <!-- start post -->
            <section class="post-column clearfix">
                <h2 class="margin-btm-none"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <section class="post-nav clearfix">
                <!--    <a class="author-name fr" href="<?php echo $authorURL; ?>">By <?php echo $authorName; ?></a>-->
                    <ul>
                        <li><?php the_category(","); ?></li>
                        <li><?php echo eminds_get_post_content_type(get_the_ID()); ?></li>
                        <li class="border-none">
                            <?php
                            /*
                             * Special Feature
                             * We need to show the date as :Hours > Yesterday > Date 
                             */
                            $postDate = get_the_time('U');
                            echo eminds_date_feature($postDate);
                            // the_time('F j, Y'); 
                            ?>
                        </li>
                    </ul>
                </section>
            <?php echo eminds_excerpt_content(get_the_ID()); ?>
            <?php 
			/*
			 *Add the tags   
			 */
			 get_template_part('default','tags');
			?>
            <?php
            //call the post sharing options
            get_template_part("post", "sharing");
            ?>
            </section>
            <!-- end post -->						
            <?php
        endwhile;
        
         if (function_exists('wp_pagenavi')) {
             ?>
        <section class="pagination">    
        <?php
        wp_pagenavi();
        ?>
        </section>
            <?php
    }
 
//loop if condition :main.  
}else{
//this file works when author have no post.
 get_template_part("author","no-post");
}
wp_reset_query();
?>
</section>
                
                <!-- end post -->						
        </section>
        <?php get_sidebar(); ?>
      
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>