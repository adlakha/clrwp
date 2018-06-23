<?php
/*
 *Template Name:Corporate Form Download
 */
 
get_header();
?>
<!-- end header -->
<section class="container-fluid double-sticky">
    <section class="row position-rel">
        <section class="col-sm-12">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix">
                    
                    <strong class="main-heading display-b">
                    	<?php the_title(); ?>
                    	 <?php
					  /*
                       *Post sharing in right direction
                       */
                       get_template_part('post','sharing-right');
						?>
                    </strong>
                    <?php 
                    if(have_posts()):
                        while (have_posts()):the_post();
                    $imgHTML=eminds_get_thumbnail_html_with_customsize(get_the_ID(),'full',"thumbnailimage");
                    if(!empty($imgHTML)){
                    ?>
                     <section class="full-view-advertise fl"> 
                          <?php echo $imgHTML; ?>
                     </section>
                     <div class="clearfix"></div>  
                    <?php } ?>
                     <?php the_content(); ?>
                  <?php 
                    endwhile;
                  endif;
                  ?>
                  
                </section>
                <!-- end post -->
            </section>
        </section> 
    
    </section>
 <!--  ************************ ********* Content ************************************************************** -->
                     <div class="row sticky-table-header">
                     	<div class="inner-table-header">
                            <div class="col-md-1 font-16 align-center"><strong>Type of Form</strong></div>
                            <div class="col-md-1 font-16 align-center"><strong>Form No.</strong></div>
                            <div class="col-md-3 font-16 align-center"><strong>Form Title</strong></div>
                            <div class="col-md-4 font-16 align-center"><strong>Description</strong></div>
                            <div class="col-md-1 font-16 align-center"><strong>Download</strong></div>
                            <div class="col-md-2 font-16 align-center"><strong>Form version updated on</strong></div>
                            </div>
                        </div>
                       <hr/> 
   <?php
   
                    $cat_ca2013 = get_terms('act_chapter', array(
                        'orderby' => 'none',
                        'hide_empty' => 1,
                    ));
//taxonomy loop start here
                    if ($cat_ca2013) {
                        foreach ($cat_ca2013 as $cat) {
                            $catname = $cat->name;
                            $catid = $cat->term_id;
                            $slug = $cat->slug;
   
   //post type query for loop category : 
                                $args = array(
                                    'post_type'      => 'chapter_form',
                                    'posts_per_page' => -1,
                                    'order'          => 'ASC',
                                    'meta_key'       => 'form_number_caform',
                                    'orderby'        => 'meta_value_num menu_order',
                                    'tax_query' => array(
											array(
												'taxonomy' => 'act_chapter',
												'field'    => 'slug',
												'terms'    => $slug,
											),
										),
                                );
                                $query = new WP_Query($args);
                                if ($query->have_posts()):
							//show the category name.		
									?>
					    <div class="row">
                            <div class="col-md-12 margin-top-15"><strong><?php echo $catname; ?> - <?php echo clr_get_field_for_category('ente_the_sub_title', $catid); ?> </strong> </div>
                        </div>		
									
									<?php
                                    $inc =1;
                                    while ($query->have_posts()) : $query->the_post();
                                
                                $rowcolor = ($inc%2==0)?"#FCFCFD":"#F6F6F7";
                                        ?>       
 

                     <div class="row margin-bottom aligncenter" style="background:<?php echo $rowcolor; ?>">
                     <div class="col-md-1 font-16">
                     	<!-- Eform/NonEform  -->
                     	 <?php echo get_post_meta(get_the_ID(),'type_of_form',TRUE); ?>
                    </div>
                     <div class="col-md-1 font-16">
                     	<!-- Form number  -->
                     	<a href="<?php the_permalink(); ?>">
                     	 <?php echo get_post_meta(get_the_ID(),'form_number_caform',TRUE); ?>
                     	 </a>
                    </div>
                          <?php 
                          $downloadfile = "";
                          /*
						   *Priority to download
						   * 1: UPLOADED file , 2 : URL of file.
						   */
						   $downloadfile ="";
						   $fileupload= get_field('upload_the_zip_file_',get_the_ID()); 	
						   $urlupload = get_post_meta(get_the_ID(),'enter_the_url_of_the_zip_file',TRUE);
						   
						  if(!empty($fileupload)){
						      $downloadfile = $fileupload;	
						      }else{
						    $downloadfile = $urlupload;	
						   }
							  
						  ?>
                          <div class="col-md-3 font-16">
                          	 
                          	  <a href="<?php the_permalink(); ?>" ><?php echo get_post_meta(get_the_ID(),'form_subtitle_forms',TRUE); ?></a> 	
                          	
                          	 </div>
                          	
                          <div class="col-md-4"><p class="font-16"><?php echo get_post_meta(get_the_ID(),'description_of_form',TRUE); ?></p></div>
                           
                           <div class="col-md-1">
                          	 	<!-- 
                          	 	uploading icons : selected to show : word or PDF 	
                          	 	-->
                          	 	<?php
                          	 	 if(!empty($downloadfile)){
                          	 	 $iconType = get_post_meta(get_the_ID(),"icons_cffo",TRUE);
								 //select the icon filename
								 $icon_name = "pdf.png";
								 $icon_name =($iconType == "PDF")?"pdf.png":"word.png";
									 ?>
                          	 	<a href="<?php echo $downloadfile; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/<?php echo $icon_name; ?>" alt="image" /></a>
                          	 	<?php } ?>
                          	 	<?php 
						          /*
								   *New Feature : Edit link - when administrator login. 
								   */
								  echo admin_edit_link(get_the_ID());
						            ?>
                          	 	 </div>
                          	 	 
                          <div class="col-md-2 font-16">
                           <!-- version updated on -->
                           	<?php echo get_field('form_version_updated_on',get_the_ID()); ?>
                          </div>
                        </div>
                              <?php 
                              ++$inc;
                              endwhile;
                              endif;
                              wp_reset_query();
                              ?>
            <?php 
                        }
                    }
 ?>
         
 <!--  ********************************* Content ************************************************************** -->  
                  
                  
   
</section>

<!-- start footer -->
<?php
get_footer();
?>