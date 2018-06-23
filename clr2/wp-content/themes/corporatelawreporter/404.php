<?php
/*
 * 404 default template file.
 *  */
get_header();
?>
<!-- end header -->
<section class="container-fluid">
    <section class="row">
        <section class="col-sm-8">
            <section class="posts-content">
                <!-- start post -->
                <section class="post-column clearfix">
                    
                    <h2>404 Error</h2>
                   <p>It looks like nothing was found at this location. Maybe try a search?</p>
                   
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