<?php

namespace TWPAYMENT;

use TWPAYMENT\Blocks\Payments\ECPayCredit;
use Automattic\WooCommerce\Blocks\Package;
use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;

defined( 'ABSPATH' ) || exit;


class Init {
	public static function register() {
		$class = new self();
		//add_action( 'woocommerce_blocks_payment_method_type_registration', array( $class, 'register_payment_method_integrations' ) );
	}

	public function __construct() {

	}

	/**
	 * Register payment method integrations bundled with blocks.
	 *
	 * @param PaymentMethodRegistry $payment_method_registry Payment method registry instance.
	 */
	public function register_payment_method_integrations( PaymentMethodRegistry $payment_method_registry ) {
		if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			$payment_method_registry->register(
				Package::container()->get( ECPayCredit::class )
			);
		}
	}
}

Init::register();
