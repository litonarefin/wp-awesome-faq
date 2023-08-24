<?php
/**
 * Plugin Name: Master Accordion
 * Plugin URI:  https://jeweltheme.com/
 * Description: Awesome WordPress FAQ Plugin
 * Version:     4.2.0
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: wp-awesome-faq
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package wp-awesome-faq
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'wp-awesome-faq' ) );
}

$jltwpafaq_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTWPAFAQ' ) ) {
	define( 'JLTWPAFAQ', $jltwpafaq_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTWPAFAQ_VER' ) ) {
	define( 'JLTWPAFAQ_VER', $jltwpafaq_plugin_data['Version'] );
}

if ( ! defined( 'JLTWPAFAQ_AUTHOR' ) ) {
	define( 'JLTWPAFAQ_AUTHOR', $jltwpafaq_plugin_data['Author'] );
}

if ( ! defined( 'JLTWPAFAQ_DESC' ) ) {
	define( 'JLTWPAFAQ_DESC', $jltwpafaq_plugin_data['Author'] );
}

if ( ! defined( 'JLTWPAFAQ_URI' ) ) {
	define( 'JLTWPAFAQ_URI', $jltwpafaq_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTWPAFAQ_DIR' ) ) {
	define( 'JLTWPAFAQ_DIR', __DIR__ );
}

if ( ! defined( 'JLTWPAFAQ_FILE' ) ) {
	define( 'JLTWPAFAQ_FILE', __FILE__ );
}

if ( ! defined( 'JLTWPAFAQ_SLUG' ) ) {
	define( 'JLTWPAFAQ_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTWPAFAQ_BASE' ) ) {
	define( 'JLTWPAFAQ_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTWPAFAQ_PATH' ) ) {
	define( 'JLTWPAFAQ_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTWPAFAQ_URL' ) ) {
	define( 'JLTWPAFAQ_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTWPAFAQ_INC' ) ) {
	define( 'JLTWPAFAQ_INC', JLTWPAFAQ_PATH . '/Inc/' );
}

if ( ! defined( 'JLTWPAFAQ_LIBS' ) ) {
	define( 'JLTWPAFAQ_LIBS', JLTWPAFAQ_PATH . 'Libs' );
}

if ( ! defined( 'JLTWPAFAQ_ASSETS' ) ) {
	define( 'JLTWPAFAQ_ASSETS', JLTWPAFAQ_URL . 'assets/' );
}

if ( ! defined( 'JLTWPAFAQ_IMAGES' ) ) {
	define( 'JLTWPAFAQ_IMAGES', JLTWPAFAQ_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTWPAFAQ\\JLT_Awesome_FAQ' ) ) {
	// Autoload Files.
	include_once JLTWPAFAQ_DIR . '/vendor/autoload.php';
	// Instantiate JLT_Awesome_FAQ Class.
	include_once JLTWPAFAQ_DIR . '/class-wp-awesome-faq.php';
}


