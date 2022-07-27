<?php
/**
 * Send OTP for verification on order Checkout.
 *
 * @package otp-verification-gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ogv_otp' ) ) {
	/**
	 * Class OVG_Mail_OTP_Code
	 */
	class Ogv_otp {

		/**
		 * Sending otp email to customer for 
		 */


        public function sending_otp_to_email(){  
		
			$to = isset( $_POST['otp_Verification_email'] ) ? $_POST['otp_Verification_email'] : '';
			$subject = 'OTP for Verification';
			$rand = rand ( 100000 , 999999  );
			$body = 'Your order\'s OTP for verification is: ' .  $rand;
	
			wp_mail( $to, $subject, $body );
		 
		
        } 
    }

}