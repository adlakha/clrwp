<?php
/*
 * Advertisement  : display in bottom of the content : single page
 */
 ?>
<?php
//Google addsense code here.



$addCode = clr_of_get_option("google_advertise_codefor_single_bottom");	
if($addCode){
?>
<section class="full-view-advertise">
	<?php echo do_shortcode($addCode); ?>
</section>
<?php
}
?>