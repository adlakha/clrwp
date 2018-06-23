<?php
/* 
 * Preview options
 */
/*
 * Get all the values. 
 */
$output ="";
//start the session
if (!session_id()){
  session_start();
}

 $allcategory = array();
                        $categorypost = array();
                      $topics = get_option('eminds_newsletter_selectedposts');//$_POST['topics'];//print_r($topics);
                      if(count($topics)>0){
                          foreach($topics as $topic){
                            $postid = $topic;  
                            
                            $terms = wp_get_post_terms($postid,'category' ); //print_r($terms);
                            $termid= 0;
                            /*
                             * Need to get category id
                             */
                            if(count($terms)>0){
                                foreach($terms as $cat){
                                  $termid= $cat->term_id;        
                                }
                            }
                            /*
                             * Store the post id via category id
                             */
                            
                            if(in_array($termid,$allcategory))
                            {
                                $categorypost[$termid][] = $postid;
                            }else{
                              $allcategory[] = $termid;                                 
                              $categorypost[$termid][] = $postid;
                            }
                          
                          }
                      }

//store it into the db for temporary .
/*
 *Store the data into db : and fetch it if it is blank i.e when refresh the data come from db.
 * because in refresh array data will lost. 
 */
 
 
if(count($categorypost)>0 AND is_array($categorypost)){
	update_option("TEMP_PREVIEW_DATA",serialize($categorypost));
    
}else{
    $categorypost	= unserialize(get_option("TEMP_PREVIEW_DATA"));
	
}

//here is the way to 
                    // echo '<pre>';
                    // print_r($categorypost);    
                    // echo '</pre>';

?>
	<section style="background:#fff;color: #333; line-height: 22px;">
		<div style="width: 90%; margin: 0 auto;">
			<!-- start header -->
			<div style="border-bottom: 1px solid #999; padding:10px 0 40px; margin-bottom: 20px;">
				<a href="www.emindslegal.com" style="float: right"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.jpg" width="300" /></a>
				<a href="<?php echo site_url(); ?>" style="font-size: 24px; font-weight: bold; display: block; padding-top: 15px; color: #333;">
					<?php echo get_option("newsletter_main_heading"); ?>
					</a>
			</div>
			<!-- end header -->
			<!-- start content -->
			<div class="content">
				<a href="#" style="font-size: 20px; font-weight: bold">Daily Updates</a>
				<br>
				<span style=" font-size: 14px; display: block; padding-top: 5px;">Posted: <span><?php echo  date("F j, Y, g:i a"); ?></span></span>
				<br>
				<br>
				<br>
				<span style="font-size: 16px; font-weight: bold;"><?php echo get_option("newsletter_headertext1"); ?></span>
<!--				<br>
				<br>
				<span style="font-size: 16px; font-weight: bold;"><?php echo get_option("newsletter_headertext2"); ?></span> -->
				
                            
                        <?php
                       // echo '<pre>';print_r($categorypost);echo '</pre>';
                     if(count($categorypost)>0){
                         foreach ($categorypost as $key=>$values){
                           
                            $postidscat  = $key;
                            ?>
                 <h2 style="padding-top: 20px; border-top: 1px solid #999; margin-top: 30px; color: #fc8b01; font-size: 30px;"><?php echo get_cat_name($postidscat); ?></h2>      
                             <?php
                            foreach($values as $postids){
                                $postid = $postids;
                        ?>
                        <h3><?php echo get_the_title($postid); ?></h3>
                       <?php echo wpautop(wp_trim_words(get_post_field('post_content',$postid), 40 )); ?>
                        <a href="<?php echo get_permalink($postid); ?>" style="margin-bottom: 20px; display: inline-block"> Read more</a>
                        <?php      
                            }
                          }//category id loop
                      } //condition loop
                      
                      
                      
                      
                      ?>
  <!--
				<br><br><br><br>
				<h3><?php echo get_option("newsletter_footermainheading"); ?></h3>
				<span style="display: block; color: #fc8b01; font-size: 14px; margin-bottom: 5px"><?php echo get_option("newsletter_footerfocustext"); ?></span>
				<a href="<?php echo get_option("newsletter_footerlink1"); ?>" style="font-size: 20px; font-weight: bold"><?php echo get_option("newsletter_footertext1"); ?></a>
				<br>
				<span style=" font-size: 14px; display: block; padding-top: 5px;"><?php echo get_option("newsletter_footerdesc1"); ?></span>
				<br>
				<br>
				<a href="<?php echo get_option("newsletter_footerlink2"); ?>" style="font-size: 20px; font-weight: bold"><?php echo get_option("newsletter_footertext2"); ?></a>
				<br>
				<span style=" font-size: 14px; display: block; padding-top: 5px;"><?php echo get_option("newsletter_footerdesc2"); ?></span>
				<br>
				<br>
				
				<h3 style="margin-bottom: 5px;"><?php echo get_option("newsletter_otherlinkheading"); ?></h3>
				<a href="<?php echo get_option("newsletter_subscribe_link"); ?>">Subscrib our Updates</a>
				<br>
				<a href="<?php echo get_option("newsletter_facebook"); ?>">Facebook</a>
				<br>
				<a href="<?php echo get_option("newsletter_twitter"); ?>">Twitter</a>
				<br>
				<a href="<?php echo get_option("newsletter_gplus"); ?>">Google plus</a>
				<br>
				<a href="<?php echo get_option("newsletter_feedbacklink"); ?>">Provide us Feedback</a>
				<br>
				<br>
				<br>
				
				<span><span style="font-size: 16px; font-weight: bold;"><?php echo get_option("newsletter_whatsup_title"); ?></span><?php echo get_option("newsletter_whatsup_text"); ?></span>
				<br>
				<span><span style="font-size: 16px; font-weight: bold;"><?php echo get_option("newsletter_query_title"); ?></span><?php echo get_option("newsletter_query_text"); ?></span>
				<br>
				<span><span style="font-size: 16px; font-weight: bold;"><?php echo get_option("newsletter_job_title"); ?>  </span><?php echo get_option("newsletter_job_text"); ?></span>
				<br>
				<br>
				<br></br> -->
				<!-- start signature -->
					<?php //echo get_option("newsletter_thanks_signature"); ?>
					
					
					<br><br><br>
					<p style="font-size: 14px;">
					<?php echo get_option("newsletter_disclaimer"); ?>	
						</p>
					<br>
					<br>
					<br>
				<!--	<div style="font-size: 14px; border-top: 1px solid #999; padding-top: 10px">
						<span style="float: right"><?php echo get_option("newsletter_poweredby"); ?></span>
				       <?php echo get_option("newsletter_email_lastlink"); ?>
						<span style="display: block; margin-top: 50px;"><?php echo get_option("newsletter_address_infooter"); ?></span>
					</div> -->
				<!-- End signature -->
			</div>
			<!-- end content -->
			<div class="footer"></div>
			
		</section>
		<br/>
			<a href="<?php echo admin_url("admin.php?page=emindsNewsletter"); ?>" class="button button-primary newsletter-submit" >Back</a>