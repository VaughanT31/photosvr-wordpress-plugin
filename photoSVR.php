<?php
/**
 * PhotoSVR | 3D SVR WordPress Plugin
 *
 * @package           PhotoSVR | 3D SVR WordPress Plugin
 * @author            Vaughan Thomas
 * @copyright         2023 FreelanceDirect
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       PhotoSVR | 3D SVR WordPress Plugin
 * Plugin URI:        https://www.freelancedirect.co.za/photosvr-wordpress-plugin/
 * Description:       Displays 3D SVR's from https://photosvr.net/ | WooCommerce, Elementor, Visual Composer, Elementor for WooCommerce
 * Version:           0.4.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Vaughan Thomas
 * Author URI:        https://freelancedirect.co.za
 * Text Domain:       photosvr
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://freelancedirect.co.za
 */

if(!defined( 'ABSPATH' ) ) {
	exit;
}

function photosvr_enqueue_scripts() {
    wp_enqueue_script('photosvr_script','https://photosvr.online/js/obfuscated.5.3.js', array(), '',false);
    wp_enqueue_style('photosvr_styles',plugin_dir_url(__FILE__).'photosvr.css');
}
add_action('wp_enqueue_scripts','photosvr_enqueue_scripts');
/**
* Register Elementor Widget
**/

function register_photosvr_widget($widgets_manager)
{
	require_once(__DIR__.'/widgets/photosvr-elementor.php');

	$widgets_manager->register(new \Elementor_PhotoSVR_Widget() );
}
add_action('elementor/widgets/register','register_photosvr_widget');

/**
 * Shortcode Script
**/

require_once(__DIR__.'/shortcode/photosvr-shortcode.php');

/**
 * WooCommerce Change Large Image
**/

if(!function_exists('is_woocommerce_activated') ) {
	require_once('woocommerce/photosvr-image.php');
	require_once('woocommerce/photosvr-change.php');
} else {

}