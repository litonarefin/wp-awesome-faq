<?php
namespace JLTWPAFAQ;

use JLTWPAFAQ\Libs\Assets;
use JLTWPAFAQ\Libs\Helper;
use JLTWPAFAQ\Libs\Featured;
use JLTWPAFAQ\Inc\Classes\Recommended_Plugins;
use JLTWPAFAQ\Inc\Classes\Notifications\Notifications;
use JLTWPAFAQ\Inc\Classes\Pro_Upgrade;
use JLTWPAFAQ\Inc\Classes\Row_Links;
use JLTWPAFAQ\Inc\Classes\Upgrade_Plugin;
use JLTWPAFAQ\Inc\Classes\Feedback;

/**
 * Main Class
 *
 * @wp-awesome-faq
 * Jewel Theme <support@jeweltheme.com>
 * @version     4.2.0
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_Awesome_FAQ Class
 */
if ( ! class_exists( '\JLTWPAFAQ\JLT_Awesome_FAQ' ) ) {

	/**
	 * Class: JLT_Awesome_FAQ
	 */
	final class JLT_Awesome_FAQ {

		const VERSION            = JLTWPAFAQ_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltwpafaq_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltwpafaq_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltwpafaq_maybe_run_upgrades' ], -100 ); .
		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_plugins_loaded() {
			$this->jltwpafaq_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltwpafaq_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltwpafaq_activate() {
			$current_jltwpafaq_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltwpafaq_activation_time' ) === false ) {
				update_option( 'jltwpafaq_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltwpafaq_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltwpafaq_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltwpafaq_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_body_class( $classes ) {
			$classes .= ' wp-awesome-faq ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltwpafaq_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();



			// Include Files
			include JLTWPAFAQ_DIR . '/Inc/FAQ/faq-cpt.php';
			include JLTWPAFAQ_DIR . '/Inc/FAQ/fa-icons.php';
			include JLTWPAFAQ_DIR . '/Inc/FAQ/faq-assets.php';
			include JLTWPAFAQ_DIR . '/Inc/FAQ/faq-metabox.php';
			include JLTWPAFAQ_DIR . '/Inc/FAQ/faq-dependecies.php';
			include JLTWPAFAQ_DIR . '/Inc/FAQ/helper-functions.php';
			
			// include( JLTWPAFAQ_DIR . '/src/init.php');
			// require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
			
			// Admin Settings
			include JLTWPAFAQ_DIR . '/Inc/Admin/class.settings-api.php';
			include JLTWPAFAQ_DIR . '/Inc/Admin/colorful-faq-settings.php';
			
			//Shortcoes
			include JLTWPAFAQ_DIR . '/Inc/FAQ/faq-shortcodes.php';
			
			//Sorting
			include JLTWPAFAQ_DIR . '/Libs/FAQ/sorting.php';
			
			// Load shortcode generator files
			include JLTWPAFAQ_DIR . '/Libs/FAQ/tinymce.button.php';
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_init() {
			$this->jltwpafaq_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_load_textdomain() {
			$domain = 'wp-awesome-faq';
			$locale = apply_filters( 'jltwpafaq_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTWPAFAQ_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_Awesome_FAQ ) ) {
				self::$instance = new JLT_Awesome_FAQ();
				self::$instance->jltwpafaq_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_Awesome_FAQ Class .
	JLT_Awesome_FAQ::get_instance();
}