<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'options-framework-theme';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'theme-textdomain' ),
		'two' => __( 'Two', 'theme-textdomain' ),
		'three' => __( 'Three', 'theme-textdomain' ),
		'four' => __( 'Four', 'theme-textdomain' ),
		'five' => __( 'Five', 'theme-textdomain' )
	);

	$hide_options = array(
		'1' => __( 'Show', 'eminds' ),
		'0' => __( 'Hide', 'eminds' )
	);
	
	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'theme-textdomain' ),
		'two' => __( 'Pancake', 'theme-textdomain' ),
		'three' => __( 'Omelette', 'theme-textdomain' ),
		'four' => __( 'Crepe', 'theme-textdomain' ),
		'five' => __( 'Waffle', 'theme-textdomain' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
//************************************************************ : 
 $options_categories_obj_product = get_terms( 'product_cat', array(
 	'orderby'    => 'count',
 	'hide_empty' => 0,
 ) );
 
$options_categories_product = array();
	
	foreach ($options_categories_obj_product as $category) {
		$options_categories_product[$category->term_id] = $category->name;
	}
//----------------------
$options_categories_obj_contenttype = get_terms( 'legal', array(
 	'orderby'    => 'count',
 	'hide_empty' => 0,
 ) );
 
$options_categories_contenttype = array();
	
	foreach ($options_categories_obj_contenttype as $category) {
		$options_categories_contenttype[$category->term_id] = $category->name;
	}	
//*********************************************************************************************
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress,wplink' )
	 );


	$options = array();

	$options[] = array(
		'name' => __( 'Basic Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);

	
$options[] = array(
		'name' => __( 'Header Logo', 'theme-textdomain' ),
		'desc' => __( 'Upload the header logo.', 'theme-textdomain' ),
		'id' => 'header_logo',
		'std'=> get_stylesheet_directory_uri().'/images/logo.jpg',
		'type' => 'upload'
	);

$options[] = array(
		'name' => __( 'Footer Logo', 'theme-textdomain' ),
		'desc' => __( 'Upload the Footer logo.', 'theme-textdomain' ),
		'id' => 'footer_logo',
		'std'=> get_stylesheet_directory_uri().'/images/logo-clr.png',
		'type' => 'upload'
	);

	
	$options[] = array(
		'name' => __( 'Select Companies Act 2013 Page', 'theme-textdomain' ),
		'desc' => __( 'Select Companies Act 2013 page which is used for setting the website.', 'theme-textdomain' ),
		'id' => 'corporate_act_reporter',
		'type' => 'select',
		'options' => $options_pages
	);

	$options[] = array(
		'name' => __( 'Select Event category from content Type', 'theme-textdomain' ),
		'desc' => __( 'Select Event category which is used for setting the website.', 'theme-textdomain' ),
		'id' => 'event_category_content_type',
		'type' => 'select',
		'options' => $options_categories_contenttype
	);

$options[] = array(
		'name' => __( 'Select Event category from woocommerce', 'theme-textdomain' ),
		'desc' => __( 'Select Event category which is used for setting the website as well as it is used to create a group of product.', 'theme-textdomain' ),
		'id' => 'event_category',
		'type' => 'select',
		'options' => $options_categories_product
	);

$options[] = array(
		'name' => __( 'Select Submit Article Page', 'theme-textdomain' ),
		'desc' => __( 'Select Submit Article page which is used for setting the website.', 'theme-textdomain' ),
		'id' => 'submit_article_page',
		'type' => 'select',
		'options' => $options_pages
	);


$options[] = array(
		'name' => __( 'Select Linkedin Login Page', 'theme-textdomain' ),
		'desc' => __( 'Select Linkedin Login page which is used for setting the website.', 'theme-textdomain' ),
		'id' => 'linkedin_login_page',
		'type' => 'select',
		'options' => $options_pages
	);
		

//$options[] = array(
//		'name' => __( 'Select category on home Page', 'theme-textdomain' ),
//		'desc' => __( 'This selected category is shown on homePage besides latest tab.', 'theme-textdomain' ),
//		'id' => 'category_homepage',
//		'type' => 'multicheck',
//		'options' => $options_categories
//	);


$options[] = array(
		'name' => __( 'Enter the copyright text', 'theme-textdomain' ),
		'desc' => __( 'Enter the copyright text which will display in bottom of the website.', 'theme-textdomain' ),
		'id' => 'copyrigt_text',
		'type' => 'textarea'
	);
	
$options[] = array(
		'name' => __( 'Adsense Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);	

$options[] = array(
		'name' => __('Header Google advertise code', 'theme-textdomain' ),
		'desc' => sprintf( __('This advertise will be display on header. ', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'google_advertise_codefor_header',
		'type' => 'editor',
		'settings' => $wp_editor_settings);


$options[] = array(
		'name' => __('Enter the Google advertise code for single page : Display in top of content', 'theme-textdomain' ),
		'desc' => sprintf( __('This advertise will be display on detail page of the Legal and company Act. ', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'google_advertise_codefor_single',
		'type' => 'editor',
		'settings' => $wp_editor_settings);
		

$options[] = array(
		'name' => __('Enter the Google advertise code for single page : Display in bottom of content', 'theme-textdomain' ),
		'desc' => sprintf( __('This advertise will be display on detail page of the Legal and company Act. ', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'google_advertise_codefor_single_bottom',
		'type' => 'editor',
		'settings' => $wp_editor_settings);

$options[] = array(
		'name' => __('Advertise code for HomePage', 'theme-textdomain' ),
		'desc' => sprintf( __('This advertise will be display on home page before 2nd post of legal update. ', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'google_advertise_codefor_homepage_before2ndpost',
		'type' => 'editor',
		'settings' => $wp_editor_settings);
		
$options[] = array(
		'name' => __('Advertise code for Companies Act 2013 page', 'theme-textdomain' ),
		'desc' => sprintf( __('This advertise will be display on page:Companies Act 2013 : before 2nd chapter. ', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'google_advertise_codefor_ca2013_before2ndchapter',
		'type' => 'editor',
		'settings' => $wp_editor_settings);				
	

	$options[] = array(
		'name' => __( 'Follow us Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);
/*		
	$options[] = array(
		'name' => __( 'Enter the follow us text', 'theme-textdomain' ),
		'desc' => __( 'Enter the follow us text which will be displyed besides the social icons.', 'theme-textdomain' ),
		'id' => 'follow_text',
		'std'=>'Follow Us',
		'type' => 'text'
	);

$options[] = array(
		'name' => __( 'Enter the rss link', 'theme-textdomain' ),
		'desc' => __( 'Enter the rss link which is used for setting through out the website.', 'theme-textdomain' ),
		'id' => 'rss_link',
		'type' => 'text'
	);
*/		

	$options[] = array(
		'name' => __( 'Enter the facebook link', 'theme-textdomain' ),
		'desc' => __( 'Enter the facebook link which is used for setting through out the website.', 'theme-textdomain' ),
		'id' => 'facebook_link',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Enter the twitter link', 'theme-textdomain' ),
		'desc' => __( 'Enter the twitter link which is used for setting through out the website.', 'theme-textdomain' ),
		'id' => 'twitter_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __( 'Enter the Googleplus link', 'theme-textdomain' ),
		'desc' => __( 'Enter the Googleplus link which is used for setting through out the website.', 'theme-textdomain' ),
		'id' => 'gplus_link',
		'type' => 'text'
	);
	
	
	$options[] = array(
		'name' => __( 'Enter the linkedin link', 'theme-textdomain' ),
		'desc' => __( 'Enter the linkedin link which is used for setting through out the website.', 'theme-textdomain' ),
		'id' => 'linkedin_link',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __( 'Advanced Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);

$options[] = array(
		'name' => __( 'Linkedin API key', 'theme-textdomain' ),
		'desc' => __( 'Enter the linkedin API key which is used for setting the linkedin login.', 'theme-textdomain' ),
		'id' => 'linkedin_apikey',
		'type' => 'text'
	);

$options[] = array(
		'name' => __( 'Linkedin Secret key', 'theme-textdomain' ),
		'desc' => __( 'Enter the linkedin Secret key which is used for setting the linkedin login.', 'theme-textdomain' ),
		'id' => 'linkedin_secretkey',
		'type' => 'text'
	);

$options[] = array(
		'name' => __( 'Linkedin Redirect URL After login', 'theme-textdomain' ),
		'desc' => __( 'Enter the linkedin Redirect URL which is used for setting the linkedin login.', 'theme-textdomain' ),
		'id' => 'linkedin_redirecturl',
		'type' => 'text' 
	);


$options[] = array(
		'name' => __( 'Emergency Hide', 'theme-textdomain' ),
		'desc' => __( 'For hide the last udpated date in companies act single page.', 'theme-textdomain' ),
		'id' => 'emergency_hide_ca2013',
		'type' => 'select',
		'options' => $hide_options
	);


$options[] = array(
		'name' => __( 'Enter the Feedburner popup title', 'theme-textdomain' ),
		'desc' => __( 'This title will shown on feedburner popup.', 'theme-textdomain' ),
		'id'   => 'feedburner_popup_title',
		'std'  =>'Subscribe to the Daily Journal',
		'type' => 'text'
	);


$options[] = array(
		'name' => __( 'Enter the Feedburner popup text', 'theme-textdomain' ),
		'desc' => __( '(Optional Field)This text will shown above the email on feedburner popup.', 'theme-textdomain' ),
		'id'   => 'feedburner_popup_content',
		'type' => 'textarea'
	);
	

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */


	// $options[] = array(
		// 'name' => __( 'Default Text Editor', 'theme-textdomain' ),
		// 'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'theme-textdomain' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		// 'id' => 'example_editor',
		// 'type' => 'editor',
		// 'settings' => $wp_editor_settings
	// );


// added theme option to select template for updating the account by using scratch code - 5 th oct
	$options[] = array(
		'name' => __( 'Select Scratch card update Page', 'theme-textdomain' ),
		'desc' => __( 'Select Scratch card update Page which is used for setting the website for existing user account.', 'theme-textdomain' ),
		'id' => 'update_account_page',
		'type' => 'select',
		'options' => $options_pages
	);


	return $options;
}