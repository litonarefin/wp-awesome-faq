<?php 
// Register Master Accordion Blocks
add_action( 'init', 'jltmaf_register_master_accordion_block' );

if ( ! function_exists( 'jltmaf_register_master_accordion_block' ) ) {
	function jltmaf_register_master_accordion_block(){

		// Gutenberg is not active.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		wp_register_script(
			'jltmaf-block',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			// filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
			MAF_DIR . '/inc/gutenberg/block.js'
		);

		register_block_type('master-accordion/faq', array(
				//'editor_script' => 'jltmaf-block',
				'render_callback' => 'jltmaf_guten_render_callback',
				'attributes' => array(
					'numCols' => array(
						'type' 		=> 'number',
						'default'	=> '4' // nb: a default is needed!
					),
					'token' => array(
						'type' 		=> 'string',
						'default' => ''
					),
					'useThumbnail' => array(
						'type' 		=> 'boolean',
						'default' => false
					),
					'numImages' => array(
						'type' 		=> 'number',
						'default' => 4
					),
					'gridGap' => array(
						'type' 		=> 'number',
						'default'	=> 0
					),
					'showProfile'	=> array(
						'type'		=> 'boolean',
						'default'	=> false
					),
					'backgroundColor'	=> array(
						'type'		=> 'string',
						'default'	=> 'transparent',
					),
				)
			)
		);

	  	if ( function_exists( 'wp_set_script_translations' ) ) {
	    	wp_set_script_translations( 'jltmaf-block', 'jltmaf' );
	  	}

	}
}



	/**
	 * Server side rendering functions
	 */
	function jltmaf_guten_render_callback( array $attributes ){

		
		echo "Accordion Render callback";
	}