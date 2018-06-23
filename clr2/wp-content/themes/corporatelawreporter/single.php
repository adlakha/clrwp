<?php
/*
 * Call the header
 *  */
get_header();
?>
<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row">
        <section class="col-sm-8 left-manageheight">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix ">
                    <?php
                 // echo "hi working ";

                    if (have_posts()):
                        while (have_posts()):the_post();
                           $authorid = get_the_author_meta('ID');

            /*
						 *Special feature
						 * Profile image pickup from linkedin : So at least one time,you need to login via linkedin profile 
						 */
				// $profile_image = eminds_get_user_image('linkedin_profile_image',$authorid);
				// $linkedin_link = eminds_get_user_image('linkedin_profile_url',$authorid);
				// $flag_profile  = get_user_meta($authorid, 'exclude_linkedin_image', TRUE);
							    
							
						 $org_image = eminds_get_user_image('upload_organisation_image',$authorid);
								//check the flag :Need linkedin profile or uploaded profile.
						$profile_image = eminds_get_user_image('upload_profile_image',$authorid);	
							

                      if(empty($profile_image)){
                       $profile_image = get_stylesheet_directory_uri()."/images/dummy-profile-pic.jpg";   
                      }
                      $designation   = get_user_meta($authorid,'designation',TRUE);
				
                      $desc          = get_user_meta($authorid,'description',TRUE);
				          $website_url     = get_the_author_meta('user_url',$authorid);
				
                      $authorName    = get_the_author_meta('display_name');
                      $authorURL     = get_author_posts_url(get_the_author_meta('ID'));
                      
			if(!empty($org_image)){
                     ?>
                     <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                     <img src="<?php echo $org_image; ?>" title='<?php echo $authorName; ?>' alt="image" />
                     </a>      
                       <?php } ?>            
                      <h1 class="post-title">
                      	<a href="<?php the_permalink(); ?>" class="article-title orange"><?php the_title(); ?></a>
                      </h1>

                      <section class="about-post">
                          <section class="author-org-logo fr">
				 <?php
				  /*
                          *Post sharing in right direction
                          */
                          get_template_part('post','sharing-right');
						?>
                          </section>

                          <section class="post-nav clearfix author-org-logo">
                              <ul>
                              	<li>
                              		<?php 
                              		    $authorid = get_the_author_meta( 'ID' );
                                     echo eminds_author_name_modifydesign($authorid);
                              		?>
                              	</li>
                                   <li><span>in </span> <?php the_category(","); ?></li>
                                  <?php 
                                  $contentType = eminds_get_post_content_type(get_the_ID());
							if(!empty($contentType)){
                                  ?> 
                                  <li><span>as </span> <?php echo $contentType; ?></li>
                                  <?php } ?>
                                  <li class="border-none"><span> 
                                          <?php
                                          /*
                                           * Special Feature
                                           * We need to show the date as :Hours > Yesterday > Date 
                                           */
                                          $postDate = get_the_time('U');
                                          echo eminds_date_feature($postDate);
                                          // the_time('F j, Y'); 
                                          ?>
                                      </span></li>
                              </ul>
                          </section>
                      </section>
                     <div class="clearfix"></div>
                      <?php 
                       /*
				  *Google top advertisement code : from Theme options 
				  */
				  get_template_part("advertisement","topsingle");
                       ?>
                        
                      <div class="single-content clearfix" id="wpsinglepostcontent">
                      	
					<?php
					//search_content_highlight();
					 the_content();
					 ?>
                      <?php 
                       /*
				  *Google top advertisement code : from Theme options 
				  */
				  get_template_part("advertisement","bottomsingle");
                       ?>
                      <?php 
					/*
					 *Add the tags   
					 */
					 get_template_part('default','tags');
					?>  
                      </div>
                      <?php 
                      //call the follow us template 
                      get_template_part('sharing','bottom'); 
                      ?>
                      <?php
                  endwhile;
              endif;
              ?>  
          </section>
                <!-- end post -->
                <section class="about-author">

                    <section class="imgb fl">
					<?php 
					        	//check the flag :Need linkedin profile or uploaded profile.
						if($flag_profile){
							?>
							  <img src="<?php echo $profile_image; ?>" width="180" alt="profile image" />
							<?php
						       }else{
							?>
							<a href="<?php echo $linkedin_link; ?>" target="_blank">
							  <img src="<?php echo $profile_image; ?>" width="180" alt="profile image" />
							  </a>
							<?php
					          	}
					        	?>
					        	<p> About <a href="<?php echo $authorURL; ?>"><?php echo $authorName; ?></a> </p>                   
					      </section>

                    <section class="txtb">
                        <h4><a href="<?php echo $authorURL; ?>"><?php echo $authorName; ?> <?php  echo ($designation)?" | $designation":""; ?></a></h4>
                         
                        <?php echo wpautop($desc); ?>
                         
                     <?php 
                        //follow author information.
                        get_template_part('follow','author');
                        ?>
                        
                    </section>

                    <div class="clearfix"></div>
                    <section class="post-nav clearfix">
                        
                    </section>
                  
                </section>
                <section class="comment-column">
                    <?php comments_template(); ?>
                </section>  
                  <?php 
                      //related article
                      get_template_part('related','article');
                      ?>
            </section>
        </section>
        <?php
        //get  the sidebar
        get_sidebar();
        ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>
