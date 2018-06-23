<?php
/*
 * Display the default tags.
 */

$postType = get_post_type();

$output = "";

if ($postType == "page") {
//leave blank.
echo '';
} else if ($postType == "companies_act") {
	//get taxonomy link
$output = eminds_get_taxonomy_link(get_the_ID(), "tags_ca2013",1);
} else {
$output = eminds_get_taxonomy_link(get_the_ID(), "post_tag",1);
}

//display the output .
if(!empty($output)){
	
	echo '<p class="margin-btm-none">';
	echo $output;
	echo '</p>';
}