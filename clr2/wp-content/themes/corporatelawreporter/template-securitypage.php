<?php
/*
 *Template Name:Security Page
 *  */
get_header();
//redirect on book page
//wp_redirect( home_url() ); exit;
//return;
?>
<script>
location.href="<?php echo home_url(); ?>";
</script>
<!-- end header -->
<section class="container-fluid middle-container security-page">
    <section class="row position-rel">
        <section class="col-sm-8">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix">
                    
                    <strong class="main-heading display-b">
                    	<?php the_title(); ?>
                    	 <?php
					  /*
                       *Post sharing in right direction
                       */
                       get_template_part('post','sharing-right');
						?>
                    </strong>
    				 

                    <?php 
                    if(have_posts()):
                        while (have_posts()):the_post();
                    $imgHTML=eminds_get_thumbnail_html_with_customsize(get_the_ID(),'full',"thumbnailimage");
                    if(!empty($imgHTML)){
                    ?>
                     <section class="full-view-advertise fl">
                          <?php echo $imgHTML; ?>
                     </section>
                    <?php } ?>
                   <?php// the_content(); ?>   
                  <?php 
                    endwhile;
                  endif;
                  ?>
                </section>
                <!-- end post -->
            </section>
        </section>
        <?php
        //get  the sidebar
        get_sidebar();
        ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>
