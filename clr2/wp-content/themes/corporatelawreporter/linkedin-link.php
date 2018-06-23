<?php
/*
 *Define the Linkedin link structure 
 */
 @session_start();
 
 $linkedin_login  = clr_of_get_option("linkedin_login_page");
 ?>
   <a href="<?php echo get_permalink($linkedin_login); ?>">
            <img src="<?php echo get_stylesheet_directory_uri();?>/images/linkedin-button.png" alt="image" />
   </a>
<?php
//echo do_shortcode('[wpli_login_link]');
?>
