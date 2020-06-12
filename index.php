<?php
/**
 * Plugin Name: AAA Master Accordion ( Former WP Awesome FAQ Plugin )
 * Plugin URI: https://jeweltheme.com/shop/wordpress-faq-plugin/
 * Description: Best Accordion Plugin. Create your FAQ (Frequently Asked Question) items on a Colorful way. A nice creation by <a href="http://www.jeweltheme.com/">Jewel Theme</a>.
 * Version: 4.1.4
 * Author: Jewel Theme
 * Author URI: https://jeweltheme.com
 * Text Domain: maf
 */

$plugin_data = get_file_data(__FILE__, 
	array(
		'Version' 		=> 'Version',
		'Plugin Name' 	=> 'Plugin Name'
	), 
	false);
$plugin_name = $plugin_data['Plugin Name'];
$plugin_version = $plugin_data['Version'];

define('MAF', $plugin_name);
define('MAF_VERSION', $plugin_version);
define('MAF_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ));
define('MAF_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ));
define('MAF_TD', load_plugin_textdomain('maf'));
define('MAF_ADDON', plugin_dir_path( __FILE__ ) . 'inc/elementor/addon/' );
define('MAF_PRO_URL', 'https://jeweltheme.com/product/wordpress-faq-plugin/');


// Include Files
include( MAF_DIR . '/inc/faq-cpt.php');
include( MAF_DIR . '/inc/fa-icons.php');
include( MAF_DIR . '/inc/faq-assets.php');
include( MAF_DIR . '/inc/faq-metabox.php');
include( MAF_DIR . '/inc/faq-dependecies.php');
include( MAF_DIR . '/inc/helper-functions.php');


// Admin Settings
include( MAF_DIR . '/admin/class.settings-api.php');
include( MAF_DIR . '/admin/colorful-faq-settings.php');


//Shortcoes
include( MAF_DIR . '/inc/faq-shortcodes.php');


//Sorting
include( MAF_DIR . '/lib/sorting.php');

// Load shortcode generator files
include( MAF_DIR . '/lib/tinymce.button.php');

add_filter( 'the_content', 'do_shortcode' );