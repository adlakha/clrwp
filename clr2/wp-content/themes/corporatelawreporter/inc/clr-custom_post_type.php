<?php
/*
 * Custom post type of the website. 
 */

add_action( 'init', 'register_cpt_companies_act' );

function register_cpt_companies_act() {

    $labels = array( 
        'name' => _x( 'Companies Act', 'companies_act' ),
        'singular_name' => _x( 'Companies Act', 'companies_act' ),
        'add_new' => _x( 'Add New', 'companies_act' ),
        'add_new_item' => _x( 'Add New Companies Act', 'companies_act' ),
        'edit_item' => _x( 'Edit Companies Act', 'companies_act' ),
        'new_item' => _x( 'New Companies Act', 'companies_act' ),
        'view_item' => _x( 'View Companies Act', 'companies_act' ),
        'search_items' => _x( 'Search Companies Act', 'companies_act' ),
        'not_found' => _x( 'No companies act found', 'companies_act' ),
        'not_found_in_trash' => _x( 'No companies act found in Trash', 'companies_act' ),
        'parent_item_colon' => _x( 'Parent Companies Act:', 'companies_act' ),
        'menu_name' => _x( 'Companies Act', 'companies_act' ),
        'all_items' => _x( 'Sections', 'companies_act' ),
    );

    $args = array( 
        'labels' => $labels,
         'capabilities' => array(
						        'publish_posts' => 'manage_options',
						        'edit_posts' => 'manage_options',
						        'edit_others_posts' => 'manage_options',
						        'delete_posts' => 'manage_options',
						        'delete_others_posts' => 'manage_options',
						        'read_private_posts' => 'manage_options',
						        'edit_post' => 'manage_options',
						        'delete_post' => 'manage_options',
						        'read_post' => 'manage_options',
						    ),
       'hierarchical' => TRUE,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments','page-attributes' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => FALSE,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'companies_act', $args );
    
    // Add new taxonomy, NOT hierarchical (like tags)
	$labelsca = array(
		'name'                       => _x( 'Act Chapter', 'taxonomy general name' ),
		'singular_name'              => _x( 'Act Chapter', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Act Chapter' ),
		'popular_items'              => __( 'Popular Act Chapter' ),
		'all_items'                  => __( 'All Act Chapter' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Act Chapter' ),
		'update_item'                => __( 'Update Act Chapter' ),
		'add_new_item'               => __( 'Add New Act Chapter' ),
		'new_item_name'              => __( 'New Act Chapter Name' ),
		'separate_items_with_commas' => __( 'Separate Act Chapter with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Act Chapter' ),
		'choose_from_most_used'      => __( 'Choose from the most used Act Chapter' ),
		'not_found'                  => __( 'No Act Chapter found.' ),
		'menu_name'                  => __( 'Chapter' ),
	);

	$argsca = array(
		'hierarchical'          => TRUE,
		'labels'                => $labelsca,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'act_chapter' ),
	);

	register_taxonomy( 'act_chapter',array('chapter_form','companies_act'), $argsca );
      //Adding the tax on this posts
       	$labelscatag = array(
		'name'                       => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'              => _x( 'Tags', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Tags' ),
		'popular_items'              => __( 'Popular Tags' ),
		'all_items'                  => __( 'All Tags' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tags' ),
		'update_item'                => __( 'Update Tags' ),
		'add_new_item'               => __( 'Add New Tags' ),
		'new_item_name'              => __( 'New Tags Name' ),
		'separate_items_with_commas' => __( 'Separate Tags with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Tags' ),
		'choose_from_most_used'      => __( 'Choose from the most used Tags' ),
		'not_found'                  => __( 'No Tags found.' ),
		'menu_name'                  => __( 'Tags' ),
	);

	$argscatags = array(
		'hierarchical'          => false,
		'labels'                => $labelscatag,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'tags_ca2013' ),
	);

       register_taxonomy( 'tags_ca2013', 'companies_act', $argscatags ); 
        
      flush_rewrite_rules();  
}
/*
 *Add taxonomy in post section : Content Type 
 */
    // Add new taxonomy, NOT hierarchical (like tags)
	$labelsPost = array(
		'name'                       => _x( 'Content Type', 'taxonomy general name' ),
		'singular_name'              => _x( 'Content Type', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Content Type' ),
		'popular_items'              => __( 'Popular Content Type' ),
		'all_items'                  => __( 'All Content Type' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Content Type' ),
		'update_item'                => __( 'Update Content Type' ),
		'add_new_item'               => __( 'Add New Content Type' ),
		'new_item_name'              => __( 'New Content Type Name' ),
		'separate_items_with_commas' => __( 'Separate Content Type with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Content Type' ),
		'choose_from_most_used'      => __( 'Choose from the most used Content Type' ),
		'not_found'                  => __( 'No Content Type found.' ),
		'menu_name'                  => __( 'Content Type' ),
	);

	$argspsot = array(
		'hierarchical'          => TRUE,
		'labels'                => $labelsPost,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'legal' ),
	);

	register_taxonomy( 'legal', 'post',$argspsot );
	
/*
 *Chapter Forms : CPT 
 */	
add_action( 'init', 'register_cpt_chapter_form' );

function register_cpt_chapter_form() {

    $labels = array( 
        'name' => _x( 'Chapter Form', 'chapter_form' ),
        'singular_name' => _x( 'Chapter Form', 'chapter_form' ),
        'add_new' => _x( 'Add New', 'chapter_form' ),
        'add_new_item' => _x( 'Add New Chapter Form', 'chapter_form' ),
        'edit_item' => _x( 'Edit Chapter Form', 'chapter_form' ),
        'new_item' => _x( 'New Chapter Form', 'chapter_form' ),
        'view_item' => _x( 'View Chapter Form', 'chapter_form' ),
        'search_items' => _x( 'Search Chapter Form', 'chapter_form' ),
        'not_found' => _x( 'No chapter form found', 'chapter_form' ),
        'not_found_in_trash' => _x( 'No chapter form found in Trash', 'chapter_form' ),
        'parent_item_colon' => _x( 'Parent Chapter Form:', 'chapter_form' ),
        'menu_name' => _x( 'Forms', 'chapter_form' ),
    );

    $args = array( 
        'labels' => $labels,
           'capabilities' => array(
						        'publish_posts' => 'manage_options',
						        'edit_posts' => 'manage_options',
						        'edit_others_posts' => 'manage_options',
						        'delete_posts' => 'manage_options',
						        'delete_others_posts' => 'manage_options',
						        'read_private_posts' => 'manage_options',
						        'edit_post' => 'manage_options',
						        'delete_post' => 'manage_options',
						        'read_post' => 'manage_options',
						    ),
        'hierarchical' => true,
        
        'supports' => array( 'title','excerpt','editor','page-attributes' ),
        
        'public' => true,
        'show_ui' => true,
      //  'show_in_menu' => true,
       'show_in_menu' => 'edit.php?post_type=companies_act', 
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'rewrite'         => array( 'slug' => 'mca_forms' ),
        
    );

    register_post_type( 'chapter_form', $args );
	flush_rewrite_rules();
}	
?>