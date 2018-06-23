<?php
/*
 * #TemplateName:Category mapping
 * page default template file.
 *  */
get_header();
?>
<!-- end header -->
<section class="container-fluid">
    <section class="row position-rel">
        <section class="col-sm-8">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix">
                    
                    <strong class="main-heading display-b"><?php the_title(); ?></strong>
                    
  <!--  ****************************************************** category mapping ***************************************************************  -->                  
                    <form method="POST" action="">
                    	<input type="submit" name="category_mapping" class="btn btn-primary" value="Category Mapping">
                    </form>
                    
                   <!--
                   	 /*
                   	  *  Category mapping 
                   	  *  CLR Snippets      : 593              => Other       : 5688  : correct - 8 : miscellaneous : now.
                   	  *  Company Law       : 1                => company Law : 1            - No change
                   	  *  Customs & Excise  : 2                => Taxation    : 5685   : correct - 5728 : new
                   	  *  Cyber Laws        : 3                => cyber Laws  : 3            - No change
                   	  *  DGFT              : 224              => Business Law: 5686   : corect - 5729  : new
                   	  *  DIPP              : 3262             => Business Law: 5686
                   	  *  Event             : 5455             => Events      : 5455         - No change
                   	  * FEMA / RBI         : 4                => Fema        : 4            - No change
                   	  * Master Circulars July 2013: 3605      => Fema        : 4
                   	  * Income Tax         :5                 => Taxation    : 5685   : correct - 5728 : new
                   	  * IPR                :6                 => Intellectual Property :5687  : correct - : 5730 : new
                   	  * Labour Laws        :7                 => Labour Law  : 7              - No change
                   	  * Miscellaneous      :8                 => Other       : 5688
                   	  * Professional Institutes : 9           => Other       : 5688
                   	  * SEBI               : 11               => company Law : 1
                   	  * Service Tax        : 12               => Taxation    : 5685
                   	  * STPI/SEZ           :447               => Other       : 5688
                   	  * VAT                :10                => Taxation    : 5685
                   	  */ 
                   	
                   -->
                    
                    <?php 
                    if(isset($_POST['category_mapping'])){
                    
			/*		$argsmapping = array(
					                  'post_type'=>'post',
					                  'posts_per_page'=> 7500,
					                  'offset'   =>5000
					                    );
					
				*/
			//query category wise
			$argsmapping = array();
			$argsmapping['post_type']      = 'post';
			$argsmapping['posts_per_page'] = -1;
			$argsmapping['offset']         = 0;
			
			$singlecategory                = array(
														'taxonomy' => 'category',
														'field'    => 'slug',
														'terms'    => 'stpisez',
													);
			
			$argsmapping['tax_query']         = array($singlecategory);	
				
				
				
					
                 $query1 = new WP_Query($argsmapping);   
                    
					 $taxonomy ="category";
					
                    if($query1->have_posts()):
                        while ($query1->have_posts()):$query1->the_post();

                        //get the category id  :
                        //Returns All Term Items for "my_taxonomy"
                        $postid    = get_the_ID();
                        $term_list = wp_get_post_terms($postid,$taxonomy, array("fields" => "all"));
						
						if($term_list){
							
							foreach($term_list as $term){
								
						    $termid  = $term->term_id;
							//echo '<br/>termid = '. $termid."=postid =" .$postid;	
					 //******************** condition start here 			
						 if($termid == 593){
						 	$tag = array( 8 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
						  if($termid == 2){
						 	$tag = array( 5728 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					   
					    if($termid == 224){
						 	$tag = array( 5729 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
						
					  if($termid == 3262){
						 	$tag = array(5729 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
						 
					  if($termid == 3605){
						 	$tag = array( 4 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
						  
				       if($termid == 5){
						 	$tag = array(5728 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
						   
				       if($termid == 6){
						 	$tag = array( 5730 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
							
					  if($termid == 8){
						 	$tag = array( 8 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					if($termid == 9){
						 	$tag = array( 8 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	 
				
					if($termid == 11){
						 	$tag = array( 1 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	 
					
						if($termid == 12){
						 	$tag = array( 5728 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	 
						
					  if($termid == 447){
						 	$tag = array(8 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	 
							
					  if($termid == 10){
						 	$tag = array( 5728 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	 
										
						 		
					//******************** condition end here 			
								
							}
							
							
						}
                        
                


                    
                    ?>
                      
                  <?php
                  //break;temporary disable after first post.
                   
                    endwhile;
                  endif;
			wp_reset_query();
			}//isset category mapping .	  
                  ?>
 <!--  ***************************************** category mapping END ************************************************************************  -->
 <!--  ***************************************** content Type Start ************************************************************************  -->
 <br/>
   <form method="POST" action="">
      <input type="submit" name="contentType_mapping" class="btn btn-primary" value="Content Type Mapping">
   </form>
<!-- 
Case Laws          : 20 : case-laws              : Legal Updates : 24 : legal-updates

CLR Snippets       :593 : clr-snippets:5689-new: : Legal Updates : 24 : legal-updates        - condition : category - others       :5688
Companies Act 2013 :4737:companies-act-2013      : Legal Updates : 24 : legal-updates        - condition : category - Company Law  :1
NCLT               :4436: nclt                   : Legal Updates : 24 : legal-updates        - condition : category - Company Law  :1

cat  = 593 , 4737 , 4436 , 3606
con  = 5688 , 1   , 1    , 4

Downloads         : 21  : downloads              : Legal Updates : 24 : legal-updates
Featured          : 22  : featured               : Legal Updates : 24 : legal-updates
Featured Events   : 5098: featured-events        : Events        : 5605 :events
Miscellaneuos     : 3296: miscellaneuos          : Legal Updates : 24 : legal-updates
News              : 23  : news                   : Legal Updates : 24 : legal-updates
Official Documents:3996 :official-documents      : Legal Updates : 24 : legal-updates
Instructions      :317  : instructions           : Legal Updates : 24 : legal-updates
Orders            :414  : orders                 : Legal Updates : 24 : legal-updates
Press Release     :361  : press-release          : Legal Updates : 24 : legal-updates
Public Notices    :4179 : public-notices         : Legal Updates : 24 : legal-updates
Popular           :5640 : popular                : Legal Updates : 24 : legal-updates

RBI Master Circulars July 2013:3606: rbi-master-circulars-july-2013 : Legal Updates : 24 : legal-updates -condition : category : Fema: 4

Reference Documents:3275: reference-documents    : Legal Updates : 24 : legal-updates
Manuals            :3276: manuals                : Legal Updates : 24 : legal-updates
Reports            :448 : reports                : Legal Updates : 24 : legal-updates
Seminars           :26  : seminars               : Legal Updates : 24 : legal-updates
Speeches           :4023: speeches               : Legal Updates : 24 : legal-updates
SMS                :109 : sms                    : Legal Updates : 24 : legal-updates

3296,23,3996,317,414,361,4179,5640
3275,3276,448,26,4023,109
-->
                    <?php 
                    if(isset($_POST['contentType_mapping'])){
                    
			//query category wise
			$argsmapping = array();
			$argsmapping['post_type']      = 'post';
			$argsmapping['posts_per_page'] = -1;
			$argsmapping['offset']         = 0;
			
			$singlecategory                = array(
							   'taxonomy' => 'legal',
							   'field'    => 'slug',
							   'terms'    => 'rbi-master-circulars-july-2013',
													);
		
		   
		// ---------- multiple category -----------------------
		$multiplecategory   = array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'legal',
										'field'    => 'slug',
										'terms'    => 'rbi-master-circulars-july-2013',
									),
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => 'fema-rbi'
									),
								);
		//----------- multiple category -----------------------
			
			$argsmapping['tax_query']         = array($singlecategory);	
				
				
				
					
                 $query1 = new WP_Query($argsmapping);   
                    
					 $taxonomy ="legal";
					
                    if($query1->have_posts()):
                        while ($query1->have_posts()):$query1->the_post();

                        //get the category id  :
                        //Returns All Term Items for "my_taxonomy"
                        $postid    = get_the_ID();
                        $term_list = wp_get_post_terms($postid,$taxonomy, array("fields" => "all"));
						
						if($term_list){
							
							foreach($term_list as $term){
								
						    $termid  = $term->term_id;

					 //******************** condition start here
					//593 , 4737 , 4436 , 3606
					//5688 , 1   , 1    , 4
				/*	$cond_arr = array(593,4737,4436,3606);
					
					 if(in_array($termid, $cond_arr)){
					 	 			
					 $cat_termlist = wp_get_post_terms($postid,"category", array("fields" => "all"));
					 
					 foreach($cat_termlist as $cat){
					 	$catid = $cat->term_id;
					 }
					 
                      if($termid == 593 AND $catid ==5688){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					  if($termid == 4737 AND $catid ==1){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					  if($termid == 4436 AND $catid ==1){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					  if($termid == 3606 AND $catid ==4){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					  
					 }//in array condition
				*/
					 //************* special
					 if($termid == 3376){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }  
					//******************** condition end here 			
					
					//-----------------
					   if($termid == 20){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					if($termid == 5689){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					if($termid == 4737){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					
					if($termid == 4436){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					
					if($termid == 21){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					
					if($termid == 22){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					
					if($termid == 5098){
						 	$tag = array( 5605 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }
					
					
					if($termid == 3296){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }		
									
					if($termid == 23){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 3996){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 317){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 414){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 361){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 4179){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 5640){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 3275){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 3276){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 448){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 26){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 4023){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					if($termid == 109){
						 	$tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            wp_set_post_terms( $postid, $tag, $taxonomy );
					   }	
										
					// if($termid == 20){
						 	// $tag = array( 24 ); // Correct. This will add the tag with the id 5.
                            // wp_set_post_terms( $postid, $tag, $taxonomy );
					   // }				
								
								
							}
							
							
						}
                        
                


                    
                    ?>
                      
                  <?php
                  //break;temporary disable after first post.
                   
                    endwhile;
                  endif;
			wp_reset_query();
			}//isset category mapping .
               ?>     
                                     
                </section>
                <!-- end post -->
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
