<?php
/**
 * Add OTP Verification Gateway to WC payment gateways.
 *
 * * @package otp-getway-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'woocommerce_payment_gateways', 'wc_otp_gateway_class_adding' );
function wc_otp_gateway_class_adding( $gateways ) {
	$gateways[] = 'ogv_getway';
	return $gateways;
}
add_action( 'plugins_loaded', 'wc_otp_gateway', 11 );

function wc_otp_gateway() {

    class ogv_getway extends WC_Payment_Gateway {

		public function __construct() {
			$this->id                 = 'otp'; 
			$this->method_title       = 'OTP Verify';
			$this->method_description = 'Description of OTP Verification'; 
			$this->has_fields = false;

			$this->init_form_fields();
			
			$this->title           = $this->get_option( 'title' );
			$this->description     = $this->get_option( 'description' );
			$this->enabled         = $this->get_option( 'enabled' );
			$this->shop_id = $this->get_option( 'shop_id' );  
			
			add_action('woocommerce_checkout_process', array( $this, 'verification_email_field_validation') );
			
		}
		
		public function init_form_fields() {
			$this->form_fields = apply_filters( 'woo_OTP_pay_fields', array(
				'enabled' => array(
					'title' => __( 'Enable/Disable', 'OTP-pay-woo'),
					'type' => 'checkbox',
					'label' => __( 'Enable or Disable OTP Payments', 'OTP-pay-woo'),
					'default' => 'no'
				),
				'title' => array(
					'title' => __( 'OTP Payments Gateway', 'OTP-pay-woo'),
					'type' => 'text',
					'default' => __( 'OTP Payments Gateway', 'OTP-pay-woo'),
					'desc_tip' => true,
					'description' => __( 'Add a new title for the OTP Payments Gateway that customers will see when they are in the checkout page.', 'OTP-pay-woo')
				),
				'description' => array(
					'title' => __( 'OTP Payments Gateway Description', 'OTP-pay-woo'),
					'type' => 'textarea',
					'default' => __( 'Please remit your payment to the shop to allow for the delivery to be made', 'OTP-pay-woo'),
					'desc_tip' => true,
					'description' => __( 'Add a new title for the OTP Payments Gateway that customers will see when they are in the checkout page.', 'OTP-pay-woo')
				),
				'instructions' => array(
					'title' => __( 'Instructions', 'OTP-pay-woo'),
					'type' => 'textarea',
					'default' => __( 'Default instructions', 'OTP-pay-woo'),
					'desc_tip' => true,
					'description' => __( 'Instructions that will be added to the thank you page and odrer email', 'OTP-pay-woo')
				),
			));
		}

		public function payment_fields(){
            if ( $description = $this->get_description() ) {
                echo wpautop( wptexturize( $description ) );
            }
            $option_keys = array_keys($this->options);
            woocommerce_form_field( 'otp_Verification_email', array(
                'type'          => 'email',
				'id'			=> 'email_field',
                'class'         => array('transaction_type form-row-wide'),
                'label'         => __('Enter Email for OTP Verification'),
            ),);
		}

		public function validate_fields(){
			global $woocommerce;
			
			if (! $_POST['otp_Verification_email'] ){
			wc_add_notice( __( 'Email for OTP verification is a required field.', 'otp-verification' ), 'error' );
			}
			else {
			if( ! filter_var($_POST['otp_Verification_email'], FILTER_VALIDATE_EMAIL) )
			wc_add_notice( __( 'Invalid email address for OTP Verification.', 'otp-verification' ), 'error' );
			}
		}
			


		public function process_payment( $order_id ) {
			update_post_meta( $order_id, 'Email_for_OTP', $_POST['otp_Verification_email'] );

			$otp_class_obj = new Ogv_otp();
			$otp_class_obj->sending_otp_to_email(); 

			$order = wc_get_order( $order_id );

			$order->update_status( 'on-hold',  __( 'Awaiting for OTP Verification,', 'otp-verification-gateway') );
			$order->reduce_order_stock();
			WC()->cart->empty_cart();
			
			$redirect_url = plugin_dir_url( __DIR__ ) . 'includes/testing.php';
   
                    return array(
                        'result'   => 'success',
                        'redirect'  => $this->get_return_url( $order )
                    );
		}
	} 
}



