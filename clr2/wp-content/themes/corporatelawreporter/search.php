<?php
/*
 *Search default template file 
 */
 get_header();
 ?>
			<!-- end header -->
			<section class="container-fluid middle-container">
				<section class="row">
					<section class="col-sm-8 left-manageheight">
						<section class="posts-content ">
					 <strong class="main-heading display-b default-page-title">
					 	Search Result For : <?php echo get_search_query(); ?>
					 	</strong>		
					 	<?php 
					 	$searchSlug = $_REQUEST['s'];
					 	?>
					   <!--  Loop wp start here -->		
						<?php
						 /*
						 *For adding the advanced functionality : Search by custom field if enter the numeric value .
						 * Special search functionality
						 * 1: When any use the search by section number i.e 175 or 25 only then it will goes on the detail page directly.  
						 */
						 $search_string = get_search_query();
						if(is_numeric($search_string)){
						               $argsSearch11 = array(
													'post_type'  => 'companies_act',
													'meta_query' => array(
														'relation' => 'OR',
														array(
															'key'     => 'enter_the_section_no_ca_post',
															'value'   => intVal($search_string),
															'compare' => '=',
														),
												  ),
												);
						
						query_posts($argsSearch11);
						}
						/*
						 *For adding the advanced functionality : Search by custom field if enter the numeric value . 
						 */ 
						 ?>
					   <?php 
					    if(have_posts()):
							while(have_posts()): the_post();
					   ?>	
					   <?php
						/*
						 * Special search feature fire :
						* Special search functionality
						 * 1: When any use the search by section number i.e 175 or 25 only then it will goes on the detail page directly.  
						 * Now if received any post then it will goes on detail page . 
						 */ 
						if(is_numeric($search_string)){
							
							$idpost = get_the_ID();
							$urlpost= get_permalink($idpost);
						  wp_redirect( $urlpost ); exit;	
						}
						?>	
							
							<!-- start post -->
							<section class="post-column clearfix">
								<h2 class="margin-btm-none"><a href="<?php the_permalink(); ?>?s=<?php echo $searchSlug; ?>"><?php search_title_highlight(); ?></a></h2>
								<?php 
								/*
								 *Author information and organisation image 
								 */
								 get_template_part('default-authorinfo','orgimg');
								?>	
								<?php search_excerpt_highlight(); ?>
								<?php //echo eminds_excerpt_content(get_the_ID()); ?>
								<?php 
								/*
								 *Add the tags   
								 */
								 get_template_part('default','tags');
								?>
								<?php //get_template_part('post','sharing'); ?>
							</section>
							<?php 
                          endwhile; ?>
						  <!-- start pagination -->
	                      <?php 
	                      get_template_part('post','pagination');
	                      ?>
							<!-- end pagination -->
			<?php
			else:
		    ?>
        
      <strong class="not-found" ><?php _e( 'Nothing Found', 'twentytwelve' ); ?></strong>
         <div class="artdetaidisc">        

<!-- Place this tag where you want the +1 button to render. -->

<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
    <hr />
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