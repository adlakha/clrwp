<?php
/*
 *Creating an json api which is used for mobile apps  
 */
 
 
 /*
  *1: Json api for showing following 
  * i)- Chapter number
  * ii)-Section title only
  */
 
 add_action('wp_ajax_eminds_get_ca2013_post','eminds_get_ca2013_post');
 add_action('wp_ajax_nopriv_eminds_get_ca2013_post','eminds_get_ca2013_post');
 
 function eminds_get_ca2013_post(){
 //main output 
 $output =array();
 
   $cat_ca2013 = get_terms('act_chapter', array(
						 	'orderby'    => 'none',
						 	'hide_empty' => 1,
						 ) );
 
 //taxonomy loop start here
if(is_array($cat_ca2013)){
	$catid =0;
  foreach($cat_ca2013 as $cat){
  	
	//chapter output
	$output_capter =array();
	
  	 $catname          = $cat->name;
	 $catid            = $cat->term_id;
	 $slug             = $cat->slug;
	 $chapter_subtitle = get_field('ente_the_sub_title','act_chapter_'.$catid);
	
	//******* json  
    $output_capter['chapterNumber']  =$catname;	 
	$output_capter['chapterid']      =$catid; 
	$output_capter['chapterslug']    =$slug; 
	$output_capter['chaptersubtitle']=$chapter_subtitle;
	//******* json  
	 
	 
	 $argsjson = array(
						'post_type' => 'companies_act',
						'orderby'   =>'menu_order',
						'posts_per_page'   =>-1,
						'order'     =>'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'act_chapter',
								'field'    => 'slug',
								'terms'    => $slug,
							),
						),
					);

$output_allpost = array();

$query = new WP_Query( $argsjson );
if($query->have_posts()):
	 while($query->have_posts()) : $query->the_post();
	 
	 $output_post = array();
	 //******* json
	 $output_post['chapterid'] = $catid; 
	 $output_post['id']        = get_the_ID();
	 $output_post['url']       =  get_permalink(get_the_ID());
	 $output_post['title']     =  get_the_title(get_the_ID());
	 $output_post['subtitle']  =  get_post_meta(get_the_ID(),'enter_the_subtitle_ca2013',TRUE);
	 $output_post['content']   = get_post_field('post_content',get_the_ID());
	 $output_post['excerpt']   = get_post_field('post_excerpt',get_the_ID());
	 $output_post['sectionNo'] = get_post_meta(get_the_ID(),'enter_the_section_no_ca_post',TRUE);
	 $output_post['notifiedDate'] = get_post_meta(get_the_ID(),'enter_the_section_no_ca_post',TRUE);
	 $output_post['footnotes'] = get_post_meta(get_the_ID(),'enter_the_foot_notes_ca_post',TRUE);
	 //******* json
	 //push the data
	 array_push($output_allpost,$output_post);
	  
	 endwhile;
//Add all the date into the chapter
//	 array_push($output_allpost,$output_post);
     $output_capter['allposts']=$output_allpost;
	 	  
   endif;
     wp_reset_query();
    //push the data
	 array_push($output,$output_capter);
   
  }//foreach loop
  
}//conditional 
 //convert into the json.
 echo $output_json = json_encode($output);
 die(0);
 }