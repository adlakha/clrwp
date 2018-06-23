<?php
/*
 * When user logged in then it will show the profile summary 
 */
?>
<section class="col-sm-3">
<section class="about-author">
    <?php
    $authorid="";
    if(is_user_logged_in()){
    
    global $current_user;
    get_currentuserinfo();
    $authorid = $current_user->ID;
    $uemail = $current_user->user_email;
    $displayName = $current_user->display_name;
	
	}
    else
    {
	$authorid = get_the_author_meta('ID');	
	$uemail   = get_the_author_meta('user_email');
    $displayName= get_the_author_meta('display_name');
	}

    /*
	 *Special feature
	 * Profile image pickup from linkedin : So at least one time,you need to login via linkedin profile 
	 */
	//$profile_image = eminds_get_user_image('linkedin_profile_image',$authorid);
	//$linkedin_link = eminds_get_user_image('linkedin_profile_url',$authorid);
   // $flag_profile  = get_user_meta($authorid, 'exclude_linkedin_image', TRUE);
    

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

    

    if (empty($profile_image)) 
    {
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
     /*october 8th saturday -- Functionality : 8th Oct 2016 
    if user check to private then don't show this information publically. for city, state, country*/

    $city     = "";
    $state    = "";
    $country  = "";


    //*********end  8th oct*********** 

   if(!get_user_meta($authorid,'check_for_mobile_number_private',true))
    $mob = get_user_meta($authorid, 'phone', TRUE);
   
    if(!get_user_meta($authorid,'check_for_telephone_number_private',true))
    $tel = get_user_meta($authorid, 'enter_the_telephone_number', TRUE);

    if(!get_user_meta($authorid,'check_for_address_private',true))
    $address = get_user_meta($authorid, 'address', TRUE);
    /*october 8th saturday -- Functionality : 8th Oct 2016 
    if user check to private then don't show this information publically.*/    

  /*  if(!get_user_meta($authorid,'check_for_city',true))
    $city= get_user_meta($authorid, 'city', TRUE);

    if(!get_user_meta($authorid,'check_for_state',true))
    $state= get_user_meta($authorid, 'state', TRUE);

    if(!get_user_meta($authorid,'ccheck_for_country',true))
    $country= get_user_meta($authorid, 'country', TRUE);*/
//***************End 8th*************


// earlier functionality -- shankranad sir commented on saturday

   $city = get_user_meta($authorid, 'city', TRUE);
   $state = get_user_meta($authorid, 'state', TRUE);
    $country = get_user_meta($authorid, 'country', TRUE);



    //implement the profile pic
    if (!empty($profile_image)) 
    {
        // 8th october Begin --To get the tempalte url from theme options -- LoggedIN
        $update_account_pid = clr_of_get_option("update_account_page");
        // *******end***********
        ?> 

                
        <section class="imgb author-epoints">
     
		  <img class="author-profile-pic" src="<?php echo $profile_image; ?>" width="180" alt="profile image" />
		
        	  <div class="clearfix"></div>
            <span class="author-point-text">ePoints : <strong class="author-point"><?php echo count_user_posts($authorid);?></strong></span>

              <div class="clearfix"></div>
            <?php if(is_user_logged_in()){ ?>
            <!-- Changes on 8th october -loggedIn ***** removed slash added above clear fix div to maintain UI LoggedIN-->
            <span class="author-point-text"> <a href="<?php echo admin_url('profile.php'); ?>" class="author-point">Edit Profile</a></span>
            <span class="author-point-text"> | <a href="<?php echo admin_url('post-new.php'); ?>" class="auth-post">Submit Article</a></span>
            <span class="author-point-text"> | <a href="<?php echo get_permalink($update_account_pid); ?>">Update ScratchCard </a></span>

            <?php } ?>
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
                 <strong  class="display-inline">T:</strong> <?php echo $tel; ?> 
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
<section class="col-sm-5 left-manageheight">
<!-- Functinality Change 10th October 2016 - changes on 10th oct for different message i.e for book user(author)-->

<?php
// to get id of current user logged in
  $authorid = $current_user->ID;
  //  to get matched scratch card of current user loggedin
$usedscratchcardwelcome = eminds_custom_book_user_welcome_message($authorid);
//echo $usedscratchcardwelcome; 

if($usedscratchcardwelcome)
{?>
<p><b class="main-heading display-b">Welcome book user</b></p>

<?php }?>
<!-- *************** End 10th oct ************ Welcome Message for Book User -->

    <?php
    //author posts
    $paged =(get_query_var('paged'))?get_query_var('paged'):"1";
    $query = new WP_Query(array(
                              'author'=>$authorid,
                              'paged'  =>$paged
            ));
    if ($query->have_posts()){
?>

<strong class="main-heading display-b">Articles by <?php echo $displayName; ?></strong>
<?php		
	$totalposts = $query->found_posts;	
		
        while ($query->have_posts()): $query->the_post();

            $authorName = get_the_author_meta('display_name');
            $authorURL = get_author_posts_url(get_the_author_meta('ID'));
            ?>

            <!-- start post -->
            <section class="post-column clearfix">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
        wp_pagenavi(array('query'=>$query));
        ?>
        </section>
            <?php
    }

//main if condition end : 
}else{
 //this file works when author have no post.
 get_template_part("author","no-post");    
}
wp_reset_query();
?>
</section>