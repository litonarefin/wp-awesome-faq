<?php 
// Register Master Accordion Blocks
add_action( 'init', 'jltmaf_register_master_accordion_block' );

if ( ! function_exists( 'jltmaf_register_master_accordion_block' ) ) {
	function jltmaf_register_master_accordion_block(){

		// Check if the register function exists
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type('master-accordion/accordion', array(
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
		

	}
}



	/**
	 * Server side rendering functions
	 */
	function jltmaf_guten_render_callback( array $attributes ){

		
		echo "Accordion Render callback";
	}