<?php 
/*
 *Explains the author information as well as organisation image. 
 */
 
 $postType=get_post_type(get_the_ID());
 
?>
<section class="authorinfo-organisation" >
	                  <section class="post-nav margin-btm-none">
								<div class="author-priority" style="float:right">
									<!--
									Functionality to show the author name on priority basis.
									1: Organisation image  > author image > author name.
									Functionality change : we don't show the author name of company act post	
								    -->
								    
									<?php
									if($postType =="companies_act")
									{
										;
									}else{
										
									;//echo eminds_author_name(get_the_author_meta( 'ID' ));	
									}
									  ?>
									</div>
							
								<div class="clearfix" style="float:left;">
									<ul>
									 <li>
									 	<!--
									Functionality to show the author name on priority basis.
									1: Organisation image  > author image > author name.
									Functionality change : we don't show the author name of company act post	
								    -->
								    
									<?php
									if($postType =="companies_act")
									{
										;
									}else{
								           $authorid = get_the_author_meta( 'ID' );
                                           echo eminds_author_name_modifydesign($authorid);
												
									}
									  ?>
									 	 
									 </li>		
										<li>
											<?php 
											/*
											 *When run the search template, show the post type in place of category. 
											 */
										if(is_search() || is_tax()){
											
											if($postType =="page"){
												echo $postType;
											}else if($postType =="companies_act"){
												//get taxonomy link
												
												echo eminds_get_taxonomy_link(get_the_ID(),"act_chapter");
											}else{
											  /*
											   *Meeting 11 aug 
											   */		
												echo 'Legal Update | ';
												
												the_category(', ',"",get_the_ID());
											}
											
										}else{
											echo "in "; the_category(', ');
										}	 
											
											 ?>
											
											</li>
							
						<?php					//Returns Array of Term Names for "my_taxonomy"
                                  $contentType = eminds_get_post_content_type(get_the_ID());
								  if(!empty($contentType)){
								  	echo '<li> as ';
									  echo $contentType;
									echo '</li>';
									}
                                      ?>
							
										<li class="border-none">
											<?php
											/*
											 *Special Feature
											 * We need to show the date as :Hours > Yesterday > Date
											 * Changed : In company act show the Last updated date and other show date  
											 */ 
											 if($postType =="companies_act"){
											 	echo eminds_lastupdated_ca2013();
											 }else{
											 $postDate = get_the_time('U');
											 echo eminds_date_feature($postDate);	
											 }
											  
											 // the_time('F j, Y'); 
											?>
											</li>
									</ul>
								</div>
						       </section>		
								<div class="clearfix"></div>
						</section>	
<?php 
$imgHTML = eminds_get_thumbnail_html_with_customsize(get_the_ID(),'full',"thumbnailimage leftimg");

if(!empty($imgHTML)){
  echo $imgHTML;                    	
  }
?>