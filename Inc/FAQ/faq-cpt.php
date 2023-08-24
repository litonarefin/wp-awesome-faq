<?php

/*
 * Creating custom cost type to  adding FAQs.
 */
function jltmaf_register_faq_post_type() {

	// Register FAQs Post Type
	$labels = array(
		'name'                => _x( 'FAQs', 'wp-awesome-faq' ),
		'singular_name'       => _x( 'FAQ', 'wp-awesome-faq' ),
		'menu_name'           => __( 'FAQs', 'wp-awesome-faq' ),
		'parent_item_colon'   => __( 'Parent FAQs:', 'wp-awesome-faq' ),
		'all_items'           => __( 'All FAQs', 'wp-awesome-faq' ),
		'view_item'           => __( 'View FAQ', 'wp-awesome-faq' ),
		'add_new_item'        => __( 'Add New FAQ', 'wp-awesome-faq' ),
		'add_new'             => __( 'New FAQ', 'wp-awesome-faq' ),
		'edit_item'           => __( 'Edit FAQ', 'wp-awesome-faq' ),
		'update_item'         => __( 'Update FAQ', 'wp-awesome-faq' ),
		'search_items'        => __( 'Search FAQs', 'wp-awesome-faq' ),
		'not_found'           => __( 'No FAQs found', 'wp-awesome-faq' ),
		'not_found_in_trash'  => __( 'No FAQs found in Trash', 'wp-awesome-faq' ),
		);
	$args = array(
		'label'               => __( 'FAQ', 'wp-awesome-faq' ),
		'description'         => __( 'Jewel Theme FAQ Post Type', 'wp-awesome-faq' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 20,
		'menu_icon' 		  => 'dashicons-welcome-write-blog',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest' 	      => true

	);
	register_post_type( 'faq', $args );

	//Register Category Taxonomy FAQs
	register_taxonomy( 'faq_cat', 'faq', array(
		'labels'                     =>  __( 'Categories', 'wp-awesome-faq' ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest' 	      		 => true,
	) );

	// Register Tags Taxonomy FAQs
	register_taxonomy( 'faq_tags', 'faq', array(
		'labels'                     => __( 'Tags', 'wp-awesome-faq' ),
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest' 	      		 => true,
	) );
}

// Hook into the 'init' action
add_action( 'init', 'jltmaf_register_faq_post_type', 0 );
