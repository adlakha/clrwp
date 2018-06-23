<?php
/*
 *Template Name:Author Listings
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
                            <div class="col-md-3"><strong>Author Name</strong></div>
                            <div class="col-md-4"><strong>Designation</strong></div>
                            <div class="col-md-3"><strong>Organisation</strong></div>
                            <div class="col-md-2"><strong>ePoints</strong></div>
                          </div>  
                     </div>
                       <hr/> 
               <?php
   //write the mysql query to fetch all the author listing whose have at least one posts.
   global $wpdb;
   $sql_authorlist = "SELECT COUNT(p.ID) AS no_of_posts,p.post_author,u.user_nicename,u.user_login,u.display_name FROM `".$wpdb->prefix."posts` AS p INNER JOIN `".$wpdb->prefix."users` AS u ON u.ID = p.post_author WHERE post_status='publish' GROUP BY post_author ORDER BY COUNT(p.ID) DESC";
   $arr_authorlist = $wpdb->get_results($sql_authorlist);
   
   if($arr_authorlist){
   	         $inc =1;
    foreach($arr_authorlist as $author){
   		$authorID   = $author->post_author;
		$epoints    = $author->no_of_posts;
		$display_name= $author->display_name;
		$username   = $author->user_login;
		                        
                                $rowcolor = ($inc%2==0)?"#FCFCFD":"#F6F6F7";
                                        ?>       
 

                     <div class="row author-listing-row margin-bottom aligncenter" style="background:<?php echo $rowcolor; ?>">
                     	
                     <div class="col-md-3">
                     	<!-- nickname  -->
                     	<a href="<?php echo bloginfo('url').'/author/'.$username; ?>">
                     	 <?php echo $display_name; ?>
                     	 </a>
                     </div>
                     
                     <div class="col-md-4">
                     	<!-- designation  -->
                     	<?php echo get_user_meta($authorID,"designation",TRUE); ?>
                     </div>
                    
                    <div class="col-md-3">
                     	<!-- organization  -->
                     	<?php echo get_user_meta($authorID,"organization",TRUE); ?>
                    </div>
                    
                    <div class="col-md-2">
                     	<!-- Epoints  -->
                     	<?php echo $epoints; ?>
                    </div>
                    
                    
                                              
                        </div>
                              <?php 
                              ++$inc;
    	}
	
   }
                              ?>
   
         
 <!--  ********************************* Content ************************************************************** -->  
                  
                  
   
</section>

<!-- start footer -->
<?php
get_footer();
?>