<?php
/*
 * Template Name: Submit Article
 */
get_header();
?>
<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row" >
        <section class="posts-content author-detail">
            
                <?php 
                if(is_user_logged_in()){
                    //call the template
                get_template_part('author','profile');
                
                }else{
                 //call the template
                get_template_part('author','login');   
                
                }
                
                ?>
               
                <!-- end post -->						
            
        </section>
        <?php get_sidebar(); ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>