<?php
	/**
	 * In this class we are Changing Variation in Variable Product (User Page) Dropdown to Redio Button.
	 *
	 * @package Email Sender
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ES_Orderstatus' ) ) {

	/**
	 * Class Variations.
	 */
	class ES_Orderstatus {

		/**
		 *  Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_shipping_order_status' ), 20 );
			add_filter( 'wc_order_statuses', array( $this, 'shipping_order_status_editpage_dropdown' ), 20, 1 );
			add_filter( 'bulk_actions-edit-shop_order', array( $this, 'shipping_dropdown_bulk_actions_shop_order' ), 20, 1 );
		}

		/**
		 *  Registered Shipping Order Status.
		 */
		public function register_shipping_order_status() {
			register_post_status(
				'wc-shipping',
				array(
					'label'                     => _x( 'Shipping', 'Order status', 'woocommerce' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
				)
			);
		}


		/**
		 * Adding shipping status to order edit pages dropdown.
		 *
		 * @param array $order_statuses all order status.
		 */
		public function shipping_order_status_editpage_dropdown( $order_statuses ) {
			$order_statuses['wc-shipping'] = _x( 'Shipping', 'Order status', 'woocommerce' );
			return $order_statuses;
		}

		/**
		 * Adding Shipping status to admin order list bulk dropdown.
		 *
		 * @param array $actions action.
		 */
		public function shipping_dropdown_bulk_actions_shop_order( $actions ) {
			$actions['mark_shipping'] = __( 'Mark Shipping', 'woocommerce' );
			return $actions;
		}
	}
}
new ES_Orderstatus();

