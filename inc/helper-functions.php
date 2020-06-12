<?php

// Render Options data from admin settings

function jltmaf_options( $option, $section, $default = '' ) {

	$options = get_option( $section );

	if ( isset( $options[$option] ) ) {
		return $options[$option];
	}

	return $default;
}




function jltmaf_get_post_settings( $settings ) {

	$post_args['post_type'] 		= 'faq';
	$post_args['faq_cat'] 			= $settings['jltmaf_faq_cats'];
	$post_args['faq_tags']  		= $settings['jltmaf_faq_tags'];
	$post_args['posts_per_page'] 	= $settings['jltmaf_faq_items'];
	$post_args['order'] 			= $settings['jltmaf_faq_order'];

	return $post_args;
}



function jltmaf_get_post_data($args, $cat, $tag, $items, $order){
	$defaults = array(
		'post_type'              => 'faq',
		'faq_cat'          		 => $cat,
		'faq_tags'               => $tag,
		'posts_per_page'         => $items,
		'order'                  => $order,
	);

	$atts = wp_parse_args( $args, $defaults );

	$posts = get_posts( $atts );

	return $posts;
}
