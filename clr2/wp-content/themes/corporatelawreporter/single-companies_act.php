<?php
/*
 * Call the header
 *  */
get_header();
?>
<!--
Top header should be orange	
 -->
 <style>
 .top-nav li.menu-item-type-post_type.menu-item-34575 a{color:#fc8b01;}
 </style>
<!-- end header -->
<section id="printable" class="container-fluid middle-container">
    <section class="row">
        <section class="col-sm-8 left-manageheight">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix  ">
                    <?php
                    if (have_posts()):
                        while (have_posts()):the_post();
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
			                	<?php previous_post_link('<strong>%link</strong>',"",FALSE); ?>
			               </div>
			               <div class="fr next"> 	
			                <?php next_post_link('<strong>%link</strong>',"",FALSE); ?>  
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
			                	<?php echo do_shortcode('[emind_jumpto_form]'); ?>
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
										    echo eminds_lastupdated_ca2013(); 	
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
                               get_template_part('post','sharing-right');
                                ?>
                            </section>
                            
                                <div class="clearfix"></div>
                             <?php 
                             /*
							  *Google top advertisement code : from Theme options 
							  */
							  get_template_part("advertisement","topsingle");
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
          
                <section class="comment-column">
                    <?php comments_template(); ?> 
                </section>
                  <?php 
                  /*
				   * Call the sidebar of CA2013. 
				   */
				   if(is_active_sidebar("ca2013_single_page_widget")){
				   	dynamic_sidebar("ca2013_single_page_widget");
				   }
                      //related article
                 //     get_template_part('related','sections');
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