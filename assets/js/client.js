/**
 * This JS File is Trigger Dropdown Value automaticly after selecting redion button swatches
 *
 * @package Woocommerce Swatches
 * */

jQuery( document ).ready(
	function($)
	{
		$( '.variations select' ).hide();
	}
);
jQuery( document ).on(
	'change',
	'.variation-radios input',
	function() {
		jQuery( '.variation-radios input:checked' ).each(
			function(index, element){
				let rdo = jQuery( element );
				jQuery( 'select[name="' + rdo.attr( 'name' ) + '"]' ).val( rdo.attr( 'value' ) ).trigger( 'change' );
			}
		);
	}
);
