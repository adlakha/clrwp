<?php
/*
 * Post pagination  
 */
?>
<!-- start pagination -->
<section class="pagination">
    <?php
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    }
    ?>
</section>
<!-- end pagination -->