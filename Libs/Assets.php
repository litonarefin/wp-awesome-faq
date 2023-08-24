<?php
namespace JLTWPAFAQ\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     4.2.0
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jltwpafaq_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jltwpafaq_admin_enqueue_scripts' ), 100 );
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jltwpafaq_enqueue_scripts() {

			// CSS Files .
			wp_enqueue_style( 'wp-awesome-faq-frontend', JLTWPAFAQ_ASSETS . 'css/wp-awesome-faq-frontend.css', JLTWPAFAQ_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'wp-awesome-faq-frontend', JLTWPAFAQ_ASSETS . 'js/wp-awesome-faq-frontend.js', array( 'jquery' ), JLTWPAFAQ_VER, true );
		}


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jltwpafaq_admin_enqueue_scripts() {
			// CSS Files .
			wp_enqueue_style( 'wp-awesome-faq-admin', JLTWPAFAQ_ASSETS . 'css/wp-awesome-faq-admin.css', array( 'dashicons' ), JLTWPAFAQ_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'wp-awesome-faq-admin', JLTWPAFAQ_ASSETS . 'js/wp-awesome-faq-admin.js', array( 'jquery' ), JLTWPAFAQ_VER, true );
			wp_localize_script(
				'wp-awesome-faq-admin',
				'JLTWPAFAQCORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'recommended_nonce' => wp_create_nonce( 'jltwpafaq_recommended_nonce' ),
				)
			);
		}
	}
}