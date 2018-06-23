<?php
/*
 * Template Name:Company Act 2013
 */
get_header();
?>          <!-- end header -->
<section class="container-fluid middle-container">
    <section class="row">
        <section class="col-sm-8">
            <section class="posts-content left-manageheight">
                <!-- start jump to -->
                 <section class="fr ca2013">
                	<?php echo do_shortcode('[emind_jumpto_form]'); ?>
                </section>	
                   
                <!-- end jump to -->
                <!-- <strong class="main-heading display-b"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>-->
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                
                <!-- Law descriptions -->
                <hr class="ca-2013-hr"/>
                <i style="color:#e57f03;" >Updated with Rules, Notifications, Circulars and Orders till 
                		    <?php 
                       /*
					   *Admin are able to hide this option when needed. 
					   */
					   $emergency_hide = clr_of_get_option("emergency_hide_ca2013");
					   if($emergency_hide){
					    echo eminds_lastupdated_ca2013(); 	
					   } ?>,
                	 all presented at one place under the relevant section of Companies Act, 2013</i>
                	 <hr class="ca-2013-hr" />
                <!-- start company acts -->
                
                <section class="company-act-column">
                    <?php
                 //get the cateogry exclude ids
                 $ids = array(0);   
                
                    $cat_ca2013_mod = get_terms('act_chapter', array(
                        'orderby' => 'none',
                        'number'  => '100', 
					            	'hide_empty' => 0
                    ));
			 
				//echo '<pre>';print_r($cat_ca2013_mod);echo '</pre>';
					
                            /*
							 * For all the scheduled , we need to show the : schedule - category without h3 , 
							 * i.e we will show like - Schedule 1 - schedule 1 post title. 
							 */
							  $scheduleSlug= array("schedule-1","schedule-2","schedule-3","schedule-4","schedule-5","schedule-6","schedule-7","schedule-8","schedule-9","schedule-10","schedule-11");
							  
					//taxonomy loop start here
                    
                    $schudleText = 1;
                    
					$chp_inc = 1;
					
                    if (is_array($cat_ca2013_mod)) {
                        foreach ($cat_ca2013_mod as $cat) {
                       
                       $catid = $cat->term_id; 
                       $catname = $cat->name;                          
                       $slug = $cat->slug;
					
					        
					     /*
							  *We will add the google adsensecode after 2st chapter.
							  * In more thigns,
							  * In 1st Ul-> We will add the class - nowAddStart . 
							  */
							  if($chp_inc == 3){
							  $addsenseCode_ca2013 = clr_of_get_option("google_advertise_codefor_ca2013_before2ndchapter");
							  echo "<div class='addsenseCode'>".$addsenseCode_ca2013."</div>";	  	
					          } 
					
							
							/*
							 * We need to exclude the category name for all the schedule 
							 * But we need to write the text - Schedule - on starting of schedule posts.
							 */
							 
							if(!in_array($slug,$scheduleSlug)){
                            ?>
                            <h3><?php echo $catname; ?> 
                             <?php
                              $subTitle=clr_get_field_for_category('ente_the_sub_title', $catid);
                             if($subTitle) echo " - ".$subTitle;
                               ?>
                            </h3>
                            <?php }else{
                            	if($schudleText){
                                echo "<h3>Schedules</h3>";		
                            	$schudleText = 0;//it means it have printed 	
                            	}
                            	  
							        } ?>
                            <ul>
                                <!-- post loop of this category  -->
                                <?php
                                $args = array(
                                    'post_type'      => 'companies_act',
                                    'posts_per_page' => -1,
                                    'order'          => 'ASC',
                                    'meta_key'       => 'enter_the_section_no_ca_post',
                                    'orderby'        => 'meta_value_num menu_order',
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'act_chapter',
                                            'field' => 'slug',
                                            'terms' => $slug,
                                        ),
                                    ),
                                );
                                $query = new WP_Query($args);
                                if ($query->have_posts()):
                                    while ($query->have_posts()) : $query->the_post();
                                        ?>       	
                                      
                                                <?php
                                                /*
                                                 * Change title display requirement
                                                 * 1: Section number then
                                                 * 2: Post title
												 * Extra feature added : 07 dec 2015 - 04:03 pm
												 * we need to exclude the text "section :" for all the schedule
                                                 */
                                                 $term_list = wp_get_post_terms(get_the_ID(), 'act_chapter', array("fields" => "all"));
                                                 $catSlug   = $term_list[0]->slug;
												 
												 if(!in_array($catSlug,$scheduleSlug)){
                                                    ?>
                                        <li><a href="<?php the_permalink(); ?>">  
                                         <?php
                                         /*
                                          * New condition : 21 sep 2016 
                                          Here is the prev rule for title
                                          1: section  #0 : title
                                          2: Schedule #0 : title
                                          Now we need the new way
                                          3 :            : title (21st sep condition)
                                          */
                                          /*
                                           * Functionality :
                                           we will check if post's category have :true: then we don't include word : section or schedule : 
                                           meta key : check_to_exclude_word  : 
                                           */
                                             if(function_exists(get_field)){
                                               $exclude_catid_flag = get_field('check_to_exclude_and_allow_for_manual_setting', 'act_chapter_'.$catid);
                                               if($exclude_catid_flag){
                                                 echo "";
                                               }else{
                                                echo "Section " .get_post_meta(get_the_ID(), 'enter_the_section_no_ca_post', TRUE)." : ";
                                                  }
                                                }

                                           }else {
                                             	 ?>
                                             	  <li class="schedulepost"><a href="<?php the_permalink(); ?>"> 
                                             	 <?php
                                                        echo $catname." : ";   	
                                                          } ?>
                                        <?php echo get_post_meta(get_the_ID(), 'enter_the_subtitle_ca2013', TRUE); ?>
                                                
                                               </a>
                                            </li>
                                        <?php
                                    endwhile;
                                endif;
                                wp_reset_query();
                                ?>             
                            </ul>
                            <?php
                            ++$chp_inc;
                        }
                    }
                ?>
          
       
                </section>
                <!-- end company act -->
            </section>
        </section>
        <?php
        //call the sidebar
        get_sidebar();
        ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>
