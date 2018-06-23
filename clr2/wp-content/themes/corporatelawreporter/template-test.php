<?php
/*
Template Name: Customers
*/
get_header();
?>
<!-- end header -->
<section class="container-fluid middle-container">
    <section class="row" >
        <section class="posts-content author-detail">
        <?php
global $wpdb;
$customers = $wpdb->get_results("SELECT * FROM contacts;");
echo "<table>";
foreach($customers as $customer){
echo "<tr>";
echo "<td>".$customer->contact_id."</td>";
echo "<td>".$customer->contact_first."</td>";
echo "<td>".$customer->contact_last."</td>";
echo "<td>".$customer->contact_email."</td>";
echo "</tr>";
}
echo "</table>";
?>
         </section>
        <?php get_sidebar(); ?>
    </section>
</section>

<!-- start footer -->
<?php
get_footer();
?>