<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function jltmaf_gutenberg_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'master_accordion-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'inc/gutenberg/dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'master_accordion-cgb-block-js', // Handle.
		plugins_url( 'dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'inc/gutenberg/dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'master_accordion-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'inc/gutenberg/dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'master_accordion-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'jltmaf/master-accordion', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'master_accordion-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'master_accordion-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'master_accordion-cgb-block-editor-css',
			'render_callback' => 'jltmaf_guten_render_callbacks',
			'attributes' => array(
				'className' => array(
					'type' => 'string',
				),
				'align' => array(
					'type' => 'string',
					'default' => 'center',
				),				
				'postsToShow' => array(
					'type' => 'number',
					'default' => 6,
				),
				'orderBy'  => array(
					'type' => 'string',
					'default' => 'date',
				),				
				'faqCat' => array(
					'type' => 'string',
					'def;ault' => '',
				),				
				'faqTags' => array(
					'type' => 'string',
				),
				'order' => array(
					'type' => 'string',
					'default' => 'desc',
				),

			),

		)
	);

	add_shortcode( 'faq', 'jltmaf_guten_render_callbacks' );

}

// Hook: Block assets.
add_action( 'init', 'jltmaf_gutenberg_block_assets' );






function jltmaf_guten_render_callbacks( $attributes, $content ){
	global $post;

	$faqCat = isset( $attributes['faqCat'] ) ? $attributes['faqCat'] : '';
	$faqTags = isset( $attributes['faqTags'] ) ? $attributes['faqTags'] : '';
	$items = isset( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : '-1';
	$order = isset( $attributes['order'] ) ? $attributes['order'] : 'desc';
	$orderBy = isset( $attributes['orderBy'] ) ? $attributes['orderBy'] : 'title';


	$recent_posts = wp_get_recent_posts( array(
		'post_type'        	=> 'faq',
		'numberposts' 		=> $items,
		'post_status' 		=> 'publish',
		'order' 			=> $order,
		'orderby' 			=> $orderBy,
		'faq_cat' 			=> $faqCat
	), 'OBJECT' );


	$list_items_markup = '';

	$count = 0; 
	$accordion = 'accordion-' . time() . rand();

	$jltmaf_id = $accordion .  $count;
	

	if ( $recent_posts ) {
		foreach ( $recent_posts as $post ) {
			setup_postdata( $post );
			$post_id = $post->ID;
			
			$list_items_markup .= sprintf(
				'<div class="%1$s"><div class="%2$s"><h3 class="%3$s">
				<a data-toggle="collapse" class="collapsed" data-parent="#%4$s" href="#%5$s-%6$s">
				<span class="pull-right jltmaf-icon">%7$s</span>%8$s</a></h3></div></div><div id="%5$s-%6$s" class="%9$s"><div class="panel-body">%10$s</div></div></div>',

				'panel panel-default',
				'jltmaf-item panel-heading',
				'panel-title',
				$jltmaf_id,
				$accordion,
				get_the_ID(),
				'',
				get_the_title( $post_id ),
				'panel-collapse collapse',
				$post->post_content
			);


		}
	}


	// Output the post markup
	$block_content = sprintf(
		'<div id="jltmaf-awesome-faq-%1$s"><div class="panel-group" id="%2$s">%3$s</div></div>',
		esc_attr( $accordion ),
		esc_attr( $jltmaf_id ),
		$list_items_markup
	);

	return $block_content;

}