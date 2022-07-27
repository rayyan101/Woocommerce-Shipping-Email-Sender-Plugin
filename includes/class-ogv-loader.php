<?php
	/**
	 * This class is Loader Class we are using for Enqueue Scrips Style and including other Classes and Files
	 *
	 * @package otp-getway-verification
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Ogv_Loader' ) ) {

	/**
	 * Class ogv_Loader
	 */
	class Ogv_Loader {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->includes();
			add_action( 'wp_enqueue_scripts', array( $this, 'ogv_enqueue_scripts_client' ) );
		}

		/**
		 * Function for Enqueue Scripts and Style on Client side
		 */
		public function ogv_enqueue_scripts_client() {
			wp_enqueue_script( 'ogv_client_js', plugin_dir_url( __DIR__ ) . '/assets/js/client.js', array( 'jquery' ), wp_rand() );
			wp_localize_script( 'ogv_client_js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_style( 'ogv_plugin_style', plugin_dir_url( __DIR__ ) . '/assets/css/clientstyle.css', array(), '1.0' );
		}

		/**
		 * Function for Including Files and Classes
		 */
		public function includes() {

			include_once 'class-ogv-getway.php'; 
			include_once 'class-ogv-otp.php'; 
	 
			
			
		}
	}
}
new Ogv_Loader();

