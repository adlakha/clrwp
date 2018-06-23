<?php
/*
 * Newsletter step 1
 */
 
 /* ********************* Step 3 ****************************
  * if click on the button "exclude" then we will do following
  * Form 1 :Post will be added .
  * Form 2: Posts will excluded.
  */
 if(isset($_POST['excludepost'])){
 	
	$excludearr = $_POST['post']; 
	$diffarr  = $totalarr   = get_option('eminds_newsletter_selectedposts');
	
	//diffrence of array
	if($excludearr){
	$diffarr    = array_diff($totalarr,$excludearr); 	
	}
	//update in database;
	update_option('eminds_newsletter_selectedposts',$diffarr);
 }
 
/****************** Step 1 ************************************
 *Key : eminds_newsletter_post_week
 *    : eminds_newsletter_posts_per_page 
 */
 //saved the setting of the :week and :perpage :
 if(isset($_POST['newsletter_submit'])){
 	
	$week    = $_POST['post_week'];
	$perpage = $_POST['posts_per_page_custom'];
	
		  //initialize the default value
		  if(empty($week)){
		  	$week = 1;
		  }
		  //initialize the default value
		  if(empty($perpage)){
		  	$perpage = 30;
		  }
	update_option('eminds_newsletter_post_week',$week );
	update_option('eminds_newsletter_posts_per_page',$perpage);
 }

 /* ************************ Step 2 ********************************
  * When select the posts and press submit then selected posts will be show on below table.
  * Key : eminds_newsletter_selectedposts 
  */
 if(isset($_POST['selectedpost'])){
 
    $updatedarr = $selectedpost = $_POST['post']; //print_r($selectedpost); echo '<1>';
    //  *We will save this data into the db for tempo.. 
    /*
	 * Before updating the value, we will check : is it have any value previously  ?
	 * if yes then update with otherwise update this.
	 */
	 $previous_value = get_option('eminds_newsletter_selectedposts'); //print_r($previous_value);echo '<2>';
	 if($previous_value){
	 $updatedarr    = array_merge($previous_value,$selectedpost); 	
	 }
//	 	 print_r($updatedarr);echo '<3>';
    update_option('eminds_newsletter_selectedposts',$updatedarr);
 
 }
 //get the current selected posts;
 $selectedpost   = array(); 
 $selectedpost   = get_option('eminds_newsletter_selectedposts');
 
 
?>
<div class="welcome-panel" id="welcome-panel">
	<div class="welcome-panel-content">
		<div class="welcome-panel-column-container">
			<?php 
		         /*
				  *  call the db value : Use for showing the posts
				  */
				  $postweek   = get_option('eminds_newsletter_post_week');
				  //initialize the default value
				  if(empty($postweek)){
				  	$postweek = 1;
				  }
				  
				  $perpage_custom    = get_option('eminds_newsletter_posts_per_page');
				  //initialize the default value
				  if(empty($perpage_custom)){
				  	$perpage_custom = 30;
				  }
		         ?> 
         
			<form method="POST" action="<?php echo admin_url('admin.php?page=emindsNewsletter'); ?>">
				<div class="custom-container" style="float:left;margin-left:20px;">
				<h4> Posts Week</h4>
				<select name="post_week">
				 <?php 
		          for($i=1;$i<=10;$i++){
		          ?>
					<option value="<?php echo $i; ?>" <?php echo ($postweek == $i)?"selected='selected'":""; ?>  > <?php echo $i; ?> Week</option>
		            <?php } ?>
					
				</select>
				
				</div>
				<div class="custom-container" style="float:left;margin-left:20px;">
				<h4>Max num posts</h4>
				<select name="posts_per_page_custom">
					<option value="-1"> All posts</option>
		          <?php 
		          for($i=30;$i<=510;$i=$i+30){
		          ?>
					<option value="<?php echo $i; ?>" <?php echo ($perpage_custom == $i)?"selected='selected'":""; ?> > <?php echo $i; ?> posts</option>
		            <?php } ?>
				</select>
				</div>
				<div class="custom-container" style="float:left;margin-left:20px;">
					<h4>&nbsp;</h4>
				<input type="submit" name="newsletter_submit" value="Submit" class="button button-primary" />
			    </div>	
            </form>
            
            <p style="clear:both;">You are visiting the posts from <?php echo $postweek; ?> weeks of <?php echo $perpage; ?> posts .</p>
            
         </div>
     </div>
</div>           				

<form method="POST" action="<?php echo admin_url('admin.php?page=emindsNewsletter'); ?>">				
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th class="manage-column column-cb check-column" id="cb" scope="col">
				<label for="cb-select-all-1" class="screen-reader-text">Select All</label>
			    <input type="checkbox" id="cb-select-all-1">
			</th>
			<th style="" class="manage-column column-title sortable desc" id="title" scope="col">
				<a href="javascript:void(0);"><span>Title</span>
					<span class="sorting-indicator"></span>
					</a>
			</th>
			<th style="" class="manage-column column-author" id="author" scope="col">Author</th>
			<th style="" class="manage-column column-categories" id="categories" scope="col">Categories</th>
			<th style="" class="manage-column column-taxonomy-legal" id="taxonomy-legal" scope="col">Content Type</th>
			<th style="" class="manage-column column-date sortable asc" id="date" scope="col"><a href="javascript:void(0);"><span>Date</span><span class="sorting-indicator"></span></a></th>
			
			
		</tr>
	</thead>

	<tbody id="the-list">
		
<!--  Loop here  -->
<?php 

/*
 *We will exclude the selected posts in here . 
 */

$postnotin = array();

$argsnewsletter1 = array(
	
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'post__not_in'=> $selectedpost,
	    'posts_per_page' => $perpage_custom,
	    'date_query' => array(
	        array(
	            'after'  => "$postweek weeks ago"
	        ),
	    ),
	);
	
	$query = new WP_Query( $argsnewsletter1 );
	
  // echo '<pre>';
  // print_r($argsnewsletter1);
  // echo '</pre>';

	if($query->have_posts()):
		while($query->have_posts()): $query->the_post();
		$postid = get_the_ID();
	?>	
	<tr class="iedit author-self level-0 post-<?php echo $postid; ?> type-post status-draft format-standard hentry category-others" id="post-<?php echo $postid; ?>">	
			<td class="check-column" scope="row">
				<label for="cb-select-<?php echo $postid; ?>" class="screen-reader-text">Select (no title)</label>
			<input type="checkbox" value="<?php echo $postid; ?>" name="post[]" id="cb-select-<?php echo $postid; ?>">
			</td>
			
			<td class="title column-title"><strong><a for="cb-select-<?php echo $postid; ?>" class="row-title" href="javascript:void(0);"><?php echo get_the_title($postid); ?></a></strong></td>
			
			<td class="author column-author"><a href="javascript:void(0);"><?php the_author(); ?></a></td>
			
			<td class="categories column-categories"><?php the_category(","); ?></td>
			<td class="categories column-categories">
				<a href="javascript:void(0);">
				<?php 
				 $contentType = eminds_get_post_content_type($postid);
								  if(!empty($contentType)){
								  	echo '<li>';
									  echo $contentType;
									echo '</li>';
									}
				?></a>
				</td>
			
			<td class="date column-date"><?php the_time('F j, Y'); ?>
			<br>
			Published
			</td>
			</tr>
		<?php 
		endwhile;
else:
?>
<tr>
	<td colspan="6">Not Found any Posts .</td>
</tr>			
		<?php
endif;
wp_reset_query();
		 ?>	
		
		
<!--  Loop here  -->
         
	</tbody>

	<tfoot>
		<tr>
			<th style="" class="manage-column column-cb check-column" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label>
			<input type="checkbox" id="cb-select-all-2">
			</th><th style="" class="manage-column column-title sortable desc" scope="col"><a href="javascript:void(0);"><span>Title</span><span class="sorting-indicator"></span></a></th><th style="" class="manage-column column-author" scope="col">Author</th><th style="" class="manage-column column-categories" scope="col">Categories</th><th style="display:none;" class="manage-column column-tags" scope="col">Tags</th><th style="" class="manage-column column-taxonomy-legal" scope="col">Content Type</th><th style="display:none;" class="manage-column column-comments num sortable desc" scope="col"><a href="http://oodlesbit.in/clr/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span title="Comments" class="vers comment-grey-bubble"><span class="screen-reader-text">Comments</span></span></span><span class="sorting-indicator"></span></a></th><th style="" class="manage-column column-date sortable asc" scope="col"><a href="http://oodlesbit.in/clr/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th><th style="display:none;" class="manage-column column-seotitle" scope="col">SEO Title</th><th style="display:none;" class="manage-column column-seodesc" scope="col">SEO Description</th><th style="display:none;" class="manage-column column-seokeywords" scope="col">SEO Keywords</th>
		</tr>
	</tfoot>

</table>
<br/>
<input type="submit" name="selectedpost" value="Submit" class="button button-primary" />
</form>

<h3>Your selected posts </h3>

<form method="POST" action="<?php echo admin_url('admin.php?page=emindsNewsletter'); ?>" >

<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th class="manage-column column-cb check-column" id="cb" scope="col">
				<label for="cb-select-all-1" class="screen-reader-text">Select All</label>
			    <input type="checkbox" id="cb-select-all-1">
			</th>
			<th style="" class="manage-column column-title sortable desc" id="title" scope="col">
				<a href="javascript:void(0);"><span>Title</span>
					<span class="sorting-indicator"></span>
					</a>
			</th>
			<th style="" class="manage-column column-author" id="author" scope="col">Author</th>
			<th style="" class="manage-column column-categories" id="categories" scope="col">Categories</th>
			<th style="" class="manage-column column-taxonomy-legal" id="taxonomy-legal" scope="col">Content Type</th>
			<th style="" class="manage-column column-date sortable asc" id="date" scope="col"><a href="javascript:void(0);"><span>Date</span><span class="sorting-indicator"></span></a></th>
			
			
		</tr>
	</thead>

	<tbody id="the-list-1">
		<!--  Loop here  -->
<?php 
/*
 *We will show only the selected posts. 
 */
$postin = array();
//print_r($selectedpost);
/*
 *As per wp rule
 * If selectedpost : blank : then initialize it with zero 
 */
if(empty($selectedpost)){
$selectedpost = array(0); 	
}
 
 
$argsnewsletter11 = array(
	
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'post__in'    => $selectedpost,
	    'posts_per_page' => -1
	);
	
	$query11 = new WP_Query( $argsnewsletter11 );
	
  // echo '<pre>';
  // print_r($argsnewsletter11);
  // echo '</pre>';

	if($query11->have_posts()):
		while($query11->have_posts()): $query11->the_post();
		$postid = get_the_ID();
	?>	
	<tr class="iedit author-self level-0 post-<?php echo $postid; ?> type-post status-draft format-standard hentry category-others" id="post-<?php echo $postid; ?>">	
			<td class="check-column" scope="row">
				<label for="cb-select-<?php echo $postid; ?>" class="screen-reader-text">Select (no title)</label>
			<input type="checkbox" value="<?php echo $postid; ?>" name="post[]" id="cb-select-<?php echo $postid; ?>">
			</td>
			
			<td class="title column-title"><strong><a for="cb-select-<?php echo $postid; ?>" class="row-title" href="javascript:void(0);"><?php echo get_the_title($postid); ?></a></strong></td>
			
			<td class="author column-author"><a href="javascript:void(0);"><?php the_author(); ?></a></td>
			
			<td class="categories column-categories"><?php the_category(","); ?></td>
			<td class="categories column-categories">
				<a href="javascript:void(0);">
				<?php 
				 $contentType = eminds_get_post_content_type($postid);
								  if(!empty($contentType)){
								  	echo '<li>';
									  echo $contentType;
									echo '</li>';
									}
				?></a>
				</td>
			
			<td class="date column-date"><?php the_time('F j, Y'); ?>
			<br>
			Published
			</td>
			</tr>
		<?php 
		endwhile;
else:
	?>
	<tr>
	<td colspan="6">Not Selected any Posts .</td>
   </tr>
	<?php
endif;
wp_reset_query();
		 ?>	
		
		
<!--  Loop here  -->
	</tbody>
	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" id="cb" scope="col">
				<label for="cb-select-all-1" class="screen-reader-text">Select All</label>
			    <input type="checkbox" id="cb-select-all-1">
			</th>
			<th style="" class="manage-column column-title sortable desc" id="title" scope="col">
				<a href="javascript:void(0);"><span>Title</span>
					<span class="sorting-indicator"></span>
					</a>
			</th>
			<th style="" class="manage-column column-author" id="author" scope="col">Author</th>
			<th style="" class="manage-column column-categories" id="categories" scope="col">Categories</th>
			<th style="" class="manage-column column-taxonomy-legal" id="taxonomy-legal" scope="col">Content Type</th>
			<th style="" class="manage-column column-date sortable asc" id="date" scope="col"><a href="javascript:void(0);"><span>Date</span><span class="sorting-indicator"></span></a></th>
			
			
		</tr>
	</tfoot>
</table>
<br/>
<div class="btn-container">
	<div class="action-submit" style="float: left;">
	<input type="submit" name="excludepost" value="Exclude Post" class="button button-primary" />
	</div>
	
	<div class="action-submit" style="float:right;">
		<a href="<?php echo admin_url('admin.php?page=emindsNewsletter&action=preview'); ?>" target="_blank" name="preview" class="button button-primary"> Preview </a>&nbsp;&nbsp;
		<a href="<?php echo admin_url('admin.php?page=emindsNewsletter&action=step-2'); ?>" target="_blank" name="generate_code" class="button button-primary" >Generate Code </a>
	</div>
		
</div>		
</form>