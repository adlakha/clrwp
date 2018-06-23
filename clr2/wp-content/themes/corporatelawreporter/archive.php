<?php
/*
 *Archive default template file 
 */
 get_header();
 ?>
			<!-- end header -->
			<section class="container-fluid middle-container">
				<section class="row ">
					<section class="col-sm-8 left-manageheight">
						<section class="posts-content">
					<strong class="main-heading display-b">
					 	<?php
					 						if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'eminds' ), get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'eminds' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'eminds' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'eminds' ), get_the_date( _x( 'Y', 'yearly archives date format', 'eminds' ) ) );
					else :
						_e( 'Archives', 'eminds' );
					endif;
				?>  
					 </strong>		
					   <!--  Loop wp start here -->		
					   <?php 
					    if(have_posts()):
							while(have_posts()): the_post();
					   ?>		
							
							<!-- start post -->
							<section class="post-column clearfix">
								<h2 class="margin-btm-none"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                            <?php 
								/*
								 *Author information and organisation image 
								 */
								 get_template_part('default-authorinfo','orgimg');
								?>	
								<?php echo eminds_excerpt_content(get_the_ID()); ?>
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