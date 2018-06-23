<?php
/*
 * Shortcode describe here. 
 */
 
 
/*
 *Eminds my account page
 * How to Use : [eminds_my_account] 
 * Functionality :-
 * It has two phase : 1 - When user not login 
 *                    2 - When user login
 */
function eminds_my_account_callback_shortcode(){
	$atts = shortcode_atts( array(), $atts, 'eminds_my_account' );
	
	$output ="";
		global $current_user;
         get_currentuserinfo();
	 $uid = $current_user->ID;
	 $uemail = $current_user->user_email; 
	 $displayName = $current_user->display_name;	
	//when submit the form then save all the records.
	if(isset($_POST['update_userinfo'])){
	//save the record
	 eminds_update_user_record($uid,$_POST);
	 eminds_update_user_image($uid,$_POST);
	 echo '<div class="success-msg"><p>User updated.</p></div>';	
	}
	
	ob_start();
	//2:when user login .
	if ( is_user_logged_in() ) {

	 //get all the user information .
	 $fname          = get_user_meta($uid,'first_name',TRUE);
	 $lname          = get_user_meta($uid,'last_name',TRUE);
	 $qualification  = get_user_meta($uid,'qualification',TRUE);
	 $designation    = get_user_meta($uid,'designation',TRUE);
	 $organization   = get_user_meta($uid,'organization',TRUE);
	 $mob            = get_user_meta($uid,'phone',TRUE);
	 $tel            = get_user_meta($uid,'enter_the_telephone_number',TRUE);
	 $address        = get_user_meta($uid,'address',TRUE);
	 $city           = get_user_meta($uid,'city',TRUE);
	 $state          = get_user_meta($uid,'state',TRUE);
	 $country        = get_user_meta($uid,'country',TRUE);
	  
	  $desc            = get_user_meta($uid,'description',TRUE);
	  //call profile image
	  $profile_image = get_user_meta($uid,'eminds_user_profile_image',TRUE);
	  $org_image = get_user_meta($uid,'eminds_user_organisation_image',TRUE);
	  
	 ?>
	 
	 Hello <?php echo $current_user->user_login; ?> (not <?php echo $current_user->user_login; ?>? <a href="<?php echo wp_logout_url( home_url() ); ?>">Sign out</a>).
	 From your account dashboard you can manage your profile and write the article.
	 
	 <div class="profile-link">
	 	<p>For creating an article, <a href="<?php echo admin_url('post-new.php'); ?>">click here</a>.</p>
	 </div>	
	 
<!-- ****************************************************************** -->	 
	 
	 <div class="myaccount-page">
	 	<h2><?php echo $displayName; ?> <a href="<?php echo admin_url("user-edit.php?user_id=".$uid); ?>"> Edit Profile</a></h2>
	   <span class="designation"><?php echo $designation; ?></span><span class="organisation"><?php echo $organization; ?></span>
	      
 <?php 
  $profile_img = wp_get_attachment_image_src(get_user_meta($uid,'upload_profile_image',TRUE));
  if(empty($profile_img)){
  	$defaultimg = get_stylesheet_directory_uri().'/images/man.jpg';
  	$profile_img = array($defaultimg);
  }
  $org_img     = wp_get_attachment_image_src(get_user_meta($uid,'upload_organisation_image',TRUE));
 
 ?>	
	 	
  <div class="myaccount-profile">
  <div class="profile-image">
  <ul class="profile-image-loop">
  	<?php if(!empty($profile_img)){ ?>
  	<li>		
  <img border="0" alt="<?php echo $displayName; ?>" id="logo" src="<?php echo $profile_img[0]; ?>" name="logo" />
  </li>
  <?php }if(!empty($org_img)){  ?>
  <li>
  <img border="0" alt="<?php echo $displayName; ?>" id="logo" src="<?php echo $org_img[0];?>" name="logo">
  </li>
  <?php } ?>
  </ul>
  </div>
<p>
<?php
if(!empty($tel) || !empty($mob)){
	echo '<strong>Contact Details</strong><br/>';
}
 if(!empty($tel)){
	echo 'Tel: '.$tel.'<br/>';
}

if(!empty($mob)){
	echo 'Mob: '.$mob;
} ?>
</p>
  <p><?php echo $address; ?><br>
      <?php echo $city; ?><br>
      <?php echo $state; ?><br>
     <?php echo $country; ?><br>
</p>

<?php 
//call the social author information.
get_template_part('social','author');
?>
<br/>
<h2>Biographical Info</h2>
<?php echo $desc; ?>
  </div>
  <div class="myaccount-posts">
  <h2>Latest Articles</h2>
  <?php 
  $paged  = get_query_var('paged');
  $query = new WP_Query( 'author='.$uid.'&paged='.$paged);
  if($query->have_posts()):
  ?>
  <ul>
   <?php while($query->have_posts()): $query->the_post(); ?>	
    <li>
    	<a class="mdqtitle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
   </li>
   <?php 
   endwhile;
   //get the pagination.
   //wp_pagenavi(array('query'=>$query));
  else:
	  echo '<p>No posts found,please create article.</p><a href="'. admin_url('post-new.php').'">click here</a>';
    ?>
   
  </ul>
 <?php
  endif; 
 wp_reset_query();
 ?> 
  </div>
</div>
<div class="clear"></div>
<!-- ****************************************************************** -->
 <?php		
	}else{
	 
	get_template_part('shortcode/myaccount/login-html');
	 
	}
	?>
	<!-- default feature -->
	<style>.addthis_default_style{display:none;}</style>
	<?php
	
	$output = ob_get_contents();
	ob_get_clean(); 
  return $output;	
} 
add_shortcode( 'eminds_my_account', 'eminds_my_account_callback_shortcode' );