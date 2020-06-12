<?php
/* Gutenberg Support */
global $wp_version;

// Elementor Activated
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'elementor/elementor.php' ) ) {    
    jltmaf_elementor_dependency();
}

function jltmaf_elementor_dependency(){
	include( MAF_DIR . '/inc/elementor/class-master-faq-elementor.php');
}


// Gutenberg Dependency
if ( version_compare( $wp_version, '5.0', '>=' ) ) {
	if (is_admin()) {
		add_filter( 'block_categories', 'jltmaf_gutenberg_block_category', 10, 2 );
	}
	include( MAF_DIR . '/inc/faq-guternberg.php');
}

function jltmaf_gutenberg_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'master-accordion',
				'title' => esc_html__( 'Master Accordion', MAF_TD),
			),
		)
	);
}