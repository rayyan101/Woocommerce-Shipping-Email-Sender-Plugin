<?php
/**
 * Plugin Name:       Email Sender
 * Description:       Sending Emails To Customers
 * Version:           1.1.1.0
 * Author:            Codup
 * Author URI:        https://codup.co
 * License:           GPL v2 or later

 * @package           Email Sender
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'ES_PLUGIN_DIR' ) ) {
	define( 'ES_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'ES_PLUGIN_DIR_URL' ) ) {
	define( 'ES_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'ES_ABSPATH' ) ) {
	define( 'ES_ABSPATH', dirname( __FILE__ ) );
}

	require_once ES_ABSPATH . '/includes/class-es-loader.php';

