<?php
/*
 * Follow author 
 * 
 * When it will be on "template-author.php " file then it will show the logged in author 
 * othewise show the post author .
 */
$fblink ="";
$ttlink ="";
$lilink ="";
$gplink ="";

if (is_page_template('template-author.php') || is_page_template('template-submit-article.php')){
    global $current_user;
    get_currentuserinfo();
   
   $authorid = $current_user->ID;

$fblink =  get_user_meta($authorid,'facebook',TRUE);
$ttlink =  get_user_meta($authorid,'twitter',TRUE);
$lilink =  get_user_meta($authorid,'linkedin',TRUE);
$gplink =  get_user_meta($authorid,'googleplus',TRUE);
$website_url     = get_the_author_meta('user_url',$authorid);    
} else {
	// Returns false when 'about.php' is not being used.
$authorid =get_post_field('post_author', get_the_ID());

$fblink =  get_user_meta($authorid,'facebook',TRUE);
$ttlink =  get_user_meta($authorid,'twitter',TRUE);
$lilink =  get_user_meta($authorid,'linkedin',TRUE);
$gplink =  get_user_meta($authorid,'googleplus',TRUE);
$website_url     = get_the_author_meta('user_url',$authorid);
}

/*
 * New condition : 21st sep 2016
 by default we will add : http:// : 
 then now we will check if any social URL is > 10 then we will show.
 */

?>
<section class="follow-us fl">
	<?php
  
    	if( strlen($fblink) > 10  || strlen($ttlink) > 10 || strlen($gplink) > 10 || strlen($lilink) > 10 || strlen($website_url) > 5){
    	 ?>
    <ul class="margin-none">
    	<li class=""><a>Follow Author:</a></li>
        <?php 
        $target_attr = (empty($fblink))?"javascript:void(0)":"target='_blank'";
        if(!empty($fblink) AND strlen($fblink) > 10){
        ?>
        <li class="fb"><a <?php echo $target_attr; ?> title="Follow Author on Facebook" href="<?php echo $fblink; ?>"></a></li>
        <?php
		} if(!empty($ttlink) AND strlen($ttlink) > 10){
        $target_attr = (empty($ttlink))?"javascript:void(0)":"target='_blank'";
        ?>
        <li class="twitter"><a <?php echo $target_attr; ?> title="Follow Author on Twitter" href="<?php echo $ttlink; ?>"></a></li>
        <?php 
		}if(!empty($gplink) AND strlen($gplink) > 10){
        $target_attr = (empty($gplink))?"javascript:void(0)":"target='_blank'";
        ?>
        <li class="google"><a <?php echo $target_attr; ?> title="Follow Author on Google plus" href="<?php echo $gplink; ?>"></a></li>
       <?php 
		}if(!empty($lilink) AND strlen($lilink) > 10){
        $target_attr = (empty($lilink))?"javascript:void(0)":"target='_blank'";
        ?>
        <li class="linkedin"><a <?php echo $target_attr; ?> title="Follow Author on Linkedin" href="<?php echo $lilink; ?>"></a></li>
        <!-- <li class="email"><a class="emailus-author" title="Email to author" href="javascript:;"></a></li> --> <!-- Wiil activate after website launch -->
       <?php 
		}if(!empty($website_url) AND strlen($website_url) > 5 ){
        $target_attr = (empty($website_url))?"javascript:void(0)":"target='_blank'";
		$website_url= ($website_url)?$website_url:"javascript:;";
        ?>
        <li class="author-website"><a <?php echo $target_attr; ?> class="author-website" title="website" href="<?php echo $website_url; ?>"></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <!-- To show the author info. -->
     
    <div class="clearfix"></div>
</section>