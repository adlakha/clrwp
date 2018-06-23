<?php
/*
 *Tag default template file 
 */
 get_header();
 ?>
			<!-- end header -->
			<section class="container-fluid">
				<section class="row">
					<section class="col-sm-8">
						<section class="posts-content left-manageheight">
                                <strong class="main-heading display-b default-page-title">
                                  <a class="title-color" href="<?php echo get_permalink(get_query_var('tag')); ?>">
                                	<?php single_tag_title(); ?>
                                  </a> 	
                               </strong>		
					   <!--  Loop wp start here -->		
					   <?php 
					    if(have_posts()):
							while(have_posts()): the_post();
					   ?>		
							
							<!-- start post -->
							<section class="post-column clearfix">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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