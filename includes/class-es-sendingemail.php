<?php
	/**
	 * In this class we are Changing Variation in Variable Product (User Page) Dropdown to Redio Button.
	 *
	 * @package Email Sender
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ES_Sendingemail' ) ) {

	/**
	 * Class Sendingemail.
	 */
	class ES_Sendingemail {

		/**
		 *  Constructor.
		 */
		public function __construct() {
			add_action( 'woocommerce_order_status_changed', array( $this, 'sending_email_on_shipping' ), 10, 4 );
			add_action( 'woocommerce_email_order_details', array( $this, 'email_customizer' ) );

		}

		/**
		 * Sending email to Client and admin on Shipment order status.
		 *
		 * @param int    $order_id ID of Order.
		 * @param string $old_status previous status name.
		 * @param string $new_status current status name.
		 * @param array  $order whole order details.
		 */
		public function sending_email_on_shipping( $order_id, $old_status, $new_status, $order ) {
			$mailer = WC()->mailer()->get_emails();
			if ( 'shipping' === $new_status ) {

				$heading = sprintf( 'Your order #%s is now on Shipment', $order->get_id() );
				$subject = 'Order\'s status changed';
				$mailer['WC_Email_Customer_Completed_Order']->heading             = $heading;
				$mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = $heading;
				$mailer['WC_Email_Customer_Completed_Order']->subject             = $subject;
				$mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = $subject;
				$mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id );

				// Sending custom email to admin.
				$admin_mail = get_option( 'admin_email' );
				$subject    = 'Order\'s status changed';
				$body       = sprintf( 'Your order #%s has proceeded to Shipment', $order->get_id() );
				wp_mail( $admin_mail, $subject, $body, '' );
			}
		}

		/**
		 * Client's shipment email customizer.
		 *
		 * @param array $order All orders.
		 */
		public function email_customizer( $order ) {
			$message  = '<h3>';
			$message .= sprintf( 'Order #%s is now proceed to Shipment', $order->get_id() );

			$message .= '</h3>';
			echo $message;
		}
	}
}
new ES_Sendingemail();

