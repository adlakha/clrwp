<?php
/*
 * Advertisement  : display in top of the content : single page
 */
?>
<?php
//Google addsense code here.
/*
*Advertisement image will exclude or include: Check - exclude
*/
$flag_show_adv = get_post_meta(get_the_ID(),"exclude_the_advertisement_image",TRUE);
if($flag_show_adv){
;
}else{
$addCode = clr_of_get_option("google_advertise_codefor_single");	

?>
<section class="full-view-advertise fl">
	<?php echo do_shortcode($addCode); ?>
</section>
<?php
}
?>