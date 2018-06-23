<?php
/*
 * Currently disabled module.
 * #Template Name#Category checking Module
 */
get_header();
?>          <!-- end header -->
<section class="container-fluid">
    <section class="row">
        <section class="col-sm-8">
            <section class="posts-content left-manageheight">
                <!-- start jump to -->
                
                <section class="fr ca2013">
                	<?php echo do_shortcode('[emind_jumpto_form]'); ?>
                </section>	
                   
                <!-- end jump to -->
                <strong class="main-heading display-b"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
                <!-- start company acts -->
                <section class="company-act-column">
                	<h2>Category</h2>
                    <?php
                    $cat_ca2013_mod = get_terms('category', array(
                        'orderby' => 'none',
                        'number'  => '100', 
						'hide_empty' => 0
                    ));
					
					//echo '<pre>';print_r($cat_ca2013_mod);echo '</pre>';
					
//taxonomy loop start here
                    if (is_array($cat_ca2013_mod)) {
                        foreach ($cat_ca2013_mod as $cat) {
                            $catname = $cat->name;
                            $catid = $cat->term_id;
                            $slug = $cat->slug;
                            ?>

                            <h3><a href="<?php echo get_term_link($cat); ?>"><?php echo $catname; ?></a></h3>
      <?php
                        }
                    }
                    ?>
                </section>
                
                
                <!-- ***************************  -->
                                <section class="company-act-column">
                                	<h2>Content Type</h2>
                    <?php
                    $cat_ca2013_legal = get_terms('legal', array(
                        'orderby' => 'none',
                        'number'  => '100', 
						'hide_empty' => 0
                    ));
					
					//echo '<pre>';print_r($cat_ca2013_mod);echo '</pre>';
					
//taxonomy loop start here
                    if (is_array($cat_ca2013_legal)) {
                        foreach ($cat_ca2013_legal as $cat) {
                            $catname = $cat->name;
                            $catid = $cat->term_id;
                            $slug = $cat->slug;
                            ?>

                            <h3><a href="<?php echo get_term_link($cat); ?>"><?php echo $catname; ?></a></h3>
      <?php
                        }
                    }
                    ?>
                </section>
                
                <!-- end company act -->
            </section>
        </section>
        <?php
        //call the sidebar
        get_sidebar();
        ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>