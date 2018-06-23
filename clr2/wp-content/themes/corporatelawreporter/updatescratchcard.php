<?php
/*
 *Scratch Code Update  template file for existing user
 5 th october
 */
 get_header();
 ?>
			<!-- end header -->
			<section class="container-fluid middle-container">
				<section class="row">
					<section class="col-sm-8 left-manageheight">
						<section class="posts-content">
					   <!--  Loop wp start here -->		
					   <?php
					   $inc =1; 
					    if(have_posts()):
							while(have_posts()): the_post();
							
							$className = "";//($inc ==1) ? "margin-top-none":"";
							
							 /*
							  *We will add the google adsensecode after 1st post. 
							  *1 more extra work-
							  * we will remove the border of 1st block .
							  */
							  if($inc ==2){
							  $addsenseCode_home = clr_of_get_option("google_advertise_codefor_homepage_before2ndpost");
							  echo "<div class='addsenseCode'>".$addsenseCode_home."</div>";	  	
					          } ?>
					   <!-- start post -->
							<section class="post-column clearfix <?php echo $className; ?>  <?php echo ($inc==1)?"border-none":""; ?>  ">
						
								<h2 class="margin-btm-none"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<?php
									//echo eminds_is_event_expire(get_the_ID());
									echo clr_event_expire_key(get_the_ID());
									 ?>		
									
								</h2>
								
								<?php 
								/*
								 *Author information and organisation image 
								 */
								 get_template_part('default-authorinfo','orgimg');
								?>	
								<?php echo eminds_excerpt_content(get_the_ID()); ?>
								<?php 
								/*
								 *Add the tags   
								 */
								 get_template_part('default','tags');
								?>
								<?php get_template_part('post','sharing'); ?>
							</section>
							<?php 
							++$inc;
                          endwhile; ?>
						  <!-- start pagination -->
	                      <?php 
	                      get_template_part('post','pagination');
	                      ?>
							<!-- end pagination -->
							<?php
                          endif;
					    ?>
							
							
							
							<!-- end post -->
	
						</section>
					</section>
					<?php 
					/*
					 *Call the sidebar 
					 */
					 get_sidebar();
					?>
				</section>
			</section>

			<!-- start footer -->
<?php 
/*
 *call the footer 
 */
 get_footer();
?>