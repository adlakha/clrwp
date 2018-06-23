<?php
/*
 * Post sharing right direction.
 */
?>
<section class="follow-us fr clearfix">
    <ul>
        <li class=""></li>
        <li class="fb margin-none">
            <a title="Share on Facebook" class="shareon facolor" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(get_the_ID()); ?>&t=<?php echo get_the_title(); ?> | IT Exchange"><i class="fa fa-facebook col-md-1"></i></a>
        </li>
        <li class="twitter">
            <a title="Share on Twitter" class="shareon twcolor" target="_blank" href="http://twitter.com/home?status=<?php echo get_permalink(get_the_ID()); ?>"><i class="fa fa-twitter col-md-1"></i></a>
        </li>

        <li class="google">
            <a title="Share on Google plus" target="_blank" href="https://plus.google.com/share?url=<?php echo get_permalink(get_the_ID()); ?> "></a>
        </li>
        <li class="linkedin">
            <a title="Share on LinkedIn" class="shareon licolor" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(get_the_ID()); ?>&title=<?php echo get_the_title(); ?> | IT Exchange &summary=<?php the_excerpt(); ?>"><i class="fa fa-linkedin col-md-1"></i></a> 
        </li>
        
       <?php if(is_single()){ ?> 
        <li class="print-icon">
        	<a title="Print Page"  target="_blank" href="http://www.printfriendly.com/print?url=<?php echo get_permalink(get_the_ID()); ?>">
	        <img src="<?php echo get_stylesheet_directory_uri()."/images/printer.png" ?>" alt="printicon" title="Print Page">
          </a>  
        </li>
         <?php }  ?>
         <?php if(is_single() || is_page()){ ?> 
        <li style="background:none;">
        	<?php 
            	/*
			     *New Feature : Edit link - when administrator login. 
				  */
			   echo admin_edit_link(get_the_ID());
            ?>
        </li>
        
        
        <?php }  ?>
          
    </ul>
    
     
          
</section>
<?php 
//for every page, call - clearfix - for reset the floating
if(is_page()){
	echo '<div class="clearfix"></div>';
}
?>