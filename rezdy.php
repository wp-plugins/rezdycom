<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Rezdy
 * @author    Rezdy <info@rezdy.com>
 * @license   GPL-2.0+
 * @link      http://rezdy.com
 * @copyright 2014 Rezdy
 *
 * @wordpress-plugin
 * Plugin Name:       Rezdy
 * Plugin URI:        http://rezdy.com
 * Description:       Reservation plugin using the rezdy.com service
 * Version:           1.1
 * Author:            rezdy.com
 * Author URI:        http://rezdy.com
 * Text Domain:       rezdy-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-rezdy.php' );
add_action( 'plugins_loaded', array( 'Rezdy', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rezdy-admin.php' );
	add_action( 'plugins_loaded', array( 'Rezdy_Admin', 'get_instance' ) );

}
