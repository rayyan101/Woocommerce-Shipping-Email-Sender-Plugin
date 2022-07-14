<?php
	/**
	 * This class is Loader Class we are using for Enqueue Scrips Style and including other Classes and Files
	 *
	 * @package Email Sender
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ES_Loader' ) ) {

	/**
	 * Class WS_Loader. ()
	 */
	class ES_Loader {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->includes();
			add_action( 'wp_enqueue_scripts', array( $this, 'es_enqueue_scripts_client' ) );
		}

		/**
		 * Function for Enqueue Scripts and Style on Client side
		 */
		public function es_enqueue_scripts_client() {
			wp_enqueue_script( 'WS_client_js', plugin_dir_url( __DIR__ ) . '/assets/js/client.js', array( 'jquery' ), wp_rand() );
			wp_localize_script( 'WS_client_js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_style( 'WS_plugin_style', plugin_dir_url( __DIR__ ) . '/assets/css/clientstyle.css', array(), '1.0' );
		}


		/**
		 * Function for Including Files and Classes
		 */
		public function includes() {
			include_once 'class-ES-Orderstatus.php';
			include_once 'class-es-sendingemail.php';
		}
	}
}
new ES_Loader();

