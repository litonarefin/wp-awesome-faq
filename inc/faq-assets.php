<?php

/*
* Load Script When adding new post
*/
add_action( 'admin_enqueue_scripts', 'jltmaf_load_admin_scripts' );
function jltmaf_load_admin_scripts() {
	global $typenow;
	if( $typenow == 'faq' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style('dashicons');
	}

	// Scripts
	wp_enqueue_style( 'fonticonpicker', MAF_URL . '/assets/fonticonpicker/css/base/jquery.fonticonpicker.min.css', false, MAF_VERSION );		
	wp_enqueue_style( 'fonticonpicker-grey', MAF_URL . '/assets/fonticonpicker/css/themes/grey-theme/jquery.fonticonpicker.grey.min.css', false, MAF_VERSION );
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css' );	

	wp_enqueue_script( 'fonticonpicker', MAF_URL . '/assets/fonticonpicker/js/jquery.fonticonpicker.min.js', array( 'jquery'), MAF_VERSION, true );	
	wp_enqueue_script( 'master-accordion-admin', MAF_URL . '/assets/js/proscript.js', array('jquery', 'wp-color-picker'), MAF_VERSION, true );
}


/*
 * Enqueue Bootstrap According JS and Styleseets
 */
add_action( 'wp_enqueue_scripts', 'jltmaf_frontend_scripts' );
function jltmaf_frontend_scripts() {
	wp_enqueue_style( 'master-accordion', MAF_URL . '/assets/css/master-accordion.css', array(), MAF_VERSION, 'all' );
	wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css' );		
	wp_enqueue_script( 'master-accordion', MAF_URL . '/assets/js/master-accordion.js', array('jquery'), MAF_VERSION, true );


	$jltmaf_post_close_icon = get_post_meta( get_the_ID(), 'close_icon', true );
	$jltmaf_options_close_icon = jltmaf_options('faq_close_icon', 'jltmaf_settings' );

	$jltmaf_post_open_icon = get_post_meta( get_the_ID(), 'open_icon', true );
	$jltmaf_options_open_icon = jltmaf_options('faq_open_icon', 'jltmaf_settings' );

	$localize_data = array(
		'close_icon'    => ($jltmaf_post_close_icon) ? $jltmaf_post_close_icon : $jltmaf_options_close_icon,
		'open_icon'     => ($jltmaf_post_open_icon) ? $jltmaf_post_open_icon : $jltmaf_options_open_icon
	);
	wp_localize_script( 'master-accordion', 'jltmaf_scripts', $localize_data );
}



add_action( 'admin_head', 'jltmaf_dashboard_icon' );
// Add FAQs icon in dashboard
function jltmaf_dashboard_icon(){ ?>
	<style>
		/*FAQs Dashboard Icons*/
		#adminmenu .menu-icon-faq div.wp-menu-image:before { content: "\f348"; }
	</style>
	<?php
}