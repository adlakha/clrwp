
<?php
//return;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 if(is_active_sidebar('single_page_widget')){
   dynamic_sidebar('single_page_widget');	
 }
  
 ?>
 <!--
 <?php
 global $wpdb;

 $post_title = get_the_title(get_the_ID());
 
 $postType_sql ="";
 $title_heading="";
 	
 $postType = get_post_type( get_the_ID() );
 
 /*
  *Functionality change : 11th aug :meeting
  * We will show 5 posts of company act in legal update single page and vice versa.
  * I have created a new file for :companies act 
  */

   	$postType_sql ="post";	
 	$title_heading="Related Articles";	 	 
 
$idcurr = get_the_ID();
 
 
 $sql_related ="SELECT ID,post_type,post_author, post_title,MATCH(post_title) AGAINST ('$post_title') AS Similarity FROM ".$wpdb->prefix."posts WHERE MATCH(post_title) AGAINST('$post_title') GROUP BY post_title HAVING post_type='$postType_sql' AND ID NOT IN('$idcurr') ORDER BY Similarity DESC Limit 0,5";
$arr_related = $wpdb->get_results($sql_related);
// echo '<pre>';
// print_r($arr_related);
// echo '</pre>';
//for use in the loop, list 5 post titles related to first tag on current post


if(count($arr_related)){
?>
<section class="related-articles"> 
        <section class="posts-content">    
            <strong class="main-heading display-b"><?php echo $title_heading; ?></strong>
            <ul>
            <?php
         foreach ($arr_related as  $value) {
          $postid     = $value->ID;   
          $Similarity = $value->Similarity; //see how many similarty occurs
          $postTitle  = $value->post_title;
		  $authorid   = $value->post_author;
                ?>   
    <li><a class="related-link" href="<?php echo get_permalink($postid); ?>"><?php echo $postTitle; ?></a></li>

                <?php
         }
            ?>
            </ul>
        </section>
       </section>
     <?php } ?>  

<?php
/************      Recent articles  ****************/  
$post_type = get_post_type(get_the_ID());
$title_heading ="";

$title_heading="Recent Articles";


$argsrecent = array(
	'post_type' => $post_type,
	'posts_per_page' => 5
);
$query = new WP_Query( $argsrecent );
if($query->have_posts()):
?>
<section class="related-articles"> 
        <section class="posts-content">    
            <strong class="main-heading display-b">Recent Articles</strong>
            <ul>
            <?php
         while($query->have_posts()): $query->the_post();
                ?>   
            <li>
            	<a class="related-link" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
           </li>
                <?php
                endwhile;
            ?>
           </ul> 
        </section>
       </section>
       <?php 
endif;
wp_reset_query();
       ?>
       

<?php
/*******************************************/
$argsrecentCA = array(
	'post_type' => 'companies_act',
	'posts_per_page' => 5
);
$query = new WP_Query( $argsrecentCA );
if($query->have_posts()):
?>
<section class="related-articles"> 
        <section class="posts-content">    
            <strong class="main-heading display-b">Recent Amendments in Companies Act, 2013</strong>
            <ul>
            <?php
         while($query->have_posts()): $query->the_post();
                ?>   
            <li>
            	<a class="related-link" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
           </li>
                <?php
                endwhile;
            ?>
           </ul> 
        </section>
       </section>
       <?php 
endif;
wp_reset_query();
       ?>
   -->
